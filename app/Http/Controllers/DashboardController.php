<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\VirtualCard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Pehle wo card dhundo jo 'is_selected' true hai
        $selectedCard = VirtualCard::where('user_id', $user->id)
            ->where('is_selected', true)
            ->first();

        // Agar koi card selected nahi hai, toh sab se naya wala uthao automatic
        if (!$selectedCard) {
            $selectedCard = VirtualCard::where('user_id', $user->id)
                ->latest()
                ->first();
        }

        // Baqi statistics
        $spentThisMonth = Transaction::where('user_id', $user->id)
            ->whereMonth('created_at', now()->month)
            ->where('type', '!=', 'topup')
            ->sum('amount');

        $addedThisMonth = Transaction::where('user_id', $user->id)
            ->whereMonth('created_at', now()->month)
            ->where('type', 'topup')
            ->sum('amount');

        $recentTransactions = Transaction::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('frontend.layout.index', compact('user', 'selectedCard', 'spentThisMonth', 'addedThisMonth', 'recentTransactions'));
    }

    public function history(Request $request)
    {
        // User ki transactions ko group karein date wise
        $user = Auth::user();
        $transactions = Auth::user()->transactions()->orderBy('created_at', 'desc')->get();

        $groupedTransactions = $transactions->groupBy(function ($item) {
            return $item->created_at->format('d M Y');
        });

        return view('frontend.pages.history', compact('groupedTransactions', 'user'));
    }
    public function profile()
    {
        $user = Auth::user()->load('wallet');
        return view('frontend.pages.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        $user->update([
            'full_name' => $request->full_name
        ]);

        return back()->with('success', 'Profile updated successfully!');
    }
}