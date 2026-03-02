<?php
session_start();
include "conexion.php";

// Verificar login
if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'usuario') {
    header("Location: login.php");
    exit;
}

// Publicaciones con más likes (TOP 10)
$sql = "SELECT p.*, COUNT(l.id_like) as total_likes
        FROM publicacion p
        LEFT JOIN likes l ON p.id_publicacion = l.id_publicacion
        WHERE p.estado='aprobada'
        GROUP BY p.id_publicacion
        ORDER BY total_likes DESC
        LIMIT 10";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>⭐ Mejores Jugadas</title>
<link rel="stylesheet" href="styles.css"> <!-- reutiliza tu CSS -->
</head>
<body>
<header>
    <h2>⭐ Mejores Jugadas</h2>
    <nav>
        <a href="usuario.php">🏠 Inicio</a>
        <a href="jugadores.php">👥 Jugadores</a>
        <a href="perfil.php">🙍 Perfil</a>
        <a href="login.php">🚪 Cerrar sesión</a>
    </nav>
</header>

<div class="container">
<?php if ($result->num_rows > 0): ?>
    <?php while ($row = $result->fetch_assoc()): ?>
        <div class="post">
            <h3><?php echo htmlspecialchars($row['titulo']); ?> ⭐</h3>
            <p><?php echo nl2br(htmlspecialchars($row['contenido'])); ?></p>
            <p><b>Likes:</b> <?php echo $row['total_likes']; ?> 👍</p>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <p>No hay jugadas destacadas aún 🚀</p>
<?php endif; ?>
</div>
</body>
</html>
