<script setup>
import GymLayout from '@/Layouts/GymLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';


const pagoExitoso = ref(false);
const clienteSeleccionado = ref({
    nombre: 'Florentino Guevara',
    telefono: '9896-0101',
    mora: true,
    diasAtraso: 12,
    monto: 580
});


const clientes = ref([
    { id: 1, nombre: 'Florentino Guevara', tel: '3536-0101', estado: 'Mora', dias: 12 },
    { id: 2, nombre: 'Mikel Romero', tel: '9894-0102', estado: 'Mora', dias: 5 },
    { id: 3, nombre: 'Leonardo Hernandez', tel: '9885-0103', estado: 'Mora', dias: 18 },
    { id: 4, nombre: 'Milexcy Perez', tel: '9893-0104', estado: 'Al día', dias: 0 },
    { id: 5, nombre: 'Denis Zuniga', tel: '9297-0105', estado: 'Al día', dias: 0 },
]);

const realizarPago = () => {
    pagoExitoso.value = true;
};

const resetear = () => {
    pagoExitoso.value = false;
};



</script>

<template>
    <Head title="Sistema de Cobranza" />

    <GymLayout>
        <div class="p-6 text-white min-h-screen relative">
            
            <div v-if="!pagoExitoso">
                <header class="mb-8">
                    <h1 class="text-3xl font-bold">Sistema de Cobranza</h1>
                    <p class="text-gray-400">Registro de pagos de membresías</p>
                </header>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    
                    <div class="bg-[#111111] border border-white/5 rounded-2xl p-6 shadow-xl">
                        <h2 class="text-xl font-bold mb-4 text-gray-200">Buscar Cliente</h2>
                        
                        <div class="relative mb-6">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </span>
                            <input type="text" placeholder="Buscar por nombre o teléfono..." class="w-full bg-white/5 border border-white/10 rounded-xl py-3 pl-10 text-white focus:border-[#00BFA5] focus:ring-0 transition">
                        </div>

                        <div class="space-y-3 max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
                            <div v-for="c in clientes" :key="c.id" 
                                @click="clienteSeleccionado = { nombre: c.nombre, telefono: c.tel, mora: c.estado === 'Mora', diasAtraso: c.dias, monto: 580 }"
                                :class="[c.nombre === clienteSeleccionado.nombre ? 'border-[#00BFA5] bg-[#00BFA5]/5' : 'border-white/5 bg-white/5']"
                                class="p-4 rounded-xl border flex justify-between items-center cursor-pointer hover:bg-white/10 transition">
                                <div>
                                    <p class="font-bold text-white">{{ c.nombre }}</p>
                                    <p class="text-gray-500 text-xs">{{ c.tel }}</p>
                                    <p v-if="c.estado === 'Mora'" class="text-yellow-500 text-[10px] mt-1">{{ c.dias }} días de atraso</p>
                                </div>
                                <span :class="c.estado === 'Mora' ? 'text-red-500 bg-red-500/10' : 'text-[#00BFA5] bg-[#00BFA5]/10'" class="px-3 py-1 rounded-lg text-[10px] font-bold border border-current uppercase">
                                    {{ c.estado }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-[#111111] border border-white/5 rounded-2xl p-6 shadow-xl flex flex-col">
                        <h2 class="text-xl font-bold mb-4 text-gray-200">Estado de Cuenta</h2>

                        <div v-if="clienteSeleccionado.mora" class="bg-red-950/30 border border-red-500/20 p-4 rounded-xl flex items-start gap-3 mb-6">
                            <svg class="w-6 h-6 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            <div>
                                <p class="text-red-500 font-bold text-sm">Cliente en Mora</p>
                                <p class="text-red-400/80 text-xs">{{ clienteSeleccionado.diasAtraso }} días de atraso. Se aplicó recargo al monto original.</p>
                            </div>
                        </div>

                        <div class="bg-white/5 rounded-xl p-4 mb-4 border border-white/5">
                            <p class="text-gray-500 text-[10px] uppercase font-bold mb-1">Cliente</p>
                            <p class="text-white font-bold">{{ clienteSeleccionado.nombre }}</p>
                            <p class="text-gray-400 text-xs">{{ clienteSeleccionado.telefono }}</p>
                        </div>

                        <div class="bg-white/5 rounded-xl p-4 mb-6 border border-white/5">
                            <p class="text-gray-500 text-[10px] uppercase font-bold mb-1">Monto a cobrar</p>
                            <p class="text-[#00BFA5] text-4xl font-black">${{ clienteSeleccionado.monto }} <span class="text-xs text-gray-500 font-normal">MXN</span></p>
                        </div>

                        <p class="text-gray-500 text-[10px] uppercase font-bold mb-3">Método de Pago</p>
                        <div class="grid grid-cols-2 gap-4 mb-8">
                            <button class="flex flex-col items-center justify-center p-4 bg-white/5 border border-[#00BFA5] rounded-xl text-[#00BFA5] hover:bg-[#00BFA5]/10 transition">
                                <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                <span class="text-xs font-bold">Efectivo</span>
                            </button>
                            <button class="flex flex-col items-center justify-center p-4 bg-white/5 border border-white/10 rounded-xl text-gray-400 hover:text-white hover:border-white/30 transition">
                                <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                <span class="text-xs font-bold">Tarjeta</span>
                            </button>
                        </div>

                        <button @click="realizarPago" class="w-full bg-[#00BFA5] hover:bg-[#009688] text-white font-bold py-4 rounded-xl transition shadow-lg shadow-[#00BFA5]/20 mt-auto">
                            Registrar Pago
                        </button>
                    </div>
                </div>
            </div>

            <div v-else class="flex items-center justify-center min-h-[80vh]">
                <div class="bg-[#111111] border border-white/5 p-10 rounded-3xl shadow-2xl text-center max-w-lg w-full">
                    <div class="w-20 h-20 bg-[#00BFA5]/20 rounded-full flex items-center justify-center mx-auto mb-6 border border-[#00BFA5]/30">
                        <svg class="w-10 h-10 text-[#00BFA5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <h2 class="text-3xl font-black mb-2">Pago Registrado Exitosamente</h2>
                    <p class="text-gray-500 mb-8 text-sm">El pago de {{ clienteSeleccionado.nombre }} ha sido procesado</p>
                    
                    <div class="bg-white/5 rounded-2xl p-6 mb-8 border border-white/5 space-y-4">
                        <div class="flex justify-between border-b border-white/5 pb-4">
                            <span class="text-gray-500">Monto:</span>
                            <span class="font-bold text-white">${{ clienteSeleccionado.monto }} MXN</span>
                        </div>
                        <div class="flex justify-between pt-2">
                            <span class="text-gray-500">Método:</span>
                            <span class="font-bold text-white">Tarjeta</span>
                        </div>
                    </div>

                    <button @click="resetear" class="bg-[#00BFA5] hover:bg-[#009688] text-white font-bold py-3 px-10 rounded-xl transition">
                        Registrar Otro Pago
                    </button>
                </div>
            </div>

        </div>
    </GymLayout>
</template>

<style scoped>
.custom-scrollbar::-webkit-scrollbar {
    width: 6px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.05);
    border-radius: 10px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: rgba(0, 191, 165, 0.5);
}
</style>