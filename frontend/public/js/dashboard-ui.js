function showCreateProjectModal() {
      document.getElementById('createProjectModal').style.display = 'flex';
    }

    function hideCreateProjectModal() {
      document.getElementById('createProjectModal').style.display = 'none';
      document.getElementById('projectForm').reset();
    }

    function showInviteModal() {
      alert('Función de invitar miembros próximamente disponible');
    }

    // Cerrar modal al hacer clic fuera
    document.getElementById('createProjectModal').addEventListener('click', function(e) {
      if (e.target === this) {
        hideCreateProjectModal();
      }
    });

    // Función para buscar proyectos
    document.getElementById('searchInput').addEventListener('input', function(e) {
      const searchTerm = e.target.value.toLowerCase();
      const projectCards = document.querySelectorAll('.project-card');
      
      projectCards.forEach(card => {
        const title = card.querySelector('.project-title').textContent.toLowerCase();
        const description = card.querySelector('.project-description').textContent.toLowerCase();
        
        if (title.includes(searchTerm) || description.includes(searchTerm)) {
          card.style.display = 'block';
        } else {
          card.style.display = 'none';
        }
      });
    });
