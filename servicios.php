<?php include("template/cabecera.php"); ?>

<!-- Incluir el CSS para estilos -->
<link rel="stylesheet" href="css/productos.css">

<?php
include("administrador/config/db.php");

// Intentar obtener los servicios desde la base de datos
try {
    $sentenciaSQL = $conexion->prepare("SELECT * FROM servicios");
    $sentenciaSQL->execute();
    $listaServicios = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo "Error al obtener los servicios: " . $e->getMessage();
    exit();
}

if (empty($listaServicios)) {
    echo "No hay servicios disponibles.";
}
?>

<div class="container mt-4 container-custom">
    <br>
    <h1 class="title">Nuestros Servicios</h1>
    <br>
    <div class="row">
        <?php foreach($listaServicios as $servicio) { 
            $rutaImagen = "./administrador/img/" . $servicio['imagen'];
        ?>
        <div class="col-md-4 mb-4"> <!-- Cambio de col-md-6 a col-md-4 para mostrar tres elementos por fila -->
            <div class="card">
                <img class="card-img-top" src="<?php echo $rutaImagen; ?>" alt="<?php echo $servicio['nombre']; ?>">
                <div class="card-body">
                    <h4 class="card-title"><?php echo $servicio['nombre']; ?></h4>
                    <p class="price">Precio: $<?php echo $servicio['precio']; ?></p>
                    <p class="card-text"><?php echo $servicio['descripcion']; ?></p>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>

<?php include("template/pie.php"); ?>
