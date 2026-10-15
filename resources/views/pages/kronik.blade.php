@extends('layouts.app')
@section('title', 'Kronik Paroki - ' . ($globalNamaParoki ?? 'St. Vinsensius a Paulo Benlutu'))

@section('content')
@php
    $defaultKronikImg = file_exists(public_path('uploads/profil/banner_1786529079.JPG')) 
        ? asset('uploads/profil/banner_1786529079.JPG') 
        : asset('images/church-logo.png');
@endphp

<!-- Page Header / Breadcrumb Konoha Style -->
<section class="page-header">
    <div class="container">
        <h1 style="font-size: 2.6rem; font-weight: 700; margin-bottom: 15px; color: #ffffff;">Kronik Paroki</h1>
        <p style="font-size: 1rem; color: rgba(255,255,255,0.88); margin-bottom: 18px; max-width: 680px; margin-left: auto; margin-right: auto; line-height: 1.6;">
            Catatan resmi perjalanan iman, tonggak peristiwa penting, dan dinamika historis {{ $globalNamaParoki ?? 'Paroki St. Vinsensius a Paulo Benlutu' }} dari masa ke masa.
        </p>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb" style="display: inline-flex; list-style: none; padding: 0; margin: 0 auto; gap: 8px; background: transparent; justify-content: center; align-items: center; flex-wrap: wrap;">
                <li class="breadcrumb-item" style="background: rgba(255,255,255,0.22); padding: 6px 18px; border-radius: 25px; font-size: 0.85rem;">
                    <a href="/" style="color: white; text-decoration: none; font-weight: 500;"><i class="fa-solid fa-house me-1" style="font-size: 0.75rem;"></i> Beranda</a>
                </li>
                <li class="breadcrumb-separator" style="color: rgba(255,255,255,0.75); font-size: 0.7rem; display: inline-flex; align-items: center;">
                    <i class="fa-solid fa-chevron-right"></i>
                </li>
                <li class="breadcrumb-item" style="background: rgba(255,255,255,0.22); padding: 6px 18px; border-radius: 25px; font-size: 0.85rem;">
                    <a href="/profil" style="color: white; text-decoration: none; font-weight: 500;">Profil</a>
                </li>
                <li class="breadcrumb-separator" style="color: rgba(255,255,255,0.75); font-size: 0.7rem; display: inline-flex; align-items: center;">
                    <i class="fa-solid fa-chevron-right"></i>
                </li>
                <li class="breadcrumb-item active" style="background: var(--primary-orange, #ff9800); color: white; padding: 6px 18px; border-radius: 25px; font-size: 0.85rem; font-weight: 700;">
                    Kronik Paroki
                </li>
            </ol>
        </nav>
    </div>
</section>

