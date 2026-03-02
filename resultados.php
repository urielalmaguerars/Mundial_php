<?php
require_once "conexion.php";

$busqueda = isset($_GET['query']) ? $conn->real_escape_string($_GET['query']) : '';
$sql = "SELECT nombre, apellido, usuario, fotografia 
        FROM usuario 
        WHERE nombre LIKE '%$busqueda%' 
           OR usuario LIKE '%$busqueda%' 
        LIMIT 20";
$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultados Mundial 2026</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #0033a0, #007bff);
            margin: 0;
            padding: 0;
            color: white;
        }

        header {
            background: url('fondo_mundial.jpg') center/cover no-repeat;
            padding: 40px 20px;
            text-align: center;
            color: white;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        }

        header h1 {
            font-size: 36px;
            margin: 0;
            text-shadow: 2px 2px 6px rgba(0,0,0,0.5);
        }

        .container {
            max-width: 1000px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .titulo {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
            color: #ffe600;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
        }

        .card {
            background: rgba(255,255,255,0.1);
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            backdrop-filter: blur(6px);
            border: 2px solid #ffe600;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .card img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 10px;
            border: 3px solid #ffe600;
        }

        .card h3 {
            margin: 10px 0 5px;
            font-size: 18px;
            color: #ffe600;
        }

        .card p {
            margin: 0;
            color: #fff;
        }

        .no-resultados {
            text-align: center;
            font-size: 18px;
            margin-top: 40px;
            color: #fff;
        }

        .volver {
            display: block;
            margin: 40px auto;
            text-align: center;
            text-decoration: none;
            color: #ffe600;
            font-weight: bold;
            font-size: 16px;
        }

        .volver:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header>
<!-- Barra de búsqueda -->
<form action="resultados.php" method="GET" class="search-bar" id="search-bar">
    <input type="text" name="query" id="buscar" placeholder="Buscar usuario..." required>
</form>    </header>

    <div class="container">
        <div class="titulo">Buscando: "<?php echo htmlspecialchars($busqueda); ?>"</div>

        <?php if ($resultado && $resultado->num_rows > 0): ?>
            <div class="grid">
                <?php while ($row = $resultado->fetch_assoc()): 
                    $foto = $row['fotografia'] ? 'fotos_perfil' . $row['fotografia'] : 'fotos_perfil/Person_icon.png';
                ?>
                    <div class="card">
                        <img src="<?php echo $foto; ?>" alt="Foto de <?php echo $row['usuario']; ?>">
                        <h3><?php echo $row['usuario']; ?></h3>
                        <p><?php echo $row['nombre'] . ' ' . $row['apellido']; ?></p>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="no-resultados">No se encontraron usuarios relacionados con el Mundial.</div>
        <?php endif; ?>

        <a href="usuario.php" class="volver">← Volver al inicio</a>
    </div>
</body>
</html>