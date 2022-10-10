<?php
require 'config/config.php';
require_once 'config/database.php';

$db = new Database();
$con = $db->conectar();

$codigo = isset($_GET['codigo']) ? $_GET['codigo'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';

if ($codigo == '' || $token == '') {
    echo "<script>alert('Error al procesar la petición!');window.location='/php-avanzado/tienda/php'</script>";
    exit;
} else {
    $token_tmp = hash_hmac('sha1', $codigo, KEY_TOKEN);

    if ($token == $token_tmp) {
        $sql = $con->prepare("SELECT count(codigo) FROM productos WHERE codigo=? AND activo=1");
        $sql->execute([$codigo]);

        if ($sql->fetchColumn() > 0) {
            $sql = $con->prepare("SELECT nombre, detalle, precio, descuento FROM productos WHERE codigo=? AND activo=1 LIMIT 1");
            $sql->execute([$codigo]);
            $row = $sql->fetch(PDO::FETCH_ASSOC);
            $nombre = $row['nombre'];
            $detalle = $row['detalle'];
            $precio = $row['precio'];
            $descuento = $row['descuento'];
            $precio_desc = $precio - (($precio * $descuento) / 100);

            $dir_img = '../img/productos/' . $codigo . '/';
            $ruta_img = $dir_img . '/principal.webp';

            if (!file_exists($ruta_img)) {
                $ruta_img = "../img/sin-imagen.png";
            }

            $imagenes = array();
            if (file_exists($dir_img)){ 
            $dir = dir($dir_img);

            while (($archivo = $dir->read()) != false) {
                if ($archivo != 'principal.webp' && (strpos($archivo, 'webp') || strpos($archivo, 'jpg') || strpos($archivo, 'jpeg') || strpos($archivo, 'png') || strpos($archivo, 'pdf'))) {
                    $imagenes[] = $dir_img . $archivo;
                }
            }
            $dir->close();
        }
        }
    } else {
        echo "<script>alert('Error al procesar la petición!');window.location='/php-avanzado/tienda/php'</script>";
        exit;
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    
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
                        <a href="index.php" class="nav-link active">Catálogo</a>
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

            <div class="row">
                <div class="col-md-6 order-md-1">
                    <!-- carousel start------------------- -->
                    <div id="carouselImg" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="<?php echo $ruta_img; ?>" class="d-block w-100 p-4" alt="<?php echo $row['nombre']; ?>">
                            </div>

                            <?php foreach ($imagenes as $img) { ?>
                                <div class="carousel-item">
                                    <img src="<?php echo $img; ?>" class="d-block w-100 p-4" alt="<?php echo $row['nombre']; ?>">
                                </div>
                            <?php } ?>

                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselImg" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselImg" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>

                    <!-- end carousel ------------------- -->

                </div>
                <div class="col-md-6 order-md-2">
                    <h2><?php echo $nombre; ?></h2>

                    <?php if ($descuento > 0) { ?>
                        <p><del><?php echo MONEDA . number_format($precio, 2, '.', ','); ?></del></p>
                        <h2>
                            <?php echo MONEDA . number_format($precio_desc, 2, '.', ','); ?>
                            <small class="text-success"><?php echo $descuento;?>% descuento</small>
                        </h2>
                    <?php } else { ?>
                        <h2><?php echo MONEDA . number_format($precio, 2, '.', ','); ?></h2>
                    <?php } ?>
                    <p class="lead">
                        <?php echo $detalle; ?>
                    </p>
                    <div class="d-grid gap-3 col-10 mx-auto">
                        <button class="btn btn-primary" type="button">Comprar ahora</button>
                        <button class="btn btn-outline-primary" type="button" onclick="addProducto(<?php echo $codigo; ?>, '<?php echo $token_tmp ?>')">Agregar al carrito</button>
                    </div>
                </div>
            </div>
        </div>


    </main>

    <script type="text/javascript" src="../js/add.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous"></script>


</body>