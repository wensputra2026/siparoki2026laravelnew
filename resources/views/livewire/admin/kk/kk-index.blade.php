<div class="space-y-6">
    <!-- 1. STATS CARDS (BIMKAT Spec) -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white dark:bg-slate-900 p-5 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Kartu Keluarga</p>
                <p class="text-2xl font-black text-slate-800 dark:text-white mt-1">{{ number_format($totalKk, 0, ',', '.') }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 flex items-center justify-center text-xl shadow-xs">
                <i class="bi bi-people-fill"></i>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-900 p-5 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Keluarga Aktif</p>
                <p class="text-2xl font-black text-emerald-600 dark:text-emerald-400 mt-1">{{ number_format($totalKkAktif, 0, ',', '.') }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-xl shadow-xs">
                <i class="bi bi-check-circle-fill"></i>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-900 p-5 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Umat / Jiwa</p>
                <p class="text-2xl font-black text-indigo-600 dark:text-indigo-400 mt-1">{{ number_format($totalJiwa, 0, ',', '.') }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-xl shadow-xs">
                <i class="bi bi-person-lines-fill"></i>
            </div>
        </div>
    </div>

    <!-- 2. HEADER & ACTION ROW -->
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
        <div>
            <h1 class="text-xl font-black text-slate-900 dark:text-white tracking-tight flex items-center gap-2">
                <i class="bi bi-house-door-fill text-amber-500"></i>
                <span>Data Kartu Keluarga (KK) Katolik</span>
            </h1>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                Basis data keluarga katolik paroki, struktur kepala keluarga, anggota jiwa, dan domisili teritorial.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2 w-full sm:w-auto">
            @if(!empty($selectedIds))
                <button wire:click="confirmBulkDelete" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-white bg-rose-600 hover:bg-rose-700 transition-all shadow-md shadow-rose-600/20 cursor-pointer">
                    <i class="bi bi-trash text-sm"></i>
                    <span>Hapus Terpilih ({{ count($selectedIds) }})</span>
                </button>
            @endif

            <a href="/{{ $prefix }}/kk-katolik/create" wire:navigate class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-xl shadow-md shadow-indigo-600/20 transition-all cursor-pointer">
                <i class="bi bi-plus-lg text-sm"></i>
                <span>Tambah KK Baru</span>
            </a>
        </div>
    </div>

    {{-- Flash Notifications --}}
    @if(session()->has('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" class="rounded-xl border border-emerald-500/30 bg-emerald-50 dark:bg-emerald-950/40 p-4 text-emerald-800 dark:text-emerald-300 flex items-center justify-between text-sm shadow-xs font-sans">
            <div class="flex items-center gap-3">
                <i class="bi bi-check-circle-fill text-emerald-600 text-lg"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button @click="show = false" class="text-emerald-600 dark:text-emerald-400 hover:opacity-80">
                <i class="bi bi-x-lg text-xs"></i>
            </button>
        </div>
    @endif

    <!-- 3. DATA TABLE & FILTERS (BIMKAT Spec) -->
    <div class="rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-xs overflow-hidden admin-table-wrap">
        {{-- Filter Bar --}}
        <div class="p-4 border-b border-slate-200/80 dark:border-slate-800 bg-slate-50/70 dark:bg-slate-950/50 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
            {{-- Search input --}}
            <div class="relative lg:col-span-2">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 pointer-events-none">
                    <i class="bi bi-search text-xs"></i>
                </span>
                <input 
                    type="search" 
                    wire:model.live.debounce.300ms="search" 
                    placeholder="Cari No KK, Kepala Keluarga, NIK, alamat..."
                    class="w-full pl-10 pr-4 py-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white placeholder-slate-400 font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all font-sans"
                >
            </div>

            {{-- Tom Select Wilayah --}}
            <div>
                <x-tom-select wire:model.live="filterWilayah" placeholder="Semua Wilayah">
                    <option value="">Semua Wilayah</option>
                    @foreach($wilayahOptions as $w)
                        <option value="{{ $w->id }}">{{ $w->nama_wilayah }}</option>
                    @endforeach
                </x-tom-select>
            </div>

            {{-- Tom Select Stasi/Kapela --}}
            <div>
                <x-tom-select wire:model.live="filterKapela" placeholder="Semua Kapela">
                    <option value="">Semua Kapela</option>
                    @foreach($kapelaOptions as $k)
                        <option value="{{ $k->id }}">{{ $k->nama_kapela }}</option>
                    @endforeach
                </x-tom-select>
            </div>

            {{-- Tom Select KUB --}}
            <div>
                <x-tom-select wire:model.live="filterKub" placeholder="Semua KUB">
                    <option value="">Semua KUB</option>
                    @foreach($kubOptions as $kub)
                        <option value="{{ $kub->id }}">{{ $kub->nama_kub }}</option>
                    @endforeach
                </x-tom-select>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead class="bg-slate-50/90 dark:bg-slate-950 text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 border-b border-slate-200/80 dark:border-slate-800 whitespace-nowrap">
                    <tr>
                        <th class="p-3 w-10 text-center">
                            <input type="checkbox" wire:model.live="selectAll" class="rounded border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-indigo-600 focus:ring-indigo-500/30">
                        </th>
                        <th class="p-3 w-12 text-center text-slate-500 dark:text-slate-400">No</th>
                        <th class="p-3">Kepala Keluarga</th>
                        <th class="p-3 cursor-pointer hover:text-indigo-600 dark:hover:text-indigo-400" wire:click="sortBy('no_kk_kw')">
                            No KK Katolik / Dukcapil
                        </th>
                        <th class="p-3">Teritorial (Wilayah / KUB)</th>
                        <th class="p-3">Alamat Domisili</th>
                        <th class="p-3 text-center">Anggota</th>
                        <th class="p-3 text-center">Status</th>
                        <th class="p-3 text-right pr-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800 font-normal whitespace-nowrap">
                    @forelse($kks as $index => $kk)
                        <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-800/40 transition-colors {{ in_array((string)$kk->id, $selectedIds) ? 'bg-amber-50/60 dark:bg-amber-950/30' : '' }}">
                            <td class="p-3 text-center">
                                <input type="checkbox" wire:model.live="selectedIds" value="{{ $kk->id }}" class="rounded border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-indigo-600 focus:ring-indigo-500/30">
                            </td>
                            <td class="p-3 text-center text-slate-400">
                                {{ $kks->firstItem() + $index }}
                            </td>
                            <td class="p-3">
                                <div class="flex items-center gap-3">
                                    <div class="h-9 w-9 rounded-xl bg-amber-50 dark:bg-amber-950/60 border border-amber-200 dark:border-amber-800 flex items-center justify-center text-amber-700 dark:text-amber-400 font-black shrink-0 shadow-2xs">
                                        {{ strtoupper(substr($kk->nama_baptis_pemilik ?: $kk->nama_lahir_pemilik ?: 'K', 0, 1)) }}
                                    </div>
                                    <div>
                                        <a href="/{{ $prefix }}/kk-katolik/{{ $kk->id }}/view" wire:navigate class="font-bold text-slate-900 dark:text-white hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                                            {{ $kk->nama_baptis_pemilik ?: '-' }}
                                        </a>
                                        @if($kk->nama_lahir_pemilik && $kk->nama_lahir_pemilik !== $kk->nama_baptis_pemilik)
                                            <div class="text-[11px] text-slate-500 dark:text-slate-400">
                                                Nama Lahir: {{ $kk->nama_lahir_pemilik }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="p-3">
                                <div class="font-mono text-indigo-600 dark:text-indigo-400 font-bold tracking-tight">
                                    {{ $kk->no_kk_kw }}
                                </div>
                                @if($kk->no_kk_dukcapil)
                                    <div class="text-[10px] text-slate-400 font-mono">
                                        Dukcapil: {{ $kk->no_kk_dukcapil }}
                                    </div>
                                @endif
                            </td>
                            <td class="p-3">
                                <div class="font-medium text-slate-800 dark:text-slate-200">
                                    {{ $kk->wilayah?->nama_wilayah ?: '-' }}
                                </div>
                                <div class="text-[11px] text-slate-400 flex items-center gap-1.5 mt-0.5">
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300">
                                        KUB: {{ $kk->kub?->nama_kub ?: '-' }}
                                    </span>
                                </div>
                            </td>
                            <td class="p-3 text-slate-600 dark:text-slate-300">
                                {{ Str::limit($kk->alamat_sekarang ?: '-', 35) }}
                                @if($kk->handphone)
                                    <div class="text-[11px] text-indigo-600 dark:text-indigo-400 mt-0.5 flex items-center gap-1">
                                        <i class="bi bi-telephone text-[10px]"></i> {{ $kk->handphone }}
                                    </div>
                                @endif
                            </td>
                            <td class="p-3 text-center">
                                <a href="/{{ $prefix }}/kk-katolik/{{ $kk->id }}/view" wire:navigate class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-amber-50 dark:bg-amber-950/60 text-amber-700 dark:text-amber-300 border border-amber-200 dark:border-amber-800 hover:bg-amber-100 transition-colors">
                                    <i class="bi bi-people text-[11px]"></i>
                                    {{ $kk->anggota_count }} Jiwa
                                </a>
                            </td>
                            <td class="p-3 text-center">
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-semibold {{ $kk->status_kk === 'Aktif' ? 'bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-700' }}">
                                    <span class="h-1.5 w-1.5 rounded-full {{ $kk->status_kk === 'Aktif' ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                    {{ $kk->status_kk ?: 'Aktif' }}
                                </span>
                            </td>
                            <td class="p-3 text-right pr-4">
                                <div class="inline-flex items-center justify-end gap-1">
                                    <a href="/{{ $prefix }}/kk-katolik/{{ $kk->id }}/view" wire:navigate title="Lihat Kartu KK & Anggota" class="w-8 h-8 rounded-lg text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-slate-800 flex items-center justify-center transition-colors cursor-pointer">
                                        <i class="bi bi-eye text-sm"></i>
                                    </a>
                                    <a href="/{{ $prefix }}/kk-katolik/{{ $kk->id }}/pdf" target="_blank" title="Cetak PDF Kartu KK" class="w-8 h-8 rounded-lg text-slate-500 hover:text-emerald-600 hover:bg-emerald-50 dark:hover:bg-slate-800 flex items-center justify-center transition-colors cursor-pointer">
                                        <i class="bi bi-printer text-sm"></i>
                                    </a>
                                    <a href="/{{ $prefix }}/kk-katolik/{{ $kk->id }}/edit" wire:navigate title="Edit KK" class="w-8 h-8 rounded-lg text-slate-500 hover:text-amber-600 hover:bg-amber-50 dark:hover:bg-slate-800 flex items-center justify-center transition-colors cursor-pointer">
                                        <i class="bi bi-pencil text-sm"></i>
                                    </a>
                                    <button wire:click="confirmDelete({{ $kk->id }})" title="Hapus KK" class="w-8 h-8 rounded-lg text-slate-500 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-slate-800 flex items-center justify-center transition-colors cursor-pointer">
                                        <i class="bi bi-trash text-sm"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="p-12 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <div class="h-12 w-12 rounded-2xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-400">
                                        <i class="bi bi-house text-2xl"></i>
                                    </div>
                                    <p class="text-sm font-bold text-slate-700 dark:text-slate-300">Tidak ada data Kartu Keluarga</p>
                                    <p class="text-xs text-slate-400">Silakan ubah filter atau klik tombol "Tambah KK Baru".</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($kks->hasPages())
            <div class="p-4 border-t border-slate-200/80 dark:border-slate-800 bg-slate-50/70 dark:bg-slate-950/50">
                {{ $kks->links() }}
            </div>
        @endif
    </div>

    {{-- MODAL HAPUS KONFIRMASI --}}
    @if($showDeleteModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm animate-fadeIn">
            <div class="relative w-full max-w-md rounded-2xl border border-rose-500/30 bg-slate-900 p-6 shadow-2xl">
                <div class="text-center">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-rose-500/20 text-rose-400 border border-rose-500/30 mb-4">
                        <i class="fa-solid fa-triangle-exclamation text-2xl"></i>
                    </div>
                    <h3 class="font-outfit text-lg font-bold text-white">Hapus Kartu Keluarga</h3>
                    <p class="font-sans text-xs text-slate-400 mt-2">
                        @if($isBulkDelete)
                            Apakah Anda yakin ingin menghapus <strong>{{ count($selectedIds) }} Kartu Keluarga</strong> yang dipilih?
                        @else
                            Apakah Anda yakin ingin menghapus Kartu Keluarga ini?
                        @endif
                        Data anggota keluarga yang tertaut akan kehilangan referensi KK.
                    </p>
                </div>

                <div class="mt-6 flex items-center justify-center gap-3">
                    <button wire:click="$set('showDeleteModal', false)" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-300 bg-slate-800 hover:bg-slate-700 transition-all font-outfit">
                        Batal
                    </button>
                    <button wire:click="delete" class="px-5 py-2 rounded-xl text-xs font-bold text-white bg-rose-600 hover:bg-rose-500 transition-all shadow-md font-outfit">
                        Ya, Hapus Sekarang
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
