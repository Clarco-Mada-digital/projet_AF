<?php

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
        Schema::table('cours', function (Blueprint $table) {
            // Vérifier si la colonne salle existe déjà
            if (Schema::hasColumn('cours', 'salle')) {
                // Si la colonne existe, la renommer en salle_id
                $table->renameColumn('salle', 'salle_id');
            } else if (!Schema::hasColumn('cours', 'salle_id')) {
                // Si aucune des deux colonnes n'existe, créer salle_id
                $table->unsignedBigInteger('salle_id')->nullable()->after('id');
            }
            
            // Convertir en clé étrangère
            $table->foreign('salle_id')
                  ->references('id')
                  ->on('salles')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cours', function (Blueprint $table) {
            // Supprimer la clé étrangère
            $table->dropForeign(['salle_id']);
            
            // Renommer la colonne en arrière si nécessaire
            if (Schema::hasColumn('cours', 'salle_id') && !Schema::hasColumn('cours', 'salle')) {
                $table->renameColumn('salle_id', 'salle');
            }
        });
    }
};
