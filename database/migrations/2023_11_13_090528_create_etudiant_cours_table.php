<?php

use App\Models\Cour;
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
        Schema::create('etudiant_cours', function (Blueprint $table) {
            $table->foreignIdFor(Cour::class)->constrained();
            $table->foreignIdFor(Etudiant::class)->constrained();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('etudiant_cours', function (Blueprint $table) {
            $table->dropColumn(['cour_id', 'etudiant_id']);
        });

        Schema::dropIfExists('etudiant_cours');
    }
};
