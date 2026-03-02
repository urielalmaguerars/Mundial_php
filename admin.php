<?php
session_start();
include "conexion.php";

if (!isset($_SESSION['rol']) || $_SESSION['rol'] != 'admin') {
    header("Location: login.php");
    exit;
}

//Mandamos a llamar la vista 
$sql = "SELECT * FROM vw_publicaciones_pendientes ORDER BY fecha_creacion DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Panel Admin</title>
</head>
<body>
    <h2>Publicaciones Pendientes</h2>
    <a href="login.php">Cerrar sesión</a>
    <hr>
    <?php while ($row = $result->fetch_assoc()) { ?>
        <div style="border:1px solid black; margin:10px; padding:10px;">
            <h3><?php echo $row['titulo']; ?></h3>
            <p><?php echo $row['contenido']; ?></p>
            <?php if ($row['imagen']) { ?>
                <img src="uploads/<?php echo $row['imagen']; ?>" width="200">
            <?php } ?>
            <br>
            <a href="aprobar.php?id=<?php echo $row['id_publicacion']; ?>&accion=aprobar">Aprobar</a> |
            <a href="aprobar.php?id=<?php echo $row['id_publicacion']; ?>&accion=rechazar">Rechazar</a>
        </div>
    <?php } ?>
</body>
</html>
