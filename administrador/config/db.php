<?php
$host = "localhost";
$usuario = "zazilhsp_zaziluser";  // Nombre de usuario que creaste
$contrasenia = "Abraham_MV2209";  // Contraseña que configuraste
$db = "zazilhsp_zazil";  // Nombre de la base de datos que creaste

try {
    $conexion = new PDO("mysql:host=$host;dbname=$db", $usuario, $contrasenia);
    // Configurar el modo de error de PDO para que lance excepciones
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (Exception $ex) {
    echo "Error en la conexión: " . $ex->getMessage();
}
?>
