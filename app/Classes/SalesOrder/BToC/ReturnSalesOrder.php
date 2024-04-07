<?php


namespace App\Classes\SalesOrder\BToC;

use App\Classes\WarehouseTransaction;


class ReturnSalesOrder extends WarehouseTransaction
{

    public function index(){
        return 'BToC ReturnSalesOrder index';
    }

    public function store(){
        return 'BToC ReturnSalesOrder store';
    }

    public function show(){
        return 'BToC ReturnSalesOrder show';
    }
}
