@php
    $tel   = \App\Models\Setting::get('contact.telephone', '06 16 24 45 49');
    $mail  = \App\Models\Setting::get('contact.email', 'les.aristocats@outlook.fr');
    $fb    = \App\Models\Setting::get('contact.facebook');
    $insta = \App\Models\Setting::get('contact.instagram');
    $siren = \App\Models\Setting::get('legal.siren');
    $ville = \App\Models\Setting::get('elevage.ville', 'Meyrieu-les-Étangs');
    $cp    = \App\Models\Setting::get('elevage.code_postal', '38440');
@endphp

<footer>
    <div class="wrap">
        <div class="fgrid">
            <div>
                <h4>Chatterie Ô Coeur Blanc</h4>
                <p class="small" style="max-width:36ch">
                    Élevage familial de chats Bengal LOOF à {{ $ville }} ({{ $cp }}), en Isère,
                    entre Lyon et Grenoble. Parents dépistés, chatons élevés à la maison depuis 2019.
                </p>
                <div class="frise"><x-fleuron taille="petit" /></div>
            </div>
            <div>
                <h4>L'élevage</h4>
                <ul>
                    <li><a href="{{ route('kittens.index') }}">Chatons disponibles</a></li>
                    <li><a href="{{ route('cats.index') }}">Nos reproducteurs</a></li>
                    <li><a href="{{ route('gallery') }}">Galerie</a></li>
                    <li><a href="{{ route('breed') }}">La race Bengal</a></li>
                </ul>
            </div>
            <div>
                <h4>Adopter</h4>
                <ul>
                    <li><a href="{{ route('adoption.create') }}">Le parcours</a></li>
                    <li><a href="{{ route('adoption.create') }}#couverture">Ce que couvre l'adoption</a></li>
                    <li><a href="{{ route('faq') }}">Questions fréquentes</a></li>
                    <li><a href="{{ route('legal') }}">Mentions légales &amp; RGPD</a></li>
                </ul>
            </div>
            <div>
                <h4>Nous joindre</h4>
                <div class="fcontact">
                    <a class="fcontact-item" href="{{ \App\Models\Setting::telephoneLien() }}">
                        <span class="k">Téléphone</span>
                        <span class="v">{{ $tel }}</span>
                    </a>
                    <a class="fcontact-item mail" href="mailto:{{ $mail }}">
                        <span class="k">Email</span>
                        <span class="v">{{ $mail }}</span>
                    </a>
                </div>
                <ul>
                    <li><a href="{{ route('contact') }}">Venir nous voir</a></li>
                </ul>
                <div class="socials" style="margin-top:20px">
                    @if($fb)
                        <x-social-link type="facebook" :url="$fb" />
                    @endif
                    @if($insta)
                        <x-social-link type="instagram" :url="$insta" handle="@ocoeurblanc" />
                    @endif
                    <x-social-link type="mail" :url="'mailto:'.$mail" :handle="$mail" />
                    <x-social-link type="tel" :url="\App\Models\Setting::telephoneLien()" :handle="$tel" />
                </div>
            </div>
        </div>
        <div class="fbot">
            <span>© {{ date('Y') }} Chatterie Ô Coeur Blanc — Certificat de capacité · SIREN {{ $siren ?? 'à compléter' }}</span>
            <span>{{ $ville }} · Isère</span>
        </div>
    </div>
</footer>
