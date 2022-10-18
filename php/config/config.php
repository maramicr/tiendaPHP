<?php
include 'database.php';

define("CLIENT_ID", "AXN-HewQN-MmMt5CB9Y_U3IeH6472XhysRRnraXIWG-5D3s4PXQEl-JKpA5xETIrenhae5vX5YM5bM_4");
define("CURRENCY", "CRC");
define("KEY_TOKEN", "ADM.api-123?");
define("MONEDA", "¢");

session_start();

$num_cart = 0;
if(isset($_SESSION['carrito']['productos'])){
    $num_cart = count($_SESSION['carrito']['productos']);
}


?>