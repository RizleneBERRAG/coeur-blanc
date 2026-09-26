<?php

/*
 * Contenu de reference du site de la Chatterie Ô Coeur Blanc.
 *
 * ── CE QUI EST REEL ──────────────────────────────────────────────────
 * Les chats, leurs robes, leurs dates de naissance, leurs numeros LOOF et
 * ICAD, les portees de 2025 et les recompenses en exposition viennent du
 * site Wix de l'elevage et des certificats LOOF et AFF qui y sont publies.
 * Les photos aussi : elles ont ete reprises du site Wix, recadrees au format
 * des arches, et sont bien celles des chats de la maison.
 *
 * ── CE QUI EST INVENTE, ET A REMPLACER ───────────────────────────────
 * La portee en cours (« Portee B ») et ses trois chatons : leurs noms, leurs
 * poids, les etapes de suivi. Les photos qui les illustrent sont de vrais
 * chatons de l'elevage, mais nes les annees precedentes. Rien de tout cela
 * ne doit rester en ligne : l'eleveuse saisit la vraie portee dans le
 * back-office, et la regle de publication (numero ICAD obligatoire) empeche
 * de toute facon une fiche incomplete de paraitre.
 *
 * Une divergence relevee : le site Wix annonce Ukaina nee le 19 mai 2022,
 * son certificat LOOF le 19 mai 2023. C'est la date du certificat qui est
 * retenue ici — a confirmer aupres de l'eleveuse.
 */

