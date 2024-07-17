<?php
require_once "config/conexion.php";
require_once "config/config.php";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $articulos = $_POST['articulos'];
    $total = 0;
    $detalle_compra = '';

    foreach ($articulos as $articulo_id) {
        $sql_articulo = "SELECT * FROM articulos WHERE id=$articulo_id";
        $result_articulo = $conn->query($sql_articulo);
        $articulo = $result_articulo->fetch_assoc();
        
        $total += $articulo['precio'];
        $detalle_compra .= $articulo['nombre'] . " - $" . $articulo['precio'] . "\n";

        // Guardar en la tabla ventas
        $sql_venta = "INSERT INTO ventas (articulo_id, cantidad, total) VALUES ($articulo_id, 1, {$articulo['precio']})";
        $conn->query($sql_venta);
    }

    // Obtener el email del usuario
    $sql_usuario = "SELECT email FROM usuarios WHERE id=1"; // Ajusta esto según el usuario actual
    $result_usuario = $conn->query($sql_usuario);
    $usuario = $result_usuario->fetch_assoc();
    $email_usuario = $usuario['email'];

    // Enviar correo
    $to = $email_usuario;
    $subject = "Detalle de Compra";
    $message = "Gracias por tu compra.\n\nDetalle de compra:\n" . $detalle_compra . "\nTotal: $" . $total;
    $headers = "From: tienda@example.com";

    if (mail($to, $subject, $message, $headers)) {
        echo "Correo enviado exitosamente.";
    } else {
        echo "Error al enviar el correo.";
    }
}

$conn->close();
?>
