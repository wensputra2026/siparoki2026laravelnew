@php
    $currentRoute = request()->path();
    $catQuery = request()->query('category') ?? request()->query('kategori') ?? '';
    $isSemua = (request()->is('warta') || request()->is('warta-paroki')) && empty($catQuery);
    $isBerita = request()->is('berita*') || strtolower($catQuery) === 'berita' || strtolower($catQuery) === 'berita paroki';
    $isArtikel = request()->is('artikel*') || strtolower($catQuery) === 'artikel' || strtolower($catQuery) === 'artikel rohani' || strtolower($catQuery) === 'katekese';
    $isPengumuman = request()->is('pengumuman*') || strtolower($catQuery) === 'pengumuman' || strtolower($catQuery) === 'pengumuman paroki';
    $isRenungan = request()->is('renungan*') || strtolower($catQuery) === 'renungan' || strtolower($catQuery) === 'renungan harian';
@endphp

<div class="warta-filter-container" style="background: #ffffff; border-radius: 20px; padding: 14px 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); margin-bottom: 32px; border: 1px solid #e2e8f0; border-top: 4px solid var(--primary-teal, #00897b);">
    <div class="d-flex align-items-center gap-2 overflow-x-auto pb-1 pb-md-0 flex-nowrap flex-md-wrap" style="-webkit-overflow-scrolling: touch;">
        
        <!-- Semua Warta -->
        <a href="/warta" style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 18px; border-radius: 25px; font-size: 0.84rem; font-weight: 700; text-decoration: none; transition: all 0.2s; flex-shrink: 0; white-space: nowrap; {{ $isSemua ? 'background: var(--primary-teal, #00897b); color: #ffffff; box-shadow: 0 4px 12px rgba(0,137,123,0.3);' : 'background: #f1f5f9; color: #334155;' }}">
            <i class="fa-solid fa-border-all"></i> Semua Warta
        </a>

        <!-- Berita Paroki -->
        <a href="/berita" style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 18px; border-radius: 25px; font-size: 0.84rem; font-weight: 700; text-decoration: none; transition: all 0.2s; flex-shrink: 0; white-space: nowrap; {{ $isBerita ? 'background: var(--primary-teal, #00897b); color: #ffffff; box-shadow: 0 4px 12px rgba(0,137,123,0.3);' : 'background: #f1f5f9; color: #334155;' }}">
            <i class="fa-regular fa-newspaper"></i> Berita Paroki
        </a>

        <!-- Artikel & Opini -->
        <a href="/artikel" style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 18px; border-radius: 25px; font-size: 0.84rem; font-weight: 700; text-decoration: none; transition: all 0.2s; flex-shrink: 0; white-space: nowrap; {{ $isArtikel ? 'background: var(--primary-teal, #00897b); color: #ffffff; box-shadow: 0 4px 12px rgba(0,137,123,0.3);' : 'background: #f1f5f9; color: #334155;' }}">
            <i class="fa-solid fa-book-open"></i> Artikel &amp; Opini
        </a>

        <!-- Pengumuman -->
        <a href="/pengumuman" style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 18px; border-radius: 25px; font-size: 0.84rem; font-weight: 700; text-decoration: none; transition: all 0.2s; flex-shrink: 0; white-space: nowrap; {{ $isPengumuman ? 'background: var(--primary-teal, #00897b); color: #ffffff; box-shadow: 0 4px 12px rgba(0,137,123,0.3);' : 'background: #f1f5f9; color: #334155;' }}">
            <i class="fa-solid fa-bullhorn"></i> Pengumuman
        </a>

        <!-- Renungan -->
        <a href="/renungan" style="display: inline-flex; align-items: center; gap: 6px; padding: 8px 18px; border-radius: 25px; font-size: 0.84rem; font-weight: 700; text-decoration: none; transition: all 0.2s; flex-shrink: 0; white-space: nowrap; {{ $isRenungan ? 'background: var(--primary-teal, #00897b); color: #ffffff; box-shadow: 0 4px 12px rgba(0,137,123,0.3);' : 'background: #f1f5f9; color: #334155;' }}">
            <i class="fa-solid fa-hands-praying"></i> Renungan
        </a>

        <!-- Dropdown Kategori Lengkap Lainnya -->
        @if(!empty($categories) && count($categories) > 0)
            @php
                $otherCats = collect($categories)->filter(function($k) {
                    $n = strtolower(is_object($k) ? ($k->kategori ?? $k->nama_kategori ?? '') : (string)$k);
                    return !in_array($n, ['berita', 'berita paroki', 'artikel', 'artikel rohani', 'pengumuman', 'pengumuman paroki', 'renungan', 'renungan harian'], true);
                });
            @endphp
            @if($otherCats->isNotEmpty())
                <div class="dropdown d-inline-block flex-shrink-0">
                    <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="background: #e6f4f1; color: var(--primary-teal, #00897b); border: 1.5px solid rgba(0,137,123,0.25); border-radius: 25px; font-size: 0.84rem; font-weight: 700; padding: 7px 16px; white-space: nowrap;">
                        <i class="fa-solid fa-tags me-1"></i> Kategori Lainnya ({{ $otherCats->count() }})
                    </button>
                    <ul class="dropdown-menu shadow-lg border-0" style="max-height: 380px; overflow-y: auto; min-width: 270px; border-radius: 14px; padding: 8px;">
                        <li class="dropdown-header text-uppercase text-xs fw-bold text-muted">Daftar Kategori Paroki</li>
                        @foreach($otherCats as $cat)
                            @php
                                $catName = is_object($cat) ? ($cat->kategori ?? $cat->nama_kategori ?? '') : (string)$cat;
                                $catTotal = is_object($cat) ? ($cat->total ?? 0) : 0;
                                $catPretty = ucwords(strtolower(trim($catName)));
                                $catSlug = is_object($cat) ? ($cat->slug ?? Str::slug($catName)) : Str::slug($catName);
                                $isCatActive = (string)$catQuery === (string)$catName || (string)$catQuery === (string)$catSlug;
                            @endphp
                            @if(!empty($catName))
                                <li>
                                    <a class="dropdown-item d-flex justify-content-between align-items-center py-2 px-3 {{ $isCatActive ? 'active fw-bold' : '' }}" href="/warta?category={{ urlencode($catName) }}" style="border-radius: 8px; font-size: 0.86rem;">
                                        <span>{{ $catPretty }}</span>
                                        @if($catTotal > 0)
                                            <span class="badge rounded-pill" style="background: rgba(0,137,123,0.12); color: var(--primary-teal, #00897b); font-size: 0.72rem;">{{ $catTotal }}</span>
                                        @endif
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            @endif
        @endif

    </div>
</div>
