<script setup>
import { ref, computed, watch, onMounted } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    show: { type: Boolean, default: false },
});
const emit = defineEmits(['close']);

const loading = ref(false);
const search = ref('');
const statusFilter = ref('aktif');
const roleFilter = ref('');
const users = ref([]);
const roles = ref([]);
const switching = ref(null);
let searchTimer = null;

const counts = computed(() => ({
    aktif:    users.value.filter(u => u.status).length,
    nonaktif: users.value.filter(u => !u.status).length,
    semua:    users.value.length,
}));

const filteredUsers = computed(() => {
    let list = users.value;
    if (statusFilter.value === 'aktif')    list = list.filter(u => u.status);
    if (statusFilter.value === 'nonaktif') list = list.filter(u => !u.status);
    if (roleFilter.value)                  list = list.filter(u => u.role_id == roleFilter.value);
    return list;
});

function getRoleColor(r) {
    r = (r || '').toLowerCase();
    if (r.includes('super') || r.includes('admin paroki')) return 'bg-red-50 text-red-700 border-red-200';
    if (r.includes('pastor')) return 'bg-purple-50 text-purple-700 border-purple-200';
    if (r.includes('bendahara')) return 'bg-yellow-50 text-yellow-700 border-yellow-200';
    if (r.includes('wilayah')) return 'bg-teal-50 text-teal-700 border-teal-200';
    if (r.includes('kub') || r.includes('lingkungan')) return 'bg-emerald-50 text-emerald-700 border-emerald-200';
    if (r.includes('kapela') || r.includes('stasi')) return 'bg-indigo-50 text-indigo-700 border-indigo-200';
    if (r.includes('penulis') || r.includes('komsos')) return 'bg-orange-50 text-orange-700 border-orange-200';
    return 'bg-slate-100 text-slate-600 border-slate-200';
}

function getInitials(nama) {
    if (!nama) return '?';
    const parts = nama.trim().split(/\s+/);
    return parts.length >= 2 ? (parts[0][0] + parts[1][0]).toUpperCase() : nama[0].toUpperCase();
}

