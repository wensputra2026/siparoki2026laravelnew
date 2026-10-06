<div class="space-y-6 font-sans">
    {{-- Header Banner --}}
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-slate-900 via-slate-800 to-amber-950 p-6 shadow-xl border border-slate-700/50">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-500/20 text-amber-400 border border-amber-500/30 shadow-inner">
                    <i class="fa-solid fa-chart-pie text-xl"></i>
                </div>
                <div>
                    <h1 class="font-outfit text-2xl font-bold tracking-tight text-white flex items-center gap-2">
                        Demografi & Statistik Paroki
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-400/20 text-amber-300 border border-amber-400/30">
                            {{ number_format($totalUmat, 0, ',', '.') }} Jiwa
                        </span>
                    </h1>
                    <p class="text-xs text-slate-400 mt-1">
                        Analisis data demografis umat beriman, distribusi usia, status penerimaan sakramen, dan teritorial pastoral.
                    </p>
                </div>
            </div>

            {{-- Tom Select Filters --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 w-full md:w-auto">
                <div class="min-w-[140px]">
                    <x-tom-select wire:model.live="filterWilayah" placeholder="Semua Wilayah">
                        <option value="">Semua Wilayah</option>
                        @foreach($wilayahOptions as $w)
                            <option value="{{ $w->id }}">{{ $w->nama_wilayah }}</option>
                        @endforeach
                    </x-tom-select>
                </div>
                <div class="min-w-[140px]">
                    <x-tom-select wire:model.live="filterKapela" placeholder="Semua Kapela">
                        <option value="">Semua Kapela</option>
                        @foreach($kapelaOptions as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_kapela }}</option>
                        @endforeach
                    </x-tom-select>
                </div>
                <div class="min-w-[140px]">
                    <x-tom-select wire:model.live="filterKub" placeholder="Semua KUB">
                        <option value="">Semua KUB</option>
                        @foreach($kubOptions as $kub)
                            <option value="{{ $kub->id }}">{{ $kub->nama_kub }}</option>
                        @endforeach
                    </x-tom-select>
                </div>
            </div>
        </div>
    </div>

    {{-- Top 4 KPI Cards --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="rounded-2xl border border-slate-800 bg-slate-900/90 p-5 shadow-xl">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-400">Total Umat / Jiwa</span>
                <div class="h-8 w-8 rounded-lg bg-amber-500/20 text-amber-400 flex items-center justify-center">
                    <i class="fa-solid fa-users text-sm"></i>
                </div>
            </div>
            <div class="font-outfit text-2xl font-bold text-white mt-2">{{ number_format($totalUmat, 0, ',', '.') }}</div>
            <div class="text-[11px] text-slate-500 mt-1">Umat terdaftar di paroki</div>
        </div>

        <div class="rounded-2xl border border-slate-800 bg-slate-900/90 p-5 shadow-xl">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-400">Kartu Keluarga (KK)</span>
                <div class="h-8 w-8 rounded-lg bg-cyan-500/20 text-cyan-400 flex items-center justify-center">
                    <i class="fa-solid fa-house-chimney-user text-sm"></i>
                </div>
            </div>
            <div class="font-outfit text-2xl font-bold text-cyan-400 mt-2">{{ number_format($totalKk, 0, ',', '.') }}</div>
            <div class="text-[11px] text-slate-500 mt-1">Keluarga Katolik</div>
        </div>

        <div class="rounded-2xl border border-slate-800 bg-slate-900/90 p-5 shadow-xl">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-400">Wilayah Pelayanan</span>
                <div class="h-8 w-8 rounded-lg bg-emerald-500/20 text-emerald-400 flex items-center justify-center">
                    <i class="fa-solid fa-compass text-sm"></i>
                </div>
            </div>
            <div class="font-outfit text-2xl font-bold text-emerald-400 mt-2">{{ number_format($totalWilayah, 0, ',', '.') }}</div>
            <div class="text-[11px] text-slate-500 mt-1">Wilayah teritorial</div>
        </div>

        <div class="rounded-2xl border border-slate-800 bg-slate-900/90 p-5 shadow-xl">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold text-slate-400">Komunitas Umat (KUB)</span>
                <div class="h-8 w-8 rounded-lg bg-purple-500/20 text-purple-400 flex items-center justify-center">
                    <i class="fa-solid fa-people-group text-sm"></i>
                </div>
            </div>
            <div class="font-outfit text-2xl font-bold text-purple-400 mt-2">{{ number_format($totalKub, 0, ',', '.') }}</div>
            <div class="text-[11px] text-slate-500 mt-1">Basis komunitas umat</div>
        </div>
    </div>

    {{-- Gender & Sakramen Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Komposisi Gender --}}
        <div class="rounded-2xl border border-slate-800 bg-slate-900/90 p-6 shadow-xl space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-800">
                <h3 class="font-outfit text-sm font-bold text-white flex items-center gap-2">
                    <i class="fa-solid fa-venus-mars text-amber-400"></i>
                    Komposisi Jenis Kelamin
                </h3>
            </div>

            @php
                $persenLaki = $totalUmat > 0 ? round(($totalLaki / $totalUmat) * 100, 1) : 0;
                $persenPerempuan = $totalUmat > 0 ? round(($totalPerempuan / $totalUmat) * 100, 1) : 0;
            @endphp

            <div class="grid grid-cols-2 gap-4">
                <div class="bg-slate-950/60 rounded-xl p-4 border border-blue-500/20">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-semibold text-blue-400">Laki-Laki</span>
                        <i class="fa-solid fa-mars text-blue-400 text-lg"></i>
                    </div>
                    <div class="font-outfit text-xl font-bold text-white mt-2">{{ number_format($totalLaki, 0, ',', '.') }}</div>
                    <div class="text-[11px] text-slate-400 mt-0.5">{{ $persenLaki }}% dari total umat</div>
                </div>

                <div class="bg-slate-950/60 rounded-xl p-4 border border-pink-500/20">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-semibold text-pink-400">Perempuan</span>
                        <i class="fa-solid fa-venus text-pink-400 text-lg"></i>
                    </div>
                    <div class="font-outfit text-xl font-bold text-white mt-2">{{ number_format($totalPerempuan, 0, ',', '.') }}</div>
                    <div class="text-[11px] text-slate-400 mt-0.5">{{ $persenPerempuan }}% dari total umat</div>
                </div>
            </div>

            {{-- Progress bar gender --}}
            <div class="space-y-1.5 pt-2">
                <div class="h-3 w-full rounded-full bg-slate-800 overflow-hidden flex shadow-inner">
                    <div class="bg-blue-500 transition-all duration-500" style="width: {{ $persenLaki }}%"></div>
                    <div class="bg-pink-500 transition-all duration-500" style="width: {{ $persenPerempuan }}%"></div>
                </div>
                <div class="flex justify-between text-[10px] text-slate-400 font-mono">
                    <span>Laki-Laki ({{ $persenLaki }}%)</span>
                    <span>Perempuan ({{ $persenPerempuan }}%)</span>
                </div>
            </div>
        </div>

        {{-- Status Penerimaan Sakramen --}}
        <div class="rounded-2xl border border-slate-800 bg-slate-900/90 p-6 shadow-xl space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-800">
                <h3 class="font-outfit text-sm font-bold text-white flex items-center gap-2">
                    <i class="fa-solid fa-book-bible text-amber-400"></i>
                    Penerimaan Sakramen Inisiasi & Perkawinan
                </h3>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div class="bg-slate-950/60 rounded-xl p-3 border border-emerald-500/20">
                    <div class="text-[11px] font-semibold text-emerald-400">Sakramen Baptis</div>
                    <div class="font-outfit text-lg font-bold text-white mt-1">{{ number_format($totalBaptis, 0, ',', '.') }}</div>
                    <div class="text-[10px] text-slate-400">{{ $totalUmat > 0 ? round(($totalBaptis / $totalUmat) * 100, 1) : 0 }}% umat</div>
                </div>
                <div class="bg-slate-950/60 rounded-xl p-3 border border-amber-500/20">
                    <div class="text-[11px] font-semibold text-amber-400">Komuni Pertama</div>
                    <div class="font-outfit text-lg font-bold text-white mt-1">{{ number_format($totalKomuni, 0, ',', '.') }}</div>
                    <div class="text-[10px] text-slate-400">{{ $totalUmat > 0 ? round(($totalKomuni / $totalUmat) * 100, 1) : 0 }}% umat</div>
                </div>
                <div class="bg-slate-950/60 rounded-xl p-3 border border-cyan-500/20">
                    <div class="text-[11px] font-semibold text-cyan-400">Sakramen Krisma</div>
                    <div class="font-outfit text-lg font-bold text-white mt-1">{{ number_format($totalKrisma, 0, ',', '.') }}</div>
                    <div class="text-[10px] text-slate-400">{{ $totalUmat > 0 ? round(($totalKrisma / $totalUmat) * 100, 1) : 0 }}% umat</div>
                </div>
                <div class="bg-slate-950/60 rounded-xl p-3 border border-purple-500/20">
                    <div class="text-[11px] font-semibold text-purple-400">Sakramen Nikah</div>
                    <div class="font-outfit text-lg font-bold text-white mt-1">{{ number_format($totalNikah, 0, ',', '.') }}</div>
                    <div class="text-[10px] text-slate-400">{{ $totalUmat > 0 ? round(($totalNikah / $totalUmat) * 100, 1) : 0 }}% umat</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Rentang Usia & Kategori Generasi --}}
    <div class="rounded-2xl border border-slate-800 bg-slate-900/90 p-6 shadow-xl space-y-4">
        <div class="flex items-center justify-between pb-3 border-b border-slate-800">
            <h3 class="font-outfit text-sm font-bold text-white flex items-center gap-2">
                <i class="fa-solid fa-users-line text-amber-400"></i>
                Kelompok Umur & Kategorial Usia
            </h3>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
            @php
                $ageGroups = [
                    ['label' => 'Balita', 'range' => '0 - 5 Thn', 'count' => $balita, 'color' => 'amber'],
                    ['label' => 'Anak-Anak', 'range' => '6 - 12 Thn', 'count' => $anak, 'color' => 'emerald'],
                    ['label' => 'Remaja / BIR', 'range' => '13 - 17 Thn', 'count' => $remaja, 'color' => 'cyan'],
                    ['label' => 'OMK / Pemuda', 'range' => '18 - 35 Thn', 'count' => $omk, 'color' => 'blue'],
                    ['label' => 'Dewasa', 'range' => '36 - 59 Thn', 'count' => $dewasa, 'color' => 'purple'],
                    ['label' => 'Lansia', 'range' => '60+ Thn', 'count' => $lansia, 'color' => 'rose'],
                ];
            @endphp

            @foreach($ageGroups as $ag)
                <div class="bg-slate-950/60 rounded-xl p-3.5 border border-slate-800 text-center">
                    <span class="text-[11px] font-semibold text-slate-400 block">{{ $ag['label'] }}</span>
                    <span class="text-[10px] text-slate-500 font-mono">{{ $ag['range'] }}</span>
                    <div class="font-outfit text-lg font-bold text-white mt-1.5">{{ number_format($ag['count'], 0, ',', '.') }}</div>
                    <div class="text-[10px] text-amber-400 font-semibold mt-0.5">
                        {{ $totalUmat > 0 ? round(($ag['count'] / $totalUmat) * 100, 1) : 0 }}%
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Distribusi Data per Wilayah Table --}}
    <div class="rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-xs overflow-hidden admin-table-wrap">
        <div class="p-4 border-b border-slate-100 dark:border-slate-800">
            <h3 class="text-sm font-bold text-slate-900 dark:text-white flex items-center gap-2">
                <i class="bi bi-geo-alt text-amber-500"></i>
                Distribusi Data Teritorial per Wilayah Pelayanan
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600 dark:text-slate-300">
                <thead class="bg-slate-50 dark:bg-slate-800/80 text-[11px] font-extrabold uppercase tracking-wider text-slate-500 dark:text-slate-400 border-b border-slate-200/80 dark:border-slate-800">
                    <tr>
                        <th class="p-3.5 w-12 text-center">No</th>
                        <th class="p-3.5">Nama Wilayah</th>
                        <th class="p-3.5 text-center">Jumlah KUB</th>
                        <th class="p-3.5 text-center">Jumlah KK</th>
                        <th class="p-3.5 text-right pr-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($wilayahStats as $i => $ws)
                        <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-800/40 transition-colors">
                            <td class="p-3.5 text-center text-slate-400 font-medium">{{ $i + 1 }}</td>
                            <td class="p-3.5 font-bold text-slate-900 dark:text-white">{{ $ws->nama_wilayah }}</td>
                            <td class="p-3.5 text-center">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-purple-50 dark:bg-purple-950/60 text-purple-700 dark:text-purple-300 border border-purple-200 dark:border-purple-800">
                                    {{ $ws->kubs_count }} KUB
                                </span>
                            </td>
                            <td class="p-3.5 text-center">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-50 dark:bg-amber-950/60 text-amber-700 dark:text-amber-300 border border-amber-200 dark:border-amber-800">
                                    {{ $ws->kks_count }} KK
                                </span>
                            </td>
                            <td class="p-3.5 text-right pr-4">
                                <a href="/{{ $prefix }}/kk-katolik?filterWilayah={{ $ws->id }}" wire:navigate class="inline-flex items-center gap-1.5 text-xs text-amber-600 dark:text-amber-400 hover:underline font-bold">
                                    <span>Lihat KK</span>
                                    <i class="bi bi-chevron-right text-[10px]"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-8 text-center text-slate-400">Belum ada data wilayah.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
