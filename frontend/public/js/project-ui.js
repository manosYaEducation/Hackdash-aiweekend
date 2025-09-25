let currentProjectId = null;
const API_BASE = '/Hackdash-aiweekend/backend/public/';

    // Verificar autenticación al cargar la página
    document.addEventListener('DOMContentLoaded', function() {
      // Verificar si el usuario está logueado usando el sistema existente
      const userLoggedIn = sessionStorage.getItem('userLoggedIn');
      const estaLogueadoLocal = localStorage.getItem('userLoggedIn');
      const token = sessionStorage.getItem('token') || localStorage.getItem('token');
      const userId = localStorage.getItem('user_id') || localStorage.getItem('userId');
      const username = localStorage.getItem('username') || localStorage.getItem('userName') || obtenerUsuario();
      
      console.log('Verificando autenticación:', {
        userLoggedIn,
        estaLogueadoLocal,
        token,
        userId,
        username
      });
      
      // Verificar múltiples condiciones de autenticación
      if ((!userLoggedIn && !estaLogueadoLocal) || !token || !userId || !username) {
        console.log('Usuario no autenticado, redirigiendo al login');
        // Limpiar cualquier dato residual
        sessionStorage.clear();
        localStorage.removeItem('userLoggedIn');
        localStorage.removeItem('user_id');
        localStorage.removeItem('userId');
        localStorage.removeItem('username');
        localStorage.removeItem('userName');
        localStorage.removeItem('token');
        
        // Redirigir al login
        window.location.href = '/Hackdash-aiweekend/frontend/login'; // Updated to use router
        return;
      }
    
      console.log('Usuario autenticado correctamente');
    
      // Obtener el ID del proyecto de la URL
      const urlParams = new URLSearchParams(window.location.search);
      currentProjectId = urlParams.get('id');
      
      if (currentProjectId) {
        loadProjectDetails();
      } else {
        alert('ID de proyecto no encontrado');
        goBack();
      }
    
      // Event listener para el formulario de crear tarea
      const taskForm = document.getElementById('taskForm');
      if (taskForm) {
        taskForm.addEventListener('submit', createTask);
      }


 // Event listener para el formulario de agregar miembro
      const memberForm = document.getElementById('memberForm');
      if (memberForm) {
        memberForm.addEventListener('submit', createProjectMember);
      }

    
      // Cerrar modal al hacer clic fuera
      const createTaskModal = document.getElementById('createTaskModal');
      if (createTaskModal) {
        createTaskModal.addEventListener('click', function(e) {
          if (e.target === this) {
            hideCreateTaskModal();
          }
        });
      }

        // Cerrar modal al hacer clic fuera
      const createMemberModal = document.getElementById('createMemberModal');
      if (createMemberModal) {
        createMemberModal.addEventListener('click', function(e) {
          if (e.target === this) {
            hideCreateTaskModal();
          }
        });
      }

      
    
      // Event listener para el formulario de editar tarea
      const editTaskForm = document.getElementById('editTaskForm');
      if (editTaskForm) {
        editTaskForm.addEventListener('submit', updateTask);
      }
    
      // Cerrar modal de editar al hacer clic fuera
      const editTaskModal = document.getElementById('editTaskModal');
      if (editTaskModal) {
        editTaskModal.addEventListener('click', function(e) {
          if (e.target === this) {
            hideEditTaskModal();
          }
        });
      }
    });
    
    function goBack() {
      const urlParams = new URLSearchParams(window.location.search);
      const dashboardSlug = urlParams.get('dashboardSlug'); // Usar dashboardSlug en lugar de dashboardId
      if (dashboardSlug) {
        window.location.href = `/Hackdash-aiweekend/frontend/dashboard?slug=${dashboardSlug}`;
      } else {
        window.location.href = '/Hackdash-aiweekend/frontend/dashboard'; // Redireccionar al dashboard por defecto
      }
    }
    
    function showTab(tabName) {
      // Ocultar todas las pestañas
      document.querySelectorAll('.tab-content').forEach(tab => {
        tab.classList.remove('active');
      });
      document.querySelectorAll('.tab').forEach(tab => {
        tab.classList.remove('active');
      });
    
      // Mostrar la pestaña seleccionada
      document.getElementById(`${tabName}-tab`).classList.add('active');
      document.querySelector(`[onclick="showTab('${tabName}')"]`).classList.add('active');
    }
    
    function loadProjectDetails() {
      // Cargar detalles del proyecto
      fetch(`${API_BASE}project/get?id=${currentProjectId}`)
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            document.getElementById('projectTitle').textContent = data.project.title;
            document.getElementById('projectDescription').textContent = data.project.description;
            
            // Actualizar estadísticas
            updateProjectStats();
            
            // Cargar contenido de las pestañas
            loadTasks();
            //loadFiles();
            loadMembers();
           // loadActivity();
          } else {
            alert('Error al cargar el proyecto');
            goBack();
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('Error al cargar el proyecto');
          goBack();
        });
    }
    
    function updateProjectStats() {
      // Actualizar estadísticas del proyecto
      fetch(`${API_BASE}project/stats?id=${currentProjectId}`)
        .then(response => response.json())
        .then(data => {
          if (data.success) {
         //   document.getElementById('progressValue').textContent = `${data.stats.progress}%`;
        //    document.querySelector('.progress-fill').style.width = `${data.stats.progress}%`;
        //    document.getElementById('tasksValue').textContent = `${data.stats.completed_tasks}/${data.stats.total_tasks}`;
           document.getElementById('tasksValue').textContent = `${data.stats.total_tasks}`;
              
        document.getElementById('membersValue').textContent = data.stats.total_members;
          //  document.getElementById('filesValue').textContent = data.stats.total_files;
          }
        })
        .catch(error => {
          console.error('Error:', error);
        });
    }
    
    function loadTasks() {
      console.log(`Fetching tasks for project ID: ${currentProjectId}`);
      fetch(`${API_BASE}project/tasks?id=${currentProjectId}`)
        .then(response => {
          console.log('Raw tasks API response:', response);
          if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
          }
          return response.json();
        })
        .then(data => {
          console.log('Parsed tasks data:', data);
          if (data.success) {
            const tasksList = document.getElementById('tasksList');
            tasksList.innerHTML = '';
            
            if (data.tasks && data.tasks.length > 0) {
              data.tasks.forEach(task => {
                const taskCard = createTaskCard(task);
                tasksList.appendChild(taskCard);
              });
            } else {
              tasksList.innerHTML = '<p class="empty-state-message">No hay tareas disponibles. Crea la primera!</p>';
            }
          } else {
            console.error('Error loading tasks:', data.message);
            // Optionally, display an error message to the user
            const tasksList = document.getElementById('tasksList');
            tasksList.innerHTML = `<p class="error-state-message">Error al cargar tareas: ${data.message}</p>`;
          }
        })
        .catch(error => {
          console.error('Error al cargar tareas:', error);
          const tasksList = document.getElementById('tasksList');
          tasksList.innerHTML = `<p class="error-state-message">Error de conexión al cargar tareas: ${error.message}</p>`;
        });
    }
    
    function createTaskCard(task) {
      const taskCard = document.createElement('div');
      taskCard.className = 'task-card';
      
      const priorityClass = `priority-${task.priority}`;
      const priorityText = task.priority === 'high' ? 'Alta' : task.priority === 'medium' ? 'Media' : 'Baja';
      
      // Determinar el icono según el estado de la tarea
      let statusIcon = '';
      switch(task.status) {
        case 'pending':
          statusIcon = '<div class="task-status pending"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></div>';
          break;
        case 'in_progress':
          statusIcon = '<div class="task-status in-progress"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" /></svg></div>';
          break;
        case 'completed':
          statusIcon = '<div class="task-status completed"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg></div>';
          break;
        default:
          statusIcon = '<div class="task-status pending"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></div>';
      }
      
      taskCard.innerHTML = `
        <div class="task-header">
          <div class="task-main-content">
            ${statusIcon}
            <div class="task-content">
              <div class="task-title-section">
                <div class="task-title">${task.title}</div>
                <span class="priority-badge ${priorityClass}">${priorityText}</span>
              </div>
              <div class="task-description">${task.description}</div>
            </div>
          </div>
          <div class="task-menu-container">
            <button class="task-menu-btn" onclick="toggleTaskMenu(${task.id})">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 0 1 0 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 0 1 0-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281Z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 016 0Z" />
              </svg>
            </button>
            <div id="task-menu-${task.id}" class="task-menu-dropdown">
              <button class="task-menu-item" onclick="editTask(${task.id})">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                </svg>
                Editar
              </button>
              <button class="task-menu-item" onclick="viewTaskDetails(${task.id})">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.885 4.5 12 4.5c4.085 0 8.526 3.11 9.964 7.178.07.207.07.431 0 .639C20.526 16.89 16.085 20 12 20c-4.085 0-8.526-3.11-9.964-7.178z" />
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Ver Detalles
              </button>
              <button class="task-menu-item delete" onclick="deleteTask(${task.id})">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                </svg>
                Eliminar
              </button>
            </div>
          </div>
        </div>
        <div class="task-meta">
          <div class="task-assigned">
            <div class="member-avatar">${task.assigned_to ? task.assigned_to.split(' ').map(n => n[0]).join('') : '?'}</div>
            ${task.assigned_to || 'Sin asignar'}
          </div>
          <div class="task-due">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
            </svg>
            Vence: ${new Date(task.due_date).toLocaleDateString('es-ES')}
          </div>
        </div>
      `;
      
      return taskCard;
    }
    
    function loadFiles() {
      fetch(`${API_BASE}project/files?id=${currentProjectId}`)
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            const filesList = document.getElementById('filesList');
            filesList.innerHTML = '';
            
            data.files.forEach(file => {
              const fileCard = createFileCard(file);
              filesList.appendChild(fileCard);
            });
          }
        })
        .catch(error => {
          console.error('Error:', error);
        });
    }
    
    function createFileCard(file) {
      const fileCard = document.createElement('div');
      fileCard.className = 'file-card';
      
      fileCard.innerHTML = `
        <div class="file-icon">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
          </svg>
        </div>
        <div class="file-info">
          <h4>${file.original_name}</h4>
          <p>Subido por ${file.uploaded_by} • ${formatFileSize(file.file_size)}</p>
        </div>
      `;
      
      return fileCard;
    }
    
    function loadMembers() {
      fetch(`${API_BASE}project/members?id=${currentProjectId}`)
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            const membersList = document.getElementById('membersList');
            membersList.innerHTML = '';
            
            data.members.forEach(member => {
              const memberCard = createMemberCard(member);
              membersList.appendChild(memberCard);
            });
          }
        })
        .catch(error => {
          console.error('Error:', error);
        });
    }
    
    function createMemberCard(member) {
      const memberCard = document.createElement('div');
      memberCard.className = 'member-card';
      
      const roleClass = `role-${member.role}`;
      const roleText = member.role === 'owner' ? 'Propietario' : member.role === 'admin' ? 'Administrador' : 'Miembro';
      
      memberCard.innerHTML = `
        <div class="member-avatar-large">${member.avatar_initials}</div>
        <div class="member-info">
          <h4>${member.user_name}</h4>
          <p>${member.email}</p>
        </div>
        <span class="member-role ${roleClass}">${roleText}</span>
      `;
      
      return memberCard;
    }
    
    function loadActivity() {
      fetch(`${API_BASE}project/activity?id=${currentProjectId}`)
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            const activityList = document.getElementById('activityList');
            activityList.innerHTML = '';
            
            data.activity.forEach(item => {
              const activityItem = createActivityItem(item);
              activityList.appendChild(activityItem);
            });
          }
        })
        .catch(error => {
          console.error('Error:', error);
        });
    }
    
    function createActivityItem(item) {
      const activityItem = document.createElement('div');
      activityItem.className = 'activity-item';
      
      const timeAgo = getTimeAgo(new Date(item.created_at));
      
      activityItem.innerHTML = `
        <div class="activity-header">
          <span class="activity-user">${item.user_name}</span>
          <span class="activity-action">${item.action}</span>
          <span class="activity-time">${timeAgo}</span>
        </div>
        <div class="activity-description">${item.description}</div>
      `;
      
      return activityItem;
    }
    
    function formatFileSize(bytes) {
      if (bytes === 0) return '0 Bytes';
      const k = 1024;
      const sizes = ['Bytes', 'KB', 'MB', 'GB'];
      const i = Math.floor(Math.log(bytes) / Math.log(k));
      return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
    
    function getTimeAgo(date) {
      const now = new Date();
      const diffInSeconds = Math.floor((now - date) / 1000);
      
      if (diffInSeconds < 60) return 'Hace un momento';
      if (diffInSeconds < 3600) return `Hace ${Math.floor(diffInSeconds / 60)} minutos`;
      if (diffInSeconds < 86400) return `Hace ${Math.floor(diffInSeconds / 3600)} horas`;
      return `Hace ${Math.floor(diffInSeconds / 86400)} días`;
    }
    
    function showCreateTaskModal() {
      document.getElementById('createTaskModal').style.display = 'block';
      // Establecer fecha mínima como hoy
      const today = new Date().toISOString().split('T')[0];
      document.getElementById('taskDueDate').min = today;
    }
    
    function hideCreateTaskModal() {
      document.getElementById('createTaskModal').style.display = 'none';
      document.getElementById('taskForm').reset();
    }

  function hidecreateMemberModal() {
      document.getElementById('createMemberModal').style.display = 'none';
      document.getElementById('memberForm').reset();
    }
    
    
    function showUploadFileModal() {
      alert('Función de subir archivo próximamente disponible');
    }
    
    function showInviteMemberModal() {
      document.getElementById('createMemberModal').style.display = 'block';
  
    }

  function createProjectMember(event) {
      event.preventDefault();
   
      const formData = new FormData(event.target);
      formData.append('project_id', currentProjectId);
      formData.append('role', 'member'); // en duro por ahora
     
      // Validar campos requeridos
      const mail = formData.get('email').trim();
  
      const name = formData.get('name').trim();
   

      if (!mail || !name) {
        alert('Por favor completa todos los campos requeridos');
        return;
      }
//  alert(currentProjectId);
      
//         alert(formData.response);
      
 fetch(`${API_BASE}project/createProjectMember`, {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          alert('Miembro creado correctamente');
          hidecreateMemberModal();
          loadMembers(); // Recargar la lista de miembros
          updateProjectStats(); // Actualizar estadísticas
        } else {
          alert('Error: ' + data.message);
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('Error al crear el miembro ');
      });


    }


    
    function createTask(event) {
      event.preventDefault();
      
      const formData = new FormData(event.target);
      formData.append('project_id', currentProjectId);
      
      // Validar campos requeridos
      const title = formData.get('title').trim();
      const description = formData.get('description').trim();
      const dueDate = formData.get('due_date');
      
      if (!title || !description || !dueDate) {
        alert('Por favor completa todos los campos requeridos');
        return;
      }
    
      fetch(`${API_BASE}task/create`, {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          alert('Tarea creada correctamente');
          hideCreateTaskModal();
          loadTasks(); // Recargar la lista de tareas
          updateProjectStats(); // Actualizar estadísticas
        } else {
          alert('Error: ' + data.message);
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('Error al crear la tarea');
      });
    }
    
    function toggleProjectMenu() {
      alert('Menú del proyecto próximamente disponible');
    }
    
    // Funciones para el menú de tareas
    function toggleTaskMenu(taskId) {
      // Cerrar todos los menús abiertos
      document.querySelectorAll('.task-menu-dropdown').forEach(dropdown => {
        dropdown.classList.remove('show');
      });
      
      // Abrir/cerrar el menú específico
      const dropdown = document.getElementById(`task-menu-${taskId}`);
      if (dropdown) {
        dropdown.classList.toggle('show');
      }
    }
    
    // Cerrar menús al hacer clic fuera
    document.addEventListener('click', function(event) {
      if (!event.target.closest('.task-menu-container')) {
        document.querySelectorAll('.task-menu-dropdown').forEach(dropdown => {
          dropdown.classList.remove('show');
        });
      }
    });
    
    function editTask(taskId) {
      // Cerrar el menú
      document.getElementById(`task-menu-${taskId}`).classList.remove('show');
      
      // Cargar los datos de la tarea
      const apiUrl = `${API_BASE}task/get?id=${taskId}`;
      console.log('🌐 URL de la API:', apiUrl);
      fetch(apiUrl)
        .then(response => {
          console.log('📡 Respuesta del servidor:', response);
          if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
          }
          return response.json();
        })
        .then(data => {
          console.log('📦 Datos recibidos:', data);
          if (data.success) {
            const task = data.task;
            
            // Llenar el formulario con los datos actuales
            document.getElementById('editTaskId').value = task.id;
            document.getElementById('editTaskTitle').value = task.title;
            document.getElementById('editTaskDescription').value = task.description;
            document.getElementById('editTaskPriority').value = task.priority;
            document.getElementById('editTaskAssignedTo').value = task.assigned_to || '';
            document.getElementById('editTaskDueDate').value = task.due_date;
            document.getElementById('editTaskStatus').value = task.status;
            
            // Mostrar el modal
            showEditTaskModal();
          } else {
            alert('Error al cargar los datos de la tarea: ' + (data.message || 'Error desconocido'));
          }
        })
        .catch(error => {
          console.error('❌ Error al cargar tarea:', error);
          alert('Error al cargar los datos de la tarea: ' + error.message);
        });
    }
    
    function viewTaskDetails(taskId) {
      // Cerrar el menú
      document.getElementById(`task-menu-${taskId}`).classList.remove('show');
      
      // Aquí puedes implementar la lógica para ver detalles de la tarea
      alert(`Ver detalles de la tarea ${taskId} próximamente disponible`);
    }
    
    function deleteTask(taskId) {
      // Cerrar el menú
      document.getElementById(`task-menu-${taskId}`).classList.remove('show');
      
      if (confirm('¿Estás seguro de que quieres eliminar esta tarea? Esta acción no se puede deshacer.')) {
        fetch(`${API_BASE}task/delete`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: `id=${taskId}`
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            alert('Tarea eliminada correctamente');
            loadTasks(); // Recargar la lista de tareas
            updateProjectStats(); // Actualizar estadísticas
          } else {
            alert('Error: ' + (data.message || 'Error desconocido al eliminar tarea'));
          }
        })
        .catch(error => {
          console.error('Error al eliminar tarea:', error);
          alert('Error al eliminar la tarea');
        });
      }
    }


    
    
    function showEditTaskModal() {
      document.getElementById('editTaskModal').style.display = 'block';
      // Establecer fecha mínima como hoy
      const today = new Date().toISOString().split('T')[0];
      document.getElementById('editTaskDueDate').min = today;
    }
    
    function hideEditTaskModal() {
      document.getElementById('editTaskModal').style.display = 'none';
      document.getElementById('editTaskForm').reset();
    }
    
    function updateTask(event) {
      event.preventDefault();
      
      const formData = new FormData(event.target);
      formData.append('project_id', currentProjectId);
      
      // Validar campos requeridos
      const title = formData.get('title').trim();
      const description = formData.get('description').trim();
      const dueDate = formData.get('due_date');
      
      if (!title || !description || !dueDate) {
        alert('Por favor completa todos los campos requeridos');
        return;
      }
    
      fetch(`${API_BASE}task/update`, {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          alert('Tarea actualizada correctamente');
          hideEditTaskModal();
          loadTasks(); // Recargar la lista de tareas
          updateProjectStats(); // Actualizar estadísticas
        } else {
          alert('Error: ' + data.message);
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('Error al actualizar la tarea');
      });
    }
