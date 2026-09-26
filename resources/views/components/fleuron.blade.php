@props(['taille' => 'moyen'])

{{--
    Le fleuron d'Ô Coeur Blanc : une auréole, et deux ailes qui s'en écartent.

    Dessiné au trait plutôt que posé en image — quelques centaines d'octets, net
    à toutes les tailles, et il prend la couleur courante. Les traits sont fins
    (0,9 px) et les ailes s'ouvrent largement : c'est ce qui le tient du côté de
    l'emblème plutôt que de l'autocollant. Ne pas épaissir.

    Trois tailles : « petit » pour une fin de bloc, « moyen » pour un titre
    de chapitre, « grand » pour l'ouverture d'une page.
--}}

@if($taille === 'petit')
    <svg {{ $attributes }} width="56" height="16" viewBox="0 0 56 16"
         fill="none" stroke="currentColor" stroke-width=".9" stroke-linecap="round" aria-hidden="true">
        <circle cx="28" cy="8" r="2.8" />
        <circle cx="28" cy="8" r=".8" fill="currentColor" stroke="none" />
        <path d="M24 6C18 2.5 11 2 5 4" />
        <path d="M24 8.5C17 6.5 9 7 3 9" />
        <path d="M32 6c6-3.5 13-4 19-2" />
        <path d="M32 8.5c7-2 15-1.5 21 .5" />
    </svg>
@elseif($taille === 'grand')
    <svg {{ $attributes }} width="170" height="34" viewBox="0 0 170 34"
         fill="none" stroke="currentColor" stroke-width=".9" stroke-linecap="round" aria-hidden="true">
        <circle cx="85" cy="17" r="5.5" />
        <circle cx="85" cy="17" r="1.3" fill="currentColor" stroke="none" />
        <path d="M78 13C66 4 48 2 32 7" />
        <path d="M78 17C64 12 44 11 26 15" />
        <path d="M78 21c-12 6-28 8-42 6" />
        <path d="M92 13c12-9 30-11 46-6" />
        <path d="M92 17c14-5 34-6 52-2" />
        <path d="M92 21c12 6 28 8 42 6" />
    </svg>
@else
    <svg {{ $attributes }} width="110" height="26" viewBox="0 0 110 26"
         fill="none" stroke="currentColor" stroke-width=".9" stroke-linecap="round" aria-hidden="true">
        <circle cx="55" cy="13" r="4.2" />
        <circle cx="55" cy="13" r="1.1" fill="currentColor" stroke="none" />
        <path d="M49 10C40 3.5 27 2 16 5.5" />
        <path d="M49 13C39 9 25 8.5 12 11.5" />
        <path d="M49 16c-9 4.5-21 6-31 4.5" />
        <path d="M61 10c9-6.5 22-8 33-4.5" />
        <path d="M61 13c10-4 24-4.5 37-1.5" />
        <path d="M61 16c9 4.5 21 6 31 4.5" />
    </svg>
@endif
