<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Bug Tracker') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.4/dist/tailwind.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    @stack('styles')
</head>

<body class="bg-gray-100 min-h-screen text-gray-900">
    <div class="flex min-h-screen">
        <!-- ICON Sidebar -->
        <aside class="w-20 bg-gradient-to-b from-slate-900 to-slate-800 flex flex-col items-center py-6 space-y-4 shadow-xl">
            <a href="{{ route('admin.overview') }}" class="mb-6" title="Home">
                <img src="https://cdn-icons-png.flaticon.com/512/616/616494.png" alt="logo" class="w-10 h-10" />
            </a>
            <nav class="flex flex-col gap-3 flex-1">
                <a href="{{ route('admin.overview') }}" class="group p-3 rounded-xl transition {{ request()->routeIs('admin.overview') ? 'bg-slate-700 text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}" title="Home">
                    <i class="fa fa-home text-xl"></i>
                </a>
                <a href="{{ route('admin.projects') }}" class="group p-3 rounded-xl transition {{ request()->routeIs('admin.projects') ? 'bg-slate-700 text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}" title="Projects">
                    <i class="fa fa-briefcase text-xl"></i>
                </a>
                <a href="{{ route('admin.bugs') }}" class="group p-3 rounded-xl transition {{ request()->routeIs('admin.bugs') ? 'bg-slate-700 text-white' : 'text-slate-300 hover:bg-slate-700 hover:text-white' }}" title="Issues">
                    <i class="fa fa-exclamation-triangle text-xl"></i>
                </a>
                <a href="{{ route('bugs.create') }}" class="group p-3 rounded-xl transition text-slate-300 hover:bg-slate-700 hover:text-white" title="Add">
                    <i class="fa fa-plus text-xl"></i>
                </a>
                <a href="#" class="group p-3 rounded-xl transition text-slate-300 hover:bg-slate-700 hover:text-white" title="Notifications">
                    <i class="fa fa-bell text-xl"></i>
                </a>
                <a href="#" class="group p-3 rounded-xl transition text-slate-300 hover:bg-slate-700 hover:text-white" title="Chat">
                    <i class="fa fa-comments text-xl"></i>
                </a>
            </nav>
        </aside>
        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-h-screen">
            <!-- Top Navbar -->
            <header class="bg-white/80 backdrop-blur supports-backdrop-blur:bg-white/60 border-b border-slate-200 flex items-center px-6 h-20 justify-between sticky top-0 z-10">
                <div class="flex items-center gap-6">
                    <h1 class="text-2xl font-black tracking-wide flex items-center gap-2 text-slate-800"><span class="text-pink-600">🐞</span> BUG TRACKER</h1>
                    <div class="hidden md:flex items-center bg-slate-100 rounded-lg px-3 py-2 border border-slate-200 w-[360px]">
                        <i class="fa fa-search text-slate-400"></i>
                        <input type="search" placeholder="Search bugs, users, projects..." class="bg-transparent border-0 focus:ring-0 focus:outline-none w-full text-sm px-2" />
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <button class="hidden md:inline-flex items-center gap-2 text-slate-600 hover:text-slate-800"><i class="fa fa-sliders-h"></i><span class="sr-only">Filters</span></button>
                    <a href="#" class="text-slate-500 hover:text-slate-800"><i class="fa fa-bell"></i></a>
                    <div class="flex items-center gap-2 bg-slate-100 px-3 py-2 rounded-lg border border-slate-200">
                        <img src="https://randomuser.me/api/portraits/men/32.jpg" class="w-8 h-8 rounded-full border-2 border-blue-200" alt="User" />
                        <div class="hidden sm:flex flex-col leading-tight">
                            <span class="font-semibold text-slate-700 text-sm">Ed White</span>
                            <span class="text-xs text-blue-500 font-medium">@PROJECT_LEADER</span>
                        </div>
                    </div>
                </div>
            </header>
            <!-- Main Content -->
            <main class="flex-1 p-6 md:p-8 bg-gray-100 animate-[fadeIn_.35s_ease]">
                @yield('admin-content')
            </main>
        </div>
    </div>
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(6px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }
    </style>
    @stack('scripts')
</body>

</html>