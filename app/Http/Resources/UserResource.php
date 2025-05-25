<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id_usuario' => $this->id_usuario,
            'usuario' => $this->usuario,
            'email' => $this->email,
            'rol' => $this->rol,
            'nombre' => $this->nombre,
            'apellido' => $this->apellido,
            'fecha_nacimiento' => $this->fecha_nacimiento,
            'fecha_creacion' => $this->fecha_creacion,
            'favourites' => FavouriteResource::collection($this->whenLoaded('favourites')),
        ];
    }
}