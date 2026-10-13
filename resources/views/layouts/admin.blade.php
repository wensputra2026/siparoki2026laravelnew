<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Dashboard Administrator' }} - {{ config('app.name', 'SIPAROKI') }}</title>

    @php
        $defaultParokiId = \Illuminate\Support\Facades\DB::table('profil_paroki')->value('paroki_id')
            ?? \Illuminate\Support\Facades\DB::table('pengaturan_aplikasi')->value('paroki_id');
        $activeParoki = ($defaultParokiId ? \App\Models\Paroki::find($defaultParokiId) : null)
            ?? \App\Models\Paroki::where('nama_paroki', 'like', '%Benlutu%')->first()
            ?? \App\Models\Paroki::first();
        $activeParokiLogo = siparoki_asset($activeParoki?->logo, '/images/church-logo.png');
        $activeParokiNama = $activeParoki?->nama_paroki ?? 'SIPAROKI';
        $faviconUrl = $globalFavicon ?? $activeParokiLogo ?? asset('images/church-logo.png');
    @endphp

    <!-- Favicon from Active Paroki Logo -->
    <link rel="icon" type="image/png" href="{{ $faviconUrl }}">
    <link rel="shortcut icon" type="image/png" href="{{ $faviconUrl }}">

    <!-- Google Fonts: Poppins (Matching Frontend Typography Spec) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons (Matching bimkatlaravel12) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/all.min.css') }}">

    <!-- SweetAlert2 (Matching bimkat) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Tailwind CSS (Vite Production Build) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Tom Select v2.3.1 CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/tom-select/tom-select.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/tom-select/tom-select.tailwind.css') }}">

    <!-- Tom Select v2.3.1 JS -->
    <script src="{{ asset('vendor/tom-select/tom-select.complete.min.js') }}"></script>

    @livewireStyles

    <style>
        [x-cloak] { display: none !important; }
        :root {
            --font-sans: 'Poppins', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
            --default-font-family: 'Poppins', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
        }
        body, html, .font-sans, p, h1, h2, h3, h4, h5, h6, span, a, button, input, select, textarea, div, label, td, th {
            font-family: 'Poppins', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
        }
        .bi, [class^="bi-"], [class*=" bi-"] {
            font-family: "bootstrap-icons" !important;
        }
        .fa, .fas, .far, .fal, .fad, .fab, .fa-solid, .fa-regular, .fa-brands, [class^="fa-"], [class*=" fa-"] {
            font-family: "Font Awesome 6 Free", "Font Awesome 6 Brands", "FontAwesome" !important;
        }
        html, body {
            height: 100%;
            height: 100dvh;
            overflow: hidden !important;
        }

        /* Custom scrollbar for fixed sidebar and content */
        .sidebar-scroll::-webkit-scrollbar {
            width: 5px;
        }
        .sidebar-scroll::-webkit-scrollbar-track {
            background: rgba(241, 245, 249, 0.6) !important;
        }
        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: rgba(203, 213, 225, 0.8) !important;
            border-radius: 9999px;
        }
        .sidebar-scroll::-webkit-scrollbar-thumb:hover {
            background: rgba(148, 163, 184, 1) !important;
        }

        #admin-main-scroll::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        #admin-main-scroll::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        #admin-main-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 9999px;
        }
        #admin-main-scroll::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        /* ========================================================
           VATICAN CITY FLAG THEME (KUNING - PUTIH / GOLD & WHITE)
           ======================================================== */
        .kemenag-sidebar, .vatikan-sidebar {
            background: #ffffff !important;
            background: linear-gradient(180deg, #fffdf2 0%, #ffffff 15%, #ffffff 85%, #fefce8 100%) !important;
            border-right: 1.5px solid #fde68a !important;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.03) !important;
            color: #1e293b !important;
        }
        .kemenag-sidebar .sidebar-brand, .vatikan-sidebar .sidebar-brand {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
            border-bottom: 1px solid rgba(202, 138, 4, 0.4) !important;
            box-shadow: 0 2px 8px rgba(217, 119, 6, 0.18) !important;
        }
        .kemenag-sidebar .sidebar-profile, .vatikan-sidebar .sidebar-profile {
            background: #fffdf5 !important;
            border-top: 1px solid #fde68a !important;
        }
        /* Section category headings */
        .kemenag-sidebar p[class*="tracking-wider"], .vatikan-sidebar p[class*="tracking-wider"] {
            color: #78350f !important;
            font-weight: 900 !important;
            letter-spacing: 0.12em !important;
            font-size: 10px !important;
        }
        /* Inactive items & dropdown triggers */
        .kemenag-sidebar a:not(.menu-active),
        .kemenag-sidebar button:not(.menu-active),
        .vatikan-sidebar a:not(.menu-active),
        .vatikan-sidebar button:not(.menu-active) {
            color: #334155 !important;
            font-weight: 600 !important;
        }
        .kemenag-sidebar a:not(.menu-active) i,
        .kemenag-sidebar button:not(.menu-active) i,
        .vatikan-sidebar a:not(.menu-active) i,
        .vatikan-sidebar button:not(.menu-active) i {
            color: #d97706 !important;
            opacity: 1 !important;
        }
        .kemenag-sidebar a:hover,
        .kemenag-sidebar button:hover,
        .vatikan-sidebar a:hover,
        .vatikan-sidebar button:hover {
            background-color: #fef3c7 !important;
            color: #78350f !important;
        }
        .kemenag-sidebar a:hover i,
        .kemenag-sidebar button:hover i,
        .vatikan-sidebar a:hover i,
        .vatikan-sidebar button:hover i {
            color: #b45309 !important;
        }
        /* Active menu items */
        .kemenag-sidebar a.menu-active,
        .kemenag-sidebar button.menu-active,
        .vatikan-sidebar a.menu-active,
        .vatikan-sidebar button.menu-active {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
            color: #ffffff !important;
            font-weight: 700 !important;
            border-left: 3.5px solid #facc15 !important;
            box-shadow: 0 4px 12px rgba(217, 119, 6, 0.25) !important;
        }
        .kemenag-sidebar a.menu-active i,
        .kemenag-sidebar button.menu-active i,
        .vatikan-sidebar a.menu-active i,
        .vatikan-sidebar button.menu-active i {
            color: #ffffff !important;
            opacity: 1 !important;
        }
        /* Submenu container */
        .kemenag-sidebar .pl-6, .vatikan-sidebar .pl-6 {
            border-left: 1.5px solid #fde68a !important;
            margin-left: 1.25rem !important;
            padding-left: 0.75rem !important;
        }
        .kemenag-sidebar .pl-6 a:not(.menu-active), .vatikan-sidebar .pl-6 a:not(.menu-active) {
            color: #475569 !important;
        }
        .kemenag-sidebar .pl-6 a:not(.menu-active):hover, .vatikan-sidebar .pl-6 a:not(.menu-active):hover {
            color: #78350f !important;
            background-color: #fef3c7 !important;
        }
        .kemenag-sidebar .sidebar-scroll::-webkit-scrollbar-track, .vatikan-sidebar .sidebar-scroll::-webkit-scrollbar-track {
            background: #f8fafc !important;
        }
        .kemenag-sidebar .sidebar-scroll::-webkit-scrollbar-thumb, .vatikan-sidebar .sidebar-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e1 !important;
            border-radius: 9999px;
        }
        .kemenag-sidebar .sidebar-scroll::-webkit-scrollbar-thumb:hover, .vatikan-sidebar .sidebar-scroll::-webkit-scrollbar-thumb:hover {
            background: #94a3b8 !important;
        }

        /* ========================================================
           BIMKAT-STYLE DATATABLE LAYOUT & SPECIFICATIONS
           ======================================================== */
        .admin-content .overflow-x-auto:has(> table),
        .overflow-x-auto:has(> table) {
            -webkit-overflow-scrolling: touch;
            touch-action: pan-x pan-y;
            overscroll-behavior-y: auto;
            min-height: 380px;
            background: #ffffff;
            border-radius: 1rem;
            box-shadow: inset 0 0 0 1px rgba(226, 232, 240, 0.9);
        }
        .dark .admin-content .overflow-x-auto:has(> table),
        .dark .overflow-x-auto:has(> table) {
            background: #0f172a;
            box-shadow: inset 0 0 0 1px rgba(51, 65, 85, 0.8);
        }
        .overflow-x-auto::-webkit-scrollbar {
            height: 6px;
        }
        .overflow-x-auto::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 999px;
        }
        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 999px;
        }
        .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        .admin-content .overflow-x-auto > table,
        .overflow-x-auto > table {
            min-width: 760px;
            width: 100%;
            border-collapse: collapse;
        }
        .admin-content .overflow-x-auto > table thead,
        .overflow-x-auto > table thead {
            background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%);
        }
        .dark .admin-content .overflow-x-auto > table thead,
        .dark .overflow-x-auto > table thead {
            background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
        }
        .admin-content .overflow-x-auto > table thead th,
        .overflow-x-auto > table thead th {
            color: #64748b;
            font-size: 0.6875rem;
            font-weight: 800;
            letter-spacing: 0.02em;
            text-transform: uppercase;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: middle;
            white-space: nowrap;
        }
        .dark .admin-content .overflow-x-auto > table thead th,
        .dark .overflow-x-auto > table thead th {
            color: #94a3b8;
            border-bottom: 1px solid #334155;
        }
        .admin-content .overflow-x-auto > table tbody tr,
        table tbody tr {
            height: 52px;
            transition: background-color 150ms ease, box-shadow 150ms ease;
        }
        .admin-content .overflow-x-auto > table tbody tr:hover,
        table tbody tr:hover {
            background-color: #f8fafc;
        }
        .dark .admin-content .overflow-x-auto > table tbody tr:hover,
        .dark table tbody tr:hover {
            background-color: rgba(30, 41, 59, 0.5);
        }
        .admin-content .overflow-x-auto > table th,
        .admin-content .overflow-x-auto > table td {
            vertical-align: middle;
        }
        .admin-content .overflow-x-auto > table tbody td {
            border-bottom: 1px solid rgba(241, 245, 249, 0.95);
        }
        .dark .admin-content .overflow-x-auto > table tbody td {
            border-bottom: 1px solid rgba(30, 41, 59, 0.8);
        }
        .admin-content .overflow-x-auto > table tbody tr:last-child td {
            border-bottom: 0;
        }

        /* Search input with bi-search icon centered */
        .admin-content .relative > .absolute.inset-y-0:has(.bi-search),
        .admin-content .relative > .bi-search.absolute {
            display: flex;
            align-items: center;
            justify-content: center;
            padding-left: 0;
            left: 0.875rem;
            width: 1rem;
            line-height: 1;
            top: 50% !important;
            transform: translateY(-50%) !important;
            pointer-events: none;
        }

        /* Modern SweetAlert2 Toast Spec matching bimkat */
        .swal2-container.swal2-top-end,
        .swal2-container.swal2-top-right,
        .swal2-container.modern-toast-container {
            top: 4.75rem !important;
            right: 1.5rem !important;
            padding: 0 !important;
            z-index: 99999 !important;
        }
        .swal2-popup.modern-toast {
            display: flex !important;
            flex-direction: column !important;
            padding: 0.85rem 1.15rem !important;
            border-radius: 1rem !important;
            background: #ffffff !important;
            border: 1px solid #f1f5f9 !important;
            box-shadow: 0 20px 25px -5px rgba(15, 23, 42, 0.1), 0 8px 10px -6px rgba(15, 23, 42, 0.04) !important;
            min-width: 320px !important;
            max-width: 420px !important;
            box-sizing: border-box !important;
            position: relative !important;
            overflow: hidden !important;
        }
        .swal2-popup.modern-toast .swal2-html-container {
            margin: 0 !important;
            padding: 0 !important;
            overflow: visible !important;
            text-align: left !important;
        }
        .swal2-popup.modern-toast .swal2-timer-progress-bar {
            height: 3px !important;
            border-radius: 9999px !important;
            bottom: 0 !important;
        }
        .swal2-popup.modern-toast.border-l-emerald-500 .swal2-timer-progress-bar {
            background: #10b981 !important;
        }
        .swal2-popup.modern-toast.border-l-rose-500 .swal2-timer-progress-bar {
            background: #f43f5e !important;
        }
        .swal2-popup.modern-toast.border-l-amber-500 .swal2-timer-progress-bar {
            background: #f59e0b !important;
        }
        .swal2-popup.modern-toast.border-l-indigo-500 .swal2-timer-progress-bar {
            background: #6366f1 !important;
        }
    </style>
    <script>
        function adminPanel() {
            return {
                sidebarOpen: false,
                sidebarCollapsed: false,
                userDropdown: false,
                darkMode: localStorage.getItem('theme') === 'dark',
                init() {
                    if (localStorage.getItem('admin_sidebar_collapsed') === 'true') {
                        this.sidebarCollapsed = false;
                        localStorage.setItem('admin_sidebar_collapsed', 'false');
                    }
                },
                toggleSidebar() {
                    if (window.innerWidth >= 1024) {
                        this.sidebarCollapsed = !this.sidebarCollapsed;
                        localStorage.setItem('admin_sidebar_collapsed', this.sidebarCollapsed);
                    } else {
                        this.sidebarOpen = !this.sidebarOpen;
                    }
                },
                toggleDark() {
                    this.darkMode = !this.darkMode;
                    localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
                }
            };
        }
    </script>
</head>
<body class="h-screen h-[100dvh] overflow-hidden font-sans antialiased text-slate-800 dark:text-slate-100 bg-slate-50 dark:bg-slate-900 selection:bg-emerald-500 selection:text-white"
    x-data="adminPanel()"
    :class="{ 'dark': darkMode }">

    <div class="h-screen h-[100dvh] flex overflow-hidden">

        <!-- Mobile Sidebar Backdrop Overlay -->
        <div x-show="sidebarOpen"
            x-cloak
            x-transition:enter="transition-opacity ease-linear duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-40 bg-slate-900/60 backdrop-blur-xs lg:hidden"
            @click="sidebarOpen = false"
            style="display: none;"></div>

        <!-- 1. SIDEBAR (Matching SIPAROKI clean white/slate theme) -->
        @php
            $currentPrefix = explode('/', trim(request()->path(), '/'))[0] ?? 'superadmin';
            if (!in_array($currentPrefix, ['admin', 'superadmin', 'paroki', 'pastor', 'wilayah', 'kapela', 'kub', 'bendahara', 'penulis', 'umat'])) {
                $currentPrefix = 'superadmin';
            }
            $user = auth()->user();
            $roleTitle = $user?->role?->nama_role ?? 'Super Admin';
            $menuSections = \App\Services\PanelMenuService::getMenus($user, $currentPrefix);
        @endphp

        <aside :class="{
                   'translate-x-0': sidebarOpen,
                   '-translate-x-full': !sidebarOpen,
                   'lg:translate-x-0 lg:w-72': !sidebarCollapsed,
                   'lg:w-0 lg:overflow-hidden': sidebarCollapsed
               }"
            class="kemenag-sidebar fixed inset-y-0 left-0 z-50 w-72 flex flex-col transition-all duration-300 ease-in-out shadow-2xl lg:shadow-none h-screen h-[100dvh] select-none lg:static lg:z-30 lg:shrink-0">

            <!-- Sidebar Header / Branding (BIMKAT Spec) -->
            <div class="sidebar-brand h-16 shrink-0 flex items-center justify-between px-5">
                <a href="{{ url("/{$currentPrefix}/dashboard") }}" wire:navigate class="flex items-center gap-3 group min-w-0">
                    <div class="w-10 h-10 rounded-xl bg-white/10 p-1 flex items-center justify-center border border-white/20 shadow-md group-hover:scale-105 transition-transform shrink-0">
                        <img src="{{ $activeParokiLogo }}" alt="Logo Paroki" class="w-full h-full object-contain rounded-lg" onerror="this.onerror=null; this.src='/images/church-logo.png'">
                    </div>
                    <div class="flex flex-col min-w-0">
                        <span class="text-base font-bold text-white tracking-wide truncate">SIPAROKI</span>
                        <span class="text-[10px] text-amber-300 font-bold uppercase tracking-wider truncate max-w-[170px]">{{ $activeParokiNama }}</span>
                    </div>
                </a>
                <button @click="sidebarOpen = false" class="lg:hidden text-emerald-200 hover:text-white p-1 rounded-lg hover:bg-white/10 cursor-pointer">
                    <i class="bi bi-x-lg text-base"></i>
                </button>
            </div>

            <!-- Dynamic Role Sidebar Menu Items -->
            <nav class="flex-1 overflow-y-auto px-3 py-3 space-y-3 pb-20 sidebar-scroll">
                @foreach ($menuSections as $section)
                    <div class="space-y-1">
                        <p class="px-3 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-1">
                            {{ $section['section'] }}
                        </p>

                        <div class="space-y-1">
                            @foreach ($section['menus'] as $menu)
                                @if (isset($menu['submenus']))
                                    @php
                                        $isSubActive = false;
                                        foreach ($menu['submenus'] as $sub) {
                                            $cleanSub = ltrim($sub['href'], '/');
                                            if (request()->is($cleanSub) || request()->is($cleanSub . '/*')) {
                                                $isSubActive = true;
                                                break;
                                            }
                                        }
                                        $menuIcon = $menu['icon'] ?? 'fa-folder';
                                        $isBiIcon = str_starts_with($menuIcon, 'bi-');
                                    @endphp
                                    <div x-data="{ open: {{ $isSubActive ? 'true' : 'false' }} }" class="space-y-1">
                                        <button @click="open = !open"
                                            type="button"
                                            class="w-full flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold transition-all {{ $isSubActive ? 'bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white font-bold' : 'hover:bg-slate-50 dark:hover:bg-slate-800/60 text-slate-600 dark:text-slate-300' }}">
                                            <div class="flex items-center gap-3 min-w-0">
                                                @if($isBiIcon)
                                                    <i class="bi {{ $menuIcon }} text-sm opacity-70 shrink-0"></i>
                                                @else
                                                    <i class="fa-solid {{ $menuIcon }} text-xs opacity-70 shrink-0 w-4 text-center"></i>
                                                @endif
                                                <span class="truncate">{{ $menu['name'] }}</span>
                                            </div>
                                            <i :class="open ? 'rotate-180 text-amber-500' : ''" class="fa-solid fa-chevron-down text-[10px] text-slate-400 transition-transform duration-200"></i>
                                        </button>

                                        <div x-show="open" x-cloak class="pl-6 pr-1 py-1 space-y-1" style="{{ $isSubActive ? '' : 'display: none;' }}">
                                            @foreach ($menu['submenus'] as $sub)
                                                @php
                                                    $cleanSub = ltrim($sub['href'], '/');
                                                    $subActive = request()->is($cleanSub) || request()->is($cleanSub . '/*');
                                                    $subIcon = $sub['icon'] ?? 'fa-circle';
                                                    $isSubBi = str_starts_with($subIcon, 'bi-');
                                                @endphp
                                                <a href="{{ url($sub['href']) }}" wire:navigate
                                                    class="flex items-center gap-2.5 px-3 py-1.5 rounded-lg text-xs font-medium transition-all {{ $subActive ? 'menu-active bg-amber-50 dark:bg-amber-950/60 text-amber-700 dark:text-amber-300 font-bold border-l-2 border-amber-500' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-slate-800/50' }}">
                                                    @if($isSubBi)
                                                        <i class="bi {{ $subIcon }} opacity-70 shrink-0 text-xs"></i>
                                                    @else
                                                        <i class="fa-solid {{ $subIcon }} opacity-70 shrink-0 text-[10px] w-3 text-center"></i>
                                                    @endif
                                                    <span class="truncate">{{ $sub['name'] }}</span>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    @php
                                        $cleanHref = ltrim($menu['href'], '/');
                                        $isActive = request()->is($cleanHref) || request()->is($cleanHref . '/*') || request()->path() === $cleanHref;
                                        $isExternal = !empty($menu['isExternal']);
                                        $menuIcon = $menu['icon'] ?? 'fa-circle';
                                        $isBiIcon = str_starts_with($menuIcon, 'bi-');
                                    @endphp
                                    <a href="{{ $isExternal ? url($menu['href']) : url($menu['href']) }}"
                                        {{ $isExternal ? 'target="_blank"' : 'wire:navigate' }}
                                        class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold transition-all {{ $isActive ? 'menu-active bg-slate-100 dark:bg-slate-800 text-slate-900 dark:text-white font-bold border-l-3 border-amber-500 shadow-2xs' : 'hover:bg-slate-50 dark:hover:bg-slate-800/60 text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white' }}">
                                        @if($isBiIcon)
                                            <i class="bi {{ $menuIcon }} text-sm opacity-70 shrink-0"></i>
                                        @else
                                            <i class="fa-solid {{ $menuIcon }} text-xs opacity-70 shrink-0 w-4 text-center"></i>
                                        @endif
                                        <span class="truncate">{{ $menu['name'] }}</span>
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endforeach

                <!-- Logout Link at Bottom of Menu -->
                <div class="pt-2 border-t border-slate-100 dark:border-slate-800 mt-3">
                    <form method="POST" action="{{ route('logout') }}" id="sidebar-logout-form">
                        @csrf
                        <button type="submit"
                                class="w-full flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/30 transition-all text-left cursor-pointer">
                            <i class="fa-solid fa-arrow-right-from-bracket text-xs text-rose-500"></i>
                            <span>Keluar Aplikasi</span>
                        </button>
                    </form>
                </div>
            </nav>

            <!-- Sidebar User Card at Bottom (BIMKAT Spec) -->
            <div class="sidebar-profile p-3.5 border-t border-white/10 bg-[#042214]/90 shrink-0">
                <div class="flex items-center gap-2.5 p-2 rounded-xl bg-white/5 border border-white/10 shadow-xs">
                    <div class="w-8 h-8 rounded-lg bg-emerald-600 text-white font-bold text-xs flex items-center justify-center shrink-0 border border-emerald-400">
                        {{ strtoupper(substr($user->nama_lengkap ?? $user->name ?? $user->username ?? 'U', 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-bold text-white truncate">{{ $user->nama_lengkap ?? $user->name ?? $user->username ?? 'User' }}</p>
                        <span class="inline-block text-[10px] font-bold text-amber-300 truncate">{{ $roleTitle }}</span>
                    </div>
                </div>
            </div>

        </aside>

        <!-- 2. MAIN CONTENT AREA WRAPPER -->
        <div class="flex-1 flex flex-col h-screen h-[100dvh] min-w-0 bg-slate-50 dark:bg-slate-900 overflow-hidden">

            <!-- 2A. FIXED HEADER TOP NAVBAR (Exact BIMKAT Spec) -->
            <header class="h-16 shrink-0 bg-white/95 dark:bg-slate-950/95 backdrop-blur-md border-b border-slate-200/80 dark:border-slate-800/80 px-4 sm:px-6 lg:px-8 flex items-center justify-between sticky top-0 z-30 shadow-xs select-none">

                <div class="flex items-center gap-3">
                    <!-- Push-Menu Toggle Button -->
                    <button @click="toggleSidebar()"
                        type="button"
                        class="text-slate-600 hover:text-emerald-700 dark:text-slate-300 dark:hover:text-emerald-400 p-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors focus:outline-none cursor-pointer flex items-center justify-center shrink-0"
                        title="Toggle Push Menu (Sidebar)">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    <h1 class="text-base sm:text-lg font-bold text-slate-800 dark:text-white tracking-tight">
                        {{ $header ?? $title ?? 'Dashboard' }}
                    </h1>
                </div>

                <!-- Right Topbar Controls matching BIMKAT spec -->
                <div class="flex items-center gap-3 sm:gap-4 shrink-0">

                    <!-- Real-time Digital Clock Pill (Matching BIMKAT) -->
                    <div class="hidden md:flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-100/80 dark:bg-slate-800/80 border border-slate-200/70 dark:border-slate-700 text-xs font-semibold text-slate-700 dark:text-slate-300">
                        <i class="bi bi-clock-history text-emerald-600 dark:text-emerald-400"></i>
                        <span id="realtime-clock">{{ now()->locale('id')->translatedFormat('l, d F Y | H:i:s') }}</span>
                    </div>

                    <!-- Screen Zoom Control Widget (Matching BIMKAT) -->
                    <div class="hidden xl:flex items-center gap-1 px-2.5 py-1 rounded-xl bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs font-medium text-slate-600 dark:text-slate-300" 
                         x-data="{
                             zoom: 100,
                             setZoom(val) {
                                 this.zoom = Math.max(70, Math.min(130, val));
                                 document.body.style.zoom = this.zoom + '%';
                                 localStorage.setItem('user_zoom', this.zoom);
                             },
                             init() {
                                 const saved = localStorage.getItem('user_zoom');
                                 if (saved) {
                                     this.zoom = parseInt(saved);
                                     document.body.style.zoom = this.zoom + '%';
                                 }
                             }
                         }">
                        <span class="font-bold text-slate-800 dark:text-white text-[11px] min-w-[32px]" x-text="zoom + '%'">100%</span>
                        <button @click="setZoom(zoom - 5)" class="w-5 h-5 rounded hover:bg-slate-200 dark:hover:bg-slate-700 flex items-center justify-center font-bold cursor-pointer" title="Perkecil Tampilan">-</button>
                        <button @click="setZoom(zoom + 5)" class="w-5 h-5 rounded hover:bg-slate-200 dark:hover:bg-slate-700 flex items-center justify-center font-bold cursor-pointer">+</button>
                        <button @click="setZoom(100)" class="px-1.5 py-0.5 rounded text-[10px] font-semibold text-slate-500 hover:text-slate-800 dark:hover:text-white hover:bg-slate-200 dark:hover:bg-slate-700 cursor-pointer">Reset</button>
                    </div>

                    <!-- Quick Link to Public Portal -->
                    <a href="{{ url('/') }}" 
                       target="_blank" 
                       class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-300 hover:text-emerald-700 dark:hover:text-emerald-400 bg-slate-100 dark:bg-slate-800 hover:bg-emerald-50 dark:hover:bg-slate-700 border border-slate-200/60 dark:border-slate-700 transition-all cursor-pointer">
                        <i class="bi bi-box-arrow-up-right text-emerald-600 dark:text-emerald-400"></i>
                        <span class="hidden sm:inline">Lihat Website</span>
                    </a>

                    <!-- Panduan RBAC Pill -->
                    <a href="{{ url("/{$currentPrefix}/panduan-hak-akses") }}" wire:navigate class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-amber-300 dark:border-amber-700/60 bg-amber-50 dark:bg-amber-950/40 text-amber-800 dark:text-amber-300 text-xs font-bold shadow-2xs hover:bg-amber-100 transition cursor-pointer">
                        <i class="bi bi-shield-check text-amber-600"></i>
                        <span>Panduan RBAC</span>
                    </a>

                    <!-- User Profile Dropdown -->
                    <div class="relative" @click.away="userDropdown = false">
                        <button @click="userDropdown = !userDropdown"
                            class="flex items-center gap-2 p-1.5 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800/80 transition-colors cursor-pointer">
                            <div class="w-8 h-8 rounded-lg bg-emerald-600 text-white font-bold text-xs flex items-center justify-center shadow-xs overflow-hidden border border-emerald-500">
                                @if(!empty($user?->foto))
                                    <img src="{{ siparoki_asset($user->foto) }}" class="w-full h-full object-cover" />
                                @else
                                    {{ strtoupper(substr($user->nama_lengkap ?? $user->name ?? $user->username ?? 'U', 0, 1)) }}
                                @endif
                            </div>
                            <span class="text-xs font-bold text-slate-700 dark:text-slate-200 hidden md:block max-w-[120px] truncate">
                                {{ $user->nama_lengkap ?? $user->name ?? $user->username }}
                            </span>
                            <i class="bi bi-chevron-down text-slate-400 text-xs transition-transform duration-200" :class="{ 'rotate-180': userDropdown }"></i>
                        </button>

                        <div x-show="userDropdown"
                            x-cloak
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-56 bg-white dark:bg-slate-900 rounded-2xl shadow-xl border border-slate-100 dark:border-slate-800 py-2 z-50 divide-y divide-slate-100 dark:divide-slate-800"
                            style="display: none;">

                            <div class="px-4 py-2 border-b border-slate-100 dark:border-slate-800">
                                <p class="text-xs text-slate-400">Masuk sebagai</p>
                                <p class="text-sm font-semibold text-slate-800 dark:text-slate-100 truncate">{{ $user->nama_lengkap ?? $user->name ?? $user->username }}</p>
                                <p class="text-[11px] text-emerald-600 font-medium capitalize">{{ $roleTitle }}</p>
                            </div>

                            <div class="py-1">
                                <a href="{{ url("/{$currentPrefix}/profil-saya") }}" wire:navigate
                                    class="flex items-center gap-2.5 px-4 py-2 text-xs font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                                    <i class="bi bi-person text-sm text-slate-400"></i>
                                    <span>Profil Saya</span>
                                </a>
                                <a href="{{ url("/{$currentPrefix}/panduan-hak-akses") }}" wire:navigate
                                    class="flex items-center gap-2.5 px-4 py-2 text-xs font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                                    <i class="bi bi-shield-check text-sm text-amber-500"></i>
                                    <span>Panduan Hak Akses</span>
                                </a>
                            </div>

                            <div class="py-1">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="w-full flex items-center gap-2.5 px-4 py-2 text-xs font-semibold text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-950/30 transition-colors text-left cursor-pointer">
                                        <i class="bi bi-box-arrow-right text-sm"></i>
                                        <span>Keluar (Logout)</span>
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>

                </div>

            </header>

            <!-- 2B. Scrollable Content Wrapper with Fixed Footer -->
            <div id="admin-main-scroll" class="flex-1 overflow-y-auto min-h-0 flex flex-col justify-between">
                
                <main class="admin-content px-3 sm:px-6 pt-4 sm:pt-6 pb-12 flex-1">

                    <!-- Flash Message Alerts -->
                    @if (session('success'))
                        <div x-data="{ show: true }" x-show="show" class="mb-6 p-4 rounded-xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/60 flex items-start justify-between text-emerald-800 dark:text-emerald-300 shadow-xs">
                            <div class="flex items-center gap-3">
                                <i class="bi bi-check-circle-fill text-emerald-600 text-lg"></i>
                                <span class="text-sm font-medium">{{ session('success') }}</span>
                            </div>
                            <button @click="show = false" class="text-emerald-500 hover:text-emerald-700 cursor-pointer"><i class="bi bi-x text-lg"></i></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div x-data="{ show: true }" x-show="show" class="mb-6 p-4 rounded-xl bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800/60 flex items-start justify-between text-rose-800 dark:text-rose-300 shadow-xs">
                            <div class="flex items-center gap-3">
                                <i class="bi bi-exclamation-triangle-fill text-rose-600 text-lg"></i>
                                <span class="text-sm font-medium">{{ session('error') }}</span>
                            </div>
                            <button @click="show = false" class="text-rose-500 hover:text-rose-700 cursor-pointer"><i class="bi bi-x text-lg"></i></button>
                        </div>
                    @endif

                    <!-- Dynamic Page Slot (Livewire SPA) -->
                    {{ $slot }}

                </main>

                <!-- 2C. FIXED FOOTER (Matching BIMKAT spec) -->
                <footer class="shrink-0 border-t border-slate-200 dark:border-slate-800 bg-white/95 dark:bg-slate-950/95 backdrop-blur-sm px-4 sm:px-8 py-2.5 text-center sm:text-left flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 dark:text-slate-400 shadow-xs z-20 select-none">
                    <div class="flex items-center gap-2 font-medium">
                        <span>&copy; {{ date('Y') }} SIPAROKI &bull; {{ $activeParokiNama }}. All rights reserved.</span>
                    </div>
                    <div class="mt-1 sm:mt-0 flex items-center gap-2">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800 text-[11px] font-bold">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span>Sistem Aktif</span>
                        </span>
                    </div>
                </footer>

            </div>

        </div>

    </div>

    <!-- Real-time Digital Clock Updater Script (Indonesian locale format matching BIMKAT) -->
    <script>
        function updateAdminClock() {
            const el = document.getElementById('realtime-clock');
            if (!el) return;
            const now = new Date();
            const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            const dayName = days[now.getDay()];
            const date = now.getDate();
            const monthName = months[now.getMonth()];
            const year = now.getFullYear();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            el.textContent = `${dayName}, ${date} ${monthName} ${year} | ${hours}:${minutes}:${seconds}`;
        }
        setInterval(updateAdminClock, 1000);
        updateAdminClock();

        document.addEventListener('DOMContentLoaded', function () {
            // 1. Universal Download / Export Loader Overlay (BIMKAT Spec)
            document.addEventListener('click', function (e) {
                const exportBtn = e.target.closest('button[wire\\:click*="export"], a[wire\\:click*="export"], [data-export-btn]');
                if (exportBtn) {
                    Swal.fire({
                        title: 'Mempersiapkan Berkas...',
                        html: `
                            <div class="flex flex-col items-center justify-center gap-3 py-2">
                                <div class="w-10 h-10 border-4 border-amber-200 border-t-amber-600 rounded-full animate-spin"></div>
                                <p class="text-xs text-slate-500 font-medium">Sistem sedang merangkum data dan mengunduh berkas. Mohon tunggu...</p>
                            </div>
                        `,
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        timer: 5000,
                        timerProgressBar: true,
                        didOpen: () => {
                            if (window.Livewire && typeof window.Livewire.hook === 'function') {
                                const unhook = window.Livewire.hook('request', ({ succeed, fail }) => {
                                    succeed(() => {
                                        setTimeout(() => {
                                            Swal.close();
                                            if (typeof unhook === 'function') unhook();
                                        }, 600);
                                    });
                                    fail(() => {
                                        Swal.close();
                                        if (typeof unhook === 'function') unhook();
                                    });
                                });
                            }
                        }
                    });
                }
            });

            // 2. Global Modern SweetAlert2 Toast Function (BIMKAT Spec)
            window.showModernToast = function (type, title, message) {
                type = type || 'success';
                if (type === 'danger') type = 'error';

                const toastConfigs = {
                    success: {
                        borderClass: 'border-l-4 border-l-emerald-500',
                        badgeBg: 'bg-emerald-50 text-emerald-600 border border-emerald-200/80',
                        titleColor: 'text-emerald-950',
                        defaultTitle: 'Berhasil!',
                        iconSvg: '<svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>'
                    },
                    error: {
                        borderClass: 'border-l-4 border-l-rose-500',
                        badgeBg: 'bg-rose-50 text-rose-600 border border-rose-200/80',
                        titleColor: 'text-rose-950',
                        defaultTitle: 'Gagal!',
                        iconSvg: '<svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>'
                    },
                    warning: {
                        borderClass: 'border-l-4 border-l-amber-500',
                        badgeBg: 'bg-amber-50 text-amber-600 border border-amber-200/80',
                        titleColor: 'text-amber-950',
                        defaultTitle: 'Perhatian!',
                        iconSvg: '<svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>'
                    },
                    info: {
                        borderClass: 'border-l-4 border-l-sky-500',
                        badgeBg: 'bg-sky-50 text-sky-600 border border-sky-200/80',
                        titleColor: 'text-sky-950',
                        defaultTitle: 'Informasi',
                        iconSvg: '<svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
                    }
                };

                const cfg = toastConfigs[type] || toastConfigs.info;
                const finalTitle = title || cfg.defaultTitle;
                const finalMsg = message || '';

                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    showCloseButton: true,
                    timer: 3500,
                    timerProgressBar: true,
                    customClass: {
                        container: 'modern-toast-container',
                        popup: `modern-toast ${cfg.borderClass}`,
                        closeButton: 'modern-toast-close'
                    },
                    html: `
                        <div class="flex items-start gap-3.5 pr-4 text-left">
                            <div class="w-9 h-9 rounded-xl ${cfg.badgeBg} flex items-center justify-center shrink-0 shadow-xs">
                                ${cfg.iconSvg}
                            </div>
                            <div class="flex-1 min-w-0 pt-0.5">
                                <h4 class="text-xs font-bold uppercase tracking-wider ${cfg.titleColor} leading-tight">${finalTitle}</h4>
                                <p class="text-xs text-slate-600 mt-1 leading-relaxed font-medium break-words">${finalMsg}</p>
                            </div>
                        </div>
                    `,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                    }
                });
            };

            // 3. Livewire Toast Listeners
            function handleSwalToast(event) {
                let data = event.detail;
                if (Array.isArray(data)) {
                    data = data[0];
                } else if (data && typeof data === 'object' && data[0]) {
                    data = data[0];
                }
                if (!data) return;

                const iconType = data.type || data.icon || 'success';
                const titleText = data.title;
                const messageText = data.text || data.message || '';

                if (typeof window.showModernToast === 'function') {
                    window.showModernToast(iconType, titleText, messageText);
                }
            }

            window.addEventListener('swal:toast', handleSwalToast);
            window.addEventListener('toast', handleSwalToast);
            window.addEventListener('alert', handleSwalToast);
            window.addEventListener('notify', handleSwalToast);

            // 4. Modal Event Listener
            window.addEventListener('swal:modal', event => {
                const data = event.detail[0] || event.detail;
                Swal.fire({
                    title: data.title || 'Informasi',
                    text: data.text || '',
                    icon: data.type || 'info',
                    confirmButtonColor: '#f59e0b'
                });
            });
        });
    </script>

    @livewireScripts
</body>
</html>
