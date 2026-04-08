<script setup>
import GymLayout from '@/Layouts/GymLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';


const empleados = ref([
    { id: 1, nombre: 'Odry Hernandez', rol: 'Entrenador', turno: 'Matutino', estado: 'Activo', clientes: '8 clientes' },
    { id: 2, nombre: 'Mauricio Rivera', rol: 'Entrenador', turno: 'Matutino', estado: 'Activo', clientes: '12 clientes' },
    { id: 3, nombre: 'Emiliano Ayala', rol: 'Entrenador', turno: 'Vespertino', estado: 'Activo', clientes: '6 clientes' },
    { id: 4, nombre: 'Josue Rivera', rol: 'Recepcionista', turno: 'Vespertino', estado: 'Activo', clientes: '-' },
]);


const turnos = ref([
    { 
        titulo: 'Matutino (6:00 - 14:00)', 
        personal: [
            { nombre: 'Odry Hernandez', rol: 'Entrenador' },
            { nombre: 'Mauricio Rivera', rol: 'Entrenador' }
        ] 
    },
    { 
        titulo: 'Vespertino (14:00 - 22:00)', 
        personal: [
            { nombre: 'Emiliano Ayala', rol: 'Entrenador' },
            { nombre: 'Josue Rivera', rol: 'Recepcionista' }
        ] 
    }
]);
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
                <button class="bg-[#00BFA5] hover:bg-[#009688] text-white px-5 py-2 rounded-lg font-bold flex items-center transition shadow-lg">
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
                                <span class="font-medium text-white">{{ emp.nombre }}</span>
                            </td>
                            <td class="p-5">{{ emp.rol }}</td>
                            <td class="p-5">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ emp.turno }}
                                </span>
                            </td>
                            <td class="p-5">
                                <span class="bg-[#00BFA5]/10 text-[#00BFA5] px-3 py-1 rounded-full text-xs font-bold border border-[#00BFA5]/20">
                                    {{ emp.estado }}
                                </span>
                            </td>
                            <td class="p-5 text-gray-400">{{ emp.clientes }}</td>
                            <td class="p-5 text-right">
                                <button class="text-gray-500 hover:text-white mr-3"><i class="fas fa-edit"></i> ✏️</button>
                                <button class="text-gray-500 hover:text-red-500"><i class="fas fa-trash"></i> 🗑️</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <h2 class="text-2xl font-bold text-white mb-6">Turnos Asignados</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div v-for="turno in turnos" :key="turno.titulo" class="bg-[#111111] border border-white/5 p-6 rounded-2xl shadow-xl">
                    <h3 class="text-gray-400 text-sm mb-4">{{ turno.titulo }}</h3>
                    <div class="space-y-3">
                        <div v-for="p in turno.personal" :key="p.nombre" class="bg-white/5 p-4 rounded-xl flex items-center gap-4 border border-white/5 hover:border-[#00BFA5]/50 transition">
                            <div class="w-12 h-12 bg-white/10 rounded-lg flex items-center justify-center text-gray-400">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-white font-bold leading-none mb-1">{{ p.nombre }}</p>
                                <p class="text-gray-500 text-xs">{{ p.rol }}</p>
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
    transition: all 0.3s ease;
}
</style>