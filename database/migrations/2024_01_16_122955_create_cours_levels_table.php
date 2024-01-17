<?php

use App\Models\Cour;
use App\Models\Level;
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
        Schema::create('cours_levels', function (Blueprint $table) {
            $table->foreignIdFor(Cour::class)->constrained();
            $table->foreignIdFor(Level::class)->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cours_levels', function (Blueprint $table) {
            $table->dropColumn(['cour_id', 'level_id']);
        });
        
        Schema::dropIfExists('cours_levels');
    }
};
