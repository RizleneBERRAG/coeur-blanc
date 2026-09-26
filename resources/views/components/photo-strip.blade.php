@props(['photos' => null, 'titre' => null])

@php
    /*
     * Le ruban ne montre que des CHATS. Les certificats et les diplômes vivent
     * dans la galerie, sous leur propre rubrique : en vignette, un document
     * scanné n'est pas une photo, et il cassait la bande.
     *
     * Sans liste fournie, on pioche au hasard : le ruban change à chaque visite.
     */
    $photos ??= \App\Models\Photo::publiees()
        ->whereIn('categorie', ['adultes', 'chatons', 'maison'])
        ->inRandomOrder()
        ->limit(14)
        ->get();
@endphp

@if($photos->isNotEmpty())
    <div class="strip" aria-label="{{ $titre ?? 'Photos de l’élevage' }}">
        {{-- La liste est dupliquée pour que le défilement boucle sans saut. --}}
        <div class="strip-rail">
            @foreach($photos->concat($photos) as $i => $photo)
                <a class="strip-item" href="{{ route('gallery') }}"
                   @if($i >= $photos->count()) aria-hidden="true" tabindex="-1" @endif>
                    <img src="{{ asset($photo->chemin) }}" alt="{{ $i < $photos->count() ? $photo->alt : '' }}" loading="lazy">
                    <span class="strip-cap">{{ $photo->legende }}</span>
                </a>
            @endforeach
        </div>
    </div>
@endif
