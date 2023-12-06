<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Professeur extends Model
{
    use HasFactory, SoftDeletes;

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
