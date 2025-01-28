<?php
// conexion.php
$host = "localhost";
$user = "root"; // Cambia este valor si tienes un usuario diferente
$password = ""; // Cambia este valor si tienes contraseña configurada
$dbname = "sistema_productos";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
    exit;
}
?>
