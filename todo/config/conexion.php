<?php
    $host = "localhost";
    $user = "Alois";
    $clave = "coronado02";
    $bd = "ferretuls";
    $conexion = mysqli_connect($host, $user, $clave, $bd);
    if (mysqli_connect_errno()) {
        echo "No se pudo conectar a la base de datos: " . mysqli_connect_error();
        exit();
    }
    mysqli_select_db($conexion, $bd) or die("No se encuentra la base de datos");
    mysqli_set_charset($conexion, "utf8");
?>
