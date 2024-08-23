<?php include("../template/cabecera.php"); ?>

<?php
$txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : "";
$txtNombre = (isset($_POST['txtNombre'])) ? $_POST['txtNombre'] : "";
$txtDescripcion = (isset($_POST['txtDescripcion'])) ? $_POST['txtDescripcion'] : "";
$txtPrecio = (isset($_POST['txtPrecio'])) ? $_POST['txtPrecio'] : "";
$txtImagen = (isset($_FILES['txtImagen']['name'])) ? $_FILES['txtImagen']['name'] : "";
$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";

// Incluye el archivo de conexión a la base de datos
include("../config/db.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    switch ($accion) {
        case "Agregar":
            // Crear la carpeta de destino si no existe
            $carpetaDestino = "../img/";
            if (!is_dir($carpetaDestino)) {
                mkdir($carpetaDestino, 0777, true);
            }

            // Mover el archivo de imagen subido a una ubicación adecuada
            if ($txtImagen != "") {
                $fecha = new DateTime();
                $nombreArchivo = $fecha->getTimestamp() . "_" . $_FILES["txtImagen"]["name"];
                $tmpImagen = $_FILES["txtImagen"]["tmp_name"];

                if ($tmpImagen != "") {
                    move_uploaded_file($tmpImagen, $carpetaDestino . $nombreArchivo);
                }
            } else {
                $nombreArchivo = "imagen.jpg"; // Imagen por defecto si no se sube ninguna imagen
            }

            // Preparar y ejecutar la consulta de inserción
            $sentenciaSQL = $conexion->prepare("INSERT INTO servicios (nombre, descripcion, precio, imagen) VALUES (:nombre, :descripcion, :precio, :imagen)");
            $sentenciaSQL->bindParam(':nombre', $txtNombre);
            $sentenciaSQL->bindParam(':descripcion', $txtDescripcion);
            $sentenciaSQL->bindParam(':precio', $txtPrecio);
            $sentenciaSQL->bindParam(':imagen', $nombreArchivo);

            $sentenciaSQL->execute();
            header("Location: servicios.php");
            exit;

        case "Modificar":
            // Actualizar los campos del servicio
            $sentenciaSQL = $conexion->prepare("UPDATE servicios SET nombre=:nombre, descripcion=:descripcion, precio=:precio WHERE id=:id");
            $sentenciaSQL->bindParam(':nombre', $txtNombre);
            $sentenciaSQL->bindParam(':descripcion', $txtDescripcion);
            $sentenciaSQL->bindParam(':precio', $txtPrecio);
            $sentenciaSQL->bindParam(':id', $txtID);
            $sentenciaSQL->execute();

            // Verificar si se subió una nueva imagen
            if ($txtImagen != "") {
                // Obtener la imagen actual
                $sentenciaSQL = $conexion->prepare("SELECT imagen FROM servicios WHERE id=:id");
                $sentenciaSQL->bindParam(':id', $txtID);
                $sentenciaSQL->execute();
                $producto = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

                // Eliminar la imagen anterior si existe y no es la imagen por defecto
                $rutaImagen = "../img/" . $producto["imagen"];
                if (isset($producto["imagen"]) && ($producto["imagen"] != "imagen.jpg") && file_exists($rutaImagen)) {
                    unlink($rutaImagen);
                }

                // Mover la nueva imagen
                $fecha = new DateTime();
                $nombreArchivo = $fecha->getTimestamp() . "_" . $_FILES["txtImagen"]["name"];
                $tmpImagen = $_FILES["txtImagen"]["tmp_name"];
                move_uploaded_file($tmpImagen, "../img/" . $nombreArchivo);

                // Actualizar la imagen en la base de datos
                $sentenciaSQL = $conexion->prepare("UPDATE servicios SET imagen=:imagen WHERE id=:id");
                $sentenciaSQL->bindParam(':imagen', $nombreArchivo);
                $sentenciaSQL->bindParam(':id', $txtID);
                $sentenciaSQL->execute();
            }
            header("Location: servicios.php");
            exit;

        case "Cancelar":
            header("Location: servicios.php");
            exit;

        case "Selecionar":
            $sentenciaSQL = $conexion->prepare("SELECT * FROM servicios WHERE id=:id");
            $sentenciaSQL->bindParam(':id', $txtID);
            $sentenciaSQL->execute();
            $producto = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

            $txtNombre = $producto['nombre'];
            $txtDescripcion = $producto['descripcion'];
            $txtPrecio = $producto['precio'];
            $txtImagen = $producto['imagen'];
            break;

        case "Borrar":
            // Obtener la imagen actual del servicio
            $sentenciaSQL = $conexion->prepare("SELECT imagen FROM servicios WHERE id=:id");
            $sentenciaSQL->bindParam(':id', $txtID);
            $sentenciaSQL->execute();
            $producto = $sentenciaSQL->fetch(PDO::FETCH_LAZY);

            // Eliminar la imagen del servidor si existe y no es la imagen por defecto
            $rutaImagen = "../img/" . $producto["imagen"];
            if (isset($producto["imagen"]) && ($producto["imagen"] != "imagen.jpg") && file_exists($rutaImagen)) {
                unlink($rutaImagen);
            }

            // Eliminar el registro de la base de datos
            $sentenciaSQL = $conexion->prepare("DELETE FROM servicios WHERE id=:id");
            $sentenciaSQL->bindParam(':id', $txtID);
            $sentenciaSQL->execute();
            header("Location: servicios.php");
            exit;
    }
}

