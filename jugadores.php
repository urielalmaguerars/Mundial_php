<?php
include "conexion.php";
session_start();

// Aseguramos que el usuario esté logueado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

$id_usuario = $_SESSION['id_usuario'];

// Si se dio click en "like"
if (isset($_POST['like'])) {
    $id_publicacion = intval($_POST['id_publicacion']);

    // Revisar si el usuario ya dio like a esa publicación
    $check = $conn->prepare("SELECT * FROM likes WHERE id_publicacion = ? AND id_usuario = ?");
    $check->bind_param("ii", $id_publicacion, $id_usuario);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows == 0) {
        // Insertar nuevo like
        $stmt = $conn->prepare("INSERT INTO likes (id_publicacion, id_usuario) VALUES (?, ?)");
        $stmt->bind_param("ii", $id_publicacion, $id_usuario);
        $stmt->execute();
    }
}

// Consulta publicaciones con sus likes
$sql = "SELECT 
            p.id_publicacion,
            p.titulo,
            p.contenido,
            p.imagen,
            u.Nombre AS autor,
            COUNT(l.id) AS total_likes
        FROM publicacion p
        JOIN usuario u ON u.id_usuario = p.id_usuario
        LEFT JOIN likes l ON l.id_publicacion = p.id_publicacion
        GROUP BY p.id_publicacion, p.titulo, p.contenido, p.imagen, u.Nombre
        ORDER BY p.fecha_creacion DESC";


$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Jugadores - Publicaciones</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .publicacion {
            background: white;
            border-radius: 10px;
            box-shadow: 0px 2px 6px rgba(0,0,0,0.2);
            margin-bottom: 20px;
            padding: 15px;
        }
        .publicacion h3 {
            margin: 0;
            color: #4B0082;
        }
        .publicacion img {
            max-width: 100%;
            border-radius: 8px;
            margin-top: 10px;
        }
        .like-btn {
            background: #4B0082;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 10px;
        }
        .like-btn:hover {
            background: #6A0DAD;
        }
    </style>
</head>
<body>
    <h2>Publicaciones de jugadores</h2>

    <?php while($row = $result->fetch_assoc()): ?>
        <div class="publicacion">
            <h3><?php echo htmlspecialchars($row['titulo']); ?></h3>
            <p><b>Autor:</b> <?php echo htmlspecialchars($row['autor']); ?></p>
            <p><?php echo htmlspecialchars($row['contenido']); ?></p>
            <?php if (!empty($row['imagen'])): ?>
                <img src="<?php echo htmlspecialchars($row['imagen']); ?>" alt="Imagen publicación">
            <?php endif; ?>

            <form method="POST">
                <input type="hidden" name="id_publicacion" value="<?php echo $row['id_publicacion']; ?>">
                <button type="submit" name="like" class="like-btn">❤️ Me gusta (<?php echo $row['total_likes']; ?>)</button>
            </form>
        </div>
    <?php endwhile; ?>

</body>
</html>
