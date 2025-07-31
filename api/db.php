<?php
// Configuración de la base de datos
$host = 'localhost';
$db = 'hackdash';
$user = 'root';
$pass = '';

function getConnection() {
    global $host, $db, $user, $pass;
    
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        throw new Exception("Error de conexión: " . $e->getMessage());
    }
}

// Conexión global para compatibilidad
try {
    $pdo = getConnection();
} catch (Exception $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>