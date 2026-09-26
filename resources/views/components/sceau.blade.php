@props(['taille' => 64, 'cercle' => true])

{{--
    Le sceau de la maison : le Ô du nom, réduit à sa géométrie.

    Un anneau pour le O, un chevron pour son accent. À seize pixels dans un
    onglet de navigateur comme à deux cents dans un pied de page, c'est la même
    marque, et elle ne ressemble à celle de personne d'autre — la plupart des
    élevages posent une patte de chat ou une couronne.

    « cercle » ajoute l'anneau extérieur, celui du sceau proprement dit : on le
    garde là où la marque est seule (le pied de page), on le retire là où elle
    n'est qu'un ornement.
--}}

<svg {{ $attributes->merge(['class' => 'sceau']) }}
     width="{{ $taille }}" height="{{ $taille }}" viewBox="0 0 64 64"
     fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
     aria-hidden="true">
    @if($cercle)
        <circle cx="32" cy="32" r="30" stroke-width="1" opacity=".45" />
    @endif
    <circle cx="32" cy="38" r="14" stroke-width="1.6" />
    <path d="M23.5 17.5 32 10l8.5 7.5" stroke-width="1.6" />
</svg>
