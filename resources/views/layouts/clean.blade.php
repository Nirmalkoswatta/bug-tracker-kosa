<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Bug Tracker') }}</title>
    <!-- TailwindCSS (CDN build) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Optional: tweak Tailwind theme (fonts, colors)
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ["Inter", "ui-sans-serif", "system-ui", "-apple-system", "Segoe UI", "Roboto", "Noto Sans", "Ubuntu", "Cantarell", "Helvetica Neue", "Arial", "sans-serif"],
                    },
                }
            }
        }
    </script>
    <!-- Inter font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    @stack('styles')
</head>

<body class="bg-gray-100 min-h-screen text-gray-900 font-sans">
    <header class="bg-white/80 backdrop-blur border-b border-slate-200 sticky top-0 z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <h1 class="text-xl font-black tracking-wide flex items-center gap-2 text-slate-800"><span class="text-pink-600">🐞</span> BUG TRACKER</h1>
            <div class="flex items-center gap-3">
                <div class="hidden md:flex items-center bg-slate-100 rounded-lg px-3 py-2 border border-slate-200 w-[360px]">
                    <i class="fa fa-search text-slate-400"></i>
                    <input type="search" placeholder="Search..." class="bg-transparent border-0 focus:ring-0 focus:outline-none w-full text-sm px-2" />
                </div>
                <!-- Bell removed by request -->
                <div class="flex items-center gap-2 bg-slate-100 px-3 py-2 rounded-lg border border-slate-200">
                    <div class="hidden sm:flex flex-col leading-tight">
                        <span class="font-semibold text-slate-700 text-sm">Admin</span>
                        <span class="text-xs text-blue-500 font-medium">@ADMIN</span>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <main class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">
        @yield('content')
    </main>
    @stack('scripts')
</body>

</html>