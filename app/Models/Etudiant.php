<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'numCarte',
        'profil',
        'nom',
        'prenom',
        'sexe',
        'dateNaissance',
        'nationalite',
        'profession',
        'adresse',
        'email',
        'telephone1',
        'telephone2',
        'coment',
        'user_id',
        'level_id',
        'categorie_id',
        'session_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
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

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function categories()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function session()
    {
        return $this->belongsTo(Session::class);
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
