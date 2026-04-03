@extends('layouts.auth')
@section('title', 'Verify OTP')

@section('content')
<div class="auth-card">
    <div class="auth-card-hdr">
        <h5>Verify Phone</h5>
        <p>Enter the 4-digit code sent to your mobile.</p>
        @if(session('otp_sent'))
            <script>alert("Development Mode: Your OTP is {{ session('otp_sent') }}");</script>
        @endif
    </div>
    
    <form action="{{ route('otp.verify') }}" method="POST" id="otpForm">
        @csrf
        <div class="field-grp">
            <div class="pin-row" id="otpPinBoxes">
                <input type="password" name="otp_digits[]" class="pbox" maxlength="1" inputmode="numeric" required />
                <input type="password" name="otp_digits[]" class="pbox" maxlength="1" inputmode="numeric" required />
                <input type="password" name="otp_digits[]" class="pbox" maxlength="1" inputmode="numeric" required />
                <input type="password" name="otp_digits[]" class="pbox" maxlength="1" inputmode="numeric" required />
            </div>
            <input type="hidden" name="otp" id="fullOtp">
        </div>
        
        <button type="submit" class="btn-nova">Verify & Continue <i class="fa-solid fa-shield-check"></i></button>
    </form>
</div>

@push('scripts')
<script>
    const boxes = document.querySelectorAll('.pbox');
    boxes.forEach((box, i) => {
        box.addEventListener('input', () => {
            if (box.value && i < boxes.length - 1) boxes[i+1].focus();
            updateHiddenOtp();
        });
        box.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && !box.value && i > 0) boxes[i-1].focus();
        });
    });

    function updateHiddenOtp() {
        let val = "";
        boxes.forEach(b => val += b.value);
        document.getElementById('fullOtp').value = val;
    }
</script>
@endpush
@endsection