<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'enlace' => $this->enlace,
            'imagen' => $this->link_imagen,
            'precio' => $this->precio,
            'oferta' => $this->oferta,
            'precio_peso' => $this->precio_peso,
            'nutricion' => [
                'grasas' => $this->grasas,
                'grasas_saturadas' => $this->grasas_saturadas,
                'hidratos_carbono' => $this->hidratos_carbono,
                'azucar' => $this->azucar,
                'proteina' => $this->proteina,
                'sal' => $this->sal,
            ],
            'valoracion' => $this->valoracion,
            'supermercado' => $this->supermercado,
            'cluster' => $this->cluster,
            'creado_en' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
