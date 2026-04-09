<script setup>
import GymLayout from '@/Layouts/GymLayout.vue';
import { Head } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    clientesActivos: { type: Number, default: 0 },
    clientesInactivos: { type: Number, default: 0 },
    totalClientes: { type: Number, default: 0 },
    pagosVencidos: { type: Array, default: () => [] },
});

const activityRate = computed(() => {
    if (!props.totalClientes) return 0;
    return Math.round((props.clientesActivos / props.totalClientes) * 100);
});
</script>

<template>
    <GymLayout>
        <Head title="Panel General" />

        <div class="max-w-6xl mx-auto">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-white">Panel General</h1>
                <p class="text-gym-gray-text">Vista general del gimnasio</p>
            </div>

            <div v-if="pagosVencidos.length" class="mb-10 bg-red-950/20 border border-red-900/40 rounded-2xl overflow-hidden shadow-2xl">
                <div class="p-4 bg-red-900/20 border-b border-red-900/30 flex items-center gap-3">
                    <div class="p-2 bg-red-500/20 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    </div>
                    <div>
                        <h3 class="text-white font-bold">Clientes con Pagos Vencidos</h3>
                        <p class="text-red-400/70 text-xs">{{ pagosVencidos.length }} clientes tienen pagos pendientes</p>
                    </div>
                </div>
                
                <div class="divide-y divide-red-900/20">
                    <div v-if="!pagosVencidos.length" class="p-6 text-sm text-red-300/60">No hay pagos vencidos por ahora.</div>
                    <div v-for="pago in pagosVencidos" :key="`${pago.nombre}-${pago.monto}`" class="p-4 flex justify-between items-center hover:bg-red-900/10 transition-all">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-red-900/30 flex items-center justify-center text-red-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            </div>
                            <div>
                                <p class="text-white font-semibold text-sm">{{ pago.nombre }}</p>
                                <p class="text-red-400/50 text-xs">{{ pago.atraso }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-red-500 font-bold">{{ pago.monto }}</p>
                            <p class="text-[10px] text-red-900 font-black uppercase">HNL</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-gym-card-bg border border-gym-gray-border p-6 rounded-2xl shadow-xl">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="p-3 bg-gym-green/10 rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gym-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><polyline points="17 11 19 13 23 9"/></svg>
                        </div>
                        <div>
                            <p class="text-gym-gray-text text-xs font-bold uppercase">Clientes Activos</p>
                            <h2 class="text-3xl font-black text-white">{{ clientesActivos }}</h2>
                        </div>
                    </div>
                    <div class="w-full bg-gym-gray-border rounded-full h-2">
                        <div class="bg-gym-green h-2 rounded-full shadow-[0_0_8px_rgba(0,168,120,0.5)]" :style="{ width: activityRate + '%' }"></div>
                    </div>
                </div>

                <div class="bg-gym-card-bg border border-gym-gray-border p-6 rounded-2xl shadow-xl">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="p-3 bg-gym-gray-border/50 rounded-xl">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gym-gray-text" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="18" y1="9" x2="22" y2="13"/><line x1="22" y1="9" x2="18" y2="13"/></svg>
                        </div>
                        <div>
                            <p class="text-gym-gray-text text-xs font-bold uppercase">Clientes Inactivos</p>
                            <h2 class="text-3xl font-black text-white">{{ clientesInactivos }}</h2>
                        </div>
                    </div>
                    <div class="w-full bg-gym-gray-border rounded-full h-2">
                        <div class="bg-gym-gray-text/20 h-2 rounded-full" :style="{ width: totalClientes ? Math.round((clientesInactivos / totalClientes) * 100) + '%' : '0%' }"></div>
                    </div>
                </div>
            </div>

            <div class="bg-gym-card-bg border border-gym-gray-border p-6 rounded-2xl shadow-xl flex justify-between items-center">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-gym-green/10 rounded-xl text-gym-green">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <div>
                        <p class="text-gym-gray-text text-xs font-bold uppercase">Total de Clientes</p>
                        <h2 class="text-4xl font-black text-white">{{ totalClientes }}</h2>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-gym-gray-text text-xs font-bold uppercase mb-1">Tasa de actividad</p>
                    <p class="text-gym-green text-3xl font-black">{{ activityRate }}%</p>
                </div>
            </div>
        </div>
    </GymLayout>
</template>