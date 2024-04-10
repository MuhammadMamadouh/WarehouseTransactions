<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $type = $request->type;
        $warehouseTransaction = app()->make('App\Classes\WarehouseTransactionsFactory')->make($type);

        // check if the warehouseTransaction implements IDeliverable interface
        if (!($warehouseTransaction instanceof \App\Interfaces\IDeliverable)) {
            return response()->json(['error' => 'This transaction type is not deliverable'], 400);
        }

        return $warehouseTransaction->deliver($id);
    }
}
