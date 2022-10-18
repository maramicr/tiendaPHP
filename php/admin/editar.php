<?php 
    include("../config/database.php");
    include("../config/config.php");
    $productos = "SELECT * FROM productos";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edición de productos</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <div class="container__table container__table--edit">
        <div class="table__title table__title--edit">Editar producto</div>
        <!-- <div class="table__header">Código</div> -->
        <div class="table__header">Nombre</div>
        <div class="table__header">Detalle</div>
        <div class="table__header">Imagen</div>
        <div class="table__header">Precio</div>
        <div class="table__header">Acción</div>

        <?php 
        $resultado = mysqli_query($conexion, $productos);
        while ($row = mysqli_fetch_assoc($resultado)){?>
        <!-- <div class="table__item"><?php echo $row ["codigo"] ?></div> -->
        <div class="table__item"><?php echo $row ["nombre"] ?></div>
        <div class="table__item"><?php echo $row ["detalle"] ?></div>
        <div class="table__item"><?php echo $row ["imagen"] ?></div>
        <div class="table__item"><?php echo $row ["precio"] ?></div>   
        <div class="table__item">
            <a href="actualizar.php?codigo=<?php echo $row ["codigo"] ?>" class="table__item--link">Editar</a>|
            <a href="eliminar.php?codigo=<?php echo $row ["codigo"] ?>" class="table__item--link--del">Eliminar</a>            
        </div>   
        <?php } 
        mysqli_free_result($resultado);
        $conexion->close();?>     
    </div>
    <script src="../js/confirmacion.js"></script>
</body>
</html>