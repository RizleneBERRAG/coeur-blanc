<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Dimensions des photos.
 *
 * La galerie est une grille en colonnes : sans dimensions declarees, le
 * navigateur ne peut reserver aucune place et la mise en page se reorganise a
 * chaque image qui arrive. Sur 37 photos, ça saute pendant plusieurs secondes.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('photos', function (Blueprint $table) {
            $table->unsignedSmallInteger('largeur')->nullable()->after('chemin');
            $table->unsignedSmallInteger('hauteur')->nullable()->after('largeur');
        });
    }

    public function down(): void
    {
        Schema::table('photos', function (Blueprint $table) {
            $table->dropColumn(['largeur', 'hauteur']);
        });
    }
};
