<?php

use App\Models\Adhesion;
use App\Models\Level;
use App\Models\User;
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
        Schema::create('etudiants', function (Blueprint $table) {            
            $table->id();
            $table->foreignIdFor(Adhesion::class)->constrained();
            $table->foreignIdFor(User::class)->constrained();
            $table->foreignIdFor(Level::class)->constrained();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('etudiants', function (Blueprint $table) {
            $table->dropColumn(['user_id', 'level_id', 'adhesion_id']);
        });

        Schema::dropIfExists('etudiants');
    }
};
