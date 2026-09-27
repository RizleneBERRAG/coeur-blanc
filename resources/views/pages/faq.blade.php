@extends('layouts.app')

@section('title', "Questions fréquentes sur l'adoption d'un Bengal")
@section('description', "Âge de départ, tarif, compatibilité avec les enfants et les chiens, vie en appartement, LOOF, allergies : les réponses complètes avant d'adopter un Bengal.")

@push('schema')
{{-- Le tableau est construit dans un bloc php ci-dessous, et non directement
     dans l'expression d'affichage. Blade compile la directive de contexte meme
     au milieu d'un tableau PHP : la cle arobase-context etait remplacee par du
     code compile, et le JSON-LD sortait inexploitable. Les blocs php sont mis
     de cote avant la compilation des directives, donc la cle y survit.
     Ne pas remettre ce tableau dans l'expression d'affichage.
     Et ne pas ecrire de directive Blade dans ce commentaire : elle serait
     compilee elle aussi. --}}
@php
    $schema = [
    '@context'   => 'https://schema.org',
    '@type'      => 'FAQPage',
    'mainEntity' => $faqs->map(fn ($f) => [
        '@type' => 'Question',
        'name'  => $f->question,
        'acceptedAnswer' => ['@type' => 'Answer', 'text' => strip_tags($f->reponse)],
    ])->values(),
];
@endphp
<script type="application/ld+json">
{!! json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>
@endpush

@section('content')

<section class="band paper">
    <div class="wrap">
        <x-section-head
            niveau="1"
            eyebrow="Questions fréquentes"
            titre="Ce qu'on nous demande le plus"
            lede="Les réponses complètes, y compris celles qui pourraient vous faire renoncer. On préfère que vous renonciez avant qu'après." />

        <div class="faqwrap">
            <div>
                <div class="faq">
                    {{-- Chaque question porte son ancre : l'eleveuse peut repondre a
                         un courriel par un lien direct vers la bonne reponse, et un
                         moteur peut y envoyer sans faire chercher. --}}
                    @foreach($faqs as $faq)
                        @php($ancre = 'q-'.\Illuminate\Support\Str::slug($faq->question))
                        <details id="{{ $ancre }}" @if($loop->first) open @endif>
                            <summary>{{ $faq->question }}</summary>
                            <div class="ans">{!! $faq->reponse !!}</div>
                        </details>
                    @endforeach
                </div>
                <div class="btnrow" style="margin-top:40px">
                    <a class="btn" href="{{ route('contact') }}">Poser une autre question</a>
                    <a class="btn ghost" href="{{ \App\Models\Setting::telephoneLien() }}">{{ \App\Models\Setting::get('contact.telephone') }}</a>
                </div>
            </div>
            <aside class="aside">
                <x-fleuron taille="petit" style="color:var(--or-mat)" />
                <h4>Votre question n'y est pas ?</h4>
                <p>Appelez-nous. On répond plus volontiers au téléphone qu'en trois lignes, surtout quand il s'agit de savoir si un Bengal est fait pour vous.</p>
                <a class="btn" href="{{ \App\Models\Setting::telephoneLien() }}" style="justify-content:center">{{ \App\Models\Setting::get('contact.telephone') }}</a>
                <a class="tlink" href="{{ route('adoption.create') }}">Demander une visite</a>
            </aside>
        </div>
    </div>
</section>

<div class="band tight" style="padding-block:clamp(22px,3vw,36px)">
    <x-photo-strip titre="L'élevage en images" />
</div>

@endsection
