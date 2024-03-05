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
        'level_id',
        'session_id',
    ];

    public function price()
    {
        return $this->belongsTo(Price::class);
    }
    
    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function session()
    {
        return $this->belongsTo(Session::class);
    }
}
