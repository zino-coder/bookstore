<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function viewLogin()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credential = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        $user = Auth::guard('admin')->attempt($credential);

        if ($user) {
            return redirect()->route('categories.index');
        }

        return redirect()->back()->withErrors(['login' => 'Sai tài khoản hoặc mật khẩu!'])->withInput();
    }

    public function logout()
    {
        Auth::guard('admin')->logout();

        return redirect()->route('admin.login');
    }
}
