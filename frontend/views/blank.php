<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mis Dashboards</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <script src="https://unpkg.com/heroicons@2.0.18/24/outline/index.js"></script>
  <link rel="stylesheet" href="public/css/blank.css">
</head>

<body>
  <header>
    <div class="header-content">
      <div class="header-left">
        <button class="btn-salir" onclick="logout()">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
          </svg>
          Salir
        </button>
        <div class="header-center">
          <h1>Mis Dashboards</h1>
          <p>Gestiona todos tus espacios de trabajo</p>
        </div>
      </div>
      <div class="header-right">
        <div class="user-info" id="userInfo">
          <div class="user-avatar" id="userAvatar">U</div>
          <div class="user-details">
            <div class="user-name" id="userName">Usuario</div>
            <div class="user-email" id="userEmail">usuario@email.com</div>
          </div>
        </div>
        <button class="btn-create" onclick="showCreateModal()">+ Crear Dashboard</button>
      </div>
    </div>
  </header>

  <div class="container">
    <div class="stats">
      <div class="stat-card">
        <span id="totalDashboards">0</span>
        <p>Total Dashboards</p>
        <div class="stat-icon stat-icon-blue">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 0 1 0-.255c.007-.378-.138-.75-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281Z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
          </svg>
        </div>
      </div>
      <div class="stat-card">
        <span id="totalProjects">0</span>
        <p>Total Proyectos</p>
        <div class="stat-icon stat-icon-green">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
          </svg>
        </div>
      </div>
      <div class="stat-card">
        <span id="totalMembers">0</span>
        <p>Total Miembros</p>
        <div class="stat-icon stat-icon-purple">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
          </svg>
        </div>
      </div>
      <div class="stat-card">
        <span id="activeDashboards">0</span>
        <p>Activos</p>
        <div class="stat-icon stat-icon-yellow">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
          </svg>
        </div>
      </div>
    </div>

    <div class="search-box">
      <input type="text" placeholder="Buscar dashboards..." id="searchInput">
    </div>

    <div class="dashboard-grid" id="dashboardsList">
      <div class="loading">Cargando dashboards...</div>
    </div>
  </div>

  <!-- Modal para crear dashboard -->
  <div id="createModal" class="modal">
    <div class="modal-content">
      <h2>Crear Nuevo Dashboard</h2>
  <form id="dashboardForm">
        <div class="form-group">
          <label for="title">Título del Dashboard</label>
          <input type="text" id="title" name="title" placeholder="Ej: Proyectos Personales" required>
        </div>
        <div class="form-group">
          <label for="description">Descripción</label>
          <textarea id="description" name="description" placeholder="Describe el propósito de este dashboard..." required></textarea>
        </div>
        <div class="form-group">
          <label>Color del Dashboard</label>
          <div class="color-options">
            <div class="color-option" data-color="blue">
              <div class="color-circle blue"></div>
              <span>Azul</span>
            </div>
            <div class="color-option" data-color="green">
              <div class="color-circle green"></div>
              <span>Verde</span>
            </div>
            <div class="color-option" data-color="purple">
              <div class="color-circle purple"></div>
              <span>Púrpura</span>
            </div>
            <div class="color-option" data-color="red">
              <div class="color-circle red"></div>
              <span>Rojo</span>
            </div>
            <div class="color-option" data-color="orange">
              <div class="color-circle orange"></div>
              <span>Naranja</span>
            </div>
            <div class="color-option" data-color="yellow">
              <div class="color-circle yellow"></div>
              <span>Amarillo</span>
            </div>
            <div class="color-option" data-color="pink">
              <div class="color-circle pink"></div>
              <span>Rosa</span>
            </div>
            <div class="color-option" data-color="indigo">
              <div class="color-circle indigo"></div>
              <span>Índigo</span>
            </div>
          </div>
          <input type="hidden" id="selectedColor" name="color" value="blue">
        </div>
        <div class="modal-buttons">
          <button type="button" class="btn-cancel" onclick="hideCreateModal()">Cancelar</button>
          <button type="submit" class="btn-submit">Crear Dashboard</button>
        </div>
  </form>
    </div>
  </div>

  <!-- Modal para editar dashboard -->
  <div id="editModal" class="modal">
    <div class="modal-content">
      <h2>Editar Dashboard</h2>
      <form id="editDashboardForm">
        <input type="hidden" id="editSlug" name="slug">
        <div class="form-group">
          <label for="editTitle">Título del Dashboard</label>
          <input type="text" id="editTitle" name="title" placeholder="Ej: Proyectos Personales" required>
        </div>
        <div class="form-group">
          <label for="editDescription">Descripción</label>
          <textarea id="editDescription" name="description" placeholder="Describe el propósito de este dashboard..." required></textarea>
        </div>
        <div class="form-group">
          <label>Color del Dashboard</label>
          <div class="color-options" id="editColorOptions">
            <div class="color-option" data-color="blue">
              <div class="color-circle blue"></div>
              <span>Azul</span>
            </div>
            <div class="color-option" data-color="green">
              <div class="color-circle green"></div>
              <span>Verde</span>
            </div>
            <div class="color-option" data-color="purple">
              <div class="color-circle purple"></div>
              <span>Púrpura</span>
            </div>
            <div class="color-option" data-color="red">
              <div class="color-circle red"></div>
              <span>Rojo</span>
            </div>
            <div class="color-option" data-color="orange">
              <div class="color-circle orange"></div>
              <span>Naranja</span>
            </div>
            <div class="color-option" data-color="yellow">
              <div class="color-circle yellow"></div>
              <span>Amarillo</span>
            </div>
            <div class="color-option" data-color="pink">
              <div class="color-circle pink"></div>
              <span>Rosa</span>
            </div>
            <div class="color-option" data-color="indigo">
              <div class="color-circle indigo"></div>
              <span>Índigo</span>
            </div>
          </div>
          <input type="hidden" id="editSelectedColor" name="color" value="blue">
        </div>
        <div class="modal-buttons">
          <button type="button" class="btn-cancel" onclick="hideEditModal()">Cancelar</button>
          <button type="submit" class="btn-submit">Guardar Cambios</button>
        </div>
      </form>
    </div>
  </div>

  <script src="public/js/dashboard-crud.js"></script>
  <script src="public/js/verifylogin.js"></script>
  <script src="public/js/blank-ui.js"></script>
</body>

</html>
