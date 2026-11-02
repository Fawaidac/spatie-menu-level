@php
    $renderDrawerIcon = function ($icon) {
        $icon = strtolower(trim($icon ?? ''));
        return match ($icon) {
            'home', 'dashboard', 'pulse'
                => '<svg class="ico" viewBox="0 0 24 24" aria-hidden="true"><path d="M3 12h4l2-5 4 10 2-5h6"/></svg>',
            'inbox', 'whatsapp'
                => '<svg class="ico" viewBox="0 0 24 24" aria-hidden="true"><path d="M4.5 19.5 5.6 16A8 8 0 1 1 8.6 18.8z"/><path d="M9.5 9c.3 2.3 2.2 4.4 5.2 5.5l1-1.4-1.6-1-1 .7c-.8-.4-1.6-1.2-2-2l.7-1-1-1.6z"/></svg>',
            'patients', 'users', 'user'
                => '<svg class="ico" viewBox="0 0 24 24" aria-hidden="true"><circle cx="9" cy="8.5" r="3.5"/><path d="M3 19.5c.6-3.2 3-5 6-5s5.4 1.8 6 5"/><path d="M15.5 5.2a3.5 3.5 0 0 1 0 6.6M17.5 14.8c1.8.6 3 2.2 3.5 4.7"/></svg>',
            'schedule', 'calendar'
                => '<svg class="ico" viewBox="0 0 24 24" aria-hidden="true"><rect x="3.5" y="5" width="17" height="15.5" rx="3"/><path d="M3.5 10h17M8 3v4M16 3v4"/></svg>',
            'settings', 'gear', 'cog'
                => '<svg class="ico" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="3"/><path d="M12 2.8l2 2.1 2.9-.4.7 2.8 2.6 1.4-1 2.8 1 2.8-2.6 1.4-.7 2.8-2.9-.4-2 2.1-2-2.1-2.9.4-.7-2.8-2.6-1.4 1-2.8-1-2.8 2.6-1.4.7-2.8 2.9.4Z"/></svg>',
            'key', 'api', 'api-key', 'token'
                => '<svg class="ico" viewBox="0 0 24 24" aria-hidden="true"><path d="m21 2-2 2m-1.5 1.5 1.5 1.5-2 2-1.5-1.5M15.5 7.5 14 9l2 2 1.5-1.5M10.5 13.5a5 5 0 1 1-7-7 5 5 0 0 1 7 7Z"/><path d="m15.5 7.5 4.5 4.5-2 2-1-1-2 2-1.5-1.5"/></svg>',
            'satusehat', 'rest-api', 'api-folder', 'clipboard', 'file-text'
                => '<svg class="ico" viewBox="0 0 24 24" aria-hidden="true"><rect x="4" y="4" width="16" height="16" rx="2" ry="2"/><path d="M9 4V2h6v2"/><line x1="9" y1="10" x2="15" y2="10"/><line x1="9" y1="14" x2="13" y2="14"/></svg>',
            'encounter', 'hospital', 'activity', 'stethoscope'
                => '<svg class="ico" viewBox="0 0 24 24" aria-hidden="true"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>',
            'shield', 'level', 'lock'
                => '<svg class="ico" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>',
            'menu', 'list'
                => '<svg class="ico" viewBox="0 0 24 24" aria-hidden="true"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><circle cx="4" cy="6" r="1.5"/><circle cx="4" cy="12" r="1.5"/><circle cx="4" cy="18" r="1.5"/></svg>',
            default
                => '<svg class="ico" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"/></svg>',
        };
    };
@endphp

<!-- Mobile Navigation Drawer Overlay & Container -->
<div class="mobile-drawer-backdrop" id="mobile-drawer-backdrop" aria-hidden="true"></div>

