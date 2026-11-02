<header class="top">
    <a class="top__brand" href="{{ route('dashboard.index') }}" aria-label="Satu Sehat — Dashboard">
        <span class="brand__mark" aria-hidden="true">
            <svg viewBox="0 0 24 24">
                <path d="M12 20.5s-7.5-4.4-7.5-10.2A4.3 4.3 0 0 1 12 7.6a4.3 4.3 0 0 1 7.5 2.7c0 5.8-7.5 10.2-7.5 10.2Z" />
                <path d="M8.5 12.5h2l1-2 1.6 4 1-2h1.4" />
            </svg>
        </span>
        Satu Sehat
    </a>
    <button type="button" class="finder-btn" id="btn-find" aria-label="Search (⌘K)">
        <svg class="ico" viewBox="0 0 24 24" aria-hidden="true">
            <circle cx="11" cy="11" r="6.5" />
            <path d="m16 16 4 4" />
        </svg>
        <span>Search patients, conversations, pages…</span>
        <kbd>⌘K</kbd>
    </button>
    <span class="top__spacer"></span>
    <div class="top__tools">
        <span class="clock" id="clock" title="Clinic time">
            <i aria-hidden="true"></i><span id="clock-time"></span><small id="clock-note"></small>
        </span>
        <button
            type="button"
            class="ibtn ibtn--glass mobile-menu-btn"
            id="btn-mobile-nav"
            aria-label="Buka Menu Navigasi"
            title="Buka Menu"
        >
            <svg class="ico" viewBox="0 0 24 24" aria-hidden="true">
                <line x1="4" y1="7" x2="20" y2="7" />
                <line x1="4" y1="12" x2="20" y2="12" />
                <line x1="4" y1="17" x2="20" y2="17" />
            </svg>
        </button>
        <button
            type="button"
            class="ibtn ibtn--glass btn-theme-toggle"
            id="btn-theme"
            aria-label="Toggle Mode Gelap/Terang"
            title="Ubah Tema"
        >
            <svg class="ico" viewBox="0 0 24 24" style="width:18px;height:18px;" aria-hidden="true"><path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/></svg>
        </button>
        <button
            type="button"
            class="ibtn ibtn--glass"
            id="btn-bell"
            aria-label="Notifications"
            aria-haspopup="dialog"
            aria-expanded="false"
        >
            <svg class="ico" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M6 16v-5a6 6 0 0 1 12 0v5l1.5 2h-15z" />
                <path d="M10 20.5a2 2 0 0 0 4 0" />
            </svg>
            <span class="dot-badge" id="bell-badge" hidden></span>
        </button>
        <button
            type="button"
            class="btn btn--primary top__new"
            id="btn-new"
            aria-label="Create new"
            aria-haspopup="menu"
            aria-expanded="false"
        >
            <svg class="ico" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14M5 12h14" /></svg>
            <span>New</span>
        </button>
    </div>
</header>
