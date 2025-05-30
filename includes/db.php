<?php

// Conexión a base de datos con PDO

$host = $_ENV['DB_HOST'];
$db_name = $_ENV['DB_NAME'];
$user = $_ENV['DB_USER'];
$pass = $_ENV['DB_PASSWORD'];

$db = new PDO("mysql:host=$host;dbname=$db_name", $user, $pass);

function pdo_execute_query($query, $params = null) {
    global $db;
    $stmt = $db->prepare($query);
    var_dump($stmt->execute($params));
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}