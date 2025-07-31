const slug = new URLSearchParams(window.location.search).get('slug');
console.log("Slug recibido:", slug);

if (!slug) {
  alert("Falta el slug del dashboard");
  location.href = "blank.html";
}

// Función para eliminar dashboard
function eliminarDashboard() {
  if (!confirm("¿Estás seguro de que quieres eliminar este dashboard? Esta acción no se puede deshacer.")) {
    return;
  }

  const formData = new FormData();
  formData.append('slug', slug);

  fetch('../api/delete_dashboard.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      alert(data.message);
      window.location.href = 'blank.html';
    } else {
      alert('Error: ' + data.message);
    }
  })
  .catch(error => {
    console.error('Error:', error);
    alert('Error al eliminar el dashboard');
  });
}

// Cargar datos del dashboard y sus proyectos
console.log('Iniciando carga del dashboard...');
fetch(`../api/get_dashboard.php?slug=${slug}`)
  .then(res => {
    console.log('Respuesta del servidor:', res);
    if (!res.ok) {
      throw new Error(`HTTP error! status: ${res.status}`);
    }
    return res.json();
  })
  .then(data => {
    console.log('Datos del dashboard:', data);
    
    if (!data.success || !data.dashboard) {
      alert('Dashboard no encontrado');
      window.location.href = 'blank.html';
      return;
    }
    
    const dashboard = data.dashboard;
    
    document.getElementById('dashboardTitle').textContent = dashboard.title;
    document.getElementById('dashboardDescription').textContent = dashboard.description;
    
    // Actualizar el color del punto basado en el color del dashboard
    const dotElement = document.querySelector('.dashboard-title-section .dot');
    if (dotElement && dashboard.color) {
      dotElement.className = `dot ${dashboard.color}`;
    }
    
    const list = document.getElementById('projectList');
    
    if (data.dashboard.projects && data.dashboard.projects.length > 0) {
      // Calcular estadísticas
      const totalProjects = data.dashboard.projects.length;
      const inProgressProjects = data.dashboard.projects.filter(p => p.status === 'in_progress').length;
      const completedProjects = data.dashboard.projects.filter(p => p.status === 'completed').length;
      const totalMembers = 3; // Por ahora hardcodeado
      
      // Actualizar estadísticas
      document.getElementById('totalProjects').textContent = totalProjects;
      document.getElementById('activeProjects').textContent = inProgressProjects;
      document.getElementById('completedProjects').textContent = completedProjects;
      document.getElementById('totalMembers').textContent = totalMembers;
      
      // Generar tarjetas de proyectos con progreso
      const projectCards = data.dashboard.projects.map(project => {
        const status = project.status || 'in_progress';
        let statusClass = 'status-in-progress';
        let statusText = 'En Progreso';
        
        if (status === 'completed') {
          statusClass = 'status-completed';
          statusText = 'Completado';
        }
        
        const createdDate = new Date(project.created_at).toLocaleDateString('es-ES');
        const members = Math.floor(Math.random() * 8) + 2; // Simulado
        const colors = ['blue', 'green', 'purple', 'red', 'orange', 'yellow', 'pink', 'indigo'];
        const color = colors[Math.floor(Math.random() * colors.length)];
        
        return `
          <div class="project-card" data-project-id="${project.id}" onclick="handleProjectCardClick(event, '${project.id}')">
            <div class="project-header">
              <div class="project-title-section">
                <div class="dot ${color}"></div>
                <div class="project-title">${project.title}</div>
              </div>
              <div class="project-menu">
                <button class="menu-button" onclick="toggleProjectMenu('${project.id}')">
                  ⋯
                </button>
                <div class="menu-dropdown" id="menu-${project.id}">
                  <button class="menu-item" onclick="viewProject('${project.id}')">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.639 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.639 0-8.573-3.007-9.963-7.178Z" />
                      <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    Ver
                  </button>
                  <button class="menu-item" onclick="editProject('${project.id}')">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                    </svg>
                    Editar
                  </button>
                  <button class="menu-item delete" onclick="eliminarProyecto('${project.id}')">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                    </svg>
                    Eliminar
                  </button>
                </div>
              </div>
            </div>
            <div class="project-description">${project.description}</div>
            <div class="project-meta">
              <div class="project-members">
                <div class="member-avatars">
                  <div class="member-avatar">AG</div>
                  <div class="member-avatar">CL</div>
                  <div class="member-avatar">MR</div>
                </div>
                <span>${members} miembros</span>
              </div>
              <span>Creado el ${createdDate}</span>
            </div>
            <div class="project-progress">
              <div class="progress-bar">
                <div class="progress-fill" style="width: 0%"></div>
              </div>
              <span class="progress-text">0%</span>
            </div>
            <div class="project-status ${statusClass}">${statusText}</div>
          </div>
        `;
      });
      
      list.innerHTML = projectCards.join('');
      
      // Cargar progreso para cada proyecto
      data.dashboard.projects.forEach(project => {
        loadProjectProgress(project.id);
      });
    } else {
      // Mostrar estado vacío
      list.innerHTML = `
        <div class="empty-state">
          <h3>No hay proyectos</h3>
          <p>Crea tu primer proyecto para comenzar</p>
          <button class="btn btn-primary" onclick="showCreateProjectModal()">Crear Proyecto</button>
        </div>
      `;
      
      // Actualizar estadísticas en 0
      document.getElementById('totalProjects').textContent = '0';
      document.getElementById('activeProjects').textContent = '0';
      document.getElementById('completedProjects').textContent = '0';
      document.getElementById('totalMembers').textContent = '3';
    }
  })
  .catch(error => {
    console.error('Error al cargar el dashboard:', error);
    alert('Error al cargar el dashboard: ' + error.message);
  });

