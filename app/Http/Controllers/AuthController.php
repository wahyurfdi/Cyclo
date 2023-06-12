<?php

namespace App\Http\Controllers;

use Auth;
use Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        return view('cms/login');
    }

    public function login(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ], [
            'email.required' => 'Email tidak boleh kosong',
            'password.required' => 'Password tidak boleh kosong'
        ]);

        $email = $request->email;
        $password = $request->password;

        if($validation->fails()) {
            return redirect()->to('/cms/login')->withErrors($validation)->withInput($request->except(['password']));
        }

        if(Auth::attempt(['email' => $email, 'password' => $password])) {
            return redirect()->to('/cms/dashboard');
        }
        
        return redirect('/cms/login');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/cms/login');
    }
}
