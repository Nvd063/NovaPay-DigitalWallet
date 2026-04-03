@extends('frontend.main')
@section('content')
<div id="appUI">
    <div class="pg-sec active" style="padding: 20px;">
        <div class="pg-hdr">
            <button class="back-btn" onclick="window.location.href='{{ route('dashboard') }}'"><i
                    class="fa-solid fa-arrow-left"></i></button>
            <h5>My Profile</h5>
        </div>

        <div style="text-align: center; margin-bottom: 30px;">
            <div class="profile-big-avatar"
                style="width: 90px; height: 90px; margin: 0 auto 15px; font-size: 2.2rem; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, var(--accent), var(--accent2)); border-radius: 50%; color: white; font-family: 'Syne'; font-weight: 800; box-shadow: 0 15px 35px var(--glow);">
                {{ strtoupper(substr($user->full_name, 0, 1)) }}
            </div>
            <h4 style="font-weight: 700; margin-bottom: 5px;">{{ $user->full_name }}</h4>
            <p style="color: var(--muted); font-size: 13px;">Member since {{ $user->created_at->format('M Y') }}</p>
        </div>

        <div class="form-card">
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                <div class="field-grp">
                    <label>Full Name</label>
                    <div class="field-wrap">
                        <i class="fa-solid fa-user fi"></i>
                        <input type="text" name="full_name" value="{{ $user->full_name }}" required>
                    </div>
                </div>

                <div class="field-grp">
                    <label>Mobile Number</label>
                    <div class="field-wrap field-dis" style="opacity: 0.6; background: var(--surf3);">
                        <i class="fa-solid fa-mobile-screen fi"></i>
                        <input type="text" value="{{ $user->phone }}" disabled>
                    </div>
                    <small style="font-size: 10px; color: var(--muted); margin-top: 5px; display: block;">Phone number
                        cannot be changed.</small>
                </div>

                <button type="submit" class="btn-nova mt-4">Save Changes <i class="fa-solid fa-check"></i></button>
            </form>
        </div>

        <div class="home-sec" style="padding: 20px 0;">
            <div class="sec-hdr">
                <h6>Security</h6>
            </div>
            <div class="svc-list">
                <div class="svc-row" onclick="alert('Change MPIN logic coming soon!')">
                    <div class="svc-ic c1"><i class="fa-solid fa-shield-halved"></i></div>
                    <div class="svc-text">
                        <p>Update MPIN</p><small>Change your 4-digit security code</small>
                    </div>
                    <i class="fa-solid fa-chevron-right svc-chev"></i>
                </div>
            </div>
        </div>

        <div id="toast" class="toast-msg @if(session('success')) show success @endif">
            @if(session('success')) {{ session('success') }} @endif
        </div>
    </div>
</div>
@endsection