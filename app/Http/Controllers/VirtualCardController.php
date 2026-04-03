<?php

namespace App\Http\Controllers;

use App\Models\VirtualCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VirtualCardController extends Controller
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
        $spentThisMonth = \App\Models\Transaction::where('user_id', $user->id)
            ->whereMonth('created_at', now()->month)
            ->where('type', '!=', 'topup')
            ->sum('amount');

        $addedThisMonth = \App\Models\Transaction::where('user_id', $user->id)
            ->whereMonth('created_at', now()->month)
            ->where('type', 'topup')
            ->sum('amount');

        $recentTransactions = \App\Models\Transaction::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('frontend.pages.index', compact('user', 'selectedCard', 'spentThisMonth', 'addedThisMonth', 'recentTransactions'));
    }

    public function createCard(Request $request)
    {
        $user = Auth::user();

        // Check limit (Max 5 cards)
        if ($user->virtualCards()->count() >= 5) {
            return back()->withErrors(['error' => 'You can only create up to 5 virtual cards.']);
        }

        // Generate Unique Card Data
        $cardNumber = '4' . rand(100, 999) . ' ' . rand(1000, 9999) . ' ' . rand(1000, 9999) . ' ' . rand(1000, 9999);
        $cvv = rand(100, 999);
        $expiry = now()->addYears(3)->format('m/y');

        VirtualCard::create([
            'user_id' => $user->id,
            'card_number' => $cardNumber,
            'card_holder_name' => strtoupper($user->full_name),
            'expiry_date' => $expiry,
            'cvv' => $cvv,
            'spending_limit' => 50000.00 // Default limit
        ]);

        return redirect()->route('cards.index')->with('success', 'New Virtual Card Created!');
    }

    public function manage()
    {
        $user = Auth::user();

        // User ke saare cards fetch karein
        $cards = $user->virtualCards;

        return view('frontend.pages.manage_cards', compact('user', 'cards'));
    }

    // Card select karne ki logic (Dashboard par dikhane ke liye)
    public function selectCard($id)
    {
        $user = Auth::user();

        // Pehle saare cards ko unselect karein
        $user->virtualCards()->update(['is_selected' => false]);

        // Selected card ko active karein
        $card = $user->virtualCards()->findOrFail($id);
        $card->update(['is_selected' => true]);

        return redirect()->route('dashboard')->with('success', 'Card displayed on Dashboard!');
    }

    // Naya card create karne ki logic
    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->virtualCards()->count() >= 5) {
            return back()->withErrors(['error' => 'You can only have up to 5 cards.']);
        }

        $card = new VirtualCard();
        $card->user_id = $user->id;
        $card->card_number = '4412 ' . rand(1000, 9999) . ' ' . rand(1000, 9999) . ' ' . rand(1000, 9999);
        $card->card_holder_name = strtoupper($user->full_name);
        $card->expiry_date = now()->addYears(3)->format('m/y');
        $card->cvv = rand(100, 999);
        $card->spending_limit = $request->spending_limit ?? 50000;

        // Agar ye pehla card hai toh isay automatic select kar dein
        if ($user->virtualCards()->count() == 0) {
            $card->is_selected = true;
        }

        $card->save();

        return back()->with('success', 'New Virtual Card Generated!');
    }
}
