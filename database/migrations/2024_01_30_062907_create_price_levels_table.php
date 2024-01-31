<?php

use App\Models\Level;
use App\Models\Price;
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
        Schema::create('price_levels', function (Blueprint $table) {
            $table->foreignIdFor(Price::class)->constrained();
            $table->foreignIdFor(Level::class)->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('price_levels', function (Blueprint $table) {
            $table->dropColumn(['price_id', 'level_id']);
        });

        Schema::dropIfExists('price_levels');
    }
};
