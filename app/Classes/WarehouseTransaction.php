<?php

namespace App\Classes;

abstract class WarehouseTransaction
{
    abstract public function index();

    abstract public function store();

    abstract public function show();
}
