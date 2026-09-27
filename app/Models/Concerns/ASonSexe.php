<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Casts\Attribute;

/**
 * Le sexe d'un chat, en base et a l'ecran.
 *
 * En base, deux valeurs et deux seulement : « male » et « femelle », sans
 * accent. C'est une CLE, pas un libelle : le formulaire du back-office la
 * compare en PHP, et une comparaison PHP ne pardonne pas l'accent circonflexe.
 * Le jour ou « male » est devenu « male » a l'enregistrement, la liste
 * deroulante du back-office s'est videe et la colonne « Sexe » a affiche
 * « Femelle » pour tous les males : aucune erreur nulle part, juste deux
 * chaines qui ne se ressemblaient plus.
 *
 * L'accent appartient a l'affichage. Il est pose ici, au seul endroit ou il
 * doit l'etre, et les gabarits demandent sexe_libelle et non sexe.
 */
trait ASonSexe
{
    /** La valeur rangee en base, quoi qu'on lui donne. */
    public static function cleSexe(?string $valeur): ?string
    {
        if ($valeur === null) {
            return null;
        }

        return str_starts_with(mb_strtolower($valeur), 'm') ? 'male' : 'femelle';
    }

    protected function sexe(): Attribute
    {
        return Attribute::set(fn (?string $valeur) => self::cleSexe($valeur));
    }

    protected function sexeLibelle(): Attribute
    {
        return Attribute::get(fn () => $this->sexe === 'male' ? 'Mâle' : 'Femelle');
    }
}
