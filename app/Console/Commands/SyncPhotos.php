<?php

namespace App\Console\Commands;

use App\Models\Litter;
use App\Models\Photo;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

/**
 * Enregistre en base les images presentes dans public/images/cats.
 * Passerelle en attendant l'upload depuis le back-office : on depose les
 * fichiers, on lance la commande, la galerie se remplit.
 */
class SyncPhotos extends Command
{
    protected $signature = 'photos:sync {--legendes : Rafraîchir aussi les légendes connues des photos déjà en base}';

    protected $description = 'Enregistre les images de public/images/cats dans la galerie';

    /**
     * Legendes connues : [legende affichee, categorie, texte alternatif].
     *
     * La legende est editoriale et courte — elle s'affiche en capitales sur la
     * photo. Le texte alternatif decrit ce qu'on voit, pour un lecteur d'ecran
     * ou quand l'image ne charge pas : ce sont deux textes differents, et les
     * confondre etait justement le reproche fait au site actuel du client.
     *
     * Sans entree ici, le nom de fichier sert de legende — d'ou les « G1 » a
     * « G16 » qui s'affichaient sur la galerie.
     */
    public const LEGENDES = [
        /*
         * Les photos de l'elevage, reprises du site Wix et recadrees au format
         * des arches. Chaque entree : [legende editoriale, categorie, texte
         * alternatif]. Le texte alternatif decrit ce qu'on voit, la legende
         * raconte — ce ne sont pas les memes mots.
         */

        // ── les reproducteurs ──
        'hero-ultime' => ["Ultime, sur les passerelles de l'enclos", 'adultes', 'Ultime, Bengal black silver tabby de la chatterie, debout sur une passerelle en bois'],
        'unyk-1'      => ['Unyk', 'adultes', "Unyk de FashionBengal, Bengal black charcoal silver tabby, debout face à l'objectif"],
        'unyk-2'      => ["Unyk dans l'enclos", 'adultes', 'Unyk, Bengal black charcoal silver tabby, debout sur une poutre en bois'],
        'unyk-3'      => ['Unyk à la grimpe', 'adultes', 'Unyk, Bengal black charcoal silver tabby, dressé contre un tronc'],
        'unyk-4'      => ['Unyk au repos', 'adultes', 'Unyk, Bengal black charcoal silver tabby, allongé sur une planche en bois'],
        'saphyr-1'    => ['Saphyr, portrait de studio', 'adultes', 'Saphyr Ô Coeur Blanc, Bengal brown tabby rosetted, assise sur fond noir'],
        'saphyr-2'    => ['Saphyr', 'adultes', 'Saphyr Ô Coeur Blanc, Bengal brown tabby rosetted, en marche sur fond noir'],
        'saphyr-3'    => ['Saphyr au jeu', 'adultes', 'Saphyr Ô Coeur Blanc, Bengal brown tabby rosetted, couchée près d’un plumeau'],
        'saphyr-4'    => ["Saphyr à l'automne", 'adultes', 'Saphyr Ô Coeur Blanc, Bengal brown tabby rosetted, allongée parmi des feuilles et des pommes de pin'],
        'saphyr-5'    => ['Saphyr à la maison', 'adultes', 'Saphyr Ô Coeur Blanc, Bengal brown tabby rosetted, assise sur un tabouret'],
        'shiva-1'     => ['Shiva', 'adultes', 'Shiva Ô Coeur Blanc, Bengal black silver tabby, assise sur fond noir'],
        'shiva-2'     => ['Shiva, portrait de studio', 'adultes', 'Shiva Ô Coeur Blanc, Bengal black silver tabby, debout de profil sur fond noir'],
        'shiva-3'     => ['Shiva au repos', 'adultes', 'Shiva Ô Coeur Blanc, Bengal black silver tabby, couchée sur fond noir'],
        'shiva-4'     => ['Shiva allongée', 'adultes', 'Shiva Ô Coeur Blanc, Bengal black silver tabby, allongée de face sur fond noir'],
        'shiva-5'     => ['Shiva au studio', 'adultes', 'Shiva Ô Coeur Blanc, Bengal black silver tabby, une patte levée sur fond noir'],
        'ukaina-1'    => ['Ukaïna, portrait', 'adultes', 'Ukaïna de FashionBengal, Bengal seal charcoal silver tabby mink, debout sur fond noir'],
        'ukaina-2'    => ['Ukaïna à la patte levée', 'adultes', 'Ukaïna de FashionBengal, Bengal mink charcoal, assise la patte levée sur fond noir'],
        'ukaina-3'    => ['Ukaïna de profil', 'adultes', 'Ukaïna de FashionBengal, Bengal mink charcoal, assise de profil sur fond noir'],
        'ukaina-4'    => ['Ukaïna', 'adultes', 'Ukaïna de FashionBengal, Bengal mink charcoal, couchée sur fond noir'],
        'ukaina-5'    => ['Ukaïna au studio', 'adultes', 'Ukaïna de FashionBengal, Bengal mink charcoal, allongée de face sur fond noir'],
        'ultime-1'    => ['Ultime', 'adultes', 'Ultime Ô Coeur Blanc, Bengal black silver tabby, sur une passerelle de l’enclos'],
        'ultime-2'    => ['Ultime en promenade', 'adultes', 'Ultime Ô Coeur Blanc, Bengal black silver tabby, marchant sur une plateforme en bois'],
        'ultime-3'    => ['Ultime en surveillance', 'maison', 'Ultime Ô Coeur Blanc, Bengal black silver tabby, couchée sur une planche, le regard vers l’objectif'],
        'ultime-4'    => ['Ultime, le nez en l’air', 'adultes', 'Ultime Ô Coeur Blanc, Bengal black silver tabby, la tête levée vers le soleil'],
        'jag-1'       => ['Jag', 'adultes', 'Jag Jocelot des Bengalexception, Bengal brown tabby rosetted, couché sur un plaid rose'],
        'jag-2'       => ['Jag au jardin', 'maison', 'Jag Jocelot des Bengalexception, Bengal brown tabby rosetted, allongé dans l’herbe en longe'],
        'salambo-1'   => ['Salambo', 'adultes', 'Ambersands Salambo, Bengal black silver tabby, debout de profil sur fond sombre'],
        'salambo-2'   => ["Salambo à l'arbre à chat", 'maison', 'Ambersands Salambo, Bengal black silver tabby, installé sur un arbre à chat'],
        'olympe-1'    => ['Olympe', 'maison', 'Olympe de Laf, Bengal snow de la maison, couchée sur un lit'],
        'robe'        => ['Lire une robe de Bengal', 'adultes', 'Bengal brown tabby rosetted de profil, rosettes, ligne dorsale et masque bien visibles'],

        // ── les chatons ──
        'chaton-1'      => ["B'Ciel", 'chatons', 'Chaton Bengal black silver dressé contre une statue de chat'],
        'chaton-2'      => ["B'Nuage", 'chatons', 'Chaton Bengal black silver debout sur une étagère d’arbre à chat'],
        'chaton-3'      => ["B'Ange", 'chatons', 'Chaton Bengal brown tabby jouant avec un plumeau coloré'],
        'portee-1'      => ['Une portée au complet', 'chatons', 'Quatre chatons Bengal alignés sur un arbre à chat'],
        'portee-2'      => ['La fratrie sur le plaid', 'chatons', 'Quatre chatons Bengal serrés les uns contre les autres sur un plaid'],
        'portee-3'      => ['Deux chatons au jeu', 'chatons', 'Deux chatons Bengal jouant sur un tapis de jeu'],
        'portee-4'      => ['Le jour de la naissance', 'chatons', 'Chatons Bengal nouveau-nés tenus dans une main'],
        'portee-2025-1' => ['Les premiers jours', 'chatons', 'Chatons Bengal nouveau-nés de la portée de mars 2025, mâle et femelle black silver'],
        'portee-2025-2' => ['Deux jours', 'chatons', 'Chatonne Bengal black silver nouveau-née, endormie sur un plaid'],
        'portee-2025-3' => ['Le mâle brown', 'chatons', 'Chaton Bengal brown nouveau-né de la portée de mars 2025'],
        'portee-2025-4' => ['Chatons de mars 2025', 'chatons', 'Chatons Bengal de la portée Shiva et Salambo, assis parmi des peluches'],
        'portee-2025-5' => ['Armonie, femelle mink', 'chatons', 'Chatonne Bengal mink de la portée de mars 2025, assise près de peluches'],
        'portee-2025-6' => ['Les quatre de mars', 'chatons', 'Quatre chatons Bengal de la portée de mars 2025 en montage photo'],

        // ── ceux qui sont partis, devenus grands ──
        'ancien-tiago'     => ['Tiago, devenu grand', 'chatons', 'Tiago, Bengal né à la chatterie, adulte, grimpant à un arbre'],
        'ancien-usimba'    => ["U'Simba", 'chatons', "U'Simba, chaton Bengal né à la chatterie, jouant avec une peluche"],
        'ancien-ulka'      => ['Ulka', 'chatons', 'Ulka, chatonne Bengal née à la chatterie, sur un plaid rose'],
        'ancien-ulia'      => ['Ulia', 'chatons', 'Ulia, chatonne Bengal née à la chatterie, jouant sur un canapé rose'],
        'ancien-tennessee' => ['Tennessee', 'chatons', 'Tennessee, Bengal né à la chatterie, adulte, en montage photo'],

        // ── les montages de l'eleveuse ──
        'montage-unyk'   => ['Unyk, trois regards', 'adultes', 'Montage de trois photos d’Unyk, Bengal black charcoal silver'],
        'montage-saphyr' => ['Saphyr, trois regards', 'adultes', 'Montage de trois photos de Saphyr, Bengal brown tabby'],
        'montage-ultime' => ['Ultime, trois regards', 'adultes', 'Montage de trois photos d’Ultime, Bengal black silver'],
        'banniere'       => ["L'élevage", 'maison', 'Bandeau de la chatterie Ô Coeur Blanc : les Bengals de la maison sur un ciel étoilé'],

        // ── les documents ──
        'cert-saphyr'            => ['Saphyr — certificat de conformité LOOF', 'récompenses', 'Certificat de conformité à la race délivré par le LOOF pour Saphyr Ô Coeur Blanc'],
        'cert-shiva'             => ['Shiva — certificat de conformité LOOF', 'récompenses', 'Certificat de conformité à la race délivré par le LOOF pour Shiva Ô Coeur Blanc'],
        'expo-unyk-tarare'       => ['Unyk — prix spécial, Tarare 2024', 'récompenses', 'Diplôme de prix spécial décerné à Unyk de FashionBengal à l’exposition de Tarare, février 2024'],
        'expo-ukaina-tarare'     => ['Ukaïna — prix spécial, Tarare 2024', 'récompenses', 'Diplôme de prix spécial décerné à Ukaïna de FashionBengal à l’exposition de Tarare, février 2024'],
        'expo-ukaina-autun'      => ['Ukaïna — prix spécial, Autun 2023', 'récompenses', 'Diplôme de prix spécial décerné à Ukaïna de FashionBengal à l’exposition d’Autun, septembre 2023'],
        'expo-ukaina-autun-2023' => ['Ukaïna — prix spécial, Autun 2023', 'récompenses', 'Second diplôme de prix spécial décerné à Ukaïna de FashionBengal à l’exposition d’Autun, septembre 2023'],
        'expo-salambo-autun'     => ['Salambo — best variété, Autun 2023', 'récompenses', 'Diplôme de best variété décerné à Ambersands Salambo à l’exposition d’Autun, septembre 2023'],
        'expo-coupe'             => ['Les récompenses de Tarare', 'récompenses', 'Coupe, rosettes et diplômes rapportés de l’exposition de Tarare'],
    ];

