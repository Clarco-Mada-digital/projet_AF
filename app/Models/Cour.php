<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cour extends Model
{
    use HasFactory;

    public function professeur(){
        return $this->belongsTo(Professeur::class);
    }

    public function level(){
        return $this->belongsTo(Level::class);
    }

    public function etudiants(){
        return $this->belongsToMany(Etudiant::class,"etudiant_cours", 'cour_id', 'etudiant_id');
    }
}
