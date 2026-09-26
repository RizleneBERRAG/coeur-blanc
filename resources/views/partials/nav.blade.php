@php
    $tel   = \App\Models\Setting::get('contact.telephone', '06 16 24 45 49');
    $fb    = \App\Models\Setting::get('contact.facebook');
    $insta = \App\Models\Setting::get('contact.instagram');
@endphp

<header class="nav" id="nav">
    <div class="wrap navin">
        <a class="brand" href="{{ route('home') }}">
            <b>Ô Coeur Blanc</b>
            <small>Chatterie de Bengal · Isère</small>
        </a>

        <nav class="menu" id="menu" aria-label="Navigation principale">
            <a href="{{ route('kittens.index') }}" @if(request()->routeIs('kittens.*')) aria-current="page" @endif>Nos chatons</a>
            <a href="{{ route('cats.index') }}"    @if(request()->routeIs('cats.*'))    aria-current="page" @endif>L'élevage</a>
            <a href="{{ route('breed') }}"         @if(request()->routeIs('breed'))     aria-current="page" @endif>Le Bengal</a>
            <a href="{{ route('gallery') }}"       @if(request()->routeIs('gallery'))   aria-current="page" @endif>Galerie</a>
            <a href="{{ route('adoption.create') }}" @if(request()->routeIs('adoption.*')) aria-current="page" @endif>Adopter</a>
            <a href="{{ route('faq') }}"           @if(request()->routeIs('faq'))       aria-current="page" @endif>Questions</a>
            <a href="{{ route('contact') }}"       @if(request()->routeIs('contact'))   aria-current="page" @endif>Contact</a>

            {{-- Pied du panneau, affiche seulement quand le menu EST un panneau.
                 Sous 1100px le bandeau masque le numero et les icones sociales :
                 sans ce bloc, le telephone — la facon dont on joint un elevage —
                 disparait de toute la navigation. --}}
            <div class="menu-pied">
                <a class="menu-appel" href="{{ \App\Models\Setting::telephoneLien() }}">
                    <span class="k">Appeler l'élevage</span>
                    <span class="v">{{ $tel }}</span>
                </a>
                @if($fb || $insta)
                    <div class="menu-reseaux">
                        @if($fb)
                            <a href="{{ $fb }}" target="_blank" rel="noopener noreferrer">Facebook</a>
                        @endif
                        @if($insta)
                            <a href="{{ $insta }}" target="_blank" rel="noopener noreferrer">Instagram</a>
                        @endif
                    </div>
                @endif
            </div>
        </nav>

        <div class="navcta">
            @if($fb)
                <x-social-link type="facebook" :url="$fb" />
            @endif
            @if($insta)
                <x-social-link type="instagram" :url="$insta" handle="@ocoeurblanc" />
            @endif
            <a class="tel" href="{{ \App\Models\Setting::telephoneLien() }}">{{ $tel }}</a>
            {{-- L'intitule suit aria-expanded, que le script tient a jour. --}}
            <button class="burger" id="burger" type="button" aria-expanded="false" aria-controls="menu">
                <span class="b-ouvrir">Menu</span>
                <span class="b-fermer">Fermer</span>
            </button>
        </div>
    </div>

    {{-- Jauge de lecture : un filet d'or sur le bord bas du bandeau, rempli
         par la position de la page. Purement decoratif. --}}
    <span id="jauge" aria-hidden="true"></span>
</header>
