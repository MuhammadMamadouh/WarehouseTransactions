<?php

namespace App\Classes\SalesOrder\BToB;
use App\Classes\WarehouseTransaction;
use App\Interfaces\IDeliverable;

class NormalSalesOrder extends WarehouseTransaction
{

    public function index(){
        return 'BToB NormalSalesOrder index';
    }

    public function store(){
        return 'BToB NormalSalesOrder store';
    }

    public function show(){
        return 'BToB NormalSalesOrder show';
    }

    // public function deliver(){
    //     return 'BToB NormalSalesOrder deliver';
    // }

    public function cancel(){
        return 'BToB NormalSalesOrder cancel';
    }



}
