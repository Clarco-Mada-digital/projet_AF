<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    use HasFactory;

    protected $fillable = [
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
        'user_id',
        'level_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function cours(){
        return $this->belongsToMany(Cour::class,"etudiant_cours", 'etudiant_id', 'cour_id');
    }

    public function level(){
        return $this->belongsTo(Level::class);
    }

}
