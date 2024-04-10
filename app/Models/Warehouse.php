<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;

    protected $table = 'warehouses';

    protected $fillable = [
        'name',
    ];

    // ==================== Relationships ========================

    public function items(){
        return $this->belongsToMany(Item::class, 'warehouse_items', 'warehouse_id', 'item_id')->withPivot('stock');
    }
}
