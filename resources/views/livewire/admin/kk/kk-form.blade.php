<div class="max-w-4xl mx-auto space-y-6">
    {{-- Header Banner --}}
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-slate-900 via-slate-800 to-amber-950 p-6 shadow-xl border border-slate-700/50">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="/{{ $prefix }}/kk-katolik" wire:navigate class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-800/80 text-slate-300 hover:text-white hover:bg-slate-700 transition-all border border-slate-700">
                    <i class="fa-solid fa-arrow-left text-sm"></i>
                </a>
                <div>
                    <h1 class="font-outfit text-xl font-bold tracking-tight text-white flex items-center gap-2">
                        <i class="fa-solid {{ $isEdit ? 'fa-pen-to-square text-amber-400' : 'fa-plus text-amber-400' }}"></i>
                        {{ $isEdit ? 'Edit Kartu Keluarga: ' . $no_kk_kw : 'Pendaftaran Kartu Keluarga (KK) Baru' }}
                    </h1>
                    <p class="font-sans text-xs text-slate-400 mt-0.5">
                        Lengkapi informasi kartu keluarga untuk sinkronisasi sensus pastoral umat paroki.
                    </p>
                </div>
            </div>
            <span class="hidden sm:inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/20 font-outfit">
                {{ $isEdit ? 'Mode Edit Data' : 'Formulir Baru' }}
            </span>
        </div>
    </div>

    {{-- Main Form Card --}}
    <form wire:submit="save" class="rounded-2xl border border-slate-800 bg-slate-900/90 shadow-xl backdrop-blur-sm p-6 space-y-8 font-sans">
        {{-- SECTION 1: Identitas KK & Kepala Keluarga --}}
        <div class="space-y-4">
            <div class="flex items-center gap-2 pb-2 border-b border-slate-800">
                <div class="h-6 w-1 bg-amber-500 rounded-full"></div>
                <h2 class="font-outfit text-sm font-bold uppercase tracking-wider text-slate-200">
                    1. Identitas KK & Kepala Keluarga
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">
                        Nomor KK Katolik (Gerejawi) <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        wire:model="no_kk_kw" 
                        placeholder="Contoh: K012001001"
                        class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-xs text-amber-400 font-mono font-bold focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500"
                    >
                    @error('no_kk_kw') <span class="text-[11px] text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">
                        Nomor KK Sipil (Dukcapil)
                    </label>
                    <input 
                        type="text" 
                        wire:model="no_kk_dukcapil" 
                        placeholder="16 Digit Nomor KK Nasional"
                        class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-xs text-white font-mono focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500"
                    >
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">
                        Nama Kepala Keluarga (Nama Lengkap & Baptis) <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        wire:model="nama_baptis_pemilik" 
                        placeholder="Contoh: Yohanes Petrus da Silva"
                        class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-xs text-white focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500"
                    >
                    @error('nama_baptis_pemilik') <span class="text-[11px] text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">
                        Nama Lahir / Sesuai KTP
                    </label>
                    <input 
                        type="text" 
                        wire:model="nama_lahir_pemilik" 
                        placeholder="Nama lahir di akta/KTP"
                        class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-xs text-white focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500"
                    >
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">
                        NIK Kepala Keluarga
                    </label>
                    <input 
                        type="text" 
                        wire:model="nik_pemilik" 
                        placeholder="16 Digit NIK"
                        class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-xs text-white font-mono focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500"
                    >
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">
                        Nama Istri / Pasangan
                    </label>
                    <input 
                        type="text" 
                        wire:model="nama_pasangan" 
                        placeholder="Nama pasangan jika sudah menikah"
                        class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-xs text-white focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500"
                    >
                </div>
            </div>
        </div>

        {{-- SECTION 2: Teritorial Paroki (Wilayah, Kapela, KUB) --}}
        <div class="space-y-4">
            <div class="flex items-center gap-2 pb-2 border-b border-slate-800">
                <div class="h-6 w-1 bg-amber-500 rounded-full"></div>
                <h2 class="font-outfit text-sm font-bold uppercase tracking-wider text-slate-200">
                    2. Teritorial Gerejawi Paroki
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">
                        Wilayah Pelayanan
                    </label>
                    <x-tom-select wire:model="wilayah_id" placeholder="-- Pilih Wilayah --">
                        <option value="">-- Pilih Wilayah --</option>
                        @foreach($wilayahList as $w)
                            <option value="{{ $w['id'] }}">{{ $w['nama_wilayah'] }}</option>
                        @endforeach
                    </x-tom-select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">
                        Stasi / Kapela
                    </label>
                    <x-tom-select wire:model="kapela_id" placeholder="-- Pilih Kapela --">
                        <option value="">-- Pilih Kapela --</option>
                        @foreach($kapelaList as $k)
                            <option value="{{ $k['id'] }}">{{ $k['nama_kapela'] }}</option>
                        @endforeach
                    </x-tom-select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">
                        Komunitas Umat Basis (KUB)
                    </label>
                    <x-tom-select wire:model="kub_id" placeholder="-- Pilih KUB --">
                        <option value="">-- Pilih KUB --</option>
                        @foreach($kubList as $kub)
                            <option value="{{ $kub['id'] }}">{{ $kub['nama_kub'] }}</option>
                        @endforeach
                    </x-tom-select>
                </div>
            </div>
        </div>

        {{-- SECTION 3: Alamat & Kontak --}}
        <div class="space-y-4">
            <div class="flex items-center gap-2 pb-2 border-b border-slate-800">
                <div class="h-6 w-1 bg-amber-500 rounded-full"></div>
                <h2 class="font-outfit text-sm font-bold uppercase tracking-wider text-slate-200">
                    3. Alamat Domisili & Kontak
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-300 mb-1">
                        Alamat Lengkap Tempat Tinggal
                    </label>
                    <textarea 
                        wire:model="alamat_sekarang" 
                        rows="2" 
                        placeholder="Nama jalan, gang, nomor rumah..."
                        class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-xs text-white focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500"
                    ></textarea>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">
                        Nomor Handphone / WhatsApp
                    </label>
                    <input 
                        type="text" 
                        wire:model="handphone" 
                        placeholder="08xxxxxxxxxx"
                        class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-xs text-white focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500"
                    >
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">
                        Email Keluarga
                    </label>
                    <input 
                        type="email" 
                        wire:model="email" 
                        placeholder="email@keluarga.com"
                        class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-xs text-white focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500"
                    >
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">
                        Status Kartu Keluarga
                    </label>
                    <select wire:model="status_kk" class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-xs text-white focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500">
                        <option value="Aktif">Aktif</option>
                        <option value="Nonaktif">Nonaktif</option>
                        <option value="Pindah">Pindah Paroki</option>
                        <option value="Meninggal">Semua Meninggal</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">
                        Kategori Ekonomi
                    </label>
                    <select wire:model="kategori_ekonomi" class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-xs text-white focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500">
                        <option value="Mampu">Mampu</option>
                        <option value="Cukup">Cukup / Sederhana</option>
                        <option value="Prasejahtera">Prasejahtera (Butuh Bantuan)</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-between pt-6 border-t border-slate-800">
            <a href="/{{ $prefix }}/kk-katolik" wire:navigate class="px-5 py-2.5 rounded-xl text-xs font-semibold text-slate-400 hover:text-white bg-slate-800 hover:bg-slate-700 transition-all font-outfit">
                Batal
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl text-xs font-bold text-slate-950 bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-300 hover:to-amber-400 transition-all shadow-md active:scale-95 font-outfit flex items-center gap-2">
                <i class="fa-solid fa-floppy-disk"></i>
                {{ $isEdit ? 'Simpan Perubahan KK' : 'Daftarkan KK Baru' }}
            </button>
        </div>
    </form>
</div>