<aside class="mobile-drawer" id="mobile-drawer" aria-label="Navigasi Menu Mobile">
    <!-- Header Drawer -->
    <div class="mobile-drawer__head">
        <div class="mobile-drawer__brand">
            <span class="brand__mark" aria-hidden="true">
                <svg viewBox="0 0 24 24">
                    <path d="M12 20.5s-7.5-4.4-7.5-10.2A4.3 4.3 0 0 1 12 7.6a4.3 4.3 0 0 1 7.5 2.7c0 5.8-7.5 10.2-7.5 10.2Z" />
                    <path d="M8.5 12.5h2l1-2 1.6 4 1-2h1.4" />
                </svg>
            </span>
            <div class="brand__text">
                <strong>Satu Sehat</strong>
                <small>RSUD dr. Soebandi</small>
            </div>
        </div>
        <button type="button" class="ibtn ibtn--glass mobile-drawer__close" id="btn-close-mobile-drawer" aria-label="Tutup Menu">
            <svg class="ico" viewBox="0 0 24 24" style="width:18px;height:18px;" aria-hidden="true">
                <line x1="18" y1="6" x2="6" y2="18" />
                <line x1="6" y1="6" x2="18" y2="18" />
            </svg>
        </button>
    </div>

    <!-- User Snippet & Theme Switcher in Drawer -->
    <div class="mobile-drawer__user">
        <div class="mobile-drawer__avatar">
            {{ strtoupper(substr(session('name', 'Pengguna'), 0, 1)) }}
        </div>
        <div class="mobile-drawer__userinfo">
            <div class="mobile-drawer__username">{{ session('name', 'Pengguna') }}</div>
            <div class="mobile-drawer__userrole">{{ session_user()?->levelName() ?? 'Staff' }}</div>
        </div>
        <button type="button" class="ibtn ibtn--glass btn-theme-toggle mobile-drawer__themebtn" aria-label="Toggle Mode Gelap/Terang" title="Toggle Tema">
            <svg class="ico" viewBox="0 0 24 24" style="width:18px;height:18px;" aria-hidden="true"><path d="M12 3a6 6 0 0 0 9 9 9 0 1 1-9-9Z"/></svg>
        </button>
    </div>

    <!-- Navigation Tree Content -->
    <div class="mobile-drawer__nav">
        {{-- Dashboard (Always available for all users, like in old system) --}}
        <a class="mobile-drawer__link {{ request()->is('dashboard') || request()->is('/') ? 'is-active' : '' }}" href="{{ route('dashboard.index') }}">
            {!! $renderDrawerIcon('dashboard') !!}
            <span>Dashboard</span>
        </a>

        @if (isset($sidebarMenus) && $sidebarMenus instanceof \Illuminate\Support\Collection && $sidebarMenus->isNotEmpty())
            @foreach ($sidebarMenus as $menu)
                @if ($menu->childrenRecursive->isEmpty())
                    @php
                        $cleanUrl = trim($menu->url, '/');
                        $urlMap = [
                            'msmenu'                   => route('setting.menu.index'),
                            'level'                    => route('setting.level.index'),
                            'user'                     => route('management.users.index'),
                            'setting/user'             => route('management.users.index'),
                            'management/users'         => route('management.users.index'),
                            'users'                    => route('management.users.index'),
                            'kode_api'                 => route('setting.api-key.index'),
                            'api/token'                => route('satusehat.token.index'),
                            'api/patient/patient'      => route('satusehat.patient.index'),
                            'api/organization'         => route('satusehat.organization.index'),
                            'api/location/location'    => route('satusehat.location.index'),
                            'api/practitioner/practitioner' => route('satusehat.practitioner.index'),
                            'api/medication/medication'     => route('satusehat.medication.index'),
                        ];

                        if ($menu->url === '#') {
                            $href = '#';
                        } elseif (isset($urlMap[$cleanUrl])) {
                            $href = $urlMap[$cleanUrl];
                        } elseif (str_starts_with($menu->url, 'http')) {
                            $href = $menu->url;
                        } else {
                            $href = url($menu->url);
                        }

                        $isActive = request()->is($cleanUrl . '*') || ($cleanUrl === 'dashboard' && (request()->is('/') || request()->is('today')));
                        if (isset($urlMap[$cleanUrl])) {
                            $mappedPath = trim(parse_url($urlMap[$cleanUrl], PHP_URL_PATH), '/');
                            if ($mappedPath && request()->is($mappedPath . '*')) {
                                $isActive = true;
                            }
                        }
                    @endphp
                    <a class="mobile-drawer__link {{ $isActive ? 'is-active' : '' }}" href="{{ $href }}">
                        {!! $renderDrawerIcon($menu->icon) !!}
                        <span>{{ $menu->nama }}</span>
                        @if ($isActive)
                            <span class="mobile-drawer__active-indicator" aria-hidden="true"></span>
                        @endif
                    </a>
                @else
                    @php
                        $isGroupActive = $menu->childrenRecursive->contains(function ($c) {
                            $cClean = trim($c->url, '/');
                            $isUser = in_array($cClean, ['setting/user', 'management/users', 'users'], true);
                            return request()->is($cClean . '*') || ($isUser && request()->is('management/users*'));
                        });
                    @endphp
                    <div class="mobile-drawer__group">
                        <div class="mobile-drawer__group-header">
                            {!! $renderDrawerIcon($menu->icon) !!}
                            <span>{{ $menu->nama }}</span>
                        </div>
                        <div class="mobile-drawer__subitems">
                            @foreach ($menu->childrenRecursive as $sub)
                                @php
                                    $subClean = trim($sub->url, '/');
                                    $subUrlMap = [
                                        'msmenu'                   => route('setting.menu.index'),
                                        'level'                    => route('setting.level.index'),
                                        'user'                     => route('management.users.index'),
                                        'setting/user'             => route('management.users.index'),
                                        'management/users'         => route('management.users.index'),
                                        'users'                    => route('management.users.index'),
                                        'kode_api'                 => route('setting.api-key.index'),
                                        'api/token'                => route('satusehat.token.index'),
                                        'api/patient/patient'      => route('satusehat.patient.index'),
                                        'api/organization'         => route('satusehat.organization.index'),
                                        'api/location/location'    => route('satusehat.location.index'),
                                        'api/practitioner/practitioner' => route('satusehat.practitioner.index'),
                                        'api/medication/medication'     => route('satusehat.medication.index'),
                                    ];

                                    if ($sub->url === '#') {
                                        $subHref = '#';
                                    } elseif (isset($subUrlMap[$subClean])) {
                                        $subHref = $subUrlMap[$subClean];
                                    } elseif (str_starts_with($sub->url, 'http')) {
                                        $subHref = $sub->url;
                                    } else {
                                        $subHref = url($sub->url);
                                    }

                                    $isSubActive = request()->is($subClean . '*');
                                    if (isset($subUrlMap[$subClean])) {
                                        $mappedSubPath = trim(parse_url($subUrlMap[$subClean], PHP_URL_PATH), '/');
                                        if ($mappedSubPath && request()->is($mappedSubPath . '*')) {
                                            $isSubActive = true;
                                        }
                                    }
                                @endphp
                                <a class="mobile-drawer__sublink {{ $isSubActive ? 'is-active' : '' }}" href="{{ $subHref }}">
                                    <span class="mobile-drawer__subdot"></span>
                                    <span>{{ $sub->nama }}</span>
                                    @if ($isSubActive)
                                        <span class="mobile-drawer__active-indicator" aria-hidden="true"></span>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        @else
            <!-- Fallback Menu jika dinamis kosong -->
            <a class="mobile-drawer__link {{ request()->is('dashboard*') || request()->is('/') ? 'is-active' : '' }}" href="{{ url('/dashboard') }}">
                {!! $renderDrawerIcon('dashboard') !!}
                <span>Dashboard</span>
            </a>
            <div class="mobile-drawer__group">
                <div class="mobile-drawer__group-header">
                    {!! $renderDrawerIcon('satusehat') !!}
                    <span>Satu Sehat REST API</span>
                </div>
                <div class="mobile-drawer__subitems">
                    <a class="mobile-drawer__sublink {{ request()->is('satusehat/token*') ? 'is-active' : '' }}" href="{{ url('/satusehat/token') }}">
                        <span class="mobile-drawer__subdot"></span><span>Token</span>
                    </a>
                    <a class="mobile-drawer__sublink {{ request()->is('satusehat/patient*') ? 'is-active' : '' }}" href="{{ url('/satusehat/patient') }}">
                        <span class="mobile-drawer__subdot"></span><span>Patient</span>
                    </a>
                    <a class="mobile-drawer__sublink {{ request()->is('satusehat/organization*') ? 'is-active' : '' }}" href="{{ url('/satusehat/organization') }}">
                        <span class="mobile-drawer__subdot"></span><span>Organization</span>
                    </a>
                    <a class="mobile-drawer__sublink {{ request()->is('satusehat/location*') ? 'is-active' : '' }}" href="{{ url('/satusehat/location') }}">
                        <span class="mobile-drawer__subdot"></span><span>Location</span>
                    </a>
                    <a class="mobile-drawer__sublink {{ request()->is('satusehat/practitioner*') ? 'is-active' : '' }}" href="{{ url('/satusehat/practitioner') }}">
                        <span class="mobile-drawer__subdot"></span><span>Practitioner</span>
                    </a>
                    <a class="mobile-drawer__sublink {{ request()->is('satusehat/medication*') ? 'is-active' : '' }}" href="{{ url('/satusehat/medication') }}">
                        <span class="mobile-drawer__subdot"></span><span>Medication</span>
                    </a>
                </div>
            </div>
            <div class="mobile-drawer__group">
                <div class="mobile-drawer__group-header">
                    {!! $renderDrawerIcon('encounter') !!}
                    <span>Encounter</span>
                </div>
                <div class="mobile-drawer__subitems">
                    <a class="mobile-drawer__sublink {{ request()->is('encounter/rawat-jalan*') ? 'is-active' : '' }}" href="{{ url('/encounter/rawat-jalan') }}">
                        <span class="mobile-drawer__subdot"></span><span>Rawat Jalan</span>
                    </a>
                    <a class="mobile-drawer__sublink {{ request()->is('encounter/igd*') ? 'is-active' : '' }}" href="{{ url('/encounter/igd') }}">
                        <span class="mobile-drawer__subdot"></span><span>IGD</span>
                    </a>
                    <a class="mobile-drawer__sublink {{ request()->is('encounter/rawat-inap*') ? 'is-active' : '' }}" href="{{ url('/encounter/rawat-inap') }}">
                        <span class="mobile-drawer__subdot"></span><span>Rawat Inap</span>
                    </a>
                </div>
            </div>
            <div class="mobile-drawer__group">
                <div class="mobile-drawer__group-header">
                    {!! $renderDrawerIcon('settings') !!}
                    <span>Pengaturan & Akses</span>
                </div>
                <div class="mobile-drawer__subitems">
                    <a class="mobile-drawer__sublink {{ request()->is('setting/menu*') ? 'is-active' : '' }}" href="{{ url('/setting/menu') }}">
                        <span class="mobile-drawer__subdot"></span><span>Menu</span>
                    </a>
                    <a class="mobile-drawer__sublink {{ request()->is('setting/level*') ? 'is-active' : '' }}" href="{{ url('/setting/level') }}">
                        <span class="mobile-drawer__subdot"></span><span>Level</span>
                    </a>
                    <a class="mobile-drawer__sublink {{ request()->is('management/users*') ? 'is-active' : '' }}" href="{{ route('management.users.index') }}">
                        <span class="mobile-drawer__subdot"></span><span>User</span>
                    </a>
                    <a class="mobile-drawer__sublink {{ request()->is('setting/api-key*') ? 'is-active' : '' }}" href="{{ url('/setting/api-key') }}">
                        <span class="mobile-drawer__subdot"></span><span>API Key</span>
                    </a>
                </div>
            </div>
        @endif
    </div>

    <!-- Footer Drawer (Logout) -->
    <div class="mobile-drawer__foot">
        <form action="{{ route('logout') }}" method="POST" style="margin: 0; width: 100%;">
            @csrf
            <button type="submit" class="mobile-drawer__logout-btn">
                <svg class="ico" viewBox="0 0 24 24" style="width:17px;height:17px;" aria-hidden="true">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                    <polyline points="16 17 21 12 16 7" />
                    <line x1="21" y1="12" x2="9" y2="12" />
                </svg>
                <span>Keluar (Logout)</span>
            </button>
        </form>
    </div>
</aside>

