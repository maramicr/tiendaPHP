<?php
include("conexion.php");

// declaración de variables--------
$codigo = $_GET["codigo"];
$eliminar = "DELETE FROM productos WHERE codigo = '$codigo'";

$resultadoEliminar = mysqli_query($conexion, $eliminar);

if ($resultadoEliminar) {
    echo "<script>alert('Datos eliminados con éxito!');window.location='/php-avanzado/tienda/php/editar.php'</script>";
}else {
    echo "<script>alert('Ocurrió un error al ejecutar la consulta!');window.history.go(-1);</script>";    
}

$conexion->close();