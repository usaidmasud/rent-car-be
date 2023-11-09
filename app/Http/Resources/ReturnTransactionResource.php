<?php

namespace App\Http\Resources;

use App\Http\Requests\TransactionRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReturnTransactionResource extends JsonResource
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
            "total_day" => $this->total_day,
            "rental_fee" => $this->rental_fee,
            "total_payment" => $this->total_payment,
            "transaction_id" => $this->transaction_id,
            "user_id" => $this->user_id,
            "transaction" => new TransactionResource($this->transaction),
            "user" => new UserResource($this->user),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
