<?php
include "conexion.php";

if(isset($_POST['query'])){
    $busqueda = $conn->real_escape_string($_POST['query']);

    $sql = "SELECT id_usuario, nombre, fotografia 
            FROM usuario
            WHERE nombre LIKE '%$busqueda%'
            LIMIT 10";

    $result = $conn->query($sql);

    if($result->num_rows > 0){
        while($u = $result->fetch_assoc()){
            $foto = $u['fotografia'] ?? "default.png";

            echo "
            <li class='resultado-item'
                onclick=\"window.location='perfil_publico.php?id={$u['id_usuario']}'\">
                <img src='uploads/$foto'>
                <span>{$u['nombre']}</span>
            </li>";
        }
    } else {
        echo "<li class='no-resultados'>Sin resultados</li>";
    }
}
?>
