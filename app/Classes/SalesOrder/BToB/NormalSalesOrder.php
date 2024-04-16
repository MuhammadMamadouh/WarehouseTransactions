<?php

namespace App\Classes\SalesOrder\BToB;
use App\Classes\WarehouseTransaction;
use App\Http\Resources\TransactionHeaderCollection;
use App\Http\Resources\TransactionHeaderResource;
use App\Interfaces\ICanceable;
use App\Interfaces\IDeliverable;
use App\Models\TransactionHeader;
use App\Pipelines\Delivery\CreateJournalEntryForTransaction;
use App\Pipelines\Delivery\UpdateTransactionToDelivered;
use App\Pipelines\Delivery\UpdateWarehouseAfterDelivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Pipeline;

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
        return new TransactionHeaderResource(TransactionHeader::find($id));
    }

    public function deliver($id){
        $transaction = TransactionHeader::find($id);

        if($transaction->status != TransactionHeader::PENDING){
            return response(['error' => 'This transaction is not in pending status']);
        }
        $transaction->update(['status' => TransactionHeader::DELIVERED]); // once delivered, it will fire event in the background (check TransactionHeader model)

        return response(['message' => 'Transaction delivered successfully']);
    }

    public function cancel(){
        return 'BToB NormalSalesOrder cancel';
    }
}
