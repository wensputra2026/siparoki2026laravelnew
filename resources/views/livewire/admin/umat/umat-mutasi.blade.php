<div>
    <!-- Header -->
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold font-heading text-slate-900 dark:text-white flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-amber-500/10 text-amber-600 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-arrows-split-up-and-left"></i>
                </div>
                <span>{{ $mode === 'pisah' ? 'Formulir Pisah Kartu Keluarga (KK)' : 'Formulir Mutasi & Pindah KK/KUB' }}</span>
            </h1>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                Proses pemindahan pencatatan data keanggotaan umat secara administratif antar keluarga dan KUB.
            </p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ url("/{$currentPrefix}/umat") }}" wire:navigate
                class="px-4 py-2 rounded-xl text-xs font-semibold bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700/60 shadow-xs inline-flex items-center gap-2 transition-all">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Kembali ke Umat</span>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left: Umat & Asal Info Card -->
        <div class="space-y-6">
            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200/80 dark:border-slate-700/80 shadow-xs p-5">
                <h3 class="text-sm font-bold font-heading text-slate-800 dark:text-slate-100 mb-4 pb-3 border-b border-slate-100 dark:border-slate-700/50 flex items-center gap-2">
                    <i class="fa-solid fa-user text-amber-500"></i>
                    <span>Informasi Umat</span>
                </h3>

                <div class="space-y-3.5 text-xs">
                    <div>
                        <span class="text-slate-400 block mb-0.5">Nama Lengkap & Baptis</span>
                        <p class="font-bold text-slate-800 dark:text-slate-100 text-sm font-heading">{{ $nama_lengkap }}</p>
                        @if($nama_baptis)
                            <p class="text-amber-600 dark:text-amber-400 font-medium">({{ $nama_baptis }})</p>
                        @endif
                    </div>
                    <div>
                        <span class="text-slate-400 block mb-0.5">Nomor Induk Kependudukan (NIK)</span>
                        <p class="font-mono font-semibold text-slate-700 dark:text-slate-200">{{ $nik ?: '-' }}</p>
                    </div>
                </div>

                <h3 class="text-sm font-bold font-heading text-slate-800 dark:text-slate-100 mt-6 mb-4 pb-3 border-b border-slate-100 dark:border-slate-700/50 flex items-center gap-2">
                    <i class="fa-solid fa-house-chimney-user text-blue-500"></i>
                    <span>Keluarga & Wilayah Asal</span>
                </h3>

                <div class="space-y-3 text-xs">
                    <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-900/60 border border-slate-100 dark:border-slate-700/40">
                        <span class="text-slate-400 text-[11px] block">Nomor KK Asal</span>
                        <span class="font-mono font-semibold text-slate-800 dark:text-slate-200">{{ $kk_asal_nomor }}</span>
                    </div>
                    <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-900/60 border border-slate-100 dark:border-slate-700/40">
                        <span class="text-slate-400 text-[11px] block">Kepala Keluarga Asal</span>
                        <span class="font-semibold text-slate-800 dark:text-slate-200">{{ $kk_asal_kepala }}</span>
                    </div>
                    <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-900/60 border border-slate-100 dark:border-slate-700/40">
                        <span class="text-slate-400 text-[11px] block">KUB & Wilayah Asal</span>
                        <span class="font-semibold text-slate-800 dark:text-slate-200">{{ $kub_asal_nama }} ({{ $wilayah_asal_nama }})</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Mutation Form Card -->
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200/80 dark:border-slate-700/80 shadow-xs p-6">
                <form wire:submit.prevent="simpanMutasi" class="space-y-5">
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5 font-heading">
                            Pilih Kartu Keluarga (KK) Tujuan <span class="text-rose-500">*</span>
                        </label>
                        <x-tom-select 
                            wire:model="kk_tujuan_id"
                            placeholder="Pilih atau cari KK Tujuan (Nama Kepala / No KK)...">
                            <option value="">-- Pilih KK Katolik Tujuan --</option>
                            @foreach($kkOptions as $kk)
                                <option value="{{ $kk->id }}">
                                    {{ $kk->nama_lahir_pemilik }} ({{ $kk->no_kk_kw ?: 'Tanpa No KK' }}) - KUB {{ $kk->kub->nama_kub ?? '-' }}
                                </option>
                            @endforeach
                        </x-tom-select>
                        @error('kk_tujuan_id')
                            <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5 font-heading">
                                Tanggal Efektif Mutasi <span class="text-rose-500">*</span>
                            </label>
                            <input type="date" wire:model="tgl_mutasi"
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs text-slate-800 dark:text-slate-200 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all">
                            @error('tgl_mutasi')
                                <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5 font-heading">
                                Nomor Surat Pindah (Jika Ada)
                            </label>
                            <input type="text" wire:model="no_surat_pindah" placeholder="Contoh: 014/P-MUT/IX/2026"
                                class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs text-slate-800 dark:text-slate-200 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all font-mono">
                            @error('no_surat_pindah')
                                <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5 font-heading">
                            Alasan Mutasi / Pindah <span class="text-rose-500">*</span>
                        </label>
                        <textarea wire:model="alasan" rows="4" placeholder="Tuliskan keterangan dan alasan kepindahan (misal: Menikah, Pindah domisili tugas, Ikut orang tua, dll)..."
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs text-slate-800 dark:text-slate-200 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 transition-all"></textarea>
                        @error('alasan')
                            <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-4 border-t border-slate-100 dark:border-slate-700/60 flex items-center justify-end gap-3">
                        <a href="{{ url("/{$currentPrefix}/umat") }}" wire:navigate
                            class="px-5 py-2.5 rounded-xl text-xs font-medium text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700/50 transition-colors">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-6 py-2.5 rounded-xl text-xs font-bold font-heading bg-linear-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white shadow-md shadow-amber-500/20 inline-flex items-center gap-2 transition-all">
                            <i class="fa-solid fa-floppy-disk"></i>
                            <span>Simpan Proses Mutasi</span>
                        </button>
                    </div>

                </form>
            </div>
        </div>

    </div>
</div>
