<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Otp;
use App\Models\User;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    // 1. Show Register Form
    public function showRegister()
    {
        
        return view('auth.register');
    }

    // 2. Handle Registration & Send OTP
    public function register(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|unique:users,phone|regex:/^03\d{9}$/',
        ]);

        // Generate 4-digit OTP
        $otpCode = rand(1000, 9999);

        // Save OTP in DB
        Otp::create([
            'phone' => $request->phone,
            'otp_code' => $otpCode,
            'expires_at' => Carbon::now()->addMinutes(10),
        ]);

        // Store temp data in session to use after OTP
        session(['reg_name' => $request->full_name, 'reg_phone' => $request->phone]);

        // Real world mein SMS jata, yahan hum Alert ke liye bhej rahe hain
        return redirect()->route('otp.verify')->with('otp_sent', $otpCode);
    }

    // 3. Show OTP Verify Page
    public function showOtpVerify()
    {
        return view('auth.otp');
    }

    // 4. Verify OTP Logic
    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required']);

        $otpRecord = Otp::where('phone', session('reg_phone'))
            ->where('otp_code', $request->otp)
            ->where('is_verified', false)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (!$otpRecord) {
            return back()->withErrors(['otp' => 'Invalid or Expired OTP']);
        }

        $otpRecord->update(['is_verified' => true]);
        return redirect()->route('mpin.set');
    }

    // 5. Show Set MPIN Page
    public function showSetMpin()
    {
        return view('auth.set-mpin');
    }

    // 6. Create Final User & Wallet
    public function storeMpin(Request $request)
    {
        $request->validate(['mpin' => 'required|digits:4']);

        DB::beginTransaction();
        try {
            // Create User
            $user = User::create([
                'full_name' => session('reg_name'),
                'phone' => session('reg_phone'),
                'mpin' => Hash::make($request->mpin),
                'status' => 'active'
            ]);

            // Generate Fake Card Number
            $cardNumber = rand(4000, 4999) . ' ' . rand(1000, 9999) . ' ' . rand(1000, 9999) . ' ' . rand(1000, 9999);

            // Create Wallet with 500 Welcome Bonus
            Wallet::create([
                'user_id' => $user->id,
                'balance' => 500.00,
                'card_number' => $cardNumber,
                'expiry_date' => Carbon::now()->addYears(5)->format('m/y'),
                'card_holder_name' => strtoupper($user->full_name),
            ]);

            DB::commit();

            // Clear Session
            session()->forget(['reg_name', 'reg_phone']);

            return redirect()->route('login')->with('success', 'Account created! Please Login.');

        } catch (\Exception $e) {
            DB::rollback();
            // Yeh line aapko bataye gi ke exact error kya hai (sirf debugging ke liye)
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

}