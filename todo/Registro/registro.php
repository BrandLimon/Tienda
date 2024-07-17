<?php
$servername = "localhost";
$user = "Alois";
$clave = "coronado02";
$bd = "ferretuls";

$conn = new mysqli($servername, $user, $clave, $bd);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo_electronico = $_POST['correo_electronico'];
    $num_telefono = $_POST['num_telefono'];
    $contrasena = $_POST['contrasena'];
    $confirmar_contrasena = $_POST['confirmar_contrasena'];

    if ($contrasena == $confirmar_contrasena) {
        $contrasena_encriptada = md5($contrasena);

        $sql_check = "SELECT * FROM usuarios2 WHERE correo_electronico='$correo_electronico'";
        $result_check = $conn->query($sql_check);

        if ($result_check->num_rows > 0) {
            header("Location: registro.html?error=El correo electrónico ya está registrado.");
            exit();
        } else {
            $sql = "INSERT INTO usuarios2 (nombre, apellido, correo_electronico, num_telefono, contrasena) VALUES ('$nombre', '$apellido', '$correo_electronico', '$num_telefono', '$contrasena_encriptada')";

            if ($conn->query($sql) === TRUE) {
                header("Location: index.html");
                exit();
            } else {
                header("Location: registro.html?error=Error en la consulta SQL.");
                exit();
            }
        }
    } else {
        header("Location: registro.html?error=Las contraseñas no coinciden.");
        exit();
    }
}

$conn->close();
?>
