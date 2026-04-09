<script setup>
import GymLayout from '@/Layouts/GymLayout.vue'; 
import { Head, useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({
    providers: { type: Array, default: () => [] },
});

const proveedores = computed(() => props.providers);

const showModal = ref(false);
const isEditing = ref(false);
const editingId = ref(null);

const form = useForm({
    nombre: '',
    servicio: '',
    telefono: '',
    email: '',
    notas: '',
    activo: true,
});

const openCreate = () => {
    isEditing.value = false;
    editingId.value = null;
    form.reset();
    form.activo = true;
    showModal.value = true;
};

const openEdit = (p) => {
    isEditing.value = true;
    editingId.value = p.id;
    form.nombre = p.nombre || '';
    form.servicio = p.servicio || '';
    form.telefono = p.telefono || '';
    form.email = p.email || '';
    form.notas = p.notas || '';
    form.activo = !!p.activo;
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
};

const submit = () => {
    if (isEditing.value) {
        form.patch(route('support-providers.update', editingId.value), {
            preserveScroll: true,
            onSuccess: closeModal,
        });
        return;
    }

    form.post(route('support-providers.store'), {
        preserveScroll: true,
        onSuccess: closeModal,
    });
};
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
                <button @click="openCreate" class="bg-[#00a878] text-black px-4 py-2 rounded-lg font-bold">
                    + Agregar Proveedor
                </button>
            </div>

            <div class="flex gap-2 flex-wrap">
                <button class="bg-[#00a878] text-black px-4 py-1.5 rounded-full text-sm font-bold">Todos</button>
                <button class="bg-white/5 text-gray-400 px-4 py-1.5 rounded-full text-sm hover:bg-white/10">Máquinas de ejercicio</button>
                <button class="bg-white/5 text-gray-400 px-4 py-1.5 rounded-full text-sm hover:bg-white/10">Aire acondicionado</button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div v-for="p in proveedores" :key="p.id" class="bg-[#111111] border border-white/5 p-5 rounded-xl">
                    <div class="flex justify-between mb-4">
                        <div class="bg-[#00a878]/20 p-2 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-[#00a878]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                            </svg>
                        </div>
                        <button @click="openEdit(p)" class="text-gray-500 hover:text-white text-sm">✏️</button>
                    </div>
                    <h3 class="text-white font-bold text-lg">{{ p.nombre }}</h3>
                    <p class="text-gray-500 text-sm mb-4">{{ p.servicio }}</p>
                    <div class="bg-black/40 p-3 rounded-lg border border-white/5 flex items-center gap-2">
                        <span class="text-gray-400 text-xs">📞</span>
                        <span class="text-gray-300 font-mono">{{ p.telefono || '-' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="showModal" class="fixed inset-0 bg-black/70 flex items-center justify-center p-6 z-50">
            <div class="bg-[#111111] border border-white/10 rounded-2xl p-6 w-full max-w-lg">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-white font-bold text-lg">{{ isEditing ? 'Editar Proveedor' : 'Nuevo Proveedor' }}</h3>
                    <button @click="closeModal" class="text-gray-400 hover:text-white">✕</button>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="text-gray-400 text-xs font-bold uppercase">Nombre</label>
                        <input v-model="form.nombre" class="w-full bg-white/5 border border-white/10 rounded-xl py-2 px-3 text-white focus:border-[#00a878] focus:ring-0 transition" />
                    </div>
                    <div>
                        <label class="text-gray-400 text-xs font-bold uppercase">Servicio</label>
                        <input v-model="form.servicio" class="w-full bg-white/5 border border-white/10 rounded-xl py-2 px-3 text-white focus:border-[#00a878] focus:ring-0 transition" />
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-gray-400 text-xs font-bold uppercase">Teléfono</label>
                            <input v-model="form.telefono" class="w-full bg-white/5 border border-white/10 rounded-xl py-2 px-3 text-white focus:border-[#00a878] focus:ring-0 transition" />
                        </div>
                        <div>
                            <label class="text-gray-400 text-xs font-bold uppercase">Email</label>
                            <input v-model="form.email" type="email" class="w-full bg-white/5 border border-white/10 rounded-xl py-2 px-3 text-white focus:border-[#00a878] focus:ring-0 transition" />
                        </div>
                    </div>
                    <div>
                        <label class="text-gray-400 text-xs font-bold uppercase">Notas</label>
                        <input v-model="form.notas" class="w-full bg-white/5 border border-white/10 rounded-xl py-2 px-3 text-white focus:border-[#00a878] focus:ring-0 transition" />
                    </div>
                    <div>
                        <label class="text-gray-400 text-xs font-bold uppercase">Activo</label>
                        <select v-model="form.activo" class="w-full bg-white/5 border border-white/10 rounded-xl py-2 px-3 text-white focus:border-[#00a878] focus:ring-0 transition">
                            <option :value="true">Sí</option>
                            <option :value="false">No</option>
                        </select>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button @click="closeModal" class="bg-white/5 hover:bg-white/10 text-white px-4 py-2 rounded-lg font-bold border border-white/10 transition">Cancelar</button>
                    <button @click="submit" :disabled="form.processing" class="bg-[#00a878] hover:bg-[#008f63] text-black px-4 py-2 rounded-lg font-bold transition disabled:opacity-50">
                        Guardar
                    </button>
                </div>
            </div>
        </div>
    </GymLayout>
</template>