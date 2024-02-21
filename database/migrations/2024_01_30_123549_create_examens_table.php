<?php

use App\Models\Level;
use App\Models\Price;
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
        Schema::create('examens', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->timestamps();
            $table->softDeletes();

            $table->foreignIdFor(Price::class)->constrained();
            $table->foreignIdFor(Level::class)->constrained();
            $table->foreignIdFor(Session::class)->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('examens', function (Blueprint $table) {
            $table->dropColumn(['price_id', 'level_id', "session_id"]);
        });

        Schema::dropIfExists('examens');
    }
};
