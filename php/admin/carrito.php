<?php
include 'conexion.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../css/estilos.css">
    <title>Carrito de compras</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/estilos.css">

    <script src="https://kit.fontawesome.com/71af4709ae.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container mt-3">
        <h1 class="title text-center">Productos seleccionados</h1>
        <div class="row">
            <div class="col-12">
                <form method="POST">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>
                                    <a href="catalogo_prod.php" class="btn btn-secondary">
                                    <i class="fa fa-backward"></i>
                                    </a>
                                </th>
                           <!-- <th>Detalle</th>
                                <th>Imagen</th>
                                <th>Precio</th>
                                <th>Acción</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $listaProductos = unserialize($_COOKIE['producto']);
                            if(isset($_REQUEST['borrar'])){
                                unset($listaProductos[$_REQUEST]['borrar']);
                                setcookie('producto', serialize($listaProductos),time()+30000);
                            }
                            foreach ($listaProductos as $key => $value) {
                            ?>
                                <tr>
                                    <td><?php echo $value; ?></td>
                                    <td>
                                        <button type="submit" name="borrar" value="<?php echo $key; ?>" class="btn btn-danger">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </form>
            </div>

            <?php
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