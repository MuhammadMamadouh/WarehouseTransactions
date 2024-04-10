<?php

namespace App\Pipelines\Delivery;

use App\Models\JournalEntryHeader;
use Closure;

class CreateJournalEntryForTransaction
{
    public function handle($transaction, Closure $next)
    {
        // create factory JournalEntryHeader with details
        $journalEntry = JournalEntryHeader::create([
            'journal_entry_no'  => 'JE' . time(),
            'date'              => now(),
            'notes'             => 'Journal Entry for transaction #' . $transaction->id,
            'debit'             => $transaction->total_price,
            'credit'            => $transaction->total_price,
        ]);

        foreach ($transaction->details as $detail) {
            $journalEntry->details()->create([
                'debit'     => $detail->price,
                'credit'    => $detail->price,
                'notes'     => 'Journal Entry for transaction #' . $transaction->id,
            ]);
        }
        // pass journal entry id to next pipeline
        $transaction->journal_entry_id = $journalEntry->id;
        
        return $next($transaction);
    }
}
