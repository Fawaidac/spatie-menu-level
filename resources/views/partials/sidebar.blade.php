<aside class="side">
    <a class="brand" href="#/today" aria-label="Tend — today">
        <span class="brand__mark" aria-hidden="true">
            <svg viewBox="0 0 24 24">
                <path d="M12 20.5s-7.5-4.4-7.5-10.2A4.3 4.3 0 0 1 12 7.6a4.3 4.3 0 0 1 7.5 2.7c0 5.8-7.5 10.2-7.5 10.2Z"/>
                <path d="M8.5 12.5h2l1-2 1.6 4 1-2h1.4"/>
            </svg>
        </span>
        <span class="brand__text">tend<small>Northside Family Clinic</small></span>
    </a>
    <nav class="nav" aria-label="Main">
        <p class="nav__label">Clinic</p>
        <div class="nav__track">
            <a class="nav__item" href="#/today" data-route="today">
                <svg class="ico" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M3 12h4l2-5 4 10 2-5h6"/>
                </svg>
                <span>Today</span>
            </a>
            <a class="nav__item" href="#/inbox" data-route="inbox">
                <svg class="ico" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M4.5 19.5 5.6 16A8 8 0 1 1 8.6 18.8z"/>
                    <path d="M9.5 9c.3 2.3 2.2 4.4 5.2 5.5l1-1.4-1.6-1-1 .7c-.8-.4-1.6-1.2-2-2l.7-1-1-1.6z"/>
                </svg>
                <span>Inbox</span>
                <b class="nav__count" data-count="inbox"></b>
            </a>
            <a class="nav__item" href="#/patients" data-route="patients">
                <svg class="ico" viewBox="0 0 24 24" aria-hidden="true">
                    <circle cx="9" cy="8.5" r="3.5"/>
                    <path d="M3 19.5c.6-3.2 3-5 6-5s5.4 1.8 6 5"/>
                    <path d="M15.5 5.2a3.5 3.5 0 0 1 0 6.6M17.5 14.8c1.8.6 3 2.2 3.5 4.7"/>
                </svg>
                <span>Patients</span>
            </a>
            <a class="nav__item" href="#/schedule" data-route="schedule">
                <svg class="ico" viewBox="0 0 24 24" aria-hidden="true">
                    <rect x="3.5" y="5" width="17" height="15.5" rx="3"/>
                    <path d="M3.5 10h17M8 3v4M16 3v4"/>
                </svg>
                <span>Schedule</span>
            </a>
            <a class="nav__item" href="#/campaigns" data-route="campaigns">
                <svg class="ico" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M4 10v4a1.5 1.5 0 0 0 1.5 1.5H7l9 4.5V4L7 8.5H5.5A1.5 1.5 0 0 0 4 10Z"/>
                    <path d="M7 15.5 8.5 20M19.5 9.5v5"/>
                </svg>
                <span>Campaigns</span>
            </a>
            <a class="nav__item" href="#/reports" data-route="reports">
                <svg class="ico" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M4.5 19.5h15"/>
                    <path d="M7.5 16v-4.5M12 16V7.5M16.5 16v-6.5"/>
                </svg>
                <span>Reports</span>
            </a>
            <a class="nav__item" href="#/settings" data-route="settings">
                <svg class="ico" viewBox="0 0 24 24" aria-hidden="true">
                    <circle cx="12" cy="12" r="3"/>
                    <path d="M12 2.8l2 2.1 2.9-.4.7 2.8 2.6 1.4-1 2.8 1 2.8-2.6 1.4-.7 2.8-2.9-.4-2 2.1-2-2.1-2.9.4-.7-2.8-2.6-1.4 1-2.8-1-2.8 2.6-1.4.7-2.8 2.9.4Z"/>
                </svg>
                <span>Settings</span>
            </a>
            <button type="button" class="nav__item nav__more" aria-label="More pages" aria-haspopup="menu" aria-expanded="false">
                <svg class="ico" viewBox="0 0 24 24" aria-hidden="true">
                    <circle cx="5.5" cy="12" r="1.3"/>
                    <circle cx="12" cy="12" r="1.3"/>
                    <circle cx="18.5" cy="12" r="1.3"/>
                </svg>
                <span>More</span>
            </button>
            <span class="nav__pill" aria-hidden="true"></span>
        </div>

        {{-- Management User Menu Section (Sidebar Desktop) --}}
        <p class="nav__label nav__label--mgmt" data-group="mgmt" style="margin-top: 14px;">Management</p>
        <div class="nav__mgmt-group" data-group="mgmt">
            <button type="button" class="nav__item nav__parent is-expanded" id="btn-toggle-mgmt" aria-expanded="true">
                <svg class="ico" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
                <span>Management User</span>
                <svg class="ico nav__chevron" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="m6 9 6 6 6-6"/>
                </svg>
            </button>
            <div class="nav__submenu-wrapper is-open" id="submenu-wrapper">
                <div class="nav__submenu" id="submenu-mgmt">
                    <a class="nav__subitem" href="#/users" data-route="users" id="nav-mgmt-users">
                        <span class="nav__subdot"></span>
                        <span>User</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>
    <div class="side__foot">
        <a class="wa-status" id="wa-status" href="#/settings/whatsapp"></a>
        <button type="button" class="me" id="btn-me" aria-label="Account menu" aria-haspopup="menu" aria-expanded="false"></button>
    </div>
</aside>

<script>
    (function () {
        function initMgmtToggle() {
            var btn = document.getElementById('btn-toggle-mgmt');
            var wrap = document.getElementById('submenu-wrapper');
            if (!btn || !wrap || btn.dataset.bound) return;
            btn.dataset.bound = '1';

            btn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                var isOpen = wrap.classList.contains('is-open');
                if (isOpen) {
                    wrap.classList.remove('is-open');
                    btn.classList.remove('is-expanded');
                    btn.setAttribute('aria-expanded', 'false');
                } else {
                    wrap.classList.add('is-open');
                    btn.classList.add('is-expanded');
                    btn.setAttribute('aria-expanded', 'true');
                }
            });
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initMgmtToggle);
        } else {
            initMgmtToggle();
        }
    })();
</script>
