<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

    <title>@yield('title', "Chatterie Ô Coeur Blanc") — Élevage de Bengal LOOF en Isère, entre Lyon et Grenoble</title>
    <meta name="description" content="@yield('description', "Chatterie Ô Coeur Blanc, élevage familial de chats Bengal LOOF à Meyrieu-les-Étangs (38), entre Lyon et Grenoble. Parents dépistés HCM, PK-Def, PRA-b et FIV/FeLV, chatons élevés à la maison.")">
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- La marque du logo, sur le papier du site. --}}
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-32.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/favicon-180.png') }}">

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Chatterie Ô Coeur Blanc">
    <meta property="og:locale" content="fr_FR">
    <meta property="og:title" content="@yield('title', "Chatterie Ô Coeur Blanc")">
    <meta property="og:description" content="@yield('description', "Élevage familial de chats Bengal LOOF en Isère, entre Lyon et Grenoble.")">
    <meta property="og:url" content="{{ url()->current() }}">
    @hasSection('og_image')
        <meta property="og:image" content="@yield('og_image')">
    @endif

    {{--
        Polices auto-hebergees dans public/fonts. Aucun appel a
        fonts.googleapis.com ni fonts.gstatic.com : la typographie tient sans
        reseau tiers, et aucun visiteur n'est trace. Les trois fichiers
        precharges sont ceux du premier ecran ; crossorigin est obligatoire
        meme en same-origin, une police etant toujours recuperee en mode CORS.
    --}}
    <link rel="preload" as="font" type="font/woff2" crossorigin
          href="{{ asset('fonts/cormorant-garamond-normal-300-latin.woff2') }}">
    <link rel="preload" as="font" type="font/woff2" crossorigin
          href="{{ asset('fonts/cinzel-normal-400-600-latin.woff2') }}">
    <link rel="preload" as="font" type="font/woff2" crossorigin
          href="{{ asset('fonts/jost-normal-300-500-latin.woff2') }}">
    <link rel="stylesheet" href="{{ asset('fonts/fonts.css') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
    @stack('schema')
</head>
<body>
    {{-- Le grain de la page : une tuile de bruit fixe, posee au-dessus du fond
         et sous tout le reste. C'est elle qui fait du blanc un papier. --}}
    <div id="grain" aria-hidden="true"></div>

    @include('partials.nav')

    <main id="app">
        @yield('content')
    </main>

    @include('partials.footer')

    @stack('scripts')
</body>
</html>
