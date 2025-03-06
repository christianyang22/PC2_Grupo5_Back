<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios';

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
}