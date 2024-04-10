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
        return 'BToB NormalSalesOrder show';
    }

    public function deliver($id){
        $transaction = TransactionHeader::find($id);

        if($transaction->status != TransactionHeader::PENDING){
            return response(['error' => 'This transaction is not in pending status']);
        }
        $this->processDelivery($transaction);

        return response(['message' => 'Transaction delivered successfully']);
    }

    private function processDelivery($transaction){

        $pipeline = [
            UpdateTransactionToDelivered::class,
            CreateJournalEntryForTransaction::class,
        ];
        if($transaction->from_warehouse_id && $transaction->to_warehouse_id){ // if transaction is warehouse to warehouse
            $pipeline[] = UpdateWarehouseAfterDelivery::class;
        }
        DB::transaction(function () use ($transaction, $pipeline){
            Pipeline::send($transaction)->through($pipeline)->thenReturn();
        });
    }

    public function cancel(){
        return 'BToB NormalSalesOrder cancel';
    }
}
