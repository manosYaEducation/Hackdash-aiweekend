// Crear dashboard
document.getElementById('dashboardForm').addEventListener('submit', function (e) {
  e.preventDefault();
  const formData = new FormData(this);

  fetch('api/create_dashboard.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    alert(data.message);
    this.reset();
    cargarDashboards();
  });
});

// Mostrar dashboards
function cargarDashboards() {
  fetch('api/get_dashboards.php')
    .then(res => res.json())
    .then(dashboards => {
      const container = document.getElementById('dashboardsList');
      container.innerHTML = '';

      dashboards.forEach(d => {
        const card = document.createElement('div');
        card.className = 'dashboard-card';

        card.innerHTML = `
          <div class="dashboard-display" id="dashboard-display-${d.slug}">
            <h3>${d.title}</h3>
            <p>${d.description}</p>
            <p><strong>${d.total_projects}</strong> proyectos</p>
            <a href="dashboard.html?slug=${d.slug}">Ver proyectos</a>
            <button onclick="mostrarFormularioEditarDashboard('${d.slug}', '${d.title}', '${d.description}')">Editar</button>
            <button class="btn-danger" onclick="eliminarDashboard('${d.slug}')">Eliminar</button>
          </div>

          <form class="dashboard-edit-form" id="edit-dashboard-${d.slug}" style="display: none;">
            <input type="text" name="title" value="${d.title}" required>
            <textarea name="description" required>${d.description}</textarea>
            <button type="submit">Guardar</button>
            <button type="button" onclick="cancelarEdicionDashboard('${d.slug}')">Cancelar</button>
          </form>
        `;
        const form = card.querySelector(`#edit-dashboard-${d.slug}`);
form.addEventListener('submit', function (e) {
  e.preventDefault();

  const formData = new FormData(this);
  formData.append('slug', d.slug);

  fetch('api/update_dashboard.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    alert(data.message);
    cargarDashboards();
  });
});


        container.appendChild(card);
      });
    });
}

document.addEventListener('DOMContentLoaded', cargarDashboards);

function eliminarDashboard(slug) {
  if (!confirm("¿Estás seguro de que quieres eliminar este dashboard? Se eliminarán también sus proyectos.")) return;

  fetch('api/delete_dashboard.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: `slug=${encodeURIComponent(slug)}`
  })
  .then(res => res.json())
  .then(data => {
    alert(data.message);
    cargarDashboards();
  });
}

function mostrarFormularioEditarDashboard(slug, title, description) {
  document.getElementById(`dashboard-display-${slug}`).style.display = 'none';
  document.getElementById(`edit-dashboard-${slug}`).style.display = 'block';
}

function cancelarEdicionDashboard(slug) {
  document.getElementById(`edit-dashboard-${slug}`).style.display = 'none';
  document.getElementById(`dashboard-display-${slug}`).style.display = 'block';
}
