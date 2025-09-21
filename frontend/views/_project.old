<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detalle del Proyecto</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="public/css/project.css">
</head>
<body>
  <!-- Project Header -->
  <div class="project-header">
    <div class="header-content">
      <div class="project-info">
        <button class="back-button" onclick="goBack()">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
          </svg>
          Volver al Dashboard
        </button>
        <div class="project-title-section">
          <div class="dot blue"></div>
          <div>
            <h1 class="project-title" id="projectTitle">Cargando...</h1>
            <p class="project-subtitle" id="projectDescription">Cargando descripción...</p>
          </div>
        </div>
      </div>
      <div class="project-actions">
        <span class="status-badge status-active" id="projectStatus">Activo</span>
        <button class="menu-button" onclick="toggleProjectMenu()">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm6 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm-6 5.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm6 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
          </svg>
        </button>
      </div>
    </div>
  </div>

  <div class="project-container">
    <!-- Statistics -->
    <div class="stats-grid">
      <div class="stat-card">
        <h3>Progreso</h3>
        <div class="stat-value" id="progressValue">65%</div>
        <div class="progress-bar">
          <div class="progress-fill" style="width: 65%"></div>
        </div>
        <div class="stat-icon stat-icon-blue">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
          </svg>
        </div>
      </div>
      <div class="stat-card">
        <h3>Tareas</h3>
        <div class="stat-value" id="tasksValue">1/3</div>
        <div class="stat-icon stat-icon-green">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </div>
      </div>
      <div class="stat-card">
        <h3>Miembros</h3>
        <div class="stat-value" id="membersValue">4</div>
        <div class="stat-icon stat-icon-purple">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
          </svg>
        </div>
      </div>
      <div class="stat-card">
        <h3>Archivos</h3>
        <div class="stat-value" id="filesValue">3</div>
        <div class="stat-icon stat-icon-yellow">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
          </svg>
        </div>
      </div>
    </div>

    <!-- Tabs -->
    <div class="tabs">
      <div class="tab active" onclick="showTab('tasks')">Tareas</div>
      <div class="tab" onclick="showTab('files')">Archivos</div>
      <div class="tab" onclick="showTab('members')">Miembros</div>
      <div class="tab" onclick="showTab('activity')">Actividad</div>
    </div>

    <!-- Tasks Tab -->
    <div id="tasks-tab" class="tab-content active">
      <div class="section-header">
        <h2 class="section-title">Tareas del Proyecto</h2>
        <button class="btn btn-primary" onclick="showCreateTaskModal()">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 16px; height: 16px;">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
          </svg>
          Nueva Tarea
        </button>
      </div>
      <div id="tasksList">
        <!-- Tasks will be loaded here -->
      </div>
    </div>

    <!-- Files Tab -->
    <div id="files-tab" class="tab-content">
      <div class="section-header">
        <h2 class="section-title">Archivos del Proyecto</h2>
        <button class="btn btn-primary" onclick="showUploadFileModal()">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 16px; height: 16px;">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
          </svg>
          Subir Archivo
        </button>
      </div>
      <div id="filesList">
        <!-- Files will be loaded here -->
      </div>
    </div>

    <!-- Members Tab -->
    <div id="members-tab" class="tab-content">
      <div class="section-header">
        <h2 class="section-title">Miembros del Proyecto</h2>
        <button class="btn btn-primary" onclick="showInviteMemberModal()">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 16px; height: 16px;">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
          </svg>
          Invitar Miembro
        </button>
      </div>
      <div id="membersList">
        <!-- Members will be loaded here -->
      </div>
    </div>

    <!-- Activity Tab -->
    <div id="activity-tab" class="tab-content">
      <div class="section-header">
        <h2 class="section-title">Actividad del Proyecto</h2>
      </div>
      <div id="activityList">
        <!-- Activity will be loaded here -->
      </div>
    </div>
  </div>

  <!-- Modal para crear tarea -->
  <div id="createTaskModal" class="modal">
    <div class="modal-content">
      <h2>Crear Nueva Tarea</h2>
      <form id="taskForm">
        <div class="form-group">
          <label for="taskTitle">Título de la Tarea</label>
          <input type="text" id="taskTitle" name="title" placeholder="Ej: Diseñar wireframes" required>
        </div>
        <div class="form-group">
          <label for="taskDescription">Descripción</label>
          <textarea id="taskDescription" name="description" placeholder="Describe la tarea..." required></textarea>
        </div>
        <div class="form-group">
          <label for="taskPriority">Prioridad</label>
          <select id="taskPriority" name="priority" required>
            <option value="low">Baja</option>
            <option value="medium" selected>Media</option>
            <option value="high">Alta</option>
          </select>
        </div>
        <div class="form-group">
          <label for="taskAssignedTo">Asignar a</label>
          <input type="text" id="taskAssignedTo" name="assigned_to" placeholder="Nombre del responsable">
        </div>
        <div class="form-group">
          <label for="taskDueDate">Fecha de vencimiento</label>
          <input type="date" id="taskDueDate" name="due_date" required>
        </div>
        <div class="modal-buttons">
          <button type="button" class="btn-cancel" onclick="hideCreateTaskModal()">Cancelar</button>
          <button type="submit" class="btn-submit">Crear Tarea</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Modal para editar tarea -->
  <div id="editTaskModal" class="modal">
    <div class="modal-content">
      <h2>Editar Tarea</h2>
      <form id="editTaskForm">
        <input type="hidden" id="editTaskId" name="task_id">
        <div class="form-group">
          <label for="editTaskTitle">Título de la Tarea</label>
          <input type="text" id="editTaskTitle" name="title" placeholder="Ej: Diseñar wireframes" required>
        </div>
        <div class="form-group">
          <label for="editTaskDescription">Descripción</label>
          <textarea id="editTaskDescription" name="description" placeholder="Describe la tarea..." required></textarea>
        </div>
        <div class="form-group">
          <label for="editTaskPriority">Prioridad</label>
          <select id="editTaskPriority" name="priority" required>
            <option value="low">Baja</option>
            <option value="medium" selected>Media</option>
            <option value="high">Alta</option>
          </select>
        </div>
        <div class="form-group">
          <label for="editTaskAssignedTo">Asignar a</label>
          <input type="text" id="editTaskAssignedTo" name="assigned_to" placeholder="Nombre del responsable">
        </div>
        <div class="form-group">
          <label for="editTaskDueDate">Fecha de vencimiento</label>
          <input type="date" id="editTaskDueDate" name="due_date" required>
        </div>
        <div class="form-group">
          <label for="editTaskStatus">Estado</label>
          <select id="editTaskStatus" name="status" required>
            <option value="pending">Pendiente</option>
            <option value="in_progress">En Progreso</option>
            <option value="completed">Completada</option>
          </select>
        </div>
        <div class="modal-buttons">
          <button type="button" class="btn-cancel" onclick="hideEditTaskModal()">Cancelar</button>
          <button type="submit" class="btn-submit">Actualizar Tarea</button>
        </div>
      </form>
    </div>
  </div>

  <script src="public/js/verifylogin.js"></script>
  <script src="public/js/project-ui.js"></script>
</body>
