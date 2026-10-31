@php
    $renderIcon = function($icon) {
        $icon = strtolower(trim($icon ?? ''));
        return match($icon) {
            'home', 'dashboard', 'pulse' => '<svg class="ico" viewBox="0 0 24 24" aria-hidden="true"><path d="M3 12h4l2-5 4 10 2-5h6"/></svg>',
            'inbox', 'whatsapp' => '<svg class="ico" viewBox="0 0 24 24" aria-hidden="true"><path d="M4.5 19.5 5.6 16A8 8 0 1 1 8.6 18.8z"/><path d="M9.5 9c.3 2.3 2.2 4.4 5.2 5.5l1-1.4-1.6-1-1 .7c-.8-.4-1.6-1.2-2-2l.7-1-1-1.6z"/></svg>',
            'patients', 'users', 'user' => '<svg class="ico" viewBox="0 0 24 24" aria-hidden="true"><circle cx="9" cy="8.5" r="3.5"/><path d="M3 19.5c.6-3.2 3-5 6-5s5.4 1.8 6 5"/><path d="M15.5 5.2a3.5 3.5 0 0 1 0 6.6M17.5 14.8c1.8.6 3 2.2 3.5 4.7"/></svg>',
            'schedule', 'calendar' => '<svg class="ico" viewBox="0 0 24 24" aria-hidden="true"><rect x="3.5" y="5" width="17" height="15.5" rx="3"/><path d="M3.5 10h17M8 3v4M16 3v4"/></svg>',
            'campaigns', 'megaphone' => '<svg class="ico" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 10v4a1.5 1.5 0 0 0 1.5 1.5H7l9 4.5V4L7 8.5H5.5A1.5 1.5 0 0 0 4 10Z"/><path d="M7 15.5 8.5 20M19.5 9.5v5"/></svg>',
            'reports', 'chart' => '<svg class="ico" viewBox="0 0 24 24" aria-hidden="true"><path d="M4.5 19.5h15"/><path d="M7.5 16v-4.5M12 16V7.5M16.5 16v-6.5"/></svg>',
            'settings', 'gear', 'cog' => '<svg class="ico" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="3"/><path d="M12 2.8l2 2.1 2.9-.4.7 2.8 2.6 1.4-1 2.8 1 2.8-2.6 1.4-.7 2.8-2.9-.4-2 2.1-2-2.1-2.9.4-.7-2.8-2.6-1.4 1-2.8-1-2.8 2.6-1.4.7-2.8 2.9.4Z"/></svg>',
            'key', 'api', 'api-key', 'token' => '<svg class="ico" viewBox="0 0 24 24" aria-hidden="true"><path d="m21 2-2 2m-1.5 1.5 1.5 1.5-2 2-1.5-1.5M15.5 7.5 14 9l2 2 1.5-1.5M10.5 13.5a5 5 0 1 1-7-7 5 5 0 0 1 7 7Z"/><path d="m15.5 7.5 4.5 4.5-2 2-1-1-2 2-1.5-1.5"/></svg>',
            'satusehat', 'rest-api', 'api-folder', 'clipboard', 'file-text' => '<svg class="ico" viewBox="0 0 24 24" aria-hidden="true"><rect x="4" y="4" width="16" height="16" rx="2" ry="2"/><path d="M9 4V2h6v2"/><line x1="9" y1="10" x2="15" y2="10"/><line x1="9" y1="14" x2="13" y2="14"/></svg>',
            'shield', 'level', 'lock' => '<svg class="ico" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>',
            'menu', 'list' => '<svg class="ico" viewBox="0 0 24 24" aria-hidden="true"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><circle cx="4" cy="6" r="1.5"/><circle cx="4" cy="12" r="1.5"/><circle cx="4" cy="18" r="1.5"/></svg>',
            default => '<svg class="ico" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"/></svg>',
        };
    };

    $topSingles = collect();
    $topGroups = collect();

    if (isset($sidebarMenus) && $sidebarMenus instanceof \Illuminate\Support\Collection && $sidebarMenus->isNotEmpty()) {
        foreach ($sidebarMenus as $menuItem) {
            if ($menuItem->childrenRecursive->isEmpty()) {
                $topSingles->push($menuItem);
            } else {
                $topGroups->push($menuItem);
            }
        }
    }
@endphp

