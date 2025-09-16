<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="public/css/dashboard.css">
</head>
<body>
  <!-- Navbar Full Width -->
  <div class="dashboard-header">
    <div class="header-content">
      <div class="dashboard-info">
        <button class="back-button" onclick="window.location.href='/Hackdash-aiweekend/frontend/blank'">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
          </svg>
          Volver
        </button>
        <div class="dashboard-title-section">
          <div class="dot blue"></div>
          <div>
            <h1 class="dashboard-title" id="dashboardTitle">Cargando...</h1>
            <p class="dashboard-subtitle" id="dashboardDescription">Cargando descripción...</p>
          </div>
        </div>
      </div>
      <div class="dashboard-actions">
        <button class="btn btn-secondary" onclick="showInviteModal()">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 16px; height: 16px;">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
          </svg>
          Invitar Miembros
        </button>
        <button class="btn btn-primary" onclick="showCreateProjectModal()">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 16px; height: 16px;">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
          </svg>
          Nuevo Proyecto
        </button>
      </div>
    </div>
  </div>

  <div class="dashboard-container">

    <!-- Statistics -->
    <div class="stats-grid">
      <div class="stat-card">
        <h3>Total Proyectos</h3>
        <div class="stat-value" id="totalProjects">0</div>
        <div class="stat-icon stat-icon-blue">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
          </svg>
        </div>
      </div>
      <div class="stat-card">
        <h3>Proyectos en Progreso</h3>
        <div class="stat-value" id="activeProjects">0</div>
        <div class="stat-icon stat-icon-green">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
          </svg>
        </div>
      </div>
      <div class="stat-card">
        <h3>Total Miembros</h3>
        <div class="stat-value" id="totalMembers">0</div>
        <div class="stat-icon stat-icon-purple">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
          </svg>
        </div>
      </div>
      <div class="stat-card">
        <h3>Completados</h3>
        <div class="stat-value" id="completedProjects">0</div>
        <div class="stat-icon stat-icon-yellow">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 0 1 0-.255c.007-.378-.138-.75-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281Z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
          </svg>
        </div>
      </div>
    </div>

    <!-- Search Box -->
    <div class="search-box">
      <input type="text" placeholder="Buscar proyectos..." id="searchInput">
    </div>

    <!-- Projects Grid -->
    <div class="projects-grid" id="projectList">
      <div class="empty-state">
        <h3>No hay proyectos</h3>
        <p>Crea tu primer proyecto para comenzar</p>
        <button class="btn btn-primary" onclick="showCreateProjectModal()">Crear Proyecto</button>
      </div>
    </div>

    <!-- Members Section -->
    <div class="members-section">
      <div class="section-header">
        <div>
          <h2>Miembros del Dashboard</h2>
          <p>Gestiona los miembros de este dashboard</p>
        </div>
      </div>
      <div id="membersList">
        <div class="member-card">
          <div class="member-avatar-large">AG</div>
          <div class="member-info">
            <h4>Ana García</h4>
            <p>ana@example.com</p>
          </div>
          <span class="member-role role-owner">Propietario</span>
        </div>
        <div class="member-card">
          <div class="member-avatar-large">CL</div>
          <div class="member-info">
            <h4>Carlos López</h4>
            <p>carlos@example.com</p>
          </div>
          <span class="member-role role-admin">Administrador</span>
        </div>
        <div class="member-card">
          <div class="member-avatar-large">MR</div>
          <div class="member-info">
            <h4>María Rodríguez</h4>
            <p>maria@example.com</p>
          </div>
          <span class="member-role role-member">Miembro</span>
        </div>
      </div>
    </div>
  </div>

  <!-- Create Project Modal -->
  <div id="createProjectModal" class="modal" style="display: none;">
    <div class="modal-content">
      <h2>Crear Nuevo Proyecto</h2>
      <form id="projectForm">
        <div class="form-group">
          <label for="projectTitle">Título del Proyecto</label>
          <input type="text" id="projectTitle" name="title" placeholder="Ej: Website Redesign" required>
        </div>
        <div class="form-group">
          <label for="projectDescription">Descripción</label>
          <textarea id="projectDescription" name="description" placeholder="Describe el proyecto..." required></textarea>
        </div>
        <div class="form-group">
          <label for="projectStatus">Estado del Proyecto</label>
          <select id="projectStatus" name="status" required>
            <option value="in_progress">En Progreso</option>
            <option value="completed">Completado</option>
          </select>
        </div>
        <div class="modal-buttons">
          <button type="button" class="btn btn-secondary" onclick="hideCreateProjectModal()">Cancelar</button>
          <button type="submit" class="btn btn-primary">Crear Proyecto</button>
        </div>
      </form>
    </div>
  </div>

  <script src="public/js/dashboard.js"></script>
  <script src="public/js/verifylogin.js"></script>
  <script src="public/js/dashboard-ui.js"></script>
</body>
</html>