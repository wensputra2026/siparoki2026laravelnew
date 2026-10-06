<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50 text-slate-800">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'SIPAROKI') }}</title>

        <!-- Dynamic Favicon -->
        @if(!empty($globalLogo))
            <link rel="icon" type="image/webp" href="{{ $globalLogo }}">
            <link rel="shortcut icon" href="{{ $globalLogo }}">
        @endif

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

            /* Inertia Top Running Progress Bar (No Spinner) */
            #nprogress {
                pointer-events: none;
            }
            #nprogress .bar {
                background: linear-gradient(90deg, #10b981, #059669, #047857) !important;
                position: fixed;
                z-index: 99999;
                top: 0;
                left: 0;
                width: 100%;
                height: 3px !important;
                box-shadow: 0 0 10px #10b981, 0 0 5px #059669;
            }
            #nprogress .peg {
                display: block;
                position: absolute;
                right: 0px;
                width: 100px;
                height: 100%;
                box-shadow: 0 0 12px #10b981, 0 0 6px #10b981;
                opacity: 1.0;
                transform: rotate(3deg) translate(0px, -4px);
            }
            #nprogress .spinner {
                display: none !important;
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
