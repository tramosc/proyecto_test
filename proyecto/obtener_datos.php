<?php
require 'conexion.php';

if (isset($_GET['type'])) {
    $type = $_GET['type'];
    switch ($type) {
        case 'bodegas':
            $query = $conn->query("SELECT id, nombre FROM bodegas");
            echo json_encode($query->fetchAll(PDO::FETCH_ASSOC));
            break;
        case 'sucursales':
            $bodega_id = $_GET['bodega_id'] ?? 0;
            $query = $conn->prepare("SELECT id, nombre FROM sucursales WHERE bodega_id = ?");
            $query->execute([$bodega_id]);
            echo json_encode($query->fetchAll(PDO::FETCH_ASSOC));
            break;
        case 'monedas':
            $query = $conn->query("SELECT id, nombre FROM monedas");
            echo json_encode($query->fetchAll(PDO::FETCH_ASSOC));
            break;
    }
}
?>
