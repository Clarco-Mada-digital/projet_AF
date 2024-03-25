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
    public function categories()
    {
        return $this->belongsToMany(Categorie::class, "price_categories", 'price_id', 'categorie_id');
    }
}
