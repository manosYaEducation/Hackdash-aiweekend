<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" href="public/css/user-view.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="profile-page-container">
        <main class="profile-content">
            <div class="profile-avatar-section">
                <div class="profile-avatar">
                    <i class="fas fa-user"></i>
                    <div class="edit-icon-overlay">
                        <i class="fas fa-pen"></i>
                    </div>
                </div>
            </div>

            <div class="profile-name-section">
                <label for="profileName" class="profile-label">Nombre del perfil</label>
                <input type="text" id="profileName" class="profile-input" value="Example...">
            </div>

            <div class="profile-actions">
                <button class="submit-button">Cancelar</button>
                <button class="submit-button">Guardar</button>
            </div>
            <div class="disconnect-section">
                <button class="submit-button">Desconectar</button>
            </div>
        </main>

        <?php require_once("components/nav.php"); ?>
    </div>

    <script src="public/css/user-view.js"></script>
</body>
</html>
