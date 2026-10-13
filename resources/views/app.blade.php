<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50 text-slate-800">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'SIPAROKI') }}</title>

        <!-- Dynamic Favicon (Synchronized with Parish Profile & Cache-Busted) -->
        @php
            $faviconRaw = !empty($globalFavicon) ? $globalFavicon : (!empty($globalLogo) ? $globalLogo : null);
            $faviconUrl = $faviconRaw ? (str_starts_with($faviconRaw, 'http') ? $faviconRaw : asset(ltrim($faviconRaw, '/'))) : asset('favicon.png');
            $faviconPath = parse_url($faviconUrl, PHP_URL_PATH);
            $faviconExt = strtolower(pathinfo($faviconPath, PATHINFO_EXTENSION));
            $faviconMime = match($faviconExt) {
                'webp' => 'image/webp',
                'png' => 'image/png',
                'jpg', 'jpeg' => 'image/jpeg',
                'svg' => 'image/svg+xml',
                default => 'image/x-icon',
            };
            $faviconVersion = \Illuminate\Support\Facades\Cache::get('global_view_data_version', 1) . '_' . (file_exists(public_path('favicon.ico')) ? filemtime(public_path('favicon.ico')) : time());
        @endphp
        <link rel="icon" type="{{ $faviconMime }}" href="{{ $faviconUrl }}?v={{ $faviconVersion }}">
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v={{ $faviconVersion }}">
        <link rel="apple-touch-icon" href="{{ $faviconUrl }}?v={{ $faviconVersion }}">

        <!-- Google Fonts: Inter (BIMKAT Official Typography Spec) -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

        <!-- Bootstrap Icons (BIMKAT Official Icon System) -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

        <!-- SweetAlert2 (BIMKAT Spec) -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- Global Inter Typography & Stability Styles -->
        <style>
            [x-cloak] { display: none !important; }
            :root {
                --font-sans: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
                --default-font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
            }

            body, html, .font-sans, p, h1, h2, h3, h4, h5, h6, span, a, button, input, select, textarea, div, label, td, th {
                font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
            }

            .bi, [class^="bi-"], [class*=" bi-"] {
                font-family: "bootstrap-icons" !important;
            }

            /* Inertia Running Loader Bar - Completely Hidden */
            #nprogress,
            #nprogress .bar,
            #nprogress .peg,
            #nprogress .spinner {
                display: none !important;
                opacity: 0 !important;
                visibility: hidden !important;
                height: 0 !important;
                max-height: 0 !important;
                pointer-events: none !important;
            }
        </style>

        <!-- Font Awesome Fallback for custom legacy icons -->
        <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/all.min.css') }}">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @inertiaHead
    </head>
    <body class="h-full font-sans antialiased bg-slate-50 text-slate-800 selection:bg-emerald-600 selection:text-white">
        @inertia
    </body>
</html>
