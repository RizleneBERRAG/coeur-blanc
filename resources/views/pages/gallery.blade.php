@extends('layouts.app')

@section('title', "Galerie — la vie à l'élevage")
@section('description', "Photos des Bengals de l'élevage : chatons, adultes et vie quotidienne à la maison, prises au fil des mois.")

@section('content')

<section class="band">
    <div class="wrap">
        <x-section-head
            niveau="1"
            eyebrow="Galerie"
            titre="La vie à l'élevage"
            lede="Des photos prises au fil des mois, pas une séance shooting. Cliquez pour agrandir." />

        @if($categories->isNotEmpty())
            {{--
                Des liens, pas des boutons : sans JavaScript ils rechargent la page
                avec ?categorie= et le filtre fonctionne quand même. Le script les
                intercepte et masque sur place — le serveur renvoyait de toute façon
                déjà toutes les photos, il les filtrait ici après les avoir chargées.
            --}}
            <div class="filters" id="galerie-filtres" data-filtre-galerie>
                <a href="{{ route('gallery') }}" data-categorie=""
                   aria-pressed="{{ request('categorie') ? 'false' : 'true' }}">Tout ({{ $photos->count() }})</a>
                @foreach($categories as $categorie)
                    <a href="{{ route('gallery', ['categorie' => $categorie]) }}" data-categorie="{{ $categorie }}"
                       aria-pressed="{{ request('categorie') === $categorie ? 'true' : 'false' }}">
                        {{ \Illuminate\Support\Str::ucfirst($categorie) }} ({{ $photos->where('categorie', $categorie)->count() }})
                    </a>
                @endforeach
            </div>
        @endif

        <div class="masonry" id="mas" data-lightbox>
            @foreach($photos as $photo)
                @php($cache = request('categorie') && request('categorie') !== $photo->categorie)
                @php($ratio = $photo->largeur && $photo->hauteur ? $photo->largeur / $photo->hauteur : 1)
                {{-- Au-dela de 1,6 une photo est nettement panoramique : elle traverse alors
     toute la largeur au lieu de tenir dans une colonne. --}}
                @php($format = $ratio > 1.6 ? 'panorama' : 'colonne')
                <figure data-full="{{ asset($photo->chemin) }}" data-legende="{{ $photo->legende }}"
                        data-format="{{ $format }}"                        style="--ratio:{{ round($ratio, 4) }}"
                        data-categorie="{{ $photo->categorie }}" @if($cache) hidden @endif>
                    {{--
                        width et height declares : sans eux le navigateur ne peut reserver
                        aucune place, et la grille en colonnes se reorganise a chaque image
                        qui arrive. Sur trente-six photos, ça saute pendant plusieurs
                        secondes. Les dimensions viennent de la base, relevees a
                        l'enregistrement de la photo.
                    --}}
                    <img src="{{ asset($photo->chemin) }}" alt="{{ $photo->alt }}" loading="lazy"
                         @if($photo->largeur && $photo->hauteur)
                             width="{{ $photo->largeur }}" height="{{ $photo->hauteur }}"
                         @endif>
                    <figcaption>{{ $photo->legende }}</figcaption>
                </figure>
            @endforeach
        </div>

        <p class="small" id="galerie-vide" hidden style="margin-top:28px">
            Aucune photo dans cette catégorie pour le moment.
        </p>
    </div>
</section>

@endsection
