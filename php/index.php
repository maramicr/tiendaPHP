<?php

include 'conexion.php';

$query = ("SELECT * FROM productos");
$resultado = mysqli_query($conexion, $query) or die(mysqli_error($conexion));

?>
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
<header>
    <div class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a href="#" class="navbar-brand">

                <strong>Tienda en Línea</strong>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarHeader">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a href="#" class="nav-link active">Catálogo de productos</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Contacto</a>
                    </li>
                </ul>
                <a href="carrito.php" class="btn btn-primary">Carrito</a>
            </div>
        </div>
    </div>
</header>

<body>
    <main>
        <div class="container pt-4">
            <h1 class="title">Catálogo de productos</h1>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3">
                <?php
                while ($row = mysqli_fetch_array($resultado)) {
                ?>
                    <div class="col">
                        <div class="card shadow-sm">
                            <img src="<?php echo $row['imagen']; ?>" class="align-self-center p-2" alt="<?php echo $row['nombre']; ?>" style="width: 200px;">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['nombre']; ?></h5>
                                <!-- el detalle se va a mostrar en un modal ------ -->
                                <!-- <p class="card-text"><?php echo $row['detalle']; ?></p> -->
                                <p class="card-text"><?php echo number_format($row["precio"], 2, '.', ',') ?></p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <a href="#" class="btn btn-primary">Detalle</a>
                                    </div>
                                    <a href="#" class="btn btn-success">Agregar</a>
                                </div>
                            </div>

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
    </main>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous"></script>

</body>