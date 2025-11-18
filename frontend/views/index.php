<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Comunidad de Proyectos IT</title>
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
          <a href="#projects">Explorar Proyectos</a>
          <a href="#join">Únete</a>
        </nav>
        <div class="header-actions">
          <a href="login" class="btn btn-primary"> Ingresar</a>
        </div>
      </div>
    </header>

    <main>
      <!-- Hero Section -->
      <section class="hero">
        <!-- SVG Blobs decorativos -->
        <svg class="hero-blob blob1" viewBox="0 0 400 400" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill="#22c55e" d="M320,60Q340,120,300,180Q260,240,200,260Q140,280,100,220Q60,160,100,100Q140,40,200,60Q260,80,320,60Z"/>
        </svg>
        <svg class="hero-blob blob2" viewBox="0 0 400 400" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill="#166534" d="M320,60Q340,120,300,180Q260,240,200,260Q140,280,100,220Q60,160,100,100Q140,40,200,60Q260,80,320,60Z"/>
        </svg>
        <div class="container">
          <div class="max-w-3xl mx-auto space-y-4">
            <h1>Hackdash: Gestión de Proyectos IT</h1>
            <p>
              Plataforma moderna para gestionar proyectos de desarrollo. Organiza tareas, colabora con tu equipo y visualiza el progreso en tiempo real.
            </p>
            <div class="hero-actions">
              <a href="login" class="btn btn-white">Iniciar dashboard</a>
            </div>
          </div>
        </div>
      </section>

      <!-- Features Section -->
      <section id="features" class="features">
        <div class="container">
          <div class="features-title">¿Qué ofrece Hackdash?</div>
          <div class="features-desc">
            Una plataforma completa para la gestión de proyectos de desarrollo con herramientas modernas y colaborativas.
          </div>
          <div class="features-grid">
            <div class="feature-card">
              <i class="fas fa-tasks"></i>
              <div class="feature-title">Gestión de Tareas</div>
              <div class="feature-desc">Crea, edita y organiza tareas con estados personalizables y seguimiento de progreso en tiempo real.</div>
            </div>
            <div class="feature-card">
              <i class="fas fa-chart-line"></i>
              <div class="feature-title">Dashboard Intuitivo</div>
              <div class="feature-desc">Visualiza el progreso de tus proyectos con barras de progreso y estadísticas detalladas.</div>
            </div>
            <div class="feature-card">
              <i class="fas fa-users-cog"></i>
              <div class="feature-title">Colaboración en Equipo</div>
              <div class="feature-desc">Invita miembros, asigna tareas y mantén comunicación fluida con tu equipo de desarrollo.</div>
            </div>
            <div class="feature-card">
              <i class="fas fa-folder-open"></i>
              <div class="feature-title">Gestión de Archivos</div>
              <div class="feature-desc">Sube y organiza archivos del proyecto con un sistema de gestión integrado y accesible.</div>
            </div>
          </div>
        </div>
      </section>

      <!-- Call to Action Section -->
      <section id="join" class="join">
        <div class="container">
          <div class="join-title">¿Listo para optimizar tu gestión de proyectos?</div>
          <div class="join-desc">
            Accede a Hackdash y comienza a organizar tus proyectos de desarrollo de manera eficiente.
          </div>
          <div class="join-actions">
            <a href="login" class="btn btn-primary">Acceder a Hackdash</a>
            <a href="blank" class="btn btn-outline">Ver Dashboards</a>
          </div>
        </div>
      </section>
    </main>

    <!-- Footer -->
    <footer>
      <div>&copy; 2025 Comunidad de Proyectos IT. Todos los derechos reservados.</div>
      <div class="footer-nav">
        <a href="#">Términos de Servicio</a>
        <a href="#">Política de Privacidad</a>
        <a href="#">Contacto</a>


        <p>Versión 0.1 

        Jose de las perdices
        laura gen 16

        </p>
      </div>
    </footer>
  </div>
</body>
</html>
