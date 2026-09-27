@extends('layouts.app')

@section('title', "L'élevage et nos reproducteurs")
@section('description', "Chatterie Ô Coeur Blanc, élevage familial déclaré à la chambre d'agriculture à Meyrieu-les-Étangs. Nos reproducteurs, leur robe, leur pedigree et leurs dépistages.")

@section('content')

<section class="band">
    <div class="wrap">
        <x-section-head
            niveau="1"
            eyebrow="L'élevage"
            titre="Ô Coeur Blanc"
            lede="Un élevage familial et professionnel de Bengal LOOF, titulaire du certificat de capacité, installé à Meyrieu-les-Étangs, en Isère, entre Lyon et Grenoble, proche des grands axes." />

        <div class="two off">
            <figure class="figure">
                <img src="{{ asset('images/cats/salambo-2.webp') }}" alt="Salambo, Bengal black silver tabby, installé sur l'arbre à chat du salon">
                <figcaption>Salambo, à la retraite depuis février 2025</figcaption>
            </figure>
            <div class="stack">
                <h3>Une famille de Bengals, depuis 2019</h3>
                <p class="lede lettrine">
                    Nous exerçons depuis 2019, dans le but de faciliter la transition de votre animal
                    entre notre foyer et le vôtre. Les chatons sont manipulés dès leur plus jeune âge
                    et vivent en contact permanent avec nous — adultes, enfants — et les bruits du
                    quotidien. Nos retraités restent à la maison : Jag et Salambo vivent paisiblement
                    à la chatterie, en profitant de l'extérieur.
                </p>
                <p class="lede">
                    Nous nous efforçons de donner le plus d'amour possible à nos animaux, d'accompagner
                    leurs nouveaux propriétaires, et de nous assurer que ces précieuses créatures
                    recevront les soins et l'attention qu'elles méritent.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="band ink2">
    <div class="wrap">
        <x-section-head eyebrow="La lignée" titre="Nos reproducteurs"
            lede="Chaque chat a sa fiche complète : robe, pedigree, identification et résultats de dépistage." />
        <div class="repros">
            @foreach($chats as $chat)
                <x-cat-card :chat="$chat" />
            @endforeach
        </div>
    </div>
</section>

{{--
    La lignée.

    Trois générations nées sous le même toit, et c'est ce qu'aucun autre site
    d'élevage ne peut copier : Jag en 2014, ses filles Saphyr et Shiva en 2021,
    puis Ultime en 2023.

    Les rangs ne sont reliés que par un filet vertical, sans branche : le site
    Wix de l'élevage dit Jag « grand-père d'Ultime » sans nommer sa mère, et un
    arbre dessinerait une filiation qu'on ne connaît pas. Le jour où l'éleveuse
    la confirmera, il suffira de relier les portraits.
--}}
<section class="band">
    <div class="wrap">
        <x-section-head
            eyebrow="La lignée"
            titre="Trois générations sous le même toit"
            lede="Presque tous nos chats descendent de Jag, arrivé en 2014. Ses filles sont nées ici, sa petite-fille aussi, et la quatrième génération est déjà là." />

        <div class="lignee">
            @foreach(config('bengal.lignee') as $generation)
                <div class="lignee-rang">
                    <span class="lignee-cran">{{ $generation['rang'] }} · {{ $generation['annee'] }}</span>
                    <div class="lignee-chats">
                        @foreach($generation['chats'] as $slug)
                            @php($chat = $chats->firstWhere('slug', $slug))
                            @if($chat)
                                <a class="lignee-chat" href="{{ route('cats.show', $chat) }}">
                                    <span class="cadre" style="--format:1">
                                        <i><u>
                                            <img src="{{ asset($chat->photo_principale) }}"
                                                 alt="{{ $chat->nom }}, {{ \Illuminate\Support\Str::lower($chat->robe) }}"
                                                 loading="lazy" width="300" height="300">
                                        </u></i>
                                    </span>
                                    <b>{{ $chat->nom }}</b>
                                    <small>{{ $chat->role->libelle() }}</small>
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endforeach

            <p class="lignee-suite">
                <span class="lignee-trait" aria-hidden="true"></span>
                Armonie, née en mars 2025 d'Ukaïna et d'Unyk, reste à la chatterie.
                Elle sera reproductrice en 2026 — quatrième génération.
            </p>
        </div>
    </div>
</section>

<x-photo-band image="images/cats/bande-enclos.webp"
              legende="Une à deux portées par an, pas davantage"
              hauteur="44vh" />

<section class="band paper">
    <div class="wrap">
        <x-section-head eyebrow="En clair" titre="L'élevage en quatre chiffres" />
        <div class="facts">
            <div class="fact"><b data-count="2">0</b><span>Portées par an maximum</span></div>
            <div class="fact"><b data-count="{{ \App\Models\Litter::SEMAINES_AVANT_CESSION }}">0</b><span>Semaines minimum avant départ</span></div>
            <div class="fact"><b data-count="2">0</b><span>Visites avant réservation</span></div>
            <div class="fact"><b data-count="4">0</b><span>Dépistages par reproducteur</span></div>
        </div>
        <div class="btnrow" style="margin-top:36px">
            <a class="btn" href="{{ route('kittens.index') }}">Voir les chatons</a>
            <a class="btn ghost" href="{{ route('contact') }}">Venir nous voir</a>
        </div>
    </div>
</section>

@endsection