<!-- Content Section Konoha Style -->
<section class="content-section" style="padding: 60px 0 80px; background: #f4faf9;">
    <div class="container">
        
        <!-- Header Info Bar -->
        <div style="background: #ffffff; border-radius: 20px; padding: clamp(20px, 4vw, 32px) clamp(16px, 4vw, 36px); box-shadow: 0 5px 20px rgba(0,0,0,0.05); margin-bottom: 35px; border: 1px solid #e2e8f0;">
            <div style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 18px;">
                <div style="display: flex; align-items: center; gap: 16px;">
                    <div style="width: 52px; height: 52px; border-radius: 16px; background: rgba(0,137,123,0.1); color: var(--primary-teal, #00897b); display: flex; align-items: center; justify-content: center; font-size: 1.5rem; flex-shrink: 0;">
                        <i class="fa-solid fa-timeline"></i>
                    </div>
                    <div>
                        <span style="display: inline-block; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: var(--primary-orange, #ff9800); margin-bottom: 2px;">
                            <i class="fa-solid fa-book-bookmark me-1"></i> Kronik Perjalanan Iman
                        </span>
                        <h3 style="font-size: 1.35rem; font-weight: 800; color: #0f172a; margin: 0;">
                            Catatan Peristiwa & Perkembangan Paroki
                        </h3>
                    </div>
                </div>
                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                    <a href="/sejarah" style="display: inline-flex; align-items: center; gap: 6px; background: #f8fafc; border: 1px solid #cbd5e1; color: #334155; font-size: 0.82rem; font-weight: 600; padding: 7px 16px; border-radius: 20px; text-decoration: none; transition: all 0.2s;">
                        <i class="fa-solid fa-landmark text-amber-500"></i> Sejarah Paroki
                    </a>
                    <a href="/pelayan-pastoral" style="display: inline-flex; align-items: center; gap: 6px; background: #f8fafc; border: 1px solid #cbd5e1; color: #334155; font-size: 0.82rem; font-weight: 600; padding: 7px 16px; border-radius: 20px; text-decoration: none; transition: all 0.2s;">
                        <i class="fa-solid fa-users-rays text-teal-600"></i> Pelayan Pastoral
                    </a>
                    <a href="/riwayat-pastor" style="display: inline-flex; align-items: center; gap: 6px; background: #f8fafc; border: 1px solid #cbd5e1; color: #334155; font-size: 0.82rem; font-weight: 600; padding: 7px 16px; border-radius: 20px; text-decoration: none; transition: all 0.2s;">
                        <i class="fa-solid fa-clock-rotate-left text-amber-600"></i> Riwayat Pastor
                    </a>
                </div>
            </div>
        </div>

        <!-- Chronicle Timeline Stream -->
        <div class="kronik-timeline-stream" style="display: flex; flex-direction: column; gap: 24px;">
            @forelse($kronik ?? [] as $k)
                @php
                    $tgl = !empty($k->tanggal_peristiwa) ? \Carbon\Carbon::parse($k->tanggal_peristiwa) : null;
                    $foto = !empty($k->foto_utama) 
                        ? (str_starts_with($k->foto_utama, 'http') || str_starts_with($k->foto_utama, '/') ? $k->foto_utama : '/' . $k->foto_utama) 
                        : null;
                    $kategori = $k->kategori_kronik ?? 'Peristiwa';
                @endphp

                <div class="kronik-card-item" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 20px; padding: clamp(20px, 3vw, 28px); box-shadow: 0 4px 18px rgba(0,0,0,0.04); border-left: 5px solid var(--primary-teal, #00897b); transition: transform 0.2s, box-shadow 0.2s;">
                    <div class="row g-4 align-items-center">
                        
                        {{-- Image Column (if photo exists) --}}
                        @if($foto)
                            <div class="col-lg-3 col-md-4">
                                <div style="width: 100%; height: 180px; border-radius: 16px; overflow: hidden; background: #f1f5f9; border: 1px solid #e2e8f0; box-shadow: 0 3px 10px rgba(0,0,0,0.06);">
                                    <img 
                                        src="{{ $foto }}" 
                                        alt="{{ $k->judul_kronik }}" 
                                        style="width: 100%; height: 100%; object-fit: cover; display: block; transition: transform 0.3s;"
                                        onmouseover="this.style.transform='scale(1.05)';"
                                        onmouseout="this.style.transform='scale(1)';"
                                        onerror="this.onerror=null; this.src='{{ $defaultKronikImg }}';"
                                    >
                                </div>
                            </div>
                        @endif

                        {{-- Content Column --}}
                        <div class="{{ $foto ? 'col-lg-9 col-md-8' : 'col-12' }}">
                            
                            {{-- Top Meta Badges --}}
                            <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 10px; margin-bottom: 12px;">
                                @if($tgl)
                                    <span style="display: inline-flex; align-items: center; gap: 6px; background: rgba(0,137,123,0.12); color: var(--primary-teal, #00897b); font-size: 0.8rem; font-weight: 700; padding: 4px 14px; border-radius: 14px;">
                                        <i class="fa-regular fa-calendar-check text-xs"></i>
                                        <span>{{ function_exists('format_tanggal_indonesia') ? format_tanggal_indonesia($tgl) : $tgl->translatedFormat('d F Y') }}</span>
                                    </span>
                                @endif

                                <span style="display: inline-flex; align-items: center; gap: 5px; background: rgba(255,152,0,0.12); color: #d97706; font-size: 0.78rem; font-weight: 700; padding: 4px 12px; border-radius: 14px; text-transform: uppercase;">
                                    <i class="fa-solid fa-bookmark text-xs"></i>
                                    <span>{{ $kategori }}</span>
                                </span>

                                @if(!empty($k->lokasi_peristiwa))
                                    <span style="display: inline-flex; align-items: center; gap: 5px; color: #64748b; font-size: 0.82rem; font-weight: 600;">
                                        <i class="fa-solid fa-location-dot text-rose-500"></i>
                                        <span>{{ $k->lokasi_peristiwa }}</span>
                                    </span>
                                @endif
                            </div>

                            {{-- Title --}}
                            <h4 style="font-size: clamp(1.15rem, 2.5vw, 1.35rem); font-weight: 800; color: #0f172a; margin-bottom: 10px; line-height: 1.4;">
                                {{ $k->judul_kronik }}
                            </h4>

                            {{-- Summary / Narrative excerpt --}}
                            <p style="font-size: 0.94rem; color: #475569; line-height: 1.7; margin-bottom: 16px;">
                                {{ !empty($k->ringkasan) ? $k->ringkasan : Str::limit(strip_tags($k->isi_kronik ?? ''), 220) }}
                            </p>

                            {{-- Bottom Actions & Footer Meta --}}
                            <div style="display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 14px; border-top: 1px dashed #e2e8f0; padding-top: 14px;">
                                <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 15px; font-size: 0.78rem; color: #64748b;">
                                    @if(!empty($k->penulis))
                                        <span><i class="fa-solid fa-feather-pointed me-1 text-teal-600"></i> {{ $k->penulis }}</span>
                                    @endif
                                    @if(!empty($k->sumber_data))
                                        <span><i class="fa-solid fa-folder-open me-1 text-amber-500"></i> Sumber: {{ $k->sumber_data }}</span>
                                    @endif
                                </div>

                                <button 
                                    type="button" 
                                    onclick="openKronikDetailModal({{ json_encode($k) }})"
                                    style="display: inline-flex; align-items: center; gap: 7px; background: #f8fafc; border: 1px solid #cbd5e1; color: #1e293b; font-size: 0.82rem; font-weight: 700; padding: 8px 18px; border-radius: 12px; transition: all 0.2s; cursor: pointer;"
                                    onmouseover="this.style.background='var(--primary-teal, #00897b)'; this.style.color='#ffffff'; this.style.borderColor='var(--primary-teal, #00897b)';"
                                    onmouseout="this.style.background='#f8fafc'; this.style.color='#1e293b'; this.style.borderColor='#cbd5e1';"
                                >
                                    <i class="fa-solid fa-book-open-reader text-xs"></i>
                                    <span>Baca Kronik Lengkap</span>
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            @empty
                <div style="background: #ffffff; border-radius: 20px; padding: 60px 24px; text-align: center; color: #94a3b8; box-shadow: 0 5px 20px rgba(0,0,0,0.05); border: 1px solid #e2e8f0;">
                    <div style="width: 72px; height: 72px; margin: 0 auto 16px; border-radius: 50%; background: #f8fafc; display: flex; align-items: center; justify-content: center; font-size: 2rem; color: #cbd5e1;">
                        <i class="fa-solid fa-calendar-xmark"></i>
                    </div>
                    <h5 style="font-size: 1.15rem; font-weight: 700; color: #334155; margin-bottom: 6px;">Belum Ada Catatan Kronik</h5>
                    <p style="font-size: 0.92rem; color: #64748b; margin: 0 auto; max-width: 480px;">
                        Catatan kronik paroki sedang dalam proses inventarisasi dan digitalisasi oleh sekretariat pastoral paroki.
                    </p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if(isset($kronik) && method_exists($kronik, 'hasPages') && $kronik->hasPages())
            <div style="margin-top: 45px; display: flex; justify-content: center;">
                {{ $kronik->links() }}
            </div>
        @endif

        <!-- Share Buttons -->
        <div style="margin-top: 40px;">
            @include('partials.share-buttons', ['title' => 'Kronik Paroki - ' . ($globalNamaParoki ?? 'Paroki')])
        </div>

    </div>
</section>

<!-- Universal Kronik Detail Modal (Bootstrap 5 Standard) -->
<style>
#kronikDetailModal {
    z-index: 1060 !important;
}
#kronikDetailModal .modal-dialog {
    max-width: 720px;
    margin: 1.75rem auto;
}
@media (max-width: 768px) {
    #kronikDetailModal .modal-dialog {
        margin: 0.75rem auto;
        max-width: calc(100% - 1.5rem);
    }
}
#kronikDetailModal .modal-content {
    border: none;
    border-radius: 22px;
    overflow: hidden;
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.35);
    background: #ffffff;
}
</style>

