<!doctype html>
<!-- Tend — the clinic CRM that answers on WhatsApp — © 2026 Hasib (OVERSHOOT). All rights reserved. -->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
    <meta name="robots" content="noindex, nofollow" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Tend — the clinic CRM that answers on WhatsApp</title>
    <meta name="description" content="Tend is a clinic CRM dashboard with WhatsApp built in: a live patient-flow board, a WhatsApp inbox with delivery ticks and the 24-hour rule, patient records with consent, a clinician schedule, reminder templates and broadcasts, reports and settings — light and dark, fully animated." />
    <meta name="theme-color" content="#fdf0f4" />

    <!-- Open Graph -->
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Tend — the clinic CRM that answers on WhatsApp" />
    <meta property="og:description" content="Patients, appointments and WhatsApp conversations in one calm, animated clinic dashboard." />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@400..800&family=Geist+Mono:wght@400..600&display=swap" rel="stylesheet" />

    <!-- Theme Init -->
    <script>
        (function (d) {
            d.classList.add('js');
            var rec = /[?&]record\b/.test(location.search);
            if (rec) d.classList.add('is-record');
            try {
                if (!rec) {
                    var t = JSON.parse(localStorage.getItem('tend:theme') || '"light"');
                    d.dataset.theme =
                        t === 'system'
                            ? matchMedia('(prefers-color-scheme: dark)').matches
                                ? 'dark'
                                : 'light'
                            : t;
                }
            } catch (e) {}
            if (!rec)
                setTimeout(function () {
                    d.classList.add('failsafe');
                }, 4000);

            // Immediately mark ready for management pages so app is visible without delay
            if (location.pathname.startsWith('/management')) {
                d.classList.add('is-ready');
            }

            // Sync hash route with current pathname on initial load
            var parts = location.pathname.replace(/^\//, '').split('/');
            var map = {
                '': 'today',
                'dashboard': 'today',
                'today': 'today',
                'inbox': 'inbox',
                'patients': 'patients',
                'schedule': 'schedule',
                'campaigns': 'campaigns',
                'reports': 'reports',
                'settings': 'settings'
            };
            if (parts[0] === 'management') {
                var sub = parts[1] || 'users';
                if (!location.hash || location.hash === '#/' || location.hash === '#/today') {
                    location.hash = '#/' + sub;
                }
            } else if (map[parts[0]] && (!location.hash || location.hash === '#/' || location.hash === '#/today')) {
                if (map[parts[0]] !== 'today') {
                    location.hash = '#/' + map[parts[0]];
                }
            }
        })(document.documentElement);
    </script>

    <!-- Global Tend Shell CSS -->
    <link rel="stylesheet" crossorigin href="{{ asset('tend/assets/index-C_0VME2I.css') }}" />

    <!-- All Page CSS Stylesheets for Smooth SPA Transitions -->
    <link rel="stylesheet" crossorigin href="{{ asset('tend/assets/today-rY2azoiN.css') }}" />
    <link rel="stylesheet" crossorigin href="{{ asset('tend/assets/inbox-uSRulYbE.css') }}" />
    <link rel="stylesheet" crossorigin href="{{ asset('tend/assets/patients-B1Ct_RWM.css') }}" />
    <link rel="stylesheet" crossorigin href="{{ asset('tend/assets/schedule-SZWs3o6S.css') }}" />
    <link rel="stylesheet" crossorigin href="{{ asset('tend/assets/campaigns-2hk80XtZ.css') }}" />
    <link rel="stylesheet" crossorigin href="{{ asset('tend/assets/reports-9hIUbvIF.css') }}" />
    <link rel="stylesheet" crossorigin href="{{ asset('tend/assets/settings-BZ16vYlf.css') }}" />

    {{-- Brand Override: PaleVioletRed #DB7093 (harus setelah CSS Tend) --}}
    @vite(['resources/css/app.css'])


    <!-- Favicons -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="48x48" />
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml" />
    <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}" />
</head>
<body>
    <a class="skip" href="#main">Skip to content</a>

    <div class="app">
        {{-- Sidebar --}}
        @include('partials.sidebar')

        <div class="main-col">
            {{-- Top Header --}}
            @include('partials.header')

            {{-- Main Content (All views loaded in DOM for seamless GSAP transitions) --}}
            <main id="main" class="main">
                {{-- 1. Today --}}
                <section class="view" data-view="today">
                    @include('dashboard.partials.hero')
                    <div class="td-grid">
                        @include('dashboard.partials.patient-flow')
                        @include('dashboard.partials.whatsapp-inbox')
                        @include('dashboard.partials.clinician-schedule')
                        @include('dashboard.partials.reminders')
                        @include('dashboard.partials.visit-trend')
                        @include('dashboard.partials.recalls')
                        @include('dashboard.partials.clinician-load')
                        @include('dashboard.partials.activity-feed')
                    </div>
                </section>

                {{-- 2. Inbox --}}
                <section class="view" data-view="inbox" hidden>
                    @include('inbox.partials.header')
                    <div class="ib">
                        @include('inbox.partials.chat-list')
                        @include('inbox.partials.chat-thread')
                        @include('inbox.partials.patient-panel')
                    </div>
                </section>

                {{-- 3. Patients --}}
                <section class="view" data-view="patients" hidden>
                    @include('patients.partials.header')
                    @include('patients.partials.table')
                </section>

                {{-- 4. Schedule --}}
                <section class="view sc" data-view="schedule" hidden>
                    @include('schedule.partials.filter-bar')
                    @include('schedule.partials.calendar-board')
                </section>

                {{-- 5. Campaigns --}}
                <section class="view" data-view="campaigns" hidden>
                    <div class="cp-list">
                        @include('campaigns.partials.tabs')
                        <div class="cp-body">
                            @include('campaigns.partials.broadcast-list')
                            @include('campaigns.partials.templates-list')
                        </div>
                    </div>
                </section>

                {{-- 6. Reports --}}
                <section class="view" data-view="reports" hidden>
                    @include('reports.partials.header')
                    <div class="r-grid">
                        @include('reports.partials.no-show-analysis')
                        @include('reports.partials.whatsapp-funnel')
                        @include('reports.partials.patient-mix')
                        @include('reports.partials.clinician-utilization')
                    </div>
                </section>

                {{-- 7. Settings --}}
                <section class="view" data-view="settings" hidden>
                    @include('settings.partials.header')
                    <div class="s-grid">
                        @include('settings.partials.nav')
                        <div class="s-stage">
                            @include('settings.partials.tab-clinic')
                            @include('settings.partials.tab-whatsapp')
                            @include('settings.partials.tab-hours')
                            @include('settings.partials.tab-team')
                        </div>
                    </div>
                </section>

                {{-- 8. Management: Users --}}
                <section class="view" data-view="users" hidden>
                    @include('management.users.partials.content')
                </section>
            </main>
        </div>
    </div>

    <!-- Scrim & Pop layer -->
    <div class="scrim" aria-hidden="true"></div>
    <div class="pop-layer"></div>

    <!-- Finder Dialog -->
    @include('partials.finder')

    <!-- Modals & Drawers -->
    <dialog class="modal" id="modal"></dialog>
    <dialog class="drawer" id="drawer"></dialog>

    <!-- Toast Notification -->
    @include('partials.toast')

    <!-- Sync Path to SPA Hash on Initial Load -->
    <script>
        (function() {
            var rawPath = window.location.pathname.replace(/^\/+|\/+$/g, '');
            if (!window.location.hash || window.location.hash === '#' || window.location.hash === '#/') {
                if (rawPath === 'management/users') {
                    window.location.hash = '#/users';
                }
            }
        })();
    </script>

    <!-- Tend Client JS Module (GSAP Router & Animations) -->
    <script type="module" crossorigin src="{{ asset('tend/assets/index-DwjwKIcQ.js') }}"></script>

    <!-- Mobile Management Menu Helper -->
    <script>
        (function () {
            function initMobileMgmt() {
                var btn = document.getElementById('btn-mgmt-mobile');
                if (!btn || btn.dataset.bound) return;
                btn.dataset.bound = '1';
                btn.addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    if (window.TEND_MC) {
                        var curr = (location.hash || '').replace(/^#\/?/, '').split('/')[0];
                        window.TEND_MC(btn, [
                            { label: 'Daftar Pengguna', icon: 'users', checked: curr === 'users', onSelect: function () { location.hash = '#/users'; } }
                        ], { align: 'end' });
                    } else {
                        location.hash = '#/users';
                    }
                });
            }
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initMobileMgmt);
            } else {
                initMobileMgmt();
            }
        })();
    </script>
    @stack('scripts')
</body>
</html>
