<div class="space-y-6 font-sans">
    {{-- Header Banner & Actions --}}
    <div class="relative overflow-hidden rounded-2xl bg-white dark:bg-slate-900 p-6 shadow-xs border border-slate-200/80 dark:border-slate-800">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <a href="/{{ $prefix }}/kk-katolik" wire:navigate class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:text-amber-600 hover:bg-amber-50 dark:hover:bg-slate-700 transition border border-slate-200 dark:border-slate-700 cursor-pointer">
                    <i class="bi bi-arrow-left text-base"></i>
                </a>
                <div>
                    <h1 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white flex items-center gap-2">
                        <i class="bi bi-card-heading text-amber-500"></i>
                        Kartu Keluarga Katolik
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-mono font-bold bg-amber-50 dark:bg-amber-950/60 text-amber-700 dark:text-amber-300 border border-emerald-200 dark:border-amber-800">
                            {{ $kk->no_kk_kw }}
                        </span>
                    </h1>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                        {{ $paroki?->nama_paroki ?? 'Paroki' }} &bull; {{ $paroki?->keuskupan?->nama_keuskupan ?? 'Keuskupan' }}
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <a href="/{{ $prefix }}/kk-katolik/{{ $kk->id }}/pdf" target="_blank" class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-semibold text-slate-700 dark:text-slate-200 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-700 transition shadow-xs cursor-pointer">
                    <i class="bi bi-printer text-emerald-600 dark:text-emerald-400"></i>
                    Cetak Kartu PDF
                </a>
                <a href="/{{ $prefix }}/umat/create?kk_id={{ $kk->id }}" wire:navigate class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl text-xs font-bold text-white bg-amber-500 hover:bg-amber-600 transition shadow-xs cursor-pointer">
                    <i class="bi bi-person-plus"></i>
                    Tambah Anggota
                </a>
                <a href="/{{ $prefix }}/kk-katolik/{{ $kk->id }}/edit" wire:navigate class="w-9 h-9 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:text-amber-600 hover:bg-amber-50 dark:hover:bg-slate-700 flex items-center justify-center transition border border-slate-200 dark:border-slate-700 cursor-pointer" title="Edit KK">
                    <i class="bi bi-pencil text-sm"></i>
                </a>
            </div>
        </div>
    </div>

    {{-- Official Catholic Family Card Header Info --}}
    <div class="rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-xs p-6 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="space-y-1">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Kepala Keluarga</span>
                <div class="text-base font-bold text-slate-900 dark:text-white">{{ $kk->nama_baptis_pemilik }}</div>
                @if($kk->nama_lahir_pemilik && $kk->nama_lahir_pemilik !== $kk->nama_baptis_pemilik)
                    <div class="text-xs text-slate-500 dark:text-slate-400">Nama Lahir: {{ $kk->nama_lahir_pemilik }}</div>
                @endif
                @if($kk->nik_pemilik)
                    <div class="text-[11px] font-mono text-slate-500 dark:text-slate-400">NIK: {{ $kk->nik_pemilik }}</div>
                @endif
            </div>

            <div class="space-y-1">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Teritorial Gerejawi</span>
                <div class="text-sm font-semibold text-slate-800 dark:text-slate-200">Wilayah: {{ $kk->wilayah?->nama_wilayah ?: '-' }}</div>
                <div class="text-xs text-slate-600 dark:text-slate-400">Stasi/Kapela: {{ $kk->kapela?->nama_kapela ?: '-' }}</div>
                <div class="text-xs text-amber-600 dark:text-amber-400 font-medium">KUB: {{ $kk->kub?->nama_kub ?: '-' }}</div>
            </div>

            <div class="space-y-1">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Domisili &amp; Kontak</span>
                <div class="text-xs text-slate-700 dark:text-slate-300 leading-relaxed">{{ $kk->alamat_sekarang ?: 'Alamat belum tercatat' }}</div>
                @if($kk->handphone)
                    <div class="text-xs text-cyan-600 dark:text-cyan-400 flex items-center gap-1.5"><i class="bi bi-telephone text-[10px]"></i>{{ $kk->handphone }}</div>
                @endif
                @if($kk->email)
                    <div class="text-xs text-slate-500 dark:text-slate-400 flex items-center gap-1.5"><i class="bi bi-envelope text-[10px]"></i>{{ $kk->email }}</div>
                @endif
            </div>

            <div class="space-y-1">
                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Status &amp; Ekonomi</span>
                <div>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $kk->status_kk === 'Aktif' ? 'bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400' }}">
                        {{ $kk->status_kk ?: 'Aktif' }}
                    </span>
                </div>
                <div class="text-xs text-slate-500 dark:text-slate-400 mt-1">Status Rumah: {{ $kk->status_kepemilikan_rumah ?: 'Milik Sendiri' }}</div>
                <div class="text-xs text-slate-500 dark:text-slate-400">Kategori Ekonomi: {{ $kk->kategori_ekonomi ?: 'Mampu' }}</div>
            </div>
        </div>
    </div>

    {{-- Family Members Table --}}
    <div class="rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-xs overflow-hidden admin-table-wrap">
        <div class="p-4 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
            <h3 class="text-sm font-bold text-slate-900 dark:text-white flex items-center gap-2">
                <i class="bi bi-people text-amber-500"></i>
                Daftar Anggota Keluarga ({{ $kk->anggota->count() }} Jiwa)
            </h3>
            <a href="/{{ $prefix }}/umat/create?kk_id={{ $kk->id }}" wire:navigate class="text-xs font-bold text-amber-600 dark:text-amber-400 hover:underline flex items-center gap-1">
                <i class="bi bi-plus text-sm"></i>
                Tambah Jiwa Baru
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600 dark:text-slate-300">
                <thead class="bg-slate-50 dark:bg-slate-800/80 text-[11px] font-extrabold uppercase tracking-wider text-slate-500 dark:text-slate-400 border-b border-slate-200/80 dark:border-slate-800">
                    <tr>
                        <th class="p-3.5 w-10 text-center">No</th>
                        <th class="p-3.5">Nama Lengkap &amp; Baptis</th>
                        <th class="p-3.5">NIK</th>
                        <th class="p-3.5">Kedudukan</th>
                        <th class="p-3.5 text-center">L/P</th>
                        <th class="p-3.5">Tempat, Tgl Lahir</th>
                        <th class="p-3.5 text-center">Status Sakramen</th>
                        <th class="p-3.5 text-center">Status Jiwa</th>
                        <th class="p-3.5 text-right pr-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($kk->anggota as $idx => $anggota)
                        <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-800/40 transition-colors">
                            <td class="p-3.5 text-center text-slate-400 font-medium">{{ $idx + 1 }}</td>
                            <td class="p-3.5">
                                <div class="font-bold text-slate-900 dark:text-white hover:text-amber-600 dark:hover:text-amber-400 transition-colors">
                                    {{ $anggota->nama_lengkap }}
                                </div>
                                @if($anggota->nama_baptis && $anggota->nama_baptis !== $anggota->nama_lengkap)
                                    <div class="text-[11px] text-slate-400">
                                        Baptis: {{ $anggota->nama_baptis }}
                                    </div>
                                @endif
                            </td>
                            <td class="p-3.5 font-mono text-slate-500 dark:text-slate-400">
                                {{ $anggota->nik ?: '-' }}
                            </td>
                            <td class="p-3.5">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-semibold {{ $anggota->hubungan_keluarga === 'Kepala Keluarga' ? 'bg-amber-50 dark:bg-amber-950/60 text-amber-700 dark:text-amber-300 border border-amber-200 dark:border-amber-800' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300' }}">
                                    {{ $anggota->hubungan_keluarga ?: '-' }}
                                </span>
                            </td>
                            <td class="p-3.5 text-center">
                                <span class="font-bold {{ $anggota->jenis_kelamin === 'Laki-Laki' ? 'text-blue-600 dark:text-blue-400' : 'text-pink-600 dark:text-pink-400' }}">
                                    {{ $anggota->jenis_kelamin === 'Laki-Laki' ? 'L' : 'P' }}
                                </span>
                            </td>
                            <td class="p-3.5">
                                <div class="text-slate-800 dark:text-slate-200">{{ $anggota->tempat_lahir ?: '-' }}</div>
                                <div class="text-[11px] text-slate-400">
                                    {{ $anggota->tanggal_lahir ? \Carbon\Carbon::parse($anggota->tanggal_lahir)->format('d M Y') : '-' }}
                                </div>
                            </td>
                            <td class="p-3.5 text-center">
                                <div class="flex items-center justify-center gap-1 text-[10px]">
                                    <span class="px-1.5 py-0.5 rounded font-mono font-bold {{ $anggota->is_baptis ? 'bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800' : 'bg-slate-100 dark:bg-slate-800 text-slate-400' }}" title="Baptis">B</span>
                                    <span class="px-1.5 py-0.5 rounded font-mono font-bold {{ $anggota->is_komuni ? 'bg-amber-50 dark:bg-amber-950/60 text-amber-700 dark:text-amber-300 border border-amber-200 dark:border-amber-800' : 'bg-slate-100 dark:bg-slate-800 text-slate-400' }}" title="Komuni">K</span>
                                    <span class="px-1.5 py-0.5 rounded font-mono font-bold {{ $anggota->is_krisma ? 'bg-cyan-50 dark:bg-cyan-950/60 text-cyan-700 dark:text-cyan-300 border border-cyan-200 dark:border-cyan-800' : 'bg-slate-100 dark:bg-slate-800 text-slate-400' }}" title="Krisma">Kr</span>
                                    <span class="px-1.5 py-0.5 rounded font-mono font-bold {{ $anggota->is_nikah ? 'bg-purple-50 dark:bg-purple-950/60 text-purple-700 dark:text-purple-300 border border-purple-200 dark:border-purple-800' : 'bg-slate-100 dark:bg-slate-800 text-slate-400' }}" title="Nikah">N</span>
                                </div>
                            </td>
                            <td class="p-3.5 text-center">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold {{ in_array($anggota->status_umat, ['1', 'Aktif', 'Hidup'], true) ? 'bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800' : 'bg-rose-50 dark:bg-rose-950/60 text-rose-700 dark:text-rose-300 border border-rose-200 dark:border-rose-800' }}">
                                    {{ $anggota->status_umat ?: 'Aktif' }}
                                </span>
                            </td>
                            <td class="p-3.5 text-right pr-4">
                                <a href="/{{ $prefix }}/umat/{{ $anggota->id }}/edit" wire:navigate class="w-8 h-8 rounded-lg text-slate-400 hover:text-amber-600 hover:bg-amber-50 dark:hover:bg-slate-800 inline-flex items-center justify-center transition cursor-pointer" title="Edit Data Umat">
                                    <i class="bi bi-pencil text-sm"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="p-8 text-center text-slate-400">
                                Belum ada anggota keluarga yang terdaftar dalam Kartu Keluarga ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
