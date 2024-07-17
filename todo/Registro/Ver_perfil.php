<?php
session_start(); // Iniciar sesión

$servername = "localhost";
$user = "Alois";
$clave = "coronado02";
$bd = "ferretuls";

$conn = new mysqli($servername, $user, $clave, $bd);


// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    echo "No estás autenticado. Inicia sesión para ver tu perfil.";
    exit();
}

// Obtener el ID del usuario desde la sesión
$usuario_id = $_SESSION['usuario_id'];

// Preparar la consulta para obtener los datos del perfil
$sql = "SELECT nombre, apellido, correo_electronico, num_telefono FROM usuarios2 WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);

// Ejecutar la consulta y obtener los resultados
$stmt->execute();
$result = $stmt->get_result();

// Verificar si se encontraron resultados
if ($result->num_rows > 0) {
    $usuario = $result->fetch_assoc();
} else {
    echo "No se encontró el perfil del usuario.";
    exit();
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil de Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: #F9E9EC;
        }

        .container {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
        }

        h1, h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 1em;
            color: #fff;
            background: #4153AF;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
        }

        .btn:hover {
            background: #2f3a8a;
        }

        .btn-secondary {
            background: #FAC748;
        }

        .btn-secondary:hover {
            background: #d4a636;
        }

        p {
            margin-top: 20px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Perfil de Usuario</h2>
        <p><strong>Nombre:</strong> <?php echo htmlspecialchars($usuario['nombre']); ?></p>
        <p><strong>Apellido:</strong> <?php echo htmlspecialchars($usuario['apellido']); ?></p>
        <p><strong>Correo Electrónico:</strong> <?php echo htmlspecialchars($usuario['correo_electronico']); ?></p>
        <p><strong>Número de Teléfono:</strong> <?php echo htmlspecialchars($usuario['num_telefono']); ?></p>
        <a href="actualizar_perfil.html" class="btn btn-primary">Actualizar Perfil</a>
        <a href="logout.php" class="btn btn-secondary">Cerrar Sesión</a>
        <a href="../index.php" class="btn btn-secondary">Volver a Inicio</a>
    </div>
</body>
</html>
