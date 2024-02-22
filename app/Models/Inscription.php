<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
    use HasFactory;

    protected $fillable = [        
        'remarque',
        'idCourOrExam',
        'statut',
        'type',
        'etudiant_id',
        'paiement_id',
    ];

    public function sessions(){
        return $this->belongsToMany(Session::class,"inscripiton_sessions", 'inscription_id', 'session_id');
    }

    public function paiement(){
        return $this->belongsTo(Paiement::class);
    }
}
