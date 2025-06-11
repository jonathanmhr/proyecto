import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction'; 
import esLocale from '@fullcalendar/core/locales/es';
import Swal from 'sweetalert2';
import '../../css/calendario.css';

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

    // Eventos combinados
    events: [
      ...(window.eventosClases || []),
      ...(window.eventosFases || [])
    ],

    // Clases CSS para eventos según tipo y estado
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

    // NO mostrar tooltip ni efecto hover

    dayMaxEvents: true,

    eventClick: function(info) {
      const event = info.event;

      // Construir contenido modal
      const titulo = event.title || 'Sin título';
      const descripcion = event.extendedProps.description || 'Sin descripción';
      const tipo = event.extendedProps.tipo || 'Tipo desconocido';
      const estado = event.extendedProps.estado || 'Estado no definido';

      // Si es fase entrenamiento y no completada, ofrezco marcar completada
      if (tipo === 'Fase Entrenamiento' && estado !== 'completado') {
        Swal.fire({
          title: titulo,
          html: `
            <p><strong>Descripción:</strong> ${descripcion}</p>
            <p><strong>Tipo:</strong> ${tipo}</p>
            <p><strong>Estado:</strong> ${estado}</p>
            <hr>
            <p>¿Marcar esta fase como completada?</p>
          `,
          icon: 'question',
          showCancelButton: true,
          confirmButtonText: 'Sí, marcar completada',
          cancelButtonText: 'Cancelar',
          customClass: { popup: 'text-left' }
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
            .then(() => {
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
        // Solo mostrar info básica en modal sin acciones
        Swal.fire({
          title: titulo,
          html: `
            <p><strong>Descripción:</strong> ${descripcion}</p>
            <p><strong>Tipo:</strong> ${tipo}</p>
            <p><strong>Estado:</strong> ${estado}</p>
          `,
          icon: 'info',
          confirmButtonText: 'Cerrar',
          customClass: { popup: 'text-left' }
        });
      }
    },

  });
  

  calendar.render();
});
