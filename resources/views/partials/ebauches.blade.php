@php
    /*
     * La barre de choix des ebauches.
     *
     * Elle n'est incluse qu'en local (voir le gabarit) : c'est un outil de
     * decision, pas une piece du site. Le jour ou la direction est choisie,
     * on reporte ses valeurs dans app.css, et ce fichier comme
     * resources/css/ebauches.css disparaissent.
     *
     * Les liens gardent la page courante : on peut comparer les quatre sur
     * n'importe quelle page, pas seulement sur l'accueil.
     */
    $ebauches = [
        1 => 'Lumière',
        2 => 'Plein cadre',
        3 => 'Porcelaine',
        4 => 'Nacre et ciel',
    ];
    $courante = (int) request('ebauche', 1);
@endphp

<nav class="ebauches" aria-label="Choix de l’ébauche">
    <b>Ébauche</b>
    @foreach($ebauches as $numero => $nom)
        <a href="{{ request()->fullUrlWithQuery(['ebauche' => $numero]) }}"
           @if($numero === $courante) aria-current="page" @endif>{{ $numero }} · {{ $nom }}</a>
    @endforeach
</nav>
