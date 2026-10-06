<div class="max-w-4xl mx-auto space-y-6">
    {{-- Header Banner --}}
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-slate-900 via-slate-800 to-amber-950 p-6 shadow-xl border border-slate-700/50">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="/{{ $prefix }}/master-pastor" wire:navigate class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-800/80 text-slate-300 hover:text-white hover:bg-slate-700 transition-all border border-slate-700">
                    <i class="fa-solid fa-arrow-left text-sm"></i>
                </a>
                <div>
                    <h1 class="font-outfit text-xl font-bold tracking-tight text-white flex items-center gap-2">
                        <i class="fa-solid {{ $isEdit ? 'fa-pen-to-square text-amber-400' : 'fa-plus text-amber-400' }}"></i>
                        {{ $isEdit ? 'Edit Data Pastor: ' . $nama_pastor : 'Tambah Pastor / Gembala Baru' }}
                    </h1>
                    <p class="font-sans text-xs text-slate-400 mt-0.5">
                        Kelola data kanonik, tahbisan, tugas pastoral, dan ordo para pastor.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <form wire:submit="save" class="rounded-2xl border border-slate-800 bg-slate-900/90 shadow-xl backdrop-blur-sm p-6 space-y-8 font-sans">
        {{-- SECTION 1: Identitas & Jabatan --}}
        <div class="space-y-4">
            <div class="flex items-center gap-2 pb-2 border-b border-slate-800">
                <div class="h-6 w-1 bg-amber-500 rounded-full"></div>
                <h2 class="font-outfit text-sm font-bold uppercase tracking-wider text-slate-200">
                    1. Identitas & Jabatan Gerejawi
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Gelar Depan</label>
                    <select wire:model="gelar_depan" class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-xs text-white focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500">
                        <option value="RD.">RD. (Reverendus Dominus - Praja)</option>
                        <option value="RP.">RP. (Reverendus Pater - Ordo)</option>
                        <option value="Mgr.">Mgr. (Monseigneur - Uskup)</option>
                        <option value="Fr.">Fr. (Frater / Diakon)</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Nama Lengkap Pastor <span class="text-rose-500">*</span></label>
                    <input type="text" wire:model="nama_pastor" placeholder="Contoh: Krispinus Saku" class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-xs text-white focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500">
                    @error('nama_pastor') <span class="text-[11px] text-rose-400 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Jabatan di Paroki <span class="text-rose-500">*</span></label>
                    <input type="text" wire:model="jabatan" placeholder="Pastor Paroki / Pastor Rekan" class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-xs text-white focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Jenis Imam</label>
                    <select wire:model="jenis_imam" class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-xs text-white focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500">
                        <option value="Diosesan / Projo">Diosesan / Projo (Praja Keuskupan)</option>
                        <option value="Religius / Kongregasi">Religius / Kongregasi (Ordo)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Ordo / Kongregasi</label>
                    <input type="text" wire:model="ordo" placeholder="CM, SVD, OFM, OCD, dll." class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-xs text-white focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500">
                </div>
            </div>
        </div>

        {{-- SECTION 2: Tahbisan & Motto --}}
        <div class="space-y-4">
            <div class="flex items-center gap-2 pb-2 border-b border-slate-800">
                <div class="h-6 w-1 bg-amber-500 rounded-full"></div>
                <h2 class="font-outfit text-sm font-bold uppercase tracking-wider text-slate-200">
                    2. Data Tahbisan & Kontak
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Tanggal Tahbisan Imamat</label>
                    <input type="date" wire:model="tanggal_tahbisan" class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-xs text-white focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Motto Tahbisan Imamat</label>
                    <input type="text" wire:model="motto_tahbisan" placeholder="Contoh: Mazmur 23:1 - Tuhan adalah Gembalaku..." class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-xs text-white focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Nomor WhatsApp / HP</label>
                    <input type="text" wire:model="no_hp" placeholder="08xxxxxxxxxx" class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-xs text-white focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Email</label>
                    <input type="email" wire:model="email" placeholder="pastor@paroki.org" class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-xs text-white focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Status Pelayanan</label>
                    <select wire:model="status" class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-xs text-white focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500">
                        <option value="Aktif">Aktif Bertugas</option>
                        <option value="Purnatugas">Purnatugas / Emeritus</option>
                        <option value="Studi">Tugas Belajar</option>
                    </select>
                </div>

                <div class="md:col-span-3">
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Foto Pastor</label>
                    <input type="file" wire:model="foto" accept="image/*" class="w-full px-3 py-2 bg-slate-950 border border-slate-700 rounded-xl text-xs text-slate-400 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-amber-500 file:text-slate-950 hover:file:bg-amber-400">
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-between pt-4 border-t border-slate-800">
            <a href="/{{ $prefix }}/master-pastor" wire:navigate class="px-5 py-2.5 rounded-xl text-xs font-semibold text-slate-400 hover:text-white bg-slate-800 hover:bg-slate-700 transition-all font-outfit">
                Batal
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl text-xs font-bold text-slate-950 bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-300 hover:to-amber-400 transition-all shadow-md active:scale-95 font-outfit flex items-center gap-2">
                <i class="fa-solid fa-floppy-disk"></i>
                {{ $isEdit ? 'Simpan Perubahan' : 'Simpan Pastor' }}
            </button>
        </div>
    </form>
</div>
