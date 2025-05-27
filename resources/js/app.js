import './bootstrap';
import '../css/app.css';
import './scripts/busqueda.js';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

document.addEventListener('DOMContentLoaded', () => {
    Alpine.start();

    // feather está disponible globalmente por el CDN
    if (window.feather) {
        window.feather.replace();
    }
});
