<?php

namespace App\Pipelines\Delivery;

use App\Models\TransactionHeader;
use Closure;

class UpdateWarehouseAfterDelivery
{

    public function handle($transaction, Closure $next)
    {
        $details = $transaction->details;

        // Update warehouse stock
        foreach ($details as $detail) {

            // update warehouse stock after delivery by subtracting the quantity from pivot table
            $warehouse = $detail->item->warehouses()->where('warehouse_id', $transaction->from_warehouse_id)->first();

            $warehouse->pivot->stock -= $detail->quantity;

            $warehouse->save();
        }

        return $next($transaction);
    }
}
