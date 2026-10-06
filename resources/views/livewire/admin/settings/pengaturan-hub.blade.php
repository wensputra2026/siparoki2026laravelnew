<div class="space-y-6 font-sans" x-data="{ tab: @entangle('activeTab') }">
    {{-- Header Banner --}}
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-slate-900 via-slate-800 to-amber-950 p-6 shadow-xl border border-slate-700/50">
        <div class="flex items-center gap-3">
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-500/20 text-amber-400 border border-amber-500/30 shadow-inner">
                <i class="fa-solid fa-sliders text-xl"></i>
            </div>
            <div>
                <h1 class="font-outfit text-2xl font-bold tracking-tight text-white flex items-center gap-2">
                    Pengaturan Terpadu Aplikasi Paroki
                </h1>
                <p class="text-xs text-slate-400 mt-1">
                    Konfigurasi integrasi gerbang pembayaran, notifikasi WhatsApp OTP, optimasi SEO, dan pemeliharaan web.
                </p>
            </div>
        </div>

        {{-- Nav Tabs --}}
        <div class="flex items-center gap-2 mt-6 overflow-x-auto pb-1 border-t border-slate-800/80 pt-4 font-outfit text-xs">
            <button @click="tab = 'pembayaran'" :class="tab === 'pembayaran' ? 'bg-amber-500 text-slate-950 font-bold shadow-md' : 'text-slate-400 hover:text-white hover:bg-slate-800'" class="px-4 py-2 rounded-xl transition-all whitespace-nowrap">
                <i class="fa-solid fa-credit-card mr-1.5"></i>
                Metode Pembayaran
            </button>
            <button @click="tab = 'midtrans'" :class="tab === 'midtrans' ? 'bg-amber-500 text-slate-950 font-bold shadow-md' : 'text-slate-400 hover:text-white hover:bg-slate-800'" class="px-4 py-2 rounded-xl transition-all whitespace-nowrap">
                <i class="fa-solid fa-bolt mr-1.5"></i>
                Midtrans Gateway
            </button>
            <button @click="tab = 'otp'" :class="tab === 'otp' ? 'bg-amber-500 text-slate-950 font-bold shadow-md' : 'text-slate-400 hover:text-white hover:bg-slate-800'" class="px-4 py-2 rounded-xl transition-all whitespace-nowrap">
                <i class="fa-brands fa-whatsapp mr-1.5"></i>
                WhatsApp & OTP
            </button>
            <button @click="tab = 'seo'" :class="tab === 'seo' ? 'bg-amber-500 text-slate-950 font-bold shadow-md' : 'text-slate-400 hover:text-white hover:bg-slate-800'" class="px-4 py-2 rounded-xl transition-all whitespace-nowrap">
                <i class="fa-solid fa-magnifying-glass-chart mr-1.5"></i>
                SEO & Meta Tags
            </button>
        </div>
    </div>

    {{-- TAB 1: METODE PEMBAYARAN --}}
    <div x-show="tab === 'pembayaran'" class="rounded-2xl border border-slate-800 bg-slate-900/90 shadow-xl p-6 space-y-6">
        <div class="flex items-center justify-between pb-3 border-b border-slate-800">
            <h3 class="font-outfit text-sm font-bold text-white flex items-center gap-2">
                <i class="fa-solid fa-money-check-dollar text-amber-400"></i>
                Daftar Rekening Bank & QRIS Paroki
            </h3>
        </div>

        <div class="overflow-x-auto rounded-xl border border-slate-800">
            <table class="w-full text-left text-xs text-slate-300">
                <thead class="bg-slate-950/80 text-[11px] font-bold uppercase tracking-wider text-slate-400 border-b border-slate-800">
                    <tr>
                        <th class="p-3 w-12 text-center">No</th>
                        <th class="p-3">Nama Bank / Channel</th>
                        <th class="p-3">Nomor Rekening</th>
                        <th class="p-3">Atas Nama</th>
                        <th class="p-3">Tipe</th>
                        <th class="p-3 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    @forelse($pembayaranList as $idx => $p)
                        <tr class="hover:bg-slate-800/40 transition-colors">
                            <td class="p-3 text-center text-slate-500">{{ $idx + 1 }}</td>
                            <td class="p-3 font-bold text-white font-outfit">{{ $p->nama_bank }}</td>
                            <td class="p-3 font-mono text-amber-400">{{ $p->nomor_rekening ?: '-' }}</td>
                            <td class="p-3 text-slate-300">{{ $p->atas_nama ?: '-' }}</td>
                            <td class="p-3">
                                <span class="px-2 py-0.5 rounded text-[10px] bg-slate-800 text-slate-300">{{ $p->tipe }}</span>
                            </td>
                            <td class="p-3 text-center">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold {{ $p->status === 'Aktif' ? 'bg-emerald-500/15 text-emerald-400' : 'bg-slate-700 text-slate-400' }}">
                                    {{ $p->status ?: 'Aktif' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-500">
                                Belum ada metode pembayaran yang terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- TAB 2: MIDTRANS GATEWAY --}}
    <div x-show="tab === 'midtrans'" class="rounded-2xl border border-slate-800 bg-slate-900/90 shadow-xl p-6 space-y-6">
        <div class="flex items-center justify-between pb-3 border-b border-slate-800">
            <h3 class="font-outfit text-sm font-bold text-white flex items-center gap-2">
                <i class="fa-solid fa-bolt text-amber-400"></i>
                Konfigurasi Midtrans Snap & Payment Gateway
            </h3>
        </div>

        @if(session()->has('success_midtrans'))
            <div class="rounded-xl border border-emerald-500/30 bg-emerald-500/10 p-3 text-emerald-400 text-xs flex items-center gap-2">
                <i class="fa-solid fa-circle-check"></i>
                <span>{{ session('success_midtrans') }}</span>
            </div>
        @endif

        <form wire:submit="saveMidtrans" class="space-y-4 max-w-2xl">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Environment</label>
                    <select wire:model="midtrans_environment" class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-xs text-white focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500">
                        <option value="sandbox">Sandbox (Testing / Uji Coba)</option>
                        <option value="production">Production (Live)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Merchant ID</label>
                    <input type="text" wire:model="midtrans_merchant_id" placeholder="G12345678" class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-xs text-white font-mono focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Client Key</label>
                    <input type="text" wire:model="midtrans_client_key" placeholder="SB-Mid-client-..." class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-xs text-white font-mono focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Server Key</label>
                    <input type="password" wire:model="midtrans_server_key" placeholder="SB-Mid-server-..." class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-xs text-white font-mono focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500">
                </div>

                <div class="md:col-span-2">
                    <label class="flex items-center gap-2.5 cursor-pointer">
                        <input type="checkbox" wire:model="midtrans_is_active" class="rounded border-slate-700 bg-slate-950 text-amber-500 focus:ring-amber-500/30">
                        <span class="text-xs text-slate-300">Aktifkan Pembayaran Otomatis Midtrans</span>
                    </label>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-800">
                <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-bold text-slate-950 bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-300 hover:to-amber-400 transition-all font-outfit shadow-md">
                    Simpan Konfigurasi Midtrans
                </button>
            </div>
        </form>
    </div>

    {{-- TAB 3: WHATSAPP OTP --}}
    <div x-show="tab === 'otp'" class="rounded-2xl border border-slate-800 bg-slate-900/90 shadow-xl p-6 space-y-6">
        <div class="flex items-center justify-between pb-3 border-b border-slate-800">
            <h3 class="font-outfit text-sm font-bold text-white flex items-center gap-2">
                <i class="fa-brands fa-whatsapp text-emerald-400"></i>
                Konfigurasi WhatsApp Gateway & Notifikasi OTP
            </h3>
        </div>

        @if(session()->has('success_otp'))
            <div class="rounded-xl border border-emerald-500/30 bg-emerald-500/10 p-3 text-emerald-400 text-xs flex items-center gap-2">
                <i class="fa-solid fa-circle-check"></i>
                <span>{{ session('success_otp') }}</span>
            </div>
        @endif

        <form wire:submit="saveOtp" class="space-y-4 max-w-2xl">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Provider WhatsApp Gateway</label>
                    <select wire:model="otp_provider" class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-xs text-white focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500">
                        <option value="Fonnte">Fonnte</option>
                        <option value="Waba">WhatsApp Cloud API (Meta)</option>
                        <option value="Wablas">Wablas</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Nomor Pengirim (Sender Number)</label>
                    <input type="text" wire:model="otp_sender_number" placeholder="628123456789" class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-xs text-white font-mono focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-300 mb-1">API Key / Token</label>
                    <input type="password" wire:model="otp_api_key" placeholder="Token dari provider..." class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-xs text-white font-mono focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Format Pesan OTP</label>
                    <textarea wire:model="otp_template" rows="2" class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-xs text-white focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500"></textarea>
                    <span class="text-[11px] text-slate-500 mt-1 block">Gunakan tag <code>&#123;&#123;otp&#125;&#125;</code> untuk kode acak 6 digit.</span>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-800">
                <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-bold text-slate-950 bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-300 hover:to-amber-400 transition-all font-outfit shadow-md">
                    Simpan Konfigurasi WhatsApp
                </button>
            </div>
        </form>
    </div>

    {{-- TAB 4: SEO & META TAGS --}}
    <div x-show="tab === 'seo'" class="rounded-2xl border border-slate-800 bg-slate-900/90 shadow-xl p-6 space-y-6">
        <div class="flex items-center justify-between pb-3 border-b border-slate-800">
            <h3 class="font-outfit text-sm font-bold text-white flex items-center gap-2">
                <i class="fa-solid fa-magnifying-glass-chart text-amber-400"></i>
                Optimasi Mesin Pencari (SEO) & Pemeliharaan Web
            </h3>
        </div>

        @if(session()->has('success_seo'))
            <div class="rounded-xl border border-emerald-500/30 bg-emerald-500/10 p-3 text-emerald-400 text-xs flex items-center gap-2">
                <i class="fa-solid fa-circle-check"></i>
                <span>{{ session('success_seo') }}</span>
            </div>
        @endif

        <form wire:submit="saveSeo" class="space-y-4 max-w-2xl">
            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-1">Judul Situs (Meta Title)</label>
                <input type="text" wire:model="meta_title" class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-xs text-white focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-1">Deskripsi Situs (Meta Description)</label>
                <textarea wire:model="meta_description" rows="2" class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-xs text-white focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500"></textarea>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-300 mb-1">Kata Kunci (Keywords)</label>
                <input type="text" wire:model="meta_keywords" placeholder="paroki, benlutu, keuskupan agung kupang, jadwal misa" class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-xs text-white focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500">
            </div>

            <div class="pt-4 border-t border-slate-800 space-y-3">
                <label class="flex items-center gap-2.5 cursor-pointer">
                    <input type="checkbox" wire:model="is_maintenance" class="rounded border-slate-700 bg-slate-950 text-amber-500 focus:ring-amber-500/30">
                    <span class="text-xs font-semibold text-rose-400">Aktifkan Mode Pemeliharaan (Maintenance Mode)</span>
                </label>

                <div x-show="$wire.is_maintenance">
                    <label class="block text-xs font-semibold text-slate-300 mb-1">Pesan Pemeliharaan untuk Pengunjung</label>
                    <textarea wire:model="maintenance_message" rows="2" class="w-full px-3.5 py-2.5 bg-slate-950 border border-slate-700 rounded-xl text-xs text-white focus:outline-none focus:ring-2 focus:ring-amber-500/40 focus:border-amber-500"></textarea>
                </div>
            </div>

            <div class="pt-4 border-t border-slate-800">
                <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-bold text-slate-950 bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-300 hover:to-amber-400 transition-all font-outfit shadow-md">
                    Simpan Pengaturan SEO
                </button>
            </div>
        </form>
    </div>
</div>
