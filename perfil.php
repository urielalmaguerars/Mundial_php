<?php
session_start();
include "conexion.php";

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}

$idUsuario = $_SESSION['id_usuario'];

$sql = "SELECT nombre, apellido, usuario, correo, fotografia FROM usuario WHERE id_usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $idUsuario);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();

$sqlLikes = "SELECT COUNT(*) as total FROM likes WHERE id_usuario = ?";
$stmt = $conn->prepare($sqlLikes);
$stmt->bind_param("i", $idUsuario);
$stmt->execute();
$result = $stmt->get_result();
$totalLikes = $result->fetch_assoc()['total'] ?? 0;

$sqlComentarios = "SELECT COUNT(*) as total FROM comentarios WHERE id_usuario = ?";
$stmt = $conn->prepare($sqlComentarios);
$stmt->bind_param("i", $idUsuario);
$stmt->execute();
$result = $stmt->get_result();
$totalComentarios = $result->fetch_assoc()['total'] ?? 0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil Mundial</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        html, body {
            height: 100%;
            background: linear-gradient(135deg, #0047AB, #FFD700); /* azul + dorado tipo mundial */
            font-family: 'Segoe UI', sans-serif;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .profile-card {
            width: 100%;
            max-width: 650px;
            min-height: 700px;
            padding: 25px;
            border-radius: 20px;
            background: rgba(255,255,255,0.95);
            box-shadow: 0 8px 20px rgba(0,0,0,0.3);
            display: flex;
            flex-direction: column;
            align-items: center;
            border-top: 6px solid #FFD700; /* dorado */
        }
        .profile-header {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .profile-img-container {
            width: 160px;
            height: 160px;
            border-radius: 50%;
            border: 4px solid #FFD700;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #eaeaea;
            margin-bottom: 15px;
            position: relative;
        }
        .profile-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .stats {
            display: flex;
            justify-content: space-around;
            width: 100%;
            margin-top: 20px;
        }
        .stats div {
            text-align: center;
        }
        .stats div h4 {
            color: #0047AB;
            font-size: 1.6rem;
        }
        .stats div p {
            color: #333;
            font-weight: bold;
        }
        .btn-custom {
            background: linear-gradient(90deg, #FFD700, #0047AB);
            color: #fff;
            border: none;
        }
        .btn-custom:hover {
            background: linear-gradient(90deg, #0047AB, #FFD700);
        }
    </style>
</head>
<body>
    <div class="profile-card">
        <div class="profile-header">
            <h2 class="mb-1"><i class="fa-solid fa-trophy"></i> Bienvenido, <?php echo htmlspecialchars($usuario['nombre']); ?></h2>
            <p class="text-muted">Usuario: <b><?php echo htmlspecialchars($usuario['usuario']); ?></b></p>
        </div>

        <!-- Imagen de perfil -->
<div class="profile-img-container">
    <img src="<?php echo htmlspecialchars($usuario['fotografia'] ?: 'uploads/default.png'); ?>"
         onerror="this.src='uploads/default.png'"
         class="profile-img" alt="Foto de perfil">
</div>

        <!-- Cambiar foto -->
        <form action="subir_foto.php" method="POST" enctype="multipart/form-data" class="mt-2 w-100 text-center">
            <input type="file" name="foto" class="form-control mb-2" required>
            <button type="submit" class="btn btn-custom w-50"><i class="fa-solid fa-image"></i> Cambiar foto</button>
        </form>

        <!-- Estadísticas -->
        <div class="stats mt-4">
            <div>
                <h4><?php echo $totalLikes; ?></h4>
                <p><i class="fa-solid fa-heart"></i> Likes dados</p>
            </div>
            <div>
                <h4><?php echo $totalComentarios; ?></h4>
                <p><i class="fa-solid fa-comments"></i> Comentarios</p>
            </div>
        </div>

        <!-- Botones -->
        <div class="mt-auto w-100">
            <a href="usuario.php" class="btn btn-danger w-100 mb-2"><i class="fa-solid"></i> Regresar al inicio</a>
            <a href="editar_perfil.php" class="btn btn-warning w-100 mb-2"><i class="fa-solid fa-user-pen"></i> Editar información</a>
            <a href="login.php" class="btn btn-danger w-100"><i class="fa-solid fa-right-from-bracket"></i> Cerrar sesión</a>
        </div>
    </div>
</body>
</html>
