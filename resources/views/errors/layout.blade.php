<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
    <meta name="robots" content="noindex, nofollow" />

    <title>@yield('title') — SIMRS RSUD dr. Soebandi</title>
    <meta name="theme-color" content="#fdf0f4" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700;800&family=Geist+Mono:wght@400;500;600&display=swap"
        rel="stylesheet"
    />

    <!-- Tend Core Shell CSS & App Vite -->
    <link rel="stylesheet" href="{{ asset('tend/assets/index-C_0VME2I.css') }}" />
    @vite(['resources/css/app.css'])

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="48x48" />
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml" />

    <!-- Theme Init -->
    <script>
        (function (d) {
            d.classList.add('js');
            try {
                var t = JSON.parse(localStorage.getItem('tend:theme') || '"light"');
                d.dataset.theme = t === 'system' ? (matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light') : t;
            } catch (e) {
                d.dataset.theme = 'light';
            }
            d.classList.add('is-ready');
        })(document.documentElement);
    </script>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Geist', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            position: relative;
            overflow-x: hidden;
            transition: background-color 0.25s ease, color 0.25s ease;
        }

        /* Ambient Glow Blobs */
        .error-glow {
            position: fixed;
            border-radius: 50%;
            filter: blur(90px);
            opacity: 0.5;
            pointer-events: none;
            z-index: 0;
        }

        .error-glow-1 {
            width: 360px;
            height: 360px;
            top: -60px;
            left: -60px;
            background: radial-gradient(circle, var(--glow-a, #f5e2e9) 0%, transparent 70%);
        }

        .error-glow-2 {
            width: 420px;
            height: 420px;
            bottom: -80px;
            right: -80px;
            background: radial-gradient(circle, var(--glow-b, #ede8f5) 0%, transparent 70%);
        }

        /* Top Header */
        .error-header {
            position: relative;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 28px;
            border-bottom: 1px solid var(--line);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            background: color-mix(in srgb, var(--surface) 60%, transparent);
        }

        .error-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: var(--text);
        }

        .error-brand .brand__mark {
            background: var(--primary);
            color: var(--on-primary);
            width: 38px;
            height: 38px;
            border-radius: 11px;
            display: grid;
            place-items: center;
            box-shadow: 0 4px 14px color-mix(in srgb, var(--primary) 35%, transparent);
        }

        .error-brand .brand__mark svg {
            width: 22px;
            height: 22px;
            fill: currentColor;
        }

        .error-brand-text strong {
            font-size: 17px;
            font-weight: 750;
            display: block;
            line-height: 1.15;
            letter-spacing: -0.01em;
        }

        .error-brand-text small {
            font-size: 12px;
            color: var(--muted);
            display: block;
        }

        /* Main Container */
        .error-main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px 60px;
            position: relative;
            z-index: 5;
        }

        /* Glass Card */
        .error-card {
            width: 100%;
            max-width: 580px;
            background: var(--surface);
            border: 1px solid var(--line-2);
            border-radius: 28px;
            box-shadow: var(--shadow-pop);
            padding: 44px 38px;
            text-align: center;
            position: relative;
            overflow: hidden;
            animation: errorCardIn 0.5s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        @keyframes errorCardIn {
            from {
                opacity: 0;
                transform: translateY(24px) scale(0.97);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* Top badge */
        .error-badge-wrapper {
            display: flex;
            justify-content: center;
            margin-bottom: 22px;
        }

        .error-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 16px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 650;
            letter-spacing: 0.02em;
        }

        .error-badge--warn {
            background: color-mix(in srgb, var(--warn, #e9953f) 14%, transparent);
            color: var(--warn, #b8700f);
            border: 1px solid color-mix(in srgb, var(--warn, #e9953f) 30%, transparent);
        }

        .error-badge--bad {
            background: color-mix(in srgb, var(--bad, #cf4429) 14%, transparent);
            color: var(--bad, #cf4429);
            border: 1px solid color-mix(in srgb, var(--bad, #cf4429) 30%, transparent);
        }

        .error-badge--primary {
            background: color-mix(in srgb, var(--primary) 14%, transparent);
            color: var(--primary);
            border: 1px solid color-mix(in srgb, var(--primary) 30%, transparent);
        }

        /* Big Icon Visual */
        .error-icon-box {
            width: 88px;
            height: 88px;
            margin: 0 auto 24px;
            border-radius: 26px;
            display: grid;
            place-items: center;
            position: relative;
        }

        .error-icon-box svg {
            width: 44px;
            height: 44px;
            stroke-width: 1.8;
        }

        .error-icon-box--warn {
            background: color-mix(in srgb, var(--warn, #e9953f) 12%, transparent);
            color: var(--warn, #b8700f);
            box-shadow: 0 10px 30px -8px color-mix(in srgb, var(--warn, #e9953f) 25%, transparent);
            border: 1px solid color-mix(in srgb, var(--warn, #e9953f) 22%, transparent);
        }

        .error-icon-box--bad {
            background: color-mix(in srgb, var(--bad, #cf4429) 12%, transparent);
            color: var(--bad, #cf4429);
            box-shadow: 0 10px 30px -8px color-mix(in srgb, var(--bad, #cf4429) 25%, transparent);
            border: 1px solid color-mix(in srgb, var(--bad, #cf4429) 22%, transparent);
        }

        .error-icon-box--primary {
            background: color-mix(in srgb, var(--primary) 12%, transparent);
            color: var(--primary);
            box-shadow: 0 10px 30px -8px color-mix(in srgb, var(--primary) 25%, transparent);
            border: 1px solid color-mix(in srgb, var(--primary) 22%, transparent);
        }

        /* Number Code & Title */
        .error-code {
            font-size: 54px;
            font-weight: 850;
            line-height: 1;
            letter-spacing: -0.04em;
            color: var(--text);
            margin-bottom: 8px;
            font-family: 'Geist Mono', monospace;
        }

        .error-title {
            font-size: 22px;
            font-weight: 750;
            color: var(--text);
            margin-bottom: 14px;
            letter-spacing: -0.02em;
        }

        .error-desc {
            font-size: 14.5px;
            line-height: 1.6;
            color: var(--muted);
            margin-bottom: 28px;
            max-width: 460px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Path/Details Box */
        .error-info-box {
            background: var(--well);
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 12px 16px;
            margin-bottom: 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            font-size: 12.5px;
            color: var(--muted);
            text-align: left;
        }

        .error-info-box code {
            font-family: 'Geist Mono', monospace;
            color: var(--text);
            font-weight: 600;
            word-break: break-all;
        }

        /* Buttons Action Group */
        .error-actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .error-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 22px;
            border-radius: 999px;
            font-size: 14px;
            font-weight: 650;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            border: none;
            min-height: 44px;
        }

        .error-btn--primary {
            background: var(--primary);
            color: var(--on-primary);
            box-shadow: 0 4px 16px color-mix(in srgb, var(--primary) 35%, transparent);
        }

        .error-btn--primary:hover {
            opacity: 0.92;
            transform: translateY(-1px);
        }

        .error-btn--secondary {
            background: var(--surface-2);
            color: var(--text);
            border: 1px solid var(--line-2);
        }

        .error-btn--secondary:hover {
            background: var(--well);
            border-color: var(--line);
        }

        /* Footer */
        .error-footer {
            position: relative;
            z-index: 10;
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: var(--faint);
            border-top: 1px solid var(--line);
        }

        @media (max-width: 600px) {
            .error-card {
                padding: 32px 22px;
                border-radius: 22px;
            }
            .error-code {
                font-size: 44px;
            }
            .error-title {
                font-size: 19px;
            }
            .error-actions {
                flex-direction: column;
                width: 100%;
            }
            .error-btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="error-glow error-glow-1"></div>
    <div class="error-glow error-glow-2"></div>

    <!-- Header -->
    <header class="error-header">
        <a href="{{ session()->has('user_id') ? route('dashboard.index') : url('/login') }}" class="error-brand">
            <span class="brand__mark" aria-hidden="true">
                <svg viewBox="0 0 24 24">
                    <path d="M12 20.5s-7.5-4.4-7.5-10.2A4.3 4.3 0 0 1 12 7.6a4.3 4.3 0 0 1 7.5 2.7c0 5.8-7.5 10.2-7.5 10.2Z" />
                    <path d="M8.5 12.5h2l1-2 1.6 4 1-2h1.4" />
                </svg>
            </span>
            <div class="error-brand-text">
                <strong>Satu Sehat</strong>
                <small>RSUD dr. Soebandi Jember</small>
            </div>
        </a>

        <div style="display: flex; align-items: center; gap: 8px;">
            <button
                type="button"
                class="ibtn ibtn--glass btn-theme-toggle"
                id="btn-theme-error"
                aria-label="Toggle Mode Gelap/Terang"
                title="Ubah Tema"
            >
                <svg class="ico" viewBox="0 0 24 24" style="width:18px;height:18px;" aria-hidden="true"><path d="M12 3a6 6 0 0 0 9 9 9 0 1 1-9-9Z"/></svg>
            </button>
            @if(session()->has('user_id'))
                <a href="{{ route('dashboard.index') }}" class="error-btn error-btn--secondary" style="padding: 8px 16px; font-size: 13px; min-height: 38px;">
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="error-btn error-btn--secondary" style="padding: 8px 16px; font-size: 13px; min-height: 38px;">
                    Masuk (Login)
                </a>
            @endif
        </div>
    </header>

    <!-- Main Content -->
    <main class="error-main">
        <div class="error-card">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="error-footer">
        SIMRS Satu Sehat & CRM Klinik &copy; {{ date('Y') }} RSUD dr. Soebandi. Hak cipta dilindungi undang-undang.
    </footer>

    <!-- Theme Switcher Script -->
    <script>
        (function () {
            var sunSvg = '<svg class="ico" viewBox="0 0 24 24" style="width:18px;height:18px;" aria-hidden="true"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.93 4.93l1.41 1.41M17.66 17.66l1.41 1.41M2 12h2M20 12h2M4.93 19.07l1.41-1.41M17.66 6.34l1.41-1.41"/></svg>';
            var moonSvg = '<svg class="ico" viewBox="0 0 24 24" style="width:18px;height:18px;" aria-hidden="true"><path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/></svg>';

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
                document.querySelectorAll('#btn-theme-error, .btn-theme-toggle').forEach(function (btn) {
                    btn.setAttribute('aria-label', theme === 'dark' ? 'Switch to light theme' : 'Switch to dark theme');
                    btn.innerHTML = theme === 'dark' ? sunSvg : moonSvg;
                });
            }

            document.addEventListener('click', function (e) {
                var btn = e.target.closest('#btn-theme-error, .btn-theme-toggle');
                if (btn) {
                    e.preventDefault();
                    var current = document.documentElement.dataset.theme || getStoredTheme();
                    var next = current === 'dark' ? 'light' : 'dark';
                    applyTheme(next);
                }
            });

            applyTheme(document.documentElement.dataset.theme || getStoredTheme());
        })();
    </script>
</body>
</html>

