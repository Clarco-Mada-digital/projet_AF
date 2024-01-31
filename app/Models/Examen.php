<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Examen extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'libelle',
        'price_id',
    ];

    public function price()
    {
        return $this->belongsTo(Price::class);
    }
}