// Formulario de crear proyecto
document.getElementById('projectForm').addEventListener('submit', function (e) {
  e.preventDefault();
  const formData = new FormData(this);
  formData.append('slug', slug);

  fetch('../api/create_project.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      alert(data.message);
      this.reset();
      hideCreateProjectModal();
      location.reload();
    } else {
      alert('Error: ' + data.message);
    }
  })
  .catch(error => {
    console.error('Error:', error);
    alert('Error al crear el proyecto');
  });
});

function eliminarProyecto(id) {
  if (!confirm("¿Eliminar este proyecto?")) return;

  fetch('../api/delete_project.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: `id=${id}`
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      alert(data.message);
      location.reload();
    } else {
      alert('Error: ' + data.message);
    }
  })
  .catch(error => {
    console.error('Error:', error);
    alert('Error al eliminar el proyecto');
  });
}

function mostrarFormularioEditar(id, title, description) {
  // Implementar modal de edición
  alert('Función de edición próximamente disponible');
}

function cancelarEdicion(id) {
  // Implementar cancelar edición
}

function toggleProjectMenu(projectId) {
  // Cerrar todos los menús abiertos
  document.querySelectorAll('.menu-dropdown').forEach(menu => {
    menu.classList.remove('show');
  });
  
  // Abrir/cerrar el menú específico
  const menu = document.getElementById(`menu-${projectId}`);
  if (menu) {
    menu.classList.toggle('show');
  }
  
  // Cerrar menú al hacer clic fuera
  document.addEventListener('click', (e) => {
    if (!e.target.closest('.project-menu')) {
      document.querySelectorAll('.menu-dropdown').forEach(menu => {
        menu.classList.remove('show');
      });
    }
  });
}

function viewProject(projectId) {
  // Navegar a la página de detalle del proyecto
  const urlParams = new URLSearchParams(window.location.search);
  const dashboardSlug = urlParams.get('slug');
  window.location.href = `project.html?id=${projectId}&dashboard=${dashboardSlug}`;
}

function editProject(projectId) {
  alert('Función de editar proyecto próximamente disponible');
}

function loadProjectProgress(projectId) {
  fetch(`../api/get_project_stats.php?id=${projectId}`)
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        const projectCard = document.querySelector(`[data-project-id="${projectId}"]`);
        if (projectCard) {
          const progressFill = projectCard.querySelector('.progress-fill');
          const progressText = projectCard.querySelector('.progress-text');
          
          if (progressFill && progressText) {
            progressFill.style.width = `${data.stats.progress}%`;
            progressText.textContent = `${data.stats.progress}%`;
          }
        }
      }
    })
    .catch(error => {
      console.error('Error al cargar progreso del proyecto:', error);
    });
}

function handleProjectCardClick(event, projectId) {
  // Evitar la navegación si se hizo clic en el menú o sus elementos
  if (event.target.closest('.project-menu') || 
      event.target.closest('.menu-button') || 
      event.target.closest('.menu-dropdown') ||
      event.target.closest('.menu-item')) {
    return;
  }
  
  // Navegar al proyecto
  viewProject(projectId);
}
