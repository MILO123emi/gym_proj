<script setup>
import GymLayout from '@/Layouts/GymLayout.vue';
import { Head } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({
    clients: {
        type: Array,
        default: () => [],
    },
});

const selectedId = ref(props.clients[0]?.id || null);

const clientes = computed(() => props.clients);
const clienteSeleccionado = computed(() => {
    return props.clients.find(c => c.id === selectedId.value) || props.clients[0] || null;
});
</script>

<template>
    <Head title="Consultas de Clientes" />

    <GymLayout>
        <div class="p-6">
            <header class="mb-8">
                <h1 class="text-3xl font-bold text-white">Consultas de Clientes</h1>
                <p class="text-gray-400 text-sm">Información detallada de miembros</p>
            </header>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                
                <div class="lg:col-span-4 bg-[#111111] border border-white/5 rounded-2xl p-6 shadow-xl">
                    <div class="relative mb-6">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </span>
                        <input type="text" placeholder="Buscar cliente..." class="w-full bg-white/5 border border-white/10 rounded-xl py-2 pl-10 text-white focus:border-[#00BFA5] focus:ring-0 transition">
                    </div>

                    <div class="space-y-3">
                        <div v-for="c in clientes" :key="c.id" 
                            @click="selectedId = c.id"
                            :class="[c.id === selectedId ? 'border-[#00BFA5] bg-[#00BFA5]/5' : 'border-white/5 bg-white/5']"
                            class="p-4 rounded-xl border flex justify-between items-center cursor-pointer hover:bg-white/10 transition group">
                            <div>
                                <p class="font-bold text-sm text-white">{{ c.nombre }}</p>
                                <p class="text-gray-500 text-[10px]">{{ c.tel }}</p>
                            </div>
                            <span :class="{'text-red-500 bg-red-500/10': c.estado === 'Mora', 'text-[#00BFA5] bg-[#00BFA5]/10': c.estado === 'Activo', 'text-gray-500 bg-gray-500/10': c.estado === 'Inactivo'}" 
                                  class="px-2 py-1 rounded text-[9px] font-bold border border-current uppercase">
                                {{ c.estado }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-8 bg-[#111111] border border-white/5 rounded-2xl p-8 shadow-xl">
                    <div v-if="!clienteSeleccionado" class="text-center py-16 text-gray-400">
                        No hay clientes para mostrar.
                    </div>

                    <template v-else>
                    <div v-if="clienteSeleccionado" class="flex justify-between items-start mb-8">
                        <div>
                            <h2 class="text-2xl font-bold text-white">{{ clienteSeleccionado.nombre }}</h2>
                            <p class="text-gray-500 text-sm">{{ clienteSeleccionado.email }}</p>
                        </div>
                        <span
                            :class="{
                                'text-red-500 bg-red-500/10 border-red-500/20': clienteSeleccionado.estado === 'Mora',
                                'text-[#00BFA5] bg-[#00BFA5]/10 border-[#00BFA5]/20': clienteSeleccionado.estado === 'Activo',
                                'text-gray-500 bg-gray-500/10 border-gray-500/20': clienteSeleccionado.estado === 'Inactivo',
                            }"
                            class="px-3 py-1 rounded border text-xs font-bold uppercase"
                        >
                            {{ clienteSeleccionado.estado }}
                        </span>
                    </div>

                    <div v-if="clienteSeleccionado && clienteSeleccionado.estado === 'Mora'" class="bg-red-950/20 border border-red-500/20 p-4 rounded-xl flex items-center gap-3 mb-8">
                        <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        <div>
                            <p class="text-red-500 font-bold text-xs">Pago Vencido</p>
                            <p class="text-red-400/70 text-[11px]">Este cliente tiene pagos pendientes</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6 mb-8">
                        <section>
                            <h3 class="text-[#00BFA5] text-[11px] font-bold uppercase mb-3 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Datos Personales
                            </h3>
                            <div class="space-y-4">
                                <div class="bg-white/5 p-3 rounded-lg border border-white/5">
                                    <p class="text-gray-500 text-[9px] uppercase">Teléfono</p>
                                    <p class="text-white text-sm">{{ clienteSeleccionado.tel }}</p>
                                </div>
                                <div class="bg-white/5 p-3 rounded-lg border border-white/5">
                                    <p class="text-gray-500 text-[9px] uppercase">Email</p>
                                    <p class="text-white text-sm">{{ clienteSeleccionado.email }}</p>
                                </div>
                            </div>
                        </section>
                        <section>
                             <h3 class="text-[#00BFA5] text-[11px] font-bold uppercase mb-3 flex items-center gap-2 opacity-0">.</h3>
                             <div class="bg-white/5 p-3 rounded-lg border border-white/5 h-full">
                                <p class="text-gray-500 text-[9px] uppercase">Dirección</p>
                                    <p class="text-white text-sm">{{ clienteSeleccionado.direccion || '-' }}</p>
                            </div>
                        </section>
                    </div>

                    <div class="grid grid-cols-2 gap-6 mb-8">
                        <section>
                            <h3 class="text-[#00BFA5] text-[11px] font-bold uppercase mb-3 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                Membresía
                            </h3>
                            <div class="grid grid-cols-2 gap-3">
                                <div class="bg-white/5 p-3 rounded-lg border border-white/5">
                                    <p class="text-gray-500 text-[9px] uppercase">Tipo de Plan</p>
                                    <p class="text-white text-sm">{{ clienteSeleccionado.plan || '-' }}</p>
                                </div>
                                <div class="bg-white/5 p-3 rounded-lg border border-white/5">
                                    <p class="text-gray-500 text-[9px] uppercase">Vencimiento</p>
                                    <p class="text-white text-sm">{{ clienteSeleccionado.vencimiento || '-' }}</p>
                                </div>
                            </div>
                        </section>
                        <section>
                            <h3 class="text-[#00BFA5] text-[11px] font-bold uppercase mb-3 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                Plan de Entrenamiento
                            </h3>
                            <div class="grid grid-cols-2 gap-3">
                                <div class="bg-white/5 p-3 rounded-lg border border-white/5">
                                    <p class="text-gray-500 text-[9px] uppercase">Rutina</p>
                                    <p class="text-white text-sm">{{ clienteSeleccionado.rutina || '-' }}</p>
                                </div>
                                <div class="bg-white/5 p-3 rounded-lg border border-white/5">
                                    <p class="text-gray-500 text-[9px] uppercase">Entrenador</p>
                                    <p class="text-white text-sm">{{ clienteSeleccionado.entrenador || '-' }}</p>
                                </div>
                            </div>
                        </section>
                    </div>

                    <section>
                        <h3 class="text-[#00BFA5] text-[11px] font-bold uppercase mb-3 flex items-center gap-2">
                            Historial de Pagos
                        </h3>
                        <div class="space-y-3">
                            <div v-if="!clienteSeleccionado.pagos?.length" class="text-gray-500 text-sm">Sin pagos registrados.</div>
                            <div v-for="pago in (clienteSeleccionado.pagos || [])" :key="pago.fecha" class="bg-white/5 p-4 rounded-xl border border-white/5 flex justify-between items-center">
                                <div>
                                    <p class="text-white font-bold text-sm">{{ pago.monto }}</p>
                                    <p class="text-gray-500 text-[10px]">{{ pago.fecha }}</p>
                                </div>
                                <span class="text-gray-500 text-[10px] uppercase font-bold">{{ pago.metodo }}</span>
                            </div>
                        </div>
                    </section>
                    </template>
                </div>
            </div>
        </div>
    </GymLayout>
</template>