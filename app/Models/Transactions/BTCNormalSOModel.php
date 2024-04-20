<?php

namespace App\Models\Transactions;

use App\Models\TransactionHeader;
use App\Pipelines\Delivery\CreateJournalEntryForTransaction;
use App\Pipelines\Delivery\UpdateTransactionToDelivered;
use App\Pipelines\Delivery\UpdateWarehouseAfterDelivery;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Pipeline;


class BTCNormalSOModel extends TransactionHeader
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();
        DB::transaction(function () {
            static::saving(function ($transaction) {
                if ($transaction->status == self::DELIVERED && $transaction->journal_entry_id == null) {
                    Pipeline::send($transaction)
                        ->through([
                            CreateJournalEntryForTransaction::class,
                            UpdateWarehouseAfterDelivery::class,
                            UpdateTransactionToDelivered::class,
                        ])->thenReturn();
                }
            });
        });
    }




    // ===================== Relationships =====================



}
