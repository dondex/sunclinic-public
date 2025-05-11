<footer class="footer mt-5">
<div class="bottom-nav mt-5 sticky-bottom shadow-sm  rounded mx-1">
    <div class="nav-item active">
        <a href="{{ url('/') }}">
            <div class="nav-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
            </div>
            <span>Home</span>
        </a>
    </div>

    <div class="nav-item">
        <a href="{{ url('about') }}" style="text-decoration: none;">
            <div class="nav-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="24" height="24" aria-label="Hospital icon" role="img">
                <rect x="3" y="7" width="18" height="14" rx="2" ry="2"></rect>
                <line x1="12" y1="11" x2="12" y2="19"></line>
                <line x1="9" y1="15" x2="15" y2="15"></line>
            </svg>

            </div>
            <!-- <span>About SunClinic</span> -->
            <span>About Obeid</span>
        </a>
    </div>

    <div class="nav-item">
    <a href="@auth {{ url('medical/' . Auth::id()) }} @else {{ route('login') }} @endauth" style="text-decoration: none; ">
            <div class="nav-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" width="24" height="24">
                <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
                <rect x="8" y="2" width="8" height="4" rx="1" ry="1"></rect>
                <circle cx="12" cy="14" r="4"></circle>
                <path d="M16 14h.01"></path>
            </svg>


            </div>
            <span>Medical File</span>
        </a>
    </div>

    <div class="nav-item">
        @if(Auth::check())
            <a href="{{ url('profile/' . Auth::id()) }}">
                <div class="nav-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </div>
                <span>Profile</span>
            </a>
        @else
            <a href="{{ route('login') }}">
                <div class="nav-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M10 3H6a2 2 0 0 0-2 2v14c0 1.1.9 2 2 2h4M16 17l5-5-5-5M19.8 12H9"></path>
                    </svg>
                </div>
                <span>Login</span>
            </a>
        @endif
    </div>
</div>

<style>
.bottom-nav {
    display: flex;
    justify-content: space-around;
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background-color: #007a3d;
    padding: 15px 0 10px;
    box-shadow: 0 -2px 5px rgba(0,0,0,0.1);
    border-radius: 12px 12px 0 0;
    z-index: 1000;
}

.nav-item {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.nav-item a {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-decoration: none;
    color: rgba(255,255,255,0.85);
    width: 100%;
    transition: all 0.3s ease;
}

.nav-icon {
    margin-bottom: 8px;
}

.nav-item.active a {
    color: #ffffff;
}

.nav-item.active svg {
    stroke-width: 2.5;
}

.nav-item span {
    font-size: 12px;
    font-weight: 500;
    letter-spacing: 0.3px;
    text-align: center;
}

/* Make sure the items have enough touchable area */
.nav-item a {
    padding: 5px 0;
}

/* Fix spacing for "SMC Hospitals" text which is longer */
.nav-item span {
    max-width: 100%;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* If the screen is very small, reduce icon size slightly */
@media (max-width: 320px) {
    .nav-icon svg {
        width: 22px;
        height: 22px;
    }
    
    .nav-item span {
        font-size: 11px;
    }
}
</style>
</footer>