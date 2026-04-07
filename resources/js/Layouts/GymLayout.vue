<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="flex min-h-screen bg-[#0a0a0a] text-white">
        
        <aside class="w-72 bg-[#111111] border-r border-white/5 flex flex-col p-6 shadow-2xl">
            <div class="mb-10 flex items-center gap-3 px-2">
                <div class="w-10 h-10 bg-[#00a878]/20 rounded-xl flex items-center justify-center text-[#00a878]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 3h12l4 6-10 13L2 9z"/></svg>
                </div>
                <div>
                    <h2 class="font-black text-xl tracking-tight leading-none">Gimnasio</h2>
                    <p class="text-[10px] text-gray-500 uppercase font-bold tracking-widest mt-1">Sistema de Gestión</p>
                </div>
            </div>

            <nav class="flex-1 space-y-1 overflow-y-auto pr-2 custom-scrollbar">
                
                <Link :href="route('dashboard')" 
                    :class="route().current('dashboard') ? 'bg-[#00a878] text-black shadow-[0_0_20px_rgba(0,168,120,0.3)]' : 'text-gray-400 hover:bg-white/5 hover:text-white'"
                    class="flex items-center gap-3 p-3 rounded-xl transition-all duration-300 font-bold text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                    Panel General
                </Link>

                <Link :href="route('clientes.nuevo')" 
                    :class="route().current('clientes.nuevo') ? 'bg-[#00a878] text-black shadow-[0_0_20px_rgba(0,168,120,0.3)]' : 'text-gray-400 hover:bg-white/5 hover:text-white'"
                    class="flex items-center gap-3 p-3 rounded-xl transition-all duration-300 font-bold text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>
                    Nuevo Cliente
                </Link>

                <Link :href="route('cobranza')" 
                    :class="route().current('cobranza') ? 'bg-[#00a878] text-black' : 'text-gray-400 hover:bg-white/5'"
                    class="flex items-center gap-3 p-3 rounded-xl transition-all font-bold text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                    Cobranza
                </Link>

                <Link :href="route('rutinas')" 
                    :class="route().current('rutinas') ? 'bg-[#00a878] text-black' : 'text-gray-400 hover:bg-white/5'"
                    class="flex items-center gap-3 p-3 rounded-xl transition-all font-bold text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 20h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2z"/><path d="M9 16V8l7 4-7 4z"/></svg>
                    Rutinas
                </Link>

                <Link :href="route('consultas')" 
                    :class="route().current('consultas') ? 'bg-[#00a878] text-black' : 'text-gray-400 hover:bg-white/5'"
                    class="flex items-center gap-3 p-3 rounded-xl transition-all font-bold text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    Consultas
                </Link>

            

                <Link :href="route('clientes.modificar')" 
                    :class="route().current('clientes.modificar') ? 'bg-[#00a878] text-black' : 'text-gray-400 hover:bg-white/5'"
                    class="flex items-center gap-3 p-3 rounded-xl transition-all font-bold text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    Modificar Cliente
                </Link>

                <Link :href="route('reportes.financieros')" 
                    :class="route().current('reportes.financieros') ? 'bg-[#00a878] text-black' : 'text-gray-400 hover:bg-white/5'"
                    class="flex items-center gap-3 p-3 rounded-xl transition-all font-bold text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                    Reportes Financieros
                </Link>

                <Link :href="route('empleados.gestion')" 
                    :class="route().current('empleados.gestion') ? 'bg-[#00a878] text-black' : 'text-gray-400 hover:bg-white/5'"
                    class="flex items-center gap-3 p-3 rounded-xl transition-all font-bold text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    Gestión Empleados
                </Link>

                <Link :href="route('soporte.directorio')" 
                    :class="route().current('soporte.directorio') ? 'bg-[#00a878] text-black' : 'text-gray-400 hover:bg-white/5'"
                    class="flex items-center gap-3 p-3 rounded-xl transition-all font-bold text-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
                    Soporte
                </Link>
            </nav>

            <div class="mt-auto pt-6 border-t border-white/5 space-y-3">
                <div class="flex items-center gap-3 p-3 bg-white/5 rounded-2xl border border-white/5">
                    <div class="w-9 h-9 rounded-full bg-[#00a878] flex items-center justify-center text-black font-black text-xs">AD</div>
                    <div class="flex-1 overflow-hidden">
                        <p class="text-xs font-bold text-white truncate">Administrador</p>
                        <p class="text-[10px] text-gray-500 truncate italic">admin@gym.com</p>
                    </div>
                </div>
                
                <Link :href="route('logout')" method="post" as="button" class="w-full flex items-center gap-3 p-3 rounded-xl text-red-500 hover:bg-red-500/10 transition-all font-bold text-xs uppercase tracking-widest">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    Cerrar Sesión
                </Link>
            </div>
        </aside>

        <main class="flex-1 p-10 overflow-y-auto">
            <slot />
        </main>
    </div>
</template>

<style scoped>
.custom-scrollbar::-webkit-scrollbar {
  width: 4px;
}
.custom-scrollbar::-webkit-scrollbar-track {
  background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
  background: rgba(255, 255, 255, 0.05);
  border-radius: 10px;
}
</style>