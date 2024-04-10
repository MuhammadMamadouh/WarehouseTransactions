<?php

namespace App\Classes;

use Illuminate\Http\Request;

abstract class WarehouseTransaction
{
    abstract public function index();

    abstract public function store(Request $request);

    abstract public function show($id);


}
