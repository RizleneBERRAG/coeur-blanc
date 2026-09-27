@props(['chaton'])

<a {{ $attributes->merge(['class' => 'fiche'.($chaton->statut === \App\Enums\KittenStatus::Adopte ? ' gone' : '')]) }}
   data-statut="{{ $chaton->statut->value }}"
   href="{{ route('kittens.show', $chaton) }}">
    {{-- Le cadre : un filet d'or, une marie-louise blanche, la photo. La
         pastille de statut se pose dessus, en haut du cadre. --}}
    <span class="cadre petite">
        <x-chip :statut="$chaton->statut" />
        <i><u>
            <img src="{{ asset($chaton->photo_principale) }}"
                 alt="{{ $chaton->nom }}, chaton Bengal {{ \Illuminate\Support\Str::lower($chaton->robe) }}"
                 loading="lazy" width="900" height="1200">
        </u></i>
    </span>
    <span class="bd">
        <span class="nm"><h3>{{ $chaton->nom }}</h3><span class="ref">{{ $chaton->reference }}</span></span>
        {{-- Chaque couple est enveloppé dans un div — c'est valide dans une
             liste de définitions, et c'est ce qui permet la conduite de
             points entre l'intitulé et la valeur. --}}
        <dl>
            <div><dt>Sexe</dt><dd>{{ $chaton->sexe_libelle }}</dd></div>
            <div><dt>Robe</dt><dd>{{ $chaton->robe }}</dd></div>
            <div><dt>Né le</dt><dd>{{ $chaton->litter->date_naissance->translatedFormat('j F Y') }}</dd></div>
        </dl>
        <span class="go">Voir la fiche complète</span>
    </span>
</a>
