<div class="space-y-6 font-sans">
    {{-- Header Banner --}}
    <div class="relative overflow-hidden rounded-2xl bg-white dark:bg-slate-900 p-6 shadow-xs border border-slate-200/80 dark:border-slate-800">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-500/20 shadow-xs">
                    <i class="bi bi-database text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white flex items-center gap-2">
                        Backup &amp; Restore Database
                    </h1>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                        Cadangkan struktur dan data MySQL secara berkala demi keamanan dan integritas arsip gereja.
                    </p>
                </div>
            </div>

            <div>
                <button wire:click="generateBackup" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold text-white bg-amber-500 hover:bg-amber-600 transition shadow-xs active:scale-95 cursor-pointer">
                    <i class="bi bi-cloud-arrow-down text-sm"></i>
                    Buat Cadangan Sekarang
                </button>
            </div>
        </div>
    </div>

    @if(session()->has('success'))
        <div class="rounded-xl border border-emerald-300 dark:border-emerald-700 bg-emerald-50 dark:bg-emerald-950/60 p-4 text-emerald-800 dark:text-emerald-200 text-xs flex items-center justify-between">
            <div class="flex items-center gap-3">
                <i class="bi bi-check-circle-fill text-base text-emerald-600 dark:text-emerald-400"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    {{-- Backup List Table --}}
    <div class="rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-xs overflow-hidden admin-table-wrap">
        <div class="p-4 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
            <h3 class="text-sm font-bold text-slate-900 dark:text-white flex items-center gap-2">
                <i class="bi bi-clock-history text-amber-500"></i>
                Riwayat Berkas Cadangan Tersimpan ({{ count($backups) }} Berkas)
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600 dark:text-slate-300">
                <thead class="bg-slate-50 dark:bg-slate-800/80 text-[11px] font-extrabold uppercase tracking-wider text-slate-500 dark:text-slate-400 border-b border-slate-200/80 dark:border-slate-800">
                    <tr>
                        <th class="p-3.5 w-12 text-center">No</th>
                        <th class="p-3.5">Nama Berkas SQL</th>
                        <th class="p-3.5">Ukuran File</th>
                        <th class="p-3.5">Dibuat Oleh</th>
                        <th class="p-3.5">Waktu Pembuatan</th>
                        <th class="p-3.5 text-right pr-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($backups as $index => $b)
                        <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-800/40 transition-colors">
                            <td class="p-3.5 text-center text-slate-400 font-medium">{{ $index + 1 }}</td>
                            <td class="p-3.5 font-mono font-bold text-amber-600 dark:text-amber-400">{{ $b->nama_file }}</td>
                            <td class="p-3.5 font-mono text-slate-600 dark:text-slate-300">
                                {{ number_format($b->ukuran / 1024, 1) }} KB
                            </td>
                            <td class="p-3.5 text-slate-700 dark:text-slate-300">{{ $b->dibuat_oleh ?? 'Administrator' }}</td>
                            <td class="p-3.5 text-slate-500 dark:text-slate-400">{{ \Carbon\Carbon::parse($b->created_at)->format('d M Y, H:i') }}</td>
                            <td class="p-3.5 text-right pr-4">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="/{{ $prefix }}/backup-database/download-direct?file={{ urlencode($b->nama_file) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold text-emerald-700 dark:text-emerald-300 bg-emerald-50 dark:bg-emerald-950/60 hover:bg-emerald-100 dark:hover:bg-emerald-900/60 transition border border-emerald-200 dark:border-emerald-800 cursor-pointer" title="Unduh Berkas">
                                        <i class="bi bi-download"></i>
                                        Unduh
                                    </a>
                                    <button wire:click="confirmDelete({{ $b->id }})" class="w-8 h-8 rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-slate-800 flex items-center justify-center transition cursor-pointer" title="Hapus Berkas">
                                        <i class="bi bi-trash text-sm"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-12 text-center text-slate-400">
                                Belum ada berkas cadangan database. Klik "Buat Cadangan Sekarang" untuk mencadangkan data.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- MODAL HAPUS KONFIRMASI --}}
    @if($showDeleteModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/60 backdrop-blur-xs animate-fadeIn">
            <div class="relative w-full max-w-md rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-6 shadow-2xl">
                <div class="text-center">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-rose-50 dark:bg-rose-950/60 text-rose-600 dark:text-rose-400 border border-rose-200 dark:border-rose-800 mb-4">
                        <i class="bi bi-exclamation-triangle text-2xl"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 dark:text-white">Hapus Berkas Cadangan</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-2">
                        Apakah Anda yakin ingin menghapus berkas cadangan SQL ini secara permanen dari server?
                    </p>
                </div>

                <div class="mt-6 flex items-center justify-center gap-3">
                    <button wire:click="$set('showDeleteModal', false)" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-700 dark:text-slate-300 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 transition cursor-pointer">
                        Batal
                    </button>
                    <button wire:click="delete" class="px-5 py-2 rounded-xl text-xs font-bold text-white bg-rose-600 hover:bg-rose-500 transition shadow-xs cursor-pointer">
                        Ya, Hapus
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
