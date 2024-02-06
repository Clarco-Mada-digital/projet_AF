<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = 
    [
        'nom',
        'prenom',
        'email',
        'password',
        'sexe',
        'nationalite',
        'telephone1',
        'telephone2',
        'adresse',
        'profil',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // public function role(){
    //     return $this->belongsTo(Role::class);
    // }

    public function etudiants(){
        return $this->hasMany(Etudiant::class);
    }

    public function paiments(){
        return $this->hasMany(Paiement::class);
    }

    // public function hasRole($role)
    // {
    //     return $this->role()->where('nom', $role)->first() !== null;
    // }

    // public function hasAnyRole($roles)
    // {
    //     return $this->role()->whereIn('nom', $roles)->first() !== null;
    // }

}
