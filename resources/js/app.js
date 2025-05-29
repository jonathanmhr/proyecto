import './bootstrap';
import '../css/app.css';
import './scripts/busqueda.js';
import './scripts/charts.js';

import Alpine from 'alpinejs';
import ApexCharts from 'apexcharts';

window.Alpine = Alpine;
window.ApexCharts = ApexCharts;

document.addEventListener('DOMContentLoaded', () => {
    Alpine.start();

    if (window.feather) {
        window.feather.replace();
    }
});