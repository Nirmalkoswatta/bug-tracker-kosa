<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    .dropdown-item.logout-red {
    color: #dc3545 !important;
    font-weight: 600;
    background: transparent !important;
    }
    .dropdown-menu {
    background: #fff !important;
    }
    .dropdown-item.logout-red:hover, .dropdown-item.logout-red:focus {
    background: #ffeaea !important;
    color: #a71d2a !important;
    }
    <style>
        .navbar,
        .navbar * {
            color: #fff !important;
            font-size: 1.15rem;
        }

        .navbar .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .navbar .nav-link,
        .navbar .dropdown-toggle {
            font-size: 1.15rem;
        }

        .btn-login,
        .btn-register,
        .btn-success {
            font-size: 1.15rem !important;
        }

        body {
            /* Unified admin dashboard gradient globally */
            background: linear-gradient(135deg, #0f2027 0%, #2c5364 55%, #141414 100%);
            min-height: 100vh;
            overflow-x: hidden;
            color: #fff;
        }

        /* Optional utility for subtle radial accent (not animated) */
        .app-gradient-overlay:before,
        .app-gradient-overlay:after {
            content: "";
            position: fixed;
            width: 520px;
            height: 520px;
            border-radius: 50%;
            filter: blur(140px);
            opacity: 0.25;
            pointer-events: none;
            mix-blend-mode: screen;
        }

        .app-gradient-overlay:before {
            top: -160px;
            left: -120px;
            background: linear-gradient(90deg, #6366f1, #8b5cf6);
        }

        .app-gradient-overlay:after {
            bottom: -180px;
            right: -140px;
            background: linear-gradient(90deg, #ec4899, #f59e0b);
        }

        /* Starfall animation (reintroduced) */
        #starfield {
            position: fixed;
            inset: 0;
            overflow: hidden;
            z-index: 0;
            pointer-events: none;
        }

        .star {
            position: absolute;
            top: -10vh;
            width: 2px;
            height: 2px;
            background: #fff;
            border-radius: 50%;
            opacity: .85;
            animation: fall linear infinite;
        }

        @keyframes fall {
            0% {
                transform: translateY(-10vh);
                opacity: .9;
            }

            90% {
                opacity: .85;
            }

            100% {
                transform: translateY(110vh);
                opacity: 0;
            }
        }

        /* Occasionally create longer streaks */
        .star.streak {
            width: 2px;
            height: 110px;
            background: linear-gradient(#fff, rgba(255, 255, 255, 0));
            filter: drop-shadow(0 0 4px rgba(255, 255, 255, .6));
        }

        /* Respect reduced-motion preference */
        @media (prefers-reduced-motion: reduce) {
            .star {
                animation-duration: 12s !important;
            }
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

<body style="background: #000 !important; min-height: 100vh;">
    <div id="starfield" aria-hidden="true"></div>
    <div id="app" class="app-gradient-overlay relative" style="z-index:1;">
        <nav class="navbar navbar-expand-md navbar-light fixed-top" style="background: transparent !important; backdrop-filter: blur(8px); z-index: 1040;">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    Bug Tracker
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto"></ul>
                    <ul class="navbar-nav ms-auto align-items-center">
                        @guest
                        @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="btn btn-success text-white px-4 py-2 mx-1 btn-login" style="font-weight:600; border-radius: 24px;" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @endif
                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="btn btn-success text-white px-4 py-2 mx-1 btn-register" style="font-weight:600; border-radius: 24px;" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item logout-red" href="{{ route('logout') }}"
                                    style="color: #dc3545 !important; font-weight: 600; background: transparent !important;"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <main class="py-4" style="padding-top: 80px;">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
    <script>
        (function() {
            const container = document.getElementById('starfield');
            if (!container) return;
            const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            const STAR_COUNT = prefersReducedMotion ? 30 : 90;
            for (let i = 0; i < STAR_COUNT; i++) {
                const s = document.createElement('div');
                const streak = Math.random() < 0.12; // 12% streaks
                s.className = 'star' + (streak ? ' streak' : '');
                const startLeft = Math.random() * 100; // vw
                s.style.left = startLeft + 'vw';
                if (streak) {
                    s.style.animationDuration = (6 + Math.random() * 8) + 's';
                } else {
                    s.style.animationDuration = (3 + Math.random() * 6) + 's';
                }
                s.style.animationDelay = (Math.random() * 6) + 's';
                s.style.opacity = (0.55 + Math.random() * 0.4).toFixed(2);
                container.appendChild(s);
            }
        })();
    </script>
</body>

</html>