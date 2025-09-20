<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Explorar Proyectos</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
  <div class="flex flex-col min-h-screen bg-background">
    <!-- Header -->
    <header>
      <div class="container header-content">
        <a href="index" class="logo">Comunidad de Proyectos IT</a>
        <nav class="nav-desktop">
          <a href="#features">Beneficios</a>
          <a href="project-list">Explorar Proyectos</a>
          <a href="#join">Únete</a>
        </nav>
        <div class="header-actions">
          <a href="login" class="btn btn-primary"> Ingresar</a>
        </div>
      </div>
    </header>

<body>
      <!-- Project Detail Section -->
      <section id="project-detail" class="project-detail">
        <div class="container">
          <h2 class="project-detail-title">Cargando Detalles del Proyecto...</h2>
          <div class="project-detail-content" id="projectDetailContent">
            <!-- Project details will be loaded here via JavaScript -->
          </div>
        </div>
      </section>

    <!-- Footer -->
    <footer>
      <div>&copy; 2025 Comunidad de Proyectos IT. Todos los derechos reservados.</div>
      <div class="footer-nav">
        <a href="#">Términos de Servicio</a>
        <a href="#">Política de Privacidad</a>
        <a href="#">Contacto</a>
      </div>
    </footer>
  </div>
  <script src="public/js/project-detail.js"></script>
</body>
</html>
