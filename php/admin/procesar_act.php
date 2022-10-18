<?php
include("../config/database.php");
include("../config/config.php");

// declaración de variables--------
$codigo = $_POST["codigo-producto"];
$nombre = $_POST["nombre-producto"];
$detalle = $_POST["detalle-producto"];
$imagen = $_POST["imagen-producto"];
$precio = $_POST["precio-producto"];

$actualizar = "UPDATE productos SET nombre = '$nombre', detalle = '$detalle', imagen = '$imagen', precio = '$precio' WHERE codigo = '$codigo'";  

$resultado = mysqli_query($conexion, $actualizar);

if ($resultado) {
    echo "<script>alert('Datos actualizados con éxito!');window.location='/php-avanzado/tienda/php/editar.php'</script>";
}else {
    echo "<script>alert('Ocurrió un error al ejecutar la consulta!');window.history.go(-1);</script>";    
}

$conexion->close();
?>