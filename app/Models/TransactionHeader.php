<?php

namespace App\Models;

use App\Pipelines\Delivery\CreateJournalEntryForTransaction;
use App\Pipelines\Delivery\UpdateTransactionToDelivered;
use App\Pipelines\Delivery\UpdateWarehouseAfterDelivery;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Pipeline;

class TransactionHeader extends Model
{
    use HasFactory;

    protected static function getType($type = null)
    {
        return TransactionType::where('name', $type)->first();
    }

    // status
    const PENDING = 0;
    const DELIVERED = 1;
    const CANCELLED = 2;

    const STATUSES = [
        self::PENDING => 'Pending',
        self::DELIVERED => 'Delivered',
        self::CANCELLED => 'Cancelled',
    ];

    protected $table = 'transaction_headers';

    protected $fillable = [
        'code',
        'warehouse_id',
        'item_id',
        'quantity',
        'transaction_date',
        'document_no',
        'from_warehouse_id',
        'to_warehouse_id',
        'journal_entry_id',
        'total_price',
        'total_discount',
        'note',
        'transaction_type_id',
        'status',
    ];

    protected $casts = [
        'transaction_date' => 'datetime',
        'transaction_type_id' => 'integer',
    ];

    // SET default values
    protected $attributes = [
        'status' => self::PENDING,
        // 'transaction_type_id' => self::getType(request()->query('type'))->id,
    ];

    // function to get status
    public function getStatus()
    {
        switch ($this->status) {
            case self::PENDING:
                return 'Pending';
            case self::DELIVERED:
                return 'Delivered';
            case self::CANCELLED:
                return 'Cancelled';
            default:
                return 'Unknown';
        }
    }

    // ===================== Relationships =====================

    public function details()
    {
        return $this->hasMany(TransactionDetail::class, 'transaction_header_id', 'id');
    }

    public function fromWarehouse()
    {
        return $this->belongsTo(Warehouse::class, 'from_warehouse_id', 'id');
    }

    public function toWarehouse()
    {
        return $this->belongsTo(Warehouse::class, 'to_warehouse_id', 'id');
    }

    public function journalEntry()
    {
        return $this->belongsTo(JournalEntryHeader::class, 'journal_entry_id', 'id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function type()
    {
        return $this->belongsTo(TransactionType::class, 'transaction_type', 'id');
    }

}
