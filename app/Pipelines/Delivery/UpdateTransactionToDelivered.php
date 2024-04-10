<?php

namespace App\Pipelines\Delivery;

use App\Models\TransactionHeader;
use Closure;

class UpdateTransactionToDelivered
{
    public function handle($transaction, Closure $next)
    {
        $transaction->update([
            'status' => TransactionHeader::DELIVERED,
            'journal_entry_id' => $transaction->journal_entry_id, // key from CreateJournalEntryForTransaction
        ]);
        return $next($transaction);
    }
}
