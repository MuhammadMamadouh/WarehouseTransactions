<?php

namespace App\Classes;

use App\Classes\WarehouseTransaction;
use App\Http\Resources\TransactionHeaderCollection;
use App\Http\Resources\TransactionHeaderResource;
use App\Interfaces\ICancelable;
use App\Interfaces\IDeliverable;
use App\Models\TransactionHeader;
use Illuminate\Http\Request;
use App\Models\Transactions\BTCNormalSOModel;

class BTCNormalSO extends WarehouseTransaction implements IDeliverable, ICancelable
{
    public function index()
    {
        $transactions = BTCNormalSOModel::paginate(30);
        return TransactionHeaderCollection::collection($transactions);
    }

    public function store(Request $request)
    {
        $header = BTCNormalSOModel::create($request->all());
        $header->details()->createMany($request->details);
        return new TransactionHeaderResource($header);
    }

    public function show($id)
    {
        return new TransactionHeaderResource(BTCNormalSOModel::find($id));
    }

    public function deliver($id)
    {
        $transaction = TransactionHeader::find($id);

        if ($transaction->status != TransactionHeader::PENDING) {
            return response(['error' => 'This transaction is not in pending status']);
        }
        $transaction->update(['status' => TransactionHeader::DELIVERED]); // once delivered, it will fire event in the background (check TransactionHeader model)

        return response(['message' => 'Transaction delivered successfully']);
    }



    public function cancel($id)
    {
        $transaction = TransactionHeader::find($id);

        if ($transaction->status != TransactionHeader::PENDING) {
            return response(['error' => 'This transaction is not in pending status']);
        }
        $transaction->update(['status' => TransactionHeader::CANCELLED]);
        return response(['message' => 'Transaction cancelled successfully']);
    }


}
