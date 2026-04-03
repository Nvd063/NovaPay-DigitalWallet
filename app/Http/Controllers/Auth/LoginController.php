<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'mpin' => 'required|digits:4'
        ]);

        $user = User::where('phone', $request->phone)->first();

        if ($user && Hash::check($request->mpin, $user->mpin)) {
            Auth::login($user);
            return redirect()->route('dashboard');
        }

        return back()->withErrors(['error' => 'Invalid Phone or MPIN']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}