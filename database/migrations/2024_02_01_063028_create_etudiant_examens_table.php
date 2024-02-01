<?php

use App\Models\Etudiant;
use App\Models\Examen;
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
        Schema::create('etudiant_examens', function (Blueprint $table) {
            $table->foreignIdFor(Examen::class)->constrained();
            $table->foreignIdFor(Etudiant::class)->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('etudiant_examens', function (Blueprint $table) {
            $table->dropColumn(['examen_id', 'etudiant_id']);
        });

        Schema::dropIfExists('etudiant_examens');
    }
};
