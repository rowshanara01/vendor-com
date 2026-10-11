<?php

namespace App\Http\Resources\user;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class authresource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'name'       => $this->name,
            'email'      => $this->email,
            'phone'      => $this->phone,
            'isVerified' => $this->isVerified,
        ];
    }
}
