function initApexCharts(usersData, subscriptionsData, classesData) {

    // Asegúrate de que ApexCharts esté disponible globalmente (lo hacemos en app.js)
    if (typeof ApexCharts === 'undefined') {
        console.error('ApexCharts no está definido. Asegúrate de importarlo en app.js y recompilar.');
        return;
    }

    // --- 1. CONFIGURACIÓN DEL GRÁFICO DE USUARIOS ---
    var usersOptions = {
        chart: {
            type: 'bar',
            height: 350,
            toolbar: { show: false }
        },
        series: [{
            name: 'Altas de Usuarios',
            data: usersData.series[0] // Usamos los datos pasados como argumento
        }],
        xaxis: {
            categories: usersData.labels, // Usamos las etiquetas pasadas como argumento
            title: { text: 'Meses' }
        },
        yaxis: { title: { text: 'Número de Usuarios' } },
        title: { text: 'Altas de Usuarios por Mes', align: 'left' },
        tooltip: { y: { formatter: function (val) { return val + " usuarios"; } } },
        colors: ['#007bff']
    };
    var usersChart = new ApexCharts(document.querySelector("#usersChart"), usersOptions);
    usersChart.render();

    // --- 2. CONFIGURACIÓN DEL GRÁFICO DE SUSCRIPCIONES ---
    var subscriptionsOptions = {
        chart: {
            type: 'line',
            height: 350,
            toolbar: { show: true }
        },
        series: subscriptionsData.series, // Usamos los datos pasados como argumento
        xaxis: {
            categories: subscriptionsData.labels,
            title: { text: 'Meses' }
        },
        yaxis: { title: { text: 'Número de Suscripciones' } },
        title: { text: 'Altas y Bajas de Suscripciones por Mes', align: 'left' },
        stroke: { curve: 'smooth', width: 3 },
        markers: { size: 5 },
        tooltip: { y: { formatter: function (val) { return val + " suscripciones"; } } },
        colors: ['#28a745', '#dc3545']
    };
    var subscriptionsChart = new ApexCharts(document.querySelector("#subscriptionsChart"), subscriptionsOptions);
    subscriptionsChart.render();

    // --- 3. CONFIGURACIÓN DEL GRÁFICO DE CLASES ---
    var classesOptions = {
        chart: {
            type: 'area',
            height: 350,
            toolbar: { show: false }
        },
        series: [{
            name: 'Clases Creadas',
            data: classesData.series[0] // Usamos los datos pasados como argumento
        }],
        xaxis: {
            categories: classesData.labels,
            title: { text: 'Meses' }
        },
        yaxis: { title: { text: 'Número de Clases' } },
        title: { text: 'Creación de Clases por Mes', align: 'left' },
        stroke: { curve: 'smooth', width: 3 },
        tooltip: { y: { formatter: function (val) { return val + " clases"; } } },
        colors: ['#ffc107']
    };
    var classesChart = new ApexCharts(document.querySelector("#classesChart"), classesOptions);
    classesChart.render();
}

// Exporta la función para que pueda ser llamada desde app.js o directamente en la vista
window.initApexCharts = initApexCharts;