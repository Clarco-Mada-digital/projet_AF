<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cour extends Model
{
    use HasFactory;

    public function etudiants(){
        return $this->belongsToMany(etudiants::class,"etudiant_cours", 'cour_id', 'etudiant_id');
    }
}
