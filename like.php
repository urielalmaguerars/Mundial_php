<?php
session_start();
include "conexion.php";

if (!isset($_SESSION['id_usuario'])) {
    die("Debes iniciar sesión.");
}

$id_usuario = $_SESSION['id_usuario'];
$id_publicacion = intval($_POST['id_publicacion']);

// Revisar si ya dio like
$sql = "SELECT * FROM likes WHERE id_usuario=? AND id_publicacion=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $id_usuario, $id_publicacion);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Quitar like
    $sql = "DELETE FROM likes WHERE id_usuario=? AND id_publicacion=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id_usuario, $id_publicacion);
    $stmt->execute();
} else {
    // Dar like
    $sql = "INSERT INTO likes (id_publicacion, id_usuario) VALUES (?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id_publicacion, $id_usuario);
    $stmt->execute();
}

// Contar likes actualizados
$sql = "SELECT COUNT(*) as total FROM likes WHERE id_publicacion=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_publicacion);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

echo $row['total']; // 👈 devolvemos solo el número actualizado
