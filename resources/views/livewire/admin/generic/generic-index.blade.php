<div class="space-y-6">
    {{-- Header Banner --}}
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-amber-800 via-amber-900 to-slate-900 p-6 shadow-xl border border-amber-600/40 text-white">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <div class="flex items-center gap-3">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white/10 text-amber-300 border border-white/20 shadow-inner">
                        <i class="fa-solid {{ $config['icon'] ?? 'fa-folder' }} text-xl"></i>
                    </div>
                    <div>
                        <h1 class="font-heading text-2xl font-extrabold tracking-tight text-white flex items-center gap-3">
                            {{ $config['title'] ?? 'Data ' . ucfirst($slug) }}
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-400 text-slate-950 shadow-xs font-heading">
                                {{ number_format($records->total(), 0, ',', '.') }} Total Data
                            </span>
                        </h1>
                        <p class="font-sans text-xs text-amber-100/90 mt-1 font-medium">
                            Kelola direktori dan data gerejawi dengan pembaruan instan, validasi terstandar, dan pencarian cepat.
                        </p>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                @if(!empty($selectedIds))
                    <button wire:click="confirmBulkDelete" class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-bold text-white bg-rose-600 hover:bg-rose-700 transition-all shadow-md active:scale-95 font-heading">
                        <i class="fa-solid fa-trash-can"></i>
                        Hapus Terpilih ({{ count($selectedIds) }})
                    </button>
                @endif

                <button wire:click="openCreateModal" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold text-slate-950 bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-300 hover:to-amber-400 transition-all shadow-md active:scale-95 font-heading">
                    <i class="fa-solid fa-plus text-sm"></i>
                    Tambah Data Baru
                </button>
            </div>
        </div>
    </div>

    {{-- Flash Notifications --}}
    @if(session()->has('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" class="rounded-xl border border-emerald-300 dark:border-emerald-800 bg-emerald-50 dark:bg-emerald-950/60 p-4 text-emerald-800 dark:text-emerald-200 flex items-center justify-between text-sm shadow-xs font-sans font-semibold">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-circle-check text-emerald-600 dark:text-emerald-400 text-lg"></i>
                <span>{{ session('success') }}</span>
            </div>
            <button @click="show = false" class="text-emerald-600 dark:text-emerald-400 hover:opacity-80">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    @endif

    @if(session()->has('error'))
        <div x-data="{ show: true }" x-show="show" class="rounded-xl border border-rose-300 dark:border-rose-800 bg-rose-50 dark:bg-rose-950/60 p-4 text-rose-800 dark:text-rose-200 flex items-center justify-between text-sm shadow-xs font-sans font-semibold">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-triangle-exclamation text-rose-600 dark:text-rose-400 text-lg"></i>
                <span>{{ session('error') }}</span>
            </div>
            <button @click="show = false" class="text-rose-600 dark:text-rose-400 hover:opacity-80">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    @endif

    {{-- Main Filter & Table Card (Matching bimkatlaravel12 datatable spec) --}}
    <div class="rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-xs overflow-hidden admin-table-wrap">
        {{-- Toolbar / Filter Bar --}}
        <div class="p-4 border-b border-slate-200/80 dark:border-slate-800 bg-slate-50/70 dark:bg-slate-950/50 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex flex-1 items-center gap-3 max-w-md">
                <div class="relative w-full">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 pointer-events-none">
                        <i class="bi bi-search text-xs"></i>
                    </span>
                    <input 
                        type="search" 
                        wire:model.live.debounce.300ms="search" 
                        placeholder="Cari data {{ strtolower($config['title']) }}..."
                        class="w-full pl-10 pr-4 py-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white placeholder-slate-400 font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all font-sans"
                    >
                </div>
            </div>

            <div class="flex items-center gap-3 justify-end">
                <div class="flex items-center gap-2 text-xs text-slate-600 dark:text-slate-400 font-medium font-sans">
                    <span>Tampil:</span>
                    <select wire:model.live="perPage" class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl px-2.5 py-1.5 text-xs text-slate-800 dark:text-slate-200 font-semibold focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs font-sans border-collapse">
                <thead class="bg-slate-50/90 dark:bg-slate-950 text-[11px] font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 border-b border-slate-200/80 dark:border-slate-800 whitespace-nowrap">
                    <tr>
                        <th class="p-3 w-10 text-center">
                            <input type="checkbox" wire:model.live="selectAll" class="rounded border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-indigo-600 focus:ring-indigo-500/30">
                        </th>
                        <th class="p-3 w-12 text-center text-slate-500 dark:text-slate-400">No</th>
                        @foreach($config['columns'] as $col)
                            <th class="p-3 cursor-pointer hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors" wire:click="sortBy('{{ $col['key'] }}')">
                                <div class="flex items-center gap-1.5">
                                    <span>{{ $col['label'] }}</span>
                                    @if($sortField === $col['key'])
                                        <i class="bi {{ $sortDirection === 'asc' ? 'bi-sort-up text-indigo-600' : 'bi-sort-down text-indigo-600' }}"></i>
                                    @endif
                                </div>
                            </th>
                        @endforeach
                        <th class="p-3 text-right pr-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800 font-normal">
                    @forelse($records as $index => $record)
                        @php
                            $recordId = (string) $record->getKey();
                        @endphp
                        <tr class="hover:bg-amber-50/70 dark:hover:bg-slate-800/60 transition-colors {{ in_array($recordId, $selectedIds) ? 'bg-amber-100/60 dark:bg-amber-950/40' : '' }}">
                            <td class="p-3 text-center">
                                <input type="checkbox" wire:model.live="selectedIds" value="{{ $recordId }}" class="rounded border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-amber-600 focus:ring-amber-500/30">
                            </td>
                            <td class="p-3 text-center text-slate-700 dark:text-slate-300 font-bold">
                                {{ $records->firstItem() + $index }}
                            </td>
                            @foreach($config['columns'] as $col)
                                <td class="p-3 align-middle">
                                    @php
                                        $key = $col['key'];
                                        $val = $record->$key ?? null;
                                        if ($val === null && !empty($col['altKey'])) {
                                            $alt = $col['altKey'];
                                            $val = $record->$alt ?? null;
                                        }
                                        if (!empty($col['relation']) && $record->relationLoaded($col['relation'])) {
                                            $rel = $record->{$col['relation']};
                                            if ($rel instanceof \Illuminate\Support\Collection) {
                                                $val = $rel->count();
                                            } elseif (is_object($rel)) {
                                                $relKey = $col['relationKey'] ?? 'nama';
                                                $val = $rel->$relKey ?? null;
                                            }
                                        }
                                    @endphp

                                    @if(!empty($col['isImage']))
                                        @php
                                            $fallbackImg = '/images/church-logo.png';
                                            if ($slug === 'keuskupan') {
                                                $fallbackImg = '/images/logo-keuskupan.png';
                                            } elseif ($slug === 'paroki') {
                                                $fallbackImg = '/images/logo-paroki.png';
                                            }
                                        @endphp
                                        <div class="h-11 w-11 rounded-xl bg-white p-1 border-2 border-slate-200 dark:border-slate-700 shadow-xs flex items-center justify-center overflow-hidden shrink-0">
                                            <img src="{{ siparoki_asset($val, $fallbackImg) }}" class="w-full h-full object-contain" alt="{{ $col['label'] ?? 'Foto' }}" onerror="this.src='{{ $fallbackImg }}'">
                                        </div>
                                    @elseif(!empty($col['isRelationLink']))
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-amber-100 dark:bg-amber-950/70 text-amber-950 dark:text-amber-200 border border-amber-300 dark:border-amber-700 shadow-xs">
                                            <i class="fa-solid {{ $col['icon'] ?? 'fa-link' }} text-[10px]"></i>
                                            {{ $val ?? 0 }} Data
                                        </span>
                                    @elseif(in_array($key, ['status', 'status_aktif', 'status_publish', 'status_approval'], true))
                                        <button wire:click="toggleStatus('{{ $recordId }}', '{{ $key }}')" class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[11px] font-bold transition-all {{ in_array(strtolower((string)$val), ['1', 'aktif', 'published', 'disetujui'], true) ? 'bg-emerald-100 text-emerald-950 dark:bg-emerald-950/80 dark:text-emerald-200 border border-emerald-400 dark:border-emerald-700' : 'bg-slate-200 text-slate-800 dark:bg-slate-800 dark:text-slate-200 border border-slate-300 dark:border-slate-700' }}">
                                            <span class="h-2 w-2 rounded-full {{ in_array(strtolower((string)$val), ['1', 'aktif', 'published', 'disetujui'], true) ? 'bg-emerald-600 dark:bg-emerald-400 animate-pulse' : 'bg-slate-500' }}"></span>
                                            {{ $val ? (is_numeric($val) ? ($val ? 'Aktif' : 'Nonaktif') : ucfirst($val)) : 'Draft' }}
                                        </button>
                                    @elseif(!empty($col['isPrimary']))
                                        <span class="font-extrabold text-slate-900 dark:text-white font-heading text-sm hover:text-amber-600 dark:hover:text-amber-400 transition-colors">
                                            {{ $val ?? '-' }}
                                        </span>
                                    @elseif(!empty($col['isDate']))
                                        <span class="font-mono text-slate-700 dark:text-slate-300 font-bold text-xs">
                                            {{ $val ? \Carbon\Carbon::parse($val)->format('d M Y') : '-' }}
                                        </span>
                                    @else
                                        <span class="text-slate-800 dark:text-slate-200 font-semibold text-xs">
                                            {{ is_string($val) ? Str::limit($val, 50) : ($val ?? '-') }}
                                        </span>
                                    @endif
                                </td>
                            @endforeach
                            <td class="p-3 text-right pr-4">
                                <div class="inline-flex items-center gap-1 justify-end">
                                    <button wire:click="viewDetail('{{ $recordId }}')" class="w-8 h-8 rounded-lg text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-slate-800 flex items-center justify-center transition-colors cursor-pointer" title="Lihat Detail">
                                        <i class="bi bi-eye text-sm"></i>
                                    </button>
                                    <button wire:click="openEditModal('{{ $recordId }}')" class="w-8 h-8 rounded-lg text-slate-500 hover:text-amber-600 hover:bg-amber-50 dark:hover:bg-slate-800 flex items-center justify-center transition-colors cursor-pointer" title="Edit Data">
                                        <i class="bi bi-pencil text-sm"></i>
                                    </button>
                                    <button wire:click="confirmDelete('{{ $recordId }}')" class="w-8 h-8 rounded-lg text-slate-500 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-slate-800 flex items-center justify-center transition-colors cursor-pointer" title="Hapus Data">
                                        <i class="bi bi-trash text-sm"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ count($config['columns']) + 3 }}" class="p-12 text-center text-slate-500 dark:text-slate-400">
                                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-400 mb-3">
                                    <i class="fa-solid {{ $config['icon'] ?? 'fa-folder-open' }} text-2xl"></i>
                                </div>
                                <p class="text-sm font-bold text-slate-800 dark:text-slate-200 font-heading">Belum ada data {{ strtolower($config['title']) }}.</p>
                                <p class="text-xs text-slate-500 mt-1">Gunakan tombol "Tambah Data Baru" di atas untuk menambahkan data.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($records->hasPages())
            <div class="p-4 border-t border-slate-200 dark:border-slate-800 bg-slate-50/70 dark:bg-slate-950/50 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-600 dark:text-slate-400 font-medium">
                <div>
                    Menampilkan <span class="font-bold text-slate-900 dark:text-white">{{ $records->firstItem() }}</span> sampai <span class="font-bold text-slate-900 dark:text-white">{{ $records->lastItem() }}</span> dari <span class="font-bold text-slate-900 dark:text-white">{{ $records->total() }}</span> data
                </div>
                <div>
                    {{ $records->links() }}
                </div>
            </div>
        @endif
    </div>

    {{-- MODAL TAMBAH / EDIT --}}
    @if($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs animate-fadeIn">
            <div class="relative w-full max-w-2xl rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 p-6 shadow-2xl overflow-y-auto max-h-[90vh]">
                <div class="flex items-center justify-between border-b border-slate-200 dark:border-slate-800 pb-4 mb-4">
                    <h3 class="font-heading text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                        <i class="fa-solid {{ $isEdit ? 'fa-pen-to-square text-amber-500' : 'fa-plus text-amber-500' }}"></i>
                        {{ $isEdit ? 'Edit ' . $config['title'] : 'Tambah ' . $config['title'] }}
                    </h3>
                    <button wire:click="$set('showModal', false)" class="text-slate-400 hover:text-slate-700 dark:hover:text-white p-1">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <form wire:submit="save" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($formData as $key => $val)
                            @if(in_array($key, ['id', 'created_at', 'updated_at', 'deleted_at'], true))
                                @continue
                            @endif

                            <div class="space-y-1.5 {{ in_array($key, ['alamat', 'keterangan', 'deskripsi', 'notulen'], true) ? 'md:col-span-2' : '' }}">
                                <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 font-heading capitalize">
                                    {{ str_replace('_', ' ', $key) }}
                                </label>

                                @if(isset($selectOptions[$key]))
                                    {{-- Use Tom Select component for foreign keys --}}
                                    <x-tom-select 
                                        wire:model="formData.{{ $key }}"
                                        placeholder="-- Pilih {{ ucwords(str_replace(['_id', '_'], ['', ' '], $key)) }} --"
                                    >
                                        <option value="">-- Pilih --</option>
                                        @foreach($selectOptions[$key] as $opt)
                                            <option value="{{ $opt['id'] }}">{{ $opt['name'] }}</option>
                                        @endforeach
                                    </x-tom-select>
                                @elseif(in_array($key, ['alamat', 'keterangan', 'deskripsi', 'notulen'], true))
                                    <textarea 
                                        wire:model="formData.{{ $key }}" 
                                        rows="3" 
                                        class="w-full px-3 py-2 bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 font-sans font-medium"
                                    ></textarea>
                                @elseif(str_contains($key, 'tanggal') || str_contains($key, 'tgl'))
                                    <input 
                                        type="date" 
                                        wire:model="formData.{{ $key }}" 
                                        class="w-full px-3 py-2 bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 font-sans font-medium"
                                    >
                                @elseif(in_array($key, ['urutan', 'jumlah', 'stok', 'nominal', 'biaya_administrasi'], true))
                                    <input 
                                        type="number" 
                                        wire:model="formData.{{ $key }}" 
                                        class="w-full px-3 py-2 bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 font-sans font-medium"
                                    >
                                @else
                                    <input 
                                        type="text" 
                                        wire:model="formData.{{ $key }}" 
                                        class="w-full px-3 py-2 bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 font-sans font-medium"
                                    >
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-200 dark:border-slate-800">
                        <button type="button" wire:click="$set('showModal', false)" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all font-heading">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2 rounded-xl text-xs font-bold text-slate-950 bg-linear-to-r from-amber-400 to-amber-500 hover:from-amber-300 hover:to-amber-400 transition-all shadow-md font-heading">
                            {{ $isEdit ? 'Simpan Perubahan' : 'Simpan Data' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- MODAL DETAIL --}}
    @if($showDetailModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs animate-fadeIn">
            <div class="relative w-full max-w-lg rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 p-6 shadow-2xl">
                <div class="flex items-center justify-between border-b border-slate-200 dark:border-slate-800 pb-3 mb-4">
                    <h3 class="font-heading text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
                        <i class="fa-solid fa-circle-info text-amber-500"></i>
                        Detail {{ $config['title'] }}
                    </h3>
                    <button wire:click="$set('showDetailModal', false)" class="text-slate-400 hover:text-slate-700 dark:hover:text-white p-1">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <div class="space-y-2.5 max-h-[70vh] overflow-y-auto pr-2 text-xs font-sans divide-y divide-slate-100 dark:divide-slate-800/60">
                    @foreach($detailItem as $k => $v)
                        @if(in_array($k, ['created_at', 'updated_at', 'deleted_at'], true))
                            @continue
                        @endif
                        <div class="pt-2 flex justify-between gap-4">
                            <span class="text-slate-500 dark:text-slate-400 font-bold capitalize font-heading">{{ str_replace('_', ' ', $k) }}:</span>
                            <span class="text-slate-900 dark:text-white text-right font-medium">
                                @if(str_contains(strtolower($k), 'logo') || str_contains(strtolower($k), 'foto') || str_contains(strtolower($k), 'gambar'))
                                    <img src="{{ siparoki_asset($v, '/images/church-logo.png') }}" class="h-12 w-12 object-contain rounded-lg border border-slate-200 dark:border-slate-700 bg-white p-1 inline-block" onerror="this.src='/images/church-logo.png'">
                                @else
                                    {{ is_array($v) ? json_encode($v) : ($v ?: '-') }}
                                @endif
                            </span>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6 flex justify-end">
                    <button wire:click="$set('showDetailModal', false)" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 transition-all font-heading">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- MODAL HAPUS KONFIRMASI --}}
    @if($showDeleteModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs animate-fadeIn">
            <div class="relative w-full max-w-md rounded-2xl border border-rose-300 dark:border-rose-800 bg-white dark:bg-slate-900 p-6 shadow-2xl">
                <div class="text-center">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-rose-100 dark:bg-rose-950/60 text-rose-600 dark:text-rose-400 border border-rose-200 dark:border-rose-800 mb-4">
                        <i class="fa-solid fa-triangle-exclamation text-2xl"></i>
                    </div>
                    <h3 class="font-heading text-lg font-bold text-slate-900 dark:text-white">Konfirmasi Penghapusan</h3>
                    <p class="font-sans text-xs text-slate-600 dark:text-slate-300 mt-2 font-medium">
                        @if($isBulkDelete)
                            Apakah Anda yakin ingin menghapus <strong>{{ count($selectedIds) }} data</strong> yang dipilih? Tindakan ini tidak dapat dibatalkan.
                        @else
                            Apakah Anda yakin ingin menghapus data ini secara permanen?
                        @endif
                    </p>
                </div>

                <div class="mt-6 flex items-center justify-center gap-3">
                    <button wire:click="$set('showDeleteModal', false)" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-700 dark:text-slate-300 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 transition-all font-heading">
                        Batal
                    </button>
                    <button wire:click="delete" class="px-5 py-2 rounded-xl text-xs font-bold text-white bg-rose-600 hover:bg-rose-700 transition-all shadow-md font-heading">
                        Ya, Hapus Sekarang
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
