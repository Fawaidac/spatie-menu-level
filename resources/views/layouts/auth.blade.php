<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
    <meta name="robots" content="noindex, nofollow" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>
        @yield ('title', 'Autentikasi')
        · Tend Clinic OS
    </title>
    <meta name="description" content="Tend Clinic OS — Sistem Manajemen Rumah Sakit & CRM WhatsApp Pasien." />
    <meta name="theme-color" content="#fdf0f4" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Geist:wght@400;500;600;700;800&family=Geist+Mono:wght@400;500;600&display=swap"
        rel="stylesheet"
    />

    <!-- Tend CSS & App Brand Overrides -->
    <link rel="stylesheet" crossorigin href="{{ asset('tend/assets/today-rY2azoiN.css') }}" />
    <link rel="stylesheet" crossorigin href="{{ asset('tend/assets/settings-BZ16vYlf.css') }}" />
    @vite (['resources/css/app.css'])

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="48x48" />
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml" />

    <!-- Theme Initializer -->
    <script>
        (function (d) {
            try {
                var t = JSON.parse(localStorage.getItem('tend:theme') || '"light"');
                d.dataset.theme =
                    t === 'system' ? (matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light') : t;
            } catch (e) {
                d.dataset.theme = 'light';
            }
        })(document.documentElement);
    </script>

    <style>
        /* ── Auth Specific Styles ── */
        .auth-wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: var(--bg);
            color: var(--text);
            position: relative;
            overflow-x: hidden;
            font-family: "Geist", system-ui, -apple-system, sans-serif;
        }

        /* Ambient background glow */
        .auth-glow-1 {
            position: absolute;
            top: -10vw;
            left: -10vw;
            width: 50vw;
            height: 50vw;
            max-width: 600px;
            max-height: 600px;
            background: radial-gradient(circle, var(--glow-a, #db709333) 0%, transparent 70%);
            filter: blur(60px);
            pointer-events: none;
            z-index: 0;
        }

        .auth-glow-2 {
            position: absolute;
            bottom: -10vw;
            right: -10vw;
            width: 50vw;
            height: 50vw;
            max-width: 600px;
            max-height: 600px;
            background: radial-gradient(circle, var(--glow-b, #7c94dc22) 0%, transparent 70%);
            filter: blur(70px);
            pointer-events: none;
            z-index: 0;
        }

        /* Top Header */
        .auth-header {
            position: relative;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 32px;
            max-width: 1240px;
            width: 100%;
            margin: 0 auto;
        }

        .auth-brand {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: var(--text);
        }

        .auth-brand__mark {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: linear-gradient(135deg, #8b2252 0%, #db7093 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            box-shadow: 0 4px 14px -2px #8b225255;
            transition: transform 0.2s ease;
        }

        .auth-brand:hover .auth-brand__mark {
            transform: scale(1.04);
        }

        .auth-brand__mark svg {
            width: 22px;
            height: 22px;
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .auth-brand__title {
            font-size: 1.25rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            line-height: 1.1;
        }

        .auth-brand__title span {
            color: var(--color-brand);
        }

        .auth-brand__title small {
            display: block;
            font-size: 0.72rem;
            font-weight: 500;
            color: var(--muted);
            letter-spacing: 0.02em;
            text-transform: uppercase;
        }

        .auth-header__actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .auth-theme-toggle {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            border: 1px solid var(--line);
            background: var(--surface);
            color: var(--text);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .auth-theme-toggle:hover {
            border-color: var(--color-brand);
            background: var(--surface-2);
            transform: translateY(-1px);
        }

        .auth-theme-toggle svg {
            width: 18px;
            height: 18px;
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
        }

        /* Main Container */
        .auth-main {
            position: relative;
            z-index: 10;
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px 20px 48px;
            max-width: 1140px;
            width: 100%;
            margin: 0 auto;
        }

        .auth-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            width: 100%;
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 24px;
            overflow: hidden;
            box-shadow: var(--shadow-pop);
        }

        /* Left Showcase Side */
        .auth-showcase {
            background: linear-gradient(
                160deg,
                #8b2252 0%,
                #a83665 25%,
                #c4527a 65%,
                #db7093 100%
            );
            color: #ffffff;
            padding: 48px 40px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }

        .auth-showcase::after {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 10% 20%, rgba(255,255,255,0.15) 0%, transparent 50%),
                        radial-gradient(circle at 90% 80%, rgba(0,0,0,0.2) 0%, transparent 60%);
            pointer-events: none;
        }

        .auth-showcase__content {
            position: relative;
            z-index: 2;
        }

        .auth-pill-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 14px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.18);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            font-size: 0.78rem;
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 24px;
        }

        .auth-pill-badge .pulse-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #4ade80;
            box-shadow: 0 0 10px #4ade80;
            animation: pulse-ring 2s infinite;
        }

        @keyframes pulse-ring {
            0% { transform: scale(0.9); opacity: 0.8; }
            50% { transform: scale(1.3); opacity: 1; }
            100% { transform: scale(0.9); opacity: 0.8; }
        }

        .auth-showcase__title {
            font-size: 2.1rem;
            font-weight: 800;
            line-height: 1.2;
            letter-spacing: -0.03em;
            margin-bottom: 16px;
            color: #ffffff;
        }

        .auth-showcase__desc {
            font-size: 0.96rem;
            line-height: 1.6;
            color: rgba(255, 255, 255, 0.85);
            margin-bottom: 32px;
        }

        /* Feature List */
        .auth-features {
            display: flex;
            flex-direction: column;
            gap: 16px;
            margin-bottom: 36px;
        }

        .auth-feature-item {
            display: flex;
            align-items: flex-start;
            gap: 14px;
        }

        .auth-feature-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .auth-feature-icon svg {
            width: 18px;
            height: 18px;
            stroke: #fff;
            stroke-width: 2;
            fill: none;
        }

        .auth-feature-text b {
            display: block;
            font-size: 0.92rem;
            font-weight: 600;
            color: #fff;
        }

        .auth-feature-text span {
            font-size: 0.82rem;
            color: rgba(255, 255, 255, 0.78);
        }

        /* WhatsApp Chat Preview Card */
        .auth-wa-bubble {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 16px;
            padding: 16px;
            position: relative;
            z-index: 2;
        }

        .auth-wa-bubble__header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .auth-wa-bubble__tag {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.75rem;
            font-weight: 600;
            color: #dcfce7;
        }

        .auth-wa-bubble__tag svg {
            width: 14px;
            height: 14px;
            fill: currentColor;
        }

        .auth-wa-bubble__msg {
            font-size: 0.85rem;
            line-height: 1.45;
            color: #ffffff;
            background: rgba(0, 0, 0, 0.16);
            padding: 12px;
            border-radius: 12px;
            border-left: 3px solid #4ade80;
        }

        .auth-showcase__foot {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 24px;
            border-top: 1px solid rgba(255, 255, 255, 0.18);
            font-size: 0.78rem;
            color: rgba(255, 255, 255, 0.75);
        }

        /* Right Form Side */
        .auth-form-card {
            padding: 48px 42px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: var(--surface);
        }

        .auth-tabs {
            display: flex;
            background: var(--well);
            padding: 4px;
            border-radius: 12px;
            margin-bottom: 28px;
            border: 1px solid var(--line);
        }

        .auth-tab {
            flex: 1;
            text-align: center;
            padding: 10px 16px;
            font-size: 0.88rem;
            font-weight: 600;
            color: var(--muted);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .auth-tab.is-active {
            background: var(--surface);
            color: var(--text);
            box-shadow: var(--shadow);
        }

        .auth-form__head {
            margin-bottom: 24px;
        }

        .auth-form__title {
            font-size: 1.6rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            margin-bottom: 6px;
            color: var(--text);
        }

        .auth-form__sub {
            font-size: 0.88rem;
            color: var(--muted);
        }

        /* Form Controls */
        .auth-field-group {
            display: flex;
            flex-direction: column;
            gap: 16px;
            margin-bottom: 24px;
        }

        .auth-label {
            display: flex;
            flex-direction: column;
            gap: 6px;
            font-size: 0.84rem;
            font-weight: 600;
            color: var(--text);
        }

        .auth-input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

        .auth-input-wrap .ico-lead {
            position: absolute;
            left: 14px;
            width: 18px;
            height: 18px;
            color: var(--faint);
            pointer-events: none;
        }

        .auth-input {
            width: 100%;
            height: 44px;
            padding: 0 14px 0 42px;
            border-radius: 10px;
            border: 1px solid var(--line);
            background: var(--surface-2);
            color: var(--text);
            font-size: 0.9rem;
            font-family: inherit;
            transition: all 0.2s ease;
            outline: none;
        }

        .auth-input:focus {
            border-color: var(--color-brand);
            background: var(--surface);
            box-shadow: 0 0 0 3px color-mix(in srgb, var(--color-brand) 18%, transparent);
        }

        .auth-input--trail {
            padding-right: 44px;
        }

        .auth-pwd-toggle {
            position: absolute;
            right: 8px;
            width: 32px;
            height: 32px;
            border: none;
            background: transparent;
            color: var(--muted);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            transition: color 0.2s ease;
        }

        .auth-pwd-toggle:hover {
            color: var(--text);
        }

        .auth-pwd-toggle svg {
            width: 18px;
            height: 18px;
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
        }

        /* Extra Row (Remember / Forgot) */
        .auth-row-extra {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.82rem;
            margin-bottom: 24px;
        }

        .auth-check {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            color: var(--muted);
            font-weight: 500;
        }

        .auth-check input {
            accent-color: var(--color-brand);
            width: 16px;
            height: 16px;
            cursor: pointer;
        }

        .auth-link {
            color: var(--color-brand);
            text-decoration: none;
            font-weight: 600;
            transition: opacity 0.2s;
        }

        .auth-link:hover {
            text-decoration: underline;
        }

        /* Buttons */
        .auth-submit-btn {
            width: 100%;
            height: 46px;
            border-radius: 12px;
            border: none;
            background: linear-gradient(135deg, #8b2252 0%, #db7093 100%);
            color: #ffffff;
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 4px 18px -4px #8b225266;
            transition: all 0.25s ease;
        }

        .auth-submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px -4px #8b225288;
        }

        .auth-submit-btn:active {
            transform: translateY(0);
        }

        /* Quick Demo Roles */
        .auth-demo-section {
            margin-top: 28px;
            padding-top: 20px;
            border-top: 1px dashed var(--line);
        }

        .auth-demo-label {
            font-size: 0.76rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--muted);
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .auth-demo-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
        }

        .auth-demo-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 8px 6px;
            border-radius: 8px;
            border: 1px solid var(--line);
            background: var(--surface-2);
            color: var(--text);
            font-size: 0.75rem;
            cursor: pointer;
            transition: all 0.2s ease;
            text-align: center;
        }

        .auth-demo-btn:hover {
            border-color: var(--color-brand);
            background: var(--well);
            transform: translateY(-1px);
        }

        .auth-demo-btn b {
            font-weight: 600;
            display: block;
        }

        .auth-demo-btn small {
            font-size: 0.68rem;
            color: var(--muted);
        }

        /* Password strength bar */
        .pwd-strength-bar {
            height: 4px;
            border-radius: 2px;
            background: var(--line);
            margin-top: 6px;
            overflow: hidden;
            display: flex;
            gap: 3px;
        }

        .pwd-strength-seg {
            flex: 1;
            height: 100%;
            background: var(--line);
            transition: background 0.3s ease;
        }

        /* Flash Message Alert */
        .auth-alert {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 0.84rem;
            margin-bottom: 20px;
        }

        .auth-alert--success {
            background: color-mix(in srgb, var(--good) 12%, transparent);
            border: 1px solid color-mix(in srgb, var(--good) 30%, transparent);
            color: var(--good);
        }

        .auth-alert--error {
            background: color-mix(in srgb, var(--bad) 12%, transparent);
            border: 1px solid color-mix(in srgb, var(--bad) 30%, transparent);
            color: var(--bad);
        }

        .auth-wa-btn {
            width: 100%;
            height: 42px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 0.86rem;
            font-weight: 600;
            border: 1px solid var(--line);
            background: var(--surface-2);
            color: var(--text);
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .auth-wa-btn:hover {
            background: var(--well);
            border-color: #25D366;
        }

        .auth-header-btn {
            height: 38px;
            padding: 0 14px;
            border-radius: 10px;
            font-size: 0.84rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: 1px solid var(--line);
            background: var(--surface);
            color: var(--text);
            transition: all 0.2s ease;
        }

        .auth-header-btn:hover {
            border-color: var(--color-brand);
            background: var(--surface-2);
            transform: translateY(-1px);
        }

        /* ── Password Requirements Card (from user reference) ── */
        .pwd-req-container {
            margin-top: 10px;
        }

        .pwd-req-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 6px;
        }

        .pwd-req-status {
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--muted);
            transition: color 0.25s ease;
        }

        .pwd-progress-track {
            width: 100%;
            height: 5px;
            background: var(--line);
            border-radius: 999px;
            overflow: hidden;
            margin-bottom: 12px;
        }

        .pwd-progress-bar {
            height: 100%;
            width: 0%;
            border-radius: 999px;
            background: var(--line-2);
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1), background-color 0.3s ease;
        }

        .pwd-req-card {
            background: color-mix(in srgb, var(--color-brand) 5%, var(--surface-2));
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 14px 18px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px 20px;
            transition: all 0.25s ease;
        }

        :root[data-theme=dark] .pwd-req-card {
            background: rgba(255, 255, 255, 0.03);
            border-color: rgba(255, 255, 255, 0.08);
        }

        .pwd-req-item {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 0.82rem;
            color: var(--muted);
            transition: all 0.25s ease;
        }

        .pwd-req-item.is-valid {
            color: var(--good);
            font-weight: 600;
        }

        .pwd-req-icon {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.2s ease;
        }

        .pwd-req-icon svg {
            width: 16px;
            height: 16px;
            stroke: currentColor;
            stroke-width: 2;
            fill: none;
        }

        .pwd-req-item.is-valid .pwd-req-icon {
            transform: scale(1.1);
        }

        /* ── Captcha Widget (Login) ── */
        .auth-captcha-card {
            margin-bottom: 20px;
            padding: 14px 16px;
            background: var(--surface-2);
            border: 1px solid var(--line);
            border-radius: 14px;
            transition: border-color 0.2s ease;
        }

        .auth-captcha-card:focus-within {
            border-color: var(--color-brand);
        }

        .auth-captcha-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.82rem;
            font-weight: 600;
            color: var(--text);
            margin-bottom: 10px;
        }

        .auth-captcha-row {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .auth-captcha-canvas-wrap {
            height: 44px;
            border-radius: 10px;
            border: 1px solid var(--line);
            background: var(--surface);
            overflow: hidden;
            display: flex;
            align-items: center;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            flex-shrink: 0;
        }

        .auth-captcha-canvas {
            display: block;
            cursor: pointer;
        }

        .auth-captcha-refresh-btn {
            width: 38px;
            height: 44px;
            border-radius: 10px;
            border: 1px solid var(--line);
            background: var(--surface);
            color: var(--muted);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.25s ease;
            flex-shrink: 0;
        }

        .auth-captcha-refresh-btn:hover {
            color: var(--color-brand);
            border-color: var(--color-brand);
            background: var(--surface-2);
            transform: rotate(60deg);
        }

        .auth-captcha-refresh-btn svg {
            width: 17px;
            height: 17px;
            stroke: currentColor;
            stroke-width: 2.2;
            fill: none;
        }

        .auth-captcha-input {
            flex: 1;
            height: 44px;
            padding: 0 12px;
            border-radius: 10px;
            border: 1px solid var(--line);
            background: var(--surface);
            color: var(--text);
            font-size: 0.95rem;
            font-weight: 700;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            outline: none;
            transition: all 0.2s ease;
        }

        .auth-captcha-input:focus {
            border-color: var(--color-brand);
            box-shadow: 0 0 0 3px color-mix(in srgb, var(--color-brand) 18%, transparent);
        }

        .auth-captcha-input.is-correct {
            border-color: var(--good);
            color: var(--good);
            background: color-mix(in srgb, var(--good) 6%, transparent);
        }

        /* Footer */
        .auth-footer {
            position: relative;
            z-index: 10;
            padding: 20px;
            text-align: center;
            font-size: 0.78rem;
            color: var(--muted);
        }

        /* Responsive Breakpoints */
        @media (max-width: 900px) {
            .auth-grid {
                grid-template-columns: 1fr;
                border-radius: 20px;
            }
            .auth-showcase {
                display: none;
            }
            .auth-form-card {
                padding: 36px 24px;
            }
            .auth-header {
                padding: 16px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="auth-wrapper">
        <div class="auth-glow-1"></div>
        <div class="auth-glow-2"></div>

        <!-- Top Header Navigation -->
        <header class="auth-header">
            <a href="{{ route('dashboard.index') }}" class="auth-brand" title="Menuju Dashboard">
                <span class="auth-brand__mark" aria-hidden="true">
                    <svg viewBox="0 0 24 24">
                        <path d="M12 20.5s-7.5-4.4-7.5-10.2A4.3 4.3 0 0 1 12 7.6a4.3 4.3 0 0 1 7.5 2.7c0 5.8-7.5 10.2-7.5 10.2Z" />
                        <path d="M8.5 12.5h2l1-2 1.6 4 1-2h1.4" />
                    </svg>
                </span>
                <span class="auth-brand__title">tend<span>.</span><small>Northside Clinic</small></span>
            </a>

            <div class="auth-header__actions">
                <button type="button" class="auth-theme-toggle" id="btn-theme-auth" aria-label="Ganti Tema">
                    <svg id="theme-ico-sun" viewBox="0 0 24 24" style="display: none;">
                        <circle cx="12" cy="12" r="5" />
                        <path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42" />
                    </svg>
                    <svg id="theme-ico-moon" viewBox="0 0 24 24"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z" /></svg>
                </button>
                <a href="{{ route('dashboard.index') }}" class="auth-header-btn">
                    <span>Dashboard Demo</span>
                    <svg class="ico" viewBox="0 0 24 24" style="width: 16px; height: 16px; stroke: currentColor; fill: none; stroke-width: 2;"><path d="M5 12h14M12 5l7 7-7 7" /></svg>
                </a>
            </div>
        </header>

        <!-- Main Content (Dual Panel) -->
        <main class="auth-main">
            <div class="auth-grid">
                <!-- Left Showcase Panel -->
                <div class="auth-showcase">
                    <div class="auth-showcase__content">
                        <div class="auth-pill-badge">
                            <span class="pulse-dot"></span>
                            <span>Tend Clinic OS & WhatsApp CRM</span>
                        </div>

                        <h2 class="auth-showcase__title">Kelola Pasien & Klinik Lebih Cerdas.</h2>
                        <p class="auth-showcase__desc">Satu platform terintegrasi: jadwal dokter, rekam medis cepat, serta pengingat dan konfirmasi otomatis melalui WhatsApp resmi.</p>

                        <div class="auth-features">
                            <div class="auth-feature-item">
                                <div class="auth-feature-icon">
                                    <svg viewBox="0 0 24 24">
                                        <path d="M4.5 19.5 5.6 16A8 8 0 1 1 8.6 18.8z" />
                                        <path d="M9.5 9c.3 2.3 2.2 4.4 5.2 5.5l1-1.4-1.6-1-1 .7c-.8-.4-1.6-1.2-2-2l.7-1-1-1.6z" />
                                    </svg>
                                </div>
                                <div class="auth-feature-text">
                                    <b>WhatsApp CRM Otomatis</b>
                                    <span>Reminder kehadiran dan konfirmasi janji temu tanpa ketik manual.</span>
                                </div>
                            </div>

                            <div class="auth-feature-item">
                                <div class="auth-feature-icon">
                                    <svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" /></svg>
                                </div>
                                <div class="auth-feature-text">
                                    <b>Akses Terproteksi & Autentikasi Aman</b>
                                    <span>Hak akses terkelola untuk Dokter, Perawat, Loket, hingga Farmasi.</span>
                                </div>
                            </div>

                            <div class="auth-feature-item">
                                <div class="auth-feature-icon">
                                    <svg viewBox="0 0 24 24"><path d="M3 12h4l2-5 4 10 2-5h6" /></svg>
                                </div>
                                <div class="auth-feature-text">
                                    <b>Alur Pasien Real-Time</b>
                                    <span>Pantau pasien menunggu, diperiksa, hingga selesai dalam satu layar.</span>
                                </div>
                            </div>
                        </div>

                        <!-- WhatsApp Live Snippet -->
                        <div class="auth-wa-bubble">
                            <div class="auth-wa-bubble__header">
                                <span class="auth-wa-bubble__tag">
                                    <svg viewBox="0 0 24 24"><path d="M12 2a10 10 0 0 1 10 10 10 10 0 0 1-10 10 10 10 0 0 1-10-10 10 10 0 0 1 10-10z" /></svg>
                                    WhatsApp Reminder · Otomatis
                                </span>
                                <small style="font-size: 0.72rem; color: rgba(255, 255, 255, 0.7)">09:15 WIB</small>
                            </div>
                            <div class="auth-wa-bubble__msg">
                                "Halo Ibu Ana, jadwal konsultasi Anda dengan dr. Hendra Spesialis Penyakit Dalam telah
                                dijadwalkan besok pukul 09.30 WIB. Balas <b>1</b> untuk Konfirmasi Hadir."
                            </div>
                        </div>
                    </div>

                    <div class="auth-showcase__foot">
                        <span>© 2026 Tend Health. Hak cipta dilindungi.</span>
                        <span>SATUSEHAT Ready · 256-Bit SSL</span>
                    </div>
                </div>

                <!-- Right Form Panel -->
                <div class="auth-form-card">
                    <!-- Session alerts -->
                    @if (session('success'))
                        <div class="auth-alert auth-alert--success">
                            <svg class="ico" viewBox="0 0 24 24" style="width: 18px; height: 18px; stroke: currentColor; fill: none; stroke-width: 2;"><polyline points="20 6 9 17 4 12" /></svg>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    @if (session('info'))
                        <div
                            class="auth-alert"
                            style="
                                background: color-mix(in srgb, var(--sky) 12%, transparent);
                                border: 1px solid color-mix(in srgb, var(--sky) 30%, transparent);
                                color: var(--sky);
                            "
                        >
                            <svg class="ico" viewBox="0 0 24 24" style="width: 18px; height: 18px; stroke: currentColor; fill: none; stroke-width: 2;">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="12" y1="16" x2="12" y2="12" />
                                <line x1="12" y1="8" x2="12.01" y2="8" />
                            </svg>
                            <span>{{ session('info') }}</span>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="auth-alert auth-alert--error">
                            <svg class="ico" viewBox="0 0 24 24" style="width: 18px; height: 18px; stroke: currentColor; fill: none; stroke-width: 2;">
                                <circle cx="12" cy="12" r="10" />
                                <line x1="12" y1="8" x2="12" y2="12" />
                                <line x1="12" y1="16" x2="12.01" y2="16" />
                            </svg>
                            <span>{{ $errors->first() }}</span>
                        </div>
                    @endif

                    @yield ('content')
                </div>
            </div>
        </main>

        <footer class="auth-footer">
            Tend Health Clinic CRM · Dibangun dengan nuansa PaleVioletRed & Sistem Autentikasi Aman
        </footer>
    </div>

    <!-- Theme Switcher Script -->
    <script>
        (function () {
            var btn = document.getElementById('btn-theme-auth');
            var sunIco = document.getElementById('theme-ico-sun');
            var moonIco = document.getElementById('theme-ico-moon');

            function updateIcons(isDark) {
                if (sunIco && moonIco) {
                    sunIco.style.display = isDark ? 'block' : 'none';
                    moonIco.style.display = isDark ? 'none' : 'block';
                }
            }

            var curr = document.documentElement.dataset.theme === 'dark';
            updateIcons(curr);

            if (btn) {
                btn.addEventListener('click', function () {
                    var next = document.documentElement.dataset.theme === 'dark' ? 'light' : 'dark';
                    document.documentElement.dataset.theme = next;
                    try {
                        localStorage.setItem('tend:theme', JSON.stringify(next));
                    } catch (e) {}
                    updateIcons(next === 'dark');
                });
            }
        })();
    </script>
    @stack ('scripts')
</body>
</html>
