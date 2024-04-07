<?php

namespace App\Classes\SalesOrder\BToB;

use App\Classes\WarehouseTransaction;
use App\Interfaces\IDeliverable;

class ReturnSalesOrder extends WarehouseTransaction implements IDeliverable
{
    //

    public function index(){
        return 'BToB ReturnSalesOrder index';
    }

    public function store(){
        return 'BToB ReturnSalesOrder store';
    }

    public function show(){
        return 'BToB ReturnSalesOrder show';
    }

    public function deliver(){
        return 'BToB ReturnSalesOrder deliver';
    }

    public function cancel(){
        return 'BToB ReturnSalesOrder cancel';
    }

}
