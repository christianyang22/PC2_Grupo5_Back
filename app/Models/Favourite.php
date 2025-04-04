<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    use HasFactory;

    protected $table = 'favoritos';

    protected $fillable = [
        'id_favorito',
        'id_usuario',
        'id_producto'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_producto');
    }
}