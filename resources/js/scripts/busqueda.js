document.addEventListener('DOMContentLoaded', function () {
  const form = document.querySelector('form#searchForm');
  const searchInput = document.querySelector('#searchInput');
  const errorMsg = document.querySelector('#searchError');

  if (form && searchInput && errorMsg) {
    form.addEventListener('submit', function (e) {
      const query = searchInput.value.trim();

      if (query.length > 0 && (query.length < 3 || query.length > 8)) {
        e.preventDefault(); // evitar envío del form
        errorMsg.textContent = 'La búsqueda debe tener entre 3 y 8 caracteres.';
        errorMsg.classList.remove('hidden');
        searchInput.classList.add('border-red-500', 'focus:ring-red-500');
      } else {
        errorMsg.textContent = '';
        errorMsg.classList.add('hidden');
        searchInput.classList.remove('border-red-500', 'focus:ring-red-500');
      }
    });

    // Opcional: ocultar error al escribir
    searchInput.addEventListener('input', () => {
      errorMsg.textContent = '';
      errorMsg.classList.add('hidden');
      searchInput.classList.remove('border-red-500', 'focus:ring-red-500');
    });
  }
});
