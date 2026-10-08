@extends('layouts.app')

@section('title', 'Artikel & Warta - ' . ($globalNamaParoki ?? 'SIPAROKI'))

@section('content')
<!-- Page Header / Breadcrumb Konoha Style -->
<section class="page-header">
    <div class="container">
        <span class="st-badge"><i class="fas fa-book-open me-1"></i> Artikel & Warta</span>
        <h1>Artikel & Katekese</h1>
        <p>Kumpulan artikel rohani, refleksi iman, katekese, dan pandangan pastoral umat {{ $globalNamaParoki ?? 'Paroki' }}.</p>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="/">Beranda</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="/warta">Warta Paroki</a>
                </li>
                <li class="breadcrumb-item active">
                    Artikel
                </li>
            </ol>
        </nav>
    </div>
</section>

<!-- News/Article Section Konoha Style -->
<section class="news-section py-5" style="background: #f4faf9; min-height: 60vh;">
    <div class="container">
        
        <!-- Unified Category Filter Bar -->
        @include('partials.warta-filter-tabs')
        
        <div class="row g-4">
            @forelse($artikel ?? [] as $item)
                @php
                    $img = $item->gambar ?? null;
                    $imgUrl = null;
                    if ($img) {
                        $base = basename(ltrim($img, '/'));
                        if (file_exists(public_path('uploads/konten/' . $base))) {
                            $imgUrl = asset('uploads/konten/' . $base);
                        } elseif (file_exists(public_path('assets/uploads/konten/' . $base))) {
                            $imgUrl = asset('assets/uploads/konten/' . $base);
                        } elseif (str_starts_with($img, 'http')) {
                            $imgUrl = $img;
                        } else {
                            $imgUrl = asset('uploads/konten/' . $base);
                        }
                    }
                    $date = $item->tanggal_publish ?? $item->created_at ?? now();
                @endphp
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="news-card card h-100 border-0 shadow-sm" style="border-radius: 18px; overflow: hidden; background: #ffffff;">
                        <a href="/artikel/{{ $item->slug }}" style="position: relative; overflow: hidden; height: 210px; background: #e2e8f0; display: block; text-decoration: none;">
                            @if($imgUrl)
                                <img src="{{ $imgUrl }}" alt="{{ $item->judul }}" class="news-img" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s;">
                            @else
                                <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: #94a3b8; background: #f1f5f9;">
                                    <i class="fas fa-book-open" style="font-size: 2.5rem;"></i>
                                </div>
                            @endif
                            <span class="news-category category-news" style="position: absolute; top: 15px; left: 15px; background: #0284c7; color: white; padding: 4px 14px; border-radius: 20px; font-size: 0.72rem; font-weight: 700; text-transform: uppercase; z-index: 2;">
                                {{ $item->kategori ?? 'ARTIKEL' }}
                            </span>
                        </a>
                        <div class="card-body p-4 d-flex flex-column">
                            <span class="news-date mb-2" style="display: inline-flex; align-items: center; gap: 6px; color: var(--primary-orange, #ff9800); font-size: 0.8rem; font-weight: 600;">
                                <i class="far fa-calendar-alt"></i> {{ format_tanggal_indonesia($date) }}
                            </span>
                            <h4 class="card-title fw-bold mb-2" style="font-size: 1.1rem; line-height: 1.45; color: #1e293b;">
                                <a href="/artikel/{{ $item->slug }}" style="color: inherit; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='var(--primary-teal, #00897b)'" onmouseout="this.style.color='#1e293b'">
                                    {{ $item->judul }}
                                </a>
                            </h4>
                            <p class="card-text text-muted mb-4 flex-grow-1" style="font-size: 0.88rem; line-height: 1.6; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                                {{ $item->ringkasan ?? $item->excerpt ?? Str::limit(strip_tags($item->konten ?? $item->isi ?? ''), 120) }}
                            </p>
                            <div class="mt-auto">
                                <a href="/artikel/{{ $item->slug }}" class="btn-news">
                                    Selengkapnya <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div style="background: #ffffff; border-radius: 18px; padding: 50px 20px; text-align: center; color: #94a3b8; box-shadow: 0 5px 20px rgba(0,0,0,0.06);">
                        <i class="far fa-folder-open fa-3x mb-3 text-secondary"></i>
                        <p style="font-size: 1rem; font-weight: 600;" class="mb-0">Belum ada artikel yang dipublikasikan.</p>
                    </div>
                </div>
            @endforelse
        </div>

        @if(isset($artikel) && method_exists($artikel, 'links'))
            <div class="mt-5 d-flex justify-content-center">
                {{ $artikel->links() }}
            </div>
        @endif

    </div>
</section>
@endsection


