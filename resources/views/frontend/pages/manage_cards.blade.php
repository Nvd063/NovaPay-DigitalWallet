@extends('frontend.main')

@section('content')
<div class="pg-sec active" style="padding: 20px;">
    <div class="pg-hdr">
        <button class="back-btn" onclick="window.location.href='{{ route('dashboard') }}'">
            <i class="fa-solid fa-arrow-left"></i>
        </button>
        <h5>Manage Virtual Cards</h5>
    </div>

    <div class="card-list" style="margin-top: 20px;">
        {{-- Loop saare cards par chalna chahiye --}}
        @foreach($cards as $card)
            <div class="card-item" onclick="window.location.href='{{ route('cards.select', $card->id) }}'" 
                 style="cursor: pointer; margin-bottom: 20px; position: relative;">
                
                @if($card->is_selected)
                    <span style="position: absolute; top: 15px; right: 15px; z-index: 10; background: #3dd68c; color: #000; padding: 4px 12px; border-radius: 20px; font-size: 10px; font-weight: 800; box-shadow: 0 4px 10px rgba(61,214,140,0.3);">
                        ACTIVE
                    </span>
                @endif

                <div class="nova-card" style="{{ $card->is_selected ? 'border: 2px solid var(--accent);' : 'opacity: 0.6;' }}">
                    <div class="card-top">
                        <div class="card-brand"><span class="cbrand-name">NovaPay</span></div>
                    </div>
                    <div class="card-mid">
                        <h2 class="cba">Rs. {{ number_format($card->spending_limit, 0) }}</h2>
                    </div>
                    <div class="card-num"><span>{{ $card->card_number }}</span></div>
                </div>
            </div>
        @endforeach

        {{-- Add Card Slot check --}}
        @if($cards->count() < 5)
            <div class="add-card-slot" id="openCreateModal" style="height: 150px; border: 2px dashed #444; border-radius: 20px; display: flex; align-items: center; justify-content: center; cursor: pointer; background: rgba(255,255,255,0.05);">
                <div style="text-align: center;">
                    <i class="fa-solid fa-plus" style="font-size: 24px; color: var(--accent);"></i>
                    <p style="margin-top: 10px; color: #ccc;">Create New Card</p>
                    <small style="color: #666;">({{ 5 - $cards->count() }} slots left)</small>
                </div>
            </div>
        @endif
    </div>
</div>

{{-- Modal Code (Wahi jo aapne likha tha) --}}
<div id="addCardModal" class="moverlay" style="display:none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 9999; align-items: flex-end;">
    <div class="msheet" style="width: 100%; background: #1a1a1a; border-radius: 30px 30px 0 0; padding: 30px 20px; position: relative;">
        <div class="mhdr" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h6 style="margin: 0;">New Virtual Card</h6>
            <button type="button" id="closeCreateModal" style="background: none; border: none; color: #fff; font-size: 24px;">&times;</button>
        </div>
        
        <form action="{{ route('cards.store') }}" method="POST">
            @csrf
            <div class="field-grp">
                <label style="display: block; margin-bottom: 10px; color: #888;">Spending Limit</label>
                <div class="field-wrap" style="background: #222; padding: 15px; border-radius: 15px; display: flex; align-items: center;">
                    <span style="margin-right: 10px; color: var(--accent);">Rs.</span>
                    <input type="number" name="spending_limit" value="50000" style="background: none; border: none; color: #fff; outline: none; width: 100%;" required>
                </div>
            </div>
            <button type="submit" class="btn-nova" style="width: 100%; background: var(--accent); color: #000; border: none; padding: 18px; border-radius: 15px; font-weight: 700; margin-top: 25px;">
                Generate Card <i class="fa-solid fa-bolt"></i>
            </button>
        </form>
    </div>
</div>

<script>
    const openBtn = document.getElementById('openCreateModal');
    const closeBtn = document.getElementById('closeCreateModal');
    const modal = document.getElementById('addCardModal');

    if (openBtn) {
        openBtn.addEventListener('click', () => { modal.style.display = 'flex'; });
    }
    if (closeBtn) {
        closeBtn.addEventListener('click', () => { modal.style.display = 'none'; });
    }
    window.addEventListener('click', (e) => {
        if (e.target == modal) { modal.style.display = 'none'; }
    });
</script>
@endsection