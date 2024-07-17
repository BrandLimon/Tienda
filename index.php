<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FerreTuls</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        header {
            background: #4153AF; /* Color primario */
            color: #fff;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        header h1 {
            margin: 0;
        }
        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
        }
        nav ul li {
            margin-left: 20px;
        }
        nav ul li a {
            color: #fff;
            text-decoration: none;
        }
        .banner {
            background: url('./todo/assets/img/1721183038.png') no-repeat center center;
            background-size: cover;
            color: #000; /* Color del texto cambiado a negro */
            text-align: center;
            padding: 60px 20px;
            opacity: 0.8; /* Añade un poco de opacidad para mejorar la visibilidad del texto */
        }
        .banner h2 {
            margin: 0;
            font-size: 2.5em;
            color: #000; /* Asegúrate de que el color del encabezado sea visible */
        }
        .banner p {
            color: #000; /* Cambia el color del párrafo también */
        }
        .banner button {
            padding: 10px 20px;
            font-size: 1em;
            background: #FAC748; /* Color secundario */
            color: #fff;
            border: none;
            cursor: pointer;
        }
        .section {
            padding: 20px;
        }
        .section h2 {
            margin-top: 0;
        }
        .offers-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .offer {
            display: flex;
            flex: 1 1 calc(50% - 20px);
            border: 1px solid #ddd;
            padding: 10px;
            background-color: #F9E9EC; /* Color secundario */
            box-sizing: border-box;
        }
        .offer .content {
            flex: 1;
            padding-right: 10px;
        }
        .offer img {
            max-width: 150px;
            height: auto;
        }
        footer {
            background: #4153AF; /* Color primario */
            color: #fff;
            padding: 20px;
            text-align: center;
        }
        footer a {
            color: #AFC9BC; /* Color secundario */
            text-decoration: none;
        }
    </style>
</head>
<body>

<header>
    <h1>FerreTuls</h1>
    <nav>
        <ul>
            <li><a href="./todo/Registro/index.html">Inicio</a></li>
        </ul>
    </nav>
</header>

<div class="banner">
    <h2>¡Bienvenido a FerreTuls!</h2>
    <p>Encuentra todo lo que necesitas para tus proyectos de mejora en el hogar. ¡Ofertas especiales y productos de calidad te están esperando!</p>
</div>

<div class="section">
    <h2>Noticias y Ofertas</h2>
    <div class="offers-grid">
        <?php
        require_once "todo/config/conexion.php";
        $query = mysqli_query($conexion, "SELECT * FROM homeplus ORDER BY id DESC");
        while ($data = mysqli_fetch_assoc($query)) { ?>
            <div class="offer">
                <div class="content">
                    <h3><?php echo $data['tipo']; ?></h3>
                    <p><?php echo $data['detalle']; ?></p>
                    <?php if ($data['duracion']) { ?>
                        <p><strong>Duración:</strong> <?php echo $data['duracion']; ?></p>
                    <?php } ?>
                </div>
                <?php if ($data['imagen']) { ?>
                    <img src="todo/assets/img/<?php echo $data['imagen']; ?>" alt="Imagen">
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</div>

<footer>
    <p><a href="#">Políticas de Privacidad</a> | <a href="#">Términos y Condiciones</a> | <a href="#">Preguntas Frecuentes</a> | <a href="#">Mapa del Sitio</a></p>
    <p>Dirección: Calle Ejemplo 123, Ciudad, País | Teléfono: (123) 456-7890 | Correo Electrónico: contacto@ejemplo.com</p>
    <p>Síguenos en: <a href="#">Facebook</a> | <a href="#">Instagram</a> | <a href="#">Twitter</a></p>
    <p>© 2024 [Nombre de la Tienda]. Todos los derechos reservados.</p>
</footer>

</body>
</html>
