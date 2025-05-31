// resources/js/dashboardcharts.js

// Importa ApexCharts. Vite se encargará de incluirlo en el bundle final de app.js.
import ApexCharts from 'apexcharts';

// Opciones base para todos los gráficos para el tema oscuro
const baseChartOptions = {
    theme: {
        mode: 'dark', // Establece el tema oscuro
        palette: 'palette1' // Puedes experimentar con 'palette1' a 'palette10' para diferentes combinaciones de colores
    },
    chart: {
        toolbar: {
            show: true, // Mostrar la barra de herramientas (zoom, descarga, etc.)
            tools: {
                //download: true, // Habilitar descarga
                selection: true,
                zoom: true,
                zoomin: true,
                zoomout: true,
                pan: true,
                reset: true // Habilitar resetear zoom
            },
            autoSelected: 'zoom' // Herramienta seleccionada por defecto
        },
        background: 'transparent', // Fondo transparente para que se vea el bg-gray-700 de la tarjeta
        foreColor: '#E0E0E0' // Color general del texto (ej. ejes, leyendas, tooltips)
    },
    grid: {
        borderColor: '#555555', // Color de las líneas de la cuadrícula
        strokeDashArray: 4, // Para que las líneas de la cuadrícula sean punteadas
        xaxis: {
            lines: {
                show: true // Mostrar líneas verticales de la cuadrícula
            }
        },
        yaxis: {
            lines: {
                show: true // Mostrar líneas horizontales de la cuadrícula
            }
        }
    },
    tooltip: {
        theme: 'dark', // Tema oscuro para los tooltips
        x: {
            show: true,
            format: 'MMMM yyyy', // Formato de fecha en el tooltip del eje X
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
            color: '#555555' // Color del borde del eje X
        },
        axisTicks: {
            show: true,
            color: '#555555' // Color de los ticks del eje X
        }
    },
    yaxis: {
        labels: {
            style: {
                colors: '#E0E0E0' // Color de las etiquetas del eje Y
            },
            formatter: function (val) {
                return Math.round(val); // Formatear valores del eje Y a enteros
            }
        },
        axisBorder: {
            show: true,
            color: '#555555' // Color del borde del eje Y
        },
        axisTicks: {
            show: true,
            color: '#555555' // Color de los ticks del eje Y
        }
    },
    dataLabels: {
        enabled: false // Desactivar los dataLabels por defecto para evitar ruido
    },
    legend: {
        labels: {
            colors: '#E0E0E0' // Color del texto de la leyenda
        },
        position: 'top', // Posición de la leyenda
        horizontalAlign: 'right', // Alineación horizontal de la leyenda
    },
    stroke: {
        curve: 'smooth', // Hace las líneas más suaves en los gráficos de línea/área
        width: 3 // Grosor de las líneas
    }
};

// **1. Mismo color para las 3 gráficas (excepto suscripciones si queremos distinguir)**
// Usaremos un color naranja oscuro para la mayoría de las series para que coincida con el tema de la marca.
const commonSeriesColor = ['#FFA500']; // Un naranja vibrante y adecuado para tema oscuro

// Objeto para almacenar las instancias de los gráficos, permitiendo su destrucción y recreación
let charts = {};

/**
 * Fetches chart data from the API (or cache) and renders the charts.
 * @param {boolean} forceUpdate - If true, bypasses cache and fetches new data from the API.
 */
async function fetchAndRenderCharts(forceUpdate = false) {
    const CACHE_KEY = 'dashboard_charts_data';
    let data = null;

    if (!forceUpdate) {
        // Intentar cargar desde localStorage
        const cachedData = localStorage.getItem(CACHE_KEY);
        if (cachedData) {
            try {
                const parsedData = JSON.parse(cachedData);
                const CACHE_LIFETIME = 3600000; // 1 hora en milisegundos

                // Si la caché no ha expirado, usar los datos cacheados
                if (parsedData.timestamp && (Date.now() - parsedData.timestamp < CACHE_LIFETIME)) {
                    data = parsedData.data;
                    console.log('Datos de gráficos cargados desde caché.');
                } else {
                    console.log('Caché de gráficos expirada, obteniendo nuevos datos.');
                    localStorage.removeItem(CACHE_KEY); // Limpiar caché expirada
                }
            } catch (e) {
                console.warn('Error al parsear datos de caché, obteniendo nuevos datos.', e);
                localStorage.removeItem(CACHE_KEY); // Limpiar caché corrupta
            }
        }
    }

    // Si no hay datos (no había caché válida o se forzó la actualización), obtenerlos de la API
    if (!data) {
        try {
            console.log('Obteniendo nuevos datos para gráficos...');
            // La URL de la API es '/admin/charts'
            const response = await fetch('/admin/charts', {
                credentials: 'same-origin' // Enviar cookies para mantener sesión
            });

            if (!response.ok) {
                throw new Error('HTTP error, status = ' + response.status);
            }

            data = await response.json();
            // Guardar en localStorage con un timestamp
            localStorage.setItem(CACHE_KEY, JSON.stringify({ data: data, timestamp: Date.now() }));
            console.log('Nuevos datos de gráficos obtenidos y guardados en caché.');
        } catch (error) {
            console.error('Error cargando los datos del gráfico desde la API:', error);
            // Proporcionar datos vacíos para evitar errores de renderizado si la API falla
            data = {
                usersChartData: { series: [[]], labels: [] },
                subscriptionsChartData: { series: [], labels: [] },
                classesChartData: { series: [[]], labels: [] }
            };
        }
    }

    // Verificar si ApexCharts está disponible. Es crucial si no se importa globalmente de otra forma.
    if (typeof ApexCharts === 'undefined') {
        console.error('ApexCharts no está definido. Asegúrate de que la librería está cargada.');
        return;
    }

    // *** DESTRUIR GRÁFICOS EXISTENTES ANTES DE RENDERIZAR LOS NUEVOS ***
    // Esto evita problemas de duplicación o superposición de gráficos.
    for (const key in charts) {
        if (charts[key]) {
            charts[key].destroy(); // Llama al método destroy() de ApexCharts
            charts[key] = null; // Libera la referencia para que pueda ser recolectada por el garbage collector
        }
    }

    // Renderizar los gráficos con los datos (ya sean de caché o de la API)
    renderUsersChart(data.usersChartData);
    renderSubscriptionsChart(data.subscriptionsChartData);
    renderClassesChart(data.classesChartData);
}

