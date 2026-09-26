<?php

namespace App\Console\Commands;

use App\Models\Cat;
use App\Models\Kitten;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

/**
 * Copie statique du site public, pour GitHub Pages.
 *
 * GitHub Pages ne sert que des fichiers : ni PHP, ni base de donnees. Cette
 * copie montre donc les pages publiques telles qu'elles sont, mais le
 * back-office n'y existe pas et les trois formulaires ne peuvent rien
 * enregistrer — ils sont desactives plutot que laisses echouer en silence.
 *
 * Le filtre de la galerie, la visionneuse, le menu et la carte continuent de
 * fonctionner : ils sont entierement cote navigateur.
 */
class ExporterSite extends Command
{
    protected $signature = 'site:exporter
        {--base= : Adresse publique finale, ex. https://rizleneberrag.github.io/bengals-parc}
        {--source=http://localhost:8081 : Adresse locale a parcourir}
        {--vers=docs : Dossier de destination, relatif a la racine du projet}';

    protected $description = 'Exporte une copie statique du site public';

    /** Dossiers de public/ a recopier tels quels. */
    private const ASSETS = ['build', 'images', 'fonts'];

    public function handle(): int
    {
        $base = rtrim((string) $this->option('base'), '/');
        $source = rtrim((string) $this->option('source'), '/');
        $vers = base_path((string) $this->option('vers'));

        if ($base === '') {
            $this->error('Indiquez --base, l’adresse publique finale : les liens et les images en dépendent.');

            return self::FAILURE;
        }

        if (! $this->siteRepond($source)) {
            $this->error("Le site ne répond pas sur {$source}. Apache et MySQL sont-ils démarrés ?");

            return self::FAILURE;
        }

        File::deleteDirectory($vers);
        File::ensureDirectoryExists($vers);

        $pages = $this->pages();
        $this->info(count($pages).' page(s) à exporter.');

        $barre = $this->output->createProgressBar(count($pages));
        $barre->start();

        foreach ($pages as $chemin => $destination) {
            // ignore_errors : la page 404 repond justement par un code 404, et
            // sans cela file_get_contents renonce au lieu de rendre le corps.
            $html = @file_get_contents($source.$chemin, false, stream_context_create([
                'http' => ['timeout' => 20, 'ignore_errors' => true],
            ]));

            if ($html === false) {
                $barre->clear();
                $this->warn("  {$chemin} : pas de réponse, ignorée.");
                $barre->display();
                continue;
            }

            $fichier = $vers.'/'.$destination;
            File::ensureDirectoryExists(dirname($fichier));
            File::put($fichier, $this->preparer($html, $source, $base));

            $barre->advance();
        }

        $barre->finish();
        $this->newLine(2);

        foreach (self::ASSETS as $dossier) {
            File::copyDirectory(public_path($dossier), $vers.'/'.$dossier);
            $this->line("  {$dossier}/ recopié");
        }

        // Sans ce fichier, GitHub Pages passe le site dans Jekyll, qui ignore
        // tout dossier commençant par un souligné et peut casser des chemins.
        File::put($vers.'/.nojekyll', '');
        $this->line('  .nojekyll écrit');

        $this->newLine();
        $this->info('Copie prête dans '.$this->option('vers').'/');
        $this->line('  Adresse de publication : '.$base);

        return self::SUCCESS;
    }

    private function siteRepond(string $source): bool
    {
        $contexte = stream_context_create(['http' => ['timeout' => 10, 'ignore_errors' => true]]);

        return @file_get_contents($source.'/robots.txt', false, $contexte) !== false;
    }

    /**
     * Les pages à parcourir, et où les écrire.
     *
     * GitHub Pages sert /chatons/ depuis /chatons/index.html : chaque page a
     * donc son propre dossier, ce qui garde les adresses identiques à celles du
     * site complet.
     *
     * @return array<string,string>
     */
    private function pages(): array
    {
        $pages = [
            '/'                 => 'index.html',
            '/chatons'          => 'chatons/index.html',
            '/elevage'          => 'elevage/index.html',
            '/le-bengal'        => 'le-bengal/index.html',
            '/galerie'          => 'galerie/index.html',
            '/adopter'          => 'adopter/index.html',
            '/questions'        => 'questions/index.html',
            '/contact'          => 'contact/index.html',
            '/mentions-legales' => 'mentions-legales/index.html',
            '/sitemap.xml'      => 'sitemap.xml',
            '/robots.txt'       => 'robots.txt',
            // GitHub Pages sert ce fichier pour toute adresse inconnue.
            '/adresse-inconnue' => '404.html',
        ];

        foreach (Cat::publies()->get() as $chat) {
            $pages['/elevage/'.$chat->slug] = 'elevage/'.$chat->slug.'/index.html';
        }

        foreach (Kitten::publies()->get() as $chaton) {
            $pages['/chatons/'.$chaton->slug] = 'chatons/'.$chaton->slug.'/index.html';
        }

        return $pages;
    }

    /**
     * Réécrit les adresses et neutralise ce qui ne peut pas fonctionner.
     */
    private function preparer(string $html, string $source, string $base): string
    {
        $html = str_replace($source, $base, $html);

        // Les trois formulaires enregistrent en base : sans serveur, ils ne
        // peuvent rien faire. Mieux vaut les désactiver visiblement que les
        // laisser échouer sans explication.
        $html = preg_replace_callback(
            '/<form\b([^>]*)method="POST"([^>]*)>/i',
            fn ($m) => '<form'.$m[1].'method="POST"'.$m[2].' onsubmit="return false" data-apercu="1">',
            $html
        );

        $note = '<p class="flash err" style="margin-top:18px">'
            .'Cet aperçu est une copie statique : le formulaire n’enregistre rien. '
            .'Appelez-nous ou écrivez-nous, les coordonnées sont sur la page Contact.'
            .'</p>';

        $html = preg_replace('/<button([^>]*)type="submit"([^>]*)>/i', '<button$1type="submit"$2 disabled>', $html);
        $html = str_replace('</form>', $note.'</form>', $html);

        return $html;
    }
}
