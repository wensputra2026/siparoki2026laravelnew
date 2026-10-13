<!DOCTYPE html>
<html lang="id" data-theme="light" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0" />

    @php
        $metaTitle = html_entity_decode(strip_tags(trim($__env->yieldContent('title', ($globalNamaParoki ?? 'Paroki') . ' - Sistem Informasi Paroki'))), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $metaDescription = html_entity_decode(strip_tags(trim($__env->yieldContent('description', 'Website resmi ' . ($globalNamaParoki ?? 'Paroki') . ' untuk informasi jadwal perayaan Ekaristi, sakramen, warta paroki, dan sensus umat Katolik.'))), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $metaKeywords = html_entity_decode(strip_tags(trim($__env->yieldContent('keywords', 'paroki, gereja katolik, jadwal misa, warta paroki, keuskupan'))), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $metaType = trim($__env->yieldContent('og_type', 'website'));
        $metaImage = trim($__env->yieldContent('image', $globalLogo ?? ''));
        $metaImageUrl = null;
        $metaImageMime = 'image/jpeg';

        if (!empty($metaImage)) {
            // Prioritaskan file JPG pendamping jika ada (agar kompatibel maksimal dengan bot WhatsApp / Facebook)
            $parsedPath = parse_url($metaImage, PHP_URL_PATH);
            $cleanRelative = ltrim($parsedPath ?? '', '/');
            if (\Illuminate\Support\Str::endsWith($cleanRelative, '.webp')) {
                $jpgCandidate = substr($cleanRelative, 0, -5) . '.jpg';
                if (file_exists(public_path($jpgCandidate))) {
                    $metaImageUrl = asset($jpgCandidate);
                    $metaImageMime = 'image/jpeg';
                }
            }
            if (!$metaImageUrl) {
                $metaImageUrl = \Illuminate\Support\Str::startsWith($metaImage, ['http://', 'https://']) ? $metaImage : url($metaImage);
                if (\Illuminate\Support\Str::endsWith($metaImageUrl, '.webp')) {
                    $metaImageMime = 'image/webp';
                } elseif (\Illuminate\Support\Str::endsWith($metaImageUrl, '.png')) {
                    $metaImageMime = 'image/png';
                } else {
                    $metaImageMime = 'image/jpeg';
                }
            }

            // Pastikan URL gambar memakai HTTPS jika website diakses via HTTPS / Cloudflare / Reverse Proxy
            if ($metaImageUrl && (request()->isSecure() || request()->header('x-forwarded-proto') === 'https' || \Illuminate\Support\Str::startsWith(config('app.url'), 'https://'))) {
                $metaImageUrl = preg_replace('/^http:\/\//i', 'https://', $metaImageUrl);
            }
        }
    @endphp
    <title>{{ $metaTitle }}</title>
    <meta name="title" content="{{ $metaTitle }}">
    <meta name="description" content="{{ $metaDescription }}">
    <meta name="keywords" content="{{ $metaKeywords }}">
    <meta name="robots" content="index, follow">
    <meta name="language" content="id">
    <meta name="author" content="{{ $globalNamaParoki ?? 'Paroki' }}">
    <meta name="theme-color" content="#0c4a6e">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta property="og:type" content="{{ $metaType }}">
    <meta property="og:title" content="{{ $metaTitle }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="{{ $globalNamaParoki ?? 'Sistem Informasi Paroki' }}">
    <meta property="og:locale" content="id_ID">
    @if($metaImageUrl)
        <meta property="og:image" content="{{ $metaImageUrl }}">
        <meta property="og:image:secure_url" content="{{ $metaImageUrl }}">
        <meta property="og:image:type" content="{{ $metaImageMime }}">
        <meta property="og:image:alt" content="{{ $metaTitle }}">
        <meta property="og:image:width" content="1200">
        <meta property="og:image:height" content="630">
    @endif
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $metaTitle }}">
    <meta name="twitter:description" content="{{ $metaDescription }}">
    @if($metaImageUrl)
        <meta name="twitter:image" content="{{ $metaImageUrl }}">
    @endif
    @yield('article_meta')
    @stack('head')
    @stack('styles')

    <!-- Favicon -->
    @php
        $cacheBuster = \Illuminate\Support\Facades\Cache::get('global_view_data_version', 1);
    @endphp
    @if(!empty($globalLogo))
        <link rel="icon" type="image/png" href="{{ $globalLogo }}?v={{ $cacheBuster }}">
        <link rel="shortcut icon" type="image/png" href="{{ $globalLogo }}?v={{ $cacheBuster }}">
        <link rel="apple-touch-icon" href="{{ $globalLogo }}?v={{ $cacheBuster }}">
    @else
        <link rel="icon" type="image/png" href="{{ asset('images/church-logo.png') }}?v={{ $cacheBuster }}">
        <link rel="shortcut icon" type="image/png" href="{{ asset('images/church-logo.png') }}?v={{ $cacheBuster }}">
        <link rel="apple-touch-icon" href="{{ asset('images/church-logo.png') }}?v={{ $cacheBuster }}">
    @endif

    <!-- SIPAROKI Theme: Bootstrap 5.3 + Icons + Fonts + Unified Theme CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/siparoki-theme.css') }}?v={{ @filemtime(public_path('assets/css/siparoki-theme.css')) ?: time() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lightbox2@2.11.4/dist/css/lightbox.min.css">

    <!-- Local Vendor Icons -->
    <link rel="stylesheet" href="/vendor/fontawesome/css/all.min.css">
    @if(request()->is('/') || request()->is('kontak*') || request()->is('peta-kapela*'))
        <link rel="stylesheet" href="/vendor/leaflet/leaflet.css" />
    @endif
    @php
        $rawBanner = $globalBanner 
            ?? $globalProfil->banner 
            ?? $globalProfil->foto_gedung 
            ?? $globalProfil->foto_banner 
            ?? $globalProfil->foto 
            ?? $globalPengaturan->banner 
            ?? $globalPengaturan->banner_header 
            ?? null;

        $resolvedHeaderBg = null;
        if (!empty($rawBanner)) {
            if (str_starts_with($rawBanner, 'http://') || str_starts_with($rawBanner, 'https://')) {
                $resolvedHeaderBg = $rawBanner;
            } elseif (file_exists(public_path($rawBanner))) {
                $resolvedHeaderBg = asset($rawBanner);
            } elseif (file_exists(public_path('assets/' . $rawBanner))) {
                $resolvedHeaderBg = asset('assets/' . $rawBanner);
            } elseif (file_exists(public_path('assets/uploads/profil/' . $rawBanner))) {
                $resolvedHeaderBg = asset('assets/uploads/profil/' . $rawBanner);
            } elseif (file_exists(public_path('uploads/profil/' . $rawBanner))) {
                $resolvedHeaderBg = asset('uploads/profil/' . $rawBanner);
            } elseif (file_exists(public_path('uploads/' . $rawBanner))) {
                $resolvedHeaderBg = asset('uploads/' . $rawBanner);
            } else {
                $resolvedHeaderBg = asset($rawBanner);
            }
        }
        if (empty($resolvedHeaderBg)) {
            if (file_exists(public_path('uploads/profil/banner_1786529079.JPG'))) {
                $resolvedHeaderBg = asset('uploads/profil/banner_1786529079.JPG');
            } elseif (file_exists(public_path('assets/uploads/profil/banner_1786529079.JPG'))) {
                $resolvedHeaderBg = asset('assets/uploads/profil/banner_1786529079.JPG');
            } else {
                $resolvedHeaderBg = asset('assets/uploads/profil/banner_1786529079.JPG');
            }
        }
        $headerBgVersion = time();
        if (!empty($resolvedHeaderBg)) {
            $cleanRel = ltrim(parse_url($resolvedHeaderBg, PHP_URL_PATH) ?? '', '/');
            if (!empty($cleanRel) && file_exists(public_path($cleanRel))) {
                $headerBgVersion = @filemtime(public_path($cleanRel)) ?: time();
            }
        }
    @endphp
    <style>
        .page-header {
            @if(!empty($resolvedHeaderBg))
            background: linear-gradient(135deg, rgba(7, 31, 51, 0.92) 0%, rgba(0, 77, 64, 0.88) 50%, rgba(5, 23, 38, 0.95) 100%), url('{{ $resolvedHeaderBg }}?v={{ $headerBgVersion }}') center/cover no-repeat !important;
            @else
            background: linear-gradient(135deg, #07273b 0%, #004d40 50%, #041624 100%) !important;
            @endif
            padding: clamp(48px, 7vw, 76px) 16px clamp(36px, 5vw, 54px) !important;
            color: #ffffff !important;
            text-align: center !important;
            position: relative !important;
            border-bottom: 3px solid var(--primary-orange, #f59e0b) !important;
        }
        .page-header h1 {
            color: #ffffff !important;
            font-size: clamp(1.65rem, 4vw, 2.5rem) !important;
            font-weight: 800 !important;
            letter-spacing: -0.025em !important;
            margin-bottom: 12px !important;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.6) !important;
            line-height: 1.25 !important;
        }
        .page-header p {
            color: #f1f5f9 !important;
            font-size: clamp(0.88rem, 1.8vw, 1.02rem) !important;
            font-weight: 400 !important;
            line-height: 1.65 !important;
            max-width: 720px !important;
            margin: 0 auto 16px !important;
            opacity: 0.95 !important;
            text-shadow: 0 1px 6px rgba(0, 0, 0, 0.5) !important;
        }
    </style>
    @stack('styles')
    @if(request()->is('sakramen*'))
        @livewireStyles
    @endif
</head>
<body class="public-portal">

        <!-- Navbar -->
        <nav class="navbar navbar-expand-xl sticky-top">
            <div class="container">
                <a class="navbar-brand d-inline-flex align-items-center gap-2" href="/" style="text-decoration: none;">
                    @if(!empty($globalLogo))
                        <img src="{{ $globalLogo }}?v={{ $cacheBuster }}" alt="Logo {{ $globalNamaParoki ?? 'Paroki' }}" style="width: 40px; height: 40px; object-fit: contain; border-radius: 50%; background: #fff; padding: 2px; box-shadow: 0 2px 6px rgba(0,0,0,0.12); border: 1.5px solid rgba(0,137,123,0.2); flex-shrink: 0; display: inline-block;">
                    @else
                        <i class="bi bi-church" style="font-size: 1.8rem; color: var(--primary-teal, #00897b); flex-shrink: 0;"></i>
                    @endif
                    <span style="font-weight: 800; font-size: clamp(0.82rem, 2.5vw, 1.15rem); color: var(--primary-orange, #ff9800); white-space: nowrap; line-height: 1; letter-spacing: -0.02em;">{{ $globalNamaParoki ?? 'SIPAROKI' }}</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigasi">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">Beranda</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ request()->is('profil*') || request()->is('pelayan-pastoral*') || request()->is('sejarah*') || request()->is('visi-misi*') || request()->is('riwayat-pastor*') || request()->is('kronik*') || request()->is('struktur*') || request()->is('profil-kapela*') || request()->is('peta-kapela*') || request()->is('direktori*') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown">
                                Profil
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="/profil">Profil Umum</a></li>
                                <li><a class="dropdown-item" href="/pelayan-pastoral">Pelayan Pastoral</a></li>
                                <li><a class="dropdown-item" href="/sejarah">Sejarah Paroki</a></li>
                                <li><a class="dropdown-item" href="/visi-misi">Visi &amp; Misi</a></li>
                                <li><a class="dropdown-item" href="/riwayat-pastor">Riwayat Pastor</a></li>
                                <li><a class="dropdown-item" href="/kronik">Kronik Paroki</a></li>
                                <li><a class="dropdown-item" href="/struktur">Dewan Pastoral</a></li>
                                <li><a class="dropdown-item" href="/profil-kapela">Profil Kapela</a></li>
                                <li><a class="dropdown-item" href="/direktori-dpp">Anggota DPP</a></li>
                                <li><a class="dropdown-item" href="/direktori-katekis">Katekis</a></li>
                                <li><a class="dropdown-item" href="/direktori-misdinar">Misdinar</a></li>
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ request()->is('jadwal-misa*') || request()->is('agenda*') || request()->is('kegiatan*') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown">
                                Jadwal
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="/jadwal-misa">Jadwal Misa</a></li>
                                <li><a class="dropdown-item" href="/agenda">Agenda Kegiatan</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('warta*') || request()->is('berita*') || request()->is('artikel*') || request()->is('pengumuman*') || request()->is('renungan*') || request()->is('kategori*') ? 'active' : '' }}" href="/warta">
                                Warta Paroki
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ request()->is('galeri*') || request()->is('video*') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown">
                                Galeri
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="/galeri">Galeri Foto</a></li>
                                <li><a class="dropdown-item" href="/video">Video</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('statistik*') ? 'active' : '' }}" href="/statistik">Statistik</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('cek-data-umat*') || request()->is('cek-nik*') ? 'active' : '' }}" href="/cek-data-umat">Cek Data Umat</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('kontak*') ? 'active' : '' }}" href="/kontak">Kontak</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('downloads*') ? 'active' : '' }}" href="/downloads">Download</a>
                        </li>
                    </ul>

                    @auth
                        <div class="dropdown ms-3">
                            @php
                                $currentUser = auth()->user();
                                $slugClean = strtolower(preg_replace('/[^a-z0-9]/', '', $currentUser?->role?->slug ?? $currentUser?->role?->nama_role ?? ''));
                                
                                $dashboardUrl = '/superadmin';
                                $roleLabel = 'Dashboard';
                                
                                if (str_contains($slugClean, 'wilayah')) {
                                    $dashboardUrl = '/wilayah';
                                    $roleLabel = 'Dashboard Wilayah';
                                } elseif (str_contains($slugClean, 'kapela') || str_contains($slugClean, 'stasi')) {
                                    $dashboardUrl = '/kapela';
                                    $roleLabel = 'Dashboard Stasi / Kapela';
                                } elseif (str_contains($slugClean, 'kub')) {
                                    $dashboardUrl = '/kub';
                                    $roleLabel = 'Dashboard KUB';
                                } elseif (str_contains($slugClean, 'pastor')) {
                                    $dashboardUrl = '/pastor';
                                    $roleLabel = 'Dashboard Pastor';
                                } elseif (str_contains($slugClean, 'bendahara')) {
                                    $dashboardUrl = '/bendahara';
                                    $roleLabel = 'Dashboard Keuangan';
                                } elseif (str_contains($slugClean, 'penulis') || str_contains($slugClean, 'komsos')) {
                                    $dashboardUrl = '/penulis';
                                    $roleLabel = 'Dashboard Penulis';
                                } elseif (str_contains($slugClean, 'umat')) {
                                    $dashboardUrl = '/umat';
                                    $roleLabel = 'Dashboard Umat';
                                } elseif (str_contains($slugClean, 'paroki') || str_contains($slugClean, 'sekretariat')) {
                                    $dashboardUrl = '/paroki';
                                    $roleLabel = 'Dashboard Sekretariat';
                                } elseif (str_contains($slugClean, 'super')) {
                                    $dashboardUrl = '/superadmin';
                                    $roleLabel = 'Dashboard Super Admin';
                                }
                            @endphp
                            <button class="btn btn-apply dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-th-large me-1"></i> {{ $currentUser->nama_lengkap ?? $currentUser->username ?? 'User' }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                <li>
                                    <a class="dropdown-item fw-semibold" href="{{ $dashboardUrl }}">
                                        <i class="fas fa-gauge-high me-2 text-primary"></i> {{ $roleLabel }}
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ $dashboardUrl }}/profil-saya">
                                        <i class="fas fa-user-circle me-2 text-muted"></i> Profil Saya
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="/logout" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt me-2"></i> Keluar (Logout)
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="/login" class="btn-apply ms-3">
                            <i class="fas fa-sign-in-alt me-1"></i> Login
                        </a>
                    @endauth
                </div>
            </div>
        </nav>

    {{-- MAIN CONTENT --}}
    <main>
        @yield('content')
    </main>

    {{-- FOOTER KONOHA STYLE --}}
    <footer class="footer" role="contentinfo">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <h5>{{ $globalNamaParoki ?? 'St. Vinsensius a Paulo - Benlutu' }}</h5>
                    <p style="color: rgba(255, 255, 255, 0.7); font-size: 0.9rem; line-height: 1.6; margin-bottom: 20px;">
                        Benlutu, Kec. Batu Putih, Kab. Timor Tengah Selatan, Prov. Nusa Tenggara Timur - Media informasi, pelayanan sakramen, dan pendataan umat paroki.
                    </p>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                        <a href="#"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6 mb-4">
                    <h5>Menu</h5>
                    <ul>
                        <li><a href="/">Beranda</a></li>
                        <li><a href="/profil">Tentang</a></li>
                        <li><a href="/warta">Warta Paroki</a></li>
                        <li><a href="/jadwal-misa">Jadwal Misa</a></li>
                        <li><a href="/kontak">Kontak</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <h5>Pelayanan</h5>
                    <ul>
                        <li><a href="/cek-data-umat">Cek Data Umat</a></li>
                        <li><a href="/pelayanan">Daftar Pelayanan</a></li>
                        <li><a href="/profil-kapela">Kapela &amp; Stasi</a></li>
                        <li><a href="/downloads">Pusat Unduhan</a></li>
                        <li><a href="/statistik">Statistik Paroki</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <h5>Informasi</h5>
                    <ul>
                        <li><a href="/sejarah">Sejarah Paroki</a></li>
                        <li><a href="/visi-misi">Visi &amp; Misi</a></li>
                        <li><a href="/struktur">Struktur Organisasi</a></li>
                        <li><a href="/riwayat-pastor">Riwayat Pastor</a></li>
                        <li><a href="/pengumuman">Warta Pengumuman</a></li>
                    </ul>
                </div>
            </div>


            <!-- Footer Bottom -->
            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} {{ $globalNamaParoki ?? 'St. Vinsensius a Paulo - Benlutu' }}. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="/env.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lightbox2@2.11.4/dist/js/lightbox.min.js"></script>
    @if(request()->is('/') || request()->is('kontak*') || request()->is('peta-kapela*'))
        <script src="/vendor/leaflet/leaflet.js"></script>
    @endif
    <script src="/js/siparoki-public.js?v={{ @filemtime(public_path('js/siparoki-public.js')) ?: time() }}" defer></script>

    <!-- Back to Top Floating Button -->
    <button id="backToTop" class="back-to-top" aria-label="Kembali ke atas halaman" title="Kembali ke atas">
        <i class="fas fa-chevron-up"></i>
    </button>

    @stack('modals')
    @stack('scripts')
    @if(request()->is('sakramen*'))
        @livewireScripts
    @endif
</body>
</html>
