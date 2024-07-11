<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class HomeController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function doLogin(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required']
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return response()->json([
                'success'   => true,
                'message'   => "Đăng nhập thành công",
                'redirect'  => route('dashboard')

            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => "Đăng nhập thất bại",
        ], 200);    
    }

    public function viewDashboard()
    {
        return view('dashboard');
    }

    public function dangXuat()
    {
        Auth::logout();
        return view('login');
    }
}
