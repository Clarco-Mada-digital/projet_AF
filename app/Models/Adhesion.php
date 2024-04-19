<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adhesion extends Model
{
    use HasFactory;

    protected $fillable = [
        'CB',
        'profil',
        'numCarte',
        'nom',
        'prenom',
        'sexe',
        'dateNaissance',
        'ville',
        'pays',
        'profession',
        'adresse',
        'email',
        'telephone1',
        'telephone2',
        'coment',
        'finAdhesion',
        'updated_at',
        'categorie_id',
    ];

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }

}
