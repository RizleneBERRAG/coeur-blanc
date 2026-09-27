@props([
    'eyebrow' => null,
    'titre',
    'lede'    => null,
    'centre'  => true,
    'gauche'  => false,
    'niveau'  => 2,
    'frise'   => false,
])

{{--
    L'en-tête d'un chapitre.

    niveau="1" sur le titre principal d'une page, 2 pour les sections
    suivantes : une page sans h1 ne dit pas à Google de quoi elle parle.
    L'échelle visuelle ne change pas — app.css ramène .chapitre h1 à la taille
    d'un h2, parce que la hiérarchie de la charte ne doit pas dépendre du
    niveau de balise.

    Le chapitre s'accroche au fil par une étoile, et son rang (« II · La
    lignée ») se tient dans la marge de gauche. Les deux sont posés par
    app.css, à partir d'un compteur : rien à écrire ici, et l'ordre reste
    juste le jour où une section s'ajoute. Le titre de page ouvre le livre,
    il ne se numérote pas.

    « centre », « gauche » et « frise » ne servent plus à rien : la charte
    n'a plus qu'un seul alignement. Ils restent acceptés pour que les
    gabarits écrits avant ne cassent pas.
--}}

<div {{ $attributes->class(['chapitre', 'compte' => (int) $niveau === 2]) }}>
    @if($eyebrow)
        <span class="numero">{{ $eyebrow }}</span>
    @endif

    <h{{ $niveau }}>{!! $titre !!}</h{{ $niveau }}>

    @if($lede)
        <p class="lede">{!! $lede !!}</p>
    @endif
</div>