<div class="modal fade" id="kronikDetailModal" tabindex="-1" aria-labelledby="kronikDetailModalLabel" aria-hidden="true" data-bs-backdrop="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            
            <!-- Modal Header -->
            <div class="modal-header border-0 text-white position-relative" style="background: linear-gradient(135deg, #0d9488 0%, #0f766e 60%, #042f2e 100%); padding: 24px 24px 18px;">
                <button type="button" class="btn-close btn-close-white position-absolute" data-bs-dismiss="modal" aria-label="Close" style="top: 18px; right: 18px; opacity: 0.9; cursor: pointer;"></button>

                <div class="w-100 pe-4">
                    <div class="d-flex align-items-center gap-2 flex-wrap mb-2">
                        <span id="modalKronikKategoriBadge" class="badge" style="background: var(--primary-orange, #ff9800); color: #ffffff; font-size: 0.72rem; font-weight: 700; text-transform: uppercase; padding: 4px 12px; border-radius: 14px;">
                            Peristiwa Bersejarah
                        </span>
                        <span id="modalKronikTanggalBadge" class="badge" style="background: rgba(255, 255, 255, 0.22); color: #ffffff; font-size: 0.72rem; font-weight: 700; padding: 4px 12px; border-radius: 14px;">
                            <i class="fa-regular fa-calendar-check me-1"></i> <span id="modalKronikTanggalText">-</span>
                        </span>
                    </div>
                    <h4 id="modalKronikJudul" class="modal-title mb-1 text-white" style="font-size: 1.25rem; font-weight: 800; line-height: 1.35;">
                        Judul Kronik
                    </h4>
                    <p id="modalKronikLokasi" class="mb-0 text-white-50" style="font-size: 0.84rem;">
                        <i class="fa-solid fa-location-dot me-1 text-rose-300"></i> <span id="modalKronikLokasiText">Gereja Paroki</span>
                    </p>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="modal-body p-4" style="background: #ffffff;">
                
                {{-- Modal Photo Container --}}
                <div id="modalKronikFotoWrap" class="mb-4" style="display: none;">
                    <div style="border-radius: 16px; overflow: hidden; max-height: 320px; box-shadow: 0 4px 14px rgba(0,0,0,0.08); border: 1px solid #e2e8f0;">
                        <img id="modalKronikFoto" src="" alt="Kronik" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                    </div>
                </div>

                {{-- Full Text Narrative --}}
                <div style="margin-bottom: 24px;">
                    <h6 style="font-size: 0.8rem; font-weight: 700; text-transform: uppercase; color: #64748b; letter-spacing: 0.5px; margin-bottom: 10px;">
                        <i class="fa-solid fa-scroll text-amber-500 me-1"></i> Catatan Historis &amp; Peristiwa
                    </h6>
                    <div id="modalKronikIsi" style="font-size: 0.96rem; line-height: 1.85; color: #334155; text-align: justify; white-space: pre-line;">
                        -
                    </div>
                </div>

                {{-- Metadata info box --}}
                <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 14px; padding: 14px 18px; display: flex; flex-wrap: wrap; justify-content: space-between; gap: 12px; font-size: 0.8rem; color: #64748b;">
                    <div>
                        <span style="font-weight: 700; color: #475569; display: block;">Dicatat Oleh:</span>
                        <span id="modalKronikPenulis">Sekretariat Paroki</span>
                    </div>
                    <div>
                        <span style="font-weight: 700; color: #475569; display: block;">Sumber Data:</span>
                        <span id="modalKronikSumber">Buku Kronik Paroki</span>
                    </div>
                </div>

            </div>

            <!-- Modal Footer -->
            <div class="modal-footer border-0 pt-0 px-4 pb-4" style="background: #ffffff; justify-content: space-between;">
                <span class="text-muted" style="font-size: 0.75rem;">
                    <i class="fa-solid fa-church me-1 text-teal-600"></i> {{ $globalNamaParoki ?? 'Paroki St. Vinsensius a Paulo Benlutu' }}
                </span>
                <button type="button" class="btn btn-secondary px-4 py-2" data-bs-dismiss="modal" style="border-radius: 12px; font-size: 0.85rem; font-weight: 600;">
                    Tutup
                </button>
            </div>

        </div>
    </div>
