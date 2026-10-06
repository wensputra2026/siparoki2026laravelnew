<div>
    @php
        $currentPrefix = explode('/', trim(request()->path(), '/'))[0] ?? 'admin';
        if (!in_array($currentPrefix, ['admin', 'superadmin', 'paroki', 'pastor', 'wilayah', 'kapela', 'kub', 'bendahara', 'penulis', 'umat'])) {
            $currentPrefix = 'admin';
        }
    @endphp

    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center">
                    <i class="fa-solid fa-users text-lg"></i>
                </div>
                <span>Data Umat Paroki</span>
            </h1>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                Kelola sensus seluruh umat, status inisiasi sakramen, dan mutasi domisili paroki.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2.5">
            <a href="{{ url("/{$currentPrefix}/umat/create") }}" wire:navigate
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white font-semibold text-xs shadow-md shadow-amber-500/20 transition-all duration-200 active:scale-95">
                <i class="fa-solid fa-user-plus text-sm"></i>
                <span>Tambah Umat Baru</span>
            </a>
        </div>
    </div>

    <!-- Filter Card with Tom Select v2.3.1 -->
    <div class="p-5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800/80 shadow-xs mb-6 space-y-4">
        
        <!-- Search & Quick Reset -->
        <div class="flex flex-col sm:flex-row gap-3 items-center justify-between">
            <div class="relative w-full sm:w-96">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </div>
                <input
                    type="text"
                    wire:model.live.debounce.350ms="search"
                    placeholder="Cari nama, NIK, nama baptis, atau telepon..."
                    class="w-full pl-9 pr-8 py-2 rounded-xl text-xs bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-slate-100 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-transparent transition-all"
                >
                @if($search)
                    <button wire:click="$set('search', '')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600">
                        <i class="fa-solid fa-circle-xmark text-xs"></i>
                    </button>
                @endif
            </div>

            <div class="flex items-center gap-2 w-full sm:w-auto justify-end">
                <button wire:click="resetFilters"
                    class="px-3 py-2 rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 border border-slate-200 dark:border-slate-700 transition-colors flex items-center gap-1.5"
                    title="Reset semua filter pencarian">
                    <i class="fa-solid fa-rotate-left text-xs"></i>
                    <span>Reset Filter</span>
                </button>
            </div>
        </div>

        <!-- Tom Select Dropdown Filters Row -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-3 pt-3 border-t border-slate-100 dark:border-slate-800/60">
            
            <!-- Tom Select: Kapela / Stasi -->
            <div>
                <label class="block text-[11px] font-semibold text-slate-500 dark:text-slate-400 mb-1">Kapela / Stasi</label>
                <x-tom-select wire:model.live="filterKapela" placeholder="Semua Kapela / Stasi">
                    @foreach($kapelas as $k)
                        <option value="{{ $k->id }}">{{ $k->nama_kapela }}</option>
                    @endforeach
                </x-tom-select>
            </div>

            <!-- Tom Select: Wilayah -->
            <div>
                <label class="block text-[11px] font-semibold text-slate-500 dark:text-slate-400 mb-1">Wilayah Rohani</label>
                <x-tom-select wire:model.live="filterWilayah" placeholder="Semua Wilayah">
                    @foreach($wilayahs as $w)
                        <option value="{{ $w->id }}">{{ $w->nama_wilayah }}</option>
                    @endforeach
                </x-tom-select>
            </div>

            <!-- Tom Select: KUB -->
            <div>
                <label class="block text-[11px] font-semibold text-slate-500 dark:text-slate-400 mb-1">Komunitas Basis (KUB)</label>
                <x-tom-select wire:model.live="filterKub" placeholder="Semua KUB">
                    @foreach($kubs as $kub)
                        <option value="{{ $kub->id }}">{{ $kub->nama_kub }}</option>
                    @endforeach
                </x-tom-select>
            </div>

            <!-- Tom Select: Jenis Kelamin -->
            <div>
                <label class="block text-[11px] font-semibold text-slate-500 dark:text-slate-400 mb-1">Jenis Kelamin</label>
                <x-tom-select wire:model.live="filterGender" placeholder="Semua Gender">
                    <option value="L">Laki-laki</option>
                    <option value="P">Perempuan</option>
                </x-tom-select>
            </div>

            <!-- Tom Select: Status Baptis -->
            <div>
                <label class="block text-[11px] font-semibold text-slate-500 dark:text-slate-400 mb-1">Status Baptis</label>
                <x-tom-select wire:model.live="filterBaptis" placeholder="Semua Status Baptis">
                    <option value="sudah">Sudah Dibaptis</option>
                    <option value="belum">Belum Dibaptis</option>
                </x-tom-select>
            </div>

        </div>

    </div>

    <!-- Data Table Card -->
    <!-- Data Table Card (Matching bimkatlaravel12 datatable spec) -->
    <div class="rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800/80 shadow-xs overflow-hidden admin-table-wrap">
        
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-50/90 dark:bg-slate-800/60 border-b border-slate-200/80 dark:border-slate-800 text-slate-500 dark:text-slate-400 font-bold uppercase text-[11px] tracking-wider select-none whitespace-nowrap">
                        <th class="py-3.5 px-4 w-12 text-center">No</th>
                        <th class="py-3.5 px-4 cursor-pointer hover:text-indigo-600 dark:hover:text-indigo-400" wire:click="sortBy('nama_lengkap')">
                            <div class="flex items-center gap-1.5">
                                <span>Nama Lengkap & Baptis</span>
                                @if($sortField === 'nama_lengkap')
                                    <i class="bi {{ $sortAsc ? 'bi-sort-up text-indigo-600' : 'bi-sort-down text-indigo-600' }}"></i>
                                @endif
                            </div>
                        </th>
                        <th class="py-3.5 px-4">L/P & Usia</th>
                        <th class="py-3.5 px-4">Keluarga (KK)</th>
                        <th class="py-3.5 px-4">Domisili (KUB / Wilayah)</th>
                        <th class="py-3.5 px-4 text-center">Inisiasi Sakramen</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60">
                    @forelse ($umats as $index => $u)
                        <tr class="hover:bg-amber-50/30 dark:hover:bg-slate-800/40 transition-colors">
                            <td class="py-3.5 px-4 text-center text-slate-400 font-mono text-[11px]">
                                {{ $umats->firstItem() + $index }}
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-amber-500/10 text-amber-600 dark:text-amber-400 font-bold flex items-center justify-center shrink-0">
                                        {{ strtoupper(substr($u->nama_lengkap ?? 'U', 0, 1)) }}
                                    </div>
                                    <div>
                                        <button wire:click="viewDetail({{ $u->id }})" class="font-semibold text-slate-800 dark:text-slate-100 hover:text-amber-600 dark:hover:text-amber-400 text-left transition-colors">
                                            {{ $u->nama_lengkap }}
                                        </button>
                                        @if($u->nama_baptis)
                                            <div class="text-[11px] text-amber-600 dark:text-amber-400 font-medium">
                                                <i class="fa-solid fa-cross text-[9px] mr-0.5"></i> {{ $u->nama_baptis }}
                                            </div>
                                        @endif
                                        <div class="text-[10px] text-slate-400 font-mono">
                                            NIK: {{ $u->nik ? substr($u->nik, 0, 6) . '******' : '-' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-1.5">
                                    @if ($u->jenis_kelamin === 'L')
                                        <span class="px-2 py-0.5 rounded-md font-semibold text-[10px] bg-blue-50 text-blue-600 dark:bg-blue-950/50 dark:text-blue-400 border border-blue-200/50 dark:border-blue-900/50">L</span>
                                    @else
                                        <span class="px-2 py-0.5 rounded-md font-semibold text-[10px] bg-pink-50 text-pink-600 dark:bg-pink-950/50 dark:text-pink-400 border border-pink-200/50 dark:border-pink-900/50">P</span>
                                    @endif
                                    <span class="text-slate-600 dark:text-slate-300 font-medium text-xs">
                                        {{ $u->usia ? $u->usia . ' thn' : '-' }}
                                    </span>
                                </div>
                            </td>
                            <td class="py-3.5 px-4 text-slate-600 dark:text-slate-300">
                                @if($u->kk)
                                    <div class="font-medium text-slate-800 dark:text-slate-200">{{ $u->kk->nama_lahir_pemilik ?? $u->kk->nama_baptis_pemilik ?? 'Keluarga' }}</div>
                                    <div class="text-[10px] text-slate-400 font-mono">{{ $u->kk->no_kk_kw ?? '-' }}</div>
                                @else
                                    <span class="text-slate-400 italic">Belum terhubung KK</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-slate-600 dark:text-slate-300">
                                <div class="font-medium">{{ $u->kub->nama_kub ?? '-' }}</div>
                                <div class="text-[10px] text-slate-400">{{ $u->wilayah->nama_wilayah ?? $u->kapela->nama_kapela ?? '-' }}</div>
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="flex items-center justify-center gap-1">
                                    <!-- Baptis -->
                                    <span class="px-1.5 py-0.5 rounded text-[10px] font-bold {{ $u->tgl_baptis || $u->status_baptis === 'Sudah' ? 'bg-amber-100 text-amber-800 dark:bg-amber-900/50 dark:text-amber-300' : 'bg-slate-100 text-slate-400 dark:bg-slate-800' }}" title="Sakramen Baptis">
                                        B
                                    </span>
                                    <!-- Komuni -->
                                    <span class="px-1.5 py-0.5 rounded text-[10px] font-bold {{ $u->tgl_komuni_1 ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/50 dark:text-emerald-300' : 'bg-slate-100 text-slate-400 dark:bg-slate-800' }}" title="Komuni Pertama">
                                        K
                                    </span>
                                    <!-- Krisma -->
                                    <span class="px-1.5 py-0.5 rounded text-[10px] font-bold {{ $u->tgl_krisma ? 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900/50 dark:text-indigo-300' : 'bg-slate-100 text-slate-400 dark:bg-slate-800' }}" title="Sakramen Krisma">
                                        R
                                    </span>
                                </div>
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <div class="inline-flex items-center gap-1 justify-end">
                                    <button wire:click="viewDetail({{ $u->id }})" class="w-8 h-8 rounded-lg text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-slate-800 flex items-center justify-center transition-colors cursor-pointer" title="Lihat Detail">
                                        <i class="bi bi-eye text-sm"></i>
                                    </button>
                                    <a href="{{ url("/{$currentPrefix}/umat/{$u->id}/edit") }}" wire:navigate class="w-8 h-8 rounded-lg text-slate-500 hover:text-amber-600 hover:bg-amber-50 dark:hover:bg-slate-800 inline-flex items-center justify-center transition-colors cursor-pointer" title="Edit Umat">
                                        <i class="bi bi-pencil text-sm"></i>
                                    </a>
                                    <button wire:click="confirmDelete({{ $u->id }}, '{{ addslashes($u->nama_lengkap) }}')" class="w-8 h-8 rounded-lg text-slate-500 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-slate-800 flex items-center justify-center transition-colors cursor-pointer" title="Hapus Umat">
                                        <i class="bi bi-trash text-sm"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <i class="fa-solid fa-users-slash text-3xl opacity-40"></i>
                                    <p class="font-medium text-sm">Tidak ada data umat yang sesuai dengan kriteria.</p>
                                    @if($search || $filterWilayah || $filterKub || $filterKapela || $filterGender || $filterBaptis)
                                        <button wire:click="resetFilters" class="text-xs text-amber-600 font-semibold hover:underline">
                                            Reset Filter Pencarian
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Table Footer / Pagination -->
        @if ($umats->hasPages())
            <div class="px-5 py-4 border-t border-slate-200/80 dark:border-slate-800/80 bg-slate-50/50 dark:bg-slate-900/50 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500 dark:text-slate-400">
                <div>
                    Menampilkan <span class="font-semibold text-slate-700 dark:text-slate-200">{{ $umats->firstItem() }}</span> sampai <span class="font-semibold text-slate-700 dark:text-slate-200">{{ $umats->lastItem() }}</span> dari <span class="font-semibold text-slate-700 dark:text-slate-200">{{ $umats->total() }}</span> data
                </div>
                <div>
                    {{ $umats->links() }}
                </div>
            </div>
        @endif

    </div>

    <!-- Modal Detail Umat (Alpine.js Controlled) -->
    @if ($showDetailModal && $selectedUmat)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" wire:click="closeDetailModal"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white dark:bg-slate-900 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-slate-200 dark:border-slate-800">
                    
                    <!-- Modal Header -->
                    <div class="p-6 bg-gradient-to-r from-amber-500 to-amber-600 text-white flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl bg-white/20 backdrop-blur-md flex items-center justify-center text-xl font-bold">
                                {{ strtoupper(substr($selectedUmat->nama_lengkap, 0, 1)) }}
                            </div>
                            <div>
                                <h3 class="text-lg font-bold">{{ $selectedUmat->nama_lengkap }}</h3>
                                <p class="text-xs text-amber-100 flex items-center gap-1.5">
                                    <i class="fa-solid fa-cross text-[10px]"></i>
                                    <span>{{ $selectedUmat->nama_baptis ?: 'Belum ada nama baptis' }}</span>
                                    <span>&bull;</span>
                                    <span>{{ $selectedUmat->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                                </p>
                            </div>
                        </div>
                        <button wire:click="closeDetailModal" class="text-white/80 hover:text-white p-2">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="p-6 space-y-6 max-h-[70vh] overflow-y-auto text-xs">

                        <!-- Data Pribadi -->
                        <div>
                            <h4 class="font-bold text-xs uppercase tracking-wider text-slate-400 dark:text-slate-500 mb-3 flex items-center gap-1.5">
                                <i class="fa-solid fa-id-card text-amber-500"></i> Identitas Pribadi
                            </h4>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 p-4 rounded-xl bg-slate-50 dark:bg-slate-800/40 border border-slate-100 dark:border-slate-800">
                                <div>
                                    <p class="text-slate-400">NIK</p>
                                    <p class="font-semibold text-slate-800 dark:text-slate-200 font-mono mt-0.5">{{ $selectedUmat->nik ?: '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-slate-400">Tempat, Tgl Lahir</p>
                                    <p class="font-semibold text-slate-800 dark:text-slate-200 mt-0.5">
                                        {{ $selectedUmat->tempat_lahir ?: '-' }}, {{ $selectedUmat->tanggal_lahir ? $selectedUmat->tanggal_lahir->format('d/m/Y') : '-' }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-slate-400">Usia</p>
                                    <p class="font-semibold text-slate-800 dark:text-slate-200 mt-0.5">{{ $selectedUmat->usia ? $selectedUmat->usia . ' Tahun' : '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-slate-400">Status Menikah</p>
                                    <p class="font-semibold text-slate-800 dark:text-slate-200 mt-0.5">{{ $selectedUmat->status_menikah ?: $selectedUmat->status_perkawinan ?: '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-slate-400">No. Telepon / HP</p>
                                    <p class="font-semibold text-slate-800 dark:text-slate-200 mt-0.5">{{ $selectedUmat->handphone ?: '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-slate-400">Pekerjaan</p>
                                    <p class="font-semibold text-slate-800 dark:text-slate-200 mt-0.5">{{ $selectedUmat->pekerjaan ?: '-' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Data Teritorial & Keluarga -->
                        <div>
                            <h4 class="font-bold text-xs uppercase tracking-wider text-slate-400 dark:text-slate-500 mb-3 flex items-center gap-1.5">
                                <i class="fa-solid fa-place-of-worship text-amber-500"></i> Teritorial & Keluarga
                            </h4>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 p-4 rounded-xl bg-slate-50 dark:bg-slate-800/40 border border-slate-100 dark:border-slate-800">
                                <div>
                                    <p class="text-slate-400">No. KK Katolik</p>
                                    <p class="font-semibold text-slate-800 dark:text-slate-200 font-mono mt-0.5">{{ $selectedUmat->kk->no_kk_kw ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-slate-400">Kepala Keluarga</p>
                                    <p class="font-semibold text-slate-800 dark:text-slate-200 mt-0.5">{{ $selectedUmat->kk->nama_lahir_pemilik ?? $selectedUmat->kk->nama_baptis_pemilik ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-slate-400">Hubungan Keluarga</p>
                                    <p class="font-semibold text-slate-800 dark:text-slate-200 mt-0.5">{{ $selectedUmat->hubungan_keluarga ?: '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-slate-400">Komunitas (KUB)</p>
                                    <p class="font-semibold text-slate-800 dark:text-slate-200 mt-0.5">{{ $selectedUmat->kub->nama_kub ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-slate-400">Wilayah</p>
                                    <p class="font-semibold text-slate-800 dark:text-slate-200 mt-0.5">{{ $selectedUmat->wilayah->nama_wilayah ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-slate-400">Kapela / Stasi</p>
                                    <p class="font-semibold text-slate-800 dark:text-slate-200 mt-0.5">{{ $selectedUmat->kapela->nama_kapela ?? '-' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Data Sakramen -->
                        <div>
                            <h4 class="font-bold text-xs uppercase tracking-wider text-slate-400 dark:text-slate-500 mb-3 flex items-center gap-1.5">
                                <i class="fa-solid fa-cross text-amber-500"></i> Sakramen Inisiasi & Perkawinan
                            </h4>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 p-4 rounded-xl bg-slate-50 dark:bg-slate-800/40 border border-slate-100 dark:border-slate-800">
                                <div>
                                    <p class="text-slate-400">Tanggal Baptis</p>
                                    <p class="font-semibold text-slate-800 dark:text-slate-200 mt-0.5">{{ $selectedUmat->tgl_baptis ? $selectedUmat->tgl_baptis->format('d/m/Y') : '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-slate-400">Paroki Baptis</p>
                                    <p class="font-semibold text-slate-800 dark:text-slate-200 mt-0.5">{{ $selectedUmat->paroki_baptis ?: '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-slate-400">No. Buku Baptis</p>
                                    <p class="font-semibold text-slate-800 dark:text-slate-200 font-mono mt-0.5">{{ $selectedUmat->buku_baptis_no ?: '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-slate-400">Komuni Pertama</p>
                                    <p class="font-semibold text-slate-800 dark:text-slate-200 mt-0.5">{{ $selectedUmat->tgl_komuni_1 ? $selectedUmat->tgl_komuni_1->format('d/m/Y') : '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-slate-400">Sakramen Krisma</p>
                                    <p class="font-semibold text-slate-800 dark:text-slate-200 mt-0.5">{{ $selectedUmat->tgl_krisma ? $selectedUmat->tgl_krisma->format('d/m/Y') : '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-slate-400">Sakramen Perkawinan</p>
                                    <p class="font-semibold text-slate-800 dark:text-slate-200 mt-0.5">{{ $selectedUmat->tgl_perkawinan ? $selectedUmat->tgl_perkawinan->format('d/m/Y') : '-' }}</p>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Modal Footer -->
                    <div class="p-4 bg-slate-50 dark:bg-slate-800/60 border-t border-slate-200 dark:border-slate-800 flex justify-end gap-2">
                        <a href="{{ url("/{$currentPrefix}/umat/{$selectedUmat->id}/edit") }}" wire:navigate
                            class="px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-semibold text-xs transition-colors">
                            Edit Umat
                        </a>
                        <button wire:click="closeDetailModal" class="px-4 py-2 rounded-xl bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-200 font-semibold text-xs hover:bg-slate-300 dark:hover:bg-slate-600 transition-colors">
                            Tutup
                        </button>
                    </div>

                </div>
            </div>
        </div>
    @endif

    <!-- Delete Confirmation Modal -->
    @if ($showDeleteModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" wire:click="$set('showDeleteModal', false)"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white dark:bg-slate-900 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full border border-slate-200 dark:border-slate-800 p-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl bg-rose-100 text-rose-600 dark:bg-rose-950/60 dark:text-rose-400 flex items-center justify-center text-xl shrink-0">
                            <i class="fa-solid fa-triangle-exclamation"></i>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-900 dark:text-white">Konfirmasi Hapus Data</h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                                Apakah Anda yakin ingin menghapus data umat <span class="font-bold text-slate-800 dark:text-slate-200">{{ $deleteName }}</span>?
                            </p>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end gap-2.5">
                        <button wire:click="$set('showDeleteModal', false)" class="px-4 py-2 rounded-xl text-xs font-semibold bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-slate-200 transition-colors">
                            Batal
                        </button>
                        <button wire:click="delete" class="px-4 py-2 rounded-xl text-xs font-semibold bg-rose-600 text-white hover:bg-rose-700 shadow-md shadow-rose-600/20 transition-colors">
                            Ya, Hapus Data
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
