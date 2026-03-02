<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = "localhost";
$user = "root";
$pass = "";
$bd   = "bdm_2";
$port = "3307"; // Cambia a 3306 si usas el puerto por defecto

$conn = new mysqli($host, $user, $pass, $bd, $port);

if ($conn->connect_errno) {
    echo "Failed to connect DB: " . $conn->connect_errno;
} else {
    //echo "Conexión exitosa a la DB";
}
?>
