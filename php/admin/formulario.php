<?php
include("../config/database.php");
$productos = "SELECT * FROM productos";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/estilos.css">
    <title>Formulario</title>
</head>
<body>
    <div class="container__add">
        <h2 class="container__title">Ingreso de productos</h2>
        <div class="container__form">

            <form method="POST" action="almacenar.php" enctype="multipart/form-data">
                <input type="text" name="nombre-producto" placeholder="Nombre del producto" require>
                <input type="text" name="detalle-producto" placeholder="Detalle" require>
                <label class="form__label">Selecciona una imágen...</label>
                <input type="file" name="imagen-producto" class="form__file" require>
                <input type="number" name="precio-producto" placeholder="Precio" require>
                <input type="submit" name="btn-registrar" value="Registrar" require>
            </form>

        </div>
    </div>    
</body>
</html>