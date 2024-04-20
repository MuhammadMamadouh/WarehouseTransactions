<?php

namespace App\Models\Transactions;

use App\Models\TransactionHeader;
use App\Pipelines\Delivery\CreateJournalEntryForTransaction;
use App\Pipelines\Delivery\UpdateTransactionToDelivered;
use App\Pipelines\Delivery\UpdateWarehouseAfterDelivery;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Pipeline;


class BTBNormalSOModel extends TransactionHeader
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();
        $type = parent::getType(request()->query('type'));

        // global scope to set transaction type
        static::addGlobalScope('type', function ($builder) use ($type) {
            $builder->where('transaction_type_id', parent::getType()->id);
        });


        DB::transaction(function () use ($type){
            $type = parent::getType(request()->query('type'));
            static::saving(function ($transaction) use ($type){
                $transaction->transaction_type_id = $type->id;
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
