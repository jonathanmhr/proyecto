// resources/js/scripts/fullcalendar.js

import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction'; // Necesario para 'eventClick', 'selectable', etc.
import esLocale from '@fullcalendar/core/locales/es'; // Importamos el locale español

/**
 * Inicializa un FullCalendar en un elemento específico con eventos.
 * @param {string} elementId - El ID del elemento HTML donde se renderizará el calendario.
 * @param {Array} eventsData - Un array de objetos de evento para el calendario.
 */
window.initFullCalendar = function(elementId, eventsData = []) {
    const calendarEl = document.getElementById(elementId);

    if (!calendarEl) {
        console.error(`FullCalendar: Elemento con ID "${elementId}" no encontrado.`);
        return;
    }

    const calendar = new Calendar(calendarEl, {
        // 1. Plugins que vamos a usar
        plugins: [dayGridPlugin, interactionPlugin],

        // 2. Vista inicial y configuración del encabezado
        initialView: 'dayGridMonth', // Muestra el mes por defecto
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay' // Vistas disponibles
        },

        // 3. Eventos del calendario
        events: eventsData, // Los eventos se pasarán como argumento a esta función

        // 4. Configuración de interactividad (si tienes el interactionPlugin)
        selectable: true, // Permite seleccionar rangos de fechas
        editable: true,   // Permite arrastrar y redimensionar eventos existentes

        // 5. Configuración de idioma y fecha/hora
        locale: esLocale, // Aplica el idioma español
        firstDay: 1,      // Lunes como primer día de la semana
        weekends: true,   // Muestra fines de semana

        // 6. Callbacks para interactividad (lo que lo hace 'clicable')
        // Cuando se hace clic en un evento
        eventClick: function(info) {
            // info.event es el objeto Evento de FullCalendar
            alert(`Evento: ${info.event.title}\nDescripción: ${info.event.extendedProps.description || 'Sin descripción'}\nDesde: ${info.event.startStr}`);
            // Puedes abrir un modal, redirigir, etc.
        },
        // Cuando se selecciona un rango de fechas
        select: function(info) {
            const title = prompt('Introduce el título del nuevo evento:');
            if (title) {
                calendar.addEvent({
                    title: title,
                    start: info.startStr,
                    end: info.endStr,
                    allDay: info.allDay
                });
                // Aquí deberías enviar el evento a tu backend para guardarlo en la base de datos
                console.log('Nuevo evento añadido:', { title, start: info.startStr, end: info.endStr, allDay: info.allDay });
            }
            calendar.unselect(); // Deselecciona el rango
        },
        // Cuando un evento es arrastrado a otra fecha/hora
        eventDrop: function(info) {
            console.log('Evento movido:', info.event.title, 'a', info.event.startStr);
            // Aquí deberías enviar la actualización a tu backend
        },
        // Cuando un evento es redimensionado
        eventResize: function(info) {
            console.log('Evento redimensionado:', info.event.title, 'de', info.event.startStr, 'a', info.event.endStr);
            // Aquí deberías enviar la actualización a tu backend
        }
    });

    calendar.render();
    console.log(`FullCalendar inicializado en "${elementId}" con ${eventsData.length} eventos.`);
};