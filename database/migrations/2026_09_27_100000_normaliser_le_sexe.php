<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Le sexe redevient une cle : « male », sans accent.
 *
 * Le semoir rangeait « male » avec son accent circonflexe, parce qu'il se
 * contentait de mettre en minuscules le libelle affiche. En SQL cela ne se
 * voyait pas — la collation de MySQL ignore les accents, et une recherche des
 * males les trouvait tous. En PHP, si : la liste deroulante du back-office
 * s'ouvrait vide sur chaque fiche, et la colonne « Sexe » du tableau annoncait
 * « Femelle » pour tout le monde.
 *
 * Cette migration remet les deux tables d'aplomb. La conversion est ecrite en
 * SQL et non en PHP : elle doit passer sur une base deja remplie.
 */
return new class extends Migration
{
    public function up(): void
    {
        foreach (['cats', 'kittens'] as $table) {
            DB::table($table)->whereRaw("LOWER(sexe) LIKE 'm%'")->update(['sexe' => 'male']);
            DB::table($table)->whereRaw("LOWER(sexe) NOT LIKE 'm%'")->update(['sexe' => 'femelle']);
        }
    }

    public function down(): void
    {
        // Rien a defaire : l'ancien etat etait une incoherence, pas un format.
    }
};
