@extends('layouts.app')

@section('title', "Chatons Bengal disponibles")
@section('description', "Les chatons Bengal de la portée en cours : robe, sexe, poids, suivi vétérinaire et statut mis à jour. Inscrits au LOOF, cédés identifiés et vaccinés.")

@section('content')

<section class="band">
    <div class="wrap">
        <x-section-head
            niveau="1"
            eyebrow="Nos chatons"
            titre="{{ $portee->code }} — {{ $portee->pere?->nom }} × {{ $portee->mere?->nom }}"
            lede="Nés le {{ $portee->date_naissance->translatedFormat('j F Y') }}. {{ $portee->phraseDisponibilite() ? \Illuminate\Support\Str::ucfirst($portee->phraseDisponibilite()).', ' : '' }}identifiés, vaccinés, vermifugés et inscrits au LOOF." />

        {{--
            Des liens, pas des boutons : sans JavaScript ils rechargent la page
            avec ?statut= et le serveur masque lui-meme les fiches. Le script les
            intercepte et masque sur place — toutes les fiches sont de toute
            facon dans le document, c'est ce qui permet au filtre de revenir en
            arriere, et de fonctionner sur la copie statique qui n'a pas de
            serveur pour lire la requete.
        --}}
        <div class="filters" data-filtre-chatons>
            <a href="{{ route('kittens.index') }}" data-statut=""
               @class(['btn-filter']) aria-pressed="{{ $statut ? 'false' : 'true' }}"
               role="button">Tous ({{ $total }})</a>
            @foreach(\App\Enums\KittenStatus::cases() as $cas)
                <a href="{{ route('kittens.index', ['statut' => $cas->value]) }}"
                   data-statut="{{ $cas->value }}"
                   aria-pressed="{{ $statut === $cas->value ? 'true' : 'false' }}"
                   role="button">{{ $cas->libelle() }}s ({{ $filtres[$cas->value] ?? 0 }})</a>
            @endforeach
        </div>

        <div class="grid" id="chatons">
            @foreach($chatons as $chaton)
                <x-kitten-card :chaton="$chaton"
                               :hidden="$statut && $statut !== $chaton->statut->value" />
            @endforeach
        </div>

        {{-- Le message depend des fiches VISIBLES, pas de la portee : filtrer
             sur un statut sans chaton ne vide pas la collection, il masque
             tout. --}}
        @php($visibles = $statut
            ? $chatons->filter(fn ($k) => $k->statut->value === $statut)->count()
            : $chatons->count())
        <p class="lede" id="chatons-vide" @if($visibles > 0) hidden @endif>
            Aucun chaton dans cette catégorie pour le moment.
            <a class="tlink" href="{{ route('adoption.create') }}">Rejoindre la liste d'attente</a>
        </p>
    </div>
</section>

<div class="band tight" style="padding-block:clamp(22px,3vw,36px)">
    <x-photo-strip titre="Les chatons au fil des semaines" />
</div>

@if($portee->events->isNotEmpty())
<section class="band ink2">
    <div class="wrap">
        <x-section-head
            eyebrow="Suivi de la portée"
            titre="Où en sont-ils aujourd'hui"
            lede="Le même calendrier pour les {{ $portee->nb_chatons }} chatons. Il se remplit au fil des actes vétérinaires saisis dans l'espace de gestion." />
        <div class="record"><x-timeline :events="$portee->events" /></div>
    </div>
</section>
@endif

@if($archives->isNotEmpty())
<section class="band paper">
    <div class="wrap">
        <x-section-head
            eyebrow="Historique"
            titre="Les portées précédentes"
            lede="Les portées passées restent en ligne. C'est la meilleure preuve du sérieux d'un élevage : on voit ce que sont devenus les chatons." />

        @foreach($archives as $archive)
            <div class="two" @if(! $loop->first) style="margin-top:40px" @endif>
                <figure class="figure">
                    <img src="{{ asset($archive->photo_principale ?? 'images/cats/portee-1.webp') }}"
                         alt="{{ $archive->code }}, chatons Bengal" loading="lazy">
                    <figcaption>{{ $archive->code }} — {{ $archive->date_naissance->translatedFormat('F Y') }}</figcaption>
                </figure>
                <div class="stack">
                    <p class="lede">{{ $archive->description }}</p>
                    <div class="facts">
                        <div class="fact"><b data-count="{{ $archive->kittens_count }}">0</b><span>Chatons</span></div>
                        <div class="fact"><b data-count="{{ $archive->kittens_count }}">0</b><span>Adoptés</span></div>
                        <div class="fact"><b data-count="0">0</b><span>Retour</span></div>
                    </div>
                    <p class="small">
                        Aucun nom de famille d'adoptant n'est publié sur ce site. Le statut d'un chaton
                        est une information sur le chaton, pas sur la personne qui l'a accueilli.
                    </p>
                </div>
            </div>
        @endforeach
    </div>
</section>
@endif

@endsection
