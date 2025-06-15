<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cour extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = 
    [
        'code',
        'libelle',
        'categorie',
        'salle_id',
        'horaireDuCour',
        'comment',
        'professeur_id',
        'categorie_id',
        'session_id',
    ];

    public function professeur()
    {
        return $this->belongsTo(Professeur::class);
    }

    // public function level()
    // {
    //     return $this->belongsTo(Level::class);
    // }

    public function salle()
    {
        return $this->belongsTo(Salle::class);
    }

    public function etudiants()
    {
        return $this->belongsToMany(Etudiant::class, "etudiant_cours", 'cour_id', 'etudiant_id');
    }

    public function level()
    {
        return $this->belongsToMany(Level::class, "cours_levels", 'cour_id', 'level_id');
    }

    public function session()
    {
        return $this->belongsTo(Session::class);
    }
}
