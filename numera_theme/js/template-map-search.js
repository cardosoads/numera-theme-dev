document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-map');
    const mapsList = document.getElementById('mapas-list');

    searchInput.addEventListener('input', function() {
        const searchTerm = searchInput.value;

        // Faz a requisição AJAX para buscar mapas e placas
        fetch(`${window.location.origin}/wp-admin/admin-ajax.php?action=search_mapas&s=searchTerm`)
            .then(response => response.text())
            .then(data => {
                mapsList.innerHTML = data;
            })
            .catch(error => console.error('Erro ao buscar mapas:', error));
    });
});