<?php
include("../config/database.php");
include("../config/config.php");

if ($conexion) {
    // echo "Conexión realizada con éxito";
}

// declaración de variables--------
$nombre = $_POST["nombre-producto"];
$detalle = $_POST["detalle-producto"];
// $imagen = $_POST["imagen-producto"];
$precio = $_POST["precio-producto"];

// se recibe la imagen -----------------
if ($_FILES["imagen-producto"]) {
    $nombre_base = basename($_FILES['imagen-producto']['name']);
    $nombre_final = $nombre_base . "-" . date("m-d-y") . "-" . date("h-i-s");
    $ruta = "../img/" . $nombre_final;
    $subirarchivo = move_uploaded_file($_FILES["imagen-producto"]["tmp_name"], $ruta);

    if ($subirarchivo) {
        // campos de la tabla que recibe los datos----------
        $insertarSQL = "INSERT INTO productos(nombre, detalle, imagen, precio)
        VALUES ('$nombre', '$detalle', '$ruta', '$precio')";
        $resultado = mysqli_query($conexion, $insertarSQL);

        if ($resultado) {
            echo "<script>alert('Datos almacenados con éxito!');window.location='/php-avanzado/tienda/php'</script>";
        } else {
            echo "<script>alert('Ocurrió un error al ejecutar la consulta!');window.history.go(-1);</script>";
        }
    } else {
        echo "<script>alert('El archivo no se ha subido correctamente!');</script>";        
    }
}
$conexion->close();
