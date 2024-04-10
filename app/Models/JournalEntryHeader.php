<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalEntryHeader extends Model
{
    use HasFactory;

    protected $fillable = [
        'journal_entry_no',
        'date',
        'notes',
        'debit',
        'credit',
    ];

    public function details()
    {
        return $this->hasMany(JournalEntryDetail::class);
    }

}
