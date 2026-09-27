<?php

namespace App\Filament\Widgets;

use App\Enums\KittenStatus;
use App\Models\AdoptionRequest;
use App\Models\ContactMessage;
use App\Models\Kitten;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

/**
 * Ce qu'il y a a faire, des l'ouverture.
 *
 * Le tableau de bord n'affichait que « Bonjour ». Sur un ordinateur ce n'est
 * qu'un vide ; sur un telephone, c'est tout l'ecran. L'eleveuse ouvre le
 * back-office entre deux choses, souvent depuis son telephone : elle doit voir
 * en une seconde ce qui attend, et pouvoir y aller d'un doigt.
 *
 * Quatre chiffres, choisis pour ce qu'ils declenchent, pas pour la statistique :
 * un chaton en brouillon ne se vend pas, un message sans reponse non plus.
 */
class OuEnEstOn extends StatsOverviewWidget
{
    protected static ?int $sort = -1;

    protected function getStats(): array
    {
        $enLigne    = Kitten::publies()->count();
        $brouillons = Kitten::query()->whereNotIn('id', Kitten::publies()->select('id'))->count();
        $messages   = ContactMessage::where('est_traite', false)->count();
        $demandes   = AdoptionRequest::where('statut', 'nouveau')->count();

        return [
            Stat::make('Chatons en ligne', $enLigne)
                ->description($enLigne > 0 ? 'Visibles du public' : 'Aucune fiche publiée')
                ->color($enLigne > 0 ? 'success' : 'gray')
                ->url(route('filament.admin.resources.kittens.index')),

            Stat::make('Fiches en brouillon', $brouillons)
                ->description($brouillons > 0 ? 'Numéro ICAD ou LOOF manquant' : 'Rien en attente')
                ->color($brouillons > 0 ? 'warning' : 'gray')
                ->url(route('filament.admin.resources.kittens.index')),

            Stat::make('Messages à traiter', $messages)
                ->description($messages > 0 ? 'Sans réponse' : 'Boîte à jour')
                ->color($messages > 0 ? 'danger' : 'gray')
                ->url(route('filament.admin.resources.contact-messages.index')),

            Stat::make('Demandes d’adoption', $demandes)
                ->description($demandes > 0 ? 'Nouvelles, non ouvertes' : 'Rien de nouveau')
                ->color($demandes > 0 ? 'danger' : 'gray')
                ->url(route('filament.admin.resources.adoption-requests.index')),
        ];
    }
}
