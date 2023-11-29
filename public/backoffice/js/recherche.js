document.addEventListener('DOMContentLoaded', function() {
    var searchInput = document.getElementById('search-input');
  
    searchInput.addEventListener('input', function() {
      var searchValue = searchInput.value;
  
      var xhr = new XMLHttpRequest();
      xhr.open('POST', '/location_vehicule/search');
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xhr.responseType = 'json';
  
      xhr.onload = function() {
        if (xhr.status === 200) {
          var response = xhr.response;
          // Traiter les résultats de recherche
          // Mettre à jour la table ou afficher les résultats d'une autre manière
          console.log(response);
        } else {
          console.error('Erreur lors de la requête Ajax. Statut : ' + xhr.status);
        }
      };
  
      xhr.onerror = function() {
        console.error('Erreur lors de la requête Ajax.');
      };
  
      xhr.send('search=' + encodeURIComponent(searchValue));
    });
  });