import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction'; 
import esLocale from '@fullcalendar/core/locales/es';
import Tooltip from 'tooltip.js';
import Swal from 'sweetalert2';

document.addEventListener('DOMContentLoaded', () => {
  const calendarEl = document.getElementById('calendar');
  if (!calendarEl) return;

  const calendar = new Calendar(calendarEl, {
    plugins: [dayGridPlugin, interactionPlugin],
    initialView: 'dayGridMonth',
    locale: esLocale,
    height: 500,
    headerToolbar: {
      left: 'title',
      center: '',
      right: 'prev,next today'
    },

    // Combinas clases, entrenamientos y fases
    events: [
      ...(window.eventosClases || []),
      ...(window.eventosFases || [])
    ],

    eventClassNames: ({ event }) => {
      const tipo = event.extendedProps.tipo;
      if (tipo === 'Clase Grupal') {
        return ['bg-blue-500', 'text-white', 'rounded-lg', 'cursor-pointer', 'shadow-md'];
      }
      if (tipo === 'Entrenamiento') {
        return ['bg-purple-500', 'text-white', 'rounded-lg', 'cursor-pointer', 'shadow-md'];
      }
      if (tipo === 'Fase Entrenamiento') {
        return event.extendedProps.estado === 'completado' 
          ? ['bg-green-600', 'text-white', 'rounded-lg', 'cursor-pointer', 'shadow-md'] 
          : ['bg-yellow-400', 'text-black', 'rounded-lg', 'cursor-pointer', 'shadow-md'];
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

    // Maneja click en eventos
    eventClick: function(info) {
      const event = info.event;
      const tipo = event.extendedProps.tipo;

      if (tipo === 'Fase Entrenamiento') {
        if (event.extendedProps.estado === 'completado') {
          Swal.fire('Fase completada', 'Ya has completado esta fase.', 'success');
          return;
        }

        Swal.fire({
          title: `¿Marcar fase "${event.title}" como completada?`,
          icon: 'question',
          showCancelButton: true,
          confirmButtonText: 'Sí, marcar completada',
          cancelButtonText: 'Cancelar'
        }).then((result) => {
          if (result.isConfirmed) {
            fetch(`/cliente/entrenamientos/fases-dias/${event.id}`, {
              method: 'PATCH',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': window.csrfToken,
                'Accept': 'application/json',
              },
              body: JSON.stringify({ estado: 'completado' }),
            })
            .then(res => {
              if (!res.ok) throw new Error('Error al actualizar');
              return res.json();
            })
            .then(data => {
              Swal.fire('¡Perfecto!', 'Fase marcada como completada.', 'success');
              event.setExtendedProp('estado', 'completado');
              info.view.calendar.refetchEvents();
            })
            .catch(() => {
              Swal.fire('Error', 'No se pudo actualizar la fase.', 'error');
            });
          }
        });
      } else {
        // Mostrar lista eventos por fecha (como tenías)
        const date = event.startStr;
        const eventos = info.view.calendar.getEvents().filter(e => e.startStr === date);
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
          customClass: { popup: 'text-gray-800 dark:text-gray-100' }
        });
      }
    },

  });

  calendar.render();
});
