<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    public $timestamps = false;

    protected $fillable = [
        'id_usuario',
        'usuario',
        'hashed_password',
        'email',
        'rol',
        'nombre',
        'apellido',
        'fecha_nacimiento',
        'fecha_creacion'
    ];

    protected $hidden = [
        'hashed_password',
        'remember_token',
    ];

    public function favourites()
    {
        return $this->hasMany(Favourite::class, 'id_usuario');
    }


    public function getAuthPassword()
    {
        return $this->hashed_password;
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
