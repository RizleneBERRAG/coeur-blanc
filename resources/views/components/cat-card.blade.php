@props(['chat'])

<a class="repro" href="{{ route('cats.show', $chat) }}">
    <span class="cadre petite">
        <i><u>
            <img src="{{ asset($chat->photo_principale) }}"
                 alt="{{ $chat->nom }}, Bengal {{ \Illuminate\Support\Str::lower($chat->robe) }}"
                 loading="lazy" width="1100" height="1467">
        </u></i>
    </span>
    <span class="cap">
        <span class="mono">{{ $chat->role->libelle() }}</span>
        <h3>{{ $chat->nom }}</h3>
        <p>{{ $chat->robe }} · {{ $chat->sexe_libelle }} · {{ $chat->annee_naissance }}</p>
    </span>
</a>
