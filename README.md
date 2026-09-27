# Chatterie Ô Coeur Blanc

Site de la Chatterie Ô Coeur Blanc — élevage de Bengal LOOF à Châtonnay
(38440), Isère. Laravel 12, Blade, MySQL, back-office Filament.

Le socle technique est celui du site Bengal's Parc (même métier, même règle
de publication des chatons). La charte graphique est la « Plein cadre »,
décrite en tête de `resources/css/app.css` : la photographie d'abord, et rien
autour. Pas de cadre, pas de filet, pas de dorure, pas d'angle coupé — le
blanc du papier, le graphite, le grain.

Elle a été choisie parmi quatre ébauches montées sur le site lui-même, avec
ses vrais textes et ses vraies photos. Les trois autres — « Lumière » (blanc
et champagne, un fil d'or descendant la page), « Porcelaine » (ivoire et rose
poudré, angles arrondis) et « Nacre et ciel » (fond bleu pâle, cartes
blanches, argent au lieu d'or) — ont été écartées ; le commit
`bb729b0 Quatre ebauches, sur le vrai site` les garde si l'envie revient d'y
retourner.

Laravel 12 et non 13 : le XAMPP de la machine de dev tourne en PHP 8.2, et
Laravel 13 exige PHP 8.3.

## Installation

Depuis PhpStorm, terminal à la racine du projet :

```powershell
composer install
npm install
npm run build          # ou `npm run dev` pendant le développement
php artisan key:generate
```

> PowerShell 5 ne comprend pas `&&` : enchaîner les commandes avec `;`
> ou les lancer une par une.

Créer la base dans phpMyAdmin (XAMPP) :

```sql
CREATE DATABASE coeur_blanc CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Puis :

```bash
php artisan migrate --seed
```

Le site est ensuite accessible sur **http://localhost/coeur-blanc/public**
(ou `php artisan serve` pour http://127.0.0.1:8000).

Compte de départ du back-office : `les.aristocats@outlook.fr` / `coeur-blanc`
— à changer à la première connexion.

## Ce qui vient de l'ancien site Wix, et ce qui est à remplacer

Tout le contenu réel vient de https://lesaristocats.wixsite.com/website et des
certificats que l'élevage y publie : le nom, le lieu, le téléphone, le
courriel, la page Facebook, l'année de création (2019), les tests pratiqués
(FIV/FeLV, HCM, PK-Def, PRA-b, identification ADN chez Genindex), les huit
chats de la maison, les deux portées de mars 2025, et les récompenses en
exposition.

**Les numéros LOOF et ICAD des adultes** ont été relevés sur les certificats
de conformité et les diplômes d'exposition publiés sur le site Wix. Ils sont
donc réels, et affichés sur chaque fiche.

### Les photos

Les 60 photos sont celles du site Wix, téléchargées, recadrées au format 7/10
des arches et converties en WebP. Elles sont dans `public/images/cats`, et le
script qui les a produites n'est pas versionné : pour en ajouter, on passe par
le back-office.

Deux choses à savoir :

- les photos de studio portent le filigrane **« la Clic — Christine Chaviel »**,
  la photographe. Elles sont reprises telles quelles, crédit compris ; vérifier
  avec l'éleveuse que la cession de droits couvre le nouveau site ;
- **les montages du site Wix ne sont pas repris.** Les prénoms écrits en script
  rose (Ulia, Ulka, U'Simba, Tennessee, Tiago, Unyk…), les cœurs, le bandeau au
  ciel étoilé : posés au milieu d'une page en Cormorant et en filets d'or, ils
  faisaient basculer le site du côté enfantin. Ils sont toujours sur le site Wix
  si l'éleveuse veut les récupérer. Deux photos ont par ailleurs été recadrées
  pour écarter la mention « Ô Coeur Blanc » incrustée dans un coin.

Deux règles tiennent ce tri :

1. **le ruban défilant ne montre que des chats** — `photo-strip` écarte la
   catégorie « récompenses », parce qu'un document scanné n'est pas une photo ;
2. **une seule forme de cadre, partout.** L'arche a disparu : la courbe mangeait
   le sujet dès que la vignette était petite, et allait mal à tout ce qui n'est
   pas un portrait. À sa place, un rectangle aux quatre angles coupés, qui rime
   avec les équerres d'or des registres et ne rogne presque rien de la photo.
   Il est défini une fois, dans `--coupe`, et chaque cadre règle la taille de
   son angle avec `--coin`. Le filet est dessiné en anneau et non avec un
   `border` : `clip-path` trancherait le border et laisserait les diagonales
   nues. Seules les bandes photo pleine largeur gardent des bords francs.

### Deux règles sur les images

**Aucun cadre n'impose son format à une photo.** Les images au fil du texte
gardent les proportions dans lesquelles elles ont été prises, et le ruban
défilant donne à ses vignettes une hauteur commune mais des largeurs libres.
Un 4/3 imposé coupait la tête de tous les portraits — et chez cet élevage,
toutes les photos de chats sont des portraits. Les seuls recadrages sont faits
en amont, à l'import, pour les places qui l'exigent : les portraits de fiche en
7/10 et les deux bandes pleine largeur en 2,13.

**Aucun document dans une galerie de photos.** Les certificats LOOF et les
diplômes d'exposition sont dans `public/images/documents`, hors de portée de
`photos:sync`. Les distinctions sont citées en toutes lettres sur la page de
l'élevage (`config/bengal.php`, clé `distinctions`) : un diplôme photographié
de biais sur une table est un mauvais visuel, et la ligne de texte dit la même
chose mieux.

### Ce qui reste inventé, à remplacer depuis le back-office

- **la portée en cours** (« Portée B », B'Ciel, B'Nuage, B'Ange) : ses noms, ses
  dates, ses poids et son suivi. Les trois photos qui l'illustrent sont de vrais
  chatons de l'élevage, mais nés les années précédentes ;
- les numéros ICAD et le numéro de portée LOOF de cette portée, posés par
  `php artisan demo:numeros`.

### Ce que l'éleveuse a corrigé le 27 septembre 2026

Premier retour de l'éleveuse sur l'aperçu, par messages. Tout est appliqué :

- **L'adresse a changé.** L'élevage est à **Châtonnay (38440)**, plus à
  Meyrieu-les-Étangs. La commune vient du réglage `elevage.ville` (back-office,
  onglet Général) ; la carte, elle, a ses coordonnées dans `config/bengal.php`,
  clé `carte` — les deux sont à changer ensemble le jour d'un déménagement.
- **Les chatons sont stérilisés avant le départ.** C'est devenu la ligne 07 du
  relevé « Ce que couvre l'adoption », et cela apparaît dans les engagements,
  dans les chiffres de la page Élevage et dans les descriptions de référencement.
- **Le dépistage PKD** (échographie rénale) manquait : il est ajouté à la fiche
  de chaque reproducteur, au relevé et à la réponse sur les tests.
- **Il n'y a pas de visite avant la vaccination**, pour des raisons sanitaires,
  et l'éleveuse travaille beaucoup en visio. Toutes les pages qui promettaient
  une visite avant réservation ont été réécrites : l'accueil, l'étape 02 du
  parcours d'adoption, la ligne « Visites » de la page Contact, deux réponses de
  la FAQ et l'objet du formulaire de contact.
- **Jag est le silver, Olympe la brown** : leurs deux portraits étaient
  intervertis, et leurs robes fausses. Les fichiers `jag-1.webp` et
  `olympe-1.webp` ont été échangés sur le disque, de sorte que toutes les
  références du site restent valables.

### À confirmer auprès de l'éleveuse

- **La photo `jardin-longe.webp`** (ancien `jag-2.webp`) montre un Bengal brown
  en longe dans l'herbe. Ce n'est pas Jag, qui est argent. Faute de savoir de
  qui il s'agit, elle reste dans la galerie sans nom : à identifier, ou à
  retirer.
- **Les temps de trajet** de la page Contact ont été réestimés depuis Châtonnay
  (Lyon 55 min, gare de Bourgoin-Jallieu 20 min, Grenoble 1 h, Vienne 30 min).
  Ce sont des ordres de grandeur, à confirmer par quelqu'un qui fait la route.
- **Les autres photos de chats** n'ont pas été revérifiées une par une. Deux
  étaient interverties ; il peut en rester. Le plus sûr est de lui faire
  parcourir la page Élevage fiche par fiche.
- **Ukaïna** : le site Wix la dit née le 19 mai 2022, son certificat LOOF le
  19 mai 2023. C'est la date du certificat qui est retenue.
- **Armonie**, la femelle mink de mars 2025 gardée comme future reproductrice,
  n'a pas de fiche : aucune photo d'elle seule n'est identifiable avec
  certitude sur le site Wix. Elle est citée dans le texte d'Ukaïna.
- Les mariages annoncés sur Wix (Saphyr/Unyk et Ultime/Unyk en mai-juin 2025,
  Shiva/Unyk et Ukaïna/Unyk en septembre-octobre 2025) ne sont pas repris : ces
  dates sont passées.

## Ce qui n'appartient qu'à cette maison

Une charte peut être soignée et ressembler à trente autres sites d'élevage.
Quatre choses tiennent celui-ci à part, et aucune n'est décorative.

**Le fil.** Un trait d'or descend la page entière, à gauche du texte, et
chaque chapitre s'y accroche par une étoile à quatre branches — un clin d'œil
à Maina, « ma petite étoile ». Le rang du chapitre se tient dans la marge, pas
au-dessus du titre. C'est ce qui sort le site du gabarit habituel : une pile de
blocs centrés, si soignée soit-elle, ressemble à tous les sites élégants.

Le fil est dessiné par les bandes elles-mêmes, qui se touchent — une ligne par
bande, et elle ne s'interrompt jamais. Sa position se mesure depuis la colonne
de texte, qui est centrée et bornée, d'où le `max()` dans `.band::after`. Trois
variables tiennent toute la mise en page : `--colonne` (la marge des numéros),
`--retrait` (la distance du fil au texte) et `--gout` (la gouttière). Sous
900 px la colonne tombe à zéro et le rang repasse au-dessus du titre.

**Le relevé en index.** Sur les fiches, l'intitulé et la valeur sont reliés par
une conduite de points, comme dans un index imprimé. Le pointillé est un
pseudo-élément qui s'étire à l'intérieur de l'intitulé, et non un fond à
masquer : un fond trahirait la couleur de la bande dès qu'elle change.

**Le logo de la maison.** Celui fourni par la cliente : un ovale surmonté de
son accent — le Ô — avec un cœur au creux. Le fichier d'origine est un tracé
blanc sur transparence, fait pour du sombre ; il a été recoloré à partir de son
seul canal alpha, la forme comptant et non la teinte. Il en sort la marque
seule (`logo-marque.png`) pour le bandeau et l'onglet, le logo entier
(`logo.png`) pour le pied de page, et la version blanche rognée
(`logo-blanc.png`) pour tout fond sombre à venir. Le mot du bandeau ne répète
pas le Ô, la marque le porte déjà.

**Le cœur.** Celui du logo, isolé en SVG
(`resources/views/components/coeur.blade.php`). Il sert de nœud au fil, à
chaque chapitre. Plein, jamais en contour : c'est ainsi qu'il est dessiné dans
la marque.

**L'histoire du nom**, sur l'accueil. La chatterie s'appelle Ô Coeur Blanc en
hommage à Maina, la petite chatte snow par qui tout a commencé, et c'est en
cherchant une saillie pour sa sœur Olympe que l'éleveuse a rencontré Jag. Tout
vient de la page « À propos » du site Wix.

**La lignée**, sur la page de l'élevage : trois générations nées sous le même
toit, Jag en 2014, Saphyr et Shiva en 2021, Ultime en 2023. Les rangs ne sont
reliés que par un filet vertical, sans branche — voir le commentaire dans
`config/bengal.php`, clé `lignee`.

Et sur la page du Bengal, **les robes de la maison** (`robes_maison`) : les
quatre robes travaillées ici, chacune renvoyant à la fiche du chat qui la
porte. C'est la différence entre un lexique de la race et un élevage.

## Ce que la charte retenue change

Ce qu'il faut savoir avant de toucher à `app.css` :

- **Les jetons gardent les noms de l'ancienne charte** (`--or`, `--or-mat`,
  `--dorure`) mais ce sont des ALIAS des gris `--gr-*` définis juste au-dessus.
  La feuille les emploie partout, et quelques gabarits les posent en style
  inline ; les renommer n'aurait rien apporté qu'un risque. Une couleur se
  change à un seul endroit : les six `--gr-*`.
- **`--coupe` vaut `none`.** Le mécanisme reste en place — il est lu par tout
  ce qui porte une image, et chaque élément garde son `--coin`. Lui redonner
  un polygone redéssinerait la silhouette du site entier, chacun retrouvant
  son rayon.
- **Deux familles de caractères sur trois font l'appareil.** Cormorant pour
  les titres, Jost pour le nom, le menu, les boutons et les intitulés de
  fiche ; Cinzel ne garde que les mentions de registre (rang de chapitre,
  étiquettes d'encart, boutons de la visionneuse), où sa gravure veut encore
  dire quelque chose.
- **Une section s'annonce par son rang et son titre, centrés, et rien
  d'autre.** Le rang vient d'un compteur CSS : rien à écrire dans les
  gabarits, et l'ordre reste juste le jour où une section s'ajoute.
- **Le seul dessin qui subsiste est le cœur du logo**, au pied de page et en
  marge d'un encart. Il vient de la marque, il ne décore pas.

Le logo suit la charte : il était doré (#A98F5E), il est en graphite
(#3A3A36), le ton médian du dégradé qui peint le nom dans le bandeau — la
marque et le mot se lisent ainsi comme un seul objet. Seule la couleur a
changé : le tracé est porté par le canal alpha, la forme et ses bords
adoucis sont intacts.

**Les fichiers dorés sont conservés** sous `logo-or.png`,
`logo-marque-or.png`, `favicon-32-or.png` et `favicon-180-or.png` dans
`public/images/`. Revenir à l'or, c'est les recopier par-dessus les quatre
fichiers sans suffixe : aucune ligne de CSS ni de gabarit à toucher.

## Ce qui est en place

| Domaine | Fichiers |
|---|---|
| Reproducteurs et dépistages | `app/Models/Cat.php`, `HealthTest.php` |
| Portées, chatons, suivi | `Litter.php`, `Kitten.php`, `LitterEvent.php` |
| Dossiers adoptants (RGPD) | `AdoptionRequest.php`, `app/Console/Commands/PurgeRgpd.php` |
| Messages de contact (RGPD) | `ContactMessage.php`, `ContactController.php` |
| Réglages et mentions légales | `Setting.php` |
| Pages publiques | `routes/web.php`, `app/Http/Controllers/`, `resources/views/pages/` |
| Charte graphique | `resources/css/app.css` (charte « Plein cadre ») |
| Emblème (le cœur ailé) | `resources/views/components/fleuron.blade.php` |
| Sceau (le Ô du nom) | `resources/views/components/sceau.blade.php`, `public/images/sceau.svg` |
| Contenu éditorial fixe | `config/bengal.php` |
| Contenu de démarrage | `database/seeders/data/content.php` |

## La règle métier à ne pas contourner

Une fiche chaton **ne peut pas être publiée** tant que son numéro d'identification
ICAD et le numéro de portée LOOF sont vides. C'est une obligation légale
(annonces de cession d'animaux de compagnie), appliquée à trois niveaux :

1. `Kitten::estPubliable()` — la règle elle-même ;
2. `App\Observers\KittenObserver` — repasse `est_publie` à `false` à chaque
   enregistrement si les numéros manquent, même si la case est cochée ;
3. `Kitten::scopePublies()` — utilisé par toutes les requêtes du site public,
   et `KittenController::show()` renvoie un 404 sur une fiche non publiée.

Le seeder laisse volontairement ces numéros vides : au premier lancement, les
fiches chatons sont donc en brouillon. C'est le comportement attendu — il suffit
de saisir les numéros pour qu'elles se publient.

### Voir le site rempli tout de suite

```powershell
php artisan demo:numeros           # remplit les numéros, publie les fiches
php artisan demo:numeros --reset   # vide les numéros, tout repasse en brouillon
```

⚠️ **À relancer après chaque `migrate:fresh --seed`**, et avant
`site:exporter` : sans numéros, aucune fiche chaton n'est publiable, et la
copie statique part sans une seule. L'export prévient désormais quand c'est
le cas, mais il ne s'arrête pas — un élevage peut légitimement n'avoir aucun
chaton à montrer entre deux portées.

Aucun nom d'adoptant n'est jamais affiché côté public. Les statuts
« réservé » et « adopté » portent sur le chaton, pas sur la famille.

## Carte de la page Contact

Leaflet sur les tuiles d'OpenStreetMap, sans clé API et sans traceur. Le fond
clair de CARTO (Positron) servait jusqu'ici ; il exige désormais une clé et ne
renvoie plus qu'un filigrane « API KEY REQUIRED ». Les tuiles arrivent donc en
couleurs, et `app.css` les ramène au gris de la page par un filtre sur
`.leaflet-tile-pane` — c'est un rendu, la tuile reçue n'est pas modifiée et
l'attribution reste due. Le fournisseur est déclaré dans
`resources/js/map.js` ; un test vérifie que la CSP de
`app/Http/Middleware/EntetesSecurite.php` autorise bien son domaine. Les
coordonnées et les temps de trajet sont dans `config/bengal.php`, clé `carte`.
L'adresse exacte n'est volontairement jamais publiée : la carte affiche un
cercle de 2,2 km autour de Châtonnay, plus les repères d'accès.
