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
                <a href="#" class="btn btn-primary position-relative">Carrito <span id="num_cart" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        <?php echo $num_cart ?></span> </a>
            </div>
        </div>
    </div>
</header>

<body>
    <main>
        <div class="container pt-4">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                            <th>Accion</th>
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
                                    <td><?php echo MONEDA . number_format($precio_desc, 2, '.', ','); ?></td>
                                    <td>
                                        <input type="number" min="1" max="100" step="1" value="<?php echo $cantidad ?>" id="cantidad_<?php echo $_id; ?>" onchange="actualizaCantidad(this.value, <?php echo $_id; ?>)">
                                    </td>
                                    <td>
                                        <div id="subtotal_<?php echo $_id; ?>" name="subtotal[]">
                                            <?php echo MONEDA . number_format($subtotal, 2, '.', ','); ?>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="#" id="eliminar" class="btn btn-warning btn-sm" data-bs-id="<?php echo $_id ?>" data-bs-toggle="modal" data-bs-target="#eliminaModal">Eliminar</a>
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td colspan="3"></td>
                                <td colspan="2">
                                    <p class="h3" id="total">
                                        <?php echo MONEDA . number_format($total, 2, '.', ','); ?>
                                    </p>
                                </td>
                            </tr>
                    </tbody>
                <?php } ?>
                </table>
            </div>

            <?php if ($lista_carrito != null) { ?>
                <div class="row">
                    <div class="col-md-5 offset-md-7 d-grid gap-2">
                        <a href="pago.php" class="btn btn-primary btn-lg">Realizar pago</a>
                    </div>
                </div>
            <?php } ?>
    </main>
    <!-- Modal para eliminar artículo -->
    <div class="modal fade" id="eliminaModal" tabindex="-1" aria-labelledby="eliminaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="eliminaModalLabel">Alerta</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Desea eliminar el producto indicado?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="btn-elimina" type="button" class="btn btn-danger" onclick="eliminar()">Quitar producto</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous"></script>

    <script>
        function actualizaCantidad(cantidad, id) {
            let url = 'clases/act_carrito.php';
            let formData = new FormData();
            formData.append('action', 'agregar');
            formData.append('id', id);
            formData.append('cantidad', cantidad)

            fetch(url, {
                    method: 'POST',
                    body: formData,
                    mode: 'cors'
                }).then(response => response.json())
                .then(data => {
                    if (data.ok) {
                        let divsubtotal = document.getElementById('subtotal_' + id)
                        divsubtotal.innerHTML = data.sub

                        let total = 0.0;
                        let list = document.getElementsByName('subtotal[]');

                        for (let i = 0; i < list.length; i++) {
                            total += parseFloat(list[i].innerHTML.replace(/[$,]/g, ''));
                        }
                        total = new Intl.NumberFormat('es-CR', {
                            style: 'currency',
                            currency: 'CRC',
                            minimumFractionDigits: 2,
                        }).format(total);
                        document.getElementById('total').innerHTML =
                            '<?php echo MONEDA; ?>' + total;
                    }
                });
        }
    </script>

    <script>
        let eliminaModal = document.getElementById('eliminaModal');
        eliminaModal.addEventListener('show.bs.modal', function(event) {
            let button = event.relatedTarget;
            let id = button.getAttribute('data-bs-id');
            let buttonElimina = eliminaModal.querySelector('.modal-footer #btn-elimina');
            buttonElimina.value = id
        });

        function eliminar() {
            let botonElimina = document.getElementById('btn-elimina');
            let id = botonElimina.value;

            let url = 'clases/act_carrito.php';
            let formData = new FormData();
            formData.append('action', 'eliminar');
            formData.append('id', id);

            fetch(url, {
                    method: 'POST',
                    body: formData,
                    mode: 'cors'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.ok) {
                        location.reload();
                    }
                });
        }
    </script>

</body>

</html>