<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'order_number' => $this->order_number,
            'created_at' => $this->created_at,
            'cashier' => new CashierResource($this->whenLoaded('cashier')),
            'orderDetails' => OrderDetailResource::collection($this->whenLoaded('orderDetails')),
        ];
    }
}
