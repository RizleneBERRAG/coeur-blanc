<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Photo extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'est_couverture' => 'boolean',
            'est_publiee'    => 'boolean',
        ];
    }

    /**
     * Les dimensions sont relevees des que le chemin change — depot par le
     * back-office comme passage de photos:sync. Elles servent a reserver la
     * place dans la galerie : sans elles, la grille se reorganise a chaque
     * image qui arrive.
     */
    protected static function booted(): void
    {
        static::saving(function (self $photo) {
            if (! $photo->isDirty('chemin') || blank($photo->chemin)) {
                return;
            }

            $fichier = public_path($photo->chemin);
            $taille = is_file($fichier) ? @getimagesize($fichier) : false;

            $photo->largeur = $taille[0] ?? null;
            $photo->hauteur = $taille[1] ?? null;
        });
    }

    public function attachable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Volontairement SANS tri, contrairement aux autres scopes publics : deux
     * appelants veulent un ordre aleatoire — la mosaique de l'accueil et le ruban
     * defilant. Un orderBy pose ici passerait devant leur inRandomOrder() et le
     * hasard disparaitrait. Les appelants trient donc eux-memes, et ils le font
     * tous.
     */
    public function scopePubliees($query)
    {
        return $query->where('est_publiee', true);
    }
}
