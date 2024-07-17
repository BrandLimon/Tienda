<?php
require_once "../config/conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST)) {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $total = $_POST['total'];
        $fecha = $_POST['fecha'];
        
        $query = mysqli_query($conexion, "INSERT INTO ventas (id, nombre, total, fecha) VALUES ('$id', '$cantidad', '$total', '$fecha')");
        
        if ($query) {
            header('Location: ventas.php');
        }
    }
}

include("includes/header.php");
?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Ventas</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" id="abrirVenta"><i class="fas fa-plus fa-sm text-white-50"></i> Nueva Venta</a>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-hover table-bordered" style="width: 100%;">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Artículo ID</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                        <th>Fecha</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = mysqli_query($conexion, "SELECT * FROM ventas ORDER BY id_venta DESC");
                    while ($data = mysqli_fetch_assoc($query)) { ?>
                        <tr>
                            <td><?php echo $data['id_venta']; ?></td>
                            <td><?php echo $data['id']; ?></td>
                            <td><?php echo $data['cantidad']; ?></td>
                            <td><?php echo $data['total']; ?></td>
                            <td><?php echo $data['fecha']; ?></td>
                            <td>
                                <form method="post" action="eliminar.php?accion=venta&id=<?php echo $data['id']; ?>" class="d-inline eliminar">
                                    <button class="btn btn-danger" type="submit">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div id="ventas" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="title">Nueva Venta</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" autocomplete="off">
                    <div class="form-group">
                        <label for="id">Artículo ID</label>
                        <input id="id" class="form-control" type="text" name="id" placeholder="Productos ID" required>
                    </div>
                    <div class="form-group">
                        <label for="cantidad">Cantidad</label>
                        <input id="cantidad" class="form-control" type="number" name="cantidad" placeholder="Cantidad" required>
                    </div>
                    <div class="form-group">
                        <label for="total">Total</label>
                        <input id="total" class="form-control" type="number" step="0.01" name="total" placeholder="Total" required>
                    </div>
                    <div class="form-group">
                        <label for="fecha">Fecha</label>
                        <input id="fecha" class="form-control" type="date" name="fecha" required>
                    </div>
                    <button class="btn btn-primary" type="submit">Registrar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include("includes/footer.php"); ?>
<script>
document.getElementById('abrirVenta').addEventListener('click', function() {
    var myModal = new bootstrap.Modal(document.getElementById('ventas'), {
        keyboard: false
    });
    myModal.show();
});
</script>
