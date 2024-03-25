<?php

use App\Models\Categorie;
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
        Schema::create('price_categories', function (Blueprint $table) {
            $table->foreignIdFor(Price::class)->constrained();
            $table->foreignIdFor(Categorie::class)->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('price_categories', function (Blueprint $table) {
            $table->dropColumn(['price_id', 'categorie_id']);
        });

        Schema::dropIfExists('price_categories');
    }
};
