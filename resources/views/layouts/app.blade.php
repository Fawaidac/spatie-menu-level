<!doctype html>
<!-- Tend — the clinic CRM that answers on WhatsApp — © 2026 Hasib (OVERSHOOT). All rights reserved. -->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
    <meta name="robots" content="noindex, nofollow" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>Satu Sehat — RSUD dr. Soebandi</title>
    <meta name="description" content="Satu Sehat — Sistem Informasi Manajemen Rumah Sakit RSUD dr. Soebandi Jember." />
    <meta name="theme-color" content="#fdf0f4" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Geist:wght@400..800&family=Geist+Mono:wght@400..600&display=swap"
        rel="stylesheet"
    />

    <!-- Theme Init -->
    <script>
        (function (d) {
            d.classList.add('js');
            try {
                var t = JSON.parse(localStorage.getItem('tend:theme') || '"light"');
                d.dataset.theme =
                    t === 'system' ? (matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light') : t;
            } catch (e) {
                d.dataset.theme = 'light';
            }
            d.classList.add('is-ready');
        })(document.documentElement);
    </script>

    <!-- Global Tend Shell CSS -->
    <link rel="stylesheet" href="{{ asset('tend/assets/index-C_0VME2I.css') }}" />
    <style>
        /* Smooth Page & Section entrance animation across all pages */
        @keyframes pageFadeInUp {
            from {
                opacity: 0;
                transform: translateY(16px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .main {
            animation: pageFadeInUp 0.8s cubic-bezier(0.25, 0.1, 0.25, 1) forwards;
            will-change: opacity, transform;
        }

        .mgmt-page,
        section.view,
        section.card,
        .head {
            animation: pageFadeInUp 0.8s cubic-bezier(0.25, 0.1, 0.25, 1) forwards;
            will-change: opacity, transform;
        }
    </style>

    <!-- Page CSS Stylesheets (scoped by [data-view]) -->
    <link rel="stylesheet" href="{{ asset('tend/assets/today-rY2azoiN.css') }}" />

    {{-- Brand Override: PaleVioletRed #DB7093 --}}
    @vite (['resources/css/app.css'])

    <!-- Favicons -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="48x48" />
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml" />
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}" />
</head>
<body>
    <a class="skip" href="#main">Skip to content</a>

    <div class="app">
        {{-- Sidebar --}}
        @include ('partials.sidebar')

        <div class="main-col">
            {{-- Top Header --}}
            @include ('partials.header')

            {{-- Main Content --}}
            <main id="main" class="main">
                @yield ('content')
            </main>
        </div>
    </div>

    <!-- Mobile Navigation Drawer -->
    @include ('partials.mobile-drawer')

    <!-- Scrim & Pop layer -->
    <div class="scrim" id="scrim" aria-hidden="true"></div>
    <div class="pop-layer" id="pop-layer"></div>

    <!-- Finder Dialog -->
    @include ('partials.finder')

    <!-- Modals & Drawers -->
    <dialog class="modal" id="modal"></dialog>
    <dialog class="drawer" id="drawer"></dialog>

    <!-- Toast Notification -->
    @include ('partials.toast')

    <!-- Account Popover Menu -->
    <div
        class="pop"
        id="menu-me-pop"
        style="
            display: none;
            position: fixed;
            bottom: 74px;
            left: 14px;
            z-index: 90;
            min-width: 230px;
            background: var(--surface);
            border: 1px solid var(--line-2);
            border-radius: 14px;
            box-shadow: var(--shadow-pop);
            padding: 8px 0;
        "
    >
        <div style="padding: 10px 16px 8px; border-bottom: 1px solid var(--line)">
            <div style="font-weight: 700; font-size: 14px; color: var(--text)">
                {{ session('name', 'User') }}
            </div>
            <div style="font-size: 12px; color: var(--muted)">
                {{
                    'Level User'
                }}
            </div>
        </div>
        <div style="padding: 4px 0">
            @if (session()->has('user_id'))
                <a
                    href="{{ url('settings') }}"
                    class="menu__item"
                    style="
                        display: flex;
                        align-items: center;
                        gap: 10px;
                        padding: 8px 16px;
                        font-size: 13px;
                        color: var(--text);
                        text-decoration: none;
                    "
                >
                    <svg class="ico" viewBox="0 0 24 24" style="width:16px;height:16px;">
                        <circle cx="12" cy="12" r="3" />
                        <path d="M12 2.8l2 2.1 2.9-.4.7 2.8 2.6 1.4-1 2.8 1 2.8-2.6 1.4-.7 2.8-2.9-.4-2 2.1-2-2.1-2.9.4-.7-2.8-2.6-1.4 1-2.8-1-2.8 2.6-1.4.7-2.8 2.9.4Z" />
                    </svg>
                    <span>Pengaturan Klinik</span>
                </a>
            @endif
            @if (session_user()?->canMenu('G1', 'view') || session_user()?->levelName() === 'admin' || session_user()?->levelName() === 'Superuser')
                <a
                    href="{{ route('setting.menu.index') }}"
                    class="menu__item"
                    style="
                        display: flex;
                        align-items: center;
                        gap: 10px;
                        padding: 8px 16px;
                        font-size: 13px;
                        color: var(--text);
                        text-decoration: none;
                    "
                >
                    <svg class="ico" viewBox="0 0 24 24" style="width:16px;height:16px;">
                        <line x1="8" y1="6" x2="21" y2="6" />
                        <line x1="8" y1="12" x2="21" y2="12" />
                        <line x1="8" y1="18" x2="21" y2="18" />
                        <circle cx="4" cy="6" r="1.5" />
                        <circle cx="4" cy="12" r="1.5" />
                        <circle cx="4" cy="18" r="1.5" />
                    </svg>
                    <span>Pengaturan Menu</span>
                </a>
            @endif
            @if (session_user()?->canMenu('G2', 'view') || session_user()?->levelName() === 'admin' || session_user()?->levelName() === 'Superuser')
                <a
                    href="{{ route('setting.level.index') }}"
                    class="menu__item"
                    style="
                        display: flex;
                        align-items: center;
                        gap: 10px;
                        padding: 8px 16px;
                        font-size: 13px;
                        color: var(--text);
                        text-decoration: none;
                    "
                >
                    <svg class="ico" viewBox="0 0 24 24" style="width:16px;height:16px;"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" /></svg>
                    <span>Pengaturan Level</span>
                </a>
            @endif
            @if (session_user()?->canMenu('G3', 'view') || session_user()?->levelName() === 'admin' || session_user()?->levelName() === 'Superuser')
                <a
                    href="{{ route('management.users.index') }}"
                    class="menu__item"
                    style="
                        display: flex;
                        align-items: center;
                        gap: 10px;
                        padding: 8px 16px;
                        font-size: 13px;
                        color: var(--text);
                        text-decoration: none;
                    "
                >
                    <svg class="ico" viewBox="0 0 24 24" style="width:16px;height:16px;">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>
                    <span>Manajemen User</span>
                </a>
            @endif
            @if (session_user()?->canMenu('G5', 'view') || session_user()?->levelName() === 'admin' || session_user()?->levelName() === 'Superuser')
                <a
                    href="{{ route('setting.api-key.index') }}"
                    class="menu__item"
                    style="
                        display: flex;
                        align-items: center;
                        gap: 10px;
                        padding: 8px 16px;
                        font-size: 13px;
                        color: var(--text);
                        text-decoration: none;
                    "
                >
                    <svg class="ico" viewBox="0 0 24 24" style="width:16px;height:16px;">
                        <path d="m21 2-2 2m-1.5 1.5 1.5 1.5-2 2-1.5-1.5M15.5 7.5 14 9l2 2 1.5-1.5M10.5 13.5a5 5 0 1 1-7-7 5 5 0 0 1 7 7Z" />
                        <path d="m15.5 7.5 4.5 4.5-2 2-1-1-2 2-1.5-1.5" />
                    </svg>
                    <span>API Key</span>
                </a>
            @endif
        </div>
        <div style="border-top: 1px solid var(--line); padding-top: 4px">
            <form action="{{ route('logout') }}" method="POST" style="margin: 0">
                @csrf
                <button
                    type="submit"
                    class="menu__item"
                    style="
                        width: 100%;
                        text-align: left;
                        display: flex;
                        align-items: center;
                        gap: 10px;
                        padding: 8px 16px;
                        font-size: 13px;
                        color: var(--bad);
                        background: none;
                        border: none;
                        cursor: pointer;
                    "
                >
                    <svg class="ico" viewBox="0 0 24 24" style="width:16px;height:16px;">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                        <polyline points="16 17 21 12 16 7" />
                        <line x1="21" y1="12" x2="9" y2="12" />
                    </svg>
                    <span>Keluar (Logout)</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Tend Core Shell UI Scripts -->
    <script>
        (function () {
            // ── 1. Bulletproof Theme Switcher (Dark / Light) ──
            var sunSvg = '<svg class="ico" viewBox="0 0 24 24" style="width:18px;height:18px;" aria-hidden="true"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"/></svg>';
            var moonSvg = '<svg class="ico" viewBox="0 0 24 24" style="width:18px;height:18px;" aria-hidden="true"><path d="M12 3a6 6 0 0 0 9 9 9 0 1 1-9-9Z"/></svg>';

            function getStoredTheme() {
                try {
                    return JSON.parse(localStorage.getItem('tend:theme')) || 'light';
                } catch (e) {
                    return document.documentElement.dataset.theme || 'light';
                }
            }

            function applyTheme(theme) {
                document.documentElement.dataset.theme = theme;
                try {
                    localStorage.setItem('tend:theme', JSON.stringify(theme));
                } catch (e) {}

                var meta = document.querySelector('meta[name="theme-color"]');
                if (meta) {
                    meta.content = theme === 'dark' ? '#0b1312' : '#fdf0f4';
                }

                document.querySelectorAll('#btn-theme, .btn-theme-toggle').forEach(function (btn) {
                    btn.setAttribute('aria-label', theme === 'dark' ? 'Switch to light theme' : 'Switch to dark theme');
                    btn.setAttribute('title', theme === 'dark' ? 'Mode Terang' : 'Mode Gelap');
                    btn.innerHTML = theme === 'dark' ? sunSvg : moonSvg;
                });
            }

            function handleThemeToggle(e) {
                if (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    e.stopImmediatePropagation();
                }
                var current = document.documentElement.dataset.theme || getStoredTheme();
                var next = current === 'dark' ? 'light' : 'dark';
                applyTheme(next);
            }

            // Capture phase intercept on document to prevent bundle double-toggle
            document.addEventListener('click', function (e) {
                var btn = e.target.closest('#btn-theme, .btn-theme-toggle');
                if (btn) {
                    handleThemeToggle(e);
                }
            }, true);

            // Sync theme icons on DOM ready
            applyTheme(document.documentElement.dataset.theme || getStoredTheme());

            // ── 2. Mobile Navigation Drawer Controller ──
            var mobileDrawer = document.getElementById('mobile-drawer');
            var mobileBackdrop = document.getElementById('mobile-drawer-backdrop');
            var btnCloseDrawer = document.getElementById('btn-close-mobile-drawer');

            function openMobileDrawer() {
                if (!mobileDrawer) return;
                mobileDrawer.classList.add('is-open');
                if (mobileBackdrop) mobileBackdrop.classList.add('is-open');
                document.body.style.overflow = 'hidden';
            }

            function closeMobileDrawer() {
                if (!mobileDrawer) return;
                mobileDrawer.classList.remove('is-open');
                if (mobileBackdrop) mobileBackdrop.classList.remove('is-open');
                document.body.style.overflow = '';
            }

            document.addEventListener('click', function (e) {
                if (e.target.closest('#btn-mobile-nav, #btn-nav-more')) {
                    e.preventDefault();
                    e.stopPropagation();
                    openMobileDrawer();
                } else if (e.target.closest('#btn-close-mobile-drawer') || e.target === mobileBackdrop) {
                    e.preventDefault();
                    closeMobileDrawer();
                } else if (e.target.closest('.mobile-drawer__link, .mobile-drawer__sublink')) {
                    // Smooth close on link navigation
                    closeMobileDrawer();
                }
            });

            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape' && mobileDrawer && mobileDrawer.classList.contains('is-open')) {
                    closeMobileDrawer();
                }
            });

            // ── 3. User Account Menu (#btn-me) ──
            var btnMe = document.getElementById('btn-me');
            var mePop = document.getElementById('menu-me-pop');
            if (btnMe && mePop) {
                btnMe.addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    var isVisible = mePop.style.display !== 'none';
                    mePop.style.display = isVisible ? 'none' : 'block';
                    btnMe.setAttribute('aria-expanded', isVisible ? 'false' : 'true');
                });
                document.addEventListener('click', function (e) {
                    if (!mePop.contains(e.target) && e.target !== btnMe) {
                        mePop.style.display = 'none';
                        btnMe.setAttribute('aria-expanded', 'false');
                    }
                });
            }

            // ── 4. Clinic Clock ──
            var clockTime = document.getElementById('clock-time');
            var clockNote = document.getElementById('clock-note');
            function tickClock() {
                if (!clockTime) return;
                var now = new Date();
                var hours = String(now.getHours()).padStart(2, '0');
                var mins = String(now.getMinutes()).padStart(2, '0');
                clockTime.textContent = hours + ':' + mins;
                if (clockNote) clockNote.textContent = 'Klinik Buka';
            }
            tickClock();
            setInterval(tickClock, 10000);

            // ── 5. Finder Dialog (⌘K) ──
            var btnFind = document.getElementById('btn-find');
            var finder = document.getElementById('finder');
            if (btnFind && finder) {
                btnFind.addEventListener('click', function () {
                    if (typeof finder.showModal === 'function') finder.showModal();
                });
                document.addEventListener('keydown', function (e) {
                    if ((e.metaKey || e.ctrlKey) && e.key.toLowerCase() === 'k') {
                        e.preventDefault();
                        if (typeof finder.showModal === 'function') finder.showModal();
                    }
                });
            }

            // ── 6. Toast Notification Handler ──
            var toast = document.querySelector('.toast');
            if (toast) {
                setTimeout(function () {
                    toast.style.opacity = '0';
                    toast.style.transform = 'translateY(12px)';
                    toast.style.transition = 'all 0.3s ease';
                    setTimeout(function () {
                        toast.style.display = 'none';
                    }, 350);
                }, 4000);
            }
        })();
    </script>

    <!-- Tend Client JS Module (GSAP Router, Pages & UI Primitives) -->
    <script type="module" crossorigin src="{{ asset('tend/assets/index-DwjwKIcQ.js') }}"></script>

    @stack ('scripts')
</body>
</html>
