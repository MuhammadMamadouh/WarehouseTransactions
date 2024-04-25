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
            'from_warehouse_id'     => $this->from_warehouse_id,
            'from_warehouse_name'   => $this->fromWarehouse?->name,
            'to_warehouse_id'       => $this->to_warehouse_id,
            'to_warehouse_name'     => $this->toWarehouse?->name,
            'journal_entry_id'      => $this->journal_entry_id,
            'journal_entry_code'    => $this->journalEntry?->code,
            'total_price'           => $this->total_price,
            'total_discount'        => $this->total_discount,
            'note'                  => $this->note,
            'transaction_type'      => $this->transactionType?->name,
            'status'                => $this->getStatus(),
        ];
    }
}
