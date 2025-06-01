// Opciones base para todos los gráficos para el tema OSCURO
const baseChartOptions = {
    theme: {
        mode: 'dark', // <-- Asegúrate de que es oscuro
        palette: 'palette1' // Puedes experimentar con 'palette1' a 'palette10'
    },
    chart: {
        toolbar: {
            show: true,
            tools: {
                //download: true,
                selection: true,
                zoom: true,
                zoomin: true,
                zoomout: true,
                pan: true,
                reset: true
            },
            autoSelected: 'zoom'
        },
        background: 'transparent', // Fondo transparente para que se vea el bg-gray-800 de la tarjeta
        foreColor: '#E0E0E0' // Color general del texto (ej. ejes, leyendas, tooltips)
    },
    grid: {
        borderColor: '#555555', // Color de las líneas de la cuadrícula
        strokeDashArray: 4,
        xaxis: {
            lines: {
                show: true
            }
        },
        yaxis: {
            lines: {
                show: true
            }
        }
    },
    tooltip: {
        theme: 'dark', // Tema oscuro para los tooltips
        x: {
            show: true,
            format: 'MMMM yyyy', // Asegúrate de que el formato de fecha sea correcto
        }
    },
    xaxis: {
        labels: {
            style: {
                colors: '#E0E0E0' // Color de las etiquetas del eje X
            }
        },
        axisBorder: {
            show: true,
            color: '#555555'
        },
        axisTicks: {
            show: true,
            color: '#555555'
        }
    },
    yaxis: {
        labels: {
            style: {
                colors: '#E0E0E0' // Color de las etiquetas del eje Y
            },
            formatter: function (val) {
                return Math.round(val);
            }
        },
        axisBorder: {
            show: true,
            color: '#555555'
        },
        axisTicks: {
            show: true,
            color: '#555555'
        }
    },
    dataLabels: {
        enabled: false
    },
    legend: {
        labels: {
            colors: '#E0E0E0' // Color del texto de la leyenda
        },
        position: 'top',
        horizontalAlign: 'right',
    },
    stroke: {
        curve: 'smooth',
        width: 3
    }
};

const trainerSeriesColor = ['#FFA500']; // Naranja para mantener la coherencia

let trainerCharts = {};

async function fetchAndRenderTrainerCharts(forceUpdate = false) {
    const CACHE_KEY = 'trainer_dashboard_charts_data';
    let data = null;

    if (!forceUpdate) {
        const cachedData = localStorage.getItem(CACHE_KEY);
        if (cachedData) {
            try {
                const parsedData = JSON.parse(cachedData);
                const CACHE_LIFETIME = 3600000; // 1 hora

                if (parsedData.timestamp && (Date.now() - parsedData.timestamp < CACHE_LIFETIME)) {
                    data = parsedData.data;
                    console.log('Datos de gráficos de entrenador cargados desde caché.');
                } else {
                    console.log('Caché de gráficos de entrenador expirada, obteniendo nuevos datos.');
                    localStorage.removeItem(CACHE_KEY);
                }
            } catch (e) {
                console.warn('Error al parsear datos de caché de entrenador, obteniendo nuevos datos.', e);
                localStorage.removeItem(CACHE_KEY);
            }
        }
    }

    if (!data) {
        try {
            console.log('Obteniendo nuevos datos para gráficos de entrenador...');
            // <--- ¡IMPORTANTE! Esta URL debe coincidir con la ruta de tu nuevo controlador TrainerChartController
            const response = await fetch('/admin-entrenador/charts', {
                credentials: 'same-origin'
            });

            if (!response.ok) {
                throw new Error('HTTP error, status = ' + response.status);
            }

            data = await response.json();
            localStorage.setItem(CACHE_KEY, JSON.stringify({ data: data, timestamp: Date.now() }));
            console.log('Nuevos datos de gráficos de entrenador obtenidos y guardados en caché.');
        } catch (error) {
            console.error('Error cargando los datos del gráfico de entrenador desde la API:', error);
            data = {
                classesChartData: { series: [[]], labels: [] },
                usersChartData: { series: [[]], labels: [] }
            };
        }
    }

    if (typeof ApexCharts === 'undefined') {
        console.error('ApexCharts no está definido. Asegúrate de que la librería está cargada.');
        return;
    }

    for (const key in trainerCharts) {
        if (trainerCharts[key]) {
            trainerCharts[key].destroy();
            trainerCharts[key] = null;
        }
    }

    renderTrainerClassesChart(data.classesChartData);
    renderTrainerUsersChart(data.usersChartData);
}

function renderTrainerClassesChart(chartData) {
    const options = {
        ...baseChartOptions,
        chart: {
            ...baseChartOptions.chart,
            type: 'bar',
            height: 300,
            id: 'trainer-classes-chart'
        },
        series: [{ name: 'Clases Creadas', data: chartData.series[0] }],
        xaxis: { categories: chartData.labels, ...baseChartOptions.xaxis },
        colors: trainerSeriesColor,
    };
    trainerCharts.classesChart = new ApexCharts(document.querySelector("#trainerClassesChart"), options);
    trainerCharts.classesChart.render();
}

function renderTrainerUsersChart(chartData) {
    const options = {
        ...baseChartOptions,
        chart: {
            ...baseChartOptions.chart,
            type: 'line', // O 'area' si prefieres
            height: 300,
            id: 'trainer-users-chart'
        },
        series: [{ name: 'Alumnos Activos', data: chartData.series[0] }], // Asumiendo una única serie
        xaxis: { categories: chartData.labels, ...baseChartOptions.xaxis },
        colors: trainerSeriesColor,
    };
    trainerCharts.usersChart = new ApexCharts(document.querySelector("#trainerUsersChart"), options);
    trainerCharts.usersChart.render();
}

document.addEventListener('DOMContentLoaded', () => {
    fetchAndRenderTrainerCharts();

    const refreshButton = document.getElementById('refreshTrainerCharts');
    if (refreshButton) {
        refreshButton.addEventListener('click', () => {
            console.log('Botón de Actualizar Gráficos de Entrenador clickeado.');
            fetchAndRenderTrainerCharts(true);
        });
    }
});