<?php 
session_start();
include "conexion.php";

// Verificar login
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $id_usuario = $_SESSION['id_usuario'];
    $titulo = trim($_POST['titulo']);
    $contenido = trim($_POST['contenido']);
    $id_categoria = intval($_POST['id_categoria']);

    // === LEER ARCHIVOS Y GUARDARLOS COMO BLOB ===
    $imagenesBlob = [];

    if (!empty($_FILES['archivos']['name'][0])) {

        foreach ($_FILES['archivos']['tmp_name'] as $key => $tmp_name) {

            if ($tmp_name == "") continue;

            $imagenBinaria = file_get_contents($tmp_name);

            $tipoArchivo = strtolower(pathinfo($_FILES['archivos']['name'][$key], PATHINFO_EXTENSION));

            $imagenesBlob[] = [
                "binario" => $imagenBinaria,
                "tipo" => $tipoArchivo
            ];
        }
    }

    // === INSERTAR PUBLICACIÓN SIN IMAGEN, SOLO TEXTO ===
    $stmt = $conn->prepare("
        INSERT INTO publicacion (id_usuario, id_categoria, titulo, contenido, estado)
        VALUES (?, ?, ?, ?, 'pendiente')
    ");
    $stmt->bind_param("iiss", $id_usuario, $id_categoria, $titulo, $contenido);

    if ($stmt->execute()) {

        $id_publicacion = $stmt->insert_id;

        // === GUARDAR CADA IMAGEN EN TABLA publicacion_imagen ===
        if (!empty($imagenesBlob)) {

            $stmtImg = $conn->prepare("
                INSERT INTO publicacion_imagen (id_publicacion, imagen, tipo)
                VALUES (?, ?, ?)
            ");

            foreach ($imagenesBlob as $img) {
                $stmtImg->bind_param("iss", $id_publicacion, $img["binario"], $img["tipo"]);
                $stmtImg->send_long_data(1, $img["binario"]);
                $stmtImg->execute();
            }
        }

        echo "<script>
            alert('✅ Tu publicación está siendo revisada por el administrador.');
            window.location.href = 'usuario.php';
        </script>";
        exit;

    } else {
        echo "<script>
            alert('❌ Error al subir tu publicación: " . addslashes($conn->error) . "');
            window.history.back();
        </script>";
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Subir Publicación</title>

<style>
:root {
    --blanco: #ffffff;
    --gris: #f5f5f7;
    --negro: #111111;
    --azul: #0071e3;
    --rojo: #e63946;
    --verde: #2a9d8f;
}

*{margin:0; padding:0; box-sizing:border-box;}

body {
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    background: var(--blanco);
    color: var(--negro);
}

/* Header */
header {
    background: rgba(255,255,255,0.9);
    backdrop-filter: blur(12px);
    position: sticky;
    top: 0;
    display: flex;
    justify-content: center;
    gap: 40px;
    padding: 15px 30px;
    border-bottom: 1px solid #ddd;
    z-index: 1000;
}
header a {
    text-decoration: none;
    color: var(--negro);
    font-weight: 500;
    font-size: 16px;
    transition: color 0.3s ease;
    background: linear-gradient(90deg, #2A398D, #E61D25, #3CAC3B);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
header a:hover { color: var(--azul); }

/* Card formulario */
.form-card {
    background: #fafafa;
    max-width: 700px;
    margin: 60px auto;
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
}
.form-card h2 {
    text-align: center;
    margin-bottom: 25px;
    font-size: 24px;
    background: linear-gradient(90deg, #3CAC3B, #2A398D, #E61D25);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
label {
    font-weight: 500;
    margin: 12px 0 6px;
    display: block;
}
input[type="text"], textarea, input[type="file"], select {
    width: 100%;
    padding: 12px;
    border: 2px solid #ddd;
    border-radius: 12px;
    margin-bottom: 18px;
    font-size: 15px;
    transition: all .3s ease;
}
input:focus, textarea:focus, select:focus {
    border-color: var(--azul);
    box-shadow: 0 0 8px rgba(0,113,227,0.3);
    outline: none;
}
textarea { min-height: 120px; resize: vertical; }

/* Botón */
button {
    width: 100%;
    background: var(--azul);
    color: var(--blanco);
    padding: 14px;
    border: none;
    border-radius: 30px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.3s ease;
}
button:hover {
    background: var(--verde);
    transform: scale(1.05);
}

.volver {
    display: block;
    text-align: center;
    margin-top: 20px;
    font-weight: bold;
    color: var(--rojo);
    text-decoration: none;
}
.volver:hover { color: var(--azul); }

</style>
</head>
<body>

<!-- Header -->
<header>
    <a href="usuario.php">Inicio</a>
    <a href="login.php">Cerrar sesión</a>
</header>

<!-- Formulario -->
<div class="form-card">
    <h2>Crear Nueva Publicación</h2>

    <form method="POST" enctype="multipart/form-data">

        <label for="titulo">Título:</label>
        <input type="text" name="titulo" required>

        <label for="contenido">Contenido / Descripción:</label>
        <textarea name="contenido" required></textarea>

        <label for="categoria">Seleccionar categoría:</label>
        <select name="id_categoria" required>
            <option value="">-- Selecciona una categoría --</option>
            <?php
            $categorias = $conn->query("SELECT * FROM categoria ORDER BY nombre_categoria ASC");
            while ($cat = $categorias->fetch_assoc()) {
                echo "<option value='{$cat['id_categoria']}'>{$cat['nombre_categoria']}</option>";
            }
            ?>
        </select>

        <label for="archivos">Seleccionar imágenes o videos:</label>
        <input type="file" name="archivos[]" multiple>

        <button type="submit">Subir Publicación</button>
    </form>

    <a href="usuario.php" class="volver">⬅ Volver al Inicio</a>
</div>

</body>
</html>
