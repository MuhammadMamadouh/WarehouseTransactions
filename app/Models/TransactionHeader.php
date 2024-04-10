<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionHeader extends Model
{
    use HasFactory;

    const NORMAL_B2B_SALES = 1;
    const RETURN_B2B_SALES = 2;
    const NORMAL_B2C_SALES = 3;
    const RETURN_B2C_SALES = 4;


    const TRANSACTION_TYPES = [
        self::NORMAL_B2B_SALES => 'Normal B2B Sales',
        self::RETURN_B2B_SALES => 'Return B2B Sales',
        self::NORMAL_B2C_SALES => 'Normal B2C Sales',
        self::RETURN_B2C_SALES => 'Return B2C Sales',
    ];

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
        'created_by',
        'from_warehouse_id',
        'to_warehouse_id',
        'journal_entry_id',
        'total_price',
        'total_discount',
        'note',
        'transaction_type',
        'status',
    ];

    protected $casts = [
        'transaction_date' => 'datetime',
    ];

    // SET default values
    protected $attributes = [
        'status' => self::PENDING,
    ];

    /**
     * Get the transaction type
     */
    public function getTransactionType()
    {
        switch ($this->transaction_type) {
            case self::NORMAL_B2B_SALES:
                return 'Normal B2B Sales';
            case self::RETURN_B2B_SALES:
                return 'Return B2B Sales';
            case self::NORMAL_B2C_SALES:
                return 'Normal B2C Sales';
            case self::RETURN_B2C_SALES:
                return 'Return B2C Sales';
            default:
                return 'Unknown';
        }
    }

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

    // ===================== scopes =====================
    public function scopeNormal_b2b($query)
    {
        return $query->where('transaction_type', self::NORMAL_B2B_SALES);
    }

    public function scopeReturn_b2b($query)
    {
        return $query->where('transaction_type', self::RETURN_B2B_SALES);
    }

    public function scopeNormal_b2c($query)
    {
        return $query->where('transaction_type', self::NORMAL_B2C_SALES);
    }

    public function scopeReturn_b2c($query)
    {
        return $query->where('transaction_type', self::RETURN_B2C_SALES);
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

}
