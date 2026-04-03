@extends('layouts.auth')
@section('title', 'Login')

@section('content')
<div id="loginBox" class="auth-card">
    <div class="auth-card-hdr"><h5>Welcome Back 👋</h5><p>Sign in to NovaPay</p></div>
    
    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="field-grp">
            <label>Mobile Number</label>
            <div class="field-wrap">
                <i class="fa-solid fa-mobile-screen fi"></i>
                <input type="tel" name="phone" placeholder="03xxxxxxxxx" maxlength="11" required />
            </div>
        </div>
        <div class="field-grp">
            <label>Your MPIN</label>
            <div class="pin-row">
                <input type="password" name="mpin_digits[]" class="pbox" maxlength="1" inputmode="numeric" required />
                <input type="password" name="mpin_digits[]" class="pbox" maxlength="1" inputmode="numeric" required />
                <input type="password" name="mpin_digits[]" class="pbox" maxlength="1" inputmode="numeric" required />
                <input type="password" name="mpin_digits[]" class="pbox" maxlength="1" inputmode="numeric" required />
            </div>
            <input type="hidden" name="mpin" id="fullMpin">
        </div>
        <button type="submit" class="btn-nova">Sign In <i class="fa-solid fa-arrow-right"></i></button>
    </form>
    <p class="auth-flip">New user? <a href="{{ route('register') }}">Create Account</a></p>
</div>

@push('scripts')
<script>
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