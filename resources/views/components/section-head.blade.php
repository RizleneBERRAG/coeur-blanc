@props([
    'eyebrow' => null,
    'titre',
    'lede'    => null,
    'centre'  => true,
    'gauche'  => false,
    'niveau'  => 2,
    'frise'   => true,
])

{{--
    L'en-tête d'un chapitre.

    niveau="1" sur le titre principal d'une page, 2 pour les sections
    suivantes : une page sans h1 ne dit pas à Google de quoi elle parle.
    L'échelle visuelle ne change pas — app.css ramène .chapitre h1 à la taille
    d'un h2, parce que la hiérarchie de la charte ne doit pas dépendre du
    niveau de balise.

    Le rang du chapitre (« II · La lignée ») est posé par un compteur CSS
    sur les seuls chapitres de niveau 2 : rien à écrire ici, et l'ordre reste
    juste le jour où une section s'ajoute. Le titre de page ouvre le livre,
    il ne se numérote pas.

    « centre » est gardé pour les gabarits hérités : la charte centre par
    défaut, « gauche » aligne à gauche là où le texte le réclame.
--}}

<div {{ $attributes->class(['chapitre', 'gauche' => $gauche, 'compte' => (int) $niveau === 2]) }}>
    @if($frise)
        <div class="frise"><x-fleuron :taille="(int) $niveau === 1 ? 'grand' : 'moyen'" /></div>
    @endif

    @if($eyebrow)
        <span class="numero">{{ $eyebrow }}</span>
    @endif

    <h{{ $niveau }}>{!! $titre !!}</h{{ $niveau }}>

    @if($lede)
        <p class="lede">{!! $lede !!}</p>
    @endif
</div>
