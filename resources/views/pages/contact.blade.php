@extends('layouts.app')

@section('title', "Contact — venir voir les chatons")
@section('description', "Écrivez-nous ou appelez l'élevage Chatterie Ô Coeur Blanc à Meyrieu-les-Étangs (38), entre Lyon et Grenoble. Visites sur rendez-vous, réponse sous 48 heures.")

@push('scripts')
    @vite('resources/js/map.js')
@endpush

@php
    $tel    = \App\Models\Setting::get('contact.telephone');
    $mail   = \App\Models\Setting::get('contact.email');
    $fb     = \App\Models\Setting::get('contact.facebook');
    $insta  = \App\Models\Setting::get('contact.instagram');
@endphp

@section('content')

<section class="band">
    <div class="wrap">
        <x-section-head
            niveau="1"
            eyebrow="Contact"
            titre="Écrivez-nous, ou appelez"
            lede="Un appel vaut souvent mieux qu'un long formulaire — nous décrochons en soirée et le week-end. Si vous préférez écrire, tout est ci-dessous : réponse sous 48 heures." />

        <div class="two off" style="align-items:start">

            {{-- ---------------- formulaire ---------------- --}}
            <div id="formulaire">

                @if(session('succes'))
                    <p class="flash">{{ session('succes') }}</p>
                @endif

                @if($errors->any())
                    <div class="flash err">
                        Votre message n'a pas pu être envoyé :
                        <ul>
                            @foreach($errors->all() as $erreur)
                                <li>{{ $erreur }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form class="demo form-dark" method="POST" action="{{ route('contact.store') }}">
                    @csrf

                    {{-- Piege a robots : invisible pour un humain. --}}
                    <div style="position:absolute;left:-9999px" aria-hidden="true">
                        <label for="c-site">Site</label>
                        <input type="text" id="c-site" name="site" tabindex="-1" autocomplete="off">
                    </div>

                    <fieldset class="field full" style="border:0;padding:0;margin:0">
                        <legend style="padding:0;margin-bottom:11px"
                                class="mono" >Votre demande</legend>
                        <div class="objets">
                            @foreach($objets as $cle => $libelle)
                                <label for="c-objet-{{ $cle }}">
                                    <input type="radio" id="c-objet-{{ $cle }}" name="objet" value="{{ $cle }}"
                                           @checked(old('objet', 'adoption') === $cle)>
                                    <span>{{ $libelle }}</span>
                                </label>
                            @endforeach
                        </div>
                    </fieldset>

                    <div class="field">
                        <label for="c-prenom">Prénom</label>
                        <input id="c-prenom" name="prenom" type="text" autocomplete="given-name"
                               value="{{ old('prenom') }}" required>
                    </div>
                    <div class="field">
                        <label for="c-nom">Nom</label>
                        <input id="c-nom" name="nom" type="text" autocomplete="family-name" value="{{ old('nom') }}">
                    </div>
                    <div class="field">
                        <label for="c-email">Email</label>
                        <input id="c-email" name="email" type="email" autocomplete="email"
                               value="{{ old('email') }}" required>
                    </div>
                    <div class="field">
                        <label for="c-tel">Téléphone</label>
                        <input id="c-tel" name="telephone" type="tel" autocomplete="tel" value="{{ old('telephone') }}">
                    </div>

                    <div class="field full">
                        <label for="c-message">Votre message</label>
                        <textarea id="c-message" name="message" required
                                  placeholder="Dites-nous ce qui vous amène : un chaton en particulier, une visite, une question sur la race…">{{ old('message') }}</textarea>
                    </div>

                    <label class="consent" for="c-rgpd">
                        <input type="checkbox" id="c-rgpd" name="rgpd" value="1" @checked(old('rgpd'))>
                        <span>
                            J'accepte que Chatterie Ô Coeur Blanc conserve ces informations pour répondre à mon
                            message. Elles ne sont jamais transmises à un tiers et sont supprimées au bout
                            de {{ \App\Models\ContactMessage::MOIS_CONSERVATION }} mois.
                            <a href="{{ route('legal') }}">Politique de confidentialité</a>
                        </span>
                    </label>

                    <div class="full"><button class="btn" type="submit">Envoyer le message</button></div>
                </form>
            </div>

            {{-- ---------------- coordonnées ---------------- --}}
            <div class="stack" style="gap:20px">
                <x-record titre="Nous joindre directement">
                    <table>
                        <tr><th>Téléphone</th><td><a href="{{ \App\Models\Setting::telephoneLien() }}" style="color:var(--or-ombre);text-decoration:none">{{ $tel }}</a></td></tr>
                        <tr><th>Email</th><td><a href="mailto:{{ $mail }}" style="color:var(--or-ombre);text-decoration:none">{{ $mail }}</a></td></tr>
                        <tr><th>Visites</th><td>Sur rendez-vous, week-end et fin de journée</td></tr>
                        <tr><th>Réponse</th><td>Sous 48 heures maximum</td></tr>
                    </table>
                </x-record>

                <div class="socials">
                    @if($fb)
                        <x-social-link type="facebook" :url="$fb" />
                    @endif
                    @if($insta)
                        <x-social-link type="instagram" :url="$insta" handle="@ocoeurblanc" />
                    @endif
                    <x-social-link type="mail" :url="'mailto:'.$mail" :handle="$mail" />
                    <x-social-link type="tel" :url="\App\Models\Setting::telephoneLien()" :handle="$tel" />
                </div>

                <div class="btnrow">
                    <a class="btn" href="{{ \App\Models\Setting::telephoneLien() }}">Appeler l'élevage</a>
                    <a class="btn ghost" href="{{ route('adoption.create') }}">Demander une visite</a>
                </div>

                <figure class="figure" style="margin:0">
                    <img src="{{ asset('images/cats/portee-3.webp') }}"
                         alt="Deux chatons Bengal de la chatterie en plein jeu" loading="lazy">
                    <figcaption>Fin de journée à la maison</figcaption>
                </figure>
            </div>
        </div>
    </div>
</section>

{{-- ---------------- avis ---------------- --}}
{{--
    Temoignages de familles adoptantes, saisis dans le back-office ou deposes
    ici par les visiteurs. Trois regles tenues :
    - prenom seul, jamais de nom de famille, comme l'annonce la page Mentions
      legales — la table n'a d'ailleurs pas de colonne pour un nom ;
    - un avis depose arrive en attente et ne parait qu'apres relecture ;
    - pas de balisage schema.org Review : les regles de Google reservent les
      donnees structurees aux avis collectes par le site lui-meme, et un
      AggregateRating auto-declare se paie d'une penalite plutot que d'etoiles.
--}}
<section class="band paper tight" id="avis">
    <div class="wrap">
        <x-section-head
            eyebrow="Ils sont passés par là"
            titre="Ce que disent les familles"
            lede="Témoignages de familles adoptantes, publiés avec leur accord. Prénom seul — aucun nom de famille n'est publié sur ce site." />

        @if($avis->isNotEmpty())
            <div class="cells">
                @foreach($avis as $a)
                    <div class="cell-b">
                        <span class="n">{{ $a->etoiles() }}</span>
                        <p>{{ $a->texte }}</p>
                        <span class="n" style="margin-top:auto">{{ $a->prenom }}@if($a->publie_le) · {{ $a->publie_le->translatedFormat('F Y') }}@endif</span>
                    </div>
                @endforeach
            </div>
        @endif

        @if(session('succes_avis'))
            <p class="flash" style="margin-top:26px">{{ session('succes_avis') }}</p>
        @endif

        @if($errors->avis->any())
            <div class="flash err" style="margin-top:26px">
                Votre avis n'a pas pu être envoyé :
                <ul>
                    @foreach($errors->avis->all() as $erreur)
                        <li>{{ $erreur }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <details class="depot" @if(session('succes_avis') || $errors->avis->any()) open @endif>
            <summary>Vous avez adopté chez nous ? Laissez votre avis</summary>

            <form class="demo" method="POST" action="{{ route('reviews.store') }}">
                @csrf

                {{-- Piege a robots : invisible pour un humain. --}}
                <div style="position:absolute;left:-9999px" aria-hidden="true">
                    <label for="a-site">Site</label>
                    <input type="text" id="a-site" name="site" tabindex="-1" autocomplete="off">
                </div>

                <div class="field">
                    <label for="a-prenom">Prénom</label>
                    <input id="a-prenom" name="prenom" type="text" autocomplete="given-name"
                           value="{{ old('prenom') }}" maxlength="80" required>
                </div>

                <div class="field">
                    <label for="a-note">Note</label>
                    <select id="a-note" name="note" required>
                        @foreach([5 => '★★★★★', 4 => '★★★★☆', 3 => '★★★☆☆', 2 => '★★☆☆☆', 1 => '★☆☆☆☆'] as $v => $libelle)
                            <option value="{{ $v }}" @selected((int) old('note', 5) === $v)>{{ $libelle }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="field full" style="grid-column:1/-1">
                    <label for="a-email">Email <span style="text-transform:none;letter-spacing:0">— facultatif, jamais publié</span></label>
                    <input id="a-email" name="email" type="email" autocomplete="email"
                           value="{{ old('email') }}" maxlength="150"
                           placeholder="Pour vous recontacter si nous avons une question">
                </div>

                <div class="field full" style="grid-column:1/-1">
                    <label for="a-texte">Votre avis</label>
                    <textarea id="a-texte" name="texte" maxlength="1500" required
                              placeholder="Votre expérience avec l'élevage : la préparation, la visite, l'arrivée du chaton chez vous.">{{ old('texte') }}</textarea>
                </div>

                <label class="consent" for="a-rgpd">
                    <input type="checkbox" id="a-rgpd" name="rgpd" value="1" @checked(old('rgpd'))>
                    <span>
                        J'accepte que mon avis soit publié sur ce site sous mon prénom seul, et que
                        Chatterie Ô Coeur Blanc conserve mon adresse email si je l'ai renseignée, uniquement pour
                        me recontacter. Mon avis est relu avant publication.
                        <a href="{{ route('legal') }}">Politique de confidentialité</a>
                    </span>
                </label>

                <div class="btnrow" style="grid-column:1/-1">
                    <button class="btn" type="submit">Envoyer mon avis</button>
                </div>
            </form>
        </details>

        @if($avisGoogle = \App\Models\Setting::get('contact.avis_google'))
            <p style="margin-top:24px">
                <a class="tlink" href="{{ $avisGoogle }}" target="_blank" rel="noopener noreferrer">
                    Voir tous les avis sur Google
                </a>
            </p>
        @endif
    </div>
</section>

{{-- ---------------- carte ---------------- --}}
<section class="band ink2 tight">
    <div class="wrap">
        <x-section-head
            eyebrow="Venir jusqu'à nous"
            titre="Entre Lyon et Grenoble"
            lede="L'élevage est à Meyrieu-les-Étangs, en Isère, entre Lyon et Grenoble, proche des grands axes. L'adresse exacte vous est communiquée lors de la prise de rendez-vous — la carte situe la zone et les principaux accès." />

        {{--
            La carte et les temps de trajet côte à côte, et non l'un posé sur
            l'autre : l'encart faisait 491 px dans un cadre de 380, il
            débordait par le bas et les angles coupés du cadre le tranchaient.
            En deux colonnes, chacun prend la hauteur qu'il lui faut.
        --}}
        <div class="carte-bloc">
            <div class="mapwrap">
                <div id="carte" data-carte='@json($points)' role="application"
                     aria-label="Carte de situation de l'élevage à Meyrieu-les-Étangs"></div>
            </div>

            <div class="carte-infos">
                <x-record titre="Temps de trajet" meta="en voiture">
                    <table>
                        @foreach($points['reperes'] as $repere)
                            <tr><th>{{ $repere['titre'] }}</th><td>{{ $repere['detail'] }}</td></tr>
                        @endforeach
                    </table>
                </x-record>

                <p class="small">
                    Nous pouvons venir vous chercher à la gare de Bourgoin-Jallieu.
                </p>

                {{-- Les itinéraires visent la commune, pas l'adresse exacte :
                     celle-ci n'est donnée qu'au rendez-vous, et un trajet
                     porte-à-porte la publierait. --}}
                <div class="btnrow">
                    <a class="btn ghost" href="{{ $itineraire['google'] }}"
                       target="_blank" rel="noopener noreferrer"
                       aria-label="Itinéraire vers {{ $itineraire['commune'] }} sur Google Maps (nouvelle fenêtre)"
                       style="flex:1;justify-content:center">Google Maps</a>
                    <a class="btn ghost" href="{{ $itineraire['waze'] }}"
                       target="_blank" rel="noopener noreferrer"
                       aria-label="Itinéraire vers {{ $itineraire['commune'] }} sur Waze (nouvelle fenêtre)"
                       style="flex:1;justify-content:center">Waze</a>
                </div>
            </div>
        </div>

        <p class="small" style="margin-top:16px">
            Carte &copy; OpenStreetMap et CARTO. Aucun traceur publicitaire n'est chargé sur cette page :
            les liens d'itinéraire ouvrent Google Maps ou Waze dans un nouvel onglet, rien n'est chargé depuis eux ici.
        </p>
    </div>
</section>

@endsection