/**
 * Renders the Users Chart.
 * @param {object} chartData - Data for the users chart.
 */
function renderUsersChart(chartData) {
    const options = {
        ...baseChartOptions, // Hereda todas las opciones base
        chart: {
            ...baseChartOptions.chart, // Hereda las opciones de chart y luego las sobrescribe
            type: 'bar',
            height: 300,
            id: 'users-chart' // Añadir un ID al gráfico de ApexCharts
        },
        series: [{ name: 'Usuarios', data: chartData.series[0] }],
        xaxis: { categories: chartData.labels, ...baseChartOptions.xaxis },
        colors: commonSeriesColor, // Usando el color común
    };
    // Crea una nueva instancia de ApexCharts y la guarda en el objeto `charts`
    charts.usersChart = new ApexCharts(document.querySelector("#usersChart"), options);
    charts.usersChart.render();
}

/**
 * Renders the Subscriptions Chart.
 * @param {object} chartData - Data for the subscriptions chart.
 */
function renderSubscriptionsChart(chartData) {
    const options = {
        ...baseChartOptions,
        chart: {
            ...baseChartOptions.chart,
            type: 'line',
            height: 300,
            id: 'subscriptions-chart' // Añadir un ID al gráfico de ApexCharts
        },
        // Asegurarse de que chartData.series sea un array válido, incluso si está vacío
        series: chartData.series && chartData.series.length > 0
            ? chartData.series.map(serie => ({ name: serie.name, data: serie.data }))
            : [{ name: 'Altas', data: [] }, { name: 'Bajas', data: [] }], // Proporcionar series por defecto
        xaxis: { categories: chartData.labels, ...baseChartOptions.xaxis },
        // Usar colores específicos para Altas/Bajas para una mejor distinción visual
        colors: ['#4CAF50', '#F44336'], // Verde para altas, Rojo para bajas
    };
    charts.subscriptionsChart = new ApexCharts(document.querySelector("#subscriptionsChart"), options);
    charts.subscriptionsChart.render();
}

/**
 * Renders the Classes Chart.
 * @param {object} chartData - Data for the classes chart.
 */
function renderClassesChart(chartData) {
    const options = {
        ...baseChartOptions,
        chart: {
            ...baseChartOptions.chart,
            type: 'area',
            height: 300,
            id: 'classes-chart' // Añadir un ID al gráfico de ApexCharts
        },
        series: [{ name: 'Clases', data: chartData.series[0] }],
        xaxis: { categories: chartData.labels, ...baseChartOptions.xaxis },
        colors: commonSeriesColor, // Usando el color común
    };
    charts.classesChart = new ApexCharts(document.querySelector("#classesChart"), options);
    charts.classesChart.render();
}

// Listener principal que se ejecuta cuando el DOM está completamente cargado
document.addEventListener('DOMContentLoaded', () => {
    // 1. Cargar los gráficos al iniciar la página
    // Intentará cargar desde localStorage primero, luego de la API si la caché no es válida.
    fetchAndRenderCharts();

    // 2. Configurar el listener para el botón de actualizar gráficos
    const refreshButton = document.getElementById('refreshCharts');
    if (refreshButton) {
        refreshButton.addEventListener('click', () => {
            console.log('Botón de Actualizar Gráficos clickeado.');
            fetchAndRenderCharts(true); // Llama a la función forzando la actualización (bypassing cache)
            // Opcional: Si los iconos de Feather se añaden dinámicamente y cambian, re-inicializarlos
            feather.replace();
        });
    }
});