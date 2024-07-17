<?php
require_once "../config/conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['action'] === 'pagar_efectivo') {
        $productos = $_POST['productos'];
        $total = $_POST['total'];
        $mensaje = $_POST['mensaje'];

        // Obtener el correo del usuario
        // Asegúrate de que la sesión esté iniciada y que el usuario esté autenticado
        session_start();
        $usuario_email = $_SESSION['user_email']; // Asegúrate de que este campo esté disponible en la sesión

        // Enviar el correo electrónico
        $asunto = 'Confirmación de Pedido';
        $cabeceras = 'From: toradahaka@gmail.com' . "\r\n" .
                     'Reply-To: toradahaka@gmail.com' . "\r\n" .
                     'X-Mailer: PHP/' . phpversion();

        mail($usuario_email, $asunto, $mensaje, $cabeceras);

        // Registrar la venta
        foreach ($productos as $producto) {
            $id = $producto['id'];
            $nombre = $producto['nombre'];
            $cantidad = 1; // Cantidad fija de 1 por producto en este ejemplo
            $fecha = date('Y-m-d H:i:s');

            $query = mysqli_query($conexion, "INSERT INTO ventas (id, nombre, cantidad, total, fecha) VALUES ('$id', '$nombre', '$cantidad', '$total', '$fecha')");
        }

        echo 'success';
    } else {
        echo 'Invalid action';
    }
}
?>
