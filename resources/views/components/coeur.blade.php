@props(['taille' => 22])

{{--
    Le cœur du logo, isolé.

    C'est l'ornement du site, et il n'est pas inventé : il est repris du logo
    de la chatterie, où il se tient au creux de l'ovale du Ô. Plein, jamais en
    contour — c'est ainsi qu'il est dessiné dans la marque.

    Il sert de nœud au fil de lumière, à chaque chapitre, et d'ornement partout
    où une fin de bloc demande une signature.
--}}

<svg {{ $attributes->merge(['class' => 'coeur']) }}
     width="{{ $taille }}" height="{{ round($taille * 0.92) }}" viewBox="0 0 24 22"
     fill="currentColor" aria-hidden="true">
    <path d="M12 21.4S1.4 14.1 1.4 7.3C1.4 3.9 4 1.3 7.3 1.3c2.1 0 4 1.2 4.7 3 .7-1.8 2.6-3 4.7-3 3.3 0 5.9 2.6 5.9 6 0 6.8-10.6 14.1-10.6 14.1Z"/>
</svg>
