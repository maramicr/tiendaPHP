<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../css/estilos.css">
    <title>Productos</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/estilos.css">
</head>

<body>
    <div class="container text-center">
        <h1 class="title">Catálogo de productos</h1>
        <div class="row">
        <?php

        include 'conexion.php';

        $query = ("SELECT * FROM productos");
        $resultado = mysqli_query($conexion, $query) or die(mysqli_error($conexion));

        while ($row = mysqli_fetch_array($resultado)) {

        ?>
            <div class="card" style="width: 18rem;">
                <img src="<?php echo $row['imagen']; ?>" class="card-img-top" alt="<?php echo $row['nombre']; ?>" style="width: 70%;">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $row['nombre']; ?></h5>
                    <p class="card-text"><?php echo $row['detalle']; ?></p>
                    <p class="card-text"><?php echo $row['precio']; ?></p>
                    <a href="#" class="btn btn-primary">Comprar</a>
                </div>
            </div>

        <?php
        }

        if ($conexion->error != '') {
            echo "Ocurrió un error al ejecutar la consulta: {$conexion->error}";
        }

        echo $conexion->error;
        $conexion->close();
        ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous"></script>

</body>