<aside class="side">
    <a class="brand" href="{{ url('/dashboard') }}" aria-label="Tend — today">
        <span class="brand__mark" aria-hidden="true">
            <svg viewBox="0 0 24 24">
                <path d="M12 20.5s-7.5-4.4-7.5-10.2A4.3 4.3 0 0 1 12 7.6a4.3 4.3 0 0 1 7.5 2.7c0 5.8-7.5 10.2-7.5 10.2Z"/>
                <path d="M8.5 12.5h2l1-2 1.6 4 1-2h1.4"/>
            </svg>
        </span>
        <span class="brand__text">tend<small>RSUD dr. Soebandi</small></span>
    </a>

    <nav class="nav" aria-label="Main">
        @if($topSingles->isNotEmpty())
            <p class="nav__label">Menu Utama</p>
            <div class="nav__track">
                @foreach($topSingles as $m)
                    @php
                        $cleanUrl = trim($m->url, '/');
                        $isUserRoute = in_array($cleanUrl, ['setting/user', 'management/users', 'users'], true);
                        $href = $m->url === '#' ? '#' : ($isUserRoute ? route('management.users.index') : (str_starts_with($m->url, 'http') ? $m->url : url($m->url)));
                        $isCurrent = request()->is($cleanUrl . '*') 
                            || ($isUserRoute && request()->is('management/users*')) 
                            || ($cleanUrl === 'dashboard' && (request()->is('/') || request()->is('today')));
                        $routeData = $isUserRoute ? 'users' : $cleanUrl;
                    @endphp
                    <a class="nav__item {{ $isCurrent ? 'is-active' : '' }}" 
                       href="{{ $href }}" 
                       data-route="{{ $routeData }}"
                       @if($isCurrent) aria-current="page" @endif>
                        {!! $renderIcon($m->icon) !!}
                        <span>{{ $m->nama }}</span>
                        @if($cleanUrl === 'inbox')
                            <b class="nav__count" data-count="inbox"></b>
                        @endif
                    </a>
                @endforeach
                <button type="button" class="nav__item nav__more" aria-label="More pages" aria-haspopup="menu" aria-expanded="false" style="display:none;">
                    <svg class="ico" viewBox="0 0 24 24" aria-hidden="true">
                        <circle cx="5.5" cy="12" r="1.3"/>
                        <circle cx="12" cy="12" r="1.3"/>
                        <circle cx="18.5" cy="12" r="1.3"/>
                    </svg>
                    <span>More</span>
                </button>
                <span class="nav__pill" aria-hidden="true"></span>
            </div>
        @else
            {{-- Fallback default clinic items if no dynamic menus are seeded --}}
            <p class="nav__label">Clinic</p>
            <div class="nav__track">
                <a class="nav__item" href="{{ url('/dashboard') }}" data-route="today">
                    <svg class="ico" viewBox="0 0 24 24" aria-hidden="true"><path d="M3 12h4l2-5 4 10 2-5h6"/></svg>
                    <span>Today</span>
                </a>
                <a class="nav__item" href="{{ url('/inbox') }}" data-route="inbox">
                    <svg class="ico" viewBox="0 0 24 24" aria-hidden="true"><path d="M4.5 19.5 5.6 16A8 8 0 1 1 8.6 18.8z"/><path d="M9.5 9c.3 2.3 2.2 4.4 5.2 5.5l1-1.4-1.6-1-1 .7c-.8-.4-1.6-1.2-2-2l.7-1-1-1.6z"/></svg>
                    <span>Inbox</span>
                    <b class="nav__count" data-count="inbox"></b>
                </a>
                <a class="nav__item" href="{{ url('/patients') }}" data-route="patients">
                    <svg class="ico" viewBox="0 0 24 24" aria-hidden="true"><circle cx="9" cy="8.5" r="3.5"/><path d="M3 19.5c.6-3.2 3-5 6-5s5.4 1.8 6 5"/><path d="M15.5 5.2a3.5 3.5 0 0 1 0 6.6M17.5 14.8c1.8.6 3 2.2 3.5 4.7"/></svg>
                    <span>Patients</span>
                </a>
                <a class="nav__item" href="{{ url('/schedule') }}" data-route="schedule">
                    <svg class="ico" viewBox="0 0 24 24" aria-hidden="true"><rect x="3.5" y="5" width="17" height="15.5" rx="3"/><path d="M3.5 10h17M8 3v4M16 3v4"/></svg>
                    <span>Schedule</span>
                </a>
                <a class="nav__item" href="{{ url('/campaigns') }}" data-route="campaigns">
                    <svg class="ico" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 10v4a1.5 1.5 0 0 0 1.5 1.5H7l9 4.5V4L7 8.5H5.5A1.5 1.5 0 0 0 4 10Z"/><path d="M7 15.5 8.5 20M19.5 9.5v5"/></svg>
                    <span>Campaigns</span>
                </a>
                <a class="nav__item" href="{{ url('/reports') }}" data-route="reports">
                    <svg class="ico" viewBox="0 0 24 24" aria-hidden="true"><path d="M4.5 19.5h15"/><path d="M7.5 16v-4.5M12 16V7.5M16.5 16v-6.5"/></svg>
                    <span>Reports</span>
                </a>
                <a class="nav__item" href="{{ url('/settings') }}" data-route="settings">
                    <svg class="ico" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="3"/><path d="M12 2.8l2 2.1 2.9-.4.7 2.8 2.6 1.4-1 2.8 1 2.8-2.6 1.4-.7 2.8-2.9-.4-2 2.1-2-2.1-2.9.4-.7-2.8-2.6-1.4 1-2.8-1-2.8 2.6-1.4.7-2.8 2.9.4Z"/></svg>
                    <span>Settings</span>
                </a>
                <button type="button" class="nav__item nav__more" aria-label="More pages" aria-haspopup="menu" aria-expanded="false" style="display:none;">
                    <svg class="ico" viewBox="0 0 24 24" aria-hidden="true">
                        <circle cx="5.5" cy="12" r="1.3"/>
                        <circle cx="12" cy="12" r="1.3"/>
                        <circle cx="18.5" cy="12" r="1.3"/>
                    </svg>
                    <span>More</span>
                </button>
                <span class="nav__pill" aria-hidden="true"></span>
            </div>
        @endif

        {{-- Dynamic Accordion Groups --}}
        @if($topGroups->isNotEmpty())
            @foreach($topGroups as $group)
                @php
                    $isGroupActive = $group->childrenRecursive->contains(function($c) {
                        $cClean = trim($c->url, '/');
                        $isUser = in_array($cClean, ['setting/user', 'management/users', 'users'], true);
                        return request()->is($cClean . '*') || ($isUser && request()->is('management/users*'));
                    });
                @endphp
                <p class="nav__label nav__label--mgmt" data-group="mgmt-{{ $group->id }}" style="margin-top: 14px;">{{ $group->nama }}</p>
                <div class="nav__mgmt-group" data-group="mgmt-{{ $group->id }}">
                    <button type="button" class="nav__item nav__parent {{ $isGroupActive ? 'is-expanded' : 'is-expanded' }}" id="btn-toggle-{{ $group->id }}" aria-expanded="true">
                        {!! $renderIcon($group->icon) !!}
                        <span>{{ $group->nama }}</span>
                        <svg class="ico nav__chevron" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="m6 9 6 6 6-6"/>
                        </svg>
                    </button>
                    <div class="nav__submenu-wrapper {{ $isGroupActive ? 'is-open' : 'is-open' }}" id="submenu-wrapper-{{ $group->id }}">
                        <div class="nav__submenu" id="submenu-{{ $group->id }}">
                            @foreach($group->childrenRecursive as $sub)
                                @php
                                    $subClean = trim($sub->url, '/');
                                    $isUserRoute = in_array($subClean, ['setting/user', 'management/users', 'users'], true);
                                    $subHref = $sub->url === '#' ? '#' : ($isUserRoute ? route('management.users.index') : (str_starts_with($sub->url, 'http') ? $sub->url : url($sub->url)));
                                    $isSubActive = request()->is($subClean . '*') || ($isUserRoute && request()->is('management/users*'));
                                    $routeData = $isUserRoute ? 'users' : $subClean;
                                @endphp
                                <a class="nav__subitem {{ $isSubActive ? 'is-active' : '' }}" 
                                   href="{{ $subHref }}" 
                                   data-route="{{ $routeData }}" 
                                   id="nav-sub-{{ $sub->id }}"
                                   @if($isSubActive) aria-current="page" @endif>
                                    <span class="nav__subdot"></span>
                                    <span>{{ $sub->nama }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </nav>

    <div class="side__foot">
        <a class="wa-status" id="wa-status" href="{{ url('/settings/whatsapp') }}"></a>
        <button type="button" class="me" id="btn-me" aria-label="Account menu" aria-haspopup="menu" aria-expanded="false"></button>
    </div>
</aside>

<script>
    (function () {
        function initSubmenuToggles() {
            document.querySelectorAll('.nav__parent').forEach(function(btn) {
                if (btn.dataset.bound) return;
                btn.dataset.bound = '1';

                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    var wrapper = btn.nextElementSibling;
                    if (!wrapper || !wrapper.classList.contains('nav__submenu-wrapper')) return;

                    var isOpen = wrapper.classList.contains('is-open');
                    if (isOpen) {
                        wrapper.classList.remove('is-open');
                        btn.classList.remove('is-expanded');
                        btn.setAttribute('aria-expanded', 'false');
                    } else {
                        wrapper.classList.add('is-open');
                        btn.classList.add('is-expanded');
                        btn.setAttribute('aria-expanded', 'true');
                    }
                });
            });
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initSubmenuToggles);
        } else {
            initSubmenuToggles();
        }
    })();
</script>
