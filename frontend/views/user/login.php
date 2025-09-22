<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de sesión</title>
    <link rel="stylesheet" href="public/css/user-view.css">
</head>
<body>


    <!-- Form Section -->
    <section class="form-section">
        <div class="form-container">
            <h1 class="form-title">Inicio de sesión</h1>
            <form class="capitals-form" id="capitalsForm">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Ingresa tu correo" required>
                </div>
                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" placeholder="Ingresa una contraseña" min="1" required>
                </div>
                <button type="submit" class="submit-button">Iniciar Sesión</button>
            </form>
            <p class="form-link">
                ¿No tienes cuenta? <a href="register">Regístrate aquí</a>
            </p>
        </div>
    </section>

    <?php require_once("components/nav.php"); ?>
    
    <script src="public/js/user-view.js"></script>
</body>
</html>