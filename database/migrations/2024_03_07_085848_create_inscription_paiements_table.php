<?php

use App\Models\Inscription;
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
        Schema::create('inscription_paiements', function (Blueprint $table) {
            $table->foreignIdFor(Paiement::class)->constrained();
            $table->foreignIdFor(Inscription::class)->constrained();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inscription_paiements', function (Blueprint $table) {
            $table->dropColumn(['paiement_id', 'Inscription_id']);
        });

        Schema::dropIfExists('inscription_paiements');
    }
};
