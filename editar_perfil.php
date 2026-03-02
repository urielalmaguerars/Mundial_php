<?php
session_start();
include "conexion.php";

// Verificar que el usuario esté logueado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}

$id_usuario = $_SESSION['id_usuario'];

// Obtener datos actuales del usuario
$sql = "SELECT nombre, apellido, fecha_nacimiento, usuario, correo, fotografia FROM usuario WHERE id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();

// Procesar actualización
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $nombreUsuario = trim($_POST['usuario']);
    $fecha_actual = new DateTime();
    $fecha_nac = new DateTime($fecha_nacimiento);
    $edad = $fecha_actual->diff($fecha_nac)->y;

    if ($edad < 21) {
        echo "<script>alert('⚠️ Debes tener al menos 21 años.'); window.history.back();</script>";
        exit;
    }
    $correo = trim($_POST['correo']);
    $contrasena = !empty($_POST['contrasena']) ? password_hash($_POST['contrasena'], PASSWORD_DEFAULT) : null;

    // Manejo de foto
    $fotoPath = $usuario['fotografia'];
    if (!empty($_FILES['fotografia']['name'])) {
        $targetDir = "uploads/";
        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);
        $nombreArchivo = time() . "_" . basename($_FILES['fotografia']['name']);
        $rutaArchivo = $targetDir . $nombreArchivo;
        $ext = strtolower(pathinfo($rutaArchivo, PATHINFO_EXTENSION));
        $permitidos = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($ext, $permitidos)) {
            if (move_uploaded_file($_FILES['fotografia']['tmp_name'], $rutaArchivo)) {
                $fotoPath = $rutaArchivo;
            }
        }
    }

    // Actualizar datos
    if ($contrasena) {
        $sql = "UPDATE usuario SET nombre=?, apellido=?, fecha_nacimiento=?, usuario=?, correo=?, contrasena=?, fotografia=? WHERE id_usuario=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssi", $nombre, $apellido, $fecha_nacimiento, $nombreUsuario, $correo, $contrasena, $fotoPath, $id_usuario);
    } else {
        $sql = "UPDATE usuario SET nombre=?, apellido=?, fecha_nacimiento=?, usuario=?, correo=?, fotografia=? WHERE id_usuario=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $nombre, $apellido, $fecha_nacimiento, $nombreUsuario, $correo, $fotoPath, $id_usuario);
    }

    if ($stmt->execute()) {
        echo "<script>alert('✅ Perfil actualizado correctamente'); window.location='usuario.php';</script>";
    } else {
        echo "❌ Error al actualizar: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Editar Perfil</title>
<style>
    /* Fondo moderno con patrón dorado suave */
    body {
        margin: 0;
        font-family: "Poppins", sans-serif;
        background: linear-gradient(135deg, #0d1b2a, #1b263b, #415a77);
        color: #fff;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        overflow: hidden;
    }

    /* Contenedor principal */
    .profile-container {
        position: relative;
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        width: 90%;
        max-width: 650px;
        padding: 40px;
        box-shadow: 0 0 40px rgba(255, 215, 0, 0.1);
    }

    /* Círculo decorativo */
    .glow-circle {
        position: absolute;
        width: 180px;
        height: 180px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(255,215,0,0.4), transparent 70%);
        top: -60px;
        right: -60px;
        z-index: 0;
    }

    h2 {
        text-align: center;
        margin-bottom: 25px;
        font-size: 26px;
        background: linear-gradient(90deg, #FFD700, #0047AB);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: bold;
        position: relative;
        z-index: 1;
    }

    .profile-img {
        width: 130px;
        height: 130px;
        border-radius: 50%;
        border: 3px solid #FFD700;
        object-fit: cover;
        display: block;
        margin: 0 auto 20px;
        box-shadow: 0 0 20px rgba(255, 215, 0, 0.3);
    }

    label {
        display: block;
        font-weight: 500;
        margin-top: 12px;
        color: #eee;
        font-size: 14px;
        letter-spacing: 0.3px;
    }

    input[type="text"], input[type="email"], input[type="password"], input[type="file"] {
        width: 100%;
        padding: 12px;
        border-radius: 10px;
        border: none;
        margin-top: 6px;
        background: rgba(255, 255, 255, 0.15);
        color: #fff;
        outline: none;
        font-size: 15px;
        transition: background 0.3s, box-shadow 0.3s;
    }

    input:focus {
        background: rgba(255, 255, 255, 0.25);
        box-shadow: 0 0 10px rgba(255, 215, 0, 0.3);
    }

    .btn-save {
        width: 100%;
        margin-top: 25px;
        padding: 12px;
        font-size: 16px;
        font-weight: bold;
        color: #0d1b2a;
        background: linear-gradient(90deg, #FFD700, #f4e04d);
        border: none;
        border-radius: 50px;
        cursor: pointer;
        transition: transform 0.2s, box-shadow 0.3s;
    }

    .btn-save:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 20px rgba(255, 215, 0, 0.5);
    }

    .back-link {
        display: block;
        text-align: center;
        margin-top: 18px;
        color: #FFD700;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.3s;
    }

    .back-link:hover {
        color: #fff;
    }
</style>
</head>
<body>

<div class="profile-container">
    <div class="glow-circle"></div>
    <h2>Editar Perfil</h2>

    <?php if (!empty($usuario['fotografia'])): ?>
        <img src="<?= htmlspecialchars($usuario['fotografia']) ?>" class="profile-img" alt="Foto de perfil">
    <?php else: ?>
        <img src="default.png" class="profile-img" alt="Sin foto">
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <label>Nombre:</label>
        <input type="text" name="nombre" value="<?= htmlspecialchars($usuario['nombre']) ?>" required>

        <label>Apellido:</label>
        <input type="text" name="apellido" value="<?= htmlspecialchars($usuario['apellido']) ?>">

        <label>Fecha nacimiento:</label>
        <input type="date" name="fecha_nacimiento" value="<?= htmlspecialchars($usuario['fecha_nacimiento']) ?>">

        <label>Usuario:</label>
        <input type="text" name="usuario" value="<?= htmlspecialchars($usuario['usuario']) ?>" required>

        <label>Correo:</label>
        <input type="email" name="correo" value="<?= htmlspecialchars($usuario['correo']) ?>" required>

        <label>Nueva Contraseña (opcional):</label>
        <input type="password" name="contrasena" placeholder="Deja en blanco si no deseas cambiarla">

        <button type="submit" class="btn-save"> Guardar Cambios</button>
    </form>

    <a href="usuario.php" class="back-link">⬅ Volver al Inicio</a>
</div>

</body>
</html>
