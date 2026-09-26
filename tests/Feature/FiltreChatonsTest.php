<?php

namespace Tests\Feature;

use App\Models\Cat;
use App\Models\Kitten;
use App\Models\Litter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Le filtre par statut de la page « Nos chatons ».
 *
 * Il etait entierement cote serveur : chaque clic rechargeait la page avec
 * ?statut=, et le controleur retirait les autres chatons de la collection.
 * Cela marche sur le site complet, mais la copie statique publiee n'a pas de
 * serveur pour lire la requete — cliquer « Disponibles » y renvoyait les cinq
 * chatons.
 *
 * Il fonctionne maintenant comme celui de la galerie : le serveur rend TOUTE la
 * portee et masque ce qui ne correspond pas, le script reprend la main. Ces
 * tests tiennent les deux bouts.
 *
 * La portee est montee ici plutot que prise du jeu de donnees : sans numero
 * ICAD ni numero de portee LOOF, aucun chaton n'est publiable — voir
 * KittenPublicationTest — et la grille serait vide.
 */
class FiltreChatonsTest extends TestCase
{
    use RefreshDatabase;

    /** @var array<string,int> statut => nombre de chatons */
    private const PORTEE = ['disponible' => 2, 'reserve' => 2, 'adopte' => 1];

    protected function setUp(): void
    {
        parent::setUp();
        $this->portee(self::PORTEE);
    }

    /** @param array<string,int> $repartition */
    private function portee(array $repartition): Litter
    {
        $portee = Litter::create([
            'code'               => 'Portée X',
            'slug'               => 'portee-x-2026',
            'pere_id'            => Cat::create(['nom' => 'Uzumaki', 'slug' => 'uzumaki', 'sexe' => 'male', 'role' => 'etalon'])->id,
            'mere_id'            => Cat::create(['nom' => 'Wendy', 'slug' => 'wendy', 'sexe' => 'femelle', 'role' => 'reproductrice'])->id,
            'date_naissance'     => now()->subWeeks(14)->toDateString(),
            'loof_portee_numero' => 'LOOF-2026-0001',
            'est_publiee'        => true,
        ]);

        $n = 0;

        foreach ($repartition as $statut => $combien) {
            for ($i = 0; $i < $combien; $i++) {
                $nom = 'Chaton'.(++$n);

                Kitten::create([
                    'litter_id'   => $portee->id,
                    'nom'         => $nom,
                    'slug'        => \Illuminate\Support\Str::slug($nom),
                    'sexe'        => $n % 2 ? 'male' : 'femelle',
                    'statut'      => $statut,
                    'icad_numero' => '25026900000000'.$n,
                    'est_publie'  => true,
                ]);
            }
        }

        return $portee;
    }

    /**
     * Les fiches de la grille, avec leur statut et le fait qu'elles soient
     * masquees ou non.
     *
     * @return list<array{statut:string,masquee:bool}>
     */
    private function fiches(string $requete = ''): array
    {
        $html = $this->get('/chatons'.$requete)->assertOk()->getContent();

        preg_match_all('/<a\b([^>]*\bdata-statut="([a-z]+)"[^>]*)>/s', $html, $m, PREG_SET_ORDER);

        $fiches = [];

        foreach ($m as [, $attributs, $statut]) {
            // Les liens du filtre portent aussi data-statut : seules les fiches
            // ont la classe.
            if (! str_contains($attributs, 'class="fiche')) {
                continue;
            }

            $fiches[] = ['statut' => $statut, 'masquee' => str_contains($attributs, 'hidden')];
        }

        return $fiches;
    }

    /** Le paragraphe d'absence est-il masque dans la page rendue ? */
    private function messageMasque(string $requete = ''): bool
    {
        $html = $this->get('/chatons'.$requete)->assertOk()->getContent();

        $this->assertMatchesRegularExpression('/<p\b[^>]*id="chatons-vide"/', $html);
        preg_match('/<p\b([^>]*id="chatons-vide"[^>]*)>/', $html, $m);

        return str_contains($m[1], 'hidden');
    }

    /**
     * Sans cela le filtre ne peut pas revenir en arriere : une fiche retiree du
     * document ne revient qu'en rechargeant, ce que la copie statique ne sait
     * pas faire.
     */
    public function test_toute_la_portee_est_rendue_quel_que_soit_le_filtre(): void
    {
        $attendu = array_sum(self::PORTEE);

        $this->assertCount($attendu, $this->fiches(), 'Sans filtre.');

        foreach (array_keys(self::PORTEE) as $statut) {
            $this->assertCount($attendu, $this->fiches('?statut='.$statut), "Filtre « {$statut} ».");
        }
    }

    /**
     * Le script lit data-statut pour masquer sans recharger. Sans cet attribut,
     * le filtre ne fonctionne plus du tout sur la copie publiee.
     */
    public function test_chaque_fiche_porte_son_statut(): void
    {
        $vus = [];

        foreach ($this->fiches() as $fiche) {
            $this->assertNotEmpty($fiche['statut']);
            $vus[$fiche['statut']] = ($vus[$fiche['statut']] ?? 0) + 1;
        }

        ksort($vus);
        $attendu = self::PORTEE;
        ksort($attendu);

        $this->assertSame($attendu, $vus);
    }

    /** Les liens doivent continuer de marcher sans JavaScript. */
    public function test_le_filtre_fonctionne_aussi_sans_javascript(): void
    {
        foreach (array_keys(self::PORTEE) as $statut) {
            foreach ($this->fiches('?statut='.$statut) as $fiche) {
                $this->assertSame(
                    $fiche['statut'] !== $statut,
                    $fiche['masquee'],
                    "Filtre « {$statut} » : une fiche « {$fiche['statut']} » est mal masquée."
                );
            }
        }
    }

    public function test_sans_filtre_aucune_fiche_n_est_masquee(): void
    {
        foreach ($this->fiches() as $fiche) {
            $this->assertFalse($fiche['masquee'], "Une fiche « {$fiche['statut']} » est masquée sans filtre.");
        }
    }

    /**
     * Le message depend des fiches VISIBLES, pas de la portee : filtrer sur un
     * statut sans chaton ne vide pas la collection, il masque tout.
     */
    public function test_le_message_d_absence_suit_les_fiches_visibles(): void
    {
        $this->assertTrue($this->messageMasque(), 'Sans filtre, le message ne doit pas apparaître.');
        $this->assertTrue($this->messageMasque('?statut=disponible'), 'Deux chatons sont disponibles.');

        Kitten::publies()->update(['statut' => 'disponible']);

        $this->assertFalse(
            $this->messageMasque('?statut=adopte'),
            "Plus aucun chaton adopté : le message doit apparaître."
        );
    }

    /** Le compteur de chaque onglet compte la portee entiere, pas le filtre. */
    public function test_les_compteurs_ne_dependent_pas_du_filtre(): void
    {
        $total = array_sum(self::PORTEE);

        foreach (['', '?statut=disponible', '?statut=adopte'] as $requete) {
            $this->get('/chatons'.$requete)
                ->assertOk()
                ->assertSee("Tous ({$total})")
                ->assertSee('Disponibles ('.self::PORTEE['disponible'].')');
        }
    }
}
