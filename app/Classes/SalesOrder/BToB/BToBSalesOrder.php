<?php

namespace App\Classes\SalesOrder\BToC;

use App\Classes\WarehouseTransaction;
use App\Interfaces\ICanceable;
use App\Interfaces\IDeliverable;


abstract class BToBSalesOrder extends WarehouseTransaction  implements IDeliverable, ICanceable
{
    //

    // public function index(){
    //     return 'BToC NormalSalesOrder index';
    // }

    // public function store(){
    //     return 'BToC NormalSalesOrder store';
    // }

    // public function show(){
    //     return 'BToC NormalSalesOrder show';
    // }
}
