<?php
require 'config/config.php';
require_once 'config/database.php';
$db = new Database();
$con = $db->conectar();

$productos = isset($_SESSION['carrito']['productos']) ? $_SESSION['carrito']['productos'] : null;
// verifico estado de session----
//session_destroy();
// print_r($_SESSION);

$lista_carrito = array();

if ($productos != null) {
    foreach ($productos as $clave => $cantidad) {

        $sql = $con->prepare("SELECT id, nombre, precio, descuento, $cantidad AS cantidad FROM productos WHERE id=? AND activo=1");
        $sql->execute([$clave]);
        $lista_carrito[] = $sql->fetch(PDO::FETCH_ASSOC);
    }
} else {
    header("location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <!-- ---- paypal ----- -->
    <script src="https://www.paypal.com/sdk/js?client-id=AXN-HewQN-MmMt5CB9Y_U3IeH6472XhysRRnraXIWG-5D3s4PXQEl-JKpA5xETIrenhae5vX5YM5bM_4&currency=USD"></script>
    <!----- sweet alert------>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            </div>
        </div>
    </div>
</header>

<body>
    <main>        
        <div class="container pt-4">
            <div class="row">
                <div class="col-6">
                    <h4>Detalle de pago</h4>
                    <div id="paypal-button-container"></div>    
                </div>
                <div class="col-6">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($lista_carrito == null) {
                                    echo '<tr><td colspan="5" class="text-center"><b>Lista vacía</b></td></tr>';
                                } else {
                                    $total = 0;
                                    foreach ($lista_carrito as $producto) {
                                        $_id = $producto['id'];
                                        $nombre = $producto['nombre'];
                                        $precio = $producto['precio'];
                                        $descuento = $producto['descuento'];
                                        $cantidad = $producto['cantidad'];
                                        $precio_desc = $precio - (($precio * $descuento) / 100);
                                        $subtotal = $cantidad * $precio_desc;
                                        $total += $subtotal;

                                ?>
                                        <tr>
                                            <td><?php echo $nombre; ?></td>
                                            <td>
                                                <div id="subtotal_<?php echo $_id; ?>" name="subtotal[]">
                                                    <?php echo MONEDA . number_format($subtotal, 2, '.', ','); ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <td colspan="3">
                                            <p class="h3 text-end" id="total">
                                                <?php echo MONEDA . number_format($total, 2, '.', ','); ?>
                                            </p>
                                        </td>
                                    </tr>

                            </tbody>
                        <?php } ?>
                        </table>
                    </div>
                    
                </div>
            </div>
        </div>
    </main>
    <!-- script render paypal ---------------- -->
    <script>
        paypal.Buttons({
            style: {
                color: 'blue',
                shape: 'pill',
                label: 'pay'
            },

            // Sets up the transaction when a payment button is clicked
            createOrder: (data, actions) => {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '77.44' // Can also reference a variable or function
                        }
                    }]
                });
            },
            // Finalize the transaction after payer approval        
            onApprove: (data, actions) => {
                return actions.order.capture().then(function(orderData) {
                    // Successful capture!
                    // console.log('orderData');
                    const transaction = orderData.purchase_units[0].payments.captures[0];
                    alert(`Transaction ${transaction.status}: ${transaction.id}\n\nSee console for all available details`);
                    window.location.href = "completado.php"
                });
            },
            onCancel: (data) => {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Acción de pago cancelada!',
                    showConfirmButton: false,
                    timer: 1500
                });                
                console.log(data);
            },
        }).render('#paypal-button-container');
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous"></script>

</body>

</html>