<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    // 1. Process Money Transfer
    public function transfer(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'bank_name' => 'required',
            'account_number' => 'required'
        ]);

        $user = Auth::user();
        $wallet = $user->wallet;

        if ($wallet->balance < $request->amount) {
            return back()->withErrors(['error' => 'Insufficient balance!']);
        }

        DB::beginTransaction();
        try {
            // Deduct Balance
            $wallet->decrement('balance', $request->amount);

            // Create Transaction Record
            Transaction::create([
                'user_id' => $user->id,
                'tx_id' => 'NP' . strtoupper(Str::random(6)),
                'type' => 'transfer',
                'amount' => $request->amount,
                'recipient_detail' => $request->bank_name . " (" . $request->account_number . ")",
                'status' => 'success'
            ]);

            // Create Notification
            Notification::create([
                'user_id' => $user->id,
                'title' => 'Money Sent',
                'message' => "Rs. {$request->amount} sent to {$request->account_number} successfully."
            ]);

            DB::commit();
            return redirect()->route('dashboard')->with('success', 'Transfer Successful!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Transaction failed!']);
        }
    }

    // 2. Process Top-Up (Add Money)
    public function topup(Request $request)
    {
        $request->validate(['amount' => 'required|numeric|min:100']);

        $user = Auth::user();

        DB::beginTransaction();
        try {
            $user->wallet->increment('balance', $request->amount);

            Transaction::create([
                'user_id' => $user->id,
                'tx_id' => 'TP' . strtoupper(Str::random(6)),
                'type' => 'topup',
                'amount' => $request->amount,
                'recipient_detail' => 'Self Wallet',
                'status' => 'success'
            ]);

            DB::commit();
            return redirect()->route('dashboard')->with('success', 'Wallet Refilled!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Top-up failed!']);
        }
    }

    // 3. Process Bill Payment
    public function payBill(Request $request)
    {
        $request->validate(['amount' => 'required|numeric|min:1', 'reference_id' => 'required', 'bill_type' => 'required']);

        $user = Auth::user();
        if ($user->wallet->balance < $request->amount)
            return back()->withErrors(['error' => 'Insufficient Balance']);

        DB::transaction(function () use ($user, $request) {
            $user->wallet->decrement('balance', $request->amount);
            Transaction::create([
                'user_id' => $user->id,
                'tx_id' => 'BL' . strtoupper(Str::random(6)),
                'type' => 'bill',
                'amount' => $request->amount,
                'recipient_detail' => "{$request->bill_type} ({$request->reference_id})",
                'status' => 'success'
            ]);
        });
        return redirect()->route('dashboard')->with('success', 'Bill Paid Successfully!');
    }

    // 4. Process Mobile Load
    public function mobileLoad(Request $request)
    {
        $request->validate(['amount' => 'required|numeric|min:50', 'phone' => 'required', 'network' => 'required']);

        $user = Auth::user();
        if ($user->wallet->balance < $request->amount)
            return back()->withErrors(['error' => 'Insufficient Balance']);

        DB::transaction(function () use ($user, $request) {
            $user->wallet->decrement('balance', $request->amount);
            Transaction::create([
                'user_id' => $user->id,
                'tx_id' => 'LD' . strtoupper(Str::random(6)),
                'type' => 'load',
                'amount' => $request->amount,
                'recipient_detail' => "{$request->network} ({$request->phone})",
                'status' => 'success'
            ]);
        });
        return redirect()->route('dashboard')->with('success', 'Mobile Recharge Done!');
    }
}