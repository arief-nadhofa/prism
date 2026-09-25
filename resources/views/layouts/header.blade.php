<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistem Aplikasi</title>

    <!-- Style agar elemen x-cloak tersembunyi total sebelum Alpine aktif -->
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <!-- Jika belum ada Alpine.js di bundle Vite/Tailwind, pasang via CDN ini -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-800 antialiased">

    <!-- Container Layout -->
    <div class="min-h-screen flex">

        <!-- Backdrop Mobile (Overlay) -->
        <div id="sidebar-backdrop" onclick="toggleSidebar()" class="fixed inset-0 bg-slate-900/40 z-30 hidden lg:hidden transition-opacity"></div>

        <!-- ================= SIDEBAR ================= -->
        <aside id="sidebar" class="fixed inset-y-0 left-0 z-40 w-64 bg-white border-r border-slate-200 flex flex-col justify-between transition-transform duration-300 ease-in-out -translate-x-full lg:translate-x-0 lg:static">
            <!-- Bagian Atas: Brand / Logo & Nav -->
            <div>
                <!-- Brand Logo -->
                <div class="h-16 flex items-center justify-between px-6 border-b border-slate-100">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center text-white font-bold text-base shadow-md shadow-indigo-600/30">
                            P
                        </div>
                        <span class="font-bold text-slate-900 tracking-tight text-lg">PRISM</span>
                    </div>
                    <!-- Tombol close sidebar (hanya di mobile) -->
                    <button onclick="toggleSidebar()" class="lg:hidden p-1.5 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Nav Menu -->
                <nav class="px-3 py-4 space-y-1">
                    <p class="px-3 text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Menu Utama</p>

                    <!-- Menu Dashboard -->
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:text-indigo-600 hover:bg-slate-50' }}">
                        <i class="fa-solid fa-house text-base w-5 text-center {{ request()->routeIs('dashboard') ? 'text-indigo-700' : 'text-slate-400' }}"></i>
                        <span>Dashboard</span>
                    </a>

                    <a href="{{ route('problem-log.index') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition {{ request()->routeIs('problem-log.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:text-indigo-600 hover:bg-slate-50' }}">
                        <i class="fa-solid fa-chart-simple text-base w-5 text-center {{ request()->routeIs('problem-log.*') ? 'text-indigo-700' : 'text-slate-400' }}"></i>
                        <span>Problem Log</span>
                    </a>
                    <p class="px-3 text-xs font-semibold uppercase tracking-wider text-slate-400 mt-6 mb-2">Pengaturan</p>

                    <a href="{{ route('line.index') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition {{ request()->routeIs('line.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:text-indigo-600 hover:bg-slate-50' }}">
                        <i class="fa-solid fa-cogs text-base w-5 text-center {{ request()->routeIs('line.*') ? 'text-indigo-700' : 'text-slate-400' }}"></i>
                        <span>Line</span>
                    </a>
                    <a href="{{ route('category.index') }}"
                        class="flex items-center gap-3 px-3 py-2.5 rounded-xl font-medium text-sm transition {{ request()->routeIs('category.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:text-indigo-600 hover:bg-slate-50' }}">
                        <i class="fa-solid fa-cogs text-base w-5 text-center {{ request()->routeIs('category.*') ? 'text-indigo-700' : 'text-slate-400' }}"></i>
                        <span>Category</span>
                    </a>
                </nav>
            </div>

            <!-- Bagian Bawah: Profile / Logout -->
            <div class="p-4 border-t border-slate-100">
                <div class="flex items-center gap-3 p-2 rounded-xl bg-slate-50">
                    <div class="w-9 h-9 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-semibold text-sm">
                        AD
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-slate-800 truncate">{{ session('name') }}</p>
                        <p class="text-xs text-slate-500 truncate">{{ session('npk') }}</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- ================= MAIN CONTENT WRAPPER ================= -->
        <div class="flex-1 flex flex-col min-w-0">

            <!-- TOPBAR -->
            <header class="h-16 bg-white border-b border-slate-200 px-4 lg:px-8 flex items-center justify-between sticky top-0 z-20">
                <!-- Button Toggle Mobile -->
                <div class="flex items-center gap-3">
                    <button onclick="toggleSidebar()" class="lg:hidden p-2 rounded-lg text-slate-500 hover:text-slate-800 hover:bg-slate-100 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <h2 class="text-lg font-bold text-slate-800 hidden sm:block">{{ $title ?? 'Dashboard' }}</h2>
                </div>

                <!-- Right Action (Search & Notification) -->
                <div class="flex items-center gap-3">
                    <!-- Search bar -->
                    <div class="relative hidden sm:block">
                        <input type="text" placeholder="Cari data..." class="pl-9 pr-4 py-1.5 rounded-lg border border-slate-200 bg-slate-50 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-600 transition w-48 md:w-64">
                        <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>

                    <!-- Notifikasi -->
                    <button class="relative p-2 rounded-lg text-slate-500 hover:text-slate-800 hover:bg-slate-100 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-rose-500"></span>
                    </button>

                    <!-- Logout Button -->
                    <form method="POST" action="{{ route('proses-logout') }}">
                        @csrf
                        <button type="submit" class="px-3 py-1.5 rounded-lg text-sm font-medium text-rose-600 hover:bg-rose-50 transition flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span class="hidden md:inline">Keluar</span>
                        </button>
                    </form>
                </div>
            </header>