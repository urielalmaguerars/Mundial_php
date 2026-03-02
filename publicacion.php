<?php
session_start();
include "conexion.php";

// Verificar si el usuario está logueado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}

// Parámetros de búsqueda
$buscar = isset($_GET['buscar']) ? $conn->real_escape_string($_GET['buscar']) : '';
$categoria = isset($_GET['categoria']) ? intval($_GET['categoria']) : 0;

// Condiciones de búsqueda
$condiciones = "p.estado = 'aprobada'";
if (!empty($buscar)) {
    $condiciones .= " AND (p.titulo LIKE '%$buscar%' OR p.contenido LIKE '%$buscar%')";
}
if ($categoria > 0) {
    $condiciones .= " AND p.id_categoria = $categoria";
}

// Consulta principal
$sql = "SELECT p.*, 
               u.nombre, u.apellido, u.usuario, u.fotografia,
               c.nombre_categoria
        FROM publicacion p
        INNER JOIN usuario u ON p.id_usuario = u.id_usuario
        LEFT JOIN categoria c ON p.id_categoria = c.id_categoria
        WHERE $condiciones
        ORDER BY p.fecha_creacion DESC";

$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Publicaciones de Usuarios</title>
    <link rel="stylesheet" href="style.css">
    <!-- Bootstrap CSS para carrusel -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #2a9d8f, #1f776d, #00aaff);
            color: #fff;
            margin: 0;
            padding: 0;
        }

        /* Header */
        header {
            background: rgba(255, 255, 255, 0.2); /* Transparencia blanca suave */
            backdrop-filter: blur(12px);
            position: sticky;
            top: 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 5px 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.3); /* Línea suave */
            z-index: 1000;
            height: 60px;
            transition: background 0.3s ease, backdrop-filter 0.3s ease;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .header-left img {
            position: relative;
            z-index: 10; /* Para que sobresalga */
            width: 80px;
            height: auto;
            border-radius: 10px;
            transform: translateY(15px); /* Lo levanta un poco */
            box-shadow: 0px 4px 15px rgba(0,0,0,0.3); /* Da efecto de relieve */
        }
        .nav-links {
            display: flex;
            gap: 35px;
            align-items: center;
        }
        .nav-links a {
            text-decoration: none;
            color: white;
            font-weight: bold;
            transition: color 0.3s;
        }
        .nav-links a:hover {
            color: white;
        }
     
        header a {
            text-decoration: none;
            font-weight: 600;
            font-size: 16px;
            transition: all 0.3s ease;
            background: linear-gradient(90deg, #ffcc00);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        header a:hover {
            text-shadow: 0.5px 0.5px 2px rgba(255, 255, 255, 0.46);
        }

        .titulo-contenedor {
            font-size: 60px;
            font-family: 'tittle', sans-serif;
            text-align: center;
            margin-bottom: 30px;
            background: linear-gradient(90deg, #ffcc00, white, red);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            grid-column: 1 / -1; /* ocupa toda la fila del grid */
        }


        .contenedor {
            width: 90%;
            max-width: 1200px;
            margin: 30px auto;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 25px;
        }

        .tarjeta {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .tarjeta:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
        }

        .tarjeta .contenido {
            padding: 15px;
        }

        .tarjeta h3 {
            margin-top: 0;
            font-size: 1.2rem;
            color: #ffcc00;
        }

        .tarjeta p {
            font-size: 0.95rem;
            color: #e0e0e0;
            margin: 10px 0;
        }

        .usuario {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 15px;
        }

        .usuario img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #fff;
        }

        .usuario span {
            font-size: 0.9rem;
            color: #fff;
        }

        footer {
            text-align: center;
            padding: 20px;
            background: rgba(0, 0, 0, 0.3);
            margin-top: 40px;
            color: #ccc;
        }

        /* Ajustes carrusel dentro de tarjeta */
        .carousel-inner img {
            height: 200px;
            object-fit: cover;
        }

        .carousel-indicators [data-bs-target] {
            background-color: #ffcc00;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            filter: invert(1);
        }



        
        /* Likes y comentarios */
        .like-btn {
            border: solid 0.5px;
            border-radius: 25px;
            padding: 10px 20px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 15px;
            transition: all 0.3s ease;
        }
        .like-btn:hover {
            background: #b22234;
            transform: scale(1.05);
        }
        h4 {
            margin-top: 20px;
            color: var(--azul);
            border-bottom: 2px solid var(--azul);
            padding-bottom: 5px;
        }
        textarea {
            width: 100%;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 10px;
            margin-top: 10px;
            resize: none;
            font-family: inherit;
        }
        .comment-btn {
            background: var(--verde);
            color: var(--blanco);
            border: solid 0.5px;
            border-radius: 25px;
            padding: 10px 20px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
            transition: all 0.3s ease;
        }
        .comment-btn:hover {
            background: #f5d450ff;
            transform: scale(1.05);
        }



/* Tipos de letras */
@font-face{
    font-family:'tittle';
    src: url(fonts/Tourney/Tourney-VariableFont_wdth,wght.ttf);
    font-weight:normal;
    font-style:normal;
}

@font-face{
    font-family:'tittle2';
    src: url(fonts/Bebas_Neue/BebasNeue-Regular.ttf);
    font-weight:normal;
    font-style:normal;
}

@font-face{
    font-family:'text';
    src: url(fonts/Work_Sans/WorkSans-Italic-VariableFont_wght.ttf);
    font-weight:normal;
    font-style:normal;
}

    </style>
</head>
<body>

<!-- Header -->
<header>
    <!-- Logo -->
    <div class="header-left">
        <img src="mundial_mascotas.png" alt="Mundial 2026" class="logo-mascota">
    </div>

    <form method="GET" style="display:flex; gap:10px; align-items:center;">
    <input type="text" name="buscar" placeholder="Buscar publicaciones..." 
           value="<?php echo isset($_GET['buscar']) ? htmlspecialchars($_GET['buscar']) : ''; ?>" 
           style="padding:8px; border-radius:8px; border:1px solid #ccc; width:250px;">

    <select name="categoria" style="padding:8px; border-radius:8px; border:1px solid #ccc;">
        <option value="">-- Todas las categorías --</option>
        <?php
        $categorias = $conn->query("SELECT * FROM categoria ORDER BY nombre_categoria ASC");
        while ($cat = $categorias->fetch_assoc()) {
            $selected = (isset($_GET['categoria']) && $_GET['categoria'] == $cat['id_categoria']) ? "selected" : "";
            echo "<option value='{$cat['id_categoria']}' $selected>{$cat['nombre_categoria']}</option>";
        }
        ?>
    </select>

    <button type="submit" 
            style="padding:8px 16px; background:#2A398D; color:white; border:none; border-radius:8px; cursor:pointer;">
        🔍 Buscar
    </button>
</form>


    <!-- Opciones -->
    <nav class="nav-links">
        <a href="usuario.php">Volver a Inicio</a>

    </nav>
</header>

<div class="contenedor">
    <h2 class="titulo-contenedor">Highlights del Mundial</h2>
    <?php
if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {

        $fotografia = !empty($row['fotografia']) ? $row['fotografia'] : 'img/default_user.png';
        $id_publicacion = intval($row['id_publicacion']);

        // ==========================================================
        // OBTENER IMÁGENES NUEVAS (BLOB)
        // ==========================================================
        $stmtImg = $conn->prepare("
            SELECT imagen, tipo 
            FROM publicacion_imagen
            WHERE id_publicacion = ?
        ");
        $stmtImg->bind_param("i", $id_publicacion);
        $stmtImg->execute();
        $resImg = $stmtImg->get_result();

        $imagenes_blob = [];
        while ($img = $resImg->fetch_assoc()) {
            $base64 = base64_encode($img["imagen"]);
            $imagenes_blob[] = "data:image/" . $img["tipo"] . ";base64," . $base64;
        }

        // ==========================================================
        // OBTENER IMÁGENES VIEJAS (RUTA)
        // ==========================================================
        $imagenes_ruta = [];
        if (!empty($row['imagen'])) {
            $imagenes_ruta = explode(",", $row['imagen']);
        }

        // ==========================================================
        // COMBINAR TODO EN UN SOLO ARRAY
        // ==========================================================
        $imagenes = array_merge($imagenes_blob, $imagenes_ruta);

        if (empty($imagenes)) {
            $imagenes = ["img/sin_imagen.png"];
        }

        echo '<div class="tarjeta">';

        // ============================
        // CARRUSEL
        // ============================
        echo '<div id="carousel' . $id_publicacion . '" class="carousel slide" data-bs-ride="carousel">';
        
        echo '<div class="carousel-inner">';
        foreach ($imagenes as $index => $img) {
            $active = ($index === 0) ? 'active' : '';
            echo '<div class="carousel-item ' . $active . '">';
            echo '<img src="' . htmlspecialchars(trim($img)) . '" class="d-block w-100">';
            echo '</div>';
        }
        echo '</div>';

        // Indicadores (puntos)
        echo '<div class="carousel-indicators">';
        foreach ($imagenes as $index => $img) {
            $active = ($index === 0) ? 'active' : '';
            echo '<button type="button" data-bs-target="#carousel' . $id_publicacion . '" data-bs-slide-to="' . $index . '" class="' . $active . '"></button>';
        }
        echo '</div>';

        echo '</div>'; // fin carrusel

        // ============================
        // CONTENIDO
        // ============================
        echo '<div class="contenido">
                <h3>' . htmlspecialchars($row['titulo']) . '</h3>
                <p>' . nl2br(htmlspecialchars($row['contenido'])) . '</p>
                <div class="usuario">
                    <img src="' . htmlspecialchars($fotografia) . '" alt="Usuario">
                    <span>' . htmlspecialchars($row['nombre'] . ' ' . $row['apellido']) . '</span>
                </div>
                <p style="font-size:0.8rem; color:#ccc; margin-top:10px;">📅 ' . date("d/m/Y", strtotime($row['fecha_creacion'])) . '</p>';

        // ============================
        // LIKES
        // ============================
        $sqlLikes = "SELECT COUNT(*) as total FROM likes WHERE id_publicacion = $id_publicacion";
        $likesRes = $conn->query($sqlLikes);
        $likesCount = $likesRes->fetch_assoc()['total'];

        echo '<button class="like-btn" onclick="darLike(' . $id_publicacion . ')" id="like-btn-' . $id_publicacion . '">❤️ Me gusta ' . $likesCount . '</button>';

        // ============================
        // COMENTARIOS
        // ============================
        echo '<h4>Comentarios:</h4>';
        $sqlCom = "SELECT c.comentario, u.Nombre 
                   FROM comentarios c 
                   JOIN usuario u ON c.id_usuario = u.id_usuario 
                   WHERE c.id_publicacion = $id_publicacion 
                   ORDER BY c.fecha DESC";
        $comentarios = $conn->query($sqlCom);
        while ($com = $comentarios->fetch_assoc()) {
            echo '<p><b>' . htmlspecialchars($com['Nombre']) . ':</b> ' . htmlspecialchars($com['comentario']) . '</p>';
        }

        // Formulario comentario AJAX
        echo '<form method="POST" action="comentario.php">
                <input type="hidden" name="id_publicacion" value="' . $id_publicacion . '">
                <textarea name="comentario" placeholder="Escribe tu comentario..." required></textarea>
                <button type="submit" class="comment-btn">💬 Comentar</button>
              </form>';

        echo '</div>'; // fin contenido
        echo '</div>'; // fin tarjeta
    }
} else {
    echo "<p style='grid-column:1/-1; text-align:center; font-size:1.2rem;'>😕 No hay publicaciones aprobadas aún.</p>";
}
?>

</div>

<footer>
    <p>&copy; <?php echo date("Y"); ?> - Sistema de Publicaciones Mundial 2026</p>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


<script>
function darLike(idPublicacion) {
    let formData = new FormData();
    formData.append('id_publicacion', idPublicacion);

    fetch('like.php', { method: 'POST', body: formData })
    .then(response => response.text())
    .then(data => {
        document.getElementById('like-btn-' + idPublicacion).innerText = '❤️ Me gusta ' + data;
    });
}
</script>
</body>
</html>
