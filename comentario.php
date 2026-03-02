<?php
session_start();
include "conexion.php";

// Verificar que el usuario haya iniciado sesión
if (!isset($_SESSION['id_usuario'])) {
    die("Debes iniciar sesión.");
}

$id_usuario = $_SESSION['id_usuario'];
$id_publicacion = intval($_POST['id_publicacion']);
$comentario = trim($_POST['comentario']);

if ($comentario != "") {
    $sql = "INSERT INTO comentarios (id_publicacion, id_usuario, comentario) VALUES (?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $id_publicacion, $id_usuario, $comentario);
    $stmt->execute();
}

// Redirigir de regreso al usuario
header("Location: publicacion.php");
exit;