$sentenciaSQL = $conexion->prepare("SELECT * FROM servicios");
$sentenciaSQL->execute();
$listaProductos = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Datos de los Servicios
                </div>
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="txtID">ID:</label>
                            <input type="text" class="form-control" value="<?php echo $txtID; ?>" name="txtID" id="txtID" placeholder="ID" readonly>
                        </div>
                        <div class="form-group">
                            <label for="txtNombre">Nombre:</label>
                            <input type="text" required class="form-control" value="<?php echo $txtNombre; ?>" name="txtNombre" id="txtNombre" placeholder="Nombre del servicio">
                        </div>
                        <div class="form-group">
                            <label for="txtDescripcion">Descripcion:</label>
                            <input type="text" required class="form-control" value="<?php echo $txtDescripcion; ?>" name="txtDescripcion" id="txtDescripcion" placeholder="Descripcion">
                        </div>
                        <div class="form-group">
                            <label for="txtPrecio">Precio:</label>
                            <input type="text" required class="form-control" value="<?php echo $txtPrecio; ?>" name="txtPrecio" id="txtPrecio" placeholder="Precio del servicio">
                        </div>
                        <div class="form-group">
                            <label for="txtImagen">Imagen:</label>
                            <?php if($txtImagen!=""){ ?>
                                <img src="../img/<?php echo $txtImagen; ?>" width="100" alt="">
                            <?php } ?>
                            <input type="file" class="form-control" name="txtImagen" id="txtImagen" placeholder="Imagen">
                        </div>
                        <div class="btn-group" role="group" aria-label="">
                            <button type="submit" name="accion" <?php echo ($accion=="Seleccionar")?"disabled":"";?> value="Agregar" class="btn btn-success">Agregar</button>
                            <button type="submit" name="accion" <?php echo ($accion=="Seleccionar")?"disabled":"";?> value="Modificar" class="btn btn-warning">Modificar</button>
                            <button type="submit" name="accion" <?php echo ($accion=="Seleccionar")?"disabled":"";?> value="Cancelar" class="btn btn-info">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Precio</th>
                        <th>Imagen</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($listaProductos as $Producto) { ?>
                    <tr>
                        <td><?php echo $Producto['id']; ?></td>
                        <td><?php echo $Producto['nombre']; ?></td>
                        <td><?php echo $Producto['descripcion']; ?></td>
                        <td><?php echo $Producto['precio']; ?></td>
                        <td>
                            <img src="../img/<?php echo $Producto['imagen']; ?>" width="50" alt="">
                        </td>
                        <td>
                            <form method="post">
                                <input type="hidden" name="txtID" id="txtID" value="<?php echo $Producto['id']; ?>">
                                <input type="submit" name="accion" value="Selecionar" class="btn btn-primary"/>
                                <input type="submit" name="accion" value="Borrar" class="btn btn-danger"/>
                            </form>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include("../template/pie.php"); ?>
