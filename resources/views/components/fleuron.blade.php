@props(['taille' => 'moyen'])

{{--
    L'emblème d'Ô Coeur Blanc : un cœur ailé.

    Le nom de la chatterie vient de Maina, la petite chatte snow par qui tout a
    commencé et qui est partie rejoindre les étoiles. Le cœur est donc le mot du
    nom, et les ailes disent le reste. C'est un motif d'ex-voto, vieux comme les
    chapelles — dessiné au trait de 0,9 px il reste du côté de l'emblème et non
    de l'autocollant. Ne pas épaissir, ne pas remplir le cœur : c'est un cœur
    BLANC, il est ouvert.

    Trois tailles : « petit » pour une fin de bloc, « moyen » pour un titre de
    chapitre, « grand » pour l'ouverture d'une page.
--}}

@if($taille === 'petit')
    <svg {{ $attributes }} width="58" height="16" viewBox="0 0 58 16"
         fill="none" stroke="currentColor" stroke-width=".9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <path d="M29 12.4c0 0-4.6-3.4-4.6-5.9 0-1.3 1-2.4 2.3-2.4.9 0 1.8.5 2.3 1.4.5-.9 1.4-1.4 2.3-1.4 1.3 0 2.3 1.1 2.3 2.4 0 2.5-4.6 5.9-4.6 5.9Z" />
        <path d="M22.6 6.3C17 2.8 10 2.4 4 4.4" />
        <path d="M22.6 9.2C16 7.6 9 8.2 3 10.2" />
        <path d="M35.4 6.3C41 2.8 48 2.4 54 4.4" />
        <path d="M35.4 9.2C42 7.6 49 8.2 55 10.2" />
    </svg>
@elseif($taille === 'grand')
    <svg {{ $attributes }} width="176" height="34" viewBox="0 0 176 34"
         fill="none" stroke="currentColor" stroke-width=".9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <path d="M88 24.6c0 0-9.4-6.8-9.4-11.7 0-2.6 2-4.6 4.5-4.6 1.9 0 3.6 1.1 4.9 2.9 1.3-1.8 3-2.9 4.9-2.9 2.5 0 4.5 2 4.5 4.6 0 4.9-9.4 11.7-9.4 11.7Z" />
        <path d="M75 11.5C62.5 3 44 1 28 6" />
        <path d="M74.6 16C60 11 40 10 22 14" />
        <path d="M75 20.5C63 26.5 47 28.5 33 26.5" />
        <path d="M101 11.5C113.5 3 132 1 148 6" />
        <path d="M101.4 16C116 11 136 10 154 14" />
        <path d="M101 20.5c12 6 28 8 42 6" />
    </svg>
@else
    <svg {{ $attributes }} width="114" height="26" viewBox="0 0 114 26"
         fill="none" stroke="currentColor" stroke-width=".9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <path d="M57 19c0 0-7-5.1-7-8.8 0-2 1.5-3.5 3.4-3.5 1.4 0 2.7.8 3.6 2.2.9-1.4 2.2-2.2 3.6-2.2 1.9 0 3.4 1.5 3.4 3.5 0 3.7-7 8.8-7 8.8Z" />
        <path d="M47.5 8.6C38 2.4 24.5 1 12.5 4.4" />
        <path d="M47.2 12.4C36.5 8.6 22 8 8.5 10.8" />
        <path d="M47.5 16.1C38.5 20.6 26 22 15.5 20.3" />
        <path d="M66.5 8.6C76 2.4 89.5 1 101.5 4.4" />
        <path d="M66.8 12.4C77.5 8.6 92 8 105.5 10.8" />
        <path d="M66.5 16.1c9 4.5 21.5 5.9 32 4.2" />
    </svg>
@endif
