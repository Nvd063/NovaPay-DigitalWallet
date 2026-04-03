@extends('layouts.auth')
@section('title', 'Set MPIN')

@section('content')
<div class="auth-card">
    <div class="auth-card-hdr"><h5>Security First</h5><p>Create a 4-digit MPIN for your transactions.</p></div>
    
    <form action="{{ route('mpin.set') }}" method="POST">
        @csrf
        <div class="field-grp">
            <div class="pin-row" id="mpinBoxes">
                <input type="password" name="mpin_digits[]" class="pbox" maxlength="1" inputmode="numeric" required />
                <input type="password" name="mpin_digits[]" class="pbox" maxlength="1" inputmode="numeric" required />
                <input type="password" name="mpin_digits[]" class="pbox" maxlength="1" inputmode="numeric" required />
                <input type="password" name="mpin_digits[]" class="pbox" maxlength="1" inputmode="numeric" required />
            </div>
            <input type="hidden" name="mpin" id="fullMpin">
        </div>
        
        <button type="submit" class="btn-nova">Complete Setup <i class="fa-solid fa-check-double"></i></button>
    </form>
</div>

@push('scripts')
<script>
    // Similar pin logic to OTP
    const boxes = document.querySelectorAll('.pbox');
    boxes.forEach((box, i) => {
        box.addEventListener('input', () => {
            if (box.value && i < boxes.length - 1) boxes[i+1].focus();
            document.getElementById('fullMpin').value = Array.from(boxes).map(b => b.value).join('');
        });
    });
</script>
@endpush
@endsection