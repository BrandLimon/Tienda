<?php
require_once "../config/conexion.php";

if (isset($_POST['submit'])) {
    $tipo = $_POST['tipo']; // Oferta o Noticia
    $detalle = $_POST['detalle'];
    $duracion = $_POST['duracion'] ?? null; // Duración de la oferta, si es que la hay
    $imagen = $_FILES['imagen'];
    $imgName = $imagen['name'];
    $tmpName = $imagen['tmp_name'];
    $imgExtension = pathinfo($imgName, PATHINFO_EXTENSION);
    $imgNewName = time() . "." . $imgExtension;
    $imgDest = "../assets/img/" . $imgNewName;

    // Insertar datos en la base de datos
    $query = mysqli_query($conexion, "INSERT INTO homeplus (tipo, detalle, duracion, imagen) VALUES ('$tipo', '$detalle', '$duracion', '$imgNewName')");
    if ($query) {
        if (move_uploaded_file($tmpName, $imgDest)) {
            header('Location: homeplus.php');
        } else {
            echo "Error al subir la imagen.";
        }
    } else {
        echo "Error al guardar la información.";
    }
}

include("includes/header.php");
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Noticias y Ofertas</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#agregarNoticiaOferta"><i class="fas fa-plus fa-sm text-white-50"></i> Nuevo</a>
</div>

<!-- Modal para agregar Noticias/Ofertas -->
<div id="agregarNoticiaOferta" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="title">Nueva Noticia/Oferta</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="homeplus.php" method="POST" enctype="multipart/form-data" autocomplete="off">
                    <div class="form-group">
                        <label for="tipo">Tipo</label>
                        <select id="tipo" class="form-control" name="tipo" required>
                            <option value="Oferta">Oferta</option>
                            <option value="Noticia">Noticia</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="detalle">Detalle</label>
                        <textarea id="detalle" class="form-control" name="detalle" placeholder="Detalle" rows="3" required></textarea>
                    </div>
                    <div class="form-group" id="duracion-group">
                        <label for="duracion">Duración (si es oferta)</label>
                        <input id="duracion" class="form-control" type="text" name="duracion" placeholder="Duración (ej. 1 semana)">
                    </div>
                    <div class="form-group">
                        <label for="imagen">Imagen</label>
                        <input id="imagen" class="form-control" type="file" name="imagen" required>
                    </div>
                    <button class="btn btn-primary" type="submit" name="submit">Registrar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="section">
    <h2>Noticias y Ofertas</h2>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tipo</th>
                    <th>Detalle</th>
                    <th>Duración</th>
                    <th>Imagen</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = mysqli_query($conexion, "SELECT * FROM homeplus ORDER BY id DESC");
                while ($data = mysqli_fetch_assoc($query)) { ?>
                    <tr>
                        <td><?php echo $data['tipo']; ?></td>
                        <td><?php echo $data['detalle']; ?></td>
                        <td><?php echo $data['duracion'] ? $data['duracion'] : 'N/A'; ?></td>
                        <td>
                            <?php if ($data['imagen']) { ?>
                                <img src="../assets/img/<?php echo $data['imagen']; ?>" alt="Imagen" style="max-width: 150px; height: auto;">
                            <?php } else { ?>
                                No disponible
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<?php include("includes/footer.php"); ?>
