<?php

namespace App\Models;

use App\Pipelines\Delivery\CreateJournalEntryForTransaction;
use App\Pipelines\Delivery\UpdateTransactionToDelivered;
use App\Pipelines\Delivery\UpdateWarehouseAfterDelivery;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Pipeline;

class BTBNormaSalesOrder extends TransactionHeader
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();
        DB::transaction(function () {
            static::saving(function ($transaction) {
                $transaction->type = self::$transactiontype;
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
