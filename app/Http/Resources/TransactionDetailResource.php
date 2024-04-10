<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'item'      => $this->item->name,
            'quantity'  => $this->quantity,
            'cost'      => $this->cost,
            'price'     => $this->price,
        ];
    }
}
