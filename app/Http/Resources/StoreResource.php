<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreResource extends JsonResource
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
            'store_name' => $this->store_name,
            'branch' => $this->branch,
            'username' => $this->username,
            'created_at' => $this->created_at,
            'admin' => new AdminResource($this->whenLoaded('admin')),
            'cashiers' => CashierResource::collection($this->whenLoaded('cashiers')),
            'is_active' => $this->is_active,
        ];
    }
}