return [
        'REPROS' => [
            'unyk' => [
                'id' => 'unyk',
                'nom' => 'UNYK',
                'sexe' => 'Mâle',
                'role' => 'Étalon',
                'naissance' => '2023',
                'robe' => 'Black charcoal silver tabby, motif spotted et rosettes',
                'loof' => 'LOOF AR 241393',
                'icad' => '250 269 699 663 635',
                'photo' => 'unyk-1',
                'photo2' => 'unyk-2',
                'texte' => "Unyk de FashionBengal, né le 19 octobre 2023. Fond argenté, masque et ligne dorsale charcoal, contraste net : c'est lui qui signe les portées de la maison depuis 2025. Prix spécial à l'exposition de Tarare en février 2024. Entièrement testé et sain, identification génétique faite chez Genindex.",
                'tests' => [
                    ['HCM — échographie cardiaque', 'Normal', 'Contrôle annuel'],
                    ['PK-Def — déficit en pyruvate kinase', 'N/N', 'Test ADN'],
                    ['PRA-b — atrophie rétinienne', 'N/N', 'Test ADN'],
                    ['FIV / FeLV', 'Négatif', 'Dépistage sanguin'],
                ],
            ],
            'saphyr' => [
                'id' => 'saphyr',
                'nom' => 'SAPHYR',
                'sexe' => 'Femelle',
                'role' => 'Reproductrice',
                'naissance' => '2021',
                'robe' => 'Brown tabby, motif spotted et rosettes',
                'loof' => 'LOOF 2021.14021',
                'icad' => '250 269 608 849 050',
                'photo' => 'saphyr-2',
                'photo2' => 'saphyr-1',
                'texte' => "Saphyr Ô Coeur Blanc, née le 17 janvier 2021 à la chatterie, fille de Jag. Fond chaud, rosettes larges et bien ouvertes, glitter franchement visible en pleine lumière. Déclarée conforme à la race par le LOOF en juin 2022. Mère très présente, qui élève ses portées au milieu de la maison.",
                'tests' => [
                    ['HCM — échographie cardiaque', 'Normal', 'Contrôle annuel'],
                    ['PK-Def — déficit en pyruvate kinase', 'N/N', 'Test ADN'],
                    ['PRA-b — atrophie rétinienne', 'N/N', 'Test ADN'],
                    ['FIV / FeLV', 'Négatif', 'Dépistage sanguin'],
                ],
            ],
            'shiva' => [
                'id' => 'shiva',
                'nom' => 'SHIVA',
                'sexe' => 'Femelle',
                'role' => 'Reproductrice',
                'naissance' => '2021',
                'robe' => 'Black silver tabby, motif spotted et rosettes',
                'loof' => 'LOOF 2021.29057',
                'icad' => '250 269 590 606 570',
                'photo' => 'shiva-2',
                'photo2' => 'shiva-5',
                'texte' => "Shiva Ô Coeur Blanc, née le 20 avril 2021 à la chatterie, fille de Jag. Fond argent, rosettes noires, pas une trace de roux. Déclarée conforme à la race par le LOOF en octobre 2023. Mère des chatons de mars 2025 avec Salambo — tous partis en famille, la femelle restant à la maison comme future reproductrice.",
                'tests' => [
                    ['HCM — échographie cardiaque', 'Normal', 'Contrôle annuel'],
                    ['PK-Def — déficit en pyruvate kinase', 'N/N', 'Test ADN'],
                    ['PRA-b — atrophie rétinienne', 'N/N', 'Test ADN'],
                    ['FIV / FeLV', 'Négatif', 'Dépistage sanguin'],
                ],
            ],
            'ukaina' => [
                'id' => 'ukaina',
                'nom' => 'UKAÏNA',
                'sexe' => 'Femelle',
                'role' => 'Reproductrice',
                'naissance' => '2023',
                'robe' => 'Seal charcoal silver tabby mink, motif spotted et rosettes',
                'loof' => 'LOOF 2023.34226',
                'icad' => '250 269 699 614 685',
                'photo' => 'ukaina-2',
                'photo2' => 'ukaina-4',
                'texte' => "Ukaïna de FashionBengal, née le 19 mai 2023. Robe mink aux yeux aqua, masque charcoal, motif très dessiné. La plus titrée de la maison : prix spécial à Autun en septembre 2023, puis à Tarare en février 2024. Mère des chatons de mars 2025 avec Unyk.",
                'tests' => [
                    ['HCM — échographie cardiaque', 'Normal', 'Contrôle annuel'],
                    ['PK-Def — déficit en pyruvate kinase', 'N/N', 'Test ADN'],
                    ['PRA-b — atrophie rétinienne', 'N/N', 'Test ADN'],
                    ['FIV / FeLV', 'Négatif', 'Dépistage sanguin'],
                ],
            ],
            'ultime' => [
                'id' => 'ultime',
                'nom' => 'ULTIME',
                'sexe' => 'Femelle',
                'role' => 'Reproductrice',
                'naissance' => '2023',
                'robe' => 'Black silver tabby',
                'loof' => null,
                'icad' => null,
                'photo' => 'ultime-4',
                'photo2' => 'ultime-1',
                'texte' => "Ultime Ô Coeur Blanc, née le 31 août 2023 à la chatterie, petite-fille de Jag et fille de la lignée silver de Shiva. Reproductrice depuis 2025, mariée à Unyk. Elle passe ses journées sur les passerelles de l'enclos, à surveiller ce qui se passe dehors.",
                'tests' => [
                    ['HCM — échographie cardiaque', 'Normal', 'Contrôle annuel'],
                    ['PK-Def — déficit en pyruvate kinase', 'N/N', 'Test ADN'],
                    ['PRA-b — atrophie rétinienne', 'N/N', 'Test ADN'],
                    ['FIV / FeLV', 'Négatif', 'Dépistage sanguin'],
                ],
            ],
            'jag' => [
                'id' => 'jag',
                'nom' => 'JAG',
                'sexe' => 'Mâle',
                'role' => 'Retraité',
                'naissance' => '2014',
                'robe' => 'Brown tabby, motif rosettes',
                'loof' => null,
                'icad' => null,
                'photo' => 'jag-1',
                'photo2' => 'jag-2',
                'texte' => "Jag Jocelot des Bengalexception, né en 2014. Notre premier coup de cœur pour un mâle reproducteur, et l'un des plus beaux chats de la maison : père de Saphyr et de Shiva, grand-père d'Ultime. Testé et sain des maladies génétiques et de la HCM. Mâle doux et attachant, très respectueux de l'homme et de ses congénères. Aujourd'hui retraité, il vit paisiblement à la chatterie en profitant de l'extérieur.",
                'tests' => [
                    ['HCM — échographie cardiaque', 'Normal', 'Contrôle annuel'],
                    ['PK-Def — déficit en pyruvate kinase', 'N/N', 'Test ADN'],
                    ['PRA-b — atrophie rétinienne', 'N/N', 'Test ADN'],
                    ['FIV / FeLV', 'Négatif', 'Dépistage sanguin'],
                ],
            ],
            'salambo' => [
                'id' => 'salambo',
                'nom' => 'SALAMBO',
                'sexe' => 'Mâle',
                'role' => 'Retraité',
                'naissance' => '2021',
                'robe' => 'Black silver tabby, motif spotted et rosettes',
                'loof' => 'TICA SBT 040421 084',
                'icad' => '616 093 901 665 388',
                'photo' => 'salambo-1',
                'photo2' => 'salambo-2',
                'texte' => "Ambersands Salambo, né le 4 avril 2021, importé à l'été 2021 pour apporter du sang étranger à la lignée. Best variété à l'exposition d'Autun en septembre 2023. Mâle très affectueux, proche de l'homme et des autres chats, bavard et joueur. Entièrement testé et sain. Placé en retraite en février 2025 — nous avons gardé l'une de ses filles.",
                'tests' => [
                    ['HCM — échographie cardiaque', 'Normal', 'Contrôle annuel'],
                    ['PK-Def — déficit en pyruvate kinase', 'N/N', 'Test ADN'],
                    ['PRA-b — atrophie rétinienne', 'N/N', 'Test ADN'],
                    ['FIV / FeLV', 'Négatif', 'Dépistage sanguin'],
                ],
            ],
            'olympe' => [
                'id' => 'olympe',
                'nom' => 'OLYMPE',
                'sexe' => 'Femelle',
                'role' => 'Retraité',
                'naissance' => '2019',
                'robe' => 'Snow',
                'loof' => null,
                'icad' => null,
                'photo' => 'olympe-1',
                'photo2' => null,
                'texte' => "Olympe de Laf, la sœur de Maina — la petite chatte snow par qui tout a commencé, et à qui la chatterie doit son nom. Elle est arrivée de la portée suivante, des mêmes parents, pour qu'il nous reste un peu d'elle. La nature en a décidé autrement : Olympe n'a jamais eu de chatons. Elle vit toujours avec nous, et c'est en cherchant une saillie pour elle que nous avons rencontré Jag.",
                'tests' => [],
            ],
        ],

        /*
         * La portee en cours : INVENTEE pour la demonstration. Voir l'avertissement
         * en tete de fichier. Les photos sont de vrais chatons de l'elevage, nes
         * les annees precedentes.
         */
        'CHATONS' => [
            [
                'id' => 'bciel',
                'nom' => "B'CIEL",
                'sexe' => 'Mâle',
                'robe' => 'Black silver tabby spotted',
                'statut' => 'dispo',
                'photo' => 'chaton-1',
                'ref' => 'B-01',
                'poids' => '1 460 g',
                'texte' => "Le plus entreprenant de la portée. Fond argent et rosettes déjà bien dessinées sur les flancs. Premier à venir vers les visiteurs, premier dans la gamelle, premier à ouvrir les portes de placard.",
            ],
            [
                'id' => 'bnuage',
                'nom' => "B'NUAGE",
                'sexe' => 'Femelle',
                'robe' => 'Black silver tabby, motif rosettes',
                'statut' => 'dispo',
                'photo' => 'chaton-2',
                'ref' => 'B-02',
                'poids' => '1 310 g',
                'texte' => "Contraste très soutenu pour son âge, sans une trace de roux. Caractère observateur : elle regarde d'abord, puis ne vous lâche plus de la soirée. Déjà à l'aise en hauteur, sur l'arbre à chat du salon.",
            ],
            [
                'id' => 'bange',
                'nom' => "B'ANGE",
                'sexe' => 'Mâle',
                'robe' => 'Brown tabby, motif rosettes',
                'statut' => 'reserve',
                'photo' => 'chaton-3',
                'ref' => 'B-03',
                'poids' => '1 520 g',
                'texte' => "Le brown de la portée, fond chaud et rosettes cerclées. Très bavard — typiquement le Bengal qui commente chacun de vos déplacements dans la maison.",
            ],
        ],
        'PORTEE' => [
            'code' => 'Portée B',
            'pere' => 'unyk',
            'mere' => 'saphyr',
            'naissance' => '3 juillet 2026',
            'dispo' => '25 septembre 2026',
            'nb' => 3,
        ],

        /* Les deux portees de mars 2025, telles qu'annoncees sur le site Wix. */
        'PORTEES_PASSEES' => [
            [
                'slug' => 'portee-a-salambo-shiva-2025',
                'code' => 'Portée A — Salambo × Shiva',
                'pere' => 'salambo',
                'mere' => 'shiva',
                'naissance' => '06/03/2025',
                'nb' => 3,
                'description' => "Deux mâles et une femelle, nés le 6 mars 2025. Tous ont trouvé une famille ; la femelle reste à la chatterie et sera reproductrice en 2026.",
                'robe' => 'Black silver tabby',
                'photo' => 'portee-2025-1',
            ],
            [
                'slug' => 'portee-a-unyk-ukaina-2025',
                'code' => 'Portée A — Unyk × Ukaïna',
                'pere' => 'unyk',
                'mere' => 'ukaina',
                'naissance' => '20/03/2025',
                'nb' => 2,
                'description' => "Un mâle et une femelle, nés le 20 mars 2025. Atlas, A'Zazou, A'Nala et A'Pumba ont trouvé de super familles ; Armonie, la femelle mink, reste avec nous comme future reproductrice.",
                'robe' => 'Snow mink charcoal',
                'photo' => 'portee-2025-5',
            ],
        ],

        'ETAPES' => [
            ['done' => true, 'when' => '3 juillet 2026',     'what' => 'Naissance — pesée quotidienne pendant les quinze premiers jours'],
            ['done' => true, 'when' => '17 juillet 2026',    'what' => 'Ouverture des yeux, premiers déplacements hors du nid'],
            ['done' => true, 'when' => '3 août 2026',        'what' => 'Première vermifugation et début du sevrage'],
            ['done' => true, 'when' => '14 août 2026',       'what' => 'Identification par puce électronique et enregistrement ICAD'],
            ['done' => true, 'when' => '21 août 2026',       'what' => 'Primo-vaccination typhus et coryza'],
            ['done' => true, 'when' => '18 septembre 2026',  'what' => 'Rappel de vaccination et certificat vétérinaire de bonne santé'],
            ['now' => true,  'when' => '25 septembre 2026',  'what' => 'Douze semaines révolues — âge légal de cession atteint, départs possibles'],
            ['done' => false, 'when' => 'Au départ',         'what' => "Pedigree LOOF, carnet de santé, contrat de cession et kit d'alimentation remis à la famille"],
        ],

        /*
         * La galerie. Categories : adultes, chatons, maison, recompenses.
         * Les legendes detaillees et les textes alternatifs vivent dans
         * SyncPhotos::LEGENDES — une seule liste pour toute l'application.
         */
        'GALERIE' => [
            ['f' => 'banniere',        'c' => "L'élevage",                 'cat' => 'maison'],
            ['f' => 'unyk-1',          'c' => 'Unyk',                      'cat' => 'adultes'],
            ['f' => 'portee-1',        'c' => 'Une portée au complet',     'cat' => 'chatons'],
            ['f' => 'saphyr-2',        'c' => 'Saphyr',                    'cat' => 'adultes'],
            ['f' => 'portee-2025-4',   'c' => 'Chatons de mars 2025',      'cat' => 'chatons'],
            ['f' => 'shiva-2',         'c' => 'Shiva',                     'cat' => 'adultes'],
            ['f' => 'ancien-tiago',    'c' => 'Tiago, devenu grand',       'cat' => 'chatons'],
            ['f' => 'ukaina-4',        'c' => 'Ukaïna',                    'cat' => 'adultes'],
            ['f' => 'portee-2',        'c' => 'La fratrie sur le plaid',   'cat' => 'chatons'],
            ['f' => 'ultime-1',        'c' => 'Ultime',                    'cat' => 'adultes'],
            ['f' => 'ancien-usimba',   'c' => "U'Simba",                   'cat' => 'chatons'],
            ['f' => 'jag-1',           'c' => 'Jag',                       'cat' => 'adultes'],
            ['f' => 'portee-3',        'c' => 'Deux chatons au jeu',       'cat' => 'chatons'],
            ['f' => 'salambo-1',       'c' => 'Salambo',                   'cat' => 'adultes'],
            ['f' => 'ancien-ulka',     'c' => 'Ulka',                      'cat' => 'chatons'],
            ['f' => 'olympe-1',        'c' => 'Olympe',                    'cat' => 'maison'],
            ['f' => 'portee-2025-1',   'c' => 'Les premiers jours',        'cat' => 'chatons'],
            ['f' => 'unyk-3',          'c' => "Unyk dans l'enclos",        'cat' => 'adultes'],
            ['f' => 'ancien-ulia',     'c' => 'Ulia',                      'cat' => 'chatons'],
            ['f' => 'ultime-3',        'c' => 'Ultime en surveillance',    'cat' => 'maison'],
            ['f' => 'portee-2025-2',   'c' => 'Deux jours',                'cat' => 'chatons'],
            ['f' => 'saphyr-4',        'c' => "Saphyr à l'automne",        'cat' => 'adultes'],
            ['f' => 'ancien-tennessee', 'c' => 'Tennessee',                'cat' => 'chatons'],
            ['f' => 'shiva-5',         'c' => 'Shiva au studio',           'cat' => 'adultes'],
            ['f' => 'portee-4',        'c' => 'Le jour de la naissance',   'cat' => 'chatons'],
            ['f' => 'ukaina-1',        'c' => 'Ukaïna, portrait',          'cat' => 'adultes'],
            ['f' => 'portee-2025-6',   'c' => 'Les quatre de mars',        'cat' => 'chatons'],
            ['f' => 'salambo-2',       'c' => "Salambo à l'arbre à chat",  'cat' => 'maison'],
            ['f' => 'montage-unyk',    'c' => 'Unyk, trois regards',       'cat' => 'adultes'],
            ['f' => 'jag-2',           'c' => 'Jag au jardin',             'cat' => 'maison'],
            ['f' => 'montage-saphyr',  'c' => 'Saphyr, trois regards',     'cat' => 'adultes'],
            ['f' => 'portee-2025-3',   'c' => 'Le mâle brown',             'cat' => 'chatons'],
            ['f' => 'montage-ultime',  'c' => 'Ultime, trois regards',     'cat' => 'adultes'],

            // Les documents : la preuve, pas la photo.
            ['f' => 'cert-saphyr',            'c' => 'Saphyr — certificat de conformité LOOF',  'cat' => 'récompenses'],
            ['f' => 'cert-shiva',             'c' => 'Shiva — certificat de conformité LOOF',   'cat' => 'récompenses'],
            ['f' => 'expo-unyk-tarare',       'c' => 'Unyk — prix spécial, Tarare 2024',        'cat' => 'récompenses'],
            ['f' => 'expo-ukaina-tarare',     'c' => 'Ukaïna — prix spécial, Tarare 2024',      'cat' => 'récompenses'],
            ['f' => 'expo-ukaina-autun',      'c' => 'Ukaïna — prix spécial, Autun 2023',       'cat' => 'récompenses'],
            ['f' => 'expo-ukaina-autun-2023', 'c' => 'Ukaïna — prix spécial, Autun 2023',       'cat' => 'récompenses'],
            ['f' => 'expo-salambo-autun',     'c' => 'Salambo — best variété, Autun 2023',      'cat' => 'récompenses'],
            ['f' => 'expo-coupe',             'c' => 'Les récompenses de Tarare',               'cat' => 'récompenses'],
        ],

        'FAQ' => [
            [
                'À quel âge un chaton peut-il partir ?',
                '<p>Douze semaines révolues, jamais avant. C\'est la loi, et c\'est surtout du bon sens : un chaton séparé plus tôt de sa mère et de sa fratrie n\'a pas terminé son apprentissage social. Il en garde souvent des troubles du comportement — morsures, malpropreté, anxiété de séparation.</p><p>Un éleveur qui vous propose un chaton à huit ou dix semaines vous dit en réalité quelque chose sur sa façon de travailler.</p>',
            ],
            [
                'Que comprend exactement le tarif ?',
                '<p>Pas le chat. Tout ce qui l\'entoure : la saillie, le suivi de gestation, la mise bas, douze semaines de nourrissage, les vermifugations, l\'identification, les deux vaccins, le certificat vétérinaire, l\'inscription au LOOF, les tests génétiques des parents, le contrat — et les centaines d\'heures passées à les manipuler pour qu\'ils arrivent chez vous déjà sociables.</p><p>Le détail complet est sur la page <a href=\'#/adoption\' data-nav>Adopter</a>.</p>',
            ],
            [
                'Les parents sont-ils testés ?',
                '<p>Tous nos reproducteurs, mâles et femelles, sont testés FIV/FeLV, HCM, PK-Def ainsi que PRA-b, et ont leur identification génétique ADN faite chez Genindex. Les résultats sont affichés sur la fiche de chaque chat, et tous les tests vous sont fournis par mail lors de la réservation de votre chaton.</p><p>Nous effectuons aussi régulièrement une coprologie de selles sur nos reproducteurs.</p>',
            ],
            [
                'Vos chats sont-ils présentés en exposition ?',
                '<p>Oui, et les certificats sont publiés dans la <a href="/galerie?categorie=r%C3%A9compenses">galerie</a>. Ukaïna a obtenu un prix spécial à Autun en 2023 puis à Tarare en 2024, Unyk un prix spécial à Tarare en 2024, Salambo le best variété à Autun en 2023.</p><p>Saphyr et Shiva ont par ailleurs passé l\'examen de conformité à la race du LOOF, et leurs certificats sont également en ligne.</p>',
            ],
            [
                'Le Bengal s\'entend-il avec les enfants et les autres animaux ?',
                '<p>Oui, et c\'est même l\'un de ses points forts. Nos chatons grandissent au milieu de la maison, en contact permanent avec les adultes et les enfants, ce qui fait une différence considérable à l\'arrivée chez vous.</p><p>La seule vraie règle est l\'adaptation progressive : une pièce dédiée les premiers jours, des présentations courtes, et on laisse le chaton décider du rythme.</p>',
            ],
            [
                'Faut-il en prendre deux ?',
                '<p>Si vous êtes absent toute la journée, oui, franchement. Le Bengal est un chat actif et joueur qui s\'ennuie vite seul, et l\'ennui se transforme en bêtises. Deux chatons de la même portée s\'occupent mutuellement et se dépensent ensemble.</p><p>Si quelqu\'un est présent à la maison une bonne partie de la journée, un seul suffit — il vous suivra partout.</p>',
            ],
            [
                'Peut-il vivre en appartement ?',
                '<p>Oui, à condition de lui donner de la hauteur. Un arbre à chat solide, des étagères libérées, une fenêtre sécurisée avec vue. Un Bengal en appartement avec de la verticalité est plus heureux qu\'un Bengal en maison sans rien à escalader.</p><p>Prévoyez aussi du jeu actif : quinze minutes de canne à pêche par jour changent tout.</p>',
            ],
            [
                'Que mangent vos chats ?',
                '<p>Tous les chats de la chatterie, adultes et chatons, sont nourris à volonté avec des croquettes sans céréales de très bonne qualité. Votre chaton part avec un kit d\'alimentation pour que la transition se fasse sans changement brutal.</p>',
            ],
            [
                'Pourquoi le LOOF est-il important ?',
                '<p>Le LOOF est le livre officiel des origines félines français. Un chaton inscrit a un pedigree qui trace ses ascendants sur plusieurs générations : c\'est ce qui permet de vérifier qu\'il n\'y a pas de consanguinité excessive et que la lignée est suivie.</p><p>Un chat vendu « de race » sans pedigree LOOF n\'est pas un chat de race au sens légal. Le pedigree est remis à la famille, il n\'est jamais en option ni en supplément.</p>',
            ],
            [
                'Livrez-vous les chatons ?',
                '<p>Non. Vous venez le chercher, et vous êtes déjà venu le voir au moins une fois avant. Un chaton n\'est pas un colis, et nous tenons à savoir dans quelles mains il part.</p><p>Nous ne faisons pas non plus de réservation sans rencontre préalable.</p>',
            ],
            [
                'Perd-il ses poils ? Est-il hypoallergénique ?',
                '<p>Il perd peu, son poil est court et ras, et il demande très peu d\'entretien — un brossage par semaine suffit largement.</p><p>En revanche, aucun chat n\'est hypoallergénique. Le Bengal produit lui aussi la protéine Fel d 1 responsable des allergies. Si vous êtes allergique, venez passer du temps à l\'élevage avant de vous engager.</p>',
            ],
            [
                'F1, F4, qu\'est-ce que ça veut dire ?',
                '<p>C\'est le nombre de générations qui séparent le chat de son ancêtre sauvage, le chat léopard du Bengale. Les F1 à F3 sont des hybrides soumis à une réglementation particulière et ne sont pas des chats de compagnie.</p><p>Tous les chatons vendus en élevage, les nôtres compris, sont au minimum F4 : ce sont des chats domestiques à part entière, sans aucune restriction.</p>',
            ],
            [
                'Comment se passe une visite ?',
                '<p>Sur rendez-vous, chez nous à Meyrieu-les-Étangs, en Isère, entre Lyon et Grenoble, proche des grands axes. Vous rencontrez la mère, la fratrie complète, et vous voyez l\'endroit où ils grandissent — pas une pièce préparée pour la visite.</p><p>Comptez une bonne heure. Venez avec vos questions, et avec les enfants si vous en avez.</p>',
            ],
        ],
    ];
