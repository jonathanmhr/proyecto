// resources/js/app.js
import './bootstrap';
import Alpine from 'alpinejs';
import ApexCharts from 'apexcharts';

window.Alpine = Alpine;
window.ApexCharts = ApexCharts;

document.addEventListener('DOMContentLoaded', () => {
    if (window.feather) {
        window.feather.replace();
    }
});

Alpine.start();
