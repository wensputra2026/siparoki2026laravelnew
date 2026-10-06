<div class="space-y-6 font-sans">
    {{-- Header Banner --}}
    <div class="relative overflow-hidden rounded-2xl bg-white dark:bg-slate-900 p-6 shadow-xs border border-slate-200/80 dark:border-slate-800">
        <div class="flex items-center gap-3.5">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-500/20 shadow-xs">
                <i class="bi bi-brush text-2xl"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white flex items-center gap-2">
                    Pembersih Sistem &amp; Optimasi Server
                </h1>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                    Bersihkan berkas sementara, cache query, kompilasi tampilan, dan optimalkan performa server web paroki.
                </p>
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

    {{-- Clean Actions Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-900 p-6 shadow-xs flex flex-col justify-between">
            <div>
                <div class="h-11 w-11 rounded-xl bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 flex items-center justify-center mb-4 text-lg">
                    <i class="bi bi-cpu"></i>
                </div>
                <h3 class="text-base font-bold text-slate-900 dark:text-white">Cache Aplikasi &amp; Data</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-2 leading-relaxed">
                    Menghapus data sementara yang tersimpan di memori cache Laravel untuk memperbarui hasil query yang mengalami delay.
                </p>
            </div>
            <div class="mt-6 pt-4 border-t border-slate-100 dark:border-slate-800">
                <button wire:click="clearApplicationCache" class="w-full py-2.5 rounded-xl text-xs font-bold text-white bg-amber-500 hover:bg-amber-600 transition shadow-xs cursor-pointer">
                    Bersihkan Cache Aplikasi
                </button>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-900 p-6 shadow-xs flex flex-col justify-between">
            <div>
                <div class="h-11 w-11 rounded-xl bg-cyan-50 dark:bg-cyan-950/60 text-cyan-600 dark:text-cyan-400 flex items-center justify-center mb-4 text-lg">
                    <i class="bi bi-window"></i>
                </div>
                <h3 class="text-base font-bold text-slate-900 dark:text-white">Cache Tampilan &amp; Blade</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-2 leading-relaxed">
                    Menyegarkan hasil kompilasi template Blade dan komponen Livewire agar perubahan desain langsung terlihat seketika.
                </p>
            </div>
            <div class="mt-6 pt-4 border-t border-slate-100 dark:border-slate-800">
                <button wire:click="clearViewCache" class="w-full py-2.5 rounded-xl text-xs font-bold text-white bg-cyan-600 hover:bg-cyan-700 transition shadow-xs cursor-pointer">
                    Segarkan Tampilan
                </button>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-900 p-6 shadow-xs flex flex-col justify-between">
            <div>
                <div class="h-11 w-11 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center mb-4 text-lg">
                    <i class="bi bi-signpost-split"></i>
                </div>
                <h3 class="text-base font-bold text-slate-900 dark:text-white">Cache Konfigurasi &amp; Route</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-2 leading-relaxed">
                    Mereset mapping rute URL dan konfigurasi lingkungan server agar setiap route baru segera terdaftar.
                </p>
            </div>
            <div class="mt-6 pt-4 border-t border-slate-100 dark:border-slate-800">
                <button wire:click="clearRouteConfigCache" class="w-full py-2.5 rounded-xl text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 transition shadow-xs cursor-pointer">
                    Reset Konfigurasi
                </button>
            </div>
        </div>
    </div>
</div>
