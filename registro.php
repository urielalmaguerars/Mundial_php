<?php
include "conexion.php"; // conexión a tu BD

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $fecha_actual = new DateTime();
    $fecha_nac = new DateTime($fecha_nacimiento);
    $edad = $fecha_actual->diff($fecha_nac)->y;

    if ($edad < 21) {
        $mensaje = "⚠️ Debes tener al menos 21 años para registrarte.";
    }
    $usuario = trim($_POST['usuario']);
    $correo = trim($_POST['correo']);
    $contrasena = $_POST['contrasena'];
    $id_nacionalidad = $_POST['id_nacionalidad'] ?? null;

    // Hashear la contraseña antes de guardar
    $hash = password_hash($contrasena, PASSWORD_DEFAULT);

    // Verificar que usuario o correo no se repitan
    $stmt = $conn->prepare("SELECT * FROM usuario WHERE usuario = ? OR correo = ?");
    $stmt->bind_param("ss", $usuario, $correo);
    $stmt->execute();
    $result = $stmt->get_result();

if ($edad >= 21) {
    // Verificar que usuario o correo no se repitan
    $stmt = $conn->prepare("SELECT * FROM usuario WHERE usuario = ? OR correo = ?");
    $stmt->bind_param("ss", $usuario, $correo);
    $stmt->execute();
    $result = $stmt->get_result();



    if ($result->num_rows > 0) {
        $mensaje = "⚠️ El usuario o correo ya están registrados.";
    } else {
        // Insertar usuario nuevo (rol por defecto: usuario)
        $stmt = $conn->prepare("INSERT INTO usuario (nombre, apellido, fecha_nacimiento, id_nacionalidad, usuario, correo, contrasena, rol) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, 'usuario')");
        $stmt->bind_param("sssssss", $nombre, $apellido, $fecha_nacimiento, $id_nacionalidad, $usuario, $correo, $hash);

        if ($stmt->execute()) {
            $mensaje = "✅ Usuario registrado correctamente. <a href='login.php'>Iniciar sesión</a>";
        } else {
            $mensaje = "❌ Error: " . $conn->error;
        }
    }
}
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Registro Mundial 2026</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
<style>
:root {
    --blanco: #ffffff;
    --negro: #111111;
    --azul: #0071e3;
    --rojo: #e63946;
    --amarillo: #FFD700;
    --verde: #2a9d8f;
    --gris: #f5f5f7;
}

body {
    font-family: 'Poppins', sans-serif;
    background: linear-gradient(180deg, #F2F2F2, #FFD400, #FFD700);
    margin: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}

.container {
    background: var(--blanco);
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    width: 100%;
    max-width: 450px;
    text-align: center;
}

.container h2 {
    margin-bottom: 20px;
    font-size: 28px;
    background: linear-gradient(90deg, #2A398D, #E61D25, #3CAC3B);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

form input {
    width: 100%;
    padding: 12px 15px;
    margin: 10px 0;
    border-radius: 10px;
    border: 1px solid #ddd;
    font-size: 16px;
    outline: none;
}

form button {
    width: 100%;
    padding: 12px;
    margin-top: 15px;
    border: none;
    border-radius: 25px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    background: linear-gradient(90deg, #2A398D, #E61D25, #3CAC3B);
    color: var(--blanco);
    transition: all 0.3s ease;
}

form button:hover {
    transform: scale(1.05);
}

.message {
    margin-top: 15px;
    font-size: 16px;
    color: var(--rojo);
}

.login-link button {
    background: var(--gris);
    color: var(--negro);
    margin-top: 10px;
}

.login-link button:hover {
    background: var(--azul);
    color: var(--blanco);
}

a { text-decoration: none; }
</style>
</head>
<body>

<div class="container">
    <h2>Registro Mundial 2026</h2>

    <?php if(isset($mensaje)) echo "<p class='message'>{$mensaje}</p>"; ?>

    <form method="POST">
        <input type="text" name="nombre" placeholder="Nombre" required>
        <input type="text" name="apellido" placeholder="Apellido">
        <input type="date" name="fecha_nacimiento" required>

        <label for="nac">Nacionalidad:</label>
        <select  id="nac" name= "id_nacionalidad" required>

            <?php
            $resultado = $conn->query("SELECT id_nacionalidad, nombre FROM nacionalidades");
            while($row = $resultado->fetch_assoc()) {
                echo '<option value="' . $row['id_nacionalidad'] . '">' . htmlspecialchars($row['nombre']) . '</option>';
            }
            ?>
            </select>

        <input type="text" name="usuario" placeholder="Usuario" required>
        <input type="email" name="correo" placeholder="Correo" required>
        <input type="password" name="contrasena" placeholder="Contraseña" required>
        <button type="submit">Registrar</button>
    </form>

    <div class="login-link">
        <form action="login.php">
            <button type="submit">Ya tengo cuenta</button>
        </form>
    </div>
</div>

</body>
</html>
