<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    use HasFactory, SoftDeletes;

    public function cours(){
        return $this->hasMany(Cour::class);
    }

    public function examens(){
        return $this->hasMany(Examen::class);
    }

    public function inscriptons(){
        return $this->belongsToMany(Inscription::class,"inscripiton_sessions", 'session_id', 'inscription_id');
    }
}
