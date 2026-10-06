<div>
    @php
        $currentPrefix = explode('/', trim(request()->path(), '/'))[0] ?? 'admin';
        if (!in_array($currentPrefix, ['admin', 'superadmin', 'paroki', 'pastor', 'wilayah', 'kapela', 'kub', 'bendahara', 'penulis', 'umat'])) {
            $currentPrefix = 'admin';
        }
    @endphp

    <!-- Form Header -->
    <div class="flex items-center justify-between gap-4 mb-6">
        <div>
            <div class="flex items-center gap-2 text-xs font-medium text-slate-500 dark:text-slate-400 mb-1">
                <a href="{{ url("/{$currentPrefix}/umat") }}" wire:navigate class="hover:text-amber-600 transition-colors">Data Umat</a>
                <span>/</span>
                <span class="text-slate-800 dark:text-slate-200 font-semibold">{{ $isEdit ? 'Edit Umat' : 'Tambah Umat Baru' }}</span>
            </div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-400 flex items-center justify-center">
                    <i class="fa-solid fa-{{ $isEdit ? 'user-pen' : 'user-plus' }} text-lg"></i>
                </div>
                <span>{{ $isEdit ? 'Perbarui Data Umat' : 'Pendaftaran Umat Baru' }}</span>
            </h1>
        </div>

        <a href="{{ url("/{$currentPrefix}/umat") }}" wire:navigate
            class="px-4 py-2 rounded-xl border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 font-semibold text-xs hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors flex items-center gap-1.5">
            <i class="fa-solid fa-arrow-left text-xs"></i>
            <span>Kembali ke Daftar</span>
        </a>
    </div>

    <form wire:submit.prevent="save" class="space-y-6">

        <!-- Card 1: Identitas Pribadi -->
        <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800/80 shadow-xs">
            <h3 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider mb-4 pb-3 border-b border-slate-100 dark:border-slate-800/60 flex items-center gap-2">
                <i class="fa-solid fa-id-card text-amber-500"></i>
                <span>Identitas Pribadi</span>
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                
                <!-- Nama Lengkap -->
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                        Nama Lengkap Sesuai KTP <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" wire:model="nama_lengkap" placeholder="Contoh: Petrus Paulus Bria"
                        class="w-full px-3.5 py-2.5 rounded-xl text-xs bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-amber-500 focus:outline-none transition-all">
                    @error('nama_lengkap') <span class="text-[11px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Nama Baptis -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                        Nama Baptis / Santo Pelindung
                    </label>
                    <input type="text" wire:model="nama_baptis" placeholder="Contoh: Petrus, Maria, Yohanes"
                        class="w-full px-3.5 py-2.5 rounded-xl text-xs bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-amber-500 focus:outline-none transition-all">
                </div>

                <!-- NIK -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                        Nomor Induk Kependudukan (NIK)
                    </label>
                    <input type="text" wire:model="nik" placeholder="16 digit angka NIK" maxlength="20"
                        class="w-full px-3.5 py-2.5 rounded-xl text-xs bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-slate-100 font-mono focus:ring-2 focus:ring-amber-500 focus:outline-none transition-all">
                    @error('nik') <span class="text-[11px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <!-- Jenis Kelamin -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                        Jenis Kelamin <span class="text-rose-500">*</span>
                    </label>
                    <select wire:model="jenis_kelamin"
                        class="w-full px-3.5 py-2.5 rounded-xl text-xs bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-amber-500 focus:outline-none transition-all">
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>

                <!-- Hubungan Keluarga -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                        Hubungan dalam Keluarga
                    </label>
                    <select wire:model="hubungan_keluarga"
                        class="w-full px-3.5 py-2.5 rounded-xl text-xs bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-amber-500 focus:outline-none transition-all">
                        <option value="Kepala Keluarga">Kepala Keluarga</option>
                        <option value="Istri">Istri</option>
                        <option value="Anak">Anak</option>
                        <option value="Orang Tua">Orang Tua</option>
                        <option value="Mertua">Mertua</option>
                        <option value="Famili Lain">Famili Lain</option>
                    </select>
                </div>

                <!-- Tempat Lahir -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                        Tempat Lahir
                    </label>
                    <input type="text" wire:model="tempat_lahir" placeholder="Kota / Desa Kelahiran"
                        class="w-full px-3.5 py-2.5 rounded-xl text-xs bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-amber-500 focus:outline-none transition-all">
                </div>

                <!-- Tanggal Lahir -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                        Tanggal Lahir
                    </label>
                    <input type="date" wire:model="tanggal_lahir"
                        class="w-full px-3.5 py-2.5 rounded-xl text-xs bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-amber-500 focus:outline-none transition-all">
                </div>

                <!-- Golongan Darah -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                        Golongan Darah
                    </label>
                    <select wire:model="golongan_darah"
                        class="w-full px-3.5 py-2.5 rounded-xl text-xs bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-amber-500 focus:outline-none transition-all">
                        <option value="">- Belum Diketahui -</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="AB">AB</option>
                        <option value="O">O</option>
                    </select>
                </div>

            </div>
        </div>

        <!-- Card 2: Teritorial & Keluarga (Tom Select v2.3.1 Powered) -->
        <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800/80 shadow-xs">
            <h3 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider mb-4 pb-3 border-b border-slate-100 dark:border-slate-800/60 flex items-center gap-2">
                <i class="fa-solid fa-place-of-worship text-amber-500"></i>
                <span>Keluarga (KK) & Wilayah Gerejawi</span>
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <!-- Tom Select: Hubungkan ke KK Katolik -->
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                        Hubungkan ke KK Katolik (Cari Kepala Keluarga / No. KK)
                    </label>
                    <x-tom-select wire:model="kk_id" placeholder="Pilih KK Katolik...">
                        @foreach($kks as $kk)
                            <option value="{{ $kk->id }}">
                                {{ $kk->nama_lahir_pemilik ?? $kk->nama_baptis_pemilik }} ({{ $kk->no_kk_kw ?? 'No KK -' }})
                            </option>
                        @endforeach
                    </x-tom-select>
                </div>

                <!-- Tom Select: Kapela / Stasi -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                        Kapela / Stasi
                    </label>
                    <x-tom-select wire:model="kapela_id" placeholder="Pilih Kapela / Stasi...">
                        @foreach($kapelas as $k)
                            <option value="{{ $k->id }}">{{ $k->nama_kapela }}</option>
                        @endforeach
                    </x-tom-select>
                </div>

                <!-- Tom Select: Wilayah Rohani -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                        Wilayah Rohani
                    </label>
                    <x-tom-select wire:model="wilayah_id" placeholder="Pilih Wilayah Rohani...">
                        @foreach($wilayahs as $w)
                            <option value="{{ $w->id }}">{{ $w->nama_wilayah }}</option>
                        @endforeach
                    </x-tom-select>
                </div>

                <!-- Tom Select: Komunitas Umat Basis (KUB) -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                        Komunitas Umat Basis (KUB)
                    </label>
                    <x-tom-select wire:model="kub_id" placeholder="Pilih KUB...">
                        @foreach($kubs as $kub)
                            <option value="{{ $kub->id }}">{{ $kub->nama_kub }}</option>
                        @endforeach
                    </x-tom-select>
                </div>

                <!-- Status Perkawinan Kanonik -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                        Status Perkawinan
                    </label>
                    <select wire:model="status_menikah"
                        class="w-full px-3.5 py-2.5 rounded-xl text-xs bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-amber-500 focus:outline-none transition-all">
                        <option value="Belum Menikah">Belum Menikah</option>
                        <option value="Menikah Katolik (Kanonik)">Menikah Katolik (Kanonik)</option>
                        <option value="Menikah Beda Agama">Menikah Beda Agama</option>
                        <option value="Duda">Duda</option>
                        <option value="Janda">Janda</option>
                    </select>
                </div>

            </div>
        </div>

        <!-- Card 3: Sakramen Inisiasi -->
        <div class="p-6 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800/80 shadow-xs">
            <h3 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-wider mb-4 pb-3 border-b border-slate-100 dark:border-slate-800/60 flex items-center gap-2">
                <i class="fa-solid fa-cross text-amber-500"></i>
                <span>Catatan Sakramen Gereja</span>
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                
                <!-- Status Baptis -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                        Status Penerimaan Baptis
                    </label>
                    <select wire:model="status_baptis"
                        class="w-full px-3.5 py-2.5 rounded-xl text-xs bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-amber-500 focus:outline-none transition-all">
                        <option value="Sudah">Sudah Dibaptis</option>
                        <option value="Belum">Belum Dibaptis</option>
                        <option value="Katekumen">Calon Baptis (Katekumen)</option>
                    </select>
                </div>

                <!-- Tanggal Baptis -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                        Tanggal Sakramen Baptis
                    </label>
                    <input type="date" wire:model="tgl_baptis"
                        class="w-full px-3.5 py-2.5 rounded-xl text-xs bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-amber-500 focus:outline-none transition-all">
                </div>

                <!-- Nomor Buku Baptis -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                        Nomor Buku / Surat Baptis
                    </label>
                    <input type="text" wire:model="buku_baptis_no" placeholder="Contoh: No. 124/Lib.Bat/2020"
                        class="w-full px-3.5 py-2.5 rounded-xl text-xs bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-slate-100 font-mono focus:ring-2 focus:ring-amber-500 focus:outline-none transition-all">
                </div>

                <!-- Paroki Baptis -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                        Gereja / Paroki Tempat Baptis
                    </label>
                    <input type="text" wire:model="paroki_baptis" placeholder="Contoh: Paroki St. Vinsensius a Paulo Benlutu"
                        class="w-full px-3.5 py-2.5 rounded-xl text-xs bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-amber-500 focus:outline-none transition-all">
                </div>

                <!-- Komuni Pertama -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                        Tanggal Komuni Pertama
                    </label>
                    <input type="date" wire:model="tgl_komuni_1"
                        class="w-full px-3.5 py-2.5 rounded-xl text-xs bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-amber-500 focus:outline-none transition-all">
                </div>

                <!-- Krisma -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                        Tanggal Sakramen Krisma / Penguatan
                    </label>
                    <input type="date" wire:model="tgl_krisma"
                        class="w-full px-3.5 py-2.5 rounded-xl text-xs bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-amber-500 focus:outline-none transition-all">
                </div>

            </div>
        </div>

        <!-- Form Submit Bar -->
        <div class="flex items-center justify-end gap-3 pt-4">
            <a href="{{ url("/{$currentPrefix}/umat") }}" wire:navigate
                class="px-5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 font-semibold text-xs hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                Batal
            </a>
            <button type="submit"
                class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white font-semibold text-xs shadow-md shadow-amber-500/20 transition-all duration-200 active:scale-95 flex items-center gap-2">
                <i class="fa-solid fa-floppy-disk"></i>
                <span>{{ $isEdit ? 'Simpan Perubahan' : 'Simpan Data Umat' }}</span>
            </button>
        </div>

    </form>

</div>
