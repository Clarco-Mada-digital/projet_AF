<?php

use App\Models\Categorie;
use App\Models\Professeur;
use App\Models\Session;
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
            $table->string('salle')->nullable();
            $table->string('horaireDuCour')->nullable();
            $table->string('comment')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreignIdFor(Categorie::class)->constrained()->default('1');
            $table->foreignIdFor(Session::class)->constrained();
            $table->foreignIdFor(Professeur::class)->constrained()->default('NULL');
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cours', function (Blueprint $table) {
            $table->dropColumn(['professeur_id','Categorie_id', 'session_id' ]);
        });

        Schema::dropIfExists('cours');
    }
};
