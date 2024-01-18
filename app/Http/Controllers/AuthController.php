<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function userLogin()
    {
        return view('user.login');
    }

    public function adminLogin()
    {
        return view('admin.login');
    }

    public function userDashboard()
    {
        return view('user.dashboard');
    }

    public function adminDashboard()
    {
        return view('admin.dashboard');
    }

    public function userLoginProcess(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:3',
        ]);

        $login_credentails = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (auth()->guard('user')->attempt($login_credentails)) {
            return redirect()->route('user.dashboard');
        } else {
            return back()->with('fail', 'Invalid Credentials');
        }
    }

    public function adminLoginProcess(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:3',
        ]);

        $login_credentails = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        if (auth()->guard('admin')->attempt($login_credentails)) {
            return redirect()->route('admin.dashboard');
        } else {
            return back()->with('fail', 'Invalid Credentials');
        }
    }

    public function userLogout()
    {
        Auth::guard('user')->logout();
        return redirect()->route('user.login');
    }

    public function adminLogout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
