function showCreateProjectModal() {
      document.getElementById('createProjectModal').style.display = 'flex';
    }

    function showCreateProjectMemberModal() {
      document.getElementById('createMemberModal').style.display = 'flex';
    }

    function hideCreateProjectModal() {
      document.getElementById('createProjectModal').style.display = 'none';
      document.getElementById('projectForm').reset();
    }

       function hideCreateMemberModal() {
      document.getElementById('createMemberModal').style.display = 'none';
      document.getElementById('memberForm').reset();
    }

    

   

    // Cerrar modal al hacer clic fuera
    document.getElementById('createProjectModal').addEventListener('click', function(e) {
      if (e.target === this) {
        hideCreateProjectModal();
      }
    });

       // Cerrar modal al hacer clic fuera
    document.getElementById('createMemberModal').addEventListener('click', function(e) {
      if (e.target === this) {
        hideCreateMemberModal();
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
