<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\WarehouseTransactionService;
use Illuminate\Http\Request;

class WTController extends Controller
{
    //
    private $wtService;

    public function __construct(WarehouseTransactionService $wtService){
        $this->wtService = $wtService;
    }

    public function index(){
        return $this->wtService->index();
    }

    public function store(Request $request){
        return $this->wtService->store($request);
    }

    public function show($id){
        return $this->wtService->show($id);
    }

    // public function update(){
    //     return $this->wtService->update();
    // }

    // public function deliver(){
    //     return $this->wtService->deliver();
    // }

    // public function cancel(){
    //     return $this->wtService->cancel();
    // }
}
