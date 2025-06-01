import './bootstrap';
import '../css/app.css';
import './scripts/busqueda.js';
import './scripts/dashboardCharts.js';
import './scripts/calendario.js';
import './scripts/mapa.js';
import './scripts/trainercharts.js';

import Alpine from 'alpinejs';
import ApexCharts from 'apexcharts';


window.Alpine = Alpine;
window.ApexCharts = ApexCharts;

document.addEventListener('DOMContentLoaded', () => {
    if (window.feather) {
        window.feather.replace();
    }
});