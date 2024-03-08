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
        'session_id',
    ];

    public function session(){
        return $this->belongsTo(Session::class);
    }

    public function paiements(){
        return $this->belongsToMany(Paiement::class, 'inscription_paiements', 'inscription_id', 'paiement_id');
    }

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }

}
