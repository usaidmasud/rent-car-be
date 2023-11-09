<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            "date" => $this->date,
            "start_date" => $this->start_date,
            "end_date" => $this->end_date,
            "car_id" => $this->car_id,
            "rental_fee" => $this->rental_fee,
            "day" => $this->day,
            "status" => $this->status,
            "total_payment" => $this->total_payment,
            "car" => new CarResource($this->car),
            "user" => new UserResource($this->user),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
