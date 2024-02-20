<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    use HasFactory;

    protected $fillable = [
        'montant',
        'montantRestant',
        'statue',
        'motif',
        'numRecue',
        'type',
        'user_id',
        'moyenPaiement',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    
    public function inscription(){
        return $this->belongsTo(Inscription::class);
    }

}
