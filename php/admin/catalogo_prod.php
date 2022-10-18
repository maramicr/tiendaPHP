<?php
require '../config/config.php';
require_once '../config/database.php';

$db = new Database();
$con = $db->conectar();

$sql = $con->prepare("SELECT id, nombre, detalle, precio FROM productos WHERE activo=1");
$sql->execute();
$resultado = $sql->fetchAll(PDO::FETCH_ASSOC);

//session_destroy();
// verifico estado de session----
print_r($_SESSION);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../css/estilos.css">
    <title>Catálogo de productos</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/estilos.css">

    <script src="https://kit.fontawesome.com/71af4709ae.js" crossorigin="anonymous"></script>
</head>
<header>
    <div class="navbar navbar-expand-lg navbar-dark bg-dark p-3">
        <div class="container">
            <a href="#" class="navbar-brand">

                <strong>Pinturas Una Mano</strong>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarHeader">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a href="#" class="nav-link active">Catálogo</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">Contacto</a>
                    </li>
                </ul>
                <a href="checkout.php" class="btn btn-primary position-relative">Carrito <span id="num_cart" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        <?php echo $num_cart; ?></span> </a>
            </div>
        </div>
    </div>
</header>

<body>
    <main>
        <div class="container pt-4">
            <h1 class="title">Lista de productos</h1>
            <?php foreach ($resultado as $row) { ?>
                <div>
                    <?php
                    $id = $row['id'];
                    $imagen = "../../img/productos/" . $id . "/principal.webp";

                    if (!file_exists($imagen)) {
                        $imagen = "../../img/sin-imagen.png";
                    }
                    ?>
                    <form method="POST" action="">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead">
                                    <tr>
                                        <th>Producto</th>
                                        <th>Detalle</th>
                                        <th>Imagen</th>
                                        <th>Precio</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <tr>
                                        <td class="col-2"><?php echo $row['nombre']; ?></td>
                                        <td class="col-4"><?php echo $row['detalle']; ?></td>
                                        <td class="col-2"><img src="<?php echo $imagen; ?>" class="d-block w-100 align-self-center p-2" alt="<?php echo $row['nombre']; ?>" style="max-width: 100px;"></td>
                                        <td class="col-2"><?php echo number_format($row["precio"], 2, '.', ','); ?></td>
                                        <td class="col-2">
                                            <input type="checkbox" name="producto[]" value="<?php echo $row['nombre']; ?>">
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                    </form>

                <?php } ?>
                </div>
        </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous"></script>
</body>