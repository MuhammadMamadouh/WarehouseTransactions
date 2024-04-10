<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalEntryDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'journal_entry_header_id',
        'debit',
        'credit',
        'notes',
    ];
}
