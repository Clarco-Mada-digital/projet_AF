<?php

use App\Models\Etudiant;
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
        Schema::create('etudiant_sessions', function (Blueprint $table) {
            $table->foreignIdFor(Session::class)->constrained();
            $table->foreignIdFor(Etudiant::class)->constrained();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('etudiant_sessions', function (Blueprint $table) {
            $table->dropColumn(['session_id', 'etudiant_id']);
        });

        Schema::dropIfExists('etudiant_sessions');
    }
};
