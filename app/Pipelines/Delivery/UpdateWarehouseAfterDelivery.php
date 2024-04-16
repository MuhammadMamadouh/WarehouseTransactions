<?php

namespace App\Pipelines\Delivery;

use Closure;
use Illuminate\Support\Facades\DB;

class UpdateWarehouseAfterDelivery
{

    public function handle($transaction, Closure $next)
    {
        // get details from request if transaction is not yet created
        $details = count($transaction->details) > 0 ? $transaction->details : request()->details;
        try {

            if ($transaction->from_warehouse_id) {
                foreach ($details as $detail) {

                    DB::table('warehouse_items')
                        ->where('warehouse_id', $transaction->from_warehouse_id)
                        ->where('item_id', $detail['item_id'])
                        ->decrement('stock', $detail['quantity']);
                }
            } else if ($transaction->to_warehouse_id) {

                foreach ($transaction->details as $detail) {

                    DB::table('warehouse_items')
                        ->where('warehouse_id', $transaction->to_warehouse_id)
                        ->where('item_id', $detail['item_id'])
                        ->increment('stock', $detail['quantity']);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
        return $next($transaction);
    }
}
