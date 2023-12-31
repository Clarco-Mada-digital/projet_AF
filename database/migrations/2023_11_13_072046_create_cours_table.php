<?php

use App\Models\Level;
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
            $table->string('code');
            $table->string('libelle');
            $table->string('categorie');
            $table->string('salle');
            $table->string('horaire');
            $table->string('coment')->nullable();
            $table->timestamps();

            $table->foreignIdFor(Professeur::class)->constrained();
            $table->foreignIdFor(Level::class)->constrained();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cours', function (Blueprint $table) {
            $table->dropColumn(['professeur_id','level_id' ]);
        });

        Schema::dropIfExists('cours');
    }
};
