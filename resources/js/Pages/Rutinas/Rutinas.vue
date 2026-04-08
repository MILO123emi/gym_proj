<script setup>
import GymLayout from '@/Layouts/GymLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';


const clienteSeleccionado = ref({
    id: 1,
    nombre: 'Carlos Mendoza',
    estado: 'Membresía activa',
    modalidad: 'Con Entrenador'
});

const planSeleccionado = ref('Ganancia Muscular');


const clientes = ref([
    { id: 1, nombre: 'Florentino Guevara', estado: 'Membresía activa' },
    { id: 2, nombre: 'Mikel Romero', estado: 'Membresía activa' },
    { id: 3, nombre: 'Leonardo Hernandez', estado: 'Membresía vencida' },
    { id: 4, nombre: 'Milexcy Perez', estado: 'Membresía activa' },
    { id: 5, nombre: 'Denis Zuniga', estado: 'Membresía activa' },
]);

const planes = [
    { 
        nombre: 'Pérdida de Peso', 
        frecuencia: '4-5 días/semana', 
        meta: 'Reducir grasa corporal', 
        color: 'border-orange-500/30 bg-orange-500/10', 
        iconColor: 'text-orange-500' 
    },
    { 
        nombre: 'Ganancia Muscular', 
        frecuencia: '5-6 días/semana', 
        meta: 'Aumentar masa muscular', 
        color: 'border-blue-500/30 bg-blue-500/10', 
        iconColor: 'text-blue-500' 
    },
    { 
        nombre: 'Resistencia', 
        frecuencia: '3-4 días/semana', 
        meta: 'Mejorar condición cardiovascular', 
        color: 'border-red-500/30 bg-red-500/10', 
        iconColor: 'text-red-500' 
    },
    { 
        nombre: 'Acondicionamiento General', 
        frecuencia: '3 días/semana', 
        meta: 'Mantener forma física', 
        color: 'border-emerald-500/30 bg-emerald-500/10', 
        iconColor: 'text-emerald-500' 
    },
];
</script>

<template>
    <Head title="Rutinas y Entrenamientos" />

    <GymLayout>
        <div class="p-6 grid grid-cols-1 lg:grid-cols-12 gap-6 min-h-[90vh]">
            
            <div class="lg:col-span-4 bg-[#111111] border border-white/5 rounded-2xl p-6 shadow-xl">
                <h2 class="text-xl font-bold text-white mb-6">Seleccionar Cliente</h2>
                
                <div class="relative mb-6">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </span>
                    <input type="text" placeholder="Buscar cliente..." class="w-full bg-white/5 border border-white/10 rounded-xl py-2 pl-10 text-sm text-white focus:border-[#00BFA5] focus:ring-0 transition">
                </div>

                <div class="space-y-3">
                    <div v-for="c in clientes" :key="c.id" 
                        @click="clienteSeleccionado = c"
                        :class="[c.id === clienteSeleccionado.id ? 'border-[#00BFA5] bg-[#00BFA5]/5 text-white' : 'border-white/5 bg-white/5 text-gray-400']"
                        class="p-4 rounded-xl border flex justify-between items-center cursor-pointer hover:bg-white/10 transition group">
                        <span class="font-medium group-hover:text-white">{{ c.nombre }}</span>
                        <div v-if="c.estado === 'Membresía vencida'" class="flex items-center text-[10px] text-gray-600 italic">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a5 5 0 00-5 5v2a2 2 0 00-2 2v5a2 2 0 002 2h10a2 2 0 002-2v-5a2 2 0 00-2-2V7a5 5 0 00-5-5zM7 7a3 3 0 116 0v2H7V7z"></path></svg>
                            Membresía vencida
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-8 bg-[#111111] border border-white/5 rounded-2xl p-8 shadow-xl">
                
                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-white">{{ clienteSeleccionado.nombre }}</h2>
                    <p :class="clienteSeleccionado.estado === 'Membresía activa' ? 'text-[#00BFA5]' : 'text-red-500'" class="text-sm font-medium">
                        {{ clienteSeleccionado.estado }}
                    </p>
                </div>

                <div class="mb-10">
                    <p class="text-gray-500 text-xs uppercase font-bold mb-4 tracking-widest">Modalidad</p>
                    <div class="grid grid-cols-2 gap-4">
                        <button class="bg-white/5 border border-white/10 p-4 rounded-xl text-center hover:bg-white/10 transition group">
                            <p class="text-white font-bold group-hover:text-[#00BFA5]">Libre</p>
                            <p class="text-gray-500 text-[10px]">Sin entrenador</p>
                        </button>
                        <button class="bg-[#00BFA5]/5 border border-[#00BFA5] p-4 rounded-xl text-center shadow-[0_0_15px_rgba(0,191,165,0.1)]">
                            <p class="text-[#00BFA5] font-bold">Con Entrenador</p>
                            <p class="text-[#00BFA5]/60 text-[10px]">Personalizado</p>
                        </button>
                    </div>
                </div>

                <div>
                    <p class="text-gray-500 text-xs uppercase font-bold mb-4 tracking-widest">Plan de Entrenamiento</p>
                    <div class="space-y-4">
                        <div v-for="plan in planes" :key="plan.nombre"
                            @click="planSeleccionado = plan.nombre"
                            :class="[planSeleccionado === plan.nombre ? plan.color + ' border-l-4' : 'bg-white/5 border-white/5 hover:bg-white/10']"
                            class="p-5 rounded-xl border flex items-center justify-between cursor-pointer transition-all duration-300">
                            
                            <div class="flex items-center gap-4">
                                <div :class="planSeleccionado === plan.nombre ? plan.iconColor : 'text-gray-600'" class="p-2 bg-black/20 rounded-lg">
                                    <svg v-if="plan.nombre === 'Pérdida de Peso'" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                    <svg v-else-if="plan.nombre === 'Ganancia Muscular'" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path></svg>
                                    <svg v-else-if="plan.nombre === 'Resistencia'" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                    <svg v-else class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-white font-bold">{{ plan.nombre }}</p>
                                    <p class="text-gray-500 text-xs">{{ plan.frecuencia }} • {{ plan.meta }}</p>
                                </div>
                            </div>

                            <div v-if="planSeleccionado === plan.nombre" class="text-[#00BFA5]">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </GymLayout>
</template>

<style scoped>

.transition-all {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
</style>