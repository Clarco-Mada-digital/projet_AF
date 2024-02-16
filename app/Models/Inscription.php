<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
    use HasFactory;

    protected $fillable = [        
        'remarque',
        'examen_id',
        'etudiant_id',
        'paiement_id'
    ];

    public function sessions(){
        return $this->belongsToMany(Session::class,"inscripiton_sessions", 'inscription_id', 'session_id');
    }
}
