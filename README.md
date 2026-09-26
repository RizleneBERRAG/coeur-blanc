# Chatterie Ô Coeur Blanc

Site de la Chatterie Ô Coeur Blanc — élevage de Bengal LOOF à Meyrieu-les-Étangs
(38440), Isère. Laravel 12, Blade, MySQL, back-office Filament.

Le socle technique est celui du site Bengal's Parc (même métier, même règle
de publication des chatons). La charte graphique, elle, descend de celle du
Temple des Fées — arches, frises, chapitres numérotés, dorure en dégradé —
transposée en blanc : c'est la charte « Lumière », décrite en tête de
`resources/css/app.css`.

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

### Ce qui reste inventé, à remplacer depuis le back-office

- **la portée en cours** (« Portée B », B'Ciel, B'Nuage, B'Ange) : ses noms, ses
  dates, ses poids et son suivi. Les trois photos qui l'illustrent sont de vrais
  chatons de l'élevage, mais nés les années précédentes ;
- les numéros ICAD et le numéro de portée LOOF de cette portée, posés par
  `php artisan demo:numeros`.

### À confirmer auprès de l'éleveuse

- **Ukaïna** : le site Wix la dit née le 19 mai 2022, son certificat LOOF le
  19 mai 2023. C'est la date du certificat qui est retenue.
- **Armonie**, la femelle mink de mars 2025 gardée comme future reproductrice,
  n'a pas de fiche : aucune photo d'elle seule n'est identifiable avec
  certitude sur le site Wix. Elle est citée dans le texte d'Ukaïna.
- Les mariages annoncés sur Wix (Saphyr/Unyk et Ultime/Unyk en mai-juin 2025,
  Shiva/Unyk et Ukaïna/Unyk en septembre-octobre 2025) ne sont pas repris : ces
  dates sont passées.

## Ce qui est en place

| Domaine | Fichiers |
|---|---|
| Reproducteurs et dépistages | `app/Models/Cat.php`, `HealthTest.php` |
| Portées, chatons, suivi | `Litter.php`, `Kitten.php`, `LitterEvent.php` |
| Dossiers adoptants (RGPD) | `AdoptionRequest.php`, `app/Console/Commands/PurgeRgpd.php` |
| Messages de contact (RGPD) | `ContactMessage.php`, `ContactController.php` |
| Réglages et mentions légales | `Setting.php` |
| Pages publiques | `routes/web.php`, `app/Http/Controllers/`, `resources/views/pages/` |
| Charte graphique | `resources/css/app.css` (charte « Lumière ») |
| Emblème (auréole et ailes) | `resources/views/components/fleuron.blade.php` |
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

Aucun nom d'adoptant n'est jamais affiché côté public. Les statuts
« réservé » et « adopté » portent sur le chaton, pas sur la famille.

## Carte de la page Contact

Leaflet + fond clair CartoDB (Positron), sans clé API et sans traceur. Les
coordonnées et les temps de trajet sont dans `config/bengal.php`, clé `carte`.
L'adresse exacte n'est volontairement jamais publiée : la carte affiche un
cercle de 2,2 km autour de Meyrieu-les-Étangs, plus les repères d'accès.
