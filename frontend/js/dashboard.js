const slug = new URLSearchParams(window.location.search).get('slug');
console.log("Slug recibido:", slug);


if (!slug) {
  alert("Falta el slug del dashboard");
  location.href = "blank.html";
}

// Cargar datos del dashboard y sus proyectos
fetch(`api/get_dashboard.php?slug=${slug}`)
  .then(res => res.json())
  .then(data => {
    document.getElementById('dashboardTitle').textContent = data.title;
    document.getElementById('dashboardDescription').textContent = data.description;

    const list = document.getElementById('projectList');
    data.projects.forEach(p => {
    const card = document.createElement('div');
    card.className = 'dashboard-card';

    card.innerHTML = `
      <div class="project-display" id="project-display-${p.id}">
        <h3>${p.title}</h3>
        <p>${p.description}</p>
        <button onclick="mostrarFormularioEditar(${p.id}, '${p.title}', '${p.description}')">Editar</button>
        <button class="btn-danger" onclick="eliminarProyecto(${p.id})">Eliminar</button>
      </div>

      <form class="project-edit-form" id="edit-form-${p.id}" style="display: none;">
        <input type="text" name="title" value="${p.title}" required>
        <textarea name="description" required>${p.description}</textarea>
        <button type="submit">Guardar</button>
        <button type="button" onclick="cancelarEdicion(${p.id})">Cancelar</button>
      </form>
    `;

    const form = card.querySelector(`#edit-form-${p.id}`);
    form.addEventListener('submit', function (e) {
      e.preventDefault();
      const formData = new FormData(this);
      formData.append('id', p.id);

      fetch('api/update_project.php', {
        method: 'POST',
        body: formData
      })
      .then(res => res.json())
      .then(data => {
        alert(data.message);
        location.reload();
      });
  });

  list.appendChild(card);
});
  });

document.getElementById('projectForm').addEventListener('submit', function (e) {
  e.preventDefault();
  const formData = new FormData(this);
  formData.append('slug', slug);

  fetch('api/create_project.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    alert(data.message);
    location.reload();
  });
});

function eliminarProyecto(id) {
  if (!confirm("¿Eliminar este proyecto?")) return;

  fetch('api/delete_project.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: `id=${id}`
  })
  .then(res => res.json())
  .then(data => {
    alert(data.message);
    location.reload();
  });
}

function mostrarFormularioEditar(id, title, description) {
  document.getElementById(`project-display-${id}`).style.display = 'none';
  document.getElementById(`edit-form-${id}`).style.display = 'block';
}

function cancelarEdicion(id) {
  document.getElementById(`edit-form-${id}`).style.display = 'none';
  document.getElementById(`project-display-${id}`).style.display = 'block';
}
