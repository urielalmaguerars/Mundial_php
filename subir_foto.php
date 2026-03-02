<?php
session_start();
include "conexion.php";

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}

$idUsuario = $_SESSION['id_usuario'];

if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {

    $foto = $_FILES['foto'];
    $nombreTemp = $foto['tmp_name'];

    // Verificar y crear carpeta si no existe
    $carpetaDestino = "fotos_perfil/";
    if (!is_dir($carpetaDestino)) {
        mkdir($carpetaDestino, 0777, true);
    }

    // Extensión original del archivo
    $extension = strtolower(pathinfo($foto['name'], PATHINFO_EXTENSION));

    // Validar formato permitido
    $permitidos = ['jpg', 'jpeg', 'png'];
    if (!in_array($extension, $permitidos)) {
        echo "<script>alert('Solo se permiten imágenes JPG o PNG'); window.location='perfil.php';</script>";
        exit;
    }

    // Nombre final de la imagen
    $nombreArchivo = "perfil_" . $idUsuario . ".jpg";
    $rutaDestino = $carpetaDestino . $nombreArchivo;

    // Mover la imagen
    if (move_uploaded_file($nombreTemp, $rutaDestino)) {
        // Actualizar la ruta en la base de datos
        $sql = "UPDATE usuario SET fotografia = ? WHERE id_usuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $rutaDestino, $idUsuario);

        if ($stmt->execute()) {
            echo "<script>alert('Foto de perfil actualizada correctamente'); window.location='perfil.php';</script>";
        } else {
            echo "<script>alert('Error al guardar la ruta en la base de datos'); window.location='perfil.php';</script>";
        }

        exit;
    } else {
        echo "<script>alert('Error al mover la imagen al servidor'); window.location='perfil.php';</script>";
        exit;
    }

} else {
    echo "<script>alert('No se seleccionó ninguna imagen'); window.location='perfil.php';</script>";
    exit;
}
?>
