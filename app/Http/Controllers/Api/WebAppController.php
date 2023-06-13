<?php

namespace App\Http\Controllers\Api;

use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Customer;
use App\Models\TrashTransaction;
use App\Models\TrashTransactionItem;
use App\Models\TrashType;

class WebAppController extends Controller
{
    public function login(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required'
        ], [
            'username.required' => 'Username tidak boleh kosong',
            'password.required' => 'Password tidak boleh kosong'
        ]);

        if($validation->fails()) {
            $errors = $validation->errors()->messages();
            foreach($errors as $error) {
                return $this->sendResponseError($error[0]);
            }
        }

        $customer = Customer::where('username', $request->username)->first();
        if(empty($customer)) {
            return $this->sendResponseError('User tidak ditemukan');
        }

        if(!Hash::check($request->password, $customer->password)) {
            return $this->sendResponseError('Username/Password tidak sesuai');
        }
        $token = $customer->createToken('API Token')->accessToken;

        return $this->sendResponseSuccess('Berhasil login', [
            'name' => $customer->name,
            'username' => $customer->username,
            'token' => $token
        ]);
    }

    public function signup(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required'
        ], [
            'username.required' => 'Username tidak boleh kosong',
            'password.required' => 'Password tidak boleh kosong',
            'name.required' => 'Nama tidak boleh kosong',
            'phone.required' => 'Telepon tidak boleh kosong',
            'address.required' => 'Alamat tidak boleh kosong'
        ]);

        if($validation->fails()) {
            $errors = $validation->errors()->messages();
            foreach($errors as $error) {
                return $this->sendResponseError($error[0]);
            }
        }

        $addCustomer = Customer::insert([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'location_detail' => !empty($request->location_detail) ? $request->location_detail : null,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        if(!$addCustomer) return $this->sendResponseError('Gagal mendaftar, silahkan coba lagi');

        return $this->sendResponseSuccess('Berhasil mendaftarkan akun', []);
    }

    public function getProfile(Request $request)
    {
        $token = $this->getTokenDetail($request->bearerToken());
        if(empty($token)) return $this->sendResponseError('Token tidak valid', 401);
        $customerId = $token->user_id;
        
        $customer = Customer::where('id', $customerId)->first();
        if(empty($customer)) return $this->sendResponseError('User tidak ditemukan', 401);

        $totalWeight = TrashTransaction::where('customer_id', $customerId)->where('status_code', 'COMPLETED')->sum('total_weight');

        return $this->sendResponseSuccess('', [
            'name' => $customer->name,
            'phone' => $customer->phone,
            'username' => $customer->username,
            'address' => $customer->address,
            'location_detail' => $customer->location_detail,
            'coin' => $customer->coin,
            'contribution' => [
                'weight' => $totalWeight
            ]
        ]);
    }

    public function createTrashTransaction(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'pickup_name' => 'required',
            'pickup_telp' => 'required',
            'pickup_address' => 'required',
            'trash_list' => 'required'
        ], [
            'pickup_name.required' => 'Nama tidak boleh kosong',
            'pickup_telp.required' => 'Telepon tidak boleh kosong',
            'pickup_address.required' => 'Alamat tidak boleh kosong',
            'trash_list.required' => 'List sampah tidak boleh kosong'
        ]);

        if($validation->fails()) {
            $errors = $validation->errors()->messages();
            foreach($errors as $error) {
                return $this->sendResponseError($error[0]);
            }
        }

        $token = $this->getTokenDetail($request->bearerToken());
        if(empty($token)) return $this->sendResponseError('Token tidak valid', 401);
        $customerId = $token->user_id;

        DB::beginTransaction();
        try {
            $code = 'CYC-'.date('dmy').rand(1000, 9999);
            $totalQty = 0;
            $totalWeight = 0;
            $totalCoin = 0;
            $trashTransactionItems = [];

            foreach($request->trash_list as $trash) {
                $trashTypeId = $trash['trash_type_id'];
                $qty = $trash['qty'];
                $weight = 0;
                $coin = 0;

                $trashType = TrashType::where('id', $trashTypeId)->first();
                if(!empty($trashType)) {
                    $weight = $qty*$trashType->weight_per_qty;
                    $coin = $qty*$trashType->coin_per_qty;
                }

                $totalQty += $qty;
                $totalWeight += $weight;
                $totalCoin += $coin;

                $trashTransactionItems[] = [
                    'trash_transaction_code' => $code,
                    'trash_type_id' => $trashTypeId,
                    'qty' => $qty,
                    'weight' => $weight,
                    'coin' => $coin,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
            }

            TrashTransaction::insert([
                'code' => $code,
                'customer_id' => $customerId,
                'pickup_name' => $request->pickup_name,
                'pickup_telp' => $request->pickup_telp,
                'pickup_address' => $request->pickup_address,
                'pickup_location_detail' => !empty($request->pickup_location_detail) ? $request->pickup_location_detail : null,
                'status_code' => 'PENDING',
                'total_qty' => $totalQty,
                'total_weight' => $totalWeight,
                'total_coin' => $totalCoin,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            TrashTransactionItem::insert($trashTransactionItems);
            
            DB::commit();
            return $this->sendResponseSuccess('Transaksi berhasil dibuat', []);
        } catch (\Exception $e) {
            DB::rollback();
            return $this->sendResponseError($e->getMessage());
        }
    }

    public function cancelTrashTransaction(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'trash_transaction_code' => 'required',
        ], [
            'trash_transaction_code.required' => 'Kode transaksi tidak boleh kosong',
        ]);

        if($validation->fails()) {
            $errors = $validation->errors()->messages();
            foreach($errors as $error) {
                return $this->sendResponseError($error[0]);
            }
        }
        
        $trashTransaction = TrashTransaction::where('code', $request->trash_transaction_code)->where('status_code', 'PENDING')->first();
        if(empty($trashTransaction)) return $this->sendResponseError('Transaksi tidak bisa dibatalkan');

        $updateTrashTransaction = TrashTransaction::where('code', $request->trash_transaction_code)->update(['status_code' => 'CANCEL']);
        if(empty($updateTrashTransaction)) return $this->sendResponseError('Transaksi tidak bisa dibatalkan');

        return $this->sendResponseSuccess('Transaksi berhasil dibatalkan', []);
    }

    public function getTrashTransactionList(Request $request)
    {
        $token = $this->getTokenDetail($request->bearerToken());
        if(empty($token)) return $this->sendResponseError('Token tidak valid', 401);
        $customerId = $token->user_id;

        $trashTransactionList = [];
        $trashTransaction = TrashTransaction::where('customer_id', $customerId)
            ->orderBy('created_at', 'DESC')
            ->get();

        if(!empty($trashTransaction)) {
            foreach($trashTransaction as $transaction) {
                $trashTransactionList[] = [
                    'code' => $transaction->code,
                    'created_at' => date('d M Y, H:i', strtotime($transaction->created_at)),
                    'total_qty' => $transaction->total_qty,
                    'total_weight' => floatval($transaction->total_weight),
                    'total_coin' => $transaction->total_coin,
                    'status_code' => $transaction->status_code
                ];
            }
        }

        return $this->sendResponseSuccess('', ['trash_transaction_list' => $trashTransactionList]);
    }

    public function getTrashTransactionDetail(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'trash_transaction_code' => 'required',
        ], [
            'trash_transaction_code.required' => 'Kode transaksi tidak boleh kosong',
        ]);

        if($validation->fails()) {
            $errors = $validation->errors()->messages();
            foreach($errors as $error) {
                return $this->sendResponseError($error[0]);
            }
        }

        $trashTransaction = TrashTransaction::where('code', $request->trash_transaction_code)->first();
        if(empty($trashTransaction)) return $this->sendResponseError('Transaksi tidak ditemukan');

        $fetchTrashTransactionItem = TrashTransactionItem::select([
                'trash_type.name',
                'trash_type.description',
                'trash_type.image',
                'trash_transaction_item.qty',
                'trash_transaction_item.weight',
                'trash_transaction_item.coin'
            ])
            ->where('trash_transaction_item.trash_transaction_code', $trashTransaction->code)
            ->leftJoin('trash_type', 'trash_type.id', 'trash_transaction_item.trash_type_id')
            ->get();

        $trashTransactionItems = [];
        foreach($fetchTrashTransactionItem as $trashTransactionItem) {
            $trashTransactionItem['image'] = url('/img/trash-type/'.$trashTransactionItem->image);
            $trashTransactionItem['weight'] = floatval($trashTransactionItem->weight);

            $trashTransactionItems[] = $trashTransactionItem;
        }
        
        $trashTransaction['total_weight'] = floatval($trashTransaction->total_weight);
        $trashTransaction['trash_list'] = $trashTransactionItems;

        return $this->sendResponseSuccess('', ['trash_transaction' => $trashTransaction]);
    }
}
