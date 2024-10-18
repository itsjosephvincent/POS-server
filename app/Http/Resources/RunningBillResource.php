<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RunningBillResource extends JsonResource
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
            'table_id' => $this->table_id,
            'product_id' => $this->product_id,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'is_voided' => $this->is_voided,
            'created_at' => $this->created_at,
            'table' => new TableResource($this->whenLoaded('table')),
            'product' => new ProductResource($this->whenLoaded('product')),
        ];
    }
}
