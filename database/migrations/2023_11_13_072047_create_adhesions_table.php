<?php

use App\Models\Categorie;
use Carbon\Carbon;
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
        Schema::create('adhesions', function (Blueprint $table) {
            $table->id();
            $table->string("CB")->nullable();
            $table->string('nom');
            $table->string('prenom');
            $table->integer('dateNaissance');
            $table->char('sexe');
            $table->string('nationalite')->nullable();
            $table->string('profession')->nullable();
            $table->string('telephone1')->nullable();
            $table->string('telephone2')->nullable();
            $table->string('adresse')->nullable();
            $table->string('email')->nullable();
            $table->string('numCarte')->unique();
            $table->string('profil')->nullable();
            $table->string('comment')->nullable();
            $table->date('finAdhesion')->default(Carbon::now()->addYear());
            $table->timestamps();
            
            $table->foreignIdFor(Categorie::class)->constrained();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('etudiants', function (Blueprint $table) {
            $table->dropColumn(['categorie_id']);
        });

        Schema::dropIfExists('adhesions');
    }
};
