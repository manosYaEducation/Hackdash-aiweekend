function showCreateModal() {
  document.getElementById('createModal').style.display = 'block';
  // Seleccionar el primer color por defecto
  selectColor('blue');
}

function hideCreateModal() {
  document.getElementById('createModal').style.display = 'none';
  document.getElementById('dashboardForm').reset();
  // Resetear la selección de color
  document.querySelectorAll('.color-option').forEach(option => {
    option.classList.remove('selected');
  });
  selectColor('blue');
}

function selectColor(color) {
  // Remover selección anterior
  document.querySelectorAll('.color-option').forEach(option => {
    option.classList.remove('selected');
  });

  // Seleccionar el nuevo color
  const selectedOption = document.querySelector(`[data-color="${color}"]`);
  if (selectedOption) {
    selectedOption.classList.add('selected');
  }

  // Actualizar el campo hidden
  document.getElementById('selectedColor').value = color;
}

function showEditModal(slug, title, description, color) {
  document.getElementById('editSlug').value = slug;
  document.getElementById('editTitle').value = title;
  document.getElementById('editDescription').value = description;
  document.getElementById('editSelectedColor').value = color;

  // Seleccionar el color correcto en el modal
  selectEditColor(color);

  document.getElementById('editModal').style.display = 'block';
}

function hideEditModal() {
  document.getElementById('editModal').style.display = 'none';
  document.getElementById('editDashboardForm').reset();
  // Resetear la selección de color
  document.querySelectorAll('#editColorOptions .color-option').forEach(option => {
    option.classList.remove('selected');
  });
  selectEditColor('blue');
}

function selectEditColor(color) {
  // Remover selección anterior
  document.querySelectorAll('#editColorOptions .color-option').forEach(option => {
    option.classList.remove('selected');
  });

  // Seleccionar el nuevo color
  const selectedOption = document.querySelector(`#editColorOptions [data-color="${color}"]`);
  if (selectedOption) {
    selectedOption.classList.add('selected');
  }

  // Actualizar el campo hidden
  document.getElementById('editSelectedColor').value = color;
}

function logout() {
  // Limpiar datos de sesión
  localStorage.removeItem('user_id');
  localStorage.removeItem('username');

  // Redirigir a la página de login
  window.location.href = 'index.php?action=login';
}

function loadUserInfo() {
  const username = localStorage.getItem('userName') || localStorage.getItem('username') || 'Usuario';
  const userEmail = localStorage.getItem('userEmail') || 'usuario@email.com';

  // Obtener las iniciales del nombre para el avatar
  const initials = username.split(' ').map(name => name.charAt(0)).join('').toUpperCase();

  // Actualizar los elementos del DOM
  document.getElementById('userName').textContent = username;
  document.getElementById('userEmail').textContent = userEmail;
  document.getElementById('userAvatar').textContent = initials;
}

// Agregar event listeners cuando se carga el DOM
document.addEventListener('DOMContentLoaded', function () {
  // Event listeners para las opciones de color del modal de creación
  document.querySelectorAll('.color-option').forEach(option => {
    option.addEventListener('click', function () {
      const color = this.getAttribute('data-color');
      selectColor(color);
    });
  });

  // Cerrar modal de creación al hacer clic fuera
  document.getElementById('createModal').addEventListener('click', function (e) {
    if (e.target === this) {
      hideCreateModal();
    }
  });

  // Event listeners para las opciones de color del modal de edición
  document.querySelectorAll('#editColorOptions .color-option').forEach(option => {
    option.addEventListener('click', function () {
      const color = this.getAttribute('data-color');
      selectEditColor(color);
    });
  });

  // Cerrar modal de edición al hacer clic fuera
  document.getElementById('editModal').addEventListener('click', function (e) {
    if (e.target === this) {
      hideEditModal();
    }
  });

  // Cargar información del usuario cuando se carga la página
  loadUserInfo();
});