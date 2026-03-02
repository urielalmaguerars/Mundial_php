<?php
session_start();
include "conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];

    $stmt = $conn->prepare("SELECT * FROM usuario WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        if (password_verify($contrasena, $row['contrasena'])) {
            $_SESSION['id_usuario'] = $row['id_usuario'];
            $_SESSION['nombre'] = $row['nombre'];
            $_SESSION['rol'] = $row['rol'];

            if ($row['rol'] == 'admin') {
                header("Location: admin.php");
            } else {
                header("Location: usuario.php");
            }
            exit;
        } else {
            echo "<script>alert('Contraseña incorrecta.');</script>";
        }
    } else {
        echo "<script>alert('Usuario no encontrado.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login Mundial 2026</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #006847, #ffffff, #bf0a30); /* Bandera */
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 8px 25px rgba(0, 0, 0, 0.25);
            width: 350px;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
            color: #006847;
        }
        input {
            width: 90%;
            padding: 12px;
            margin: 10px 0;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 14px;
        }
        button {
            width: 95%;
            padding: 12px;
            margin-top: 15px;
            background: #006847;
            color: white;
            font-size: 15px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
        }
        button:hover {
            background: #bf0a30;
        }
        h5 {
            margin-top: 20px;
            font-weight: normal;
            color: #444;
        }
        .alt-btn {
            background: #0055a4;
        }
        .alt-btn:hover {
            background: #bf0a30;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        <p>Ocupas Iniciar Sesion para poder ver mas publicaciones
            y poder interactuar con todos los servicios.
        </p>
        <form method="POST">
            <input type="text" name="usuario" placeholder="Usuario" required>
            <input type="password" name="contrasena" placeholder="Contraseña" required>
            <button type="submit">Ingresar</button>
        </form>

        <form action="index.php">
            <button type="submit" class="alt-btn">Continuar como invitado</button>
        </form>

        <h5>¿No tienes cuenta?</h5>
        <form action="registro.php">
            <button type="submit" class="alt-btn">Regístrate</button>
        </form>
    </div>
</body>
</html>
