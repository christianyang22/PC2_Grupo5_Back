<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'productos';

    protected $fillable = [
        'id_producto',
        'nombre',
        'enlace',
        'link_imagen',
        'precio',
        'oferta',
        'precio_peso',
        'grasas',
        'grasas_saturadas',
        'hidratos_carbono',
        'azucar',
        'proteina',
        'sal',
        'valoracion',
        'supermercado',
        'cluster'
    ];

    public function favourites()
    {
        return $this->hasMany(Favourite::class, 'id_producto');
    }

    public function getLinkImagenAttribute($value)
    {
        if (strpos($value, 'product_imaes') !== false) {
            return str_replace('product_imaes', 'product_images', $value);
        }
        return $value;
    }

    public static function obtenerProductosPaginados($cantidad = 100)
    {
        return self::paginate($cantidad);
    }
}