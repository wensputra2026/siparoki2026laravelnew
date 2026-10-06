<div class="max-w-4xl mx-auto space-y-6">
    {{-- Header Banner --}}
    <div class="relative overflow-hidden rounded-2xl bg-linear-to-r from-amber-700 via-amber-800 to-slate-900 p-6 shadow-xl border border-amber-600/30 text-white">
        <div class="flex items-center gap-4">
            <div class="relative shrink-0">
                @if($foto)
                    <img src="{{ $foto->temporaryUrl() }}" class="h-16 w-16 rounded-2xl object-cover border-2 border-amber-400 shadow-md">
                @elseif($currentFoto)
                    <img src="{{ siparoki_asset($currentFoto, '/images/avatar-user.jpg') }}" class="h-16 w-16 rounded-2xl object-cover border-2 border-amber-400 shadow-md" onerror="this.src='/images/avatar-user.jpg'">
                @else
                    <div class="h-16 w-16 rounded-2xl bg-white/10 text-amber-300 border border-white/20 flex items-center justify-center text-2xl font-bold font-heading shadow-inner">
                        {{ strtoupper(substr($nama_lengkap ?: 'U', 0, 1)) }}
                    </div>
                @endif
            </div>
            <div>
                <h1 class="font-heading text-2xl font-extrabold tracking-tight text-white flex items-center gap-2">
                    {{ $nama_lengkap }}
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-400 text-slate-950 shadow-xs font-heading">
                        {{ $user?->role?->nama_role ?? 'Administrator' }}
                    </span>
                </h1>
                <p class="font-sans text-xs text-amber-100 mt-1 font-medium">
                    {{ $email }} &bull; Username: <span class="font-mono text-amber-300 font-bold">{{ $username }}</span>
                </p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 font-sans">
        {{-- Profile Details Card --}}
        <div class="lg:col-span-2 rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-md p-6 space-y-6">
            <div class="flex items-center gap-2 pb-3 border-b border-slate-200 dark:border-slate-800">
                <div class="h-6 w-1 bg-amber-500 rounded-full"></div>
                <h2 class="font-heading text-sm font-bold uppercase tracking-wider text-slate-800 dark:text-slate-100">
                    Informasi Profil & Akun
                </h2>
            </div>

            @if(session()->has('success_profile'))
                <div class="rounded-xl border border-emerald-300 dark:border-emerald-800 bg-emerald-50 dark:bg-emerald-950/60 p-3.5 text-emerald-800 dark:text-emerald-200 text-xs flex items-center gap-2 font-semibold shadow-xs">
                    <i class="fa-solid fa-circle-check text-emerald-600 dark:text-emerald-400"></i>
                    <span>{{ session('success_profile') }}</span>
                </div>
            @endif

            <form wire:submit="updateProfile" class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1 font-heading">Nama Lengkap</label>
                    <input type="text" wire:model="nama_lengkap" class="w-full px-3.5 py-2.5 bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white font-medium focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500">
                    @error('nama_lengkap') <span class="text-[11px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1 font-heading">Username</label>
                        <input type="text" wire:model="username" class="w-full px-3.5 py-2.5 bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white font-mono font-medium focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500">
                        @error('username') <span class="text-[11px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1 font-heading">Nomor Handphone / WA</label>
                        <input type="text" wire:model="no_hp" class="w-full px-3.5 py-2.5 bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white font-medium focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500">
                        @error('no_hp') <span class="text-[11px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1 font-heading">Alamat Email</label>
                    <input type="email" wire:model="email" class="w-full px-3.5 py-2.5 bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white font-medium focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500">
                    @error('email') <span class="text-[11px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1 font-heading">Foto Profil / Avatar Baru</label>
                    <input type="file" wire:model="foto" accept="image/*" class="w-full px-3 py-2 bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 rounded-xl text-xs text-slate-700 dark:text-slate-300 file:mr-3 file:py-1.5 file:px-3.5 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-amber-500 file:text-white hover:file:bg-amber-600 cursor-pointer">
                    @error('foto') <span class="text-[11px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="pt-3 flex justify-end">
                    <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-linear-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 transition-all shadow-md font-heading flex items-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i>
                        <span>Simpan Profil</span>
                    </button>
                </div>
            </form>
        </div>

        {{-- Change Password Card --}}
        <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-md p-6 space-y-6">
            <div class="flex items-center gap-2 pb-3 border-b border-slate-200 dark:border-slate-800">
                <div class="h-6 w-1 bg-amber-500 rounded-full"></div>
                <h2 class="font-heading text-sm font-bold uppercase tracking-wider text-slate-800 dark:text-slate-100">
                    Ubah Kata Sandi
                </h2>
            </div>

            @if(session()->has('success_password'))
                <div class="rounded-xl border border-emerald-300 dark:border-emerald-800 bg-emerald-50 dark:bg-emerald-950/60 p-3.5 text-emerald-800 dark:text-emerald-200 text-xs flex items-center gap-2 font-semibold shadow-xs">
                    <i class="fa-solid fa-circle-check text-emerald-600 dark:text-emerald-400"></i>
                    <span>{{ session('success_password') }}</span>
                </div>
            @endif

            <form wire:submit="updatePassword" class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1 font-heading">Kata Sandi Saat Ini</label>
                    <input type="password" wire:model="current_password" class="w-full px-3.5 py-2.5 bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white font-medium focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500">
                    @error('current_password') <span class="text-[11px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1 font-heading">Kata Sandi Baru</label>
                    <input type="password" wire:model="new_password" class="w-full px-3.5 py-2.5 bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white font-medium focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500">
                    @error('new_password') <span class="text-[11px] text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1 font-heading">Konfirmasi Kata Sandi Baru</label>
                    <input type="password" wire:model="new_password_confirmation" class="w-full px-3.5 py-2.5 bg-white dark:bg-slate-950 border border-slate-300 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white font-medium focus:outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500">
                </div>

                <div class="pt-3">
                    <button type="submit" class="w-full px-4 py-2.5 rounded-xl text-xs font-bold text-white bg-linear-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 transition-all shadow-md font-heading flex items-center justify-center gap-2">
                        <i class="fa-solid fa-key"></i>
                        <span>Perbarui Kata Sandi</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
