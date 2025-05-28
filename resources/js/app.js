// resources/js/app.js

import './bootstrap';
import '../css/app.css';
import './scripts/busqueda.js';
import './scripts/charts.js'; // Mantén o elimina si no los necesitas ahora
import './scripts/fullcalendar.js'; // <-- ¡Añade esta línea!

import Alpine from 'alpinejs';
import ApexCharts from 'apexcharts'; // Mantén o elimina si no los necesitas ahora

window.Alpine = Alpine;
window.ApexCharts = ApexCharts; // Mantén o elimina si no los necesitas ahora

document.addEventListener('DOMContentLoaded', () => {
    Alpine.start();

    if (window.feather) {
        window.feather.replace();
    }
});