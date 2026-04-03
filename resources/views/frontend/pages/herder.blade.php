<header class="app-hdr">
    <div class="hdr-top">
        <button class="hbtn" onclick="toggleSidebar(true)">
            <i class="fa-solid fa-bars-staggered"></i>
        </button>
        <div class="hdr-wordmark">Nova<span>Pay</span></div>
        <form action="{{ route('logout') }}" method="POST" id="logout-form">
            @csrf
            <button type="submit" class="hbtn"><i class="fa-solid fa-right-from-bracket"></i></button>
        </form>
    </div>
    <div class="hdr-greet">
        <div>
            <p class="greet-line">Welcome back,</p>
            <h3 id="displayUserName">{{ explode(' ', $user->full_name ?? '')[0] }}</h3>
        </div>
        {{-- <div class="hdr-bal-pill">
            <small>Balance</small>
            <strong>Rs. {{ number_format($selectedCard->spending_limit ?? 0, 2) }}</strong>
        </div> --}}
    </div>
</header>