<?php

use App\Models\Cour;
use App\Models\Session;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // public function up(): void
    // {
    //     Schema::create('session_cours', function (Blueprint $table) {
    //         $table->foreignIdFor(Session::class)->constrained();
    //         $table->foreignIdFor(Cour::class)->constrained();
    //     });

    //     Schema::enableForeignKeyConstraints();
    // }

    /**
     * Reverse the migrations.
     */
    // public function down(): void
    // {
    //     Schema::table('session_cours', function (Blueprint $table) {
    //         $table->dropColumn(['session_id', 'cour_id']);
    //     });

    //     Schema::dropIfExists('session_cours');
    // }
};
