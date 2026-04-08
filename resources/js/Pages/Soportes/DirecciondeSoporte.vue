<script setup>
import GymLayout from '@/Layouts/GymLayout.vue'; 
import { Head } from '@inertiajs/vue3';


const proveedores = [
    { nombre: 'Técnico Máquinas SA', servicio: 'Máquinas de ejercicio', tel: '9897-9693' },
    { nombre: 'Aire Acondicionado Express', servicio: 'Aire acondicionado', tel: '9789-2130' },
    { nombre: 'Mantenimiento Eléctrico', servicio: 'Instalaciones eléctricas', tel: '3239-3000' },
    { nombre: 'Ventiladores y Más', servicio: 'Ventiladores', tel: '9695-4000' },
    { nombre: 'Plomería Rápida', servicio: 'Plomería', tel: '3526-4050' },
];
</script>

<template>
    <Head title="Soporte y Mantenimiento" />

    <GymLayout>
        <div class="space-y-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-white text-3xl">Directorio de Soporte y Mantenimiento</h1>
                    <p class="text-gray-500">Contactos de proveedores de servicios</p>
                </div>
                <button class="bg-[#00a878] text-black px-4 py-2 rounded-lg font-bold">
                    + Agregar Proveedor
                </button>
            </div>

            <div class="flex gap-2 flex-wrap">
                <button class="bg-[#00a878] text-black px-4 py-1.5 rounded-full text-sm font-bold">Todos</button>
                <button class="bg-white/5 text-gray-400 px-4 py-1.5 rounded-full text-sm hover:bg-white/10">Máquinas de ejercicio</button>
                <button class="bg-white/5 text-gray-400 px-4 py-1.5 rounded-full text-sm hover:bg-white/10">Aire acondicionado</button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div v-for="p in proveedores" :key="p.nombre" class="bg-[#111111] border border-white/5 p-5 rounded-xl">
                    <div class="flex justify-between mb-4">
                        <div class="bg-[#00a878]/20 p-2 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-[#00a878]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                            </svg>
                        </div>
                    </div>
                    <h3 class="text-white font-bold text-lg">{{ p.nombre }}</h3>
                    <p class="text-gray-500 text-sm mb-4">{{ p.servicio }}</p>
                    <div class="bg-black/40 p-3 rounded-lg border border-white/5 flex items-center gap-2">
                        <span class="text-gray-400 text-xs">📞</span>
                        <span class="text-gray-300 font-mono">{{ p.tel }}</span>
                    </div>
                </div>
            </div>
        </div>
    </GymLayout>
</template>