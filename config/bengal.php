<?php

/*
 * Contenu editorial fixe du site de la Chatterie Ô Coeur Blanc.
 *
 * - 'robe'       : les reperes cliquables de la lecture de robe (page Le Bengal).
 *                  x et y sont des pourcentages sur la photo public/images/cats/robe.webp ;
 *                  changer de photo impose de repositionner les reperes.
 * - 'couverture' : le detail de ce que couvre l'adoption (page Adopter).
 *
 * Ces deux blocs ne bougent quasiment jamais : ils restent en config plutot qu'en base.
 * Le reste du contenu (chatons, portees, chats, questions) vit en base de donnees.
 */

return [

    'robe' => [
        [
            'x' => 30,
            'y' => 50,
            'categorie' => 'Motif',
            'titre' => 'Rosette en donut',
            'texte' => 'Une tache claire entièrement cerclée d\'un contour plus foncé, comme un anneau refermé. C\'est le motif le plus recherché de la race, et le plus difficile à fixer : il demande plusieurs générations de sélection.',
        ],
        [
            'x' => 37,
            'y' => 40,
            'categorie' => 'Structure',
            'titre' => 'Ligne dorsale',
            'texte' => 'Sur un Bengal bien typé, les taches ne se rejoignent jamais en une bande continue le long du dos. Une ligne dorsale pleine est un défaut de type, héritage du tabby domestique.',
        ],
        [
            'x' => 48,
            'y' => 56,
            'categorie' => 'Effet',
            'titre' => 'Glitter',
            'texte' => 'Un reflet doré déposé sur la pointe du poil, visible seulement quand la lumière frappe la robe de biais. C\'est un caractère propre au Bengal, hérité de ses origines, qui donne l\'impression que le chat a été saupoudré d\'or.',
        ],
        [
            'x' => 20,
            'y' => 58,
            'categorie' => 'Fond',
            'titre' => 'Fond chaud, fond argent',
            'texte' => 'Le fond de robe va du sable au cuivre profond chez le brown, et du blanc à l\'argent chez le silver — la couleur des lignées de la maison. Plus le contraste entre le fond et les rosettes est marqué, plus la robe est considérée comme réussie.',
        ],
        [
            'x' => 62,
            'y' => 24,
            'categorie' => 'Tête',
            'titre' => 'Masque et colliers',
            'texte' => 'Les lignes du front doivent dessiner un M ouvert, et les marques du cou — les colliers — rester brisées. Un collier fermé qui fait le tour de la gorge est, là encore, une trace de tabby domestique.',
        ],
    ],

    'couverture' => [
        [
            'numero' => '01',
            'titre' => 'Saillie et suivi de gestation',
            'detail' => 'Échographie de confirmation, alimentation spécifique de la mère pendant neuf semaines, visites vétérinaires.',
            'quand' => 'Avant la naissance',
        ],
        [
            'numero' => '02',
            'titre' => 'Mise bas et première semaine',
            'detail' => 'Surveillance continue jour et nuit, pesée quotidienne, aide à la tétée si un chaton décroche.',
            'quand' => 'Semaine 1',
        ],
        [
            'numero' => '03',
            'titre' => 'Douze semaines de nourrissage',
            'detail' => 'Lait maternisé au besoin, puis pâtée et croquettes chaton sans céréales, à volonté, pour la mère comme pour les petits.',
            'quand' => 'Semaines 1 à 12',
        ],
        [
            'numero' => '04',
            'titre' => 'Deux vermifugations',
            'detail' => 'Protocole complet, renouvelé avant le départ.',
            'quand' => 'Semaines 5 et 9',
        ],
        [
            'numero' => '05',
            'titre' => 'Identification ICAD',
            'detail' => 'Puce électronique posée et enregistrée au nom de l\'élevage, puis transférée à la famille.',
            'quand' => 'Semaine 6',
        ],
        [
            'numero' => '06',
            'titre' => 'Primo-vaccination et rappel',
            'detail' => 'Typhus et coryza, deux injections, carnet de santé tenu à jour.',
            'quand' => 'Semaines 8 et 12',
        ],
        [
            'numero' => '07',
            'titre' => 'Certificat vétérinaire de bonne santé',
            'detail' => 'Établi moins de huit jours avant la cession, obligatoire et remis en main propre.',
            'quand' => 'Avant le départ',
        ],
        [
            'numero' => '08',
            'titre' => 'Inscription LOOF et pedigree',
            'detail' => 'Déclaration de saillie, déclaration de portée, édition du pedigree officiel.',
            'quand' => 'Semaines 1 à 12',
        ],
        [
            'numero' => '09',
            'titre' => 'Tests des parents',
            'detail' => 'Échographie cardiaque HCM, tests ADN PK-Def et PRA-b, dépistage FIV/FeLV, identification génétique chez Genindex — les résultats vous sont transmis à la réservation.',
            'quand' => 'Toute l\'année',
        ],
        [
            'numero' => '10',
            'titre' => 'Socialisation quotidienne',
            'detail' => 'Manipulation dès la naissance, habituation aux bruits de la maison, aux adultes et aux enfants, au transport.',
            'quand' => 'Chaque jour',
        ],
        [
            'numero' => '11',
            'titre' => 'Contrat et document d\'information',
            'detail' => 'Contrat de cession écrit, document d\'information sur les besoins de l\'espèce, conseils d\'arrivée.',
            'quand' => 'Au départ',
        ],
        [
            'numero' => '12',
            'titre' => 'Suivi après le départ',
            'detail' => 'Disponibilité pour toutes vos questions, aussi longtemps qu\'il le faudra.',
            'quand' => 'Sans limite',
        ],
    ],

    /*
     * La lignee, sur la page de l'elevage. Un rang par generation, du plus
     * ancien au plus recent, chaque entree etant un slug de chat.
     *
     * Les rangs ne sont relies que par un filet vertical : on sait que Jag est
     * le grand-pere d'Ultime, on ne sait pas laquelle de ses filles est sa
     * mere. Le jour ou ce sera confirme, on pourra dessiner les branches.
     */
    'lignee' => [
        ['rang' => '1re génération', 'annee' => '2014', 'chats' => ['jag']],
        ['rang' => '2e génération',  'annee' => '2021', 'chats' => ['saphyr', 'shiva']],
        ['rang' => '3e génération',  'annee' => '2023', 'chats' => ['ultime']],
    ],

    /*
     * Les robes travaillees par l'elevage, chacune rattachee au chat qui la
     * porte ici : c'est la difference entre un lexique de la race et un
     * elevage. Le slug renvoie a la fiche.
     */
    'robes_maison' => [
        [
            'chat'  => 'shiva',
            'nom'   => 'Black silver',
            'texte' => "Fond argent, rosettes noires, pas une trace de roux. La lignée historique de la maison, celle de Shiva et d'Ultime.",
        ],
        [
            'chat'  => 'saphyr',
            'nom'   => 'Brown',
            'texte' => "Le fond chaud, du sable au cuivre, et des rosettes larges et bien ouvertes. C'est la robe classique du Bengal.",
        ],
        [
            'chat'  => 'ukaina',
            'nom'   => 'Snow mink charcoal',
            'texte' => "Une robe claire aux yeux aqua, doublée d'un masque charcoal. La plus rare des quatre, et la plus demandée.",
        ],
        [
            'chat'  => 'unyk',
            'nom'   => 'Black charcoal silver',
            'texte' => "L'argent du silver et le masque sombre du charcoal sur le même chat. C'est la robe de notre étalon.",
        ],
    ],

    /*
     * Carte de la page Contact.
     * L'adresse exacte n'est jamais publiee : on affiche une zone autour de
     * Meyrieu-les-Etangs, et les points de repere cites dans les acces.
     */
    'carte' => [
        'zone' => [
            'lat'    => 45.5340,
            'lng'    => 5.2010,
            'rayon'  => 2200,          // metres
            'titre'  => 'Meyrieu-les-Étangs',
            'detail' => "L'élevage — adresse exacte communiquée au rendez-vous",
        ],
        'reperes' => [
            ['lat' => 45.7640, 'lng' => 4.8357, 'titre' => 'Lyon',                     'detail' => "50 min par l'A43"],
            ['lat' => 45.5847, 'lng' => 5.2761, 'titre' => 'Gare de Bourgoin-Jallieu', 'detail' => '15 min en voiture'],
            ['lat' => 45.1885, 'lng' => 5.7245, 'titre' => 'Grenoble',                 'detail' => "55 min par l'A48"],
            ['lat' => 45.5254, 'lng' => 4.8744, 'titre' => 'Vienne',                   'detail' => '35 min'],
        ],
    ],

    /*
     * Qui a le droit d'entrer dans le back-office. Lu par User::canAccessPanel().
     * Le site n'ouvre aucune inscription : ajouter une adresse ici est une
     * decision, pas un effet de bord de la creation d'un compte.
     */
    'back_office' => [
        'emails' => [
            'les.aristocats@outlook.fr',
        ],
    ],

    /*
     * Anciennes adresses du site Wix, relevees page par page. Le site Wix vit
     * sur un sous-domaine wixsite.com : ces adresses ne tomberont ici que si
     * un jour le meme nom de domaine sert aux deux. La page 404 s'en sert
     * aussi pour proposer la bonne destination a un visiteur perdu.
     */
    'anciennes_urls' => [
        'animaux-disponibles'          => 'kittens.index',
        'about-1-1'                    => 'kittens.index',   // « Nos chatons actuel »
        'about-3-1'                    => 'kittens.index',   // « Mariages prévus »
        'les-adultes-de-la-chatterie'  => 'cats.index',
        'nos-males'                    => 'cats.index',
        'nos-femelles'                 => 'cats.index',
        'nos-femelles-1'               => 'cats.index',
        'femelles'                     => 'cats.index',
        'about-1'                      => 'cats.index',      // « Notre mâle Unyk »
        'a-propos'                     => 'cats.index',
        'temoignages'                  => 'contact',
    ],

];
