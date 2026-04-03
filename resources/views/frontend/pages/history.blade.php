@extends('frontend.main')
@section('content')
    <div id="appUI">
        <div class="pg-sec active" style="padding: 20px;">
            <div class="pg-hdr">
                <button class="back-btn" onclick="window.location.href='{{ route('dashboard') }}'"><i
                        class="fa-solid fa-arrow-left"></i></button>
                <h5>Transaction History</h5>
            </div>

            <div class="filter-row">
                <a href="{{ route('history', ['type' => 'all']) }}"
                    class="fbtn {{ request('type') == 'all' || !request('type') ? 'active' : '' }}">All</a>
                <a href="{{ route('history', ['type' => 'transfer']) }}"
                    class="fbtn {{ request('type') == 'transfer' ? 'active' : '' }}">Transfers</a>
                <a href="{{ route('history', ['type' => 'bill']) }}"
                    class="fbtn {{ request('type') == 'bill' ? 'active' : '' }}">Bills</a>
                <a href="{{ route('history', ['type' => 'load']) }}"
                    class="fbtn {{ request('type') == 'load' ? 'active' : '' }}">Loads</a>
                <a href="{{ route('history', ['type' => 'topup']) }}"
                    class="fbtn {{ request('type') == 'topup' ? 'active' : '' }}">Top-Up</a>
            </div>

            <div class="search-wrap">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="historySearch" placeholder="Search transactions..." onkeyup="filterList()">
            </div>

            <div id="historyList">
                {{-- Loop through grouped dates --}}
                @forelse($groupedTransactions as $transactionDate => $dayTransactions)
                    <div class="hist-date-group">
                        <p class="hist-date-lbl">{{ $transactionDate }}</p>

                        {{-- Yahan $transaction variable use karein --}}
                        @foreach($dayTransactions as $transaction)
                            <div class="tx-item searchable" data-text="{{ strtolower($transaction->type ?? '')  }}">
                                <div class="tx-left">
                                    {{-- Check karein ke line 36 par $transaction->type hi likha ho --}}
                                    <div class="tx-ic {{ $transaction->type == 'topup' ? 'green' : '' }}">
                                        <i
                                            class="fa-solid {{ $transaction->type == 'transfer' ? 'fa-paper-plane' : ($transaction->type == 'bill' ? 'fa-bolt' : 'fa-circle-plus') }}"></i>
                                    </div>
                                    <div>
                                        <div class="tx-ttl">{{ ucfirst($transaction->type) }}</div>
                                        <div class="tx-sub">{{ $transaction->recipient_detail }} &middot;
                                            <span style="opacity:.6;font-size:10px">{{ $transaction->tx_id }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="tx-amt {{ $transaction->type == 'topup' ? 'credit' : 'debit' }}">
                                    {{ $transaction->type == 'topup' ? '+' : '-' }}Rs.{{ number_format($transaction->amount, 2) }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @empty
                    <p class="empty-state">No transactions found.</p>
                @endforelse
            </div>
        </div>

    </div>
@endsection