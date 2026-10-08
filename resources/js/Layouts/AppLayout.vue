<script setup>
import { provide, ref, onMounted, watch } from 'vue';
import { useRoleMenu, RoleMenuKey } from '../composables/useRoleMenu.js';
import AppTopbar from '../Components/AppTopbar.vue';
import AppSidebar from '../Components/AppSidebar.vue';
import AppToast from '../Components/AppToast.vue';
import AppLogoutModal from '../Components/AppLogoutModal.vue';
import TukarPenggunaModal from '../Components/TukarPenggunaModal.vue';

const props = defineProps({
    title: {
        type: String,
        default: 'Dashboard',
    },
    role: {
        type: String,
        default: '',
    },
    prefix: {
        type: String,
        default: '',
    },
    fullWidth: {
        type: Boolean,
        default: false,
    },
});

const showTukarPengguna = ref(false);

const menu = useRoleMenu(props);
provide(RoleMenuKey, { ...menu, showTukarPengguna });

// Destructure ke top-level agar ref ter-auto-unwrap di template.
// (Akses via `menu.xxx` tidak di-unwrap karena menu adalah plain object.)
const {
    showToast,
    toastMessage,
    toastType,
    toastIsPersistent,
    showLogoutModal,
    confirmLogout,
    page,
    activeRole,
    leaveImpersonation,
    isSuperAdmin,
} = menu;

// Synchronize browser tab favicon with active parish logo
const syncFavicon = () => {
    const iconUrl = page.props.app?.favicon || page.props.app?.logo;
    if (!iconUrl) return;
    const fullUrl = iconUrl.startsWith('http') ? iconUrl : (iconUrl.startsWith('/') ? iconUrl : '/' + iconUrl);
    const links = document.querySelectorAll("link[rel*='icon']");
    if (links.length > 0) {
        links.forEach(el => {
            el.href = fullUrl;
        });
    } else {
        const link = document.createElement('link');
        link.rel = 'icon';
        link.href = fullUrl;
        document.head.appendChild(link);
    }
};

onMounted(() => {
    syncFavicon();
});

watch(() => page.props.app?.logo, () => {
    syncFavicon();
});
</script>

<template>
    <!-- Fixed Full Height Shell -->
    <div class="h-screen w-full overflow-hidden bg-slate-50 text-slate-800 flex flex-col font-sans selection:bg-amber-500 selection:text-white">
        <!-- 1. FIXED TOPBAR / HEADER -->
        <AppTopbar :title="title" />

        <!-- IMPERSONATION SIMULATION BANNER -->
        <div
            v-if="page.props.impersonating"
            class="w-full bg-gradient-to-r from-amber-700 via-amber-600 to-amber-700 text-white px-3 sm:px-6 py-2 text-xs flex items-center justify-between shadow-md z-40 shrink-0 border-b border-amber-500/40"
        >
            <div class="flex items-center gap-2 truncate">
                <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-white/20 text-[11px] shrink-0">
                    <i class="bi bi-person-gear"></i>
                </span>
                <span class="truncate">
                    Mode Simulasi Akun: Anda sedang masuk sebagai <strong class="text-amber-100 underline decoration-amber-300 underline-offset-2">{{ page.props.auth?.user?.name }}</strong> 
                    ({{ page.props.auth?.user?.role }}{{ page.props.auth?.user?.nama_kub ? ' • ' + page.props.auth?.user?.nama_kub : '' }})
                </span>
            </div>
            <button
                type="button"
                @click="leaveImpersonation"
                class="ml-3 shrink-0 inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-white text-amber-900 hover:bg-amber-50 font-bold text-[11px] shadow-sm transition cursor-pointer"
            >
                <i class="bi bi-box-arrow-right text-[10px]"></i>
                <span>Kembali ke Super Admin</span>
            </button>
        </div>

        <!-- FLOATING TOAST NOTIFICATION -->
        <AppToast
            :show="showToast"
            :message="toastMessage"
            :type="toastType"
            :persistent="toastIsPersistent"
            @close="showToast = false"
        />

        <!-- LOGOUT CONFIRMATION MODAL -->
        <AppLogoutModal
            :show="showLogoutModal"
            @confirm="confirmLogout"
            @cancel="showLogoutModal = false"
        />

        <!-- TUKAR PENGGUNA MODAL (Impersonasi) -->
        <TukarPenggunaModal
            v-if="isSuperAdmin"
            :show="showTukarPengguna"
            @close="showTukarPengguna = false"
        />

        <!-- Body Area: Fixed Sidebar + Scrollable Content -->
        <div class="flex-1 flex overflow-hidden">
            <!-- 2. SIDEBAR (DESKTOP + MOBILE DRAWER) -->
            <AppSidebar />

            <!-- 3. FULL HEIGHT MAIN CONTENT AREA -->
            <div class="flex-1 flex flex-col min-w-0 overflow-hidden h-full">
                <!-- Page Full Body -->
                <main class="flex-1 overflow-y-auto flex flex-col min-h-0 custom-scrollbar">
                    <div :class="['flex-1 flex flex-col min-h-0', fullWidth ? 'p-2 sm:p-3' : 'px-3 sm:px-4 lg:px-5 py-3 sm:py-4']">
                        <slot />
                    </div>
                </main>

                <!-- 4. FIXED BACKEND FOOTER (Exact BIMKAT Spec) -->
                <footer class="min-h-11 py-2 sm:py-0 sm:h-11 w-full shrink-0 border-t border-slate-200/80 bg-white/95 backdrop-blur-sm px-3 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-1.5 sm:gap-4 text-[11px] sm:text-xs text-slate-500 z-20 select-none">
                    <div class="flex items-center gap-1.5 font-medium text-center sm:text-left min-w-0 max-w-full">
                        <span class="truncate">&copy; {{ new Date().getFullYear() }} {{ page.props.app?.name || 'SIPAROKI' }} &bull; {{ page.props.app?.nama_paroki || 'St. Vinsensius a Paulo - Benlutu' }}</span>
                    </div>
                    <div class="flex items-center gap-2 sm:gap-3 shrink-0">
                        <span class="hidden md:inline text-slate-400 text-[11px]">Peran Aktif: <b class="text-emerald-800 font-semibold">{{ activeRole }}</b></span>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] sm:text-[11px] font-bold">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span>Sistem Aktif</span>
                        </span>
                    </div>
                </footer>
            </div>
        </div>
    </div>
</template>

<style scoped>
.custom-scrollbar::-webkit-scrollbar {
    width: 5px;
    height: 5px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: rgba(148, 163, 184, 0.4);
    border-radius: 9999px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: rgba(148, 163, 184, 0.7);
}
</style>
