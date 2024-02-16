<?php

use App\Models\Categorie;
use App\Models\Level;
use App\Models\Niveaux;
use App\Models\Session;
use App\Models\User;
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
        Schema::create('etudiants', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->date('dateNaissance');
            $table->char('sexe');
            $table->string('nationalite');
            $table->string('profession')->nullable();
            $table->string('telephone1');
            $table->string('telephone2')->nullable();
            $table->string('adresse');
            $table->string('email');
            $table->string('numCarte')->unique();
            $table->string('profil')->nullable();
            $table->string('comment')->nullable();
            $table->timestamps();

            $table->foreignIdFor(User::class)->constrained();
            $table->foreignIdFor(Level::class)->constrained();
            $table->foreignIdFor(Categorie::class)->constrained();
            $table->foreignIdFor(Session::class)->constrained();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('etudiants', function (Blueprint $table) {
            $table->dropColumn(['user_id', 'level_id', 'categorie_id', 'session_id']);
        });

        Schema::dropIfExists('etudiants');
    }
};
