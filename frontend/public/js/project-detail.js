const API_BASE = '/Hackdash-aiweekend/backend/public/';

document.addEventListener('DOMContentLoaded', () => {
    const projectDetailContent = document.getElementById('projectDetailContent');
    const urlParams = new URLSearchParams(window.location.search);
    const projectId = urlParams.get('id');

    if (projectId) {
        fetchProjectDetails(projectId);
    } else {
        projectDetailContent.innerHTML = '<p>No se especificó ningún ID de proyecto.</p>';
    }

    async function fetchProjectDetails(id) {
        try {
            const response = await fetch(`${API_BASE}project/get?id=${id}`);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const data = await response.json();

            if (data.success) {
                if (data.project) { 
                    renderProjectDetails(data.project);
                } else {
                    projectDetailContent.innerHTML = '<p>No se encontraron detalles del proyecto.</p>';
                }
            } else {
                projectDetailContent.innerHTML = '<p>Error al cargar detalles del proyecto: ' + data.message + '</p>';
            }
        } catch (error) {
            console.error('Error fetching project detail:', error);
            projectDetailContent.innerHTML = '<p>No se pudieron cargar los detalles del proyecto. Inténtalo de nuevo más tarde.</p>';
        }
    }

function renderProjectDetails(project) {
    if (!project) {
        console.error("Project data is undefined or null.");
        return;
    }

    document.querySelector('.project-detail-title').textContent = project.title;

    projectDetailContent.innerHTML = `
        <p><strong>Descripción:</strong> ${project.description}</p>
        <p><strong>Estado:</strong> ${project.status === 'completed' ? 'Completado' : 'En Progreso'}</p>
        <p><strong>Dashboard:</strong> ${project.dashboard_slug}</p>
        <p><strong>Fecha de Creación:</strong> ${new Date(project.created_at).toLocaleDateString()}</p>
        <p><strong>Última Actualización:</strong> ${new Date(project.updated_at).toLocaleDateString()}</p>
        <button id="backButton">
            Volver atrás
        </button>
    `;

    // Añadir funcionalidad al botón
    const backButton = document.getElementById('backButton');
    backButton.addEventListener('click', () => {
        window.history.back();
    });
}


});
