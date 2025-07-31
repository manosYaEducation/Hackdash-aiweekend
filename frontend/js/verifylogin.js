window.onload = function() {
  const userLoggedIn = sessionStorage.getItem('userLoggedIn');
  const estaLogueadoLocal = localStorage.getItem('userLoggedIn');
  const token = sessionStorage.getItem('token') || localStorage.getItem('token');
  const userId = localStorage.getItem('user_id') || localStorage.getItem('userId');
  const username = localStorage.getItem('username') || localStorage.getItem('userName');
  
  console.log('verifylogin.js - Verificando autenticación:', {
    userLoggedIn,
    estaLogueadoLocal,
    token,
    userId,
    username
  });
  
  if ((!userLoggedIn && !estaLogueadoLocal) || !token || !userId || !username) {
    console.log('Usuario no autenticado, redirigiendo al login');
    // Limpiar datos residuales
    sessionStorage.clear();
    localStorage.removeItem('userLoggedIn');
    localStorage.removeItem('user_id');
    localStorage.removeItem('userId');
    localStorage.removeItem('username');
    localStorage.removeItem('userName');
    localStorage.removeItem('token');
    
    window.location.href = 'login.html'; 
  } else {
    console.log('Usuario autenticado correctamente');
  }
}

function obtenerUsuario() {
  return sessionStorage.getItem('userName') || localStorage.getItem('userName') || 
         sessionStorage.getItem('username') || localStorage.getItem('username');
}

function obtenerToken() {
  return sessionStorage.getItem('token') || localStorage.getItem('token');
}

function obtenerUserId() {
  return localStorage.getItem('user_id') || localStorage.getItem('userId');
}