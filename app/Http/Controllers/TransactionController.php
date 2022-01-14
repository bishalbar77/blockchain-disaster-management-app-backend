<?php

namespace App\Http\Controllers;

use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use DB;

class TransactionController extends Controller
{
    private $apiResponse;

    // private $aws_base_url = "https://precisely-test1221001-dev.s3.ap-south-1.amazonaws.com";

    public function __construct(ApiResponse $apiResponse)
    {
        $this->apiResponse = $apiResponse;
    }
    
    public function updateTrasaction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'trasaction_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->apiResponse->sendResponse(400, 'Parameters missing or invalid.', $validator->errors());
        }

        try {
            
            $project = Transaction::find($request->trasaction_id);
            $project->sender_account = $request->sender_account ?? "N/A";
            $project->receiver_account = $request->receiver_account ?? "N/A";
            $project->status = 'Completed';
            $project->save();

            DB::commit();
            return $this->apiResponse->sendResponse(200, 'Transaction record updated successfully', $project);
        } catch (\Exception $e) {
            DB::rollback();
            return $this->apiResponse->sendResponse(500, $e->getMessage(), $e->getTraceAsString());
        }
    }

    public function storeTrasaction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'item_name' => 'required',
            'unit' => 'required',
            'reference' => 'required',
            'amount' => 'required',
            'seller_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->apiResponse->sendResponse(400, 'Parameters missing or invalid.', $validator->errors());
        }

        try {
            
            $project = new Transaction();
            $project->user_id = $request->seller_id;
            $project->item_name = $request->item_name;
            $project->unit = $request->unit;
            $project->sender_account = "N/A";
            $project->receiver_account = "N/A";
            $project->reference = $request->reference;
            $project->status = 'Initialized';
            $project->amount = $request->amount;
            $project->save();

            DB::commit();
            return $this->apiResponse->sendResponse(200, 'Transaction record saved successfully', $project);
        } catch (\Exception $e) {
            DB::rollback();
            return $this->apiResponse->sendResponse(500, $e->getMessage(), $e->getTraceAsString());
        }
    }

    public function getTransactions(Request $request)
    {
        return $this->apiResponse->sendResponse(200, 'Transactions fetched successfully', Transaction::all());
    }
}
