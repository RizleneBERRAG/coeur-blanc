@extends('layouts.app')

@section('title', "Élevage de chats Bengal LOOF en Isère")
@section('description', "Chatterie Ô Coeur Blanc : chatons Bengal inscrits au LOOF à Châtonnay (38), entre Lyon et Grenoble. Parents testés HCM, PKD, PK-Def, PRA-b et FIV/FeLV, chatons stérilisés avant le départ.")

@push('schema')
{{--
    Fiche d'identite de l'elevage pour les moteurs. Elle compte double ici :
    le site Wix actuel n'expose aucune donnee structuree. Ces donnees sont le
    seul signal structure dont disposent les moteurs pour situer
    l'etablissement.

    Les coordonnees sont celles de la ZONE, pas de l'adresse exacte : le site
    annonce que l'adresse est communiquee au rendez-vous.

    Pas de Product ni d'Offer sur les fiches chaton : un resultat enrichi
    Product exige un prix, que ce site ne publie pas.
--}}
{{-- Le tableau est construit dans un bloc php, et non dans l'expression
     d'affichage : Blade compile la directive de contexte meme au milieu d'un
     tableau PHP. Ne pas ecrire de directive Blade dans ce commentaire. --}}
@php
    $schema = [
    '@context' => 'https://schema.org',
    '@type'    => 'LocalBusiness',
    '@id'      => route('home').'#elevage',
    'name'     => \App\Models\Setting::get('elevage.nom', 'Chatterie Ô Coeur Blanc'),
    'description' => "Élevage familial de chats Bengal LOOF à Châtonnay, en Isère, entre Lyon et Grenoble.",
    'url'      => route('home'),
    'image'    => asset('images/cats/hero-ultime.webp'),
    'telephone' => \App\Models\Setting::get('contact.telephone'),
    'email'     => \App\Models\Setting::get('contact.email'),
    'foundingDate' => '2019',
    'address'  => [
        '@type' => 'PostalAddress',
        'addressLocality' => \App\Models\Setting::get('elevage.ville'),
        'postalCode'      => \App\Models\Setting::get('elevage.code_postal'),
        'addressRegion'   => \App\Models\Setting::get('elevage.departement'),
        'addressCountry'  => 'FR',
    ],
    'geo' => [
        '@type'     => 'GeoCoordinates',
        'latitude'  => config('bengal.carte.zone.lat'),
        'longitude' => config('bengal.carte.zone.lng'),
    ],
    'areaServed' => [
        ['@type' => 'City',               'name' => 'Lyon'],
        ['@type' => 'City',               'name' => 'Grenoble'],
        ['@type' => 'AdministrativeArea', 'name' => \App\Models\Setting::get('elevage.departement')],
    ],
    'sameAs' => array_values(array_filter([
        \App\Models\Setting::get('contact.facebook'),
        \App\Models\Setting::get('contact.instagram'),
    ])),
    'availableLanguage' => 'fr',
];
@endphp
<script type="application/ld+json">
{!! json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>
@endpush

@section('content')

{{-- ═══ ouverture ═══ --}}
<section class="hero">
    {{--
        La photo prend la moitié droite de l'écran, du haut du bandeau au bas
        de l'ouverture, et sort par le bord. Elle était auparavant encadrée au
        milieu du blanc : une chatterie se présente par ses chats, pas par sa
        marge. Le voile blanc sur son flanc gauche la fait naître de la page
        plutôt que d'y être collée.
    --}}
    <div class="hero-photo">
        <img src="{{ asset('images/cats/hero.webp') }}"
             alt="Ultime, Bengal black silver tabby de la chatterie, sur une passerelle de l'enclos"
             width="1500" height="1875" fetchpriority="high">
    </div>

    <div class="hero-texte">
        <div class="dedans">
            <span class="eyebrow">Chatterie Ô Coeur Blanc · Châtonnay (38)</span>
            {{-- Chaque ligne est enfermee dans son propre masque : le span
                 interieur monte derriere, la ligne se decouvre. --}}
            <h1 class="or"><span class="ln"><span>Un léopard</span></span><span class="ln"><span><em>au cœur blanc.</em></span></span></h1>
            <p class="lede">
                Élevage familial de chats Bengal LOOF en Isère, entre Lyon et Grenoble,
                depuis 2019. Les chatons naissent et grandissent au milieu de la maison.
                Parents dépistés, chatons cédés identifiés, vaccinés, stérilisés et sous contrat.
            </p>
            <div class="btnrow">
                <a class="btn" href="{{ route('kittens.index') }}">
                    @if($nbDispo > 0) Voir les {{ $nbDispo }} chatons disponibles @else Voir la portée en cours @endif
                </a>
                <a class="btn ghost" href="{{ route('adoption.create') }}">Le parcours d'adoption</a>
            </div>
        </div>
    </div>
</section>

{{-- ═══ le fil vivant ═══ --}}
@if($portee)
<div class="livestrip">
    <div class="wrap in">
        <span class="pulse" aria-hidden="true"></span>
        <span class="mono" style="color:var(--encre-dim)">{{ $portee->code }} · {{ $portee->pere?->nom }} × {{ $portee->mere?->nom }}</span>
        <span>
            <strong>{{ $nbDispo }} chaton{{ $nbDispo > 1 ? 's' : '' }} disponible{{ $nbDispo > 1 ? 's' : '' }}</strong>
            <span style="color:var(--encre-dim)">— né{{ $portee->nb_chatons > 1 ? 's' : '' }} le {{ $portee->date_naissance->translatedFormat('j F Y') }}@if($portee->phraseDisponibilite()), {{ $portee->phraseDisponibilite() }}@endif</span>
        </span>
        <a class="tlink" href="{{ route('kittens.index') }}">Voir la portée</a>
    </div>
</div>
@endif

<div class="band tight" style="padding-block:clamp(26px,3vw,40px)">
    <x-photo-strip titre="La vie à l'élevage" />
</div>

{{-- ═══ chapitre premier : la portée ═══ --}}
@if($chatons->isNotEmpty())
<section class="band">
    <div class="wrap">
        <x-section-head
            eyebrow="Portée en cours"
            titre="La {{ \Illuminate\Support\Str::replaceFirst('Portée', 'portée', $portee->code) }} est arrivée"
            lede="{{ $portee->nb_chatons }} chatons nés le {{ $portee->date_naissance->translatedFormat('j F Y') }} de {{ $portee->pere?->nom }} et {{ $portee->mere?->nom }}. Chaque chaton a sa fiche : robe, sexe, poids, numéro d'identification, suivi vétérinaire et statut mis à jour en direct." />

        {{-- defile : sur telephone les fiches passent en rail horizontal
             plutot que de s'empiler sur cinq ecrans de haut. --}}
        <div class="grid defile" role="group" aria-label="Chatons de la portée">
            @foreach($chatons as $chaton)
                <x-kitten-card :chaton="$chaton" />
            @endforeach
        </div>

        <div class="btnrow" style="margin-top:40px;justify-content:center">
            <a class="btn ghost" href="{{ route('kittens.index') }}">Toutes les portées</a>
        </div>
    </div>
</section>
@endif

{{-- ═══ d'où vient le nom ═══ --}}
<section class="band ink2">
    <div class="wrap">
        <div class="two off">
            <div class="overlap">
                <figure class="a figure"><img src="{{ asset('images/cats/ultime-3.webp') }}" alt="Ultime, Bengal black silver de la chatterie, couchée sur une planche de l'enclos" loading="lazy"></figure>
                <figure class="b figure"><img src="{{ asset('images/cats/portee-1.webp') }}" alt="Quatre chatons Bengal alignés sur un arbre à chat" loading="lazy"></figure>
            </div>
            <div class="stack">
                <span class="eyebrow">D'où vient le nom</span>
                <p class="quote">« Ô Coeur Blanc, pour Maina&nbsp;— ma petite étoile. »</p>
                <p class="lede lettrine">
                    Tout a commencé par une minette snow au regard plein d'amour. Maina nous a fait
                    tomber amoureux de la race, et c'est en hommage à elle que la chatterie porte ce
                    nom. Quand elle est partie rejoindre les étoiles, nous avons accueilli sa sœur,
                    née des mêmes parents à la portée suivante : Olympe. Elle n'a jamais eu de
                    chatons, la nature en a décidé autrement, et elle vit toujours avec nous.
                </p>
                <p class="lede">
                    C'est en cherchant une saillie pour elle que nous avons rencontré Jag. Il est
                    devenu le premier mâle de la maison, et le grand-père de presque tous nos chats.
                </p>
                <a class="tlink" href="{{ route('cats.index') }}">L'histoire de l'élevage</a>
            </div>
        </div>
    </div>
</section>

{{-- ═══ les engagements ═══ --}}
<section class="band paper">
    <div class="wrap">
        <x-section-head
            eyebrow="Ce qui change tout"
            titre="Quatre engagements, pas des promesses"
            lede="Ce que nous tenons avant même que vous nous contactiez — et que vous pouvez vérifier sur ce site." />

        <div class="cells">
            <div class="cell-b"><span class="n">ENGAGEMENT 01</span><h3>Parents testés</h3><p>Tous nos reproducteurs, mâles et femelles, sont testés FIV/FeLV, HCM, PK-Def et PRA-b, et identifiés génétiquement par ADN chez Genindex. Les résultats vous sont fournis à la réservation de votre chaton.</p></div>
            <div class="cell-b"><span class="n">ENGAGEMENT 02</span><h3>Élevés au milieu de la maison</h3><p>Aucune cage, aucune pièce à part. Les chatons grandissent avec nous, les enfants et les bruits du quotidien, manipulés chaque jour dès la naissance.</p></div>
            <div class="cell-b"><span class="n">ENGAGEMENT 03</span><h3>Jamais avant douze semaines</h3><p>Départ à partir de trois mois, identifiés, primo-vaccinés, rappelés et stérilisés, avec un certificat vétérinaire de bonne santé de moins de huit jours.</p></div>
            <div class="cell-b"><span class="n">ENGAGEMENT 04</span><h3>Soignés et bien nourris</h3><p>Coprologies régulières sur les reproducteurs, et pour tous — adultes comme chatons — des croquettes sans céréales de très bonne qualité, à volonté.</p></div>
        </div>
    </div>
</section>

{{-- ═══ la lignée ═══ --}}
<section class="band">
    <div class="wrap">
        <x-section-head
            eyebrow="La lignée"
            titre="Nos reproducteurs"
            lede="Brown, black silver, snow mink, charcoal : chaque fiche affiche la robe, le pedigree et les résultats de dépistage." />
        <div class="repros">
            @foreach($chats as $chat)
                <x-cat-card :chat="$chat" />
            @endforeach
        </div>
        <div class="btnrow" style="margin-top:40px;justify-content:center">
            <a class="tlink" href="{{ route('cats.index') }}">Tous les chats de l'élevage</a>
        </div>
    </div>
</section>

<x-photo-band image="images/cats/bande-chatons.webp"
              legende="Quatre paires d'yeux sur le même point"
              hauteur="52vh" />

{{-- ═══ la race ═══ --}}
<section class="band ink2">
    <div class="wrap">
        <div class="two rev">
            <figure class="figure">
                <img src="{{ asset('images/cats/unyk-3.webp') }}" alt="Unyk, Bengal black charcoal silver, dressé contre un tronc dans l'enclos" loading="lazy">
                <figcaption>Unyk, dans l'enclos de la maison</figcaption>
            </figure>
            <div class="stack">
                <span class="eyebrow">La race</span>
                <h2>Un chat sauvage d'apparence,<br>un chat de famille de caractère</h2>
                <p class="lede">
                    Le Bengal descend d'un croisement entre le chat léopard du Bengale et des chats
                    domestiques, fixé en Californie par Jean S. Mill dans les années 1960 et reconnu
                    en 1983. De son ancêtre il garde la robe — rosettes, glitter, ligne dorsale — et
                    l'énergie. Le reste est un chat de compagnie bavard, joueur et franchement collant.
                </p>
                <a class="tlink" href="{{ route('breed') }}">Apprendre à lire une robe</a>
            </div>
        </div>
    </div>
</section>

{{-- ═══ la maison ═══ --}}
@if($photos->isNotEmpty())
<section class="band">
    <div class="wrap">
        <x-section-head eyebrow="La maison" titre="Ils grandissent ici" />
        {{-- defile : sur telephone les photos passent en bande plutot que de
             s'empiler. data-lightbox : la visionneuse les ouvre au doigt. --}}
        <div class="masonry defile" id="mas" data-lightbox>
            @foreach($photos as $photo)
                <figure data-full="{{ asset($photo->chemin) }}" data-legende="{{ $photo->legende }}">
                    <img src="{{ asset($photo->chemin) }}" alt="{{ $photo->alt }}" loading="lazy"
                         @if($photo->largeur && $photo->hauteur)
                             width="{{ $photo->largeur }}" height="{{ $photo->hauteur }}"
                         @endif>
                    <figcaption>{{ $photo->legende }}</figcaption>
                </figure>
            @endforeach
        </div>
        <div class="btnrow" style="margin-top:34px;justify-content:center">
            <a class="btn ghost" href="{{ route('gallery') }}">Voir toute la galerie</a>
        </div>
    </div>
</section>
@endif

{{-- ═══ transparence ═══ --}}
<section class="band ink2">
    <div class="wrap">
        <x-section-head
            eyebrow="Transparence"
            titre="Ce que vous pouvez vérifier"
            lede="Les informations qu'un éleveur doit pouvoir donner avant toute réservation. Elles sont affichées ici, pas sur demande." />

        <div class="legalgrid">
            <div class="legalcell"><span class="k">Élevage</span><span class="v">{{ \App\Models\Setting::get('elevage.nom') }}</span></div>
            <div class="legalcell"><span class="k">Adresse</span><span class="v">{{ \App\Models\Setting::get('elevage.ville') }} ({{ \App\Models\Setting::get('elevage.code_postal') }}), {{ \App\Models\Setting::get('elevage.departement') }}</span></div>
            <div class="legalcell"><span class="k">Certificat de capacité</span><x-legal-value cle="legal.certificat" /></div>
            <div class="legalcell"><span class="k">SIREN</span><x-legal-value cle="legal.siren" /></div>
            <div class="legalcell"><span class="k">N° de portée LOOF</span>
                @if($portee?->loof_portee_numero)
                    <span class="v">{{ $portee->loof_portee_numero }}</span>
                @else
                    <span class="v todo">À compléter</span>
                @endif
            </div>
            <div class="legalcell"><span class="k">Identification</span><span class="v">Puce ICAD avant cession</span></div>
            <div class="legalcell"><span class="k">Âge minimum de cession</span><span class="v">{{ \App\Models\Litter::SEMAINES_AVANT_CESSION }} semaines</span></div>
            <div class="legalcell"><span class="k">Contrat</span><span class="v">Écrit et signé à chaque cession</span></div>
        </div>

        <p class="lede" style="margin-top:24px;font-size:.92rem;margin-inline:auto;text-align:center">
            Les champs « à compléter » sont ceux que la loi impose d'afficher sur toute annonce de
            cession de chat. Le site les réclame automatiquement : une fiche chaton ne peut pas être
            publiée tant que son numéro d'identification est vide.
        </p>
    </div>
</section>

{{-- ═══ rendez-vous ═══ --}}
<section class="band paper">
    <div class="wrap">
        <x-section-head
            eyebrow="Faire connaissance"
            titre="On se rencontre d'abord en visio"
            lede="Tant que les chatons ne sont pas vaccinés, l'élevage ne reçoit personne : c'est ce qui les protège. En attendant on se parle en vidéo — vous les voyez en direct, avec leur mère, dans la pièce où ils vivent. La rencontre sur place vient ensuite, à Châtonnay, entre Lyon et Grenoble." />
        <div class="btnrow" style="justify-content:center">
            <a class="btn" href="{{ route('adoption.create') }}">Demander un rendez-vous</a>
            <a class="btn ghost" href="{{ \App\Models\Setting::telephoneLien() }}">{{ \App\Models\Setting::get('contact.telephone') }}</a>
        </div>
    </div>
</section>

@endsection