    public function handle(): int
    {
        $dossier = public_path('images/cats');
        $fichiers = glob($dossier.'/*.{webp,jpg,jpeg,png}', GLOB_BRACE) ?: [];

        if ($fichiers === []) {
            $this->warn('Aucune image trouvée dans public/images/cats.');

            return self::FAILURE;
        }

        $ordre = (int) Photo::max('ordre');
        $crees = 0;
        $majs  = 0;
        $dimensions = 0;

        foreach ($fichiers as $fichier) {
            $base    = pathinfo($fichier, PATHINFO_FILENAME);
            $chemin  = 'images/cats/'.basename($fichier);

            $connue = self::LEGENDES[$base] ?? null;

            $legende   = $connue[0] ?? Str::of($base)->replace(['-', '_'], ' ')->ucfirst()->toString();
            $categorie = $connue[1] ?? (Str::startsWith($base, ['k', 'g']) ? 'chatons' : 'adultes');
            // A defaut de texte alternatif propre, la legende fait office — mais
            // c'est un pis-aller : les deux ne disent pas la meme chose.
            $alt       = $connue[2] ?? $legende;

            $photo = Photo::firstOrNew([
                'attachable_type' => Litter::class,
                'attachable_id'   => 0,
                'chemin'          => $chemin,
            ]);

            if (! $photo->exists) {
                $photo->fill([
                    'alt'       => $alt,
                    'legende'   => $legende,
                    'categorie' => $categorie,
                    'ordre'     => ++$ordre,
                ])->save();
                $crees++;
                continue;
            }

            // Les photos d'avant l'ajout des dimensions n'en ont pas : on les
            // releve ici. Le modele ne le fait qu'au changement de chemin.
            if (blank($photo->largeur) || blank($photo->hauteur)) {
                $taille = @getimagesize($fichier);
                if ($taille !== false) {
                    $photo->forceFill(['largeur' => $taille[0], 'hauteur' => $taille[1]])->save();
                    $dimensions++;
                }
            }

            // --legendes : on réaligne les libellés connus, sans toucher au reste.
            if ($this->option('legendes') && isset(self::LEGENDES[$base])) {
                $photo->update(['alt' => $alt, 'legende' => $legende, 'categorie' => $categorie]);
                $majs++;
            }
        }

        $this->info("{$crees} photo(s) ajoutée(s), {$majs} mise(s) à jour, {$dimensions} dimension(s) relevée(s). Galerie : ".Photo::count().' au total.');

        return self::SUCCESS;
    }
}
