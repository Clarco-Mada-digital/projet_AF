<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salle extends Model
{
    protected $fillable = ['nom', 'description'];


    public function cours()
    {
        return $this->hasMany(Cour::class, 'salle_id', 'id');
    }
}
