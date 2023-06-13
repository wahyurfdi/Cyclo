<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::select('id', 'name', 'email', 'created_at')
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('cms.master.user-account', compact('users'));
    }

    public function storeUser(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ], [
            'name.required' => 'Nama tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'password.required' => 'Password tidak boleh kosong'
        ]);

        if($validation->fails()) {
            $errors = $validation->errors()->messages();
            foreach($errors as $error) {
                return $this->sendResponseError($error[0]);
            }
        }

        $store = User::insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        if(!$store) {
            return $this->sendResponseError('Terjadi kesalahan internal');
        }

        return $this->sendResponseSuccess('Berhasil menambah data', []);
    }

    public function getUserDetail(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'user_id' => 'required',
        ], [
            'user_id.required' => 'User tidak ditemukan',
        ]);

        if($validation->fails()) {
            $errors = $validation->errors()->messages();
            foreach($errors as $error) {
                return $this->sendResponseError($error[0]);
            }
        }

        $detail = User::where('id', $request->user_id)->first();

        if(empty($detail)) {
            return $this->sendResponseError('Terjadi kesalahan internal');
        }

        return $this->sendResponseSuccess('Berhasil menampilkan data', $detail);
    }

    public function updateUser(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'user_id' => 'required',
            'name' => 'required',
            'email' => 'required',
        ], [
            'user_id.required' => 'ID tidak boleh kosong',
            'name.required' => 'Nama tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
        ]);

        if($validation->fails()) {
            $errors = $validation->errors()->messages();
            foreach($errors as $error) {
                return $this->sendResponseError($error[0]);
            }
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if(!empty($request->password)) $data['password'] = Hash::make($request->password);

        $update = User::where('id', $request->user_id)->update($data);

        if(!$update) {
            return $this->sendResponseError('Terjadi kesalahan internal');
        }

        return $this->sendResponseSuccess('Berhasil mengubah data', []);
    }

    public function deleteUser(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'user_id' => 'required',
        ], [
            'user_id.required' => 'User tidak ditemukan',
        ]);

        if($validation->fails()) {
            $errors = $validation->errors()->messages();
            foreach($errors as $error) {
                return $this->sendResponseError($error[0]);
            }
        }

        $delete = User::where('id', $request->user_id)->delete();

        if(!$delete) {
            return $this->sendResponseError('Terjadi kesalahan internal');
        }

        return $this->sendResponseSuccess('Berhasil menghapus data', []);
    }
}
