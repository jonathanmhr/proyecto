import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction'; // IMPORTANTE
import esLocale from '@fullcalendar/core/locales/es';
import Tooltip from 'tooltip.js';
import Swal from 'sweetalert2';

document.addEventListener('DOMContentLoaded', () => {
    const calendarEl = document.getElementById('calendar');
    if (calendarEl) {
        const calendar = new Calendar(calendarEl, {
            plugins: [dayGridPlugin, interactionPlugin],  // <--- incluir interactionPlugin aquí
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

            dayMaxEvents: true,

            // Esto funcionará si interactionPlugin está incluido
            dateClick: function(info) {
                const date = info.dateStr;
                const eventos = calendar.getEvents().filter(event => event.startStr === date);

                if (eventos.length === 0) {
                    Swal.fire('Sin eventos', 'No tienes clases ni entrenamientos este día.', 'info');
                    return;
                }

                const detallesHtml = eventos.map(e => `
                    <li class="mb-1">
                        <strong>${e.title}</strong><br>
                        <span class="text-sm text-gray-500">${e.extendedProps.tipo}</span>
                    </li>
                `).join('');

                Swal.fire({
                    title: `Eventos del ${date}`,
                    html: `<ul class="text-left list-disc pl-5">${detallesHtml}</ul>`,
                    icon: 'info',
                    confirmButtonText: 'Cerrar',
                    customClass: {
                        popup: 'text-gray-800 dark:text-gray-100',
                    }
                });
            }
        });

        calendar.render();
    }
});
