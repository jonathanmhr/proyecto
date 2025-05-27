import './bootstrap';
import '../css/app.css';
import './scripts/busqueda.js';
import Alpine from 'alpinejs';
import feather from 'feather-icons';

window.Alpine = Alpine;

document.addEventListener('DOMContentLoaded', () => {
    Alpine.start();
    feather.replace();
});
