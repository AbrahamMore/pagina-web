<?php 
session_start();
if($_POST){
    if(($_POST['usuario']=="administrador")&&($_POST['contrasenia']=="sistema")){
        $_SESSION['usuario']="ok";
        $_SESSION['nombreUsuario']="Administrador";
        header('Location:inicio.php');
    }else{
        $mensaje="Error: El usuario o contraseñia son incorrectos";
    }
 
}
?>


<!doctype html>
<html lang="en">
  <head>
    <title>Administracion</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="icon" href="../img/zazil.ico">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/estilos.css">
  </head>
  <body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card login-card">
                    <div class="login-header">
                        INICIAR SESION
                    </div>
                    <div class="card-body login-body">

                    <?php if(isset($mensaje)) {?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $mensaje; ?>
                        </div>
                    <?php }?>


                        <form method="POST">
                            <div class="form-group">
                                <label><i class="fas fa-user"></i> Usuario</label>
                                <input type="text" class="form-control" name="usuario" placeholder="Escribe tu usuario">
                            </div>
                            <div class="form-group">
                                <label><i class="fas fa-key"></i> Contraseña:</label>
                                <input type="password" class="form-control" name="contrasenia" placeholder="Escribe tu contraseña">
                            </div>
                            <button type="submit" class="btn btn-login">Entrar el administrador</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Font Awesome for icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
  </body>
</html>
