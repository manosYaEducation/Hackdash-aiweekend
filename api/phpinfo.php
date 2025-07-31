<?php
// Archivo para verificar la configuración de PHP
// Acceder a: http://localhost/Hackdash-aiweekend/api/phpinfo.php

// Mostrar información básica de PHP
echo "<h1>Información de PHP</h1>";
echo "<p><strong>Versión de PHP:</strong> " . PHP_VERSION . "</p>";
echo "<p><strong>Servidor:</strong> " . $_SERVER['SERVER_SOFTWARE'] . "</p>";
echo "<p><strong>Document Root:</strong> " . $_SERVER['DOCUMENT_ROOT'] . "</p>";

// Verificar extensiones importantes
echo "<h2>Extensiones Verificadas</h2>";
$extensions = ['pdo', 'pdo_mysql', 'json'];
foreach ($extensions as $ext) {
    $loaded = extension_loaded($ext) ? "✅ Cargada" : "❌ No cargada";
    echo "<p><strong>$ext:</strong> $loaded</p>";
}

// Verificar configuración de errores
echo "<h2>Configuración de Errores</h2>";
echo "<p><strong>display_errors:</strong> " . (ini_get('display_errors') ? 'On' : 'Off') . "</p>";
echo "<p><strong>error_reporting:</strong> " . ini_get('error_reporting') . "</p>";

// Verificar si podemos conectar a MySQL
echo "<h2>Prueba de Conexión MySQL</h2>";
try {
    $pdo = new PDO("mysql:host=localhost;dbname=hackdash", "root", "");
    echo "<p>✅ Conexión a MySQL exitosa</p>";
    
    // Verificar tablas
    $tables = ['dashboards', 'projects'];
    foreach ($tables as $table) {
        $stmt = $pdo->query("SHOW TABLES LIKE '$table'");
        $exists = $stmt->rowCount() > 0 ? "✅ Existe" : "❌ No existe";
        echo "<p><strong>Tabla $table:</strong> $exists</p>";
    }
} catch (PDOException $e) {
    echo "<p>❌ Error de conexión MySQL: " . $e->getMessage() . "</p>";
}

// Mostrar información completa de PHP (opcional)
if (isset($_GET['full'])) {
    phpinfo();
}
?> 