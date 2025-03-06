<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialSesion extends Model
{
    use HasFactory;

    protected $table = 'historial_sesiones'; // Nombre de la tabla
    protected $primaryKey = 'Id_historial'; // Clave primaria personalizada
    public $timestamps = false; // No usa created_at y updated_at

    protected $fillable = ['Id_usuario', 'Fecha_de_sesion'];

    // Relación con el modelo Usuario
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'Id_usuario', 'Id_usuario');
    }
}
