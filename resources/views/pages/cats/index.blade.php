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
                <p class="lede">
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

<x-photo-band image="images/cats/banniere.webp"
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
