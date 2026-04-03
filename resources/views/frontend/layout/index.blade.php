@extends('frontend.main')

@section('content')
    <div class="app-body">

        <div class="card-wrap">
            <div class="nova-card">
                <div class="card-glow"></div>

                <div class="card-top">
                    <div class="card-chip">
                        <div class="ch"></div>
                        <div class="ch"></div>
                        <div class="cv"></div>
                        <div class="cv"></div>
                    </div>
                    <div class="card-brand">
                        <span class="cbrand-name">NovaPay</span>
                        <span class="cbrand-type">VIRTUAL</span>
                    </div>
                </div>

                <div class="card-mid">
                    <p class="cbl">Card Spending Limit</p>
                    <h2 class="cba">Rs. {{ number_format($selectedCard->spending_limit ?? 0, 2) }}</h2>
                </div>

                <div class="card-bot">
                    <div>
                        <p class="cbl">CARD HOLDER</p>
                        <p class="cbv">{{ strtoupper($user->full_name) }}</p>
                    </div>
                    <div class="text-end">
                        <p class="cbl">EXPIRES</p>
                        <p class="cbv">{{ $selectedCard->expiry_date ?? '00/00' }}</p>
                    </div>
                </div>

                <div class="card-num">
                    <span>{{ $selectedCard->card_number ?? 'No Virtual Card Active' }}</span>
                </div>
            </div>
        </div>

        <div class="qact-row">
            <button class="qact" onclick="openModal('topUpModal')">
                <div class="qact-ic"><i class="fa-solid fa-plus"></i></div>
                <span>Add</span>
            </button>

            <button class="qact" onclick="openModal('sendModal')">
                <div class="qact-ic"><i class="fa-solid fa-paper-plane"></i></div>
                <span>Send</span>
            </button>

            <button class="qact" onclick="openModal('billModal')">
                <div class="qact-ic"><i class="fa-solid fa-bolt"></i></div>
                <span>Bills</span>
            </button>

            <button class="qact" onclick="openModal('loadModal')">
                <div class="qact-ic"><i class="fa-solid fa-sim-card"></i></div>
                <span>Load</span>
            </button>

            <button class="qact" onclick="window.location.href='{{ route('cards.manage') }}'">
                <div class="qact-ic"><i class="fa-solid fa-credit-card"></i></div>
                <span>Cards</span>
            </button>
        </div>

        <div class="home-sec">
            <div class="sec-hdr">
                <h6>This Month <span class="mchip">{{ now()->format('F Y') }}</span></h6>
            </div>
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-ic out"><i class="fa-solid fa-arrow-up"></i></div>
                    <div>
                        <p class="stat-lbl">Spent</p>
                        <p class="stat-val">Rs. {{ number_format($spentThisMonth, 0) }}</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-ic in"><i class="fa-solid fa-arrow-down"></i></div>
                    <div>
                        <p class="stat-lbl">Added</p>
                        <p class="stat-val">Rs. {{ number_format($addedThisMonth, 0) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="home-sec pb-nav">
            <div class="sec-hdr">
                <h6>Recent Activity</h6>
                <a href="{{ route('history') }}" class="see-all-lnk">See all</a>
            </div>

            <div id="recentTxList">
                @forelse($recentTransactions as $tx)
                    <div class="tx-item">
                        <div class="tx-left">
                            <div class="tx-ic {{ $tx->type == 'topup' ? 'green' : '' }}">
                                <i
                                    class="fa-solid {{ $tx->type == 'transfer' ? 'fa-paper-plane' : ($tx->type == 'bill' ? 'fa-bolt' : 'fa-circle-plus') }}"></i>
                            </div>
                            <div>
                                <div class="tx-ttl">{{ ucfirst($tx->type) }}</div>
                                <div class="tx-sub">{{ $tx->recipient_detail }} &middot; {{ $tx->created_at->format('d M') }}
                                </div>
                            </div>
                        </div>
                        <div class="tx-amt {{ $tx->type == 'topup' ? 'credit' : 'debit' }}">
                            {{ $tx->type == 'topup' ? '+' : '-' }}Rs.{{ number_format($tx->amount, 2) }}
                        </div>
                    </div>
                @empty
                    <p class="empty-state">No transactions yet</p>
                @endforelse
            </div>
        </div>
    </div>

    <div id="topUpModal" class="moverlay" style="display:none">
        <div class="msheet">
            <div class="mdrag"></div>
            <div class="mhdr">
                <h6>Add Money</h6>
                <button class="mx" onclick="closeModal('topUpModal')">×</button>
            </div>
            <form action="{{ route('topup.process') }}" method="POST">
                @csrf
                <div class="field-grp mt-3">
                    <label>Amount (PKR)</label>
                    <div class="field-wrap amt-wrap">
                        <span class="fpre">Rs.</span>
                        <input type="number" name="amount" placeholder="0.00" min="100" required>
                    </div>
                </div>
                <button type="submit" class="btn-nova mt-3">Refill Wallet</button>
            </form>
        </div>
    </div>

    <div id="sendModal" class="moverlay" style="display:none">
        <div class="msheet">
            <div class="mdrag"></div>
            <div class="mhdr">
                <h6>Send Money</h6>
                <button class="mx" onclick="closeModal('sendModal')">×</button>
            </div>
            <form action="{{ route('transfer.process') }}" method="POST">
                @csrf
                <div class="field-grp">
                    <label>Bank Name</label>
                    <div class="field-wrap">
                        <i class="fa-solid fa-building-columns fi"></i>
                        <input type="text" name="bank_name" placeholder="e.g. HBL, Easypaisa" required>
                    </div>
                </div>
                <div class="field-grp">
                    <label>Account / Phone</label>
                    <div class="field-wrap">
                        <i class="fa-solid fa-hashtag fi"></i>
                        <input type="text" name="account_number" placeholder="03xxxxxxxxx" required>
                    </div>
                </div>
                <div class="field-grp">
                    <label>Amount</label>
                    <div class="field-wrap amt-wrap">
                        <span class="fpre">Rs.</span>
                        <input type="number" name="amount" min="1" required>
                    </div>
                </div>
                <button type="submit" class="btn-nova mt-3">Send Now</button>
            </form>
        </div>
    </div>

    <div id="billModal" class="moverlay" style="display:none">
        <div class="msheet">
            <div class="mdrag"></div>
            <div class="mhdr">
                <h6>Pay Utility Bill</h6>
                <button class="mx" onclick="closeModal('billModal')">×</button>
            </div>
            <form action="{{ route('bill.process') }}" method="POST">
                @csrf
                <div class="bill-grid mb-3">
                    <label class="bill-tile">
                        <input type="radio" name="bill_type" value="Electricity" checked style="display:none">
                        <i class="fa-solid fa-bolt"></i><span>Electricity</span>
                    </label>
                    <label class="bill-tile">
                        <input type="radio" name="bill_type" value="Gas" style="display:none">
                        <i class="fa-solid fa-fire"></i><span>Gas</span>
                    </label>
                </div>
                <div class="field-grp">
                    <label>Consumer Reference</label>
                    <div class="field-wrap">
                        <i class="fa-solid fa-barcode fi"></i>
                        <input type="text" name="reference_id" placeholder="14-digit No." required>
                    </div>
                </div>
                <div class="field-grp">
                    <label>Amount</label>
                    <div class="field-wrap amt-wrap">
                        <span class="fpre">Rs.</span>
                        <input type="number" name="amount" min="1" required>
                    </div>
                </div>
                <button type="submit" class="btn-nova mt-3">Pay Bill Now</button>
            </form>
        </div>
    </div>

    <div id="loadModal" class="moverlay" style="display:none">
        <div class="msheet">
            <div class="mdrag"></div>
            <div class="mhdr">
                <h6>Mobile Load</h6>
                <button class="mx" onclick="closeModal('loadModal')">×</button>
            </div>
            <form action="{{ route('load.process') }}" method="POST">
                @csrf
                <div class="net-grid mb-3">
                    <label class="net-tile">
                        <input type="radio" name="network" value="Jazz" checked style="display:none">Jazz
                    </label>
                    <label class="net-tile">
                        <input type="radio" name="network" value="Zong" style="display:none">Zong
                    </label>
                </div>
                <div class="field-grp">
                    <label>Mobile Number</label>
                    <div class="field-wrap">
                        <i class="fa-solid fa-mobile-screen fi"></i>
                        <input type="tel" name="phone" placeholder="03xxxxxxxxx" maxlength="11" required>
                    </div>
                </div>
                <div class="field-grp">
                    <label>Amount</label>
                    <div class="field-wrap amt-wrap">
                        <span class="fpre">Rs.</span>
                        <input type="number" name="amount" min="50" required>
                    </div>
                </div>
                <button type="submit" class="btn-nova mt-3">Recharge Now</button>
            </form>
        </div>
    </div>

    <div id="toast" class="toast-msg @if(session('success')) show success @elseif($errors->any()) show error @endif">
        @if(session('success'))
            {{ session('success') }}
        @elseif($errors->any())
            {{ $errors->first() }}
        @endif
    </div>

@endsection