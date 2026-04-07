import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue', 
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                
                'gym-dark-bg': '#121212', 
                'gym-card-bg': '#1e1e1e', 
                'gym-input-bg': '#2a2a2a', 
                'gym-green': {
                    'DEFAULT': '#00a878', 
                    'hover': '#00c18c',   
                    'light': '#e6fdf5',   
                },
                'gym-gray': {
                    'text': '#a0a0a0',    
                    'border': '#333333',  
                }
            },
        },
    },

    plugins: [forms],
};