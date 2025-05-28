import './bootstrap';
import '../css/app.css';
import './scripts/busqueda.js';

import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import esLocale from '@fullcalendar/core/locales/es';
import Tooltip from 'tooltip.js';

<<<<<<< Updated upstream
// OpenLayers imports
=======
// Importar OpenLayers
>>>>>>> Stashed changes
import 'ol/ol.css';
import Map from 'ol/Map';
import View from 'ol/View';
import TileLayer from 'ol/layer/Tile';
import OSM from 'ol/source/OSM';
import { fromLonLat } from 'ol/proj';
import Feature from 'ol/Feature';
import Point from 'ol/geom/Point';
import VectorLayer from 'ol/layer/Vector';
import VectorSource from 'ol/source/Vector';
import Style from 'ol/style/Style';
import Icon from 'ol/style/Icon';

<<<<<<< Updated upstream
document.addEventListener('DOMContentLoaded', () => {
    // === FullCalendar Initialization ===
=======
document.addEventListener('DOMContentLoaded', function () {
    // Calendario (igual que antes)
>>>>>>> Stashed changes
    const calendarEl = document.getElementById('calendar');
    if (calendarEl) {
        const calendar = new Calendar(calendarEl, {
            plugins: [dayGridPlugin],
            initialView: 'dayGridMonth',
            locale: esLocale,
            height: 500,
            headerToolbar: {
                left: 'title',
                center: '',
                right: 'prev,next today'
            },
            events: window.eventosClases || [],
<<<<<<< Updated upstream
            eventClassNames: ({ event }) => {
                const tipo = event.extendedProps.tipo;
                if (tipo === 'Clase Grupal') {
                    return ['bg-blue-500', 'text-white', 'rounded-lg', 'cursor-pointer', 'shadow-md'];
                }
                if (tipo === 'Entrenamiento') {
=======
            eventClassNames: function(arg) {
                if (arg.event.extendedProps.tipo === 'Clase Grupal') {
                    return ['bg-blue-500', 'text-white', 'rounded-lg', 'cursor-pointer', 'shadow-md'];
                }
                if (arg.event.extendedProps.tipo === 'Entrenamiento') {
>>>>>>> Stashed changes
                    return ['bg-purple-500', 'text-white', 'rounded-lg', 'cursor-pointer', 'shadow-md'];
                }
                return ['bg-gray-600', 'text-white', 'rounded-lg', 'cursor-pointer', 'shadow-md'];
            },
<<<<<<< Updated upstream
            eventDidMount: ({ el, event }) => {
                if (event.extendedProps.description) {
                    new Tooltip(el, {
                        title: event.extendedProps.description,
=======
            eventDidMount: function(info) {
                if (info.event.extendedProps.description) {
                    new Tooltip(info.el, {
                        title: info.event.extendedProps.description,
>>>>>>> Stashed changes
                        placement: 'top',
                        trigger: 'hover',
                        offset: '0, 10',
                        container: 'body',
                    });
                }
            },
            dayMaxEvents: true
        });
<<<<<<< Updated upstream

        calendar.render();
    }

    // === OpenLayers Map Initialization ===
    const mapContainer = document.getElementById('map');
    if (mapContainer) {
        const madridCoords = fromLonLat([-3.7038, 40.4168]);

=======
        calendar.render();
    }

    // Inicializar mapa OpenLayers solo si existe el div
    const mapContainer = document.getElementById('map');
    if (mapContainer) {
        // Coordenadas Madrid (longitud, latitud)
        const madridCoords = fromLonLat([-3.7038, 40.4168]);

        // Crear marcador
>>>>>>> Stashed changes
        const marker = new Feature({
            geometry: new Point(madridCoords),
        });

        marker.setStyle(new Style({
            image: new Icon({
                anchor: [0.5, 1],
                src: 'https://cdn-icons-png.flaticon.com/512/684/684908.png',
                scale: 0.05,
            }),
        }));

<<<<<<< Updated upstream
=======
        // Vector con el marcador
>>>>>>> Stashed changes
        const vectorSource = new VectorSource({
            features: [marker],
        });

        const vectorLayer = new VectorLayer({
            source: vectorSource,
        });

<<<<<<< Updated upstream
        new Map({
            target: 'map',
            layers: [
                new TileLayer({ source: new OSM() }),
=======
        // Crear mapa
        const map = new Map({
            target: 'map',
            layers: [
                new TileLayer({
                    source: new OSM(),
                }),
>>>>>>> Stashed changes
                vectorLayer
            ],
            view: new View({
                center: madridCoords,
                zoom: 13,
            }),
        });
    }
});
