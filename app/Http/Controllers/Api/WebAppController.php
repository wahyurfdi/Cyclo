<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Customer;

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
            return $this->sendResponseError('User tidak ditemukan', 401);
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

    public function getProfile(Request $request)
    {
        $token = $this->getTokenDetail($request->bearerToken());
        if(empty($token)) return $this->sendResponseError('Token tidak valid', 401);
        $customerId = $token->user_id;
        
        $customer = Customer::where('id', $customerId)->first();
        if(empty($customer)) return $this->sendResponseError('User tidak ditemukan');

        return $this->sendResponseSuccess('', [
            'name' => $customer->name,
            'username' => $customer->username,
            'coin' => $customer->coin
        ]);
    }
}
