<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'admin_id' => $this->admin_id,
            'name' => $this->name,
            'created_at' => $this->created_at,
            'admin' => new AdminResource($this->whenLoaded('admin')),
            'products' => ProductResource::collection($this->whenLoaded('products')),
        ];
    }
}
