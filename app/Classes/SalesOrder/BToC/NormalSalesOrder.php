<?php

namespace App\Classes\SalesOrder\BToC;

use App\Classes\WarehouseTransaction;


class NormalSalesOrder extends WarehouseTransaction
{
    //

    public function index(){
        return 'BToC NormalSalesOrder index';
    }

    public function store(){
        return 'BToC NormalSalesOrder store';
    }

    public function show(){
        return 'BToC NormalSalesOrder show';
    }
}
