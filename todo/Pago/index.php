<?php
$servername = "localhost";
$user = "Alois";
$clave = "coronado02";
$bd = "ferretuls";



session_start();
if (empty($_SESSION['id'])) {
    header('Location: ./');
    exit;
}


$conn = new mysqli($servername, $user, $clave, $bd);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos de la empresa
$sql_empresa = "SELECT * FROM empresa LIMIT 1";
$result_empresa = $conn->query($sql_empresa);
$empresa = $result_empresa->fetch_assoc();

// Obtener artículos
$sql_articulos = "SELECT * FROM articulos";
$result_articulos = $conn->query($sql_articulos);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras - FerreTuls</title>
    <link href="assets/css/styles.css" rel="stylesheet">
    <link href="assets/css/estilos.css" rel="stylesheet">
</head>
<body>
    <header>
        <h1>FerreTuls</h1>
        <nav>
            <ul>
                <li><a href="#">Inicio</a></li>
                <li><a href="#">Mi Cuenta</a></li>
            </ul>
        </nav>
    </header>
    <section>
        <h2>Datos de la Empresa</h2>
        <p>Nombre: <?php echo $empresa['nombre']; ?></p>
        <p>Dirección: <?php echo $empresa['direccion']; ?></p>
        <p>Teléfono: <?php echo $empresa['telefono']; ?></p>
        <p>Email: <?php echo $empresa['email']; ?></p>
    </section>
    <section>
        <h2>Artículos</h2>
        <form action="procesar_pago.php" method="POST">
            <div>
                <?php while($articulo = $result_articulos->fetch_assoc()): ?>
                    <div>
                        <input type="checkbox" name="articulos[]" value="<?php echo $articulo['id']; ?>">
                        <span><?php echo $articulo['nombre']; ?> - $<?php echo $articulo['precio']; ?></span>
                    </div>
                <?php endwhile; ?>
            </div>
            <button type="submit">Pagar</button>
        </form>
    </section>
    <footer>
        <p>&copy; 2024 FerreTuls</p>
    </footer>
</body>
</html>

<?php $conn->close(); ?>
