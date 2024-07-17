<?php
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
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo_electronico = $_POST['correo_electronico'];
    $num_telefono = $_POST['num_telefono'];
    $contrasena = $_POST['contrasena'];
    $confirmar_contrasena = $_POST['confirmar_contrasena'];

    // Validar si las contraseñas coinciden
    if ($contrasena === $confirmar_contrasena) {
        // Encriptar la contraseña
        $contrasena_encriptada = md5($contrasena);

        // Preparar la consulta de actualización
        $sql = "UPDATE usuarios2 SET nombre=?, correo_electronico=?, num_telefono=?";
        
        // Agregar actualización de contraseña si se ha proporcionado una nueva
        if (!empty($contrasena)) {
            $sql .= ", contrasena=?";
        }
        
        $sql .= " WHERE apellido=?";

        // Preparar declaración
        $stmt = $conn->prepare($sql);

        // Vincular parámetros y ejecutar declaración
        if (!empty($contrasena)) {
            $stmt->bind_param("sssss", $nombre, $correo_electronico, $num_telefono, $contrasena_encriptada, $apellido);
        } else {
            $stmt->bind_param("ssss", $nombre, $correo_electronico, $num_telefono, $apellido);
        }

        // Ejecutar y verificar
        if ($stmt->execute()) {
            header("Location: ../index.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        // Cerrar declaración
        $stmt->close();
    } else {
        echo "Las contraseñas no coinciden";
    }
}

// Cerrar conexión
$conn->close();
?>
