<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../css/estilos.css">
    <title>Carrito</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/estilos.css">

    <script src="https://kit.fontawesome.com/71af4709ae.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container mt-3 text-center">
        <h1 class="title">Carrito de compras</h1>
        <div class="row">
            <div class="col-12">
                <form method="POST" action="">
                    <table class="table table-stripped">
                        <thead class="thead-inverse">
                            <tr>
                                <th>Nombre</th>
                                <th>Detalle</th>
                                <th>Imagen</th>
                                <th>Precio</th>
                                <th>Acción</th>
                                <th><button type="submit" name="agregar" class="btn btn-primary">
                                <i class="fa fa-cart-plus"></i>
                                </button></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include 'conexion.php';
                            $query = ("SELECT * FROM productos");
                            $resultado = mysqli_query($conexion, $query) or die(mysqli_error($conexion));
                            // creacion de cookies --------------
                            if(isset($_REQUEST['producto'])){ 
                            setcookie("producto", serialize($_REQUEST['producto']),time()+3000);
                            }
                            while ($row = mysqli_fetch_assoc($resultado)){
                                if(isset($_REQUEST['producto'])){
                                $este = in_array($row['nombre'],$_REQUEST['producto']);
                                }else{
                                    $listaProducto=unserialize($_COOKIE['producto']);
                                    $este = in_array($row['nombre'],$listaProducto);
                                }
                            
                            ?> 
                            <tr>
                                <td><?php echo $row['nombre']; ?></td>
                                <td><?php echo $row['detalle']; ?></td>
                                <td><img src="<?php echo $row['imagen']; ?>" class="card-img-top carrito__img" alt="<?php echo $row['nombre']; ?>" style="width: 50%;"></td>
                                <td><?php echo $row['precio']; ?></td>
                                <td><input type="checkbox" name="producto[]" value="<?php echo $row['nombre']; ?>" <?php echo $este?"checked='checked'":" "; ?> ></td>

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