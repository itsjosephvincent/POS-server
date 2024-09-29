<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
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
            'user_id' => $this->user_id,
            'username' => $this->user->username,
            'name' => $this->user->name,
            'business_name' => $this->business_name,
            'role' => $this->user->getRoleNames()[0],
            'enabled' => $this->enabled,
        ];
    }
}
