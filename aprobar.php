<?php
include "conexion.php";

$id = $_GET['id'];
$accion = $_GET['accion'];

if ($accion == "aprobar") {
    $sql = "UPDATE publicacion SET estado='aprobada' WHERE id_publicacion=$id";
} else {
    $sql = "UPDATE publicacion SET estado='rechazada' WHERE id_publicacion=$id";
}


$conn->query($sql);
header("Location: admin.php");
?>
