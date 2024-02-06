<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Price extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = 
    [
        'nom',
        'montant',
    ];

    public function levels()
    {
        return $this->belongsToMany(Level::class, "price_levels", 'price_id', 'level_id');
    }
}