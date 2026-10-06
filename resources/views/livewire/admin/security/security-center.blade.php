<div class="space-y-6 font-sans">
    {{-- Header Banner --}}
    <div class="relative overflow-hidden rounded-2xl bg-white dark:bg-slate-900 p-6 shadow-xs border border-slate-200/80 dark:border-slate-800">
        <div class="flex items-center gap-3.5">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-500/20 shadow-xs">
                <i class="bi bi-shield-lock text-2xl"></i>
            </div>
            <div>
                <h1 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white flex items-center gap-2">
                    Security Center &amp; Firewall Server
                </h1>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                    Pusat pemantauan keamanan, kebijakan pencegahan brute force, dan pengelolaan daftar hitam IP.
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Policy Settings --}}
        <div class="rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-xs p-6 space-y-5">
            <div class="flex items-center gap-2 pb-3 border-b border-slate-100 dark:border-slate-800">
                <div class="h-5 w-1 bg-amber-500 rounded-full"></div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-slate-200">
                    Kebijakan Proteksi Login
                </h3>
            </div>

            <form wire:submit="saveSettings" class="space-y-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Maksimal Percobaan Login Gagal</label>
                    <input type="number" wire:model="max_login_attempts" class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Durasi Kunci Akun (Menit)</label>
                    <input type="number" wire:model="lockout_minutes" class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Waktu Sesi Berakhir (Menit)</label>
                    <input type="number" wire:model="session_timeout_minutes" class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500">
                </div>

                <div class="space-y-3 pt-2">
                    <label class="flex items-center gap-2.5 cursor-pointer">
                        <input type="checkbox" wire:model="enable_brute_force_protection" class="rounded border-slate-300 dark:border-slate-700 text-amber-500 focus:ring-amber-500/30">
                        <span class="text-xs text-slate-700 dark:text-slate-300">Aktifkan Proteksi Anti Brute Force</span>
                    </label>

                    <label class="flex items-center gap-2.5 cursor-pointer">
                        <input type="checkbox" wire:model="force_strong_password" class="rounded border-slate-300 dark:border-slate-700 text-amber-500 focus:ring-amber-500/30">
                        <span class="text-xs text-slate-700 dark:text-slate-300">Wajibkan Kata Sandi Kuat</span>
                    </label>
                </div>

                <div class="pt-4 border-t border-slate-100 dark:border-slate-800">
                    <button type="submit" class="w-full py-2.5 rounded-xl text-xs font-bold text-white bg-amber-500 hover:bg-amber-600 transition shadow-xs cursor-pointer">
                        Simpan Kebijakan
                    </button>
                </div>
            </form>
        </div>

        {{-- Blocked IPs & Manual Firewall --}}
        <div class="lg:col-span-2 rounded-2xl border border-slate-200/80 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-xs p-6 space-y-6">
            <div class="flex items-center gap-2 pb-3 border-b border-slate-100 dark:border-slate-800">
                <div class="h-5 w-1 bg-amber-500 rounded-full"></div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-800 dark:text-slate-200">
                    Daftar Hitam IP (Firewall)
                </h3>
            </div>

            {{-- Manual Block Form --}}
            <form wire:submit="blockIp" class="flex flex-col sm:flex-row gap-3">
                <input type="text" wire:model="newIp" placeholder="Masukkan Alamat IP (contoh: 192.168.1.100)" class="flex-1 px-3.5 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500 font-mono">
                <input type="text" wire:model="reason" placeholder="Alasan pemblokiran (opsional)" class="flex-1 px-3.5 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500">
                <button type="submit" class="px-4 py-2.5 rounded-xl text-xs font-bold text-white bg-rose-600 hover:bg-rose-500 transition whitespace-nowrap shadow-xs cursor-pointer">
                    <i class="bi bi-slash-circle mr-1.5"></i>
                    Blokir IP
                </button>
            </form>
            @error('newIp') <span class="text-[11px] text-rose-500 block -mt-2">{{ $message }}</span> @enderror

            {{-- Table Blocked IPs --}}
            <div class="overflow-x-auto rounded-xl border border-slate-200/80 dark:border-slate-800 admin-table-wrap">
                <table class="w-full text-left text-xs text-slate-600 dark:text-slate-300">
                    <thead class="bg-slate-50 dark:bg-slate-800/80 text-[11px] font-extrabold uppercase tracking-wider text-slate-500 dark:text-slate-400 border-b border-slate-200/80 dark:border-slate-800">
                        <tr>
                            <th class="p-3.5">Alamat IP</th>
                            <th class="p-3.5">Alasan</th>
                            <th class="p-3.5">Waktu Pemblokiran</th>
                            <th class="p-3.5 text-right pr-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @forelse($blockedIps as $b)
                            <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-800/40 transition-colors">
                                <td class="p-3.5 font-mono text-rose-600 dark:text-rose-400 font-semibold">{{ $b->ip_address }}</td>
                                <td class="p-3.5 text-slate-700 dark:text-slate-300">{{ $b->reason ?: 'Manual' }}</td>
                                <td class="p-3.5 text-slate-500 dark:text-slate-400">{{ \Carbon\Carbon::parse($b->created_at)->format('d M Y, H:i') }}</td>
                                <td class="p-3.5 text-right pr-4">
                                    <button wire:click="unblockIp({{ $b->id }})" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold text-emerald-700 dark:text-emerald-300 bg-emerald-50 dark:bg-emerald-950/60 hover:bg-emerald-100 dark:hover:bg-emerald-900/60 transition border border-emerald-200 dark:border-emerald-800 cursor-pointer">
                                        <i class="bi bi-unlock text-xs"></i>
                                        Buka Blokir
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-8 text-center text-slate-400">
                                    Tidak ada alamat IP yang sedang diblokir.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
