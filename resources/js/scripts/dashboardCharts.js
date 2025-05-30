//import ApexCharts from 'apexcharts';

document.addEventListener('DOMContentLoaded', async () => {
    try {
        const response = await fetch('/admin/charts', {
            credentials: 'same-origin' // enviar cookies para mantener sesión
        });

        if (!response.ok) {
            throw new Error('HTTP error, status = ' + response.status);
        }

        const data = await response.json();

        renderUsersChart(data.usersChartData);
        renderSubscriptionsChart(data.subscriptionsChartData);
        renderClassesChart(data.classesChartData);
    } catch (error) {
        console.error('Error cargando los datos del gráfico:', error);
    }
});

function renderUsersChart(chartData) {
    new ApexCharts(document.querySelector("#usersChart"), {
        chart: { type: 'bar', height: 300 },
        series: [{ name: 'Usuarios', data: chartData.series[0] }],
        xaxis: { categories: chartData.labels }
    }).render();
}

function renderSubscriptionsChart(chartData) {
    new ApexCharts(document.querySelector("#subscriptionsChart"), {
        chart: { type: 'line', height: 300 },
        series: chartData.series.map(serie => ({ name: serie.name, data: serie.data })),
        xaxis: { categories: chartData.labels }
    }).render();
}

function renderClassesChart(chartData) {
    new ApexCharts(document.querySelector("#classesChart"), {
        chart: { type: 'area', height: 300 },
        series: [{ name: 'Clases', data: chartData.series[0] }],
        xaxis: { categories: chartData.labels }
    }).render();
}
