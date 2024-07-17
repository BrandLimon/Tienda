<?php
require_once "../config/conexion.php";

// Manejo del formulario de adición de empresa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['nombre']) && !empty($_POST['direccion']) && !empty($_POST['telefono']) && !empty($_POST['email'])) {
        $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
        $direccion = mysqli_real_escape_string($conexion, $_POST['direccion']);
        $telefono = mysqli_real_escape_string($conexion, $_POST['telefono']);
        $email = mysqli_real_escape_string($conexion, $_POST['email']);

        $query = "INSERT INTO empresa (nombre, direccion, telefono, email) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conexion, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssss", $nombre, $direccion, $telefono, $email);
            if (mysqli_stmt_execute($stmt)) {
                header('Location: empresa.php');
                exit(); // Asegúrate de salir después de redirigir
            } else {
                echo "Error al insertar los datos: " . mysqli_error($conexion);
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "Error en la preparación de la consulta: " . mysqli_error($conexion);
        }
    } else {
        echo "Todos los campos son obligatorios.";
    }
}

include("includes/header.php");
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Datos de la Empresa</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" id="abrirEmpresa"><i class="fas fa-plus fa-sm text-white-50"></i> Nueva Empresa</a>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-hover table-bordered" style="width: 100%;">
                <thead class="thead-dark">
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Dirección</th>
                        <th>Teléfono</th>
                        <th>Email</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT * FROM empresa ORDER BY id DESC";
                    $result = mysqli_query($conexion, $query);
                    if ($result) {
                        while ($data = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($data['id']); ?></td>
                                <td><?php echo htmlspecialchars($data['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($data['direccion']); ?></td>
                                <td><?php echo htmlspecialchars($data['telefono']); ?></td>
                                <td><?php echo htmlspecialchars($data['email']); ?></td>
                                <td>
                                    <form method="post" action="eliminar.php?accion=empresa&id=<?php echo urlencode($data['id']); ?>" class="d-inline eliminar">
                                        <button class="btn btn-danger" type="submit">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php }
                    } else {
                        echo "Error al obtener los datos: " . mysqli_error($conexion);
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="empresa" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="title">Nueva Empresa</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" autocomplete="off">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input id="nombre" class="form-control" type="text" name="nombre" placeholder="Nombre de la empresa" required>
                    </div>
                    <div class="form-group">
                        <label for="direccion">Dirección</label>
                        <input id="direccion" class="form-control" type="text" name="direccion" placeholder="Dirección" required>
                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input id="telefono" class="form-control" type="text" name="telefono" placeholder="Teléfono" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input id="email" class="form-control" type="email" name="email" placeholder="Email" required>
                    </div>
                    <button class="btn btn-primary" type="submit">Registrar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>
