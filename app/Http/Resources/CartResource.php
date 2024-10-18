<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
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
            'cashier_id' => $this->cashier_id,
            'product_id' => $this->product_id,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'is_voided' => $this->is_voided,
            'created_at' => $this->created_at,
            'cashier' => new CashierResource($this->whenLoaded('cashier')),
            'product' => new ProductResource($this->whenLoaded('product')),
        ];
    }
}
