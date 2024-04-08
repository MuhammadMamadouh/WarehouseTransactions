<?php

namespace App\Classes;

use App\Classes\SalesOrder\BToB\NormalSalesOrder as BToBNormalSalesOrder;
use App\Classes\SalesOrder\BToC\NormalSalesOrder as BToCNormalSalesOrder;

class WarehouseTransactionsFactory
{
    /**
     * Create a new class instance.
     */
    public function make($type) : WarehouseTransaction
    {
        try {
            return $this->transactions()[$type];
        } catch (\Exception $e) {
            throw new \Exception('Transaction type not found');
        }
    }

    public function transactions(){
        return [
            'B2B' => new BToBNormalSalesOrder(),
            'B2C' => new BToCNormalSalesOrder()
        ];
    }
}
