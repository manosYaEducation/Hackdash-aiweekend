// Configuración de la API
const API_BASE = '../api/';

// Clase para manejar dashboards
class DashboardManager {
    constructor() {
        this.init();
    }

    init() {
        this.loadDashboards();
        this.setupEventListeners();
    }

    setupEventListeners() {
        // Formulario de crear dashboard
        const dashboardForm = document.getElementById('dashboardForm');
        if (dashboardForm) {
            dashboardForm.addEventListener('submit', (e) => this.createDashboard(e));
        }

        // Búsqueda
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('input', (e) => this.filterDashboards(e.target.value));
        }
    }

    async loadDashboards() {
        try {
            console.log('Cargando dashboards desde:', `${API_BASE}get_dashboards.php`);
            const response = await fetch(`${API_BASE}get_dashboards.php`);
            console.log('Respuesta del servidor:', response);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const result = await response.json();
            console.log('Datos recibidos:', result);
            
            if (result.success) {
                this.displayDashboards(result.data);
            } else {
                this.showMessage('Error al cargar dashboards: ' + result.message, 'error');
            }
        } catch (error) {
            console.error('Error al cargar dashboards:', error);
            this.showMessage('Error de conexión: ' + error.message, 'error');
        }
    }

    displayDashboards(dashboards) {
        const container = document.getElementById('dashboardsList');
        if (!container) {
            console.error('No se encontró el contenedor dashboardsList');
            return;
        }

        console.log('Mostrando dashboards:', dashboards);

        if (dashboards.length === 0) {
            container.innerHTML = '<p style="text-align: center; color: #6b7280; padding: 2rem;">No hay dashboards disponibles. Crea el primero!</p>';
            return;
        }

        // Actualizar contadores
        this.updateSummaryCards(dashboards);

        container.innerHTML = dashboards.map((dashboard, index) => {
            // Usar el color real del dashboard desde la base de datos
            const color = dashboard.color || 'blue';
            const members = Math.floor(Math.random() * 10) + 3; // Simulado por ahora
            const projects = dashboard.total_projects || 0;
            const lastActivity = new Date(dashboard.created_at).toLocaleDateString('es-ES');
            const owner = dashboard.created_by || 'Ana García';
            
            return `
                <div class="dashboard-card" data-slug="${dashboard.slug}">
                    <div class="dashboard-header">
                        <div class="dashboard-title-section">
                            <div class="dot ${color}"></div>
                            <h3 class="dashboard-title">${this.escapeHtml(dashboard.title)}</h3>
                        </div>
                        <div class="dashboard-menu">
                            <button class="menu-button" onclick="dashboardManager.toggleMenu('${dashboard.slug}')">
                                ⋯
                            </button>
                            <div class="menu-dropdown" id="menu-${dashboard.slug}">
                                <button class="menu-item" onclick="dashboardManager.viewDashboard('${dashboard.slug}')">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.639 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.639 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                    Ver
                                </button>
                                <button class="menu-item" onclick="dashboardManager.editDashboard('${dashboard.slug}')">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                    Editar
                                </button>
                                <button class="menu-item delete" onclick="dashboardManager.deleteDashboard('${dashboard.slug}', '${dashboard.title}')">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                    Eliminar
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <p class="dashboard-description">${this.escapeHtml(dashboard.description)}</p>
                    
                    <div class="dashboard-meta">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 16px; height: 16px; display: inline; margin-right: 4px;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                            </svg>
                            ${projects} proyectos
                        </span>
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 16px; height: 16px; display: inline; margin-right: 4px;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                            </svg>
                            ${members} miembros
                        </span>
                    </div>
                    
                    <div class="dashboard-footer">
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <div style="width: 24px; height: 24px; background-color: #e5e7eb; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.7rem; color: #6b7280;">
                                ${owner.charAt(0).toUpperCase()}
                            </div>
                            <span style="font-size: 0.85rem; color: #6b7280;">${owner}</span>
                        </div>
                        <span style="font-size: 0.85rem; color: #6b7280;">Última actividad: ${lastActivity}</span>
                    </div>
                    
                    <div class="dashboard-actions">
                        <button class="btn-open" onclick="dashboardManager.viewDashboard('${dashboard.slug}')">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 16px; height: 16px; margin-right: 8px;">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.639 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.639 0-8.573-3.007-9.963-7.178Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                            Abrir Dashboard
                        </button>
                    </div>
                </div>
            `;
        }).join('');
    }

    updateSummaryCards(dashboards) {
        const totalDashboards = dashboards.length;
        const totalProjects = dashboards.reduce((sum, d) => sum + parseInt(d.total_projects || 0), 0);
        const totalMembers = dashboards.length * 5; // Simulado
        const activeDashboards = dashboards.length;

        document.getElementById('totalDashboards').textContent = totalDashboards;
        document.getElementById('totalProjects').textContent = totalProjects;
        document.getElementById('totalMembers').textContent = totalMembers;
        document.getElementById('activeDashboards').textContent = activeDashboards;
    }

    filterDashboards(searchTerm) {
        const cards = document.querySelectorAll('.dashboard-card');
        cards.forEach(card => {
            const title = card.querySelector('.dashboard-header').textContent.toLowerCase();
            const description = card.querySelector('.dashboard-description').textContent.toLowerCase();
            const search = searchTerm.toLowerCase();
            
            if (title.includes(search) || description.includes(search)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }

    async createDashboard(event) {
        event.preventDefault();
        
        const formData = new FormData(event.target);
        const title = formData.get('title').trim();
        const description = formData.get('description').trim();
        
        // Obtener el email del usuario logueado
        const userEmail = sessionStorage.getItem('userName') || 
                         localStorage.getItem('userName') || 
                         sessionStorage.getItem('username') || 
                         localStorage.getItem('username') || 
                         'usuario@ejemplo.com';

        if (!title || !description) {
            this.showMessage('Por favor completa todos los campos', 'error');
            return;
        }

        // Agregar el email del creador al formData
        formData.append('created_by', userEmail);

        try {
            const response = await fetch(`${API_BASE}create_dashboard.php`, {
                method: 'POST',
                body: formData
            });

            const result = await response.json();
            
            if (result.success) {
                this.showMessage(result.message, 'success');
                event.target.reset();
                hideCreateModal();
                this.loadDashboards();
            } else {
                this.showMessage(result.message, 'error');
            }
        } catch (error) {
            this.showMessage('Error al crear dashboard: ' + error.message, 'error');
        }
    }

    async viewDashboard(slug) {
        window.location.href = `dashboard.html?slug=${slug}`;
    }

    toggleMenu(slug) {
        // Cerrar todos los menús abiertos
        document.querySelectorAll('.menu-dropdown').forEach(menu => {
            menu.classList.remove('show');
        });
        
        // Abrir/cerrar el menú específico
        const menu = document.getElementById(`menu-${slug}`);
        if (menu) {
            menu.classList.toggle('show');
        }
        
        // Cerrar menú al hacer clic fuera
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.dashboard-menu')) {
                document.querySelectorAll('.menu-dropdown').forEach(menu => {
                    menu.classList.remove('show');
                });
            }
        });
    }

    async editDashboard(slug) {
        // Por ahora, redirigir a la página de edición o mostrar modal
        this.showMessage('Función de edición próximamente disponible', 'info');
        // TODO: Implementar modal de edición
    }

    async deleteDashboard(slug, title) {
        if (!confirm(`¿Estás seguro de que quieres eliminar el dashboard "${title}"? Esta acción no se puede deshacer.`)) {
            return;
        }

        try {
            const formData = new FormData();
            formData.append('slug', slug);

            const response = await fetch(`${API_BASE}delete_dashboard.php`, {
                method: 'POST',
                body: formData
            });

            const result = await response.json();
            
            if (result.success) {
                this.showMessage(result.message, 'success');
                this.loadDashboards(); // Recargar la lista
            } else {
                this.showMessage(result.message, 'error');
            }
        } catch (error) {
            console.error('Error al eliminar dashboard:', error);
            this.showMessage('Error al eliminar el dashboard: ' + error.message, 'error');
        }
    }

    showMessage(message, type = 'info') {
        // Crear elemento de mensaje
        const messageDiv = document.createElement('div');
        messageDiv.className = `message message-${type}`;
        messageDiv.textContent = message;
        
        // Agregar al DOM
        document.body.appendChild(messageDiv);
        
        // Remover después de 3 segundos
        setTimeout(() => {
            messageDiv.remove();
        }, 3000);
    }

    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
    console.log('Inicializando DashboardManager');
    window.dashboardManager = new DashboardManager();
}); 