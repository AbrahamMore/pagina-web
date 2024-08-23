<?php
    session_start();
    if(!isset($_SESSION['usuario'])){
        header('Location:../index.php');
    }else{
        if($_SESSION['usuario']=="ok"){
            $nombreUsuario=$_SESSION["nombreUsuario"];
        }
    }
?> 


<!doctype html>
<html lang="en">
<head>
    <title>Zazil Há Spa</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="../../img/zazil.ico">
    <link rel="icon" href="../img/zazil.ico">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        .navbar {
            padding: 1.0rem 1rem; /* Aumenta la altura del navbar */
        }
        .nav-link {
            color: white !important; /* Color blanco para el texto */
            font-size: 1.2rem;/* Ajusta el tamaño de la fuente */
        }
        .navbar-dark .navbar-nav .nav-link.active {
            color: #ffffff !important; /* Color blanco para el texto activo */
        }
    </style>
</head>
<body>

    <?php $url="http://".$_SERVER['HTTP_HOST']."/zazil" ?>
    
    <nav class="navbar navbar-expand navbar-dark bg-dark">
        <div class="nav navbar-nav">
            <a class="nav-item nav-link active" href="#">Administracion del sitio web <span class="sr-only">(current)</span></a>
        </div>

        <div class="nav navbar-nav ml-auto">
            <a class="nav-item nav-link" href="<?php echo $url;?>/administrador/inicio.php">Inicio</a>
            <a class="nav-item nav-link" href="<?php echo $url;?>/administrador/seccion/productos.php">Productos</a>
            <a class="nav-item nav-link" href="<?php echo $url;?>/administrador/seccion/servicios.php">Servicios</a>
            <a class="nav-item nav-link" href="<?php echo $url;?>/administrador/seccion/cerrar.php">Cerrar</a>
            <a class="nav-item nav-link" href="<?php echo $url;?>">Ver sitio web</a>
        </div>
    </nav>

    <div class="container">
        <br><br>
        <div class="row">
            <!-- Contenido adicional aquí -->
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRjTBqiyd29p/6pSff1" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGaR8ymBGpIbbVYUew+OrCXaRk" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIyYQU6z0DlCcz/smI44FHE3JJh25STt1CtpClw9" crossorigin="anonymous"></script>
</body>
</html>
