<?php

use App\Models\Etudiant;
use App\Models\Paiement;
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
            $table->float('montant');
            $table->string('statue');
            $table->string('moyenPaiement');
            $table->string('numRecue');
            $table->timestamps();

            
            $table->foreignIdFor(Etudiant::class)->constrained();
            $table->foreignIdFor(Paiement::class)->constrained();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('adhesions', function (Blueprint $table) {
            $table->dropColumn(['etudiant_id', 'paiement_id']);
        });

        Schema::dropIfExists('adhesions');
    }
};
