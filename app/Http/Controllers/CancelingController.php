<?php

namespace App\Http\Controllers;

use App\Classes\WarehouseTransactionsFactory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CancelingController extends Controller
{
    public function __invoke(Request $request,WarehouseTransactionsFactory $factory, $id)
    {
        $warehouseTransaction = $factory->make($request->type);

        // check if the warehouseTransaction implements IDeliverable interface
        if (!($warehouseTransaction instanceof \App\Interfaces\ICanceable)) {
            return response()->json(['error' => 'This transaction type is not Canceable'], 422);
        }
        return $warehouseTransaction->cancel($id);
    }
}
