import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';
import colors from 'tailwindcss/colors';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Extiende la paleta completa de rojos
                red: {
                    ...colors.red,      // tonos 50–900 predeterminados
                    950: '#450a0a',     // opcional: tono extra oscuro
                },
                // Igual para amarillo y naranja si vas a usar gradientes mixtos
                yellow: { ...colors.yellow },
                orange: { ...colors.orange },
                
            },
            animation: {
                'fade-in': 'fadeIn 0.5s ease-out forwards',
            },
            keyframes: {
                fadeIn: {
                    '0%': { opacity: 0, transform: 'translateY(0.5rem)' },
                    '100%': { opacity: 1, transform: 'translateY(0)' },
                },
            },
        },
    },

    plugins: [forms, typography],
};
