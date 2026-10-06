<div>
    @php
        $currentPrefix = explode('/', trim(request()->path(), '/'))[0] ?? 'admin';
        if (!in_array($currentPrefix, ['admin', 'superadmin', 'paroki', 'pastor', 'wilayah', 'kapela', 'kub', 'bendahara', 'penulis', 'umat'])) {
            $currentPrefix = 'admin';
        }
    @endphp

    <!-- 1. Welcome Alert Callout Banner (Matching BIMKAT TTS) -->
    <div class="relative overflow-hidden rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800/90 shadow-xs p-6 sm:p-7 mb-8">
        <div class="absolute left-0 top-0 bottom-0 w-2 bg-gradient-to-b from-emerald-600 via-emerald-500 to-emerald-700"></div>
        <div class="absolute -right-16 -top-16 w-56 h-56 bg-emerald-50/70 dark:bg-emerald-950/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6 pl-2 sm:pl-3">
            <div class="flex items-start sm:items-center gap-4 sm:gap-5">
                <div class="w-13 h-13 sm:w-14 sm:h-14 rounded-2xl bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-100 dark:border-emerald-800/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0 shadow-2xs">
                    <i class="bi bi-speedometer2 text-2xl sm:text-3xl"></i>
                </div>

                <div>
                    <div class="flex flex-wrap items-center gap-2 mb-1.5">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            Sistem Aktif & Terintegrasi
                        </span>
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-semibold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300">
                            <i class="bi bi-shield-lock text-slate-500"></i>
                            Administrator Panel
                        </span>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                        Selamat Datang, {{ auth()->user()->nama_lengkap ?? auth()->user()->username ?? 'Super Admin' }}!
                    </h2>
                    <p class="text-slate-600 dark:text-slate-300 text-sm mt-1 max-w-2xl leading-relaxed">
                        Panel kontrol statistik terpadu Sistem Informasi Paroki (SIPAROKI) {{ $activeParokiNama ?? 'Paroki St. Vinsensius a Paulo Benlutu' }}.
                    </p>
                </div>
            </div>

            <!-- Quick Action Shortcuts (Matching BIMKAT) -->
            <div class="flex items-center gap-2.5 shrink-0 pl-2 sm:pl-0">
                <a href="{{ url("/{$currentPrefix}/umat/create") }}" wire:navigate
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl text-xs font-bold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200/80 shadow-2xs transition-all cursor-pointer">
                    <i class="bi bi-person-plus text-sm"></i>
                    <span>Tambah Umat</span>
                </a>
                <a href="{{ url("/{$currentPrefix}/kk-katolik") }}" wire:navigate
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-2xl text-xs font-bold text-slate-700 dark:text-slate-200 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 border border-slate-200/80 dark:border-slate-700 shadow-2xs transition-all cursor-pointer">
                    <i class="bi bi-folder2-open text-sm text-amber-600"></i>
                    <span>Kelola KK</span>
                </a>
            </div>
        </div>
    </div>

    <!-- 2. KPI Statistics Grid (Matching BIMKAT Rounded-3xl Card Design) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

        <!-- Total Umat -->
        <div class="group relative p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800/90 shadow-xs hover:shadow-md hover:border-emerald-500/50 transition-all duration-300 flex flex-col justify-between">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800/60">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Total Umat</p>
                    <p class="text-[11px] text-slate-400">Jiwa terdaftar di paroki</p>
                </div>
                <div class="w-10 h-10 rounded-2xl bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 flex items-center justify-center text-lg shadow-2xs group-hover:scale-105 transition-transform duration-200">
                    <i class="bi bi-people-fill"></i>
                </div>
            </div>
            <div class="mt-3">
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">{{ number_format($totalUmat) }}</span>
                    <span class="text-xs text-emerald-700 dark:text-emerald-400 font-bold">Jiwa Aktif</span>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-800/60 flex items-center justify-between text-xs">
                <a href="{{ url("/{$currentPrefix}/umat") }}" wire:navigate class="text-xs font-semibold text-emerald-700 dark:text-emerald-400 hover:underline inline-flex items-center gap-1">
                    <span>Lihat Semua Umat</span>
                    <i class="bi bi-arrow-right text-[11px]"></i>
                </a>
            </div>
        </div>

        <!-- Total KK Katolik -->
        <div class="group relative p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800/90 shadow-xs hover:shadow-md hover:border-emerald-500/50 transition-all duration-300 flex flex-col justify-between">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800/60">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">KK Katolik</p>
                    <p class="text-[11px] text-slate-400">Kepala keluarga aktif</p>
                </div>
                <div class="w-10 h-10 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-lg shadow-2xs group-hover:scale-105 transition-transform duration-200">
                    <i class="bi bi-card-heading"></i>
                </div>
            </div>
            <div class="mt-3">
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">{{ number_format($totalKk) }}</span>
                    <span class="text-xs text-emerald-700 dark:text-emerald-400 font-bold">KK Terverifikasi</span>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-800/60 flex items-center justify-between text-xs">
                <a href="{{ url("/{$currentPrefix}/kk-katolik") }}" wire:navigate class="text-xs font-semibold text-emerald-700 dark:text-emerald-400 hover:underline inline-flex items-center gap-1">
                    <span>Lihat Buku KK</span>
                    <i class="bi bi-arrow-right text-[11px]"></i>
                </a>
            </div>
        </div>

        <!-- Total Kapela / Stasi -->
        <div class="group relative p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800/90 shadow-xs hover:shadow-md hover:border-indigo-500/50 transition-all duration-300 flex flex-col justify-between">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800/60">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Kapela / Stasi</p>
                    <p class="text-[11px] text-slate-400">Gereja stasi pelayanan</p>
                </div>
                <div class="w-10 h-10 rounded-2xl bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-lg shadow-2xs group-hover:scale-105 transition-transform duration-200">
                    <i class="bi bi-building"></i>
                </div>
            </div>
            <div class="mt-3">
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">{{ number_format($totalKapela) }}</span>
                    <span class="text-xs text-indigo-700 dark:text-indigo-400 font-bold">Stasi Aktif</span>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-800/60 flex items-center justify-between text-xs">
                <a href="{{ url("/{$currentPrefix}/kapela") }}" wire:navigate class="text-xs font-semibold text-indigo-600 dark:text-indigo-400 hover:underline inline-flex items-center gap-1">
                    <span>Direktori Kapela</span>
                    <i class="bi bi-arrow-right text-[11px]"></i>
                </a>
            </div>
        </div>

        <!-- Total KUB -->
        <div class="group relative p-6 rounded-3xl bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-slate-800/90 shadow-xs hover:shadow-md hover:border-rose-500/50 transition-all duration-300 flex flex-col justify-between">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800/60">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Komunitas (KUB)</p>
                    <p class="text-[11px] text-slate-400">Komunitas Umat Basis</p>
                </div>
                <div class="w-10 h-10 rounded-2xl bg-rose-50 dark:bg-rose-950/60 text-rose-600 dark:text-rose-400 flex items-center justify-center text-lg shadow-2xs group-hover:scale-105 transition-transform duration-200">
                    <i class="bi bi-people"></i>
                </div>
            </div>
            <div class="mt-3">
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">{{ number_format($totalKub) }}</span>
                    <span class="text-xs text-rose-700 dark:text-rose-400 font-bold">KUB Terdata</span>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-800/60 flex items-center justify-between text-xs">
                <a href="{{ url("/{$currentPrefix}/kub") }}" wire:navigate class="text-xs font-semibold text-rose-600 dark:text-rose-400 hover:underline inline-flex items-center gap-1">
                    <span>Daftar KUB</span>
                    <i class="bi bi-arrow-right text-[11px]"></i>
                </a>
            </div>
        </div>

    </div>

    <!-- Analytics & Summaries Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">

        <!-- Demografi & Sakramen (Left 2 cols on lg) -->
        <div class="lg:col-span-1 space-y-6">

            <!-- Demografi Gender -->
            <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800/80 shadow-xs">
                <h4 class="font-bold text-sm text-slate-900 dark:text-white flex items-center gap-2 mb-4">
                    <i class="fa-solid fa-venus-mars text-amber-500"></i>
                    <span>Demografi Jenis Kelamin</span>
                </h4>

                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between text-xs font-semibold mb-1.5 text-slate-700 dark:text-slate-300">
                            <span class="flex items-center gap-1.5">
                                <i class="fa-solid fa-mars text-blue-500"></i> Laki-laki
                            </span>
                            <span>{{ $genderL }} Jiwa ({{ $genderLPercent }}%)</span>
                        </div>
                        <div class="w-full h-2.5 rounded-full bg-slate-100 dark:bg-slate-800 overflow-hidden">
                            <div class="h-full bg-blue-500 rounded-full transition-all duration-500" style="width: {{ $genderLPercent }}%"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex justify-between text-xs font-semibold mb-1.5 text-slate-700 dark:text-slate-300">
                            <span class="flex items-center gap-1.5">
                                <i class="fa-solid fa-venus text-pink-500"></i> Perempuan
                            </span>
                            <span>{{ $genderP }} Jiwa ({{ $genderPPercent }}%)</span>
                        </div>
                        <div class="w-full h-2.5 rounded-full bg-slate-100 dark:bg-slate-800 overflow-hidden">
                            <div class="h-full bg-pink-500 rounded-full transition-all duration-500" style="width: {{ $genderPPercent }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Penerimaan Sakramen -->
            <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800/80 shadow-xs">
                <h4 class="font-bold text-sm text-slate-900 dark:text-white flex items-center gap-2 mb-4">
                    <i class="fa-solid fa-cross text-amber-500"></i>
                    <span>Status Sakramen Inisiasi</span>
                </h4>

                <div class="grid grid-cols-3 gap-3 text-center">
                    <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200/80 dark:border-slate-800 shadow-xs">
                        <p class="text-xs font-bold text-slate-700 dark:text-slate-300 font-heading">Baptis</p>
                        <p class="text-xl font-black text-amber-700 dark:text-amber-400 mt-1 font-heading">{{ $totalBaptis }}</p>
                    </div>

                    <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200/80 dark:border-slate-800 shadow-xs">
                        <p class="text-xs font-bold text-slate-700 dark:text-slate-300 font-heading">Komuni</p>
                        <p class="text-xl font-black text-emerald-700 dark:text-emerald-400 mt-1 font-heading">{{ $totalKomuni }}</p>
                    </div>

                    <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200/80 dark:border-slate-800 shadow-xs">
                        <p class="text-xs font-bold text-slate-700 dark:text-slate-300 font-heading">Krisma</p>
                        <p class="text-xl font-black text-indigo-700 dark:text-indigo-400 mt-1 font-heading">{{ $totalKrisma }}</p>
                    </div>
                </div>
            </div>

        </div>

        <!-- Umat Terbaru Table (Right 2 cols on lg) -->
        <div class="lg:col-span-2 p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800/80 shadow-xs">
            <div class="flex items-center justify-between mb-4">
                <h4 class="font-bold text-sm text-slate-900 dark:text-white flex items-center gap-2 font-heading">
                    <i class="fa-solid fa-clock-rotate-left text-amber-500"></i>
                    <span>Pendaftaran Umat Terbaru</span>
                </h4>
                <a href="{{ url("/{$currentPrefix}/umat") }}" wire:navigate class="text-xs font-bold text-amber-700 dark:text-amber-400 hover:underline font-heading">
                    Lihat Semua
                </a>
            </div>

            <div class="overflow-x-auto admin-table-wrap rounded-xl border border-slate-200/80 dark:border-slate-800">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="border-b border-slate-200/80 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/80 text-slate-500 dark:text-slate-400 font-extrabold uppercase text-[11px] tracking-wider">
                            <th class="py-3 px-3">Nama Umat</th>
                            <th class="py-3 px-3">L/P</th>
                            <th class="py-3 px-3">KUB / Wilayah</th>
                            <th class="py-3 px-3">Status</th>
                            <th class="py-3 px-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60">
                        @forelse ($recentUmats as $u)
                            <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-800/40 transition-colors">
                                <td class="py-3 px-3">
                                    <div class="font-semibold text-slate-900 dark:text-slate-100">{{ $u->nama_lengkap }}</div>
                                    <div class="text-[11px] text-slate-500 dark:text-slate-400 font-mono font-medium">{{ $u->nik ? substr($u->nik, 0, 6) . '******' : '-' }}</div>
                                </td>
                                <td class="py-3 px-3">
                                    @if ($u->jenis_kelamin === 'L')
                                        <span class="px-2 py-0.5 rounded-md font-bold text-[10px] bg-blue-50 text-blue-700 dark:bg-blue-950/60 dark:text-blue-300 border border-blue-200 dark:border-blue-800">Laki-laki</span>
                                    @else
                                        <span class="px-2 py-0.5 rounded-md font-bold text-[10px] bg-pink-50 text-pink-700 dark:bg-pink-950/60 dark:text-pink-300 border border-pink-200 dark:border-pink-800">Perempuan</span>
                                    @endif
                                </td>
                                <td class="py-3 px-3 text-slate-700 dark:text-slate-300 font-medium">
                                    <div>{{ $u->kub->nama_kub ?? '-' }}</div>
                                    <div class="text-[11px] text-slate-500 dark:text-slate-400">{{ $u->wilayah->nama_wilayah ?? $u->kapela->nama_kapela ?? '-' }}</div>
                                </td>
                                <td class="py-3 px-3">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        <span>Aktif</span>
                                    </span>
                                </td>
                                <td class="py-3 px-3 text-right">
                                    <a href="{{ url("/{$currentPrefix}/umat/{$u->id}/edit") }}" wire:navigate
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-slate-400 hover:text-amber-600 hover:bg-amber-50 dark:hover:bg-slate-800 transition-colors" title="Edit Umat">
                                        <i class="bi bi-pencil text-sm"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-500 dark:text-slate-400 font-medium">
                                    Belum ada data umat yang didaftarkan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>
