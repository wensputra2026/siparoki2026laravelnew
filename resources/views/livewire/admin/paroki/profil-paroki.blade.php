<div class="w-full space-y-5">

    {{-- Flash Notifications --}}
    @if(session()->has('success'))
        <div class="rounded-xl border border-emerald-300 dark:border-emerald-700 bg-emerald-50 dark:bg-emerald-950/60 p-3.5 text-emerald-800 dark:text-emerald-200 text-xs flex items-center gap-3 font-semibold shadow-xs">
            <i class="fa-solid fa-circle-check text-emerald-600 dark:text-emerald-400 text-base shrink-0"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if(session()->has('error'))
        <div class="rounded-xl border border-rose-300 dark:border-rose-700 bg-rose-50 dark:bg-rose-950/60 p-3.5 text-rose-800 dark:text-rose-200 text-xs flex items-center gap-3 font-semibold shadow-xs">
            <i class="fa-solid fa-triangle-exclamation text-rose-600 dark:text-rose-400 text-base shrink-0"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    {{-- ═══════════════════════════════════════════════════════════════ --}}
    {{-- 6 STAT CARDS AT TOP (Exact match to katedrallaravel12)         --}}
    {{-- ═══════════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-6 gap-3.5">
        {{-- Wilayah --}}
        <div class="p-3.5 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-xs flex items-center gap-3 min-w-0 transition hover:shadow-sm">
            <div class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-base font-black shrink-0">
                <i class="bi bi-geo-alt"></i>
            </div>
            <div class="min-w-0">
                <span class="text-[10px] uppercase tracking-wider text-slate-400 font-bold block truncate">Wilayah</span>
                <span class="text-sm font-black text-slate-900 dark:text-white">{{ $totalWilayah }}</span>
            </div>
        </div>

        {{-- Lingkungan --}}
        <div class="p-3.5 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-xs flex items-center gap-3 min-w-0 transition hover:shadow-sm">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-base font-black shrink-0">
                <i class="bi bi-diagram-3"></i>
            </div>
            <div class="min-w-0">
                <span class="text-[10px] uppercase tracking-wider text-slate-400 font-bold block truncate">Lingkungan</span>
                <span class="text-sm font-black text-slate-900 dark:text-white">{{ $totalLingkungan }}</span>
            </div>
        </div>

        {{-- Kapela / Stasi --}}
        <div class="p-3.5 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-xs flex items-center gap-3 min-w-0 transition hover:shadow-sm">
            <div class="w-10 h-10 rounded-xl bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 flex items-center justify-center text-base font-black shrink-0">
                <i class="bi bi-bank2"></i>
            </div>
            <div class="min-w-0">
                <span class="text-[10px] uppercase tracking-wider text-slate-400 font-bold block truncate">Kapela / Stasi</span>
                <span class="text-sm font-black text-slate-900 dark:text-white">{{ $totalKapela }}</span>
            </div>
        </div>

        {{-- KUB --}}
        <div class="p-3.5 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-xs flex items-center gap-3 min-w-0 transition hover:shadow-sm">
            <div class="w-10 h-10 rounded-xl bg-purple-50 dark:bg-purple-950/60 text-purple-600 dark:text-purple-400 flex items-center justify-center text-base font-black shrink-0">
                <i class="bi bi-diagram-2"></i>
            </div>
            <div class="min-w-0">
                <span class="text-[10px] uppercase tracking-wider text-slate-400 font-bold block truncate">KUB</span>
                <span class="text-sm font-black text-slate-900 dark:text-white">{{ $totalKub }}</span>
            </div>
        </div>

        {{-- Total Umat --}}
        <div class="p-3.5 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-xs flex items-center gap-3 min-w-0 transition hover:shadow-sm">
            <div class="w-10 h-10 rounded-xl bg-cyan-50 dark:bg-cyan-950/60 text-cyan-600 dark:text-cyan-400 flex items-center justify-center text-base font-black shrink-0">
                <i class="bi bi-people"></i>
            </div>
            <div class="min-w-0">
                <span class="text-[10px] uppercase tracking-wider text-slate-400 font-bold block truncate">Total Umat</span>
                <span class="text-sm font-black text-slate-900 dark:text-white">{{ number_format($totalUmat, 0, ',', '.') }}</span>
            </div>
        </div>

        {{-- Kepala Keluarga --}}
        <div class="p-3.5 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-xs flex items-center gap-3 min-w-0 transition hover:shadow-sm">
            <div class="w-10 h-10 rounded-xl bg-rose-50 dark:bg-rose-950/60 text-rose-600 dark:text-rose-400 flex items-center justify-center text-base font-black shrink-0">
                <i class="bi bi-houses"></i>
            </div>
            <div class="min-w-0">
                <span class="text-[10px] uppercase tracking-wider text-slate-400 font-bold block truncate">Kepala Keluarga</span>
                <span class="text-sm font-black text-slate-900 dark:text-white">{{ number_format($totalKk, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════ --}}
    {{-- MAIN 2-COLUMN LAYOUT (Matching katedrallaravel12 8:4 ratio)     --}}
    {{-- ═══════════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 xl:grid-cols-12 gap-5 items-start">

        {{-- ── LEFT COLUMN: DETAIL PROFIL PAROKI (xl:col-span-8) ──────── --}}
        <div class="xl:col-span-8 space-y-4 min-w-0">
            
            {{-- Top Action Card --}}
            <div class="rounded-xl bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 p-4 sm:p-5 shadow-2xs space-y-4">
                <div class="flex flex-col gap-3 pb-4 border-b border-slate-100 dark:border-slate-800">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 min-w-0">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <span class="w-9 h-9 rounded-lg bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 flex items-center justify-center shrink-0">
                                <i class="fa-solid fa-house-chimney-window text-sm"></i>
                            </span>
                            <div class="min-w-0">
                                <h1 class="text-base font-black text-slate-900 dark:text-white tracking-tight">Detail Profil Paroki</h1>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400 truncate">Data utama, wilayah, kontak, pastor, dan lokasi</p>
                            </div>
                        </div>
                        @if($paroki)
                            <span class="w-fit max-w-full px-2.5 py-1 rounded-lg bg-blue-50 dark:bg-blue-950/60 border border-blue-200 dark:border-blue-800 text-blue-700 dark:text-blue-300 text-[11px] font-bold truncate">
                                {{ $paroki->nama_paroki }}
                            </span>
                        @endif
                    </div>

                    {{-- 4 Action Buttons matching katedrallaravel12 --}}
                    <div class="grid grid-cols-1 sm:grid-cols-4 gap-2">
                        <a
                            href="{{ url('/setup-paroki') }}"
                            class="inline-flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold transition shadow-2xs cursor-pointer"
                            title="Pilih atau inisialisasi ulang Keuskupan & Paroki Default"
                        >
                            <i class="fa-solid fa-sliders text-xs"></i>
                            <span class="truncate">Setup Default</span>
                        </a>
                        <button
                            type="button"
                            wire:click="openBannerModal"
                            class="inline-flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition shadow-2xs cursor-pointer"
                            title="Upload Banner Latar Belakang Header Website Publik"
                        >
                            <i class="fa-solid fa-panorama text-xs"></i>
                            <span class="truncate">Upload Banner</span>
                        </button>
                        <button
                            type="button"
                            wire:click="openImageModal"
                            class="inline-flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold transition shadow-2xs cursor-pointer"
                        >
                            <i class="fa-regular fa-image text-xs"></i>
                            <span class="truncate">Gambar & Sejarah</span>
                        </button>
                        <button
                            type="button"
                            wire:click="openEditModal"
                            class="inline-flex items-center justify-center gap-1.5 px-3 py-2 rounded-lg bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold transition shadow-2xs cursor-pointer"
                        >
                            <i class="fa-solid fa-pen-to-square text-xs"></i>
                            <span class="truncate">Edit Data Profil</span>
                        </button>
                    </div>
                </div>

                {{-- Read-Only Sync Notice (Cyan Box) --}}
                <div class="p-3 rounded-lg bg-cyan-50/80 dark:bg-cyan-950/40 border border-cyan-200/90 dark:border-cyan-800/60 flex items-start gap-2.5 text-xs text-cyan-950 dark:text-cyan-200">
                    <i class="fa-solid fa-rotate text-cyan-600 dark:text-cyan-400 text-xs mt-0.5 shrink-0"></i>
                    <div class="leading-relaxed text-[11.5px]">
                        <span class="font-bold text-cyan-900 dark:text-cyan-300">Sinkronisasi Otomatis Terintegrasi:</span>
                        Paroki yang dipilih di halaman ini otomatis menjadi <b>Paroki Default</b> aplikasi. Seluruh perubahan profil, logo, kontak, maupun penggantian paroki utama akan <b>langsung otomatis mengubah tampilan Frontend dan Backend</b> secara seketika.
                    </div>
                </div>

                {{-- Paroki Header Title & Badges --}}
                <div class="flex flex-col sm:flex-row sm:items-center gap-4 pt-1 min-w-0">
                    <div class="w-16 h-16 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/50 overflow-hidden flex items-center justify-center shrink-0 shadow-2xs">
                        @php
                            $logoImg = siparoki_asset($paroki?->logo ?? $profil?->logo);
                        @endphp
                        @if(!empty($paroki?->logo) || !empty($profil?->logo))
                            <img
                                src="{{ $logoImg }}"
                                alt="{{ $paroki?->nama_paroki ?? 'Paroki' }}"
                                class="w-full h-full object-cover"
                                onerror="this.onerror=null; this.src='/images/church-logo.png'"
                            />
                        @else
                            <i class="fa-solid fa-church text-2xl text-amber-500"></i>
                        @endif
                    </div>
                    <div class="min-w-0">
                        <h2 class="text-lg font-black text-slate-900 dark:text-white leading-snug">{{ $paroki?->nama_paroki ?? 'Paroki Belum Ditetapkan' }}</h2>
                        <div class="flex flex-wrap items-center gap-2 mt-1">
                            <span class="px-2 py-0.5 rounded-md bg-emerald-500 text-white text-[10px] font-bold">{{ $paroki?->status ?? 'Aktif' }}</span>
                            <span class="px-2 py-0.5 rounded-md bg-cyan-600 text-white text-[10px] font-bold">{{ $paroki?->status_paroki ?? 'Paroki' }}</span>
                            <span class="px-2 py-0.5 rounded-md bg-slate-800 text-white text-[10px] font-mono font-bold">Kode: {{ $paroki?->kode_paroki ?? '012.009' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 6 STRUCTURED TABLE SECTIONS (Exact match to katedrallaravel12) --}}
            <div class="rounded-xl bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800 overflow-hidden shadow-2xs divide-y divide-slate-100 dark:divide-slate-800">
                
                {{-- SECTION 1: IDENTITAS PAROKI --}}
                <div>
                    <div class="bg-slate-50/90 dark:bg-slate-800/80 px-4 py-2.5 border-b border-slate-200 dark:border-slate-800 flex items-center gap-2 text-xs font-black text-slate-800 dark:text-slate-200 uppercase">
                        <i class="fa-solid fa-bars-staggered text-amber-600"></i>
                        <span>IDENTITAS PAROKI</span>
                    </div>
                    <div class="divide-y divide-slate-100 dark:divide-slate-800 text-xs">
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-3 px-4 py-2.5 hover:bg-slate-50/50 dark:hover:bg-slate-800/40">
                            <span class="text-slate-500 dark:text-slate-400 font-semibold">Keuskupan Induk</span>
                            <span class="sm:col-span-2 font-bold text-slate-900 dark:text-white">{{ $paroki?->keuskupan?->nama_keuskupan ?? 'Keuskupan Agung Kupang' }}</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-3 px-4 py-2.5 hover:bg-slate-50/50 dark:hover:bg-slate-800/40">
                            <span class="text-slate-500 dark:text-slate-400 font-semibold">Dekenat / Kevikepan</span>
                            <span class="sm:col-span-2 font-bold text-slate-900 dark:text-white">{{ $paroki?->dekenat?->nama_dekenat ?? $paroki?->dekenat?->nama_kevikepan ?? 'Kevikepan/Dekenat Kota Kupang' }}</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-3 px-4 py-2.5 hover:bg-slate-50/50 dark:hover:bg-slate-800/40">
                            <span class="text-slate-500 dark:text-slate-400 font-semibold">Kode Paroki</span>
                            <span class="sm:col-span-2 font-mono font-bold text-rose-600">{{ $paroki?->kode_paroki ?? '012.009' }}</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-3 px-4 py-2.5 hover:bg-slate-50/50 dark:hover:bg-slate-800/40">
                            <span class="text-slate-500 dark:text-slate-400 font-semibold">Nama Paroki</span>
                            <span class="sm:col-span-2 font-bold text-slate-900 dark:text-white">{{ $paroki?->nama_paroki }}</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-3 px-4 py-2.5 hover:bg-slate-50/50 dark:hover:bg-slate-800/40">
                            <span class="text-slate-500 dark:text-slate-400 font-semibold">Nama Pelindung / Santo</span>
                            <span class="sm:col-span-2 font-bold text-slate-700 dark:text-slate-300">{{ $paroki?->pelindung_paroki ?? '-' }}</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-3 px-4 py-2.5 hover:bg-slate-50/50 dark:hover:bg-slate-800/40">
                            <span class="text-slate-500 dark:text-slate-400 font-semibold">Status</span>
                            <span class="sm:col-span-2">
                                <span class="px-2 py-0.5 rounded-full bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800 text-[10px] font-bold">
                                    {{ $paroki?->status ?? 'Aktif' }}
                                </span>
                        </div>
                    </div>
                </div>

                {{-- SECTION 2: PELAYAN PASTORAL --}}
                <div>
                    <div class="bg-slate-50/90 dark:bg-slate-800/80 px-4 py-2.5 border-b border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 text-xs font-black text-slate-800 dark:text-slate-200 uppercase">
                        <div class="flex items-center gap-2 min-w-0">
                            <i class="fa-solid fa-user-tie text-amber-600"></i>
                            <span class="truncate">PELAYAN PASTORAL</span>
                        </div>
                        <a
                            href="{{ url("/{$currentPrefix}/master-referensi/pastor") }}"
                            class="text-[11px] font-bold text-amber-700 dark:text-amber-400 hover:text-amber-900 dark:hover:text-amber-300 flex items-center gap-1.5 normal-case shrink-0"
                        >
                            <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                            <span>Buka Master Pastor</span>
                        </a>
                    </div>
                    
                    {{-- If pastorsBertugas exists in database --}}
                    @if(!empty($pastorsBertugas))
                        <div class="divide-y divide-slate-100 dark:divide-slate-800 text-xs">
                            @foreach($pastorsBertugas as $p)
                                <div class="p-4 flex flex-col md:flex-row md:items-center justify-between gap-3 hover:bg-slate-50/70 dark:hover:bg-slate-800/40 transition">
                                    <div class="flex items-center gap-3.5 min-w-0">
                                        <div class="w-11 h-11 rounded-xl bg-amber-50 dark:bg-amber-950/60 border border-amber-200 dark:border-amber-800 overflow-hidden flex items-center justify-center shrink-0">
                                            @if(!empty($p['foto']))
                                                <img
                                                    src="{{ siparoki_asset($p['foto']) }}"
                                                    alt="{{ $p['nama_formatted'] ?? $p['nama_pastor'] }}"
                                                    class="w-full h-full object-cover"
                                                    onerror="this.onerror=null; this.src='/images/default-pastor.jpg'"
                                                />
                                            @else
                                                <i class="fa-solid fa-user-tie text-amber-600 text-lg"></i>
                                            @endif
                                        </div>
                                        <div class="min-w-0">
                                            <div class="flex items-center gap-2 flex-wrap">
                                                <h4 class="font-black text-slate-900 dark:text-white text-[13px]">{{ $p['nama_formatted'] ?? $p['nama_pastor'] }}</h4>
                                                @php
                                                    $isPastorParoki = !empty($p['jabatan']) && str_contains($p['jabatan'], 'Paroki') && !str_contains($p['jabatan'], 'Rekan');
                                                @endphp
                                                <span class="px-2 py-0.5 rounded-md text-[10px] font-bold {{ $isPastorParoki ? 'bg-amber-100 dark:bg-amber-950/80 text-amber-800 dark:text-amber-300 border border-amber-200 dark:border-amber-700' : 'bg-blue-100 dark:bg-blue-950/80 text-blue-800 dark:text-blue-300 border border-blue-200 dark:border-blue-700' }}">
                                                    {{ $p['jabatan'] ?: 'Pastor Rekan' }}
                                                </span>
                                                <span class="px-2 py-0.5 rounded-md bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800 text-[10px] font-bold">
                                                    {{ ($p['status'] == 1 || $p['status'] === '1' || $p['status'] === 'Aktif') ? 'Aktif' : 'Nonaktif' }}
                                                </span>
                                            </div>
                                            <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5 leading-relaxed">
                                                <span>Bertugas di: <b>{{ $p['paroki_tugas'] ?: ($paroki->nama_paroki ?? 'Paroki') }}</b></span>
                                                @if(!empty($p['ordo']))
                                                    <span class="ml-2">• Tarekat/Ordo: <b>{{ $p['ordo'] }}</b></span>
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center gap-2 shrink-0 md:self-center">
                                        <a
                                            href="{{ url("/{$currentPrefix}/master-referensi/pastor/edit/{$p['id']}") }}"
                                            class="px-2.5 py-1 rounded-lg bg-slate-100 dark:bg-slate-800 hover:bg-amber-500 hover:text-white dark:hover:bg-amber-500 text-slate-700 dark:text-slate-300 text-xs font-bold transition flex items-center gap-1 cursor-pointer"
                                            title="Edit data pastor ini di master pastor"
                                        >
                                            <i class="fa-solid fa-pen-to-square text-[10px]"></i>
                                            <span>Edit Data</span>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        {{-- Fallback standard fields if no pastors list --}}
                        <div class="divide-y divide-slate-100 dark:divide-slate-800 text-xs">
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-3 px-4 py-2.5 items-center hover:bg-slate-50/50 dark:hover:bg-slate-800/40">
                                <span class="text-slate-500 dark:text-slate-400 font-semibold">Pastor Paroki</span>
                                <div class="sm:col-span-2 flex items-center gap-2">
                                    <span class="font-bold text-slate-900 dark:text-white">{{ $paroki?->nama_pastor_paroki_aktif ?: 'Belum diatur' }}</span>
                                    <span class="px-2 py-0.5 rounded-md bg-amber-50 dark:bg-amber-950/60 text-amber-700 dark:text-amber-300 border border-amber-200 dark:border-amber-800 text-[10px] font-bold">Pastor Paroki</span>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-3 px-4 py-2.5 items-center hover:bg-slate-50/50 dark:hover:bg-slate-800/40">
                                <span class="text-slate-500 dark:text-slate-400 font-semibold">Pastor Rekan</span>
                                <div class="sm:col-span-2 flex items-center gap-2">
                                    <span class="font-bold text-slate-700 dark:text-slate-300">{{ $paroki?->nama_pastor_rekan ?: '-' }}</span>
                                    <span class="px-2 py-0.5 rounded-md bg-blue-50 dark:bg-blue-950/60 text-blue-700 dark:text-blue-300 border border-blue-200 dark:border-blue-800 text-[10px] font-bold">Pastor Rekan</span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- SECTION 3: LOKASI & WILAYAH ADMINISTRATIF --}}
                <div>
                    <div class="bg-slate-50/90 dark:bg-slate-800/80 px-4 py-2.5 border-b border-slate-200 dark:border-slate-800 flex items-center gap-2 text-xs font-black text-slate-800 dark:text-slate-200 uppercase">
                        <i class="bi bi-geo-alt-fill text-amber-600"></i>
                        <span>LOKASI & WILAYAH ADMINISTRATIF</span>
                    </div>
                    <div class="divide-y divide-slate-100 dark:divide-slate-800 text-xs">
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-3 px-4 py-2.5 hover:bg-slate-50/50 dark:hover:bg-slate-800/40">
                            <span class="text-slate-500 dark:text-slate-400 font-semibold">Alamat Lengkap</span>
                            <span class="sm:col-span-2 font-medium text-slate-800 dark:text-slate-200">{{ $paroki?->alamat ?: '-' }}</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-3 px-4 py-2.5 hover:bg-slate-50/50 dark:hover:bg-slate-800/40">
                            <span class="text-slate-500 dark:text-slate-400 font-semibold">Kelurahan / Desa</span>
                            <span class="sm:col-span-2 font-bold text-slate-800 dark:text-slate-200">{{ $paroki?->desa?->nama_desa ?: ($profil?->desa_kelurahan ?: '-') }}</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-3 px-4 py-2.5 hover:bg-slate-50/50 dark:hover:bg-slate-800/40">
                            <span class="text-slate-500 dark:text-slate-400 font-semibold">Kecamatan</span>
                            <span class="sm:col-span-2 font-bold text-slate-800 dark:text-slate-200">{{ $paroki?->kecamatan?->nama_kecamatan ?: ($profil?->kecamatan ?: '-') }}</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-3 px-4 py-2.5 hover:bg-slate-50/50 dark:hover:bg-slate-800/40">
                            <span class="text-slate-500 dark:text-slate-400 font-semibold">Kabupaten / Kota</span>
                            <span class="sm:col-span-2 font-bold text-slate-800 dark:text-slate-200">{{ $paroki?->kabupaten?->nama_kabupaten ?: ($profil?->kabupaten_kota ?: '-') }}</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-3 px-4 py-2.5 hover:bg-slate-50/50 dark:hover:bg-slate-800/40">
                            <span class="text-slate-500 dark:text-slate-400 font-semibold">Provinsi</span>
                            <span class="sm:col-span-2 font-bold text-slate-800 dark:text-slate-200">{{ $paroki?->provinsi?->nama_provinsi ?: ($profil?->provinsi ?: '-') }}</span>
                        </div>
                    </div>
                </div>

                {{-- SECTION 4: KONTAK & INFORMASI --}}
                <div>
                    <div class="bg-slate-50/90 dark:bg-slate-800/80 px-4 py-2.5 border-b border-slate-200 dark:border-slate-800 flex items-center gap-2 text-xs font-black text-slate-800 dark:text-slate-200 uppercase">
                        <i class="bi bi-telephone-fill text-amber-600"></i>
                        <span>KONTAK & INFORMASI</span>
                    </div>
                    <div class="divide-y divide-slate-100 dark:divide-slate-800 text-xs">
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-3 px-4 py-2.5 hover:bg-slate-50/50 dark:hover:bg-slate-800/40">
                            <span class="text-slate-500 dark:text-slate-400 font-semibold">No. Telepon / HP</span>
                            <span class="sm:col-span-2 font-bold text-slate-800 dark:text-slate-200">{{ $paroki?->telepon ?: ($paroki?->whatsapp ?: ($profil?->telepon ?: '-')) }}</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-3 px-4 py-2.5 hover:bg-slate-50/50 dark:hover:bg-slate-800/40">
                            <span class="text-slate-500 dark:text-slate-400 font-semibold">Email Resmi</span>
                            <span class="sm:col-span-2 font-bold text-slate-800 dark:text-slate-200">{{ $paroki?->email ?: ($profil?->email ?: '-') }}</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-1 sm:gap-3 px-4 py-2.5 hover:bg-slate-50/50 dark:hover:bg-slate-800/40">
                            <span class="text-slate-500 dark:text-slate-400 font-semibold">Website</span>
                            <span class="sm:col-span-2 font-bold text-blue-600 dark:text-blue-400">{{ $paroki?->website ?: ($profil?->website ?: '-') }}</span>
                        </div>
                    </div>
                </div>

                {{-- SECTION 5: NARASI & SEJARAH PAROKI --}}
                @if(!empty($paroki?->keterangan) || !empty($profil?->sejarah))
                    <div>
                        <div class="bg-slate-50/90 dark:bg-slate-800/80 px-4 py-2.5 border-b border-slate-200 dark:border-slate-800 flex items-center gap-2 text-xs font-black text-slate-800 dark:text-slate-200 uppercase">
                            <i class="fa-solid fa-book-open text-amber-600"></i>
                            <span>NARASI & SEJARAH PAROKI</span>
                        </div>
                        <div class="p-4 text-xs leading-relaxed text-slate-700 dark:text-slate-300 space-y-2">
                            {!! nl2br(e($paroki?->keterangan ?: $profil?->sejarah)) !!}
                        </div>
                    </div>
                @endif

                {{-- SECTION 6: PETA & LOKASI GOOGLE MAPS --}}
                @if(!empty($paroki?->maps_embed) || !empty($paroki?->maps_url) || !empty($profil?->google_maps))
                    <div>
                        <div class="bg-slate-50/90 dark:bg-slate-800/80 px-4 py-2.5 border-b border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 text-xs font-black text-slate-800 dark:text-slate-200 uppercase">
                            <div class="flex items-center gap-2">
                                <i class="fa-solid fa-map-location-dot text-amber-600"></i>
                                <span>PETA & LOKASI GOOGLE MAPS</span>
                            </div>
                            @if(!empty($paroki?->maps_url))
                                <a
                                    href="{{ $paroki->maps_url }}"
                                    target="_blank"
                                    class="text-[11px] font-bold text-blue-600 dark:text-blue-400 hover:text-blue-800 normal-case flex items-center gap-1 shrink-0"
                                >
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                    <span>Buka di Google Maps</span>
                                </a>
                            @endif
                        </div>
                        <div class="p-4 space-y-3">
                            @php
                                $mapsEmbed = $paroki?->maps_embed ?: $profil?->google_maps;
                            @endphp
                            @if(!empty($mapsEmbed))
                                <div class="w-full h-64 rounded-xl overflow-hidden border border-slate-200 dark:border-slate-800 shadow-2xs">
                                    {!! $mapsEmbed !!}
                                </div>
                            @endif
                            @if(!empty($paroki?->latitude) && !empty($paroki?->longitude))
                                <div class="text-xs text-slate-500 dark:text-slate-400 flex items-center gap-4">
                                    <span><b>Latitude:</b> {{ $paroki->latitude }}</span>
                                    <span><b>Longitude:</b> {{ $paroki->longitude }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

            </div>
        </div>

        {{-- ── RIGHT COLUMN: PAROKI UTAMA (DEFAULT) WIDGETS (xl:col-span-4) ── --}}
        <div class="xl:col-span-4 space-y-4 xl:sticky xl:top-4 min-w-0">
            
            {{-- WIDGET 1: PAROKI UTAMA (DEFAULT) SELECTOR --}}
            <div class="rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 p-4 shadow-xs space-y-4">
                <div class="flex items-center gap-2 pb-2.5 border-b border-slate-100 dark:border-slate-800">
                    <i class="bi bi-gear-fill text-amber-500 text-sm"></i>
                    <h3 class="text-xs font-black text-slate-900 dark:text-white uppercase tracking-wider">Paroki Utama (Default)</h3>
                </div>

                <div class="space-y-3">
                    {{-- Searchable Custom Popover Dropdown (Powered by Alpine.js for instantaneous UI) --}}
                    <div x-data="{ open: false, query: '' }" @click.outside="open = false" class="relative">
                        <label class="text-[11px] font-bold text-slate-600 dark:text-slate-400 block mb-1">Pilih Paroki Utama</label>
                        
                        <button
                            type="button"
                            @click="open = !open"
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/70 hover:bg-white dark:hover:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-800 dark:text-slate-200 focus:outline-none focus:border-amber-500 flex items-center justify-between gap-2 cursor-pointer shadow-2xs text-left transition"
                        >
                            <span class="truncate">{{ $selectedParokiName }}</span>
                            <i :class="['bi bi-chevron-down text-[10px] text-slate-400 transition-transform duration-200 shrink-0', open ? 'rotate-180 text-amber-600' : '']"></i>
                        </button>

                        {{-- Searchable Popover Menu --}}
                        <div
                            x-show="open"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute left-0 right-0 top-full mt-1.5 z-40 bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-xl overflow-hidden space-y-2 p-2"
                            style="display: none;"
                        >
                            <div class="relative">
                                <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                                <input
                                    type="text"
                                    x-model="query"
                                    placeholder="Ketik nama paroki / keuskupan..."
                                    class="w-full pl-8 pr-3 py-1.5 rounded-lg bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs text-slate-800 dark:text-white focus:outline-none focus:border-amber-500"
                                    @click.stop
                                />
                            </div>

                            <div class="max-h-60 overflow-y-auto divide-y divide-slate-100 dark:divide-slate-800">
                                @forelse($allParoki as $p)
                                    <button
                                        type="button"
                                        x-show="!query || '{{ strtolower(addslashes($p['nama_paroki'] . ' ' . $p['nama_keuskupan'] . ' ' . $p['kode_paroki'])) }}'.includes(query.toLowerCase())"
                                        wire:click="selectParokiItem({{ $p['id_paroki'] }})"
                                        @click="open = false"
                                        class="w-full text-left px-3 py-2 rounded-lg text-xs transition flex flex-col cursor-pointer {{ $p['id_paroki'] == $selectedParokiId ? 'bg-amber-50 dark:bg-amber-950/60 text-amber-900 dark:text-amber-200 font-bold' : 'hover:bg-slate-50 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-300' }}"
                                    >
                                        <span class="font-bold">{{ $p['nama_paroki'] }}</span>
                                        <span class="text-[10px] text-slate-400">
                                            {{ $p['nama_keuskupan'] ?: 'Keuskupan' }} • {{ $p['kode_paroki'] ?: '-' }}
                                        </span>
                                    </button>
                                @empty
                                    <div class="py-4 text-center text-xs text-slate-400">
                                        Tidak ada paroki yang tersedia.
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <button
                        type="button"
                        wire:click="applyAndSync"
                        class="w-full flex items-center justify-center gap-2 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold shadow-xs transition cursor-pointer"
                    >
                        <i class="bi bi-arrow-repeat text-sm"></i>
                        <span>Terapkan &amp; Sinkronkan</span>
                    </button>

                    <p class="text-[11px] text-slate-400 text-center leading-relaxed">
                        Paroki terpilih akan digunakan secara otomatis di seluruh web publik dan backend.
                    </p>
                </div>
            </div>

            {{-- WIDGET 2: AUTO-SINKRONISASI AKTIF (Green Box) --}}
            <div class="p-4 rounded-2xl bg-emerald-50/70 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/60 space-y-2 text-xs">
                <div class="flex items-center gap-2 font-bold text-emerald-900 dark:text-emerald-300">
                    <i class="bi bi-check-circle-fill text-emerald-600 dark:text-emerald-400 text-sm"></i>
                    <span>Auto-Sinkronisasi Aktif:</span>
                </div>
                <ul class="list-disc pl-4 space-y-1.5 text-[11px] text-emerald-800 dark:text-emerald-300/90 leading-relaxed">
                    <li>Menyetel paroki default akan langsung menampilkan seluruh detail profil paroki terpilih.</li>
                    <li>Frontend dan backend otomatis tersinkronisasi tanpa perlu refresh manual.</li>
                </ul>
            </div>

            {{-- WIDGET 3: PAROKI SUMMARY CARD (Clean Card matching bimkat/katedral) --}}
            @if($paroki)
                <div class="rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 p-4 shadow-xs space-y-3 text-xs">
                    <div class="flex items-center justify-between gap-2 border-b border-slate-100 dark:border-slate-800 pb-2.5">
                        <div class="font-extrabold text-amber-600 dark:text-amber-400 text-sm truncate">
                            {{ $paroki->nama_paroki }}
                        </div>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800 text-[10px] font-bold shrink-0">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            {{ $paroki->status ?? 'Aktif' }}
                        </span>
                    </div>

                    <div class="space-y-2 text-slate-600 dark:text-slate-400">
                        @if(!empty($paroki->keuskupan?->nama_keuskupan))
                            <div class="flex items-center gap-2.5">
                                <i class="bi bi-bank text-slate-400 text-xs w-4"></i>
                                <span class="font-medium text-slate-700 dark:text-slate-300">{{ $paroki->keuskupan->nama_keuskupan }}</span>
                            </div>
                        @endif
                        @if(!empty($paroki->dekenat?->nama_dekenat ?? $paroki->dekenat?->nama_kevikepan))
                            <div class="flex items-center gap-2.5">
                                <i class="bi bi-layers text-slate-400 text-xs w-4"></i>
                                <span>{{ $paroki->dekenat->nama_dekenat ?? $paroki->dekenat->nama_kevikepan }}</span>
                            </div>
                        @endif
                        @if(!empty($paroki->kode_paroki))
                            <div class="flex items-center gap-2.5">
                                <i class="bi bi-tag text-slate-400 text-xs w-4"></i>
                                <span>Kode: <code class="bg-slate-100 dark:bg-slate-800 px-1.5 py-0.5 rounded text-amber-600 dark:text-amber-400 font-mono font-bold">{{ $paroki->kode_paroki }}</code></span>
                            </div>
                        @endif
                        @if(!empty($paroki->nama_pastor_paroki_aktif))
                            <div class="pt-1 flex items-start gap-2.5">
                                <i class="bi bi-person-fill text-slate-400 text-xs w-4 mt-0.5"></i>
                                <span><b>Pastor:</b> {{ $paroki->nama_pastor_paroki_aktif }}</span>
                            </div>
                        @endif
                        @if(!empty($paroki->telepon))
                            <div class="flex items-center gap-2.5">
                                <i class="bi bi-telephone-fill text-slate-400 text-xs w-4"></i>
                                <span>{{ $paroki->telepon }}</span>
                            </div>
                        @endif
                        @if(!empty($paroki->alamat))
                            <div class="flex items-start gap-2.5">
                                <i class="bi bi-geo-alt-fill text-slate-400 text-xs w-4 mt-0.5"></i>
                                <span class="leading-relaxed">{{ $paroki->alamat }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════════ --}}
    {{-- MODAL 1: EDIT DATA PROFIL PAROKI (Full Form Matching Vue)      --}}
    {{-- ═══════════════════════════════════════════════════════════════ --}}
    @if($showEditModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/60 backdrop-blur-xs overflow-y-auto">
            <div class="bg-white dark:bg-slate-900 rounded-3xl max-w-4xl w-full shadow-2xl border border-slate-200 dark:border-slate-800 overflow-hidden my-8 flex flex-col max-h-[92vh]">
                
                {{-- Header Modal --}}
                <div class="bg-gradient-to-r from-amber-500 via-amber-600 to-amber-700 px-6 py-4 flex items-center justify-between text-white shrink-0">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center text-lg font-black">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </div>
                        <div>
                            <h3 class="text-base font-black">Edit Profil &amp; Data Paroki</h3>
                            <p class="text-[11px] text-amber-100">Perbarui identitas paroki, alamat, kontak, dan pastor yang bertugas.</p>
                        </div>
                    </div>
                    <button type="button" wire:click="closeEditModal" class="w-8 h-8 rounded-lg bg-white/10 hover:bg-white/20 flex items-center justify-center transition cursor-pointer">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                {{-- Body Modal --}}
                <div class="p-6 space-y-6 overflow-y-auto flex-1">
                    
                    {{-- 1. INFORMASI INDUK & IDENTITAS PAROKI --}}
                    <div class="space-y-3">
                        <h4 class="text-xs font-black text-slate-800 dark:text-slate-200 uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 dark:border-slate-800 pb-2">
                            <i class="fa-solid fa-church text-amber-600"></i>
                            <span>Informasi Induk &amp; Identitas Paroki</span>
                        </h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <label class="text-[11px] font-bold text-slate-600 dark:text-slate-400">Keuskupan Induk *</label>
                                <select wire:model.live="form.keuskupan_id" class="w-full px-3 py-2 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs text-slate-800 dark:text-white focus:outline-none focus:border-amber-500 cursor-pointer">
                                    <option value="">-- Pilih Keuskupan --</option>
                                    @foreach($keuskupanList as $k)
                                        <option value="{{ $k['id'] }}">{{ $k['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="space-y-1">
                                <label class="text-[11px] font-bold text-slate-600 dark:text-slate-400">Dekenat / Kevikepan *</label>
                                <select wire:model="form.dekenat_id" class="w-full px-3 py-2 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs text-slate-800 dark:text-white focus:outline-none focus:border-amber-500 cursor-pointer">
                                    <option value="">-- Pilih Dekenat --</option>
                                    @foreach($dekenatList as $d)
                                        <option value="{{ $d['id'] }}">{{ $d['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="space-y-1">
                                <label class="text-[11px] font-bold text-slate-600 dark:text-slate-400">Kode Paroki <span class="text-slate-400 font-normal">(Readonly Otomatis)</span></label>
                                <input wire:model="form.kode_paroki" type="text" readonly class="w-full px-3 py-2 rounded-xl bg-slate-100 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 text-xs font-mono font-bold text-slate-600 dark:text-slate-400 cursor-not-allowed" />
                            </div>
                            <div class="space-y-1">
                                <label class="text-[11px] font-bold text-slate-600 dark:text-slate-400">Nama Paroki *</label>
                                <input wire:model="form.nama_paroki" type="text" class="w-full px-3 py-2 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-800 dark:text-white focus:outline-none focus:border-amber-500" />
                                @error('form.nama_paroki') <span class="text-[10px] text-rose-500 font-bold block">{{ $message }}</span> @enderror
                            </div>
                            <div class="space-y-1">
                                <label class="text-[11px] font-bold text-slate-600 dark:text-slate-400">Nama Pelindung / Santo</label>
                                <input wire:model="form.pelindung_paroki" type="text" placeholder="Contoh: St. Vinsensius a Paulo" class="w-full px-3 py-2 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs text-slate-800 dark:text-white focus:outline-none focus:border-amber-500" />
                            </div>
                            <div class="space-y-1">
                                <label class="text-[11px] font-bold text-slate-600 dark:text-slate-400">Status</label>
                                <select wire:model="form.status" class="w-full px-3 py-2 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs text-slate-800 dark:text-white focus:outline-none focus:border-amber-500 cursor-pointer">
                                    <option value="Aktif">Aktif</option>
                                    <option value="Nonaktif">Nonaktif</option>
                                </select>
                            </div>
                            <div class="space-y-1">
                                <label class="text-[11px] font-bold text-slate-600 dark:text-slate-400">Status Paroki</label>
                                <select wire:model="form.status_paroki" class="w-full px-3 py-2 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs text-slate-800 dark:text-white focus:outline-none focus:border-amber-500 cursor-pointer">
                                    @foreach($statusOptions as $st)
                                        <option value="{{ $st }}">{{ $st }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="space-y-1">
                                <label class="text-[11px] font-bold text-slate-600 dark:text-slate-400">Tanggal Berdiri</label>
                                <input wire:model="form.tanggal_berdiri" type="date" class="w-full px-3 py-2 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs text-slate-800 dark:text-white focus:outline-none focus:border-amber-500" />
                            </div>
                        </div>
                    </div>

                    {{-- 2. PELAYAN PASTORAL --}}
                    <div class="space-y-3">
                        <h4 class="text-xs font-black text-slate-800 dark:text-slate-200 uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 dark:border-slate-800 pb-2">
                            <i class="fa-solid fa-user-tie text-amber-600"></i>
                            <span>Pelayan Pastoral</span>
                        </h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <label class="text-[11px] font-bold text-slate-600 dark:text-slate-400">Pastor Paroki</label>
                                <input
                                    wire:model="form.nama_pastor_paroki_aktif"
                                    type="text"
                                    placeholder="Contoh: RD. Krispinus Saku"
                                    class="w-full px-3 py-2 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-800 dark:text-white focus:outline-none focus:border-amber-500"
                                />
                                <p class="text-[10px] text-slate-400">Pastor yang bertugas memimpin paroki</p>
                            </div>

                            {{-- Pastor Rekan Multi Select with Tag Badges --}}
                            <div class="space-y-1">
                                <label class="text-[11px] font-bold text-slate-600 dark:text-slate-400">Pastor Rekan (Bisa lebih dari 1)</label>
                                <div class="flex items-center gap-2">
                                    <input
                                        wire:model="pastorRekanInput"
                                        wire:keydown.enter.prevent="addPastorRekan"
                                        type="text"
                                        placeholder="Ketik nama pastor rekan lalu tekan Enter / Tambah..."
                                        class="w-full px-3 py-2 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs text-slate-800 dark:text-white focus:outline-none focus:border-amber-500"
                                    />
                                    <button
                                        type="button"
                                        wire:click="addPastorRekan"
                                        class="px-3 py-2 rounded-xl bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold shrink-0 transition cursor-pointer"
                                    >
                                        + Tambah
                                    </button>
                                </div>
                                @if(!empty($form['pastor_rekan_array']))
                                    <div class="flex flex-wrap gap-1.5 pt-1.5">
                                        @foreach($form['pastor_rekan_array'] as $idx => $pr)
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-amber-50 dark:bg-amber-950/60 border border-amber-200 dark:border-amber-800 text-amber-900 dark:text-amber-200 text-xs font-bold">
                                                <span>{{ $pr }}</span>
                                                <button type="button" wire:click="removePastorRekan({{ $idx }})" class="text-amber-700 hover:text-rose-600 font-black cursor-pointer">
                                                    ✕
                                                </button>
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                                <p class="text-[10px] text-slate-400">Pilih satu atau beberapa pastor yang bertugas sebagai Pastor Rekan</p>
                            </div>
                        </div>
                    </div>

                    {{-- 3. WILAYAH ADMINISTRATIF & ALAMAT --}}
                    <div class="space-y-3">
                        <h4 class="text-xs font-black text-slate-800 dark:text-slate-200 uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 dark:border-slate-800 pb-2">
                            <i class="fa-solid fa-map-location-dot text-amber-600"></i>
                            <span>Wilayah Administratif &amp; Alamat</span>
                        </h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <label class="text-[11px] font-bold text-slate-600 dark:text-slate-400">Provinsi *</label>
                                <select wire:model.live="form.provinsi_id" class="w-full px-3 py-2 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs text-slate-800 dark:text-white focus:outline-none focus:border-amber-500 cursor-pointer">
                                    <option value="">-- Pilih Provinsi --</option>
                                    @foreach($provinsiList as $prov)
                                        <option value="{{ $prov['id'] }}">{{ $prov['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="space-y-1">
                                <label class="text-[11px] font-bold text-slate-600 dark:text-slate-400">Kabupaten / Kota *</label>
                                <select wire:model.live="form.kabupaten_id" class="w-full px-3 py-2 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs text-slate-800 dark:text-white focus:outline-none focus:border-amber-500 cursor-pointer">
                                    <option value="">-- Pilih Kabupaten/Kota --</option>
                                    @foreach($kabupatenList as $kab)
                                        <option value="{{ $kab['id'] }}">{{ $kab['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="space-y-1">
                                <label class="text-[11px] font-bold text-slate-600 dark:text-slate-400">Kecamatan</label>
                                <select wire:model.live="form.kecamatan_id" class="w-full px-3 py-2 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs text-slate-800 dark:text-white focus:outline-none focus:border-amber-500 cursor-pointer">
                                    <option value="">-- Pilih Kecamatan --</option>
                                    @foreach($kecamatanList as $kec)
                                        <option value="{{ $kec['id'] }}">{{ $kec['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="space-y-1">
                                <label class="text-[11px] font-bold text-slate-600 dark:text-slate-400">Desa / Kelurahan</label>
                                <select wire:model="form.desa_id" class="w-full px-3 py-2 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs text-slate-800 dark:text-white focus:outline-none focus:border-amber-500 cursor-pointer">
                                    <option value="">-- Pilih Desa/Kelurahan --</option>
                                    @foreach($desaList as $des)
                                        <option value="{{ $des['id'] }}">{{ $des['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="space-y-1 sm:col-span-2">
                                <label class="text-[11px] font-bold text-slate-600 dark:text-slate-400">Alamat Lengkap Kantor / Gereja</label>
                                <textarea wire:model="form.alamat" rows="2" placeholder="Contoh: Jl. Timor Raya Km. 45, Benlutu..." class="w-full px-3 py-2 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs text-slate-800 dark:text-white focus:outline-none focus:border-amber-500"></textarea>
                            </div>
                        </div>
                    </div>

                    {{-- 4. KONTAK & MEDIA INFORMASI --}}
                    <div class="space-y-3">
                        <h4 class="text-xs font-black text-slate-800 dark:text-slate-200 uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 dark:border-slate-800 pb-2">
                            <i class="fa-solid fa-phone text-amber-600"></i>
                            <span>Kontak &amp; Media Informasi</span>
                        </h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <label class="text-[11px] font-bold text-slate-600 dark:text-slate-400">Nomor Telepon Kantor</label>
                                <input wire:model="form.telepon" type="text" placeholder="Contoh: (0380) 123456" class="w-full px-3 py-2 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs text-slate-800 dark:text-white focus:outline-none focus:border-amber-500" />
                            </div>
                            <div class="space-y-1">
                                <label class="text-[11px] font-bold text-slate-600 dark:text-slate-400">Nomor WhatsApp Resmi</label>
                                <input wire:model="form.whatsapp" type="text" placeholder="Contoh: 081234567890" class="w-full px-3 py-2 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs text-slate-800 dark:text-white focus:outline-none focus:border-amber-500" />
                            </div>
                            <div class="space-y-1">
                                <label class="text-[11px] font-bold text-slate-600 dark:text-slate-400">Email Resmi Paroki</label>
                                <input wire:model="form.email" type="email" placeholder="Contoh: sekretariat@parokibenlutu.org" class="w-full px-3 py-2 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs text-slate-800 dark:text-white focus:outline-none focus:border-amber-500" />
                            </div>
                            <div class="space-y-1">
                                <label class="text-[11px] font-bold text-slate-600 dark:text-slate-400">Website Resmi</label>
                                <input wire:model="form.website" type="text" placeholder="Contoh: https://parokibenlutu.org" class="w-full px-3 py-2 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs text-slate-800 dark:text-white focus:outline-none focus:border-amber-500" />
                            </div>
                        </div>
                    </div>

                    {{-- 5. INTEGRASI GOOGLE MAPS --}}
                    <div class="space-y-3">
                        <h4 class="text-xs font-black text-slate-800 dark:text-slate-200 uppercase tracking-wider flex items-center gap-2 border-b border-slate-100 dark:border-slate-800 pb-2">
                            <i class="fa-solid fa-map-pin text-amber-600"></i>
                            <span>Integrasi Google Maps &amp; Titik Koordinat</span>
                        </h4>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div class="space-y-1 sm:col-span-3">
                                <label class="text-[11px] font-bold text-slate-600 dark:text-slate-400">Link Google Maps (Share Link)</label>
                                <input wire:model="form.maps_url" type="text" placeholder="https://maps.google.com/?q=-9.895699,124.223603" class="w-full px-3 py-2 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs text-slate-800 dark:text-white focus:outline-none focus:border-amber-500" />
                            </div>
                            <div class="space-y-1">
                                <label class="text-[11px] font-bold text-slate-600 dark:text-slate-400">Latitude</label>
                                <input wire:model="form.latitude" type="text" placeholder="-9.895699" class="w-full px-3 py-2 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs text-slate-800 dark:text-white focus:outline-none focus:border-amber-500" />
                            </div>
                            <div class="space-y-1">
                                <label class="text-[11px] font-bold text-slate-600 dark:text-slate-400">Longitude</label>
                                <input wire:model="form.longitude" type="text" placeholder="124.223603" class="w-full px-3 py-2 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs text-slate-800 dark:text-white focus:outline-none focus:border-amber-500" />
                            </div>
                            <div class="space-y-1 sm:col-span-3">
                                <label class="text-[11px] font-bold text-slate-600 dark:text-slate-400">Embed Google Maps (Iframe)</label>
                                <textarea wire:model="form.maps_embed" rows="3" placeholder='<iframe src="https://www.google.com/maps/embed?..." width="600" height="450"></iframe>' class="w-full px-3 py-2 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs font-mono text-slate-800 dark:text-white focus:outline-none focus:border-amber-500"></textarea>
                                <p class="text-[10px] text-slate-400">Pastekan tag &lt;iframe src="..."&gt;&lt;/iframe&gt; dari Google Maps (Bagikan / Share -&gt; Sematkan peta / Embed a map).</p>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Footer Modal --}}
                <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-end gap-3 bg-slate-50/50 dark:bg-slate-800/40 shrink-0">
                    <button type="button" wire:click="closeEditModal" class="px-4 py-2 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 text-xs font-bold transition cursor-pointer">Batal</button>
                    <button type="button" wire:click="saveParokiModal" class="px-5 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold shadow-xs transition flex items-center gap-2 cursor-pointer">
                        <i class="fa-solid fa-check"></i>
                        <span>Simpan Perubahan Paroki</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- ═══════════════════════════════════════════════════════════════ --}}
    {{-- MODAL 2: UPLOAD BANNER HEADER (Matching katedrallaravel12)      --}}
    {{-- ═══════════════════════════════════════════════════════════════ --}}
    @if($showBannerModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/60 backdrop-blur-xs overflow-y-auto">
            <div class="bg-white dark:bg-slate-900 rounded-3xl max-w-2xl w-full shadow-2xl border border-slate-200 dark:border-slate-800 overflow-hidden my-8">
                
                {{-- Header Modal --}}
                <div class="bg-gradient-to-r from-emerald-600 via-teal-600 to-emerald-700 px-6 py-4 flex items-center justify-between text-white">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center text-lg font-black">
                            <i class="fa-solid fa-panorama"></i>
                        </div>
                        <div>
                            <h3 class="text-base font-black">Upload Banner Header Website Publik</h3>
                            <p class="text-[11px] text-emerald-100">Ganti latar belakang header halaman Statistik, Jadwal Misa, Kontak, dll.</p>
                        </div>
                    </div>
                    <button type="button" wire:click="closeBannerModal" class="w-8 h-8 rounded-lg bg-white/10 hover:bg-white/20 flex items-center justify-center transition cursor-pointer">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                {{-- Body Modal --}}
                <div class="p-6 space-y-5">
                    {{-- Info Alert --}}
                    <div class="p-3.5 rounded-2xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200/80 dark:border-emerald-800/60 flex items-start gap-3 text-emerald-950 dark:text-emerald-200 text-xs">
                        <i class="fa-solid fa-circle-info text-emerald-600 dark:text-emerald-400 text-sm mt-0.5 shrink-0"></i>
                        <div class="leading-relaxed text-[11.5px]">
                            Foto yang Anda upload di sini akan langsung otomatis menjadi <b>latar belakang header atas</b> di seluruh sub-halaman publik, termasuk halaman <b>Statistik &amp; Demografi Umat</b>.
                        </div>
                    </div>

                    {{-- Banner Preview Area with Header Simulation Overlay --}}
                    <div class="space-y-2">
                        <label class="text-[11px] font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wide block">Preview Banner Latar Belakang</label>
                        <div class="w-full h-48 sm:h-56 rounded-2xl border-2 border-dashed border-emerald-300 dark:border-emerald-700 bg-slate-900 overflow-hidden relative shadow-inner flex items-center justify-center group">
                            @if(!empty($bannerPreview))
                                <img
                                    src="{{ $bannerPreview }}"
                                    class="w-full h-full object-cover transition duration-300 group-hover:scale-105"
                                    alt="Banner Preview"
                                />
                            @else
                                <div class="flex flex-col items-center gap-2 text-slate-400">
                                    <i class="fa-solid fa-mountain-sun text-4xl text-emerald-500/60"></i>
                                    <span class="text-xs font-semibold">Belum ada gambar banner yang dipilih</span>
                                    <span class="text-[10px] text-slate-500">Klik tombol di bawah untuk memilih foto dari komputer/HP</span>
                                </div>
                            @endif

                            {{-- Header Simulation Overlay (Green gradient on top of preview matching katedral) --}}
                            <div class="absolute inset-0 bg-gradient-to-r from-emerald-950/75 via-teal-900/60 to-emerald-950/80 pointer-events-none flex flex-col justify-end p-4">
                                <span class="text-white font-black text-sm drop-shadow-md">Simulasi Tampilan Header</span>
                                <span class="text-emerald-200/90 text-[10px] drop-shadow-sm">Statistik &amp; Demografi Umat • Transparansi Data Jemaat</span>
                            </div>
                        </div>
                    </div>

                    {{-- Upload Controls --}}
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-800">
                        <label class="cursor-pointer inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition shadow-sm cursor-pointer shrink-0">
                            <i class="fa-solid fa-cloud-arrow-up text-sm"></i>
                            <span>Pilih Foto Banner (Komputer / HP)</span>
                            <input type="file" wire:model="bannerUpload" accept="image/*" class="hidden" />
                        </label>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400 text-center sm:text-right">Format: JPG, PNG, atau WebP. Rekomendasi foto lanskap melebar (16:9 / 21:9), maks 5MB.</p>
                    </div>
                    @error('bannerUpload') <span class="text-xs text-rose-500 font-bold block">{{ $message }}</span> @enderror
                </div>

                {{-- Footer Modal --}}
                <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-end gap-3 bg-slate-50/75 dark:bg-slate-800/40">
                    <button type="button" wire:click="closeBannerModal" class="px-4 py-2 rounded-xl bg-slate-200 dark:bg-slate-800 hover:bg-slate-300 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 text-xs font-bold transition cursor-pointer">Batal</button>
                    <button
                        type="button"
                        wire:click="saveBannerModal"
                        @if(!$bannerUpload) disabled @endif
                        class="px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold shadow-md transition flex items-center gap-2 disabled:opacity-60 cursor-pointer"
                    >
                        <i class="fa-solid fa-check"></i>
                        <span>Simpan Banner Header</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- ═══════════════════════════════════════════════════════════════ --}}
    {{-- MODAL 3: GAMBAR & SEJARAH PAROKI (Matching katedrallaravel12)   --}}
    {{-- ═══════════════════════════════════════════════════════════════ --}}
    @if($showImageModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/60 backdrop-blur-xs overflow-y-auto">
            <div class="bg-white dark:bg-slate-900 rounded-3xl max-w-2xl w-full shadow-2xl border border-slate-200 dark:border-slate-800 overflow-hidden my-8">
                
                {{-- Header Modal --}}
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 flex items-center justify-between text-white">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-white/20 flex items-center justify-center text-sm font-black">
                            <i class="fa-regular fa-image"></i>
                        </div>
                        <div>
                            <h3 class="text-base font-black">Edit Gambar &amp; Sejarah Paroki</h3>
                            <p class="text-[11px] text-blue-100">Upload logo paroki (kompresi otomatis) dan narasi sejarah.</p>
                        </div>
                    </div>
                    <button type="button" wire:click="closeImageModal" class="w-8 h-8 rounded-lg bg-white/10 hover:bg-white/20 flex items-center justify-center transition cursor-pointer">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                {{-- Body Modal --}}
                <div class="p-6 space-y-4 max-h-[65vh] overflow-y-auto">
                    {{-- Logo Upload with Auto Compress --}}
                    <div class="space-y-2 p-3.5 rounded-2xl bg-blue-50/50 dark:bg-blue-950/40 border border-blue-200/80 dark:border-blue-800/60">
                        <label class="text-[11px] font-bold text-blue-900 dark:text-blue-200 uppercase tracking-wide block">Logo / Lambang Paroki</label>
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 rounded-full border-2 border-dashed border-blue-300 dark:border-blue-700 bg-white dark:bg-slate-800 overflow-hidden flex items-center justify-center shrink-0 shadow-xs">
                                @if(!empty($logoPreview))
                                    <img src="{{ $logoPreview }}" alt="Preview Logo" class="w-full h-full object-contain p-1" />
                                @else
                                    <i class="fa-solid fa-church text-blue-500 text-xl"></i>
                                @endif
                            </div>
                            <div class="space-y-1">
                                <label class="cursor-pointer inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold transition shadow-xs cursor-pointer">
                                    <i class="fa-solid fa-upload text-[11px]"></i>
                                    <span>Pilih Logo Baru</span>
                                    <input type="file" wire:model="logoUpload" accept="image/*" class="hidden" />
                                </label>
                                <p class="text-[10px] text-blue-700 dark:text-blue-300">Gambar akan otomatis dikompresi (Maks 2MB, WebP/JPG/PNG).</p>
                                @error('logoUpload') <span class="text-[10px] text-rose-500 font-bold block">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="text-[11px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-wide block mb-1">Sejarah &amp; Keterangan Paroki</label>
                        <textarea
                            wire:model="keteranganSejarah"
                            rows="8"
                            placeholder="Tuliskan sejarah, latar belakang pendirian, dan profil lengkap paroki..."
                            class="w-full px-3 py-2 rounded-xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-xs text-slate-800 dark:text-white leading-relaxed focus:outline-none focus:border-blue-500"
                        ></textarea>
                    </div>
                </div>

                {{-- Footer Modal --}}
                <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-end gap-3 bg-slate-50/50 dark:bg-slate-800/40">
                    <button type="button" wire:click="closeImageModal" class="px-4 py-2 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 text-xs font-bold transition cursor-pointer">Batal</button>
                    <button type="button" wire:click="saveImageModal" class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold shadow-xs transition flex items-center gap-1.5 cursor-pointer">
                        <i class="fa-solid fa-check"></i>
                        <span>Simpan Gambar &amp; Sejarah</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>
