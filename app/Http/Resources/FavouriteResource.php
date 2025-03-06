<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FavouriteResource extends JsonResource
{
    /**
     * Transforma el recurso en un array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id_favorito' => $this->id_favorito,
            'id_usuario' => $this->id_usuario,
            'id_producto' => $this->id_producto,
            'usuario' => new UserResource($this->whenLoaded('user')),
            'producto' => new ProductResource($this->whenLoaded('product')),
        ];
    }
}
