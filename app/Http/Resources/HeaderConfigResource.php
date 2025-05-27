<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HeaderConfigResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'backgroundColor' => $this->background_color,
            'headerColor'     => $this->header_color,
            'buttonColor'     => $this->button_color,
            'hoverColor'      => $this->hover_color,
            'updatedBy'       => $this->updated_by,
            'createdAt'       => $this->created_at?->toDateTimeString(),
            'updatedAt'       => $this->updated_at?->toDateTimeString(),
        ];
    }
}