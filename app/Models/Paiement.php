<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    use HasFactory;

    protected $fillable = [
        'montant',
        'statue',
        'numRecue',
        'type',
        'user_id',
        'moyenPaiement',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

}
