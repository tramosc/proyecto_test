<?php
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigo = $_POST['codigo'];
    $nombre = $_POST['nombre'];
    $bodega = $_POST['bodega'];
    $sucursal = $_POST['sucursal'];
    $moneda = $_POST['moneda'];
    $precio = $_POST['precio'];
    $materiales = implode(", ", $_POST['material']);
    $descripcion = $_POST['descripcion'];

    // Validaciones en el servidor
    if (empty($codigo) || !preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{5,15}$/', $codigo)) {
        die("El código del producto es inválido.");
    }
    if (empty($nombre) || strlen($nombre) < 2 || strlen($nombre) > 50) {
        die("El nombre del producto es inválido.");
    }
    if (!is_numeric($precio) || $precio <= 0) {
        die("El precio es inválido.");
    }
    if (empty($descripcion) || strlen($descripcion) < 10 || strlen($descripcion) > 1000) {
        die("La descripción es inválida.");
    }

    // Verificar unicidad del código
    $query = $conn->prepare("SELECT COUNT(*) FROM productos WHERE codigo = ?");
    $query->execute([$codigo]);
    if ($query->fetchColumn() > 0) {
        die("El código del producto ya está registrado.");
    }

    // Insertar el producto en la base de datos
    $stmt = $conn->prepare("INSERT INTO productos (codigo, nombre, bodega_id, sucursal_id, moneda_id, precio, materiales, descripcion) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$codigo, $nombre, $bodega, $sucursal, $moneda, $precio, $materiales, $descripcion]);

    echo "Producto registrado correctamente.";
}
?>
