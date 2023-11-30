<?php

use App\Models\Etudiant;
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
        Schema::create('inscriptions', function (Blueprint $table) {
            $table->id();
            $table->integer('montant');
            $table->date('dateInscription');
            $table->string('moyentPaiement');
            $table->string('statue');
            $table->integer('numRecue')->nullable();
            $table->longText('remarque')->nullable();
            $table->timestamps();

            $table->foreignIdFor(Etudiant::class)->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inscriptions', function (Blueprint $table) {
            $table->dropColumn('etudiant_id');
        });

        Schema::dropIfExists('inscriptions');
    }
};
