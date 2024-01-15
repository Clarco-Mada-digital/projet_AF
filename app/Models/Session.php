<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $fillable = [
        'nom',
        'dateDebut',
        'dateFin',
        'dateFinPromo',
        'montant',
        'montantPromo',
        'horaireDuCour',
        'statue',
        'updated_at',
    ];

    use HasFactory;

    public function cours(){
        return $this->belongsToMany(Cour::class,"session_cours", 'session_id', 'cour_id');
    }

    public function inscriptons(){
        return $this->belongsToMany(Inscription::class,"inscripiton_sessions", 'session_id', 'inscription_id');
    }
}
