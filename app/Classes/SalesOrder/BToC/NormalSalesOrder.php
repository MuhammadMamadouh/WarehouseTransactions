<?php

namespace App\Classes\SalesOrder\BToC;

use App\Classes\WarehouseTransaction;
use Illuminate\Http\Request;

class NormalSalesOrder extends WarehouseTransaction
{
    //

    public function index(){
        return 'BToC NormalSalesOrder index';
    }

    public function store(Request $request){
        return 'BToC NormalSalesOrder store';
    }

    public function show($id){
        return 'BToC NormalSalesOrder show';
    }
}
