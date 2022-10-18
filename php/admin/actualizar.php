<?php
include("../config/database.php");
include("../config/config.php");
$codigo = $_GET["codigo"];
$productos = "SELECT * FROM productos WHERE codigo = '$codigo'";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/estilos.css">
    <title>Formulario-actualizar</title>
</head>

<body>
    <div class="container__add">
        <h2 class="container__title">Actualización de productos</h2>
        <div class="container__form">

            <?php
            $resultadoActualizar = mysqli_query($conexion, $productos);
            while ($row = mysqli_fetch_assoc($resultadoActualizar)) {
            ?>
                <form method="POST" action="procesar_act.php" enctype="multipart/form-data">
                    <input type="hidden" name="codigo-producto" value="<?php echo $row["codigo"]; ?>">
                    <input type="text" name="nombre-producto" value="<?php echo $row["nombre"]; ?>">
                    <input type="text" name="detalle-producto" value="<?php echo $row["detalle"]; ?>">
                    <label class="form__label">Selecciona una imágen...</label>
                    <input type="text" name="imagen-producto" value="<?php echo $row["imagen"]; ?>">
                    <input type="number" name="precio-producto" value="<?php echo $row["precio"]; ?>">                    
                    <?php }mysqli_free_result($resultadoActualizar);
                    $conexion->close(); ?>
                    <input type="submit" name="btn-registrar" value="Actualizar">
                </form>
        </div>
    </div>
</body>
</html>