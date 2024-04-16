<?php

namespace App\Classes\SalesOrder\BToC;

use App\Classes\WarehouseTransaction;
use App\Http\Resources\TransactionHeaderCollection;
use App\Http\Resources\TransactionHeaderResource;
use App\Models\TransactionHeader;
use Illuminate\Http\Request;

class NormalSalesOrder extends WarehouseTransaction
{

    public function index(){
        $transactions = TransactionHeader::normal_b2c()->paginate(30);
        return TransactionHeaderCollection::collection($transactions);
    }

    public function store(Request $request){
        $request->merge([
            'transaction_type'  => TransactionHeader::NORMAL_B2C_SALES,
            'status'            => TransactionHeader::DELIVERED // once created, it is considered delivered and fire event in the background
        ]);
        $header = TransactionHeader::create($request->all());
        $header->details()->createMany($request->details);
        return new TransactionHeaderResource($header);
    }

    public function show($id){
        return new TransactionHeaderResource(TransactionHeader::find($id));
    }
}
