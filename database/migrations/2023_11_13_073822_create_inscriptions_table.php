<?php

use App\Models\Adhesion;
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
        Schema::create('inscriptions', function (Blueprint $table) {
            $table->id();            
            $table->longText('remarque')->nullable();
            $table->integer('idCourOrExam')->nullable();
            $table->boolean("statut");
            $table->string("type");
            $table->timestamps();

            $table->foreignIdFor(Adhesion::class)->constrained();
            // $table->foreignIdFor(Session::class)->constrained()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inscriptions', function (Blueprint $table) {
            $table->dropColumn(['adhesion_id', "session_id"]);
        });

        Schema::dropIfExists('inscriptions');
    }
};
