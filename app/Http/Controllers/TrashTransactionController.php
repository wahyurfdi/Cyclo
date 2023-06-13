<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\TrashTransaction;
use App\Models\Customer;

class TrashTransactionController extends Controller
{
    public function index()
    {
        $trashTransactions = TrashTransaction::select([
                'trash_transaction.code',
                'customer.name AS customer_name',
                'trash_transaction.pickup_name',
                'trash_transaction.pickup_telp',
                'trash_transaction.pickup_address',
                'trash_transaction.pickup_location_detail',
                'trash_transaction.created_at',
                'trash_transaction.total_qty',
                'trash_transaction.total_weight',
                'trash_transaction.total_coin',
                'trash_transaction.status_code'
            ])
            ->leftJoin('customer', 'customer.id', 'trash_transaction.customer_id')
            ->orderBy('trash_transaction.created_at', 'DESC')
            ->get();

        return view('cms.trash.transaction', compact('trashTransactions'));
    }

    public function updateStatus(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'trash_transaction_code' => 'required',
            'status_code' => 'required'
        ], [
            'trash_transaction_code.required' => 'Code tidak boleh kosong',
            'status_code.required' => 'Status tidak boleh kosong'
        ]);

        if($validation->fails()) {
            $errors = $validation->errors()->messages();
            foreach($errors as $error) {
                return $this->sendResponseError($error[0]);
            }
        }

        DB::beginTransaction();
        try {
            $statuCode = $request->status_code;
            $trashTransactionCode = $request->trash_transaction_code;

            TrashTransaction::where('code', $trashTransactionCode)->update(['status_code' => $statuCode]);
            if($statuCode == 'COMPLETED') {
                $trashTransaction = TrashTransaction::where('code', $trashTransactionCode)->first();
                Customer::where('id', $trashTransaction->customer_id)->update(['coin' => DB::raw('coin+'.$trashTransaction->total_coin)]);
            }
            
            DB::commit();
            return $this->sendResponseSuccess('Berhasil mengubah data', []);
        } catch (\Exception $e) {
            DB::rollback();
            return $this->sendResponseError($e->getMessage());
        }
    }
}
