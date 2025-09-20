const API_BASE = '/Hackdash-aiweekend/backend/public/';

document.addEventListener('DOMContentLoaded', () => {
    const allProjectsGrid = document.getElementById('allProjectsGrid');
    const paginationControls = document.getElementById('paginationControls');
    let currentPage = 1;
    const projectsPerPage = 6;

async function fetchProjects(page) {
    try {
        const response = await fetch(`${API_BASE}project/all?page=${page}&limit=${projectsPerPage}`);

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        const data = await response.json();
        if (data.success) {
            renderProjects(data.data);
            renderPagination(data.pagination.totalPages, data.pagination.page);
        } else {
            allProjectsGrid.innerHTML = '<p>Error al cargar proyectos: ' + data.message + '</p>';
        }
    } catch (error) {
        console.error('Error fetching all projects:', error);
        allProjectsGrid.innerHTML = '<p>No se pudieron cargar los proyectos. Inténtalo de nuevo más tarde.</p>';
    }
}

    function renderProjects(projects) {
        allProjectsGrid.innerHTML = '';
        if (projects.length === 0) {
            allProjectsGrid.innerHTML = '<p>No hay proyectos disponibles en este momento.</p>';
            return;
        }
        projects.forEach(project => {
            const projectCard = document.createElement('div');
            projectCard.className = 'project-card';
            projectCard.innerHTML = `
                <h3>${project.title}</h3>
                <p>${project.description}</p>
                <div class="project-meta">
                    <span class="status ${project.status === 'completed' ? 'status-completed' : 'status-in-progress'}">${project.status === 'completed' ? 'Completado' : 'En Progreso'}</span>
                    <span class="dashboard-link">Dashboard: <a href="/Hackdash-aiweekend/frontend/dashboard?slug=${project.dashboard_slug}">${project.dashboard_name}</a></span>
                </div>
                <a href="project-detail?id=${project.id}" class="btn-ver-mas">Ver más</a>
            `;
            allProjectsGrid.appendChild(projectCard);
        });
    }

    function renderPagination(totalPages, currentPage) {
        paginationControls.innerHTML = '';
        if (totalPages <= 1) return;

        // Previous Button
        const prevButton = document.createElement('button');
        prevButton.className = 'pagination-button';
        prevButton.disabled = currentPage === 1;
        prevButton.textContent = 'Anterior';
        prevButton.addEventListener('click', () => {
            currentPage--;
            fetchProjects(currentPage);
        });
        paginationControls.appendChild(prevButton);

        // Page Numbers
        for (let i = 1; i <= totalPages; i++) {
            const pageButton = document.createElement('button');
            pageButton.className = 'pagination-button';
            if (i === currentPage) {
                pageButton.classList.add('active');
            }
            pageButton.textContent = i;
            pageButton.addEventListener('click', () => {
                currentPage = i;
                fetchProjects(currentPage);
            });
            paginationControls.appendChild(pageButton);
        }

        // Next Button
        const nextButton = document.createElement('button');
        nextButton.className = 'pagination-button';
        nextButton.disabled = currentPage === totalPages;
        nextButton.textContent = 'Siguiente';
        nextButton.addEventListener('click', () => {
            currentPage++;
            fetchProjects(currentPage);
        });
        paginationControls.appendChild(nextButton);
    }

    // Initial fetch
    fetchProjects(currentPage);
});
