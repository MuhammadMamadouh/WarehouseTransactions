<?php

namespace App\Services;

use App\Classes\WarehouseTransactionsFactory;
use Illuminate\Http\Request;

class WarehouseTransactionService
{

    protected $warehouseTransaction;
    protected $type;

    /**
     * Create a new class instance.
     */
    public function __construct(WarehouseTransactionsFactory $factory)
    {
        $this->warehouseTransaction = $factory->make(request()->type);
    }
    public function index(){
        return $this->warehouseTransaction->index();
    }

    public function store(Request $request){
        return $this->warehouseTransaction->store($request);
    }

    public function show($id){
        return $this->warehouseTransaction->show($id);
    }

    // public function update(){
    //     return $this->warehouseTransaction->update();
    // }

    // public function deliver(){
    //     return $this->warehouseTransaction->deliver();
    // }

    // public function cancel(){
    //     return $this->warehouseTransaction->cancel();
    // }
}