async function fetchUsers() {
    loading.value = true;
    try {
        const params = new URLSearchParams({ search: search.value });
        const res = await fetch(`/api/users-list?${params}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', Accept: 'application/json' },
            credentials: 'same-origin',
        });
        if (!res.ok) throw new Error();
        const data = await res.json();
        users.value = data.users || [];
        roles.value = data.roles || [];
    } catch {
        users.value = [];
    } finally {
        loading.value = false;
    }
}

function onSearchInput() {
    clearTimeout(searchTimer);
    searchTimer = setTimeout(() => fetchUsers(), 350);
}

function beralihAkun(user) {
    if (switching.value) return;
    switching.value = user.id;
    router.post(`/superadmin/user/${user.id}/impersonate`, {}, {
        onFinish:  () => { switching.value = null; },
        onSuccess: () => emit('close'),
        onError:   () => { switching.value = null; },
    });
}

function onKeydown(e) { if (e.key === 'Escape') emit('close'); }

onMounted(() => document.addEventListener('keydown', onKeydown));

// Open watcher — fetch when modal opens
watch(() => props.show, (val) => {
    if (val) {
        search.value = '';
        roleFilter.value = '';
        statusFilter.value = 'aktif';
        fetchUsers();
    }
});
</script>

<template>
    <Teleport to="body">
        <Transition
            enter-active-class="transition-opacity duration-200 ease-out"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition-opacity duration-150"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
        >
            <div
                v-if="show"
                class="fixed inset-0 z-[9999] flex items-center justify-center p-3 sm:p-5"
                style="background: rgba(2,18,8,0.72); backdrop-filter: blur(4px);"
                @click.self="$emit('close')"
            >
                <Transition
                    enter-active-class="transition-all duration-200 ease-out"
                    enter-from-class="opacity-0 scale-95 translate-y-3"
                    enter-to-class="opacity-100 scale-100 translate-y-0"
                >
                    <div
                        v-if="show"
                        class="bg-white rounded-2xl shadow-2xl w-full max-w-3xl flex flex-col overflow-hidden"
                        style="max-height: 90vh;"
                    >
                        <!-- Header -->
                        <div
                            class="px-5 py-4 flex items-center justify-between shrink-0"
                            style="background: linear-gradient(135deg,#064e3b 0%,#065f46 55%,#047857 100%);"
                        >
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-9 h-9 rounded-xl bg-white/15 flex items-center justify-center shrink-0">
                                    <i class="bi bi-people text-white text-lg"></i>
                                </div>
                                <div class="min-w-0">
                                    <h2 class="text-white font-bold text-sm leading-tight flex items-center gap-2 flex-wrap">
                                    Tukar Pengguna (Impersonasi Akun)
                                        <span class="px-2 py-0.5 rounded-full bg-amber-400 text-amber-900 text-[10px] font-extrabold tracking-wider uppercase">
                                            MODE ADMIN
                                        </span>
                                    </h2>
                                    <p class="text-emerald-200 text-[11px] mt-0.5 truncate">
                                        Pilih akun pengguna untuk melihat tampilan sistem dari sudut pandang mereka.
                                    </p>
                                </div>
                            </div>
                            <button
                                @click="$emit('close')"
                                class="w-8 h-8 rounded-lg bg-white/10 hover:bg-white/25 text-white flex items-center justify-center transition shrink-0 ml-2 cursor-pointer"
                            >
                                <i class="bi bi-x-lg text-sm"></i>
                            </button>
                        </div>

                        <!-- Status Tabs -->
                        <div class="px-5 pt-3 pb-0 bg-slate-50/70 border-b border-slate-100 flex items-center gap-0 shrink-0">
                            <button
                                v-for="tab in [
                                    { key: 'aktif',    label: 'Pengguna Aktif', count: counts.aktif },
                                    { key: 'nonaktif', label: 'Nonaktif',       count: counts.nonaktif },
                                    { key: 'semua',    label: 'Semua',          count: counts.semua },
                                ]"
                                :key="tab.key"
                                @click="statusFilter = tab.key"
                                :class="[
                                    'flex items-center gap-1.5 px-4 py-2.5 text-xs font-semibold border-b-2 transition-all cursor-pointer',
                                    statusFilter === tab.key
                                        ? 'border-emerald-600 text-emerald-700 bg-white'
                                        : 'border-transparent text-slate-500 hover:text-slate-700',
                                ]"
                            >
                                {{ tab.label }}
                                <span :class="[
                                    'px-1.5 py-0.5 rounded-full text-[10px] font-bold',
                                    statusFilter === tab.key ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-200 text-slate-500'
                                ]">{{ tab.count }}</span>
                            </button>
                        </div>

                        <!-- Search + Role Filters -->
                        <div class="px-4 py-3 bg-white border-b border-slate-100 space-y-2 shrink-0">
                            <div class="relative">
                                <i class="bi bi-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm pointer-events-none"></i>
                                <input
                                    v-model="search"
                                    @input="onSearchInput"
                                    type="text"
                                    placeholder="Ketik nama pengguna, username, atau email..."
                                    class="w-full pl-9 pr-4 py-2.5 text-sm border border-slate-200 rounded-xl bg-slate-50/60 focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition"
                                />
                            </div>
                            <div class="flex gap-1.5 flex-wrap">
                                <button
                                    @click="roleFilter = ''"
                                    :class="[
                                        'px-2.5 py-1 rounded-lg text-xs font-semibold border transition cursor-pointer',
                                        roleFilter === '' ? 'bg-emerald-600 text-white border-emerald-600' : 'bg-white text-slate-600 border-slate-200 hover:border-emerald-400 hover:text-emerald-700',
                                    ]"
                                >
                                    <i class="bi bi-people-fill me-1"></i> Semua
                                    <span class="ml-1 opacity-75 text-[10px]">({{ filteredUsers.length }})</span>
                                </button>
                                <button
                                    v-for="role in roles"
                                    :key="role.id"
                                    @click="roleFilter = (roleFilter == role.id ? '' : role.id)"
                                    :class="[
                                        'px-2.5 py-1 rounded-lg text-xs font-semibold border transition cursor-pointer',
                                        roleFilter == role.id ? 'bg-emerald-600 text-white border-emerald-600' : 'bg-white text-slate-600 border-slate-200 hover:border-emerald-400 hover:text-emerald-700',
                                    ]"
                                >
                                    {{ role.nama_role }}
                                    <span class="ml-1 text-[10px] opacity-75">
                                        ({{ users.filter(u => u.role_id == role.id && (statusFilter === 'semua' || (statusFilter === 'aktif' ? u.status : !u.status))).length }})
                                    </span>
                                </button>
                            </div>
                        </div>

                        <!-- User List -->
                        <div class="flex-1 overflow-y-auto px-4 py-3 min-h-0" style="scrollbar-width: thin;">
                            <!-- Loading Skeleton -->
                            <div v-if="loading" class="space-y-2">
                                <!-- Progress bar berjalan -->
                                <div class="w-full h-1 bg-slate-100 rounded-full overflow-hidden mb-3">
                                    <div class="h-full bg-emerald-500 rounded-full animate-progress-bar"></div>
                                </div>
                                <!-- Skeleton cards -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                    <div v-for="i in 6" :key="i" class="bg-white border border-slate-100 rounded-xl p-3 flex items-center gap-3">
                                        <div class="w-11 h-11 rounded-xl bg-slate-200 animate-pulse shrink-0"></div>
                                        <div class="flex-1 space-y-1.5">
                                            <div class="h-3 bg-slate-200 rounded animate-pulse w-3/4"></div>
                                            <div class="h-2.5 bg-slate-100 rounded animate-pulse w-1/2"></div>
                                            <div class="h-4 bg-slate-100 rounded animate-pulse w-1/3"></div>
                                        </div>
                                        <div class="w-16 h-7 bg-slate-100 rounded-lg animate-pulse shrink-0"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- Empty -->
                            <div v-else-if="filteredUsers.length === 0" class="flex flex-col items-center justify-center py-16 text-slate-400">
                                <i class="bi bi-person-x text-5xl mb-3 opacity-30"></i>
                                <p class="text-sm font-medium">Tidak ada pengguna ditemukan</p>
                                <p class="text-xs mt-1 opacity-70">Coba ubah kata kunci atau filter</p>
                            </div>
                            <!-- Grid Cards -->
                            <div v-else class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                <div
                                    v-for="user in filteredUsers"
                                    :key="user.id"
                                    class="group bg-white border border-slate-100 hover:border-emerald-200 rounded-xl p-3 flex items-center gap-3 transition-all duration-150 hover:shadow-md"
                                >
                                    <!-- Avatar -->
                                    <div class="relative shrink-0">
                                        <img
                                            v-if="user.foto"
                                            :src="user.foto"
                                            :alt="user.nama"
                                            class="w-11 h-11 rounded-xl object-cover border-2 border-slate-100 group-hover:border-emerald-200 transition"
                                            @error="(e) => { e.target.style.display='none'; }"
                                        />
                                        <div
                                            v-if="!user.foto"
                                            class="w-11 h-11 rounded-xl flex items-center justify-center text-white font-bold text-sm"
                                            style="background: linear-gradient(135deg, #064e3b, #047857);"
                                        >{{ getInitials(user.nama) }}</div>
                                        <span
                                            :class="['absolute -bottom-0.5 -right-0.5 w-3 h-3 rounded-full border-2 border-white', user.status ? 'bg-emerald-500' : 'bg-slate-300']"
                                        ></span>
                                    </div>
                                    <!-- Info -->
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-bold text-slate-800 truncate">{{ user.nama }}</p>
                                        <p class="text-[11px] text-slate-400 truncate">
                                            {{ user.username }}<span v-if="user.email" class="text-slate-300"> · </span>{{ user.email }}
                                        </p>
                                        <div class="flex items-center gap-1.5 mt-1.5 flex-wrap">
                                            <span :class="['inline-flex px-1.5 py-0.5 rounded-md text-[10px] font-semibold border', getRoleColor(user.nama_role)]">
                                                {{ user.nama_role }}
                                            </span>
                                            <span class="text-[10px] text-slate-400">{{ user.last_login }}</span>
                                        </div>
                                    </div>
                                    <!-- Beralih Button -->
                                    <button
                                        @click="beralihAkun(user)"
                                        :disabled="!!switching"
                                        :class="[
                                            'shrink-0 flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold transition-all cursor-pointer select-none',
                                            switching === user.id
                                                ? 'bg-emerald-50 text-emerald-400'
                                                : 'bg-emerald-600 text-white hover:bg-emerald-700 active:scale-95 hover:shadow-sm',
                                        ]"
                                    >
                                        <i :class="switching === user.id ? 'bi bi-hourglass-split' : 'bi bi-arrow-right-circle-fill'" class="text-sm"></i>
                                        <span class="hidden sm:inline">{{ switching === user.id ? '...' : 'Beralih' }}</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="px-5 py-3 bg-slate-50 border-t border-slate-100 shrink-0 flex items-center justify-between gap-3">
                            <p class="text-[11px] text-slate-500 flex-1">
                                <i class="bi bi-shield-lock-fill text-emerald-600 me-1"></i>
                                Hanya <strong class="text-slate-700">Super Admin</strong> yang dapat menggunakan fitur ini. Semua aktivitas tercatat.
                            </p>
                            <button
                                @click="$emit('close')"
                                class="px-3 py-1.5 rounded-lg text-xs font-semibold text-slate-600 bg-white border border-slate-200 hover:bg-slate-50 transition shrink-0 cursor-pointer"
                            >
                                Tutup
                            </button>
                        </div>
                    </div>
                </Transition>
            </div>
        </Transition>
    </Teleport>
</template>
