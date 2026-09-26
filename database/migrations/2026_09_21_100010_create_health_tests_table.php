<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/** Depistages d'un reproducteur : HCM, PK-Def, PRA-b, FIV/FeLV. */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('health_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cat_id')->constrained()->cascadeOnDelete();
            $table->string('type');                          // hcm | pk_def | pra_b | fiv_felv
            $table->string('resultat')->nullable();          // N/N, Normal, Negatif, A programmer...
            $table->date('date_examen')->nullable();
            $table->string('laboratoire')->nullable();
            $table->string('veterinaire')->nullable();
            $table->string('document_path')->nullable();     // compte-rendu PDF
            $table->text('commentaire')->nullable();
            $table->timestamps();

            $table->unique(['cat_id', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('health_tests');
    }
};
