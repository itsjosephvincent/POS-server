<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CashierResource extends JsonResource
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
            'store_id' => $this->store_id,
            'name' => $this->name,
            'username' => $this->username,
            'created_at' => $this->created_at,
            'store' => new StoreResource($this->whenLoaded('store')),
            'is_active' => $this->is_active,
        ];
    }
}
