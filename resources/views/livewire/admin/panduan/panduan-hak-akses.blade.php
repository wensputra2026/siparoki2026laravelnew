<div class="space-y-6 font-sans">
    {{-- Header Banner --}}
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-slate-900 via-slate-800 to-amber-950 p-6 shadow-xl border border-slate-700/50">
        <div class="flex items-center gap-3">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-500/20 text-amber-400 border border-amber-500/30 shadow-inner">
                <i class="fa-solid fa-book-open text-xl"></i>
            </div>
            <div>
                <h1 class="font-outfit text-2xl font-bold tracking-tight text-white flex items-center gap-2">
                    Panduan Hak Akses & Matriks Kewenangan (RBAC)
                </h1>
                <p class="text-xs text-slate-400 mt-1">
                    Sistem Peran dan Hak Akses Berjenjang (Role-Based Access Control) Paroki Benlutu yang aman dan terstruktur.
                </p>
            </div>
        </div>
    </div>

    {{-- Role Hierarchy Matrix --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        {{-- Super Admin --}}
        <div class="rounded-2xl border border-amber-500/30 bg-slate-900/90 p-5 shadow-xl relative overflow-hidden">
            <div class="absolute -top-10 -right-10 w-28 h-28 bg-amber-500/10 rounded-full blur-xl pointer-events-none"></div>
            <div class="flex items-center gap-3 mb-3">
                <div class="h-10 w-10 rounded-xl bg-amber-500/20 text-amber-400 flex items-center justify-center font-bold">
                    <i class="fa-solid fa-crown text-base"></i>
                </div>
                <div>
                    <h3 class="font-outfit text-base font-bold text-white">Super Admin</h3>
                    <span class="text-[11px] text-amber-400 font-medium">Tingkat Tertinggi (Global)</span>
                </div>
            </div>
            <p class="text-xs text-slate-300 leading-relaxed">
                Memiliki kendali penuh ke semua modul: manajemen user, konfigurasi sistem, database backup, log keamanan, teritorial gerejawi dan seluruh data pastoral.
            </p>
            <div class="mt-4 pt-3 border-t border-slate-800/80 flex flex-wrap gap-1.5 text-[10px]">
                <span class="px-2 py-0.5 rounded bg-slate-800 text-slate-300">Semua Modul</span>
                <span class="px-2 py-0.5 rounded bg-slate-800 text-slate-300">Backup DB</span>
                <span class="px-2 py-0.5 rounded bg-slate-800 text-slate-300">Firewall</span>
            </div>
        </div>

        {{-- Pastor Paroki --}}
        <div class="rounded-2xl border border-slate-800 bg-slate-900/90 p-5 shadow-xl">
            <div class="flex items-center gap-3 mb-3">
                <div class="h-10 w-10 rounded-xl bg-purple-500/20 text-purple-400 flex items-center justify-center font-bold">
                    <i class="fa-solid fa-cross text-base"></i>
                </div>
                <div>
                    <h3 class="font-outfit text-base font-bold text-white">Pastor Paroki</h3>
                    <span class="text-[11px] text-purple-400 font-medium">Kepemimpinan Pastoral</span>
                </div>
            </div>
            <p class="text-xs text-slate-300 leading-relaxed">
                Memantau seluruh statistik umat paroki, pelayanan sakramen, warta paroki, persetujuan intensi misa, dan riwayat mutasi umat gerejawi.
            </p>
            <div class="mt-4 pt-3 border-t border-slate-800/80 flex flex-wrap gap-1.5 text-[10px]">
                <span class="px-2 py-0.5 rounded bg-slate-800 text-slate-300">Buku Sakramen</span>
                <span class="px-2 py-0.5 rounded bg-slate-800 text-slate-300">Intensi Misa</span>
                <span class="px-2 py-0.5 rounded bg-slate-800 text-slate-300">Statistik</span>
            </div>
        </div>

        {{-- Admin Paroki --}}
        <div class="rounded-2xl border border-slate-800 bg-slate-900/90 p-5 shadow-xl">
            <div class="flex items-center gap-3 mb-3">
                <div class="h-10 w-10 rounded-xl bg-cyan-500/20 text-cyan-400 flex items-center justify-center font-bold">
                    <i class="fa-solid fa-place-of-worship text-base"></i>
                </div>
                <div>
                    <h3 class="font-outfit text-base font-bold text-white">Admin Paroki / Sekretariat</h3>
                    <span class="text-[11px] text-cyan-400 font-medium">Administrasi Pusat</span>
                </div>
            </div>
            <p class="text-xs text-slate-300 leading-relaxed">
                Pengelolaan sensus seluruh KK Katolik, registrasi surat masuk/keluar, penerbitan surat baptis/nikah, kearsipan digital paroki, dan agenda rapat.
            </p>
            <div class="mt-4 pt-3 border-t border-slate-800/80 flex flex-wrap gap-1.5 text-[10px]">
                <span class="px-2 py-0.5 rounded bg-slate-800 text-slate-300">KK Katolik</span>
                <span class="px-2 py-0.5 rounded bg-slate-800 text-slate-300">Surat Menyurat</span>
                <span class="px-2 py-0.5 rounded bg-slate-800 text-slate-300">Arsip Digital</span>
            </div>
        </div>

        {{-- Admin Wilayah --}}
        <div class="rounded-2xl border border-slate-800 bg-slate-900/90 p-5 shadow-xl">
            <div class="flex items-center gap-3 mb-3">
                <div class="h-10 w-10 rounded-xl bg-blue-500/20 text-blue-400 flex items-center justify-center font-bold">
                    <i class="fa-solid fa-compass text-base"></i>
                </div>
                <div>
                    <h3 class="font-outfit text-base font-bold text-white">Admin Wilayah</h3>
                    <span class="text-[11px] text-blue-400 font-medium">Teritorial Wilayah</span>
                </div>
            </div>
            <p class="text-xs text-slate-300 leading-relaxed">
                Memantau dan mengawasi data KUB, KK, dan umat beriman yang berada di bawah naungan wilayah pelayanannya masing-masing.
            </p>
            <div class="mt-4 pt-3 border-t border-slate-800/80 flex flex-wrap gap-1.5 text-[10px]">
                <span class="px-2 py-0.5 rounded bg-slate-800 text-slate-300">Scoped Wilayah</span>
                <span class="px-2 py-0.5 rounded bg-slate-800 text-slate-300">KUB Binaan</span>
            </div>
        </div>

        {{-- Admin Stasi / Kapela --}}
        <div class="rounded-2xl border border-slate-800 bg-slate-900/90 p-5 shadow-xl">
            <div class="flex items-center gap-3 mb-3">
                <div class="h-10 w-10 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center font-bold">
                    <i class="fa-solid fa-map-location-dot text-base"></i>
                </div>
                <div>
                    <h3 class="font-outfit text-base font-bold text-white">Admin Stasi / Kapela</h3>
                    <span class="text-[11px] text-emerald-400 font-medium">Teritorial Stasi</span>
                </div>
            </div>
            <p class="text-xs text-slate-300 leading-relaxed">
                Pengelolaan jadwal ibadat stasi, aset kapela, serta data umat dan KUB yang terafiliasi dengan kapela/stasi terkait.
            </p>
            <div class="mt-4 pt-3 border-t border-slate-800/80 flex flex-wrap gap-1.5 text-[10px]">
                <span class="px-2 py-0.5 rounded bg-slate-800 text-slate-300">Scoped Stasi</span>
                <span class="px-2 py-0.5 rounded bg-slate-800 text-slate-300">Jadwal Misa</span>
            </div>
        </div>

        {{-- Admin KUB --}}
        <div class="rounded-2xl border border-slate-800 bg-slate-900/90 p-5 shadow-xl">
            <div class="flex items-center gap-3 mb-3">
                <div class="h-10 w-10 rounded-xl bg-teal-500/20 text-teal-400 flex items-center justify-center font-bold">
                    <i class="fa-solid fa-people-group text-base"></i>
                </div>
                <div>
                    <h3 class="font-outfit text-base font-bold text-white">Admin KUB</h3>
                    <span class="text-[11px] text-teal-400 font-medium">Basis Komunitas (Ujung Tombak)</span>
                </div>
            </div>
            <p class="text-xs text-slate-300 leading-relaxed">
                Menginput dan memutakhirkan Kartu Keluarga (KK) dan data jiwa anggotanya secara berkala, mengusulkan mutasi, dan mencatat kehadiran.
            </p>
            <div class="mt-4 pt-3 border-t border-slate-800/80 flex flex-wrap gap-1.5 text-[10px]">
                <span class="px-2 py-0.5 rounded bg-slate-800 text-slate-300">Entri Umat KUB</span>
                <span class="px-2 py-0.5 rounded bg-slate-800 text-slate-300">Mutasi Umat</span>
            </div>
        </div>

        {{-- Bendahara --}}
        <div class="rounded-2xl border border-slate-800 bg-slate-900/90 p-5 shadow-xl">
            <div class="flex items-center gap-3 mb-3">
                <div class="h-10 w-10 rounded-xl bg-yellow-500/20 text-yellow-400 flex items-center justify-center font-bold">
                    <i class="fa-solid fa-vault text-base"></i>
                </div>
                <div>
                    <h3 class="font-outfit text-base font-bold text-white">Bendahara</h3>
                    <span class="text-[11px] text-yellow-400 font-medium">Pengelolaan Finansial</span>
                </div>
            </div>
            <p class="text-xs text-slate-300 leading-relaxed">
                Mencatat iuran umat, kolekte misa, stipendium intensi, transaksi arus kas masuk/keluar, dan laporan pembukuan berkala.
            </p>
            <div class="mt-4 pt-3 border-t border-slate-800/80 flex flex-wrap gap-1.5 text-[10px]">
                <span class="px-2 py-0.5 rounded bg-slate-800 text-slate-300">Kas Paroki</span>
                <span class="px-2 py-0.5 rounded bg-slate-800 text-slate-300">Iuran Umat</span>
                <span class="px-2 py-0.5 rounded bg-slate-800 text-slate-300">Kolekte</span>
            </div>
        </div>

        {{-- Penulis / Komsos --}}
        <div class="rounded-2xl border border-slate-800 bg-slate-900/90 p-5 shadow-xl">
            <div class="flex items-center gap-3 mb-3">
                <div class="h-10 w-10 rounded-xl bg-rose-500/20 text-rose-400 flex items-center justify-center font-bold">
                    <i class="fa-solid fa-newspaper text-base"></i>
                </div>
                <div>
                    <h3 class="font-outfit text-base font-bold text-white">Penulis / Komsos</h3>
                    <span class="text-[11px] text-rose-400 font-medium">Komunikasi Sosial & Warta</span>
                </div>
            </div>
            <p class="text-xs text-slate-300 leading-relaxed">
                Membuat dan mempublikasikan artikel warta paroki, renungan harian, agenda kegiatan, pengumuman, dan galeri foto dokumentasi.
            </p>
            <div class="mt-4 pt-3 border-t border-slate-800/80 flex flex-wrap gap-1.5 text-[10px]">
                <span class="px-2 py-0.5 rounded bg-slate-800 text-slate-300">Warta Paroki</span>
                <span class="px-2 py-0.5 rounded bg-slate-800 text-slate-300">Galeri Foto</span>
                <span class="px-2 py-0.5 rounded bg-slate-800 text-slate-300">Pengumuman</span>
            </div>
        </div>

        {{-- Umat --}}
        <div class="rounded-2xl border border-slate-800 bg-slate-900/90 p-5 shadow-xl">
            <div class="flex items-center gap-3 mb-3">
                <div class="h-10 w-10 rounded-xl bg-slate-700/40 text-slate-300 flex items-center justify-center font-bold">
                    <i class="fa-solid fa-user text-base"></i>
                </div>
                <div>
                    <h3 class="font-outfit text-base font-bold text-white">Umat / Jemaat</h3>
                    <span class="text-[11px] text-slate-400 font-medium">Akses Mandiri</span>
                </div>
            </div>
            <p class="text-xs text-slate-300 leading-relaxed">
                Akses mandiri untuk memeriksa keabsahan data keluarga katolik, melihat riwayat iuran pribadi, dan informasi jadwal misa paroki.
            </p>
            <div class="mt-4 pt-3 border-t border-slate-800/80 flex flex-wrap gap-1.5 text-[10px]">
                <span class="px-2 py-0.5 rounded bg-slate-800 text-slate-300">Data Mandiri</span>
                <span class="px-2 py-0.5 rounded bg-slate-800 text-slate-300">Informasi</span>
            </div>
        </div>
    </div>
</div>
