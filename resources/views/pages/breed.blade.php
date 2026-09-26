@extends('layouts.app')

@section('title', "Le chat Bengal — robe, caractère, origines")
@section('description', "Tout sur le Bengal avant d'en accueillir un : origines, lecture de la robe (rosettes, glitter, ligne dorsale), motifs, couleurs et caractère réel de la race.")

@section('content')

<section class="band">
    <div class="wrap">
        <x-section-head
            niveau="1"
            eyebrow="La race"
            titre="Le Bengal"
            lede="Une robe sauvage sur un chat de salon. Ce qu'il faut savoir avant d'en accueillir un — y compris ce qui pourrait vous faire changer d'avis." />

        <div class="two rev">
            <figure class="figure">
                <img src="{{ asset('images/cats/saphyr-4.webp') }}" alt="Saphyr, Bengal brown tabby rosetted de la chatterie, allongée parmi des feuilles d'automne">
                <figcaption>Brown tabby rosetted — rosettes, glitter, fond chaud</figcaption>
            </figure>
            <div class="stack">
                <h3>Une race née en Californie</h3>
                <p class="lede">
                    Le Bengal est issu du croisement entre le chat léopard du Bengale
                    (<em class="it">Prionailurus bengalensis</em>) et des chats domestiques, travaillé par
                    Jean S. Mill à partir des années 1960. La race est reconnue par la TICA en 1983 et
                    arrive en France dans les années 1990.
                </p>
                <p class="lede">
                    Les chatons vendus en élevage sont au minimum de quatrième génération : ce sont des
                    chats domestiques à part entière, sans aucune restriction réglementaire.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="band ink2">
    <div class="wrap">
        <x-section-head
            eyebrow="Lire une robe"
            titre="Cinq points qu'un juge regarde"
            lede="Cliquez sur les repères pour comprendre le vocabulaire qu'on utilise dans les fiches de nos chatons." />

        @php($reperes = config('bengal.robe'))

        <div style="max-width:940px">
            <div class="coat" id="coat" data-points="{{ json_encode(collect($reperes)->map(fn ($r) => ['k' => $r['categorie'], 't' => $r['titre'], 'd' => $r['texte']]), JSON_UNESCAPED_UNICODE) }}">
                <img src="{{ asset('images/cats/robe.webp') }}" alt="Saphyr de profil : rosettes, ligne dorsale, masque et colliers bien visibles">
                @foreach($reperes as $i => $r)
                    <button class="hot" type="button"
                            style="left:{{ $r['x'] }}%;top:{{ $r['y'] }}%"
                            data-coat="{{ $i }}"
                            aria-pressed="{{ $i === 0 ? 'true' : 'false' }}"
                            aria-label="{{ $r['titre'] }}"><span class="ring"></span></button>
                @endforeach
            </div>
            <div class="coatinfo" id="coatinfo">
                {{-- Rempli par app.js ; contenu de repli si le JS ne tourne pas. --}}
                <span class="k">{{ $reperes[0]['categorie'] }}</span>
                <h3>{{ $reperes[0]['titre'] }}</h3>
                <p>{{ $reperes[0]['texte'] }}</p>
            </div>
        </div>
    </div>
</section>

<section class="band">
    <div class="wrap">
        <x-section-head eyebrow="Les motifs" titre="Spotted, rosetted, marbled"
            lede="Trois familles de motifs, et une couleur de fond qui change tout." />
        <div class="cells">
            <div class="cell-b"><span class="n">MOTIF</span><h3>Spotted</h3><p>Des taches pleines, d'un seul ton, réparties horizontalement. C'est le motif le plus courant, et la base de tous les autres.</p></div>
            <div class="cell-b"><span class="n">MOTIF</span><h3>Rosetted</h3><p>Chaque tache est cerclée d'un contour plus foncé. Rosette en flèche, en patte d'ours, en donut : plus le cercle est fermé, plus le travail de sélection est abouti.</p></div>
            <div class="cell-b"><span class="n">MOTIF</span><h3>Marbled</h3><p>De grands aplats horizontaux en marbrures, sans alignement vertical ni motif en cible. Plus rare dans nos portées.</p></div>
            <div class="cell-b"><span class="n">COULEUR</span><h3>Le fond</h3><p>Du fond doré classique au snow aux yeux aqua, en passant par le silver et le masque charcoal. Une même portée peut en contenir plusieurs.</p></div>
        </div>
    </div>
</section>

<section class="band">
    <div class="wrap">
        <x-section-head
            eyebrow="Les robes de la maison"
            titre="Quatre robes, quatre chats"
            lede="Le standard de la race en admet beaucoup. Voici celles que nous travaillons, et le chat qui la porte chez nous." />

        <div class="robes">
            @foreach(config('bengal.robes_maison') as $robe)
                @php($chat = \App\Models\Cat::publies()->where('slug', $robe['chat'])->first())
                @if($chat)
                    <a class="robe" href="{{ route('cats.show', $chat) }}">
                        <span class="cadre" style="--format:4/5">
                            <i><u>
                                <img src="{{ asset($chat->photo_principale) }}"
                                     alt="{{ $chat->nom }}, Bengal {{ \Illuminate\Support\Str::lower($robe['nom']) }}"
                                     loading="lazy" width="400" height="500">
                            </u></i>
                        </span>
                        <b>{{ $robe['nom'] }}</b>
                        <small>chez nous&nbsp;: {{ \Illuminate\Support\Str::ucfirst(\Illuminate\Support\Str::lower($chat->nom)) }}</small>
                        <p>{{ $robe['texte'] }}</p>
                    </a>
                @endif
            @endforeach
        </div>
    </div>
</section>

<div class="band tight" style="padding-block:clamp(22px,3vw,36px)">
    <x-photo-strip titre="Robes et motifs" />
</div>

<section class="band paper">
    <div class="wrap">
        <x-section-head
            eyebrow="Le caractère"
            titre="Ce n'est pas un chat tranquille"
            lede="Autant le dire tout de suite : si vous cherchez un chat qui dort seize heures par jour sur un radiateur, le Bengal n'est pas fait pour vous." />
        <div class="cells">
            <div class="cell-b"><h3>Il parle</h3><p>Beaucoup. Il commente vos déplacements, réclame, et répond quand on lui adresse la parole. C'est charmant les six premiers mois, et il faut aimer ça.</p></div>
            <div class="cell-b"><h3>Il grimpe</h3><p>Prévoyez de la hauteur : arbre à chat solide, étagères libérées, et acceptez qu'il soit souvent au-dessus de vous, y compris sur le réfrigérateur.</p></div>
            <div class="cell-b"><h3>Il joue avec l'eau</h3><p>Robinet, douche, gamelle renversée. C'est une constante de la race, pas une excentricité individuelle.</p></div>
            <div class="cell-b"><h3>Il vit longtemps</h3><p>Douze à seize ans en bonne santé. C'est un engagement sur une durée, pas une décoration d'intérieur.</p></div>
        </div>
        <div class="btnrow" style="margin-top:36px">
            <a class="btn" href="{{ route('kittens.index') }}">Voir les chatons disponibles</a>
            <a class="btn ghost" href="{{ route('faq') }}">Questions fréquentes</a>
        </div>
    </div>
</section>

@endsection
