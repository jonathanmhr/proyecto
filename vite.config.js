import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        port: 5173, // Asegúrate de que el puerto es el correcto
        proxy: {
            '/': 'http://localhost', // Redirige todas las solicitudes a Laravel
        },
    },
});
