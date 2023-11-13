<?php

use App\Models\Niveaux;
use App\Models\Professeur;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cours', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('categorie');
            $table->string('sale');
            $table->json('horaire');
            $table->timestamps();

            $table->foreignIdFor(Professeur::class)->constrained();
            $table->foreignIdFor(Niveaux::class)->references('id')->on('niveaux')->constrained();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cours', function (Blueprint $table) {
            $table->dropColumn(['professeur_id','niveaux_id' ]);
        });

        Schema::dropIfExists('cours');
    }
};
