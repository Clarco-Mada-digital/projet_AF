<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    use HasFactory;

    protected $fillable =
    [
        "adhesion_id",
        'coment',
        'user_id',
        'level_id',
        'categorie_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function adhesion()
    {
        return $this->belongsTo(Adhesion::class);
    }

    public function cours()
    {
        return $this->belongsToMany(Cour::class, "etudiant_cours", 'etudiant_id', 'cour_id');
    }

    public function examens()
    {
        return $this->belongsToMany(Examen::class, "etudiant_examens", 'etudiant_id', 'examen_id');
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }
    

    public function categories()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function session()
    {
        return $this->belongsToMany(Session::class, "etudiant_sessions", 'etudiant_id', 'session_id');
    }

    public function inscription()
    {
        return $this->hasMany(Inscription::class);
    }

    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }
}
