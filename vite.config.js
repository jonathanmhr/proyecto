import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        host: true, // Esto permite conexiones externas
        hmr: {
            host: '192.168.1.22', // Cambia esto a tu dirección IP si es necesario
        }
    },
    plugins: [
        laravel([
            'resources/css/app.css',
            'resources/js/app.js',
        ]),
    ],
});