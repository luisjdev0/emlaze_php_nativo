<?php
ob_start();
require_once 'config/config.php';

//Peticiones GET para obtener los todos los productos o uno por SKU
if (isset($_GET['request'])) {
    $result = [];

    switch ($_GET['request']) {
        case 'get_products':
            $result = pdo_execute_query("SELECT * FROM productos");
            break;
        case 'by_sku':
            $result = pdo_execute_query("SELECT * FROM productos WHERE sku = ?", [$_GET['sku']])[0];
    }

    ob_clean();
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode($result);
    exit;
}

// Manejo de peticiones POST para crear o actualizar productos
if (isset($_POST['sku'], $_POST['nombre'], $_POST['descripcion'], $_POST['cantidad'], $_POST['precio'], $_POST['total'])) {
    $sku = $_POST['sku'];
    $nombre = $_POST['nombre'];
    $cantidad = $_POST['cantidad'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $total = $_POST['total'];

    if (isset($_POST['id'])) {
        $result = pdo_execute_query("UPDATE productos SET sku = ?, nombre = ?, descripcion = ?, cantidad = ?, precio = ?, total = ? WHERE id = ?", [
            $sku,
            $nombre,
            $descripcion,
            $cantidad,
            $precio,
            $total,
            $_POST['id']
        ]);
    } else {
        $result = pdo_execute_query("INSERT INTO productos (sku, nombre, descripcion, cantidad, precio, total) VALUES (?, ?, ?, ?, ?, ?)", [
            $sku,
            $nombre,
            $descripcion,
            $cantidad,
            $precio,
            $total
        ]);
    }

    ob_clean();
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode($result);
    exit;
}

// Manejo de petición para eliminar productos
if (isset($_POST['delete_sku'])) {
    $result = pdo_execute_query("DELETE FROM productos WHERE sku = ?", [$_POST['delete_sku']]);
    ob_clean();
    header('Content-Type: application/json; charset=UTF-8');
    echo json_encode($result);
    exit;
}
