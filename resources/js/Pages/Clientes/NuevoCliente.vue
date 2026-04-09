<script setup>
import GymLayout from '@/Layouts/GymLayout.vue'; 
import { Head, useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({
    membershipPlans: {
        type: Array,
        default: () => [],
    },
});

const form = useForm({
    nombre_completo: '',
    email: '',
    cedula: '',
    telefono: '',
    fecha_nacimiento: '',
    direccion: '',
    contacto_emergencia: '',
    membership_plan_id: null,
    plan_tipo: '',
    metodo_pago: '',
});

const steps = [
    { number: 1, name: 'Datos' },
    { number: 2, name: 'Plan' },
    { number: 3, name: 'Pago' },
    { number: 4, name: 'Confirmar' },
];

// Cambiamos a ref para que sea reactivo
const currentStep = ref(1); 
const registeredClientName = ref('');
const maxBirthDate = new Date(new Date().setFullYear(new Date().getFullYear() - 15)).toISOString().split('T')[0];

const siguientePaso = () => {
    if (currentStep.value < 4) currentStep.value++;
};

const pasoAnterior = () => {
    if (currentStep.value > 1) currentStep.value--;
};

const canContinueStep = computed(() => {
    if (currentStep.value === 1) {
        return form.nombre_completo && form.email && form.cedula && form.telefono && form.fecha_nacimiento;
    }

    if (currentStep.value === 2) {
        return form.membership_plan_id || form.plan_tipo;
    }

    if (currentStep.value === 3) {
        return form.metodo_pago;
    }

    return true;
});

const continueOrSubmit = () => {
    if (!canContinueStep.value) return;

    if (currentStep.value === 3) {
        submit();
        return;
    }

    siguientePaso();
};

const submit = () => {
    form.post(route('clientes.store'), { 
        onSuccess: () => {
            registeredClientName.value = form.nombre_completo;
            currentStep.value = 4;
        },
    });
};

const selectedPlan = computed(() => {
    return availablePlans.value.find(p => p.id === form.membership_plan_id || p.tipo === form.plan_tipo) || null;
});

const totalToPay = computed(() => {
    return selectedPlan.value ? Number(selectedPlan.value.precio) : 0;
});

const fallbackPlans = [
    { id: null, tipo: 'mensual', nombre: 'Plan Mensual', descripcion: 'Acceso mensual', precio: 60 },
    { id: null, tipo: 'semestral', nombre: 'Plan Semestral', descripcion: 'Acceso por 6 meses', precio: 280 },
    { id: null, tipo: 'anual', nombre: 'Plan Anual', descripcion: 'Acceso anual', precio: 500 },
];

const availablePlans = computed(() => {
    if (props.membershipPlans.length > 0) {
        return props.membershipPlans.map(p => ({ ...p, tipo: p.tipo || '' }));
    }
    return fallbackPlans;
});

const selectPlan = (plan) => {
    if (plan.id) {
        form.membership_plan_id = plan.id;
        form.plan_tipo = '';
        return;
    }

    form.membership_plan_id = null;
    form.plan_tipo = plan.tipo;
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
                <div class="absolute left-0 top-1/2 h-0.5 bg-gym-green -translate-y-1/2 z-0 transition-all duration-500" 
                     :style="{ width: ((currentStep - 1) / (steps.length - 1) * 100) + '%' }"></div>
                
                <div v-for="step in steps" :key="step.number" class="flex flex-col items-center relative z-10 group">
                    <div class="w-12 h-12 rounded-full border-4 flex items-center justify-center text-lg font-bold transition-all duration-300"
                         :class="[
                             step.number === currentStep 
                                 ? 'bg-gym-green border-gym-green text-white shadow-lg shadow-gym-green/40 scale-110' 
                                 : step.number < currentStep 
                                     ? 'bg-gym-green border-gym-green text-white'
                                     : 'bg-gym-card-bg border-gym-gray-border text-gym-gray-text group-hover:border-gym-green/50'
                         ]"
                    >
                        <svg v-if="step.number < currentStep" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        <span v-else>{{ step.number }}</span>
                    </div>
                    <span class="absolute top-16 text-xs font-semibold text-center whitespace-nowrap transition-colors"
                          :class="step.number <= currentStep ? 'text-white' : 'text-gym-gray-text'">
                        {{ step.name }}
                    </span>
                </div>
            </div>
        </div>

        <div class="max-w-4xl bg-gym-card-bg p-10 rounded-3xl border border-gym-gray-border shadow-2xl mx-auto">
            
            <div v-if="currentStep === 1">
                <h2 class="text-2xl font-bold text-white mb-10 flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-gym-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    Datos Personales
                </h2>
                <div class="space-y-8">
                    <div>
                        <label class="block text-sm font-semibold text-gym-gray-text mb-2.5">Nombre Completo</label>
                        <input v-model="form.nombre_completo" type="text" required pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{3,255}" placeholder="Ej. Juan Pérez García" class="w-full px-5 py-4 bg-gym-input-bg text-white border border-gym-gray-border rounded-xl focus:ring-2 focus:ring-gym-green outline-none transition-all">
                        <p v-if="form.errors.nombre_completo" class="text-xs text-red-400 mt-1">{{ form.errors.nombre_completo }}</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-sm font-semibold text-gym-gray-text mb-2.5">Email</label>
                            <input v-model="form.email" type="email" required placeholder="Ej. juan@email.com" class="w-full px-5 py-4 bg-gym-input-bg text-white border border-gym-gray-border rounded-xl focus:ring-2 focus:ring-gym-green outline-none transition-all">
                            <p v-if="form.errors.email" class="text-xs text-red-400 mt-1">{{ form.errors.email }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gym-gray-text mb-2.5">Cédula</label>
                            <input v-model="form.cedula" type="text" required placeholder="Ej. V-12345678" class="w-full px-5 py-4 bg-gym-input-bg text-white border border-gym-gray-border rounded-xl focus:ring-2 focus:ring-gym-green outline-none transition-all">
                            <p v-if="form.errors.cedula" class="text-xs text-red-400 mt-1">{{ form.errors.cedula }}</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <label class="block text-sm font-semibold text-gym-gray-text mb-2.5">Teléfono</label>
                            <input v-model="form.telefono" type="tel" required pattern="[2389][0-9]{7}" maxlength="8" placeholder="Ej. 98765432" class="w-full px-5 py-4 bg-gym-input-bg text-white border border-gym-gray-border rounded-xl focus:ring-2 focus:ring-gym-green outline-none">
                            <p v-if="form.errors.telefono" class="text-xs text-red-400 mt-1">{{ form.errors.telefono }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gym-gray-text mb-2.5">Fecha de Nacimiento</label>
                            <input v-model="form.fecha_nacimiento" type="date" required :max="maxBirthDate" class="w-full px-5 py-4 bg-gym-input-bg text-white border border-gym-gray-border rounded-xl focus:ring-2 focus:ring-gym-green outline-none [color-scheme:dark]">
                            <p v-if="form.errors.fecha_nacimiento" class="text-xs text-red-400 mt-1">{{ form.errors.fecha_nacimiento }}</p>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gym-gray-text mb-2.5">Dirección</label>
                        <input v-model="form.direccion" type="text" placeholder="Calle Principal #123" class="w-full px-5 py-4 bg-gym-input-bg text-white border border-gym-gray-border rounded-xl focus:ring-2 focus:ring-gym-green outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gym-gray-text mb-2.5">Contacto de Emergencia</label>
                        <input v-model="form.contacto_emergencia" type="text" placeholder="Ej. María Pérez - 555-000-0000" class="w-full px-5 py-4 bg-gym-input-bg text-white border border-gym-gray-border rounded-xl focus:ring-2 focus:ring-gym-green outline-none">
                    </div>
                </div>
            </div>

            <div v-else-if="currentStep === 2">
                <h2 class="text-2xl font-bold text-white mb-10 flex items-center gap-3">
                    <svg class="w-7 h-7 text-gym-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    Selección de Plan
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div v-for="plan in availablePlans" :key="plan.id || plan.tipo" 
                         @click="selectPlan(plan)"
                         :class="(plan.id ? form.membership_plan_id === plan.id : form.plan_tipo === plan.tipo) ? 'border-gym-green bg-gym-green/10' : 'border-gym-gray-border bg-gym-input-bg'"
                         class="p-8 rounded-2xl border-2 cursor-pointer transition-all hover:border-gym-green group text-center">
                        <h3 class="text-white font-bold text-xl mb-2">{{ plan.nombre }}</h3>
                        <p class="text-gym-gray-text text-sm">{{ plan.descripcion || 'Acceso total a las instalaciones' }}</p>
                        <div class="mt-4 text-gym-green font-bold" v-if="plan.id ? form.membership_plan_id === plan.id : form.plan_tipo === plan.tipo">Seleccionado</div>
                    </div>
                </div>
            </div>

            <div v-else-if="currentStep === 3">
                <h2 class="text-2xl font-bold text-white mb-10 flex items-center gap-3">
                    <svg class="w-7 h-7 text-gym-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    Método de Pago
                </h2>
                <div class="bg-gym-input-bg border border-gym-gray-border p-8 rounded-2xl mb-8">
                    <div class="flex justify-between text-white mb-4">
                        <span>Plan {{ selectedPlan?.nombre || '' }}</span>
                        <span class="font-bold">L {{ totalToPay.toFixed(2) }}</span>
                    </div>
                    <div class="flex justify-between text-gym-green text-xl font-black pt-4 border-t border-gym-gray-border">
                        <span>Total a Pagar</span>
                        <span>L {{ totalToPay.toFixed(2) }} HNL</span>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <button v-for="metodo in ['Tarjeta', 'Efectivo']" :key="metodo"
                            @click="form.metodo_pago = metodo === 'Efectivo' ? 'efectivo' : 'tarjeta_debito'"
                            :class="(metodo === 'Efectivo' ? form.metodo_pago === 'efectivo' : form.metodo_pago === 'tarjeta_debito') ? 'bg-gym-green text-white' : 'bg-gym-input-bg text-gym-gray-text border-gym-gray-border'"
                            class="py-4 rounded-xl border font-bold transition-all">
                        {{ metodo }}
                    </button>
                </div>
            </div>

            <div v-else-if="currentStep === 4" class="text-center py-12">
                <div class="w-24 h-24 bg-gym-green/20 text-gym-green rounded-full flex items-center justify-center mx-auto mb-8 shadow-xl shadow-gym-green/10">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <h2 class="text-3xl font-black text-white mb-4">¡Registro Exitoso!</h2>
                <p class="text-gym-gray-text text-lg">El cliente <strong>{{ registeredClientName }}</strong> ha sido registrado en el sistema correctamente.</p>
                <button @click="(currentStep = 1, form.reset())" class="mt-10 text-gym-green font-bold hover:underline">Registrar otro cliente</button>
            </div>

            <div v-if="currentStep < 4" class="flex justify-between items-center mt-12 pt-8 border-t border-gym-gray-border">
                <button v-if="currentStep > 1" @click="pasoAnterior" class="text-gym-gray-text font-bold hover:text-white transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    Atrás
                </button>
                <div v-else></div>

                
     

    <button @click="continueOrSubmit" :disabled="!canContinueStep || form.processing"
            class="bg-gym-green text-white px-10 py-4 rounded-2xl font-black hover:bg-opacity-90 transition-all shadow-lg shadow-gym-green/20 flex items-center gap-2 disabled:opacity-50">
        {{ currentStep === 3 ? 'Finalizar Registro' : 'Siguiente' }}
        <svg v-if="currentStep < 3" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
    </button>
</div>
            </div>
      
    </GymLayout>
</template>