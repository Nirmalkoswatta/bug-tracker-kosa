<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <style>
        /* Dropdown styles */
        .dropdown-item.logout-red {
            color: #dc3545 !important;
            font-weight: 600;
            background: transparent !important;
        }

        .dropdown-menu {
            background: #fff !important;
        }

        .dropdown-item.logout-red:hover,
        .dropdown-item.logout-red:focus {
            background: #ffeaea !important;
            color: #a71d2a !important;
        }

        /* Global white theme */
        html,
        body {
            background: #ffffff !important;
            color: #111111 !important;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Navbar in white theme */
        .navbar {
            background: rgba(255, 255, 255, 0.7) !important;
            border-bottom: 1px solid #e5e7eb;
            box-shadow: 0 4px 24px -8px rgba(0, 0, 0, 0.07);
            backdrop-filter: blur(8px);
            transition: background 0.3s, box-shadow 0.3s;
        }

        .navbar,
        .navbar * {
            color: #111111 !important;
            font-size: 1.05rem;
        }

        /* Card system (global) */
        .ui-container {
            max-width: 100%;
            margin: 0;
            /* left aligned */
            padding: 24px 16px 40px;
        }

        .card-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 16px;
            align-items: stretch;
            justify-items: stretch;
        }

        .ui-card {
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid #e5e7eb;
            border-radius: 18px;
            box-shadow: 0 10px 32px -10px rgba(80, 80, 180, .13), 0 1.5px 8px -2px rgba(0, 0, 0, .07);
            transition: transform .22s ease, box-shadow .22s ease, opacity .35s ease, translate .35s ease;
            padding: 22px 18px;
            opacity: 0;
            transform: translateY(10px);
        }

        /* Modern form styling */
        .ui-card form,
        .ui-card .form {
            background: rgba(245, 247, 255, 0.7);
            border-radius: 12px;
            padding: 1rem 1.2rem;
            box-shadow: 0 2px 8px -4px rgba(80, 80, 180, 0.07);
            margin-bottom: 1rem;
        }

        .ui-card input,
        .ui-card select,
        .ui-card textarea {
            border-radius: 8px !important;
            border: 1px solid #d1d5db !important;
            background: #f8fafc !important;
            transition: border 0.2s;
        }

        .ui-card input:focus,
        .ui-card select:focus,
        .ui-card textarea:focus {
            border-color: #6366f1 !important;
            box-shadow: 0 0 0 2px #6366f133;
        }

        .ui-card .btn,
        .ui-card button {
            border-radius: 8px !important;
            font-weight: 600;
            letter-spacing: 0.01em;
            box-shadow: 0 2px 8px -4px rgba(80, 80, 180, 0.07);
        }

        .ui-card .btn-outline-primary {
            border-color: #6366f1 !important;
            color: #6366f1 !important;
        }

        .ui-card .btn-outline-primary:hover {
            background: #6366f1 !important;
            color: #fff !important;
        }

        .ui-card.animate-in {
            opacity: 1;
            transform: translateY(0);
        }

        .ui-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 34px -14px rgba(0, 0, 0, .22);
        }

        .btn {
            position: relative;
            z-index: 0;
        }

        .navbar .navbar-brand {
            font-size: 1.25rem;
            font-weight: 700;
            color: #111111 !important;
        }

        /* Modern brand styling */
        .brand-modern {
            font-size: clamp(1.7rem, 2.6vw, 2.4rem) !important;
            font-weight: 800 !important;
            letter-spacing: 1px;
            line-height: 1.05;
            background: linear-gradient(90deg, #111 0%, #2563eb 40%, #7c3aed 70%, #db2777 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent !important;
            position: relative;
            display: inline-flex;
            align-items: center;
            gap: .55rem;
            text-transform: uppercase;
        }

        .brand-modern .brand-accent {
            font-size: 1.15em;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.25));
            animation: bugPulse 3.5s ease-in-out infinite;
        }

        @keyframes bugPulse {

            0%,
            100% {
                transform: scale(1) rotate(0deg);
            }

            25% {
                transform: scale(1.08) rotate(4deg);
            }

            50% {
                transform: scale(1.02) rotate(-3deg);
            }

            75% {
                transform: scale(1.09) rotate(2deg);
            }
        }

        @media (max-width: 576px) {
            .brand-modern {
                font-size: 1.9rem !important;
            }
        }

        .navbar .nav-link,
        .navbar .dropdown-toggle {
            font-size: 1.05rem;
            color: #111111 !important;
        }

        .btn-login,
        .btn-register,
        .btn-success {
            font-size: 1.05rem !important;
        }

        /* Remove previous gradient overlay visuals */
        .app-gradient-overlay:before,
        .app-gradient-overlay:after {
            display: none !important;
        }
    </style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Bug Tracker</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <!-- Tailwind CDN (temporary until compiled) -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.4/dist/tailwind.min.css" rel="stylesheet" />
    @stack('styles')
</head>

<body style="background: #fff !important; min-height: 100vh; color:#111 !important;">
    <div id="app" class="relative" style="z-index:1;">
        <nav class="navbar navbar-expand-md navbar-light fixed-top" style="z-index: 1040;">
            <div class="container d-flex justify-content-center">
                <span class="navbar-brand brand-modern text-center" style="cursor: default; pointer-events: none; flex:0 1 auto;">
                    <span class="brand-accent">🐞</span> Bug Tracker
                </span>
                <div class="collapse navbar-collapse show position-absolute end-0 me-3" style="top:0; bottom:0; display:flex; align-items:center;" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto d-none"></ul>
                    <ul class="navbar-nav ms-auto align-items-center" style="gap:0.75rem;">
                        @auth
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                    class="dropdown-item logout-red">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>
        <main class="py-4" style="padding-top: 88px;">
            <div class="ui-container">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cards = Array.from(document.querySelectorAll('.ui-card'));
            cards.forEach((c, i) => {
                setTimeout(() => c.classList.add('animate-in'), 60 + i * 70);
            });
        });
    </script>
    @stack('scripts')
    <!-- Starfall animation removed -->
</body>

</html>