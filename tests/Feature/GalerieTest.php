<?php

namespace Tests\Feature;

use App\Models\Photo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GalerieTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * Sans dimensions declarees, la grille en colonnes se reorganise a chaque
     * image qui arrive. Les dimensions sont relevees a l'enregistrement.
     */
    public function test_chaque_photo_declare_ses_dimensions(): void
    {
        $html = $this->get('/galerie')->assertOk()->getContent();

        // On se limite a la grille : le hero et le ruban defilant portent aussi
        // des images de ce dossier, sans les memes contraintes.
        $grille = \Illuminate\Support\Str::between($html, '<div class="masonry"', '</div>');

        preg_match_all('/<img[^>]*>/', $grille, $m);
        $this->assertNotEmpty($m[0], 'La galerie doit afficher des images.');

        foreach ($m[0] as $img) {
            $this->assertMatchesRegularExpression('/width="\d+"/', $img);
            $this->assertMatchesRegularExpression('/height="\d+"/', $img);
        }
    }

    public function test_les_dimensions_sont_relevees_a_l_enregistrement(): void
    {
        $photo = Photo::publiees()->firstOrFail();

        $this->assertNotNull($photo->largeur);
        $this->assertNotNull($photo->hauteur);
        $this->assertGreaterThan(0, $photo->largeur);
    }

    /**
     * Le filtre agit cote client, mais les liens doivent continuer de marcher
     * sans JavaScript : la page rendue masque alors les autres categories.
     */
    public function test_le_filtre_fonctionne_aussi_sans_javascript(): void
    {
        $html = $this->get('/galerie?categorie=chatons')->assertOk()->getContent();

        preg_match_all('/<figure[^>]*data-categorie="([a-z]+)"([^>]*)>/', $html, $m, PREG_SET_ORDER);
        $this->assertNotEmpty($m);

        foreach ($m as [, $categorie, $attributs]) {
            $masquee = str_contains($attributs, 'hidden');
            $this->assertSame(
                $categorie !== 'chatons',
                $masquee,
                "La figure « {$categorie} » devrait ".($categorie !== 'chatons' ? 'être masquée' : 'rester visible')."."
            );
        }
    }

    /**
     * Seize photos s'appelaient « G1 » a « G16 » sur la galerie — et c'etait aussi
     * leur texte alternatif. La commande de synchronisation deduit une legende du
     * nom de fichier quand elle n'en connait pas : un pis-aller qui ne doit pas
     * finir en ligne.
     */
    public function test_aucune_legende_ne_reprend_le_nom_de_fichier(): void
    {
        $fautives = [];

        foreach (Photo::publiees()->get() as $photo) {
            $nom = pathinfo($photo->chemin, PATHINFO_FILENAME);
            $deduite = ucfirst(str_replace(['-', '_'], ' ', $nom));

            // « Wendy » est le nom de la chatte : la coincidence est legitime.
            if (strcasecmp(trim($photo->legende), $deduite) === 0 && mb_strlen($nom) <= 4 && preg_match('/\d/', $nom)) {
                $fautives[] = $photo->chemin.' → '.$photo->legende;
            }
        }

        $this->assertSame([], $fautives, 'Légendes déduites du nom de fichier.');
    }

    /**
     * Le texte alternatif decrit ce qu'on voit ; la legende est editoriale. Les
     * confondre etait le reproche fait au site actuel du client.
     */
    public function test_chaque_photo_a_un_texte_alternatif_descriptif(): void
    {
        foreach (Photo::publiees()->get() as $photo) {
            $this->assertNotEmpty(trim($photo->alt), "Texte alternatif vide : {$photo->chemin}");
            $this->assertGreaterThanOrEqual(
                12,
                mb_strlen(trim($photo->alt)),
                "Texte alternatif trop court pour décrire quoi que ce soit : {$photo->chemin} → « {$photo->alt} »"
            );
        }
    }

    public function test_toutes_les_photos_sont_rendues_quel_que_soit_le_filtre(): void
    {
        $total = Photo::publiees()->count();

        foreach (['', '?categorie=chatons', '?categorie=adultes'] as $requete) {
            $html = $this->get('/galerie'.$requete)->assertOk()->getContent();
            $this->assertSame($total, substr_count($html, '<figure'), "Filtre « {$requete} »");
        }
    }
}
