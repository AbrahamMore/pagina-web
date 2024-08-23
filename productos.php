<?php include("template/cabecera.php"); ?>

<!-- Incluir el CSS para estilos -->
<link rel="stylesheet" href="css/productos.css">

<?php
include("administrador/config/db.php");

try {
    $sentenciaSQL = $conexion->prepare("SELECT * FROM productos");
    $sentenciaSQL->execute();
    $listaProductos = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo "Error al obtener los productos: " . $e->getMessage();
    exit();
}

if (empty($listaProductos)) {
    echo "No hay productos disponibles.";
}
?>

<div class="container mt-4 container-custom">
    <br><br>
    <h1 class="title">Nuestros Productos</h1>
    <div class="row">
        <?php foreach($listaProductos as $producto) { 
            $rutaImagen = "administrador/img/" . $producto['imagen'];
        ?>
        <div class="col-md-4 mb-4"> <!-- Mostrar tres elementos por fila -->
            <div class="card">
                <img class="card-img-top" src="<?php echo $rutaImagen; ?>" alt="<?php echo $producto['nombre']; ?>">
                <div class="card-body">
                    <h4 class="card-title"><?php echo $producto['nombre']; ?></h4>
                    <p class="price">Precio: $<?php echo $producto['precio']; ?></p>
                    <p class="card-text"><?php echo $producto['descripcion']; ?></p>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>

<?php include("template/pie.php"); ?>