</div>

<script>
function openKronikDetailModal(data) {
    if (!data) return;

    // Judul
    document.getElementById('modalKronikJudul').textContent = data.judul_kronik || 'Catatan Kronik';
    
    // Kategori
    document.getElementById('modalKronikKategoriBadge').textContent = data.kategori_kronik || 'Peristiwa';
    
    // Tanggal
    const tgl = data.tanggal_peristiwa || '';
    if (tgl) {
        document.getElementById('modalKronikTanggalText').textContent = tgl;
        document.getElementById('modalKronikTanggalBadge').style.display = 'inline-block';
    } else {
        document.getElementById('modalKronikTanggalBadge').style.display = 'none';
    }

    // Lokasi
    const lokasi = data.lokasi_peristiwa || '';
    if (lokasi) {
        document.getElementById('modalKronikLokasiText').textContent = lokasi;
        document.getElementById('modalKronikLokasi').style.display = 'block';
    } else {
        document.getElementById('modalKronikLokasi').style.display = 'none';
    }

    // Foto
    const foto = data.foto_utama || '';
    const fotoWrap = document.getElementById('modalKronikFotoWrap');
    const fotoEl = document.getElementById('modalKronikFoto');
    if (foto) {
        const fotoUrl = (foto.startsWith('http') || foto.startsWith('/')) ? foto : ('/' + foto);
        fotoEl.src = fotoUrl;
        fotoWrap.style.display = 'block';
    } else {
        fotoWrap.style.display = 'none';
    }

    // Isi
    const isi = data.isi_kronik || data.ringkasan || 'Tidak ada uraian narasi tambahan.';
    document.getElementById('modalKronikIsi').innerHTML = isi.replace(/\n/g, '<br>');

    // Penulis & Sumber
    document.getElementById('modalKronikPenulis').textContent = data.penulis || 'Sekretariat Paroki';
    document.getElementById('modalKronikSumber').textContent = data.sumber_data || 'Buku Arsip Paroki';

    // Show modal
    const modalEl = document.getElementById('kronikDetailModal');
    if (window.bootstrap && window.bootstrap.Modal) {
        let modalInstance = window.bootstrap.Modal.getInstance(modalEl);
        if (!modalInstance) {
            modalInstance = new window.bootstrap.Modal(modalEl);
        }
        modalInstance.show();
    } else {
        // Fallback
        modalEl.classList.add('show');
        modalEl.style.display = 'block';
        document.body.classList.add('modal-open');
    }
}
</script>
@endsection
