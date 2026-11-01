<header class="top">
    <a class="top__brand" href="{{ route('dashboard.index') }}" aria-label="Tend — today">
        <span class="brand__mark" aria-hidden="true">
            <svg viewBox="0 0 24 24">
                <path d="M12 20.5s-7.5-4.4-7.5-10.2A4.3 4.3 0 0 1 12 7.6a4.3 4.3 0 0 1 7.5 2.7c0 5.8-7.5 10.2-7.5 10.2Z" />
                <path d="M8.5 12.5h2l1-2 1.6 4 1-2h1.4" />
            </svg>
        </span>
        tend
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
            class="ibtn ibtn--glass top__mgmt-btn"
            id="btn-mgmt-mobile"
            aria-label="Manajemen User"
            title="Manajemen User"
        >
            <svg class="ico" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                <circle cx="9" cy="7" r="4" />
                <path d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75" />
            </svg>
        </button>
        <button type="button" class="ibtn ibtn--glass" id="btn-theme" aria-label="Switch to dark theme">
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
