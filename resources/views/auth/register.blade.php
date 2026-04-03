@extends('layouts.auth')
@section('title', 'Create Account')

@section('content')
<div id="registerBox" class="auth-card">
    <div class="auth-card-hdr"><h5>Create Account</h5><p>Join NovaPay today</p></div>
    
    <form action="{{ route('register') }}" method="POST">
        @csrf
        <div class="field-grp">
            <label>Full Name</label>
            <div class="field-wrap">
                <i class="fa-solid fa-user fi"></i>
                <input type="text" name="full_name" placeholder="Ahmed Ali" required value="{{ old('full_name') }}" autocomplete="off" />
            </div>
        </div>
        <div class="field-grp">
            <label>Mobile Number</label>
            <div class="field-wrap">
                <i class="fa-solid fa-mobile-screen fi"></i>
                <input type="tel" name="phone" placeholder="03xxxxxxxxx" maxlength="11" required value="{{ old('phone') }}" />
            </div>
        </div>
        
        <button type="submit" class="btn-nova">Get OTP <i class="fa-solid fa-arrow-right"></i></button>
    </form>
    {{-- <p class="auth-flip">Have account? <a href="{{ route('login') }}">Sign In</a></p> --}}
</div>
@endsection