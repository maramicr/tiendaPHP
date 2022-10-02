<?php 
    include("conexion.php");
    $productos = "SELECT * FROM productos";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de productos</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
    <div class="container__table">
        <div class="table__title">Datos del producto <a href="editar.php" class="title--edit">Editar</a></div>
        <!-- <div class="table__header">Código</div> -->
        <div class="table__header">Nombre</div>
        <div class="table__header">Detalle</div>
        <div class="table__header">Imagen</div>
        <div class="table__header">Precio</div>

        <?php 
        $resultado = mysqli_query($conexion, $productos);
        while ($row = mysqli_fetch_assoc($resultado)){?>
        <!-- <div class="table__item"><?php echo $row ["codigo"] ?></div> -->
        <div class="table__item"><?php echo $row ["nombre"] ?></div>
        <div class="table__item"><?php echo $row ["detalle"] ?></div>
        <div class="table__item"><img src="<?php echo $row['imagen']; ?>" class="card-img-top" alt="<?php echo $row['nombre']; ?>" width="50px"></div>
        <div class="table__item"><?php echo $row ["precio"] ?></div>   
        <?php } 
        mysqli_free_result($resultado);
        $conexion->close();?>     
    </div>
    
</body>
</html>