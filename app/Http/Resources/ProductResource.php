<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'category_id' => $this->category_id,
            'name' => $this->name,
            'image_url' => $this->image_url,
            'cost' => $this->cost,
            'price' => $this->price,
            'inventory' => $this->inventory,
            'created_at' => $this->created_at,
        ];
    }
}