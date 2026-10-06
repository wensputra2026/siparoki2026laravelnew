<script setup>
import { inject, ref, onMounted } from 'vue';
import { Link } from '@inertiajs/vue3';
import { RoleMenuKey } from '../composables/useRoleMenu.js';
import { roleMenus } from '../menu/roleMenus.js';

const {
    isSidebarOpen,
    isMobileOpen,
    showLogoutModal,
    isMounted,
    activeRole,
    currentMenuTree,
    openGroups,
    toggleGroup,
    getHref,
    isItemActive,
    isGroupActive,
    userAvatar,
    userName,
    isSuperAdmin,
    showTukarPengguna,
} = inject(RoleMenuKey);

// Persistent scroll state agar posisi scroll menu tidak melompat saat berpindah halaman
const desktopScrollRef = ref(null);
let _savedDesktopScrollY = 0;

const onDesktopScroll = (e) => {
    _savedDesktopScrollY = e.target.scrollTop;
};

onMounted(() => {
    if (desktopScrollRef.value && _savedDesktopScrollY > 0) {
        desktopScrollRef.value.scrollTop = _savedDesktopScrollY;
    }
});

// BIMKAT Official Icon Mapper (Resolves to Bootstrap Icons)
const resolveIcon = (icon) => {
    if (!icon) return 'bi bi-dot';
    if (icon.startsWith('bi-')) return `bi ${icon}`;
    if (icon.startsWith('bi ')) return icon;
    const faToBiMap = {
        'fa-gauge-high': 'bi bi-grid-1x2-fill',
        'fa-gauge': 'bi bi-grid-1x2-fill',
        'fa-book-open': 'bi bi-book-half',
        'fa-church': 'bi bi-building',
        'fa-building-columns': 'bi bi-bank2',
        'fa-building': 'bi bi-building',
        'fa-place-of-worship': 'bi bi-house-door-fill',
        'fa-cross': 'bi bi-plus-circle',
        'fa-map-location-dot': 'bi bi-geo-alt-fill',
        'fa-compass': 'bi bi-compass-fill',
        'fa-people-group': 'bi bi-people-fill',
        'fa-map': 'bi bi-map-fill',
        'fa-city': 'bi bi-buildings',
        'fa-map-pin': 'bi bi-geo-alt',
        'fa-location-dot': 'bi bi-pin-map-fill',
        'fa-tags': 'bi bi-tags-fill',
        'fa-hands-holding-child': 'bi bi-heart-pulse-fill',
        'fa-users-gear': 'bi bi-people',
        'fa-book-open-reader': 'bi bi-journal-bookmark',
        'fa-hands-praying': 'bi bi-hand-thumbs-up-fill',
        'fa-user-tie': 'bi bi-person-workspace',
        'fa-timeline': 'bi bi-clock-history',
        'fa-layer-group': 'bi bi-collection-fill',
        'fa-user-check': 'bi bi-person-check-fill',
        'fa-calendar-check': 'bi bi-calendar-check-fill',
        'fa-calendar-day': 'bi bi-calendar-event',
        'fa-address-book': 'bi bi-person-lines-fill',
        'fa-house-chimney-user': 'bi bi-houses-fill',
        'fa-user': 'bi bi-person-fill',
        'fa-arrows-split-up-and-left': 'bi bi-arrow-left-right',
        'fa-book-skull': 'bi bi-bookmark-x-fill',
        'fa-chart-pie': 'bi bi-pie-chart-fill',
        'fa-book-bible': 'bi bi-book-fill',
        'fa-book-bookmark': 'bi bi-journal-check',
        'fa-file-signature': 'bi bi-pencil-square',
        'fa-shop': 'bi bi-shop',
        'fa-envelope-open-text': 'bi bi-envelope-paper-fill',
        'fa-inbox': 'bi bi-inbox-fill',
        'fa-paper-plane': 'bi bi-send-fill',
        'fa-folder-tree': 'bi bi-folder-fill',
        'fa-cloud-arrow-down': 'bi bi-cloud-arrow-down-fill',
        'fa-clipboard-question': 'bi bi-clipboard-check-fill',
        'fa-comments': 'bi bi-chat-dots-fill',
        'fa-newspaper': 'bi bi-newspaper',
        'fa-images': 'bi bi-images',
        'fa-sliders': 'bi bi-sliders',
        'fa-gear': 'bi bi-gear-fill',
        'fa-gears': 'bi bi-gear-wide-connected',
        'fa-shield-halved': 'bi bi-shield-check',
        'fa-user-shield': 'bi bi-shield-lock-fill',
        'fa-shield-virus': 'bi bi-shield-fill-exclamation',
        'fa-database': 'bi bi-database-fill-down',
        'fa-broom': 'bi bi-trash3-fill',
        'fa-key': 'bi bi-key-fill',
        'fa-arrow-right-from-bracket': 'bi bi-box-arrow-right',
    };
    if (faToBiMap[icon]) return faToBiMap[icon];
    if (icon.startsWith('fa-')) return `fa-solid ${icon}`;
    return icon;
};
</script>

<template>
    <!-- MOBILE SIDEBAR DRAWER (OFF-CANVAS - VATICAN THEME) -->
    <Transition
        enter-active-class="transition-opacity ease-linear duration-300"
        enter-from-class="opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="transition-opacity ease-linear duration-300"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
    >
        <div
            v-if="isMobileOpen"
            class="fixed inset-0 z-40 bg-slate-950/60 backdrop-blur-sm lg:hidden"
            @click="isMobileOpen = false"
        ></div>
    </Transition>

    <Transition
        enter-active-class="transition ease-in-out duration-300 transform"
        enter-from-class="-translate-x-full"
        enter-to-class="translate-x-0"
        leave-active-class="transition ease-in-out duration-300 transform"
        leave-from-class="translate-x-0"
        leave-to-class="-translate-x-full"
    >
        <aside
            v-if="isMobileOpen"
            class="vatikan-sidebar fixed inset-y-0 left-0 z-50 w-72 shadow-2xl flex flex-col lg:hidden border-r border-amber-300/50 bg-white"
        >
            <!-- Mobile Drawer Header (Vatican Gold Header) -->
            <div class="sidebar-brand min-h-16 py-2.5 px-4 flex items-center justify-between shrink-0 bg-gradient-to-r from-amber-500 via-amber-500 to-amber-600 border-b border-amber-600/40 shadow-xs">
                <Link :href="getHref('/dashboard')" preserve-scroll class="flex items-center gap-3 min-w-0" @click="isMobileOpen = false">
                    <div class="w-10 h-10 rounded-xl bg-white/20 p-1 flex items-center justify-center border border-white/40 shadow-sm shrink-0">
                        <img
                            :src="$page.props.app?.logo || '/images/church-logo.png'"
                            :alt="$page.props.app?.nama_paroki || 'Logo'"
                            class="w-full h-full object-contain rounded-lg"
                            @error="(e) => { e.target.onerror = null; e.target.src = '/images/church-logo.png'; }"
                        />
                    </div>
                    <div class="flex flex-col min-w-0 flex-1 pr-2">
                        <h1 class="font-black text-base tracking-wide text-white leading-tight drop-shadow-xs">
                            SIPAROKI
                        </h1>
                        <p class="text-[10px] text-amber-100 font-extrabold uppercase tracking-wide leading-snug whitespace-normal">
                            {{ $page.props.app?.nama_paroki || 'St. Vinsensius a Paulo - Benlutu' }}
                        </p>
                    </div>
                </Link>
                <button
                    @click="isMobileOpen = false"
                    class="w-8 h-8 rounded-lg text-white hover:bg-white/20 flex items-center justify-center transition cursor-pointer"
                >
                    <i class="bi bi-x-lg text-base"></i>
                </button>
            </div>

            <!-- Mobile Role Switcher (Vatican Gold Themed) -->
            <div class="p-3 bg-amber-50/90 border-b border-amber-200/80">
                <label class="text-[10px] font-black uppercase text-amber-950 block mb-1">Ganti Peran Pengguna:</label>
                <select
                    v-model="activeRole"
                    class="w-full bg-white border border-amber-300 rounded-xl px-3 py-2 text-xs font-bold text-amber-950 focus:outline-none focus:border-amber-500 cursor-pointer shadow-2xs"
                >
                    <option v-for="r in Object.keys(roleMenus)" :key="r" :value="r" class="bg-white text-slate-900">
                        {{ r }}
                    </option>
                </select>
            </div>

            <!-- Nav Scrollable Menu Area -->
            <div class="flex-1 py-3 px-3 space-y-3 overflow-y-auto sidebar-scroll bg-white">
                <div v-for="section in currentMenuTree" :key="section.section" class="space-y-1">
                    <div class="px-3 pt-2 pb-1 text-[10px] font-black uppercase tracking-wider text-amber-950 flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                        <span>{{ section.section }}</span>
                    </div>

                    <div v-for="item in section.menus" :key="item.name">
                        <!-- Logout Action Item -->
                        <button
                            v-if="item.action === 'logout'"
                            type="button"
                            @click="showLogoutModal = true; isMobileOpen = false;"
                            class="w-full flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold text-rose-600 hover:bg-rose-50 hover:text-rose-700 transition-all duration-150 group text-left cursor-pointer"
                        >
                            <i class="bi bi-box-arrow-right text-center w-5 text-base text-rose-500 group-hover:scale-110 transition-transform"></i>
                            <span class="truncate">{{ item.name }}</span>
                        </button>

                        <!-- Single Menu Item (No Submenus) -->
                        <Link
                            v-else-if="!item.submenus"
                            :href="getHref(item.href)"
                            :data-active="isItemActive(item.href)"
                            preserve-scroll
                            @click="isMobileOpen = false"
                            :class="[
                                'flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold transition-all duration-150 group',
                                isItemActive(item.href)
                                    ? 'bg-gradient-to-r from-amber-500 to-amber-600 text-white font-bold border-l-4 border-amber-300 shadow-md shadow-amber-500/20'
                                    : 'text-slate-700 hover:bg-amber-100/70 hover:text-amber-950',
                            ]"
                        >
                            <i :class="[
                                'text-center w-5 text-base transition-transform group-hover:scale-110 shrink-0',
                                isItemActive(item.href) ? 'text-white' : 'text-amber-600 group-hover:text-amber-700',
                                resolveIcon(item.icon)
                            ]"></i>
                            <span class="truncate">{{ item.name }}</span>
                        </Link>

                        <!-- Menu Item with Submenus -->
                        <div v-else class="space-y-0.5">
                            <button
                                type="button"
                                @click="toggleGroup(item.name)"
                                :class="[
                                    'w-full flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold transition-all duration-150 text-left group cursor-pointer',
                                    isGroupActive(item)
                                        ? 'bg-amber-100/80 text-amber-950 font-bold border-l-3 border-amber-500'
                                        : 'text-slate-700 hover:bg-amber-100/70 hover:text-amber-950',
                                ]"
                            >
                                <div class="flex items-center gap-3 min-w-0">
                                    <i :class="[
                                        'text-center w-5 text-base transition-transform group-hover:scale-110 shrink-0',
                                        isGroupActive(item) ? 'text-amber-700' : 'text-amber-600 group-hover:text-amber-700',
                                        resolveIcon(item.icon)
                                    ]"></i>
                                    <span class="truncate">{{ item.name }}</span>
                                </div>
                                <i
                                    :class="[
                                        'bi bi-chevron-down text-[11px] text-slate-400 group-hover:text-amber-700 transition-transform duration-200 shrink-0',
                                        openGroups[item.name] ? 'rotate-180 text-amber-600 font-bold' : '',
                                    ]"
                                ></i>
                            </button>

                            <div
                                v-show="openGroups[item.name]"
                                class="pl-3.5 pr-0.5 space-y-0.5 border-l-2 border-amber-300/70 ml-4 my-1"
                            >
                                <Link
                                    v-for="sub in item.submenus"
                                    :key="sub.name"
                                    :href="getHref(sub.href)"
                                    :data-active="isItemActive(sub.href)"
                                    preserve-scroll
                                    @click="isMobileOpen = false"
                                    :class="[
                                        'flex items-center gap-2.5 px-2.5 py-1.5 rounded-lg text-xs font-medium transition-all duration-150 group',
                                        isItemActive(sub.href)
                                            ? 'bg-amber-100 text-amber-950 font-bold border-l-2.5 border-amber-600 shadow-2xs'
                                            : 'text-slate-600 hover:text-amber-950 hover:bg-amber-50',
                                    ]"
                                >
                                    <i :class="[
                                        'text-[13px] w-4 text-center shrink-0',
                                        isItemActive(sub.href) ? 'text-amber-700' : 'text-amber-600/80 group-hover:text-amber-700',
                                        resolveIcon(sub.icon)
                                    ]"></i>
                                    <span class="truncate">{{ sub.name }}</span>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mobile Drawer Footer (Vatican Theme) -->
            <div class="sidebar-profile p-3 shrink-0 bg-slate-50 border-t border-slate-200/80">
                <div class="px-1 mb-1.5 text-[10px] font-black uppercase tracking-wider text-amber-950">
                    AKUN SAYA
                </div>
                <div class="flex items-center gap-2.5 p-2 rounded-xl bg-white border border-slate-200 shadow-2xs mb-2">
                    <img
                        :src="userAvatar || '/images/avatar-default.jpg'"
                        alt="Foto Profil"
                        class="w-8 h-8 rounded-lg object-cover border-2 border-amber-400 shrink-0"
                        @error="(e) => { e.target.onerror = null; e.target.src = '/images/avatar-default.jpg'; }"
                    />
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-bold text-slate-900 truncate">{{ userName }}</p>
                        <span class="inline-block text-[10px] font-extrabold text-amber-700 truncate">{{ activeRole }}</span>
                    </div>
                </div>
                <!-- Tukar Pengguna (hanya Super Admin) -->
                <button
                    v-if="isSuperAdmin"
                    type="button"
                    @click="showTukarPengguna = true; isMobileOpen = false;"
                    class="w-full flex items-center gap-2 px-3 py-2 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white text-xs font-bold mb-2 transition cursor-pointer shadow-xs border border-amber-600/30"
                >
                    <i class="bi bi-person-gear text-white text-sm"></i>
                    <span>Tukar Pengguna</span>
                    <i class="bi bi-arrow-right-short ml-auto text-amber-200"></i>
                </button>
                <div class="grid grid-cols-2 gap-2">
                    <Link
                        :href="getHref('/profil-saya')"
                        preserve-scroll
                        @click="isMobileOpen = false"
                        class="flex items-center justify-center gap-1.5 px-2 py-1.5 rounded-lg bg-white border border-slate-200 text-slate-700 text-[11px] font-semibold hover:bg-slate-50 transition"
                    >
                        <i class="bi bi-person text-xs text-amber-600"></i>
                        <span>Profil</span>
                    </Link>
                    <button
                        type="button"
                        @click="showLogoutModal = true; isMobileOpen = false;"
                        class="flex items-center justify-center gap-1.5 px-2 py-1.5 rounded-lg bg-rose-50 border border-rose-200 text-rose-700 text-[11px] font-semibold hover:bg-rose-100 transition cursor-pointer"
                    >
                        <i class="bi bi-box-arrow-right text-xs"></i>
                        <span>Keluar</span>
                    </button>
                </div>
            </div>
        </aside>
    </Transition>

    <!-- 2. FIXED SIDEBAR DESKTOP (VATICAN THEME: KUNING - PUTIH) -->
    <aside
        :class="[
            'hidden lg:flex flex-col vatikan-sidebar shrink-0 select-none shadow-xl h-full overflow-hidden z-30 bg-white border-r border-amber-300/40',
            isMounted ? 'transition-[width] duration-300 ease-in-out' : '',
            isSidebarOpen ? 'w-72' : 'w-20',
        ]"
    >
        <!-- Sidebar Brand Header (Vatican Gold Header) -->
        <div class="sidebar-brand min-h-16 py-2 px-3.5 shrink-0 flex items-center justify-between bg-gradient-to-r from-amber-500 via-amber-500 to-amber-600 border-b border-amber-600/40 shadow-xs">
            <Link :href="getHref('/dashboard')" preserve-scroll class="flex items-center gap-3 group min-w-0">
                <div class="w-10 h-10 rounded-xl bg-white/20 p-1 flex items-center justify-center border border-white/40 shadow-sm group-hover:scale-105 transition-transform shrink-0">
                    <img
                        :src="$page.props.app?.logo || '/images/church-logo.png'"
                        :alt="$page.props.app?.nama_paroki || 'Logo'"
                        class="w-full h-full object-contain rounded-lg"
                        @error="(e) => { e.target.onerror = null; e.target.src = '/images/church-logo.png'; }"
                    />
                </div>
                <div v-show="isSidebarOpen" class="flex flex-col min-w-0 flex-1">
                    <span class="text-base font-black text-white tracking-wide leading-tight drop-shadow-xs">SIPAROKI</span>
                    <span class="text-[10px] text-amber-100 font-extrabold uppercase tracking-wide leading-snug whitespace-normal">
                        {{ $page.props.app?.nama_paroki || 'St. Vinsensius a Paulo - Benlutu' }}
                    </span>
                </div>
            </Link>
        </div>

        <!-- Nav Scrollable Menu Area (Preserves Scroll Position) -->
        <div
            ref="desktopScrollRef"
            @scroll="onDesktopScroll"
            class="flex-1 py-3 px-3 space-y-3 overflow-y-auto sidebar-scroll bg-white"
        >
            <div v-for="section in currentMenuTree" :key="section.section" class="space-y-1">
                <!-- Section Heading in Deep Amber/Gold for Maximum Contrast -->
                <div
                    v-show="isSidebarOpen"
                    class="px-3 pt-2 pb-1 text-[10px] font-black uppercase tracking-wider text-amber-950 flex items-center gap-1.5"
                >
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                    <span>{{ section.section }}</span>
                </div>

                <!-- Menu Items in Section -->
                <div v-for="item in section.menus" :key="item.name" class="space-y-0.5">
                    <!-- Logout Action Item -->
                    <button
                        v-if="item.action === 'logout'"
                        type="button"
                        @click="showLogoutModal = true"
                        class="w-full flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold text-rose-600 hover:bg-rose-50 hover:text-rose-700 transition-all duration-150 group text-left cursor-pointer"
                        title="Keluar / Logout"
                    >
                        <i class="bi bi-box-arrow-right text-center w-5 text-base text-rose-500 group-hover:scale-110 transition-transform"></i>
                        <span v-show="isSidebarOpen" class="truncate">{{ item.name }}</span>
                    </button>

                    <!-- Single Link (No Submenu) -->
                    <Link
                        v-else-if="!item.submenus"
                        :href="getHref(item.href)"
                        :data-active="isItemActive(item.href)"
                        :title="item.name"
                        preserve-scroll
                        :class="[
                            'flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-semibold transition-all duration-150 group',
                            isItemActive(item.href)
                                ? 'bg-gradient-to-r from-amber-500 to-amber-600 text-white font-bold border-l-4 border-amber-300 shadow-md shadow-amber-500/20'
                                : 'text-slate-700 hover:bg-amber-100/70 hover:text-amber-950',
                        ]"
                    >
                        <i :class="[
                            'text-center w-5 text-base transition-transform group-hover:scale-110 shrink-0',
                            isItemActive(item.href) ? 'text-white' : 'text-amber-600 group-hover:text-amber-700',
                            resolveIcon(item.icon)
                        ]"></i>
                        <span v-show="isSidebarOpen" class="truncate">{{ item.name }}</span>
                    </Link>

                    <!-- Collapsible Parent with Submenus -->
                    <div v-else class="space-y-0.5">
                        <button
                            type="button"
                            @click="toggleGroup(item.name)"
                            :class="[
                                'w-full flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold transition-all duration-150 text-left group cursor-pointer',
                                isGroupActive(item)
                                    ? 'bg-amber-100/80 text-amber-950 font-bold border-l-3 border-amber-500'
                                    : 'text-slate-700 hover:bg-amber-100/70 hover:text-amber-950',
                            ]"
                        >
                            <div class="flex items-center gap-3 min-w-0">
                                <i :class="[
                                    'text-center w-5 text-base transition-transform group-hover:scale-110 shrink-0',
                                    isGroupActive(item) ? 'text-amber-700' : 'text-amber-600 group-hover:text-amber-700',
                                    resolveIcon(item.icon)
                                ]"></i>
                                <span v-show="isSidebarOpen" class="truncate">{{ item.name }}</span>
                            </div>
                            <i
                                v-show="isSidebarOpen"
                                :class="[
                                    'bi bi-chevron-down text-[11px] text-slate-400 group-hover:text-amber-700 transition-transform duration-200 shrink-0',
                                    openGroups[item.name] ? 'rotate-180 text-amber-600 font-bold' : '',
                                ]"
                            ></i>
                        </button>

                        <!-- Submenu Items -->
                        <div
                            v-show="isSidebarOpen && openGroups[item.name]"
                            class="pl-3.5 pr-0.5 space-y-0.5 border-l-2 border-amber-300/70 ml-4 my-1"
                        >
                            <Link
                                v-for="sub in item.submenus"
                                :key="sub.name"
                                :href="getHref(sub.href)"
                                :data-active="isItemActive(sub.href)"
                                :title="sub.name"
                                preserve-scroll
                                :class="[
                                    'flex items-center gap-2.5 px-2.5 py-1.5 rounded-lg text-xs font-medium transition-all duration-150 group',
                                    isItemActive(sub.href)
                                        ? 'bg-amber-100 text-amber-950 font-bold border-l-2.5 border-amber-600 shadow-2xs'
                                        : 'text-slate-600 hover:text-amber-950 hover:bg-amber-50',
                                ]"
                            >
                                <i :class="[
                                    'text-[13px] w-4 text-center shrink-0',
                                    isItemActive(sub.href) ? 'text-amber-700' : 'text-amber-600/80 group-hover:text-amber-700',
                                    resolveIcon(sub.icon)
                                ]"></i>
                                <span class="min-w-0 flex-1 truncate">{{ sub.name }}</span>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Profile Box at Bottom (Vatican Theme) -->
        <div class="sidebar-profile p-3 shrink-0 bg-slate-50 border-t border-slate-200/80">
            <div v-show="isSidebarOpen" class="px-1 mb-1.5 text-[10px] font-black uppercase tracking-wider text-amber-950">
                AKUN SAYA
            </div>
            <div class="flex items-center gap-2.5 p-2 rounded-xl bg-white border border-slate-200 shadow-2xs">
                <img
                    :src="userAvatar || '/images/avatar-default.jpg'"
                    alt="Foto Profil"
                    class="w-8 h-8 rounded-lg object-cover border-2 border-amber-400 shrink-0"
                    @error="(e) => { e.target.onerror = null; e.target.src = '/images/avatar-default.jpg'; }"
                />
                <div v-show="isSidebarOpen" class="flex-1 min-w-0">
                    <p class="text-xs font-bold text-slate-900 truncate">{{ userName }}</p>
                    <span class="inline-block text-[10px] font-extrabold text-amber-700 truncate">{{ activeRole }}</span>
                </div>
            </div>
            <!-- Tukar Pengguna Button (Desktop, hanya Super Admin) -->
            <button
                v-if="isSuperAdmin"
                type="button"
                @click="showTukarPengguna = true"
                :title="!isSidebarOpen ? 'Tukar Pengguna' : undefined"
                :class="[
                    'w-full flex items-center gap-2 px-3 py-2 mt-2 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white text-xs font-bold transition cursor-pointer shadow-xs border border-amber-600/30',
                    !isSidebarOpen ? 'justify-center' : '',
                ]"
            >
                <i class="bi bi-person-gear text-white text-base shrink-0"></i>
                <span v-show="isSidebarOpen" class="truncate">Tukar Pengguna</span>
                <i v-show="isSidebarOpen" class="bi bi-arrow-right-short ml-auto text-amber-200"></i>
            </button>
        </div>
    </aside>
</template>
