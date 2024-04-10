<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TransactionHeaderCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                    => $this->id,
            'code'                  => $this->code,
            'transaction_date'      => $this->transaction_date,
            'document_no'           => $this->document_no,
            'created_by'            => $this->created_by,
            'from_warehouse_id'     => $this->from_warehouse?->name,
            'to_warehouse_id'       => $this->to_warehouse?->name,
            'journal_entry_id'      => $this->journal_entry?->code,
            'total_price'           => $this->total_price,
            'total_discount'        => $this->total_discount,
            'note'                  => $this->note,
            'transaction_type'      => $this->getTransactionType(),
            'status'                => $this->getStatus(),
        ];
    }
}
