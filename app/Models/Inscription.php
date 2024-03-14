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
        'adhesion_id',
    ];

    public function session(){
        return $this->belongsToMany(Session::class, 'inscription_sessions', 'inscription_id', 'session_id');
    }

    public function paiements(){
        return $this->belongsToMany(Paiement::class, 'inscription_paiements', 'inscription_id', 'paiement_id');
    }

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }

}
