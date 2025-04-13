import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    server: {
        host: '0.0.0.0', // Escucha en todas las interfaces
        port: 5173,
        strictPort: true,
        origin: 'http://192.168.1.34:5173', // <- IMPORTANTE para que use la IP correcta
        cors: true, // <- PERMITIR CORS
        hmr: {
            protocol: 'ws',
            host: '192.168.1.34',
            port: 5173,
        },
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
