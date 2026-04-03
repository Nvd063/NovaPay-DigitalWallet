<div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar(false)"></div>

<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-avatar" id="sideAvatar">
            {{ strtoupper(substr(Auth::user()->full_name, 0, 1)) }}
        </div>
        <div class="sidebar-info">
            <h6 id="sideUserName">{{ Auth::user()->full_name }}</h6>
            <small id="sideUserPhone">{{ Auth::user()->phone }}</small>
        </div>
        <button class="sidebar-close" onclick="toggleSidebar(false)">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>

    <nav class="sidebar-nav">
        <div class="s-label">Account</div>
        
        <div class="sidebar-item" onclick="window.location.href='{{ route('dashboard') }}'">
            <span class="s-icon"><i class="fa-solid fa-house"></i></span>
            <span>Dashboard</span>
            <i class="fa-solid fa-chevron-right s-chev"></i>
        </div>

        <div class="sidebar-item" onclick="window.location.href='{{ route('profile') }}'">
            <span class="s-icon"><i class="fa-solid fa-user-pen"></i></span>
            <span>My Profile</span>
            <i class="fa-solid fa-chevron-right s-chev"></i>
        </div>

        <div class="sidebar-item" onclick="window.location.href='{{ route('history') }}'">
            <span class="s-icon"><i class="fa-solid fa-clock-rotate-left"></i></span>
            <span>Transaction History</span>
            <i class="fa-solid fa-chevron-right s-chev"></i>
        </div>

        <div class="s-label">Appearance</div>
        <div class="sidebar-item theme-row">
            <span class="s-icon"><i class="fa-solid fa-palette"></i></span>
            <span>Theme</span>
            <div class="theme-swatches">
                <button class="swatch midnight active" onclick="setTheme('midnight')" title="Midnight"></button>
                <button class="swatch ocean" onclick="setTheme('ocean')" title="Ocean"></button>
                <button class="swatch forest" onclick="setTheme('forest')" title="Forest"></button>
                <button class="swatch rose" onclick="setTheme('rose')" title="Rose"></button>
            </div>
        </div>

        <div class="s-divider"></div>

        <div class="sidebar-item logout-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <span class="s-icon"><i class="fa-solid fa-right-from-bracket"></i></span>
            <span>Sign Out</span>
        </div>
    </nav>
    
    <p class="sidebar-ver">NovaPay v2.0 · Beta</p>
</div>