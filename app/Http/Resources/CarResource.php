<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "merk" => $this->merk,
            "model" => $this->model,
            "photo" => $this->photo,
            "plat_number" => $this->plat_number,
            "rental_fee" => $this->rental_fee,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
