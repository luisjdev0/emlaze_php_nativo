<?php
// Ajustes generales de la aplicación
require_once 'vendor/autoload.php';

// Cargar variables de entorno
use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__."/../");
$dotenv->load();

// Configuración de la base de datos
require_once 'includes/db.php';

//Redirigir al login si no hay sesión iniciada
session_start();
if (!isset($_SESSION['id']) && basename($_SERVER['PHP_SELF']) !== 'login.php') {
    header('Location: /login.php');
    exit();
}