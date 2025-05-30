import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import esLocale from '@fullcalendar/core/locales/es';
import Tooltip from 'tooltip.js';

document.addEventListener('DOMContentLoaded', () => {
    // === FullCalendar Initialization ===
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
            eventClassNames: ({ event }) => {
                const tipo = event.extendedProps.tipo;
                if (tipo === 'Clase Grupal') {
                    return ['bg-blue-500', 'text-white', 'rounded-lg', 'cursor-pointer', 'shadow-md'];
                }
                if (tipo === 'Entrenamiento') {
                    return ['bg-purple-500', 'text-white', 'rounded-lg', 'cursor-pointer', 'shadow-md'];
                }
                return ['bg-gray-600', 'text-white', 'rounded-lg', 'cursor-pointer', 'shadow-md'];
            },
            eventDidMount: ({ el, event }) => {
                if (event.extendedProps.description) {
                    new Tooltip(el, {
                        title: event.extendedProps.description,
                        placement: 'top',
                        trigger: 'hover',
                        offset: '0, 10',
                        container: 'body',
                    });
                }
            },
            dayMaxEvents: true
        });

        calendar.render();
    }
});