<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'montant',
        'dateInscription',
        'moyentPaiement',
        'statue',
        'numRecue',
        'remarque',
        'etudiant_id',
        'updated_at'
    ];

    public function sessions(){
        return $this->belongsToMany(Session::class,"inscripiton_sessions", 'inscription_id', 'session_id');
    }
}
