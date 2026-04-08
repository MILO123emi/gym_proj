<script setup>
import GymLayout from '@/Layouts/GymLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';


const clienteAEditar = ref({
    nombre: 'Florentino Guevara',
    telefono: '3536-0101',
    email: 'florentino@email.com',
    direccion: 'Calle Principal #123',
    emergencia: 'Milexcy Perez - 9893-0201'
});


const resultados = ref([
    { id: 1, nombre: 'Florentino Guevara', tel: '555-0101' },
    { id: 2, nombre: 'Mikel Romero', tel: '9894-0102' },
    { id: 3, nombre: 'Leonardo Hernandez', tel: '9885-0103' },
]);

const editarCampo = (campo) => {
    console.log(`Editando el campo: ${campo}`);
    
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
                            @click="clienteAEditar.nombre = c.nombre"
                            :class="[c.nombre === clienteAEditar.nombre ? 'border-[#00BFA5] bg-[#00BFA5]/5' : 'border-white/5 bg-white/5']"
                            class="p-4 rounded-xl border flex flex-col cursor-pointer hover:bg-white/10 transition group">
                            <span class="font-bold text-sm text-white">{{ c.nombre }}</span>
                            <span class="text-gray-500 text-[10px]">{{ c.tel }}</span>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-8 bg-[#111111] border border-white/5 rounded-2xl p-8 shadow-xl">
                    <h2 class="text-xl font-bold text-white mb-6">Editar: {{ clienteAEditar.nombre }}</h2>

                    <div class="space-y-4">
                        <div class="bg-white/5 p-4 rounded-xl border border-white/5 flex justify-between items-center group">
                            <div>
                                <p class="text-gray-500 text-[10px] uppercase font-bold mb-1 tracking-wider">Nombre Completo</p>
                                <p class="text-white font-medium">{{ clienteAEditar.nombre }}</p>
                            </div>
                            <button @click="editarCampo('nombre')" class="bg-[#1E1E1E] hover:bg-[#2A2A2A] text-gray-400 hover:text-white px-3 py-1.5 rounded-lg text-[10px] flex items-center gap-2 transition border border-white/5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                Editar
                            </button>
                        </div>

                        <div class="bg-white/5 p-4 rounded-xl border border-white/5 flex justify-between items-center group">
                            <div>
                                <p class="text-gray-500 text-[10px] uppercase font-bold mb-1 tracking-wider">Teléfono</p>
                                <p class="text-white font-medium">{{ clienteAEditar.telefono }}</p>
                            </div>
                            <button @click="editarCampo('telefono')" class="bg-[#1E1E1E] hover:bg-[#2A2A2A] text-gray-400 hover:text-white px-3 py-1.5 rounded-lg text-[10px] flex items-center gap-2 transition border border-white/5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                Editar
                            </button>
                        </div>

                        <div class="bg-white/5 p-4 rounded-xl border border-white/5 flex justify-between items-center group">
                            <div>
                                <p class="text-gray-500 text-[10px] uppercase font-bold mb-1 tracking-wider">Email</p>
                                <p class="text-white font-medium">{{ clienteAEditar.email }}</p>
                            </div>
                            <button @click="editarCampo('email')" class="bg-[#1E1E1E] hover:bg-[#2A2A2A] text-gray-400 hover:text-white px-3 py-1.5 rounded-lg text-[10px] flex items-center gap-2 transition border border-white/5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                Editar
                            </button>
                        </div>

                        <div class="bg-white/5 p-4 rounded-xl border border-white/5 flex justify-between items-center group">
                            <div>
                                <p class="text-gray-500 text-[10px] uppercase font-bold mb-1 tracking-wider">Dirección</p>
                                <p class="text-white font-medium">{{ clienteAEditar.direccion }}</p>
                            </div>
                            <button @click="editarCampo('direccion')" class="bg-[#1E1E1E] hover:bg-[#2A2A2A] text-gray-400 hover:text-white px-3 py-1.5 rounded-lg text-[10px] flex items-center gap-2 transition border border-white/5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                Editar
                            </button>
                        </div>

                        <div class="bg-white/5 p-4 rounded-xl border border-white/5 flex justify-between items-center group">
                            <div>
                                <p class="text-gray-500 text-[10px] uppercase font-bold mb-1 tracking-wider">Contacto de Emergencia</p>
                                <p class="text-white font-medium">{{ clienteAEditar.emergencia }}</p>
                            </div>
                            <button @click="editarCampo('emergencia')" class="bg-[#1E1E1E] hover:bg-[#2A2A2A] text-gray-400 hover:text-white px-3 py-1.5 rounded-lg text-[10px] flex items-center gap-2 transition border border-white/5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                Editar
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