<script setup>
import GymLayout from '@/Layouts/GymLayout.vue'; 
import { Head, useForm } from '@inertiajs/vue3';


const form = useForm({
    nombre_completo: '',
    telefono: '',
    fecha_nacimiento: '',
    direccion: '',
    contacto_emergencia: '',
});


const steps = [
    { number: 1, name: 'Datos' },
    { number: 2, name: 'Plan' },
    { number: 3, name: 'Pago' },
    { number: 4, name: 'Confirmar' },
];
const currentStep = 1; 

const submit = () => {
    form.post(route('clientes.store'), { 
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <GymLayout>
        <Head title="Nuevo Cliente - Registro" />

        <div class="mb-12 border-b border-gym-gray-border pb-8">
            <h1 class="text-4xl font-extrabold text-white">Nuevo Cliente</h1>
            <p class="text-lg text-gym-gray-text mt-1">Registro de nuevo miembro</p>
        </div>

        <div class="mb-16">
            <div class="relative flex justify-between items-center max-w-2xl mx-auto">
                <div class="absolute left-0 top-1/2 h-0.5 bg-gym-gray-border w-full -translate-y-1/2 z-0"></div>
                <div class="absolute left-0 top-1/2 h-0.5 bg-gym-green w-1/3 -translate-y-1/2 z-0 transition-all duration-300" 
                     :style="{ width: ((currentStep - 1) / (steps.length - 1) * 100) + '%' }"></div>
                
                <div v-for="step in steps" :key="step.number" class="flex flex-col items-center relative z-10 group">
                    <div class="w-12 h-12 rounded-full border-4 flex items-center justify-center text-lg font-bold transition-colors duration-300"
                         :class="[
                             step.number === currentStep 
                                 ? 'bg-gym-green border-gym-green text-white shadow-lg shadow-gym-green/20' 
                                 : step.number < currentStep 
                                     ? 'bg-gym-green border-gym-green text-white'
                                     : 'bg-gym-card-bg border-gym-gray-border text-gym-gray-text group-hover:border-gym-green/50'
                         ]"
                    >
                        {{ step.number }}
                    </div>
                    <span class="absolute top-16 text-xs font-semibold text-center whitespace-nowrap transition-colors"
                          :class="step.number <= currentStep ? 'text-white' : 'text-gym-gray-text'">
                        {{ step.name }}
                    </span>
                </div>
            </div>
        </div>

        <div class="max-w-4xl bg-gym-card-bg p-10 rounded-3xl border border-gym-gray-border shadow-2xl">
            
            <h2 class="text-2xl font-bold text-white mb-10 flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-gym-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                Datos Personales
            </h2>

            <form @submit.prevent="submit" class="space-y-8">
                <div>
                    <label for="nombre_completo" class="block text-sm font-semibold text-gym-gray-text mb-2.5">Nombre Completo</label>
                    <input 
                        id="nombre_completo" 
                        type="text" 
                        v-model="form.nombre_completo"
                        placeholder="Ej. Juan Pérez García"
                        class="w-full px-5 py-4 bg-gym-input-bg text-white border border-gym-gray-border rounded-xl focus:ring-2 focus:ring-gym-green focus:border-gym-green transition-all placeholder:text-gym-gray-text/50"
                        required 
                    />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label for="telefono" class="block text-sm font-semibold text-gym-gray-text mb-2.5">Teléfono</label>
                        <input 
                            id="telefono" 
                            type="tel" 
                            v-model="form.telefono"
                            placeholder="Ej. 555-123-4567"
                            class="w-full px-5 py-4 bg-gym-input-bg text-white border border-gym-gray-border rounded-xl focus:ring-2 focus:ring-gym-green focus:border-gym-green transition-all placeholder:text-gym-gray-text/50"
                            required 
                        />
                    </div>
                    <div>
                        <label for="fecha_nacimiento" class="block text-sm font-semibold text-gym-gray-text mb-2.5">Fecha de Nacimiento</label>
                        <input 
                            id="fecha_nacimiento" 
                            type="date" 
                            v-model="form.fecha_nacimiento"
                            class="w-full px-5 py-4 bg-gym-input-bg text-white border border-gym-gray-border rounded-xl focus:ring-2 focus:ring-gym-green focus:border-gym-green transition-all [color-scheme:dark]"
                            required 
                        />
                    </div>
                </div>

                <div>
                    <label for="direccion" class="block text-sm font-semibold text-gym-gray-text mb-2.5">Dirección</label>
                    <input 
                        id="direccion" 
                        type="text" 
                        v-model="form.direccion"
                        placeholder="Ej. Calle Principal #123, Col. Centro"
                        class="w-full px-5 py-4 bg-gym-input-bg text-white border border-gym-gray-border rounded-xl focus:ring-2 focus:ring-gym-green focus:border-gym-green transition-all placeholder:text-gym-gray-text/50"
                        required 
                    />
                </div>

                <div>
                    <label for="contacto_emergencia" class="block text-sm font-semibold text-gym-gray-text mb-2.5">Contacto de Emergencia</label>
                    <input 
                        id="contacto_emergencia" 
                        type="text" 
                        v-model="form.contacto_emergencia"
                        placeholder="Nombre y teléfono"
                        class="w-full px-5 py-4 bg-gym-input-bg text-white border border-gym-gray-border rounded-xl focus:ring-2 focus:ring-gym-green focus:border-gym-green transition-all placeholder:text-gym-gray-text/50"
                        required 
                    />
                </div>

                <div class="flex justify-end pt-6 border-t border-gym-gray-border mt-10">
                    <button 
                        type="submit" 
                        class="flex items-center gap-2.5 px-8 py-3.5 bg-gym-gray-border text-white font-semibold rounded-xl hover:bg-gym-green hover:text-white transition-all duration-150 shadow-md group"
                    >
                        Siguiente
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gym-gray-text group-hover:text-white transition-colors" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </button>
                </div>
            </form>
        </div>
    </GymLayout>
</template>