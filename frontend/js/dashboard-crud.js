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
            
            return `
                <div class="dashboard-card" data-slug="${dashboard.slug}">
                    <div class="dashboard-header">
                        <div class="dot ${color}"></div>
                        ${this.escapeHtml(dashboard.title)}
                    </div>
                    <p class="dashboard-description">${this.escapeHtml(dashboard.description)}</p>
                    <div class="dashboard-meta">
                        <span>${dashboard.total_projects} proyectos</span>
                        <span>${members} miembros</span>
                    </div>
                    <div class="dashboard-footer">
                        <span>${dashboard.created_by || 'Creado recientemente'}</span>
                        <span>Última actividad: ${new Date(dashboard.created_at).toLocaleDateString('es-ES')}</span>
                    </div>
                    <div class="dashboard-actions">
                        <button class="btn-open" onclick="dashboardManager.viewDashboard('${dashboard.slug}')">
                            Abrir Dashboard
                        </button>
                        <button class="btn-delete" onclick="dashboardManager.deleteDashboard('${dashboard.slug}', '${dashboard.title}')" title="Eliminar Dashboard">
                            🗑️
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