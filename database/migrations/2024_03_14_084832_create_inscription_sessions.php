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
        Schema::create('inscription_sessions', function (Blueprint $table) {
            $table->foreignIdFor(Inscription::class)->constrained();
            $table->foreignIdFor(Session::class)->constrained();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inscription_sessions', function (Blueprint $table) {
            $table->dropColumn(['session_id', 'Inscription_id']);
        });

        Schema::dropIfExists('inscription_sessions');
    }
};
