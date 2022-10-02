<?php
$servidor="localhost";
$usuario="root";
$password="";
$db="tienda";

$conexion = mysqli_connect($servidor,$usuario,$password,$db);

if ($conexion->connect_error != null){
    echo "Ocurrió un error al establecer la conexión: {$conexion->connect_error}";
}else {
    // echo "Conexión a db realizada con éxito!";
}


// $conexion->close();  

?>