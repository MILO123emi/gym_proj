<script setup>
import GymLayout from '@/Layouts/GymLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({
    employees: { type: Array, default: () => [] },
});

const empleados = computed(() => props.employees);

const showModal = ref(false);
const isEditing = ref(false);
const editingId = ref(null);

const form = useForm({
    name: '',
    email: '',
    role: 'receptionist',
    active: true,
    password: '',
});

const roleLabel = (role) => {
    if (role === 'admin') return 'Administrador';
    if (role === 'trainer') return 'Entrenador';
    return 'Recepcionista';
};

const openCreate = () => {
    isEditing.value = false;
    editingId.value = null;
    form.reset();
    form.role = 'receptionist';
    form.active = true;
    showModal.value = true;
};

const openEdit = (emp) => {
    isEditing.value = true;
    editingId.value = emp.id;
    form.name = emp.name;
    form.email = emp.email;
    form.role = emp.role;
    form.active = emp.active;
    form.password = '';
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
};

const submit = () => {
    if (isEditing.value) {
        form.patch(route('employees.update', editingId.value), {
            preserveScroll: true,
            onSuccess: closeModal,
        });
        return;
    }

    form.post(route('employees.store'), {
        preserveScroll: true,
        onSuccess: closeModal,
    });
};

const eliminar = (emp) => {
    if (!confirm(`¿Eliminar al empleado ${emp.name}?`)) return;
    form.delete(route('employees.destroy', emp.id), {
        preserveScroll: true,
    });
};
</script>

<template>
    <Head title="Gestión de Empleados" />

    <GymLayout>
        <div class="p-6">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-white">Gestión de Empleados</h1>
                    <p class="text-gray-400">Administración de personal</p>
                </div>
                <button @click="openCreate" class="bg-[#00BFA5] hover:bg-[#009688] text-white px-5 py-2 rounded-lg font-bold flex items-center transition shadow-lg">
                    <span class="mr-2 text-xl">+</span> Nuevo Empleado
                </button>
            </div>

            <div class="bg-[#111111] border border-white/5 rounded-2xl overflow-hidden shadow-2xl mb-10">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-gray-500 text-xs uppercase tracking-wider border-b border-white/5">
                            <th class="p-5 font-semibold">Nombre</th>
                            <th class="p-5 font-semibold">Rol</th>
                            <th class="p-5 font-semibold">Turno</th>
                            <th class="p-5 font-semibold">Estado</th>
                            <th class="p-5 font-semibold">Clientes</th>
                            <th class="p-5 font-semibold text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-300">
                        <tr v-for="emp in empleados" :key="emp.id" class="border-b border-white/5 hover:bg-white/5 transition">
                            <td class="p-5 flex items-center gap-3">
                                <div class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                <span class="font-medium text-white">{{ emp.name }}</span>
                            </td>
                            <td class="p-5">{{ roleLabel(emp.role) }}</td>
                            <td class="p-5">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    -
                                </span>
                            </td>
                            <td class="p-5">
                                <span :class="emp.active ? 'bg-[#00BFA5]/10 text-[#00BFA5] border-[#00BFA5]/20' : 'bg-red-500/10 text-red-500 border-red-500/20'" class="px-3 py-1 rounded-full text-xs font-bold border">
                                    {{ emp.active ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td class="p-5 text-gray-400">
                                <span v-if="emp.role === 'trainer'">{{ emp.clients_count }} clientes</span>
                                <span v-else>-</span>
                            </td>
                            <td class="p-5 text-right">
                                <button @click="openEdit(emp)" class="text-gray-500 hover:text-white mr-3"><i class="fas fa-edit"></i> ✏️</button>
                                <button @click="eliminar(emp)" class="text-red-400 hover:text-red-300">🗑️</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <h2 class="text-2xl font-bold text-white mb-6">Turnos Asignados</h2>
            <div class="bg-[#111111] border border-white/5 p-6 rounded-2xl shadow-xl text-gray-400">
                No hay turnos configurados en el sistema.
            </div>
        </div>

        <div v-if="showModal" class="fixed inset-0 bg-black/70 flex items-center justify-center p-6 z-50">
            <div class="bg-[#111111] border border-white/10 rounded-2xl p-6 w-full max-w-lg">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-white font-bold text-lg">{{ isEditing ? 'Editar Empleado' : 'Nuevo Empleado' }}</h3>
                    <button @click="closeModal" class="text-gray-400 hover:text-white">✕</button>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="text-gray-400 text-xs font-bold uppercase">Nombre</label>
                        <input v-model="form.name" class="w-full bg-white/5 border border-white/10 rounded-xl py-2 px-3 text-white focus:border-[#00BFA5] focus:ring-0 transition" />
                    </div>
                    <div>
                        <label class="text-gray-400 text-xs font-bold uppercase">Email</label>
                        <input v-model="form.email" type="email" class="w-full bg-white/5 border border-white/10 rounded-xl py-2 px-3 text-white focus:border-[#00BFA5] focus:ring-0 transition" />
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-gray-400 text-xs font-bold uppercase">Rol</label>
                            <select v-model="form.role" class="w-full bg-white/5 border border-white/10 rounded-xl py-2 px-3 text-white focus:border-[#00BFA5] focus:ring-0 transition">
                                <option value="receptionist">Recepcionista</option>
                                <option value="trainer">Entrenador</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-gray-400 text-xs font-bold uppercase">Estado</label>
                            <select v-model="form.active" class="w-full bg-white/5 border border-white/10 rounded-xl py-2 px-3 text-white focus:border-[#00BFA5] focus:ring-0 transition">
                                <option :value="true">Activo</option>
                                <option :value="false">Inactivo</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="text-gray-400 text-xs font-bold uppercase">Contraseña {{ isEditing ? '(opcional)' : '' }}</label>
                        <input v-model="form.password" type="password" class="w-full bg-white/5 border border-white/10 rounded-xl py-2 px-3 text-white focus:border-[#00BFA5] focus:ring-0 transition" />
                        <p v-if="form.errors.password" class="mt-1 text-xs text-red-400">{{ form.errors.password }}</p>
                    </div>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button @click="closeModal" class="bg-white/5 hover:bg-white/10 text-white px-4 py-2 rounded-lg font-bold border border-white/10 transition">Cancelar</button>
                    <button @click="submit" :disabled="form.processing" class="bg-[#00BFA5] hover:bg-[#009688] text-white px-4 py-2 rounded-lg font-bold transition disabled:opacity-50">
                        Guardar
                    </button>
                </div>
            </div>
        </div>
    </GymLayout>
</template>

<style scoped>

.transition-all {
    transition: all 0.3s ease;
}
</style>