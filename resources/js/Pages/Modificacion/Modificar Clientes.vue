<script setup>
import GymLayout from '@/Layouts/GymLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({
    clients: {
        type: Array,
        default: () => [],
    },
});

const selectedId = ref(props.clients[0]?.id || null);
const resultados = computed(() => props.clients);
const clienteAEditar = computed(() => {
    return props.clients.find(c => c.id === selectedId.value) || props.clients[0] || null;
});

const editingField = ref(null);

const form = useForm({
    nombre: '',
    apellido: '',
    telefono: '',
    email: '',
    cedula: '',
    direccion: '',
    contacto_emergencia: '',
});

const fillForm = (client) => {
    if (!client) return;
    form.nombre = client.nombre || '';
    form.apellido = client.apellido || '';
    form.telefono = client.telefono || '';
    form.email = client.email || '';
    form.cedula = client.cedula || '';
    form.direccion = client.direccion || '';
    form.contacto_emergencia = client.contacto_emergencia || '';
};

fillForm(clienteAEditar.value);

const selectClient = (c) => {
    selectedId.value = c.id;
    editingField.value = null;
    fillForm(c);
};

const editarCampo = (campo) => {
    editingField.value = editingField.value === campo ? null : campo;
};

const guardar = () => {
    if (!clienteAEditar.value) return;

    form.patch(route('clientes.update', clienteAEditar.value.id), {
        preserveScroll: true,
        onSuccess: () => {
            editingField.value = null;
        },
    });
};
</script>

<template>
    <Head title="Modificar Clientes" />

    <GymLayout>
        <div class="p-6">
            <header class="mb-8">
                <h1 class="text-3xl font-bold text-white">Modificación de Clientes</h1>
                <p class="text-gray-400 text-sm">Editar información de miembros</p>
            </header>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                
                <div class="lg:col-span-4 bg-[#111111] border border-white/5 rounded-2xl p-6 shadow-xl">
                    <h2 class="text-lg font-bold text-white mb-4">Buscar Cliente</h2>
                    <div class="relative mb-6">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </span>
                        <input type="text" placeholder="Buscar cliente..." class="w-full bg-white/5 border border-white/10 rounded-xl py-2 pl-10 text-white focus:border-[#00BFA5] focus:ring-0 transition">
                    </div>

                    <div class="space-y-3">
                        <div v-for="c in resultados" :key="c.id" 
                            @click="selectClient(c)"
                            :class="[c.id === selectedId ? 'border-[#00BFA5] bg-[#00BFA5]/5' : 'border-white/5 bg-white/5']"
                            class="p-4 rounded-xl border flex flex-col cursor-pointer hover:bg-white/10 transition group">
                            <span class="font-bold text-sm text-white">{{ c.full_name }}</span>
                            <span class="text-gray-500 text-[10px]">{{ c.telefono }}</span>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-8 bg-[#111111] border border-white/5 rounded-2xl p-8 shadow-xl">
                    <h2 v-if="clienteAEditar" class="text-xl font-bold text-white mb-6">Editar: {{ clienteAEditar.full_name }}</h2>

                    <div class="space-y-4">
                        <div class="bg-white/5 p-4 rounded-xl border border-white/5 flex justify-between items-center group">
                            <div>
                                <p class="text-gray-500 text-[10px] uppercase font-bold mb-1 tracking-wider">Nombre Completo</p>
                                <p v-if="editingField !== 'nombre'" class="text-white font-medium">{{ form.nombre }} {{ form.apellido }}</p>
                                <div v-else class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <input v-model="form.nombre" type="text" class="w-full bg-white/5 border border-white/10 rounded-xl py-2 px-3 text-white focus:border-[#00BFA5] focus:ring-0 transition" />
                                    <input v-model="form.apellido" type="text" class="w-full bg-white/5 border border-white/10 rounded-xl py-2 px-3 text-white focus:border-[#00BFA5] focus:ring-0 transition" />
                                </div>
                            </div>
                            <button @click="editingField === 'nombre' ? guardar() : editarCampo('nombre')" class="bg-[#1E1E1E] hover:bg-[#2A2A2A] text-gray-400 hover:text-white px-3 py-1.5 rounded-lg text-[10px] flex items-center gap-2 transition border border-white/5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                {{ editingField === 'nombre' ? 'Guardar' : 'Editar' }}
                            </button>
                        </div>

                        <div class="bg-white/5 p-4 rounded-xl border border-white/5 flex justify-between items-center group">
                            <div>
                                <p class="text-gray-500 text-[10px] uppercase font-bold mb-1 tracking-wider">Teléfono</p>
                                <p v-if="editingField !== 'telefono'" class="text-white font-medium">{{ form.telefono }}</p>
                                <input v-else v-model="form.telefono" type="text" class="w-full bg-white/5 border border-white/10 rounded-xl py-2 px-3 text-white focus:border-[#00BFA5] focus:ring-0 transition" />
                            </div>
                            <button @click="editingField === 'telefono' ? guardar() : editarCampo('telefono')" class="bg-[#1E1E1E] hover:bg-[#2A2A2A] text-gray-400 hover:text-white px-3 py-1.5 rounded-lg text-[10px] flex items-center gap-2 transition border border-white/5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                {{ editingField === 'telefono' ? 'Guardar' : 'Editar' }}
                            </button>
                        </div>

                        <div class="bg-white/5 p-4 rounded-xl border border-white/5 flex justify-between items-center group">
                            <div>
                                <p class="text-gray-500 text-[10px] uppercase font-bold mb-1 tracking-wider">Email</p>
                                <p v-if="editingField !== 'email'" class="text-white font-medium">{{ form.email }}</p>
                                <input v-else v-model="form.email" type="email" class="w-full bg-white/5 border border-white/10 rounded-xl py-2 px-3 text-white focus:border-[#00BFA5] focus:ring-0 transition" />
                            </div>
                            <button @click="editingField === 'email' ? guardar() : editarCampo('email')" class="bg-[#1E1E1E] hover:bg-[#2A2A2A] text-gray-400 hover:text-white px-3 py-1.5 rounded-lg text-[10px] flex items-center gap-2 transition border border-white/5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                {{ editingField === 'email' ? 'Guardar' : 'Editar' }}
                            </button>
                        </div>

                        <div class="bg-white/5 p-4 rounded-xl border border-white/5 flex justify-between items-center group">
                            <div>
                                <p class="text-gray-500 text-[10px] uppercase font-bold mb-1 tracking-wider">Dirección</p>
                                <p v-if="editingField !== 'direccion'" class="text-white font-medium">{{ form.direccion }}</p>
                                <input v-else v-model="form.direccion" type="text" class="w-full bg-white/5 border border-white/10 rounded-xl py-2 px-3 text-white focus:border-[#00BFA5] focus:ring-0 transition" />
                            </div>
                            <button @click="editingField === 'direccion' ? guardar() : editarCampo('direccion')" class="bg-[#1E1E1E] hover:bg-[#2A2A2A] text-gray-400 hover:text-white px-3 py-1.5 rounded-lg text-[10px] flex items-center gap-2 transition border border-white/5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                {{ editingField === 'direccion' ? 'Guardar' : 'Editar' }}
                            </button>
                        </div>

                        <div class="bg-white/5 p-4 rounded-xl border border-white/5 flex justify-between items-center group">
                            <div>
                                <p class="text-gray-500 text-[10px] uppercase font-bold mb-1 tracking-wider">Contacto de Emergencia</p>
                                <p v-if="editingField !== 'contacto_emergencia'" class="text-white font-medium">{{ form.contacto_emergencia }}</p>
                                <input v-else v-model="form.contacto_emergencia" type="text" class="w-full bg-white/5 border border-white/10 rounded-xl py-2 px-3 text-white focus:border-[#00BFA5] focus:ring-0 transition" />
                            </div>
                            <button @click="editingField === 'contacto_emergencia' ? guardar() : editarCampo('contacto_emergencia')" class="bg-[#1E1E1E] hover:bg-[#2A2A2A] text-gray-400 hover:text-white px-3 py-1.5 rounded-lg text-[10px] flex items-center gap-2 transition border border-white/5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                {{ editingField === 'contacto_emergencia' ? 'Guardar' : 'Editar' }}
                            </button>
                        </div>
                    </div>

                    <div class="mt-10">
                        <h3 class="text-white font-bold mb-4">Gestión de Contraseña</h3>
                        <button class="bg-[#1E1E1E] hover:bg-[#2A2A2A] text-white font-bold py-3 px-6 rounded-xl border border-white/5 transition text-sm">
                            Restablecer Contraseña
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </GymLayout>
</template>