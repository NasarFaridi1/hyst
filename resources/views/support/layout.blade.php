<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support Panel - {{ config('app.name', 'HYST') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f8fafc; }
        .sidebar-link { display: flex; align-items: center; gap: 12px; padding: 12px 18px; border-radius: 12px; font-weight: 500; font-size: 14px; color: #64748b; transition: all 0.2s ease; }
        .sidebar-link:hover { background-color: #f1f5f9; color: #0f172a; }
        .sidebar-link.active { background-color: #c25a2a; color: #ffffff; font-weight: 600; box-shadow: 0 4px 14px rgba(194,90,42,0.3); }
    </style>
</head>
<body class="flex h-screen overflow-hidden bg-slate-50">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-white border-r border-slate-200 flex flex-col justify-between flex-shrink-0 z-20">
        <div>
            <!-- BRAND LOGO -->
            <div class="h-20 flex items-center px-6 border-b border-slate-100">
                <a href="{{ route('support.dashboard') }}" class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-orange-600 flex items-center justify-center text-white font-bold text-xl shadow-md">
                        🎧
                    </div>
                    <div>
                        <span class="font-bold text-lg text-slate-900 block leading-none">Support Panel</span>
                        <span class="text-xs text-orange-600 font-semibold tracking-wider uppercase">HYST Desk</span>
                    </div>
                </a>
            </div>

            <!-- NAVIGATION TABS -->
            <nav class="p-4 space-y-1.5">
                <a href="{{ route('support.dashboard') }}" class="sidebar-link {{ request()->routeIs('support.dashboard') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('support.tickets.index') }}" class="sidebar-link {{ request()->routeIs('support.tickets*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                    </svg>
                    <span>All Tickets</span>
                </a>

                <a href="{{ route('support.orders.index') }}" class="sidebar-link {{ request()->routeIs('support.orders*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <span>All Orders</span>
                </a>

                <a href="{{ route('support.users.index') }}" class="sidebar-link {{ request()->routeIs('support.users*') ? 'active' : '' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span>All Users</span>
                </a>
            </nav>
        </div>

        <!-- FOOTER USER INFO -->
        <div class="p-4 border-t border-slate-100">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-slate-900 text-white font-bold flex items-center justify-center text-sm">
                        {{ strtoupper(substr(auth()->user()->name ?? 'S', 0, 1)) }}
                    </div>
                    <div class="truncate max-w-[110px]">
                        <span class="block text-xs font-semibold text-slate-800 truncate">{{ auth()->user()->name ?? 'Support User' }}</span>
                        <span class="block text-[10px] text-slate-400 capitalize">{{ auth()->user()->role ?? 'Support' }}</span>
                    </div>
                </div>
                <a href="{{ route('front.home') }}" title="Back to main site" class="p-2 text-slate-400 hover:text-slate-700 transition">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </a>
            </div>
        </div>
    </aside>

    <!-- MAIN CONTENT AREA -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
        <!-- TOP HEADER -->
        <header class="h-20 bg-white border-b border-slate-200 flex items-center justify-between px-8 flex-shrink-0">
            <div>
                <h1 class="text-xl font-bold text-slate-800">@yield('title', 'Support Panel')</h1>
            </div>
            <div class="flex items-center gap-4">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 mr-2 animate-pulse"></span>
                    Support Active
                </span>
                <a href="{{ route('front.home') }}" class="text-sm font-semibold text-slate-600 hover:text-slate-900 border px-4 py-2 rounded-xl hover:bg-slate-50 transition">
                    Visit Main Site
                </a>
            </div>
        </header>

        <!-- PAGE CONTENT -->
        <main class="flex-1 overflow-y-auto p-8">
            @if(session('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: @json(session('success')),
                        confirmButtonColor: '#c25a2a'
                    });
                </script>
            @endif

            @if(session('error'))
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: @json(session('error')),
                        confirmButtonColor: '#ef4444'
                    });
                </script>
            @endif

            @yield('content')
        </main>
    </div>

</body>
</html>
