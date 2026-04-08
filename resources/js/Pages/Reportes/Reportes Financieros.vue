<script setup>
import GymLayout from '@/Layouts/GymLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const periodoActivo = ref('Este Mes');
const periodos = ['Esta Semana', 'Este Mes', 'Trimestre', 'Año'];

const ingresosPorContrato = [
    { tipo: 'Mensual', monto: '$45,000 MXN', porcentaje: 30.5, color: 'bg-blue-500' },
    { tipo: 'Semestral', monto: '$54,000 MXN', porcentaje: 36.6, color: 'bg-purple-500' },
    { tipo: 'Anual', monto: '$48,500 MXN', porcentaje: 32.9, color: 'bg-[#00BFA5]' }
];
</script>

<template>
    <Head title="Reportes Financieros" />

    <GymLayout>
        <div class="p-6">
            <header class="flex justify-between items-start mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-white">Reportes Financieros</h1>
                    <p class="text-gray-400 text-sm">Análisis económico del gimnasio</p>
                </div>
                <button class="bg-[#00BFA5] hover:bg-[#008F7A] text-white px-4 py-2 rounded-lg text-sm font-bold flex items-center gap-2 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Exportar Reporte
                </button>
            </header>

            <div class="flex items-center gap-2 mb-8 bg-[#111111] p-1 rounded-xl border border-white/5 w-fit">
                <div class="px-4 py-2 text-gray-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <button v-for="p in periodos" :key="p" 
                        @click="periodoActivo = p"
                        :class="periodoActivo === p ? 'bg-[#00BFA5] text-white shadow-lg' : 'text-gray-400 hover:text-white'"
                        class="px-4 py-1.5 rounded-lg text-xs font-bold transition">
                    {{ p }}
                </button>
            </div>

            <div class="bg-[#111111] border border-white/5 rounded-2xl p-8 mb-8 relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-8">
                    <span class="text-[#00BFA5] text-sm font-bold flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        +12.5%
                    </span>
                </div>
                <div class="flex items-center gap-6">
                    <div class="bg-[#00BFA5]/10 p-4 rounded-2xl">
                        <svg class="w-10 h-10 text-[#00BFA5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm font-medium uppercase tracking-wider">Ingresos Totales</p>
                        <h2 class="text-5xl font-black text-white mt-1">$147,500 <span class="text-lg text-gray-600 font-bold uppercase">mxn</span></h2>
                    </div>
                </div>
            </div>

            <div class="bg-[#111111] border border-white/5 rounded-2xl p-8 mb-8">
                <h3 class="text-white font-bold mb-8">Ingresos por Tipo de Contrato</h3>
                <div class="space-y-8">
                    <div v-for="item in ingresosPorContrato" :key="item.tipo">
                        <div class="flex justify-between items-end mb-2">
                            <span class="text-sm text-white font-bold">{{ item.tipo }}</span>
                            <span class="text-sm text-white font-black">{{ item.monto }}</span>
                        </div>
                        <div class="h-2 w-full bg-white/5 rounded-full overflow-hidden">
                            <div :class="item.color" class="h-full transition-all duration-1000" :style="{ width: item.porcentaje + '%' }"></div>
                        </div>
                        <p class="text-[10px] text-gray-500 mt-2">{{ item.porcentaje }}% del total</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-[#111111] border border-white/5 rounded-2xl p-6 flex flex-col justify-between">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="bg-red-500/10 p-3 rounded-xl">
                            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-gray-500 text-xs font-bold uppercase tracking-wider">Clientes en Mora</p>
                            <h4 class="text-2xl font-black text-white">4</h4>
                        </div>
                    </div>
                    <div class="flex justify-between items-end bg-white/5 p-4 rounded-xl border border-white/5">
                        <span class="text-gray-500 text-xs font-medium">Monto Pendiente</span>
                        <span class="text-red-500 font-black">$3,260 MXN</span>
                    </div>
                </div>

                <div class="bg-[#111111] border border-white/5 rounded-2xl p-6 flex flex-col justify-between">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="bg-[#00BFA5]/10 p-3 rounded-xl">
                            <svg class="w-6 h-6 text-[#00BFA5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                        </div>
                        <div>
                            <p class="text-gray-500 text-xs font-bold uppercase tracking-wider">Clientes Nuevos</p>
                            <h4 class="text-2xl font-black text-white">8</h4>
                        </div>
                    </div>
                    <div class="flex justify-between items-end bg-white/5 p-4 rounded-xl border border-white/5">
                        <span class="text-gray-500 text-xs font-medium">En este periodo</span>
                        <span class="text-[#00BFA5] bg-[#00BFA5]/10 px-2 py-0.5 rounded text-[10px] font-bold border border-[#00BFA5]/20">+8 miembros</span>
                    </div>
                </div>
            </div>
        </div>
    </GymLayout>
</template>