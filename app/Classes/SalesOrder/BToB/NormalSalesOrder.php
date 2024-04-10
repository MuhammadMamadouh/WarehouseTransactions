<?php

namespace App\Classes\SalesOrder\BToB;
use App\Classes\WarehouseTransaction;
use App\Http\Resources\TransactionHeaderCollection;
use App\Http\Resources\TransactionHeaderResource;
use App\Interfaces\ICanceable;
use App\Interfaces\IDeliverable;
use App\Models\TransactionHeader;
use Illuminate\Http\Request;

class NormalSalesOrder extends WarehouseTransaction implements IDeliverable, ICanceable
{

    public function index(){

        $transactions = TransactionHeader::normal_b2b()->get();
        return TransactionHeaderCollection::collection($transactions);
    }

    public function store(Request $request){

        $header = TransactionHeader::create($request->all());
        $header->details()->createMany($request->details);
        return new TransactionHeaderResource($header);
    }

    public function show($id){
        return 'BToB NormalSalesOrder show';
    }

    public function deliver($id){
        $transaction = TransactionHeader::find($id);
        // check if transaction is not pending
        if($transaction->status != TransactionHeader::PENDING){
            return response(['error' => 'This transaction is not in pending status']);
        }

        

        return 'BToB NormalSalesOrder deliver';
    }

    public function cancel(){
        return 'BToB NormalSalesOrder cancel';
    }



}
