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

// Comprobar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo_electronico = $_POST['correo_electronico'];
    $contrasena = $_POST['contrasena'];

    // Encriptar la contraseña para comparar con la base de datos
    $contrasena_encriptada = md5($contrasena);

    // Preparar y ejecutar la consulta
    $sql = "SELECT id FROM usuarios2 WHERE correo_electronico=? AND contrasena=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $correo_electronico, $contrasena_encriptada);
    $stmt->execute();
    $stmt->store_result();

    // Verificar si el usuario existe
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id);
        $stmt->fetch();
        $_SESSION['usuario_id'] = $id; // Guardar el ID del usuario en la sesión
        header("Location: ../index.php");
        exit();
    } else {
        header("Location: login.html"); // Redirige a la misma página con un parámetro de error
        exit();
    }

    $stmt->close();
}

$conn->close();
?>
