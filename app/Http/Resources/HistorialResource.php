<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HistorialResource extends JsonResource
{
    /**
     * Transforma el recurso en un array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id_historial' => $this->Id_historial,
            'id_usuario' => $this->Id_usuario,
            'fecha_de_sesion' => $this->Fecha_de_sesion,
            'usuario' => new UsuarioResource($this->whenLoaded('usuario')), // Incluye info del usuario si está cargado
        ];
    }
}
