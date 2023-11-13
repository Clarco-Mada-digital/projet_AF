<?php

use App\Models\Inscription;
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
        Schema::create('inscripiton_sessions', function (Blueprint $table) {
            $table->foreignIdFor(Session::class)->constrained();
            $table->foreignIdFor(Inscription::class)->constrained();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inscripton_sessions', function (Blueprint $table) {
            $table->dropColumn(['session_id', 'Inscription_id']);
        });

        Schema::dropIfExists('inscripiton_sessions');
    }
};
