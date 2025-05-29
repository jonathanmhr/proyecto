import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        host: true, // Esto permite conexiones externas
        cors: true,
        hmr: {
            host: '127.0.0.1', // Cambia esto a tu dirección IP si es necesario
        }
    },
    plugins: [
        laravel([
            'resources/css/app.css',
            'resources/js/app.js',
        ]),
    ],
});