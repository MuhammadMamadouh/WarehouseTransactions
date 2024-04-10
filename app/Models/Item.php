<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $table = 'items';

    protected $fillable = [
        'name',
        'code',
        'price',
    ];

    // ==================== Relationships ========================
    public function warehouses(){
        return $this->belongsToMany(Warehouse::class, 'warehouse_items', 'item_id', 'warehouse_id')->withPivot('stock');
    }
}
