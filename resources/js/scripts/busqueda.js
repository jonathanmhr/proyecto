document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.querySelector('#searchInput');
    const searchButton = document.querySelector('#searchButton');

    if (searchInput && searchButton) {
        searchButton.addEventListener('click', function () {
            const query = searchInput.value.trim();
            
            if (query.length >= 3 && query.length <= 8) {
                window.location.href = '/admin/users?search=' + query;
            } else {
                alert('La búsqueda debe tener entre 3 y 8 caracteres.');
            }
        });

        // Para que la búsqueda también se dispare al presionar "Enter"
        searchInput.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                searchButton.click();
            }
        });
    }
});
