<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Sistema de Gestión - Login" />

    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gym-dark-bg bg-[radial-gradient(#1a1a1a_1px,transparent_1px)] [background-size:16px_16px]">
        
        <div class="w-full sm:max-w-md mt-6 px-10 py-12 bg-gym-card-bg shadow-xl overflow-hidden sm:rounded-2xl border border-gym-gray-border flex flex-col items-center">
            
            <div class="p-4 rounded-full bg-gym-green/10 border-2 border-gym-green mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-gym-green" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 18h2a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2H6"></path>
                    <path d="M14 18h2a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-2"></path>
                    <path d="M3 12h18"></path>
                    <circle cx="21" cy="12" r="1"></circle>
                    <circle cx="3" cy="12" r="1"></circle>
                </svg>
            </div>

            <h1 class="text-3xl font-extrabold text-white mb-1">Sistema de Gestión</h1>
            <p class="text-lg text-gym-gray-text mb-10 font-medium">Gimnasio</p>

            <form @submit.prevent="submit" class="w-full space-y-6">
                <div>
                    <label for="email" class="block text-sm font-semibold text-gym-gray-text mb-2">Usuario</label>
                    <div class="relative">
                        <input 
                            id="email" 
                            type="text" 
                            v-model="form.email"
                            placeholder="Ingrese su usuario"
                            class="w-full px-5 py-4 bg-gym-input-bg text-white border border-gym-gray-border rounded-xl focus:ring-2 focus:ring-gym-green focus:border-gym-green transition-all duration-150 placeholder:text-gym-gray-text/60"
                            required 
                            autofocus 
                        />
                    </div>
                    <p v-if="form.errors.email" class="mt-2 text-sm text-red-400">{{ form.errors.email }}</p>
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-gym-gray-text mb-2">Contraseña</label>
                    <div class="relative">
                        <input 
                            id="password" 
                            type="password" 
                            v-model="form.password"
                            placeholder="Ingrese su contraseña"
                            class="w-full px-5 py-4 bg-gym-input-bg text-white border border-gym-gray-border rounded-xl focus:ring-2 focus:ring-gym-green focus:border-gym-green transition-all duration-150 placeholder:text-gym-gray-text/60"
                            required 
                        />
                    </div>
                    <p v-if="form.errors.password" class="mt-2 text-sm text-red-400">{{ form.errors.password }}</p>
                </div>

                <div class="pt-2">
                    <button 
                        type="submit" 
                        class="w-full flex justify-center items-center px-6 py-4 bg-gym-green text-white font-bold text-lg rounded-xl hover:bg-gym-green-hover focus:outline-none focus:ring-2 focus:ring-gym-green focus:ring-offset-2 focus:ring-offset-gym-card-bg transition-colors duration-150 disabled:opacity-50"
                        :disabled="form.processing"
                    >
                        <span v-if="form.processing">Ingresando...</span>
                        <span v-else>Ingresar al Sistema</span>
                    </button>
                </div>
            </form>

            <div class="mt-6 text-sm text-gym-gray-text">
                <span>¿No tienes cuenta?</span>
                <Link :href="route('register')" class="ml-2 text-gym-green font-semibold hover:underline">
                    Regístrate
                </Link>
            </div>
        </div>
    </div>
</template>