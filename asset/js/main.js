// asset/js/main.js

document.addEventListener('DOMContentLoaded', function() {
    // 1. Filtro de búsqueda de cursos
    const searchInput = document.getElementById('searchCursoInput');
    if (searchInput) {
      searchInput.addEventListener('keyup', function () {
        const filter = this.value.toLowerCase();
        document
          .querySelectorAll('#cursosTable tbody tr')
          .forEach(row => {
            row.style.display = row.textContent.toLowerCase().includes(filter)
              ? ''
              : 'none';
          });
      });
    }
  
    // 2. (Opcional) Si quieres un toggle extra, usa el selector correcto:
    const pushMenuBtn = document.querySelector('[data-lte-toggle="sidebar"]');
    if (pushMenuBtn) {
      pushMenuBtn.addEventListener('click', function() {
        // AdminLTE ya hace la apertura/cierre, pero si quieres animar el body:
        document.body.classList.toggle('sidebar-collapse');
      });
    }
  });
  