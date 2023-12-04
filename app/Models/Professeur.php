<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Professeur extends Model
{
    use HasFactory;

    protected $fillable = [
        'profil',
        'nom',
        'prenom',
        'sexe',
        'nationalite',
        'adresse',
        'email',
        'telephone1',
        'telephone2',
    ];

    public function cours(){
        return $this->hasMany(Cour::class);
    }
}
