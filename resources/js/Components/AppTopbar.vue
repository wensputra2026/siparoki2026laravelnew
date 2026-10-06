<script setup>
import { ref, computed, watch, inject, onMounted, onUnmounted } from 'vue';
import { Link } from '@inertiajs/vue3';
import { RoleMenuKey } from '../composables/useRoleMenu.js';
import { roleMenus } from '../menu/roleMenus.js';
import AppNotificationBell from './AppNotificationBell.vue';
import AppChatWidget from './AppChatWidget.vue';
import SearchableSelect from './SearchableSelect.vue';

defineProps({
    title: { type: String, default: 'Dashboard' },
});

const {
    page,
    isSidebarOpen,
    toggleSidebar,
    isMobileOpen,
    isSuperAdmin,
    activeRole,
    onRoleChange,
    pastorsList,
    selectedPastorId,
    wilayahList,
    selectedWilayahId,
    kapelaList,
    selectedKapelaId,
    kubList,
    selectedKubId,
    onScopeChange,
    getHref,
    isItemActive,
    userAvatar,
    userName,
    showLogoutModal,
} = inject(RoleMenuKey);

const isUserMenuOpen = ref(false);

// Realtime Clock & Screen Zoom Control (BIMKAT Spec)
const currentClock = ref('');
const currentZoom = ref(100);
let clockTimer = null;

const updateClock = () => {
    const now = new Date();
    const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    const day = days[now.getDay()];
    const date = now.getDate();
    const month = months[now.getMonth()];
    const year = now.getFullYear();
    const h = String(now.getHours()).padStart(2, '0');
    const m = String(now.getMinutes()).padStart(2, '0');
    const s = String(now.getSeconds()).padStart(2, '0');
    currentClock.value = `${day}, ${date} ${month} ${year} | ${h}:${m}:${s}`;
};

const changeZoom = (delta) => {
    currentZoom.value = Math.max(70, Math.min(130, currentZoom.value + delta));
    document.body.style.zoom = currentZoom.value + '%';
    localStorage.setItem('user_zoom', currentZoom.value);
};

const resetZoom = () => {
    currentZoom.value = 100;
    document.body.style.zoom = '100%';
    localStorage.setItem('user_zoom', 100);
};

// Induk Wilayah & Stasi untuk simulasi Admin KUB
const selectedKubParentId = ref(''); // e.g. 'w_17' or 'k_1'

const kubParentOptions = computed(() => {
    const list = [];
    if (wilayahList?.value && wilayahList.value.length > 0) {
        wilayahList.value.forEach(w => {
            list.push({
                id: 'w_' + w.id,
                rawId: w.id,
                type: 'wilayah',
                name: 'Wilayah: ' + (w.nama_wilayah || w.nama),
            });
        });
    }
    if (kapelaList?.value && kapelaList.value.length > 0) {
        kapelaList.value.forEach(k => {
            list.push({
                id: 'k_' + k.id,
                rawId: k.id,
                type: 'kapela',
                name: 'Stasi: ' + (k.nama_kapela || k.nama),
            });
        });
    }
    return list;
});

// Sinkronisasi otomatis: Jika KUB sudah terpilih sebelumnya, sesuaikan pilihan Wilayah / Stasi induknya
watch(
    () => [selectedKubId?.value, kubList?.value],
    () => {
        const kubId = selectedKubId?.value;
        if (!kubId) return;
        const kub = (kubList?.value || []).find(k => String(k.id) === String(kubId));
        if (kub) {
            if (kub.wilayah_id) {
                selectedKubParentId.value = 'w_' + kub.wilayah_id;
            } else if (kub.kapela_id) {
                selectedKubParentId.value = 'k_' + kub.kapela_id;
            }
        }
    },
    { immediate: true, deep: true }
);

// Filter KUB: Hanya tampilkan KUB di bawah Wilayah atau Stasi yang dipilih
const filteredKubsForAdminKub = computed(() => {
    const list = kubList?.value || [];
    if (!selectedKubParentId.value) {
        return [];
    }
    const [type, rawId] = selectedKubParentId.value.split('_');
    if (type === 'w') {
        return list.filter(k => String(k.wilayah_id) === String(rawId));
    }
    if (type === 'k') {
        return list.filter(k => String(k.kapela_id) === String(rawId));
    }
    return list;
});

const onKubParentChange = (val) => {
    selectedKubParentId.value = val || '';
    if (!val) {
        onScopeChange('kub_id', null);
    } else {
        const [type, rawId] = val.split('_');
        if (type === 'w') {
            onScopeChange('wilayah_id', rawId);
        } else if (type === 'k') {
            onScopeChange('kapela_id', rawId);
        }
        const currentKub = (kubList?.value || []).find(k => String(k.id) === String(selectedKubId?.value));
        if (currentKub) {
            const matches = (type === 'w' && String(currentKub.wilayah_id) === String(rawId))
                         || (type === 'k' && String(currentKub.kapela_id) === String(rawId));
            if (!matches) {
                onScopeChange('kub_id', null);
            }
        }
    }
};

const returnToSuperAdmin = () => {
    activeRole.value = 'Super Admin';
    onRoleChange();
};

const closeUserMenu = (e) => {
    if (!e.target.closest('#user-menu-container')) {
        isUserMenuOpen.value = false;
    }
};

onMounted(() => {
    updateClock();
    clockTimer = setInterval(updateClock, 1000);
    const saved = localStorage.getItem('user_zoom');
    if (saved) {
        const parsedZoom = parseInt(saved);
        if (!isNaN(parsedZoom) && parsedZoom !== 100) {
            currentZoom.value = parsedZoom;
            if (document.body.style.zoom !== parsedZoom + '%') {
                document.body.style.zoom = parsedZoom + '%';
            }
        }
    }
    document.addEventListener('click', closeUserMenu);
});

onUnmounted(() => {
    if (clockTimer) clearInterval(clockTimer);
    document.removeEventListener('click', closeUserMenu);
});
</script>

<template>
    <!-- 1. FIXED TOPBAR / HEADER (Exact BIMKAT Specification) -->
    <header class="h-16 w-full shrink-0 border-b border-slate-200/80 bg-white/95 backdrop-blur-md z-30 shadow-xs flex items-center justify-between px-3 sm:px-6 gap-3 select-none">
        
        <!-- Left: Push-Menu Toggle Button & Current Page Title -->
        <div class="flex items-center gap-2.5 sm:gap-3.5 min-w-0 shrink-0">
            <!-- Sidebar toggle desktop -->
            <button
                @click="toggleSidebar"
                type="button"
                class="hidden lg:flex items-center justify-center w-9 h-9 rounded-xl text-slate-600 hover:text-emerald-700 hover:bg-slate-100 transition-colors cursor-pointer shrink-0 border border-slate-200/80"
                title="Toggle Push Menu (Sidebar)"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>

            <!-- Sidebar toggle mobile -->
            <button
                @click="isMobileOpen = !isMobileOpen"
                type="button"
                class="lg:hidden flex items-center justify-center w-9 h-9 rounded-xl text-slate-600 hover:text-emerald-700 hover:bg-slate-100 transition-colors cursor-pointer shrink-0 border border-slate-200/80"
                title="Buka Menu"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>

            <!-- Page Title -->
            <h1 class="text-base sm:text-lg font-bold text-slate-800 tracking-tight truncate max-w-[200px] xs:max-w-[260px] sm:max-w-[400px]">
                {{ title }}
            </h1>
        </div>

        <!-- Right: Realtime Clock, Zoom Widget, Website Link, Role Controls, User Dropdown -->
        <div class="flex items-center gap-2 sm:gap-3 shrink-0 justify-end">

            <!-- Real-time Digital Clock Pill (BIMKAT Spec) -->
            <div class="hidden md:flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-100/90 border border-slate-200/80 text-xs font-semibold text-slate-700">
                <i class="bi bi-clock-history text-emerald-600 text-xs"></i>
                <span class="font-medium tracking-tight">{{ currentClock }}</span>
            </div>

            <!-- Screen Zoom Control Widget (BIMKAT Spec) -->
            <div class="hidden xl:flex items-center gap-1 px-2.5 py-1 rounded-xl bg-slate-100 border border-slate-200 text-xs font-medium text-slate-600">
                <span class="font-bold text-slate-800 text-[11px] min-w-[32px]">{{ currentZoom }}%</span>
                <button @click="changeZoom(-5)" class="w-5 h-5 rounded hover:bg-slate-200 flex items-center justify-center font-bold cursor-pointer" title="Perkecil Tampilan">-</button>
                <button @click="changeZoom(5)" class="w-5 h-5 rounded hover:bg-slate-200 flex items-center justify-center font-bold cursor-pointer" title="Perbesar Tampilan">+</button>
                <button @click="resetZoom()" class="px-1.5 py-0.5 rounded text-[10px] font-semibold text-slate-500 hover:text-slate-800 hover:bg-slate-200 cursor-pointer">Reset</button>
            </div>

            <!-- Quick Link: Lihat Website (BIMKAT Spec) -->
            <a
                href="/"
                target="_blank"
                class="hidden sm:inline-flex items-center gap-2 px-3.5 py-1.5 rounded-xl text-xs font-semibold text-slate-600 hover:text-emerald-700 bg-slate-100 hover:bg-emerald-50 border border-slate-200/70 transition-all cursor-pointer"
                title="Buka Website Publik Paroki"
            >
                <i class="bi bi-box-arrow-up-right text-emerald-600 text-xs"></i>
                <span>Lihat Website</span>
            </a>

            <!-- Role Switcher & Scoping Selectors (Preserved for Super Admin Simulation) -->
            <div v-if="isSuperAdmin" class="flex items-center gap-1 bg-slate-100/90 p-1 rounded-xl border border-slate-200 text-xs shrink-0">
                <select
                    v-model="activeRole"
                    @change="onRoleChange"
                    class="bg-white border border-slate-200 rounded-lg px-2 py-1 text-xs font-bold text-emerald-800 focus:outline-none focus:border-emerald-500 cursor-pointer shadow-2xs max-w-[130px] truncate"
                    title="Ganti Peran Aktif (Simulasi Hak Akses)"
                >
                    <option v-for="r in Object.keys(roleMenus)" :key="r" :value="r">
                        {{ r }}
                    </option>
                </select>

                <!-- Dynamic Pastor Selector -->
                <template v-if="activeRole === 'Pastor' && pastorsList.length > 0">
                    <div class="hidden xl:block w-36 2xl:w-44">
                        <SearchableSelect
                            v-model="selectedPastorId"
                            :options="pastorsList"
                            valueKey="id"
                            labelKey="nama_pastor"
                            placeholder="-- Semua Pastor --"
                            searchPlaceholder="Cari pastor..."
                            compact
                            dropdownMinWidth="min-w-[240px]"
                            @change="(val) => onScopeChange('pastor_id', val)"
                        />
                    </div>
                </template>

                <!-- Dynamic Wilayah Selector -->
                <template v-if="activeRole === 'Admin Wilayah' && wilayahList.length > 0">
                    <div class="hidden xl:block w-36 2xl:w-44">
                        <SearchableSelect
                            v-model="selectedWilayahId"
                            :options="wilayahList"
                            valueKey="id"
                            labelKey="nama_wilayah"
                            placeholder="-- Semua Wilayah --"
                            searchPlaceholder="Cari wilayah..."
                            compact
                            dropdownMinWidth="min-w-[240px]"
                            @change="(val) => onScopeChange('wilayah_id', val)"
                        />
                    </div>
                </template>

                <!-- Dynamic Kapela Selector -->
                <template v-if="activeRole === 'Admin Kapela / Stasi' && kapelaList.length > 0">
                    <div class="hidden xl:block w-40 2xl:w-48">
                        <SearchableSelect
                            v-model="selectedKapelaId"
                            :options="kapelaList"
                            valueKey="id"
                            labelKey="nama_kapela"
                            placeholder="-- Semua Stasi / Kapela --"
                            searchPlaceholder="Cari stasi / kapela..."
                            compact
                            dropdownMinWidth="min-w-[250px]"
                            @change="(val) => onScopeChange('kapela_id', val)"
                        />
                    </div>
                </template>

                <!-- Dynamic KUB Selector -->
                <template v-if="(activeRole === 'Admin KUB' || activeRole === 'Ketua KUB') && (kubParentOptions.length > 0 || kubList.length > 0)">
                    <div class="hidden xl:block w-40 2xl:w-48">
                        <SearchableSelect
                            v-model="selectedKubParentId"
                            :options="kubParentOptions"
                            valueKey="id"
                            labelKey="name"
                            placeholder="-- 1. Wilayah / Stasi --"
                            searchPlaceholder="Cari wilayah / stasi..."
                            compact
                            dropdownMinWidth="min-w-[260px]"
                            @change="onKubParentChange"
                        />
                    </div>
                    <div class="hidden xl:block w-44 2xl:w-56">
                        <SearchableSelect
                            v-model="selectedKubId"
                            :options="filteredKubsForAdminKub"
                            valueKey="id"
                            labelKey="nama_kub"
                            :placeholder="selectedKubParentId ? (filteredKubsForAdminKub.length > 0 ? '-- 2. Pilih KUB --' : 'Tidak ada KUB') : '-- Pilih Wilayah Dulu --'"
                            searchPlaceholder="Cari nama KUB..."
                            compact
                            dropdownMinWidth="min-w-[270px]"
                            :disabled="!selectedKubParentId"
                            @change="(val) => onScopeChange('kub_id', val)"
                        />
                    </div>
                </template>

                <!-- Quick Button: Return To Super Admin -->
                <button
                    v-if="activeRole !== 'Super Admin'"
                    type="button"
                    @click="returnToSuperAdmin"
                    class="inline-flex items-center justify-center gap-1 px-2 py-1 rounded-lg bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white text-[11px] font-bold shadow-xs transition cursor-pointer shrink-0"
                    title="Kembali ke Mode Penuh Super Admin"
                >
                    <i class="bi bi-arrow-counterclockwise text-xs"></i>
                    <span class="hidden 2xl:inline">Ke Super Admin</span>
                </button>
            </div>

            <!-- Static Role Badge for Non-Super Admin -->
            <div v-else class="hidden sm:flex items-center gap-1 px-2.5 py-1 rounded-xl bg-emerald-50 border border-emerald-200/80 text-xs font-bold text-emerald-900 shadow-2xs shrink-0">
                <i class="bi bi-shield-check text-emerald-600 text-xs"></i>
                <span class="truncate max-w-[120px]">{{ activeRole }}</span>
            </div>

            <!-- Panduan RBAC Pill -->
            <Link
                :href="getHref('/panduan-hak-akses')"
                class="hidden 2xl:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-amber-300 bg-amber-50 text-amber-800 text-xs font-bold shadow-2xs hover:bg-amber-100 transition cursor-pointer shrink-0"
            >
                <i class="bi bi-shield-check text-amber-600"></i>
                <span>Panduan RBAC</span>
            </Link>

            <!-- Real-time Internal Chat & Messaging -->
            <AppChatWidget
                v-if="$page.props.auth?.user?.is_super_admin || $page.props.fitur_chat_aktif !== false"
                class="shrink-0"
            />

            <!-- Real-time Notification Bell -->
            <AppNotificationBell class="shrink-0" />

            <!-- User Menu Container (Dropdown matching BIMKAT) -->
            <div id="user-menu-container" class="relative shrink-0">
                <button
                    type="button"
                    @click="isUserMenuOpen = !isUserMenuOpen"
                    class="inline-flex items-center gap-2 p-1 md:px-2 md:py-1 rounded-xl bg-slate-100 hover:bg-slate-200/80 border border-slate-200/80 text-slate-700 text-xs font-semibold transition cursor-pointer shadow-2xs shrink-0"
                    title="Menu Pengguna"
                >
                    <img
                        :src="userAvatar || '/images/avatar-default.jpg'"
                        alt="Foto Profil"
                        class="w-7 h-7 sm:w-8 sm:h-8 rounded-lg object-cover border border-emerald-500/40 shadow-2xs shrink-0"
                        @error="(e) => { e.target.onerror = null; e.target.src = '/images/avatar-default.jpg'; }"
                    />
                    <span class="hidden md:inline font-bold text-slate-800 truncate max-w-[120px]">{{ userName }}</span>
                    <i class="bi bi-chevron-down text-[11px] text-slate-400 hidden sm:inline ml-0.5 transition-transform duration-200" :class="{ 'rotate-180': isUserMenuOpen }"></i>
                </button>

                <!-- User Dropdown Popover Menu -->
                <transition
                    enter-active-class="transition duration-150 ease-out"
                    enter-from-class="transform scale-95 opacity-0"
                    enter-to-class="transform scale-100 opacity-100"
                    leave-active-class="transition duration-100 ease-in"
                    leave-from-class="transform scale-100 opacity-100"
                    leave-to-class="transform scale-95 opacity-0"
                >
                    <div
                        v-if="isUserMenuOpen"
                        class="absolute right-0 mt-2 w-56 rounded-2xl bg-white border border-slate-100 shadow-2xl z-50 overflow-hidden py-1.5 text-xs divide-y divide-slate-100"
                    >
                        <!-- Header User Info -->
                        <div class="px-4 py-2.5 bg-slate-50/80 flex items-center gap-2.5">
                            <img
                                :src="userAvatar || '/images/avatar-default.jpg'"
                                alt="Foto Profil"
                                class="w-9 h-9 rounded-lg object-cover border border-emerald-500/40 shrink-0"
                            />
                            <div class="min-w-0">
                                <p class="text-xs text-slate-400">Masuk sebagai</p>
                                <p class="font-bold text-slate-900 truncate">{{ userName }}</p>
                                <p class="text-[11px] text-emerald-600 font-semibold truncate">{{ activeRole }}</p>
                            </div>
                        </div>

                        <!-- Menu Links -->
                        <div class="py-1">
                            <Link
                                :href="getHref('/profil-saya')"
                                @click="isUserMenuOpen = false"
                                class="w-full px-4 py-2 hover:bg-slate-50 hover:text-emerald-800 text-slate-700 flex items-center gap-2.5 font-medium transition cursor-pointer"
                            >
                                <i class="bi bi-person text-slate-400 w-4"></i>
                                <span>Profil Saya</span>
                            </Link>

                            <Link
                                :href="getHref('/panduan-hak-akses')"
                                @click="isUserMenuOpen = false"
                                class="w-full px-4 py-2 hover:bg-slate-50 hover:text-amber-800 text-slate-700 flex items-center gap-2.5 font-medium transition cursor-pointer"
                            >
                                <i class="bi bi-shield-check text-amber-500 w-4"></i>
                                <span>Panduan Hak Akses</span>
                            </Link>

                            <a
                                href="/"
                                target="_blank"
                                class="w-full px-4 py-2 hover:bg-slate-50 hover:text-emerald-800 text-slate-700 flex items-center gap-2.5 font-medium transition cursor-pointer"
                            >
                                <i class="bi bi-globe text-emerald-600 w-4"></i>
                                <span>Situs Paroki Publik</span>
                            </a>
                        </div>

                        <!-- Logout -->
                        <div class="pt-1">
                            <button
                                type="button"
                                @click="isUserMenuOpen = false; showLogoutModal = true;"
                                class="w-full px-4 py-2 hover:bg-rose-50 text-rose-700 flex items-center gap-2.5 font-bold transition cursor-pointer text-left"
                            >
                                <i class="bi bi-box-arrow-right w-4 text-rose-500"></i>
                                <span>Keluar Aplikasi</span>
                            </button>
                        </div>
                    </div>
                </transition>
            </div>

        </div>

    </header>
</template>
