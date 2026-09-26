@props(['taille' => 'moyen'])

{{--
    Le fleuron d'Ô Coeur Blanc : un halo, et deux ailes qui s'en écartent.
    Dessiné au trait plutôt que posé en image — quelques centaines d'octets,
    net à toutes les tailles, et il prend la couleur courante : or sur la
    page blanche, encre là où on le voudrait discret.

    Trois tailles : « petit » pour une fin de bloc, « moyen » pour un titre
    de chapitre, « grand » pour l'ouverture d'une page.
--}}

@if($taille === 'petit')
    <svg {{ $attributes }} width="44" height="14" viewBox="0 0 44 14"
         fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" aria-hidden="true">
        <circle cx="22" cy="7" r="3" />
        <path d="M17 7c-2.5-3.5-6-4-9-2M27 7c2.5-3.5 6-4 9-2" />
        <path d="M14 7H2M42 7H30" />
    </svg>
@elseif($taille === 'grand')
    <svg {{ $attributes }} width="160" height="30" viewBox="0 0 160 30"
         fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <circle cx="80" cy="15" r="5.5" />
        <circle cx="80" cy="15" r="1.6" fill="currentColor" stroke="none" />
        <path d="M72 15c-6-9-15-12-25-8M72 15c-7-4-16-4-24 1M72 15c-5 1-11 4-15 9" />
        <path d="M88 15c6-9 15-12 25-8M88 15c7-4 16-4 24 1M88 15c5 1 11 4 15 9" />
        <path d="M42 15H6M154 15h-36" />
        <circle cx="46" cy="15" r="1.7" />
        <circle cx="114" cy="15" r="1.7" />
    </svg>
@else
    <svg {{ $attributes }} width="100" height="26" viewBox="0 0 100 26"
         fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <circle cx="50" cy="13" r="4.5" />
        <circle cx="50" cy="13" r="1.3" fill="currentColor" stroke="none" />
        <path d="M43 13c-5-7-12-9-19-6M43 13c-5-3-12-3-18 1M43 13c-4 1-8 4-11 8" />
        <path d="M57 13c5-7 12-9 19-6M57 13c5-3 12-3 18 1M57 13c4 1 8 4 11 8" />
        <path d="M16 13H2M98 13H84" />
    </svg>
@endif
