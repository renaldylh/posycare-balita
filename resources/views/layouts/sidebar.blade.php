<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'POSYCARE')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans antialiased">
    <div class="flex h-screen overflow-hidden">
        
        <!-- Mobile Sidebar Backdrop -->
        <div id="sidebarBackdrop" onclick="toggleSidebar()" class="fixed inset-0 z-20 bg-black opacity-50 transition-opacity lg:hidden hidden"></div>

        <!-- Sidebar -->
        <aside id="sidebar" class="fixed inset-y-0 left-0 z-30 w-60 px-4 py-4 transition-transform duration-300 transform -translate-x-full bg-gradient-to-b from-purple-700 to-indigo-800 text-white lg:translate-x-0 lg:static lg:inset-0 shadow-xl flex flex-col">
            <!-- Brand -->
            <div class="flex items-center justify-between px-2 mb-6">
                <span class="font-bold text-xl">POSYCARE</span>
                <button onclick="toggleSidebar()" class="lg:hidden text-white hover:text-gray-200">✕</button>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 overflow-y-auto">
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-white/10 transition-colors {{ request()->routeIs('dashboard') ? 'bg-white/20' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    
                    <li class="pt-4">
                        <span class="px-3 text-xs uppercase tracking-wider text-purple-300 font-semibold">Prediksi Gizi</span>
                    </li>
                    <li>
                        <a href="{{ route('prediksi.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-white/10 transition-colors {{ request()->routeIs('prediksi.index') ? 'bg-white/20' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                            </svg>
                            <span>Input Prediksi</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('prediksi.rekap') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-white/10 transition-colors {{ request()->routeIs('prediksi.rekap') || request()->routeIs('prediksi.show') ? 'bg-white/20' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            <span>Rekap Prediksi</span>
                        </a>
                    </li>

                    <li class="pt-4">
                        <span class="px-3 text-xs uppercase tracking-wider text-purple-300 font-semibold">Data Posyandu</span>
                    </li>
                    <li>
                        <a href="{{ route('balita.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-white/10 transition-colors {{ request()->routeIs('balita.*') ? 'bg-white/20' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <span>Data Balita</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('pengukuran.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-white/10 transition-colors {{ request()->routeIs('pengukuran.*') ? 'bg-white/20' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                            <span>Pengukuran Balita</span>
                        </a>
                    </li>

                    <li class="pt-4">
                        <span class="px-3 text-xs uppercase tracking-wider text-purple-300 font-semibold">Laporan</span>
                    </li>
                    <li>
                        <a href="{{ route('laporan.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-white/10 transition-colors {{ request()->routeIs('laporan.*') ? 'bg-white/20' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span>Laporan Bulanan</span>
                        </a>
                    </li>

                    <li class="pt-4">
                        <span class="px-3 text-xs uppercase tracking-wider text-purple-300 font-semibold">Sistem</span>
                    </li>
                    <li>
                        <a href="{{ route('users.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-white/10 transition-colors {{ request()->routeIs('users.*') ? 'bg-white/20' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            <span>Manajemen User</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('logout') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-red-500/20 text-red-200 hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            <span>Logout</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content Wrapper -->
        <div class="flex flex-col flex-1 h-full overflow-hidden">
            <!-- Mobile Header -->
            <header class="flex items-center justify-between px-4 py-3 bg-white border-b lg:hidden">
                <span class="font-bold text-lg text-purple-800">POSYCARE</span>
                <button onclick="toggleSidebar()" class="p-1 rounded text-gray-600 hover:bg-gray-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </header>

            <!-- Main Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-5">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            sidebar.classList.toggle('-translate-x-full');
            backdrop.classList.toggle('hidden');
        }
    </script>
</body>
</html>
