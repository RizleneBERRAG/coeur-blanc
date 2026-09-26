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
        <dl>
            <dt>Sexe</dt><dd>{{ \Illuminate\Support\Str::ucfirst($chaton->sexe) }}</dd>
            <dt>Robe</dt><dd>{{ $chaton->robe }}</dd>
            <dt>Né le</dt><dd>{{ $chaton->litter->date_naissance->translatedFormat('j F Y') }}</dd>
        </dl>
        <span class="go">Voir la fiche complète</span>
    </span>
</a>
