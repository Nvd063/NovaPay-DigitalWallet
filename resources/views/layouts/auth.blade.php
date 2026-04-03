<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NovaPay — @yield('title')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
</head>
<body class="theme-midnight">
    <div id="authOverlay">
        <div class="auth-orbs"><div class="orb o1"></div><div class="orb o2"></div><div class="orb o3"></div></div>
        <div class="auth-shell">
            <div class="auth-brand">
                <div class="nova-logo"><div class="nova-ring"></div><span class="nova-n"></span></div>
                <h1 class="nova-wordmark">NovaPay</h1>
                <p class="nova-sub">Your money. Smarter. Faster.</p>
            </div>

            @yield('content')
            
        </div>
    </div>

    <div id="toast" class="toast-msg @if(session('success')) show success @elseif($errors->any()) show error @endif">
        @if(session('success')) {{ session('success') }}
        @elseif($errors->any()) {{ $errors->first() }}
        @endif
    </div>

    <script>
        // Auto-hide toast
        setTimeout(() => { document.getElementById('toast').classList.remove('show'); }, 4000);
    </script>
    @stack('scripts')
</body>
</html>