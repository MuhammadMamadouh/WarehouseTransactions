<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;

    public $table = 'transaction_details';

    protected $fillable = [
        'transaction_header_id',
        'item_id',
        'quantity',
        'cost',
        'price',
    ];


    public $timestamps = false;


    // ===================== Relationships =====================

    public function header()
    {
        return $this->belongsTo(TransactionHeader::class, 'transaction_header_id', 'id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'id');
    }
}
