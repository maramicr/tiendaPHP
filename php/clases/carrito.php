<?php

require '../config/config.php';

if(isset($_POST['codigo'])){
    $codigo = $_POST['codigo'];
    $token = $_POST['token'];

    $token_tmp = hash_hmac('sha1', $codigo, KEY_TOKEN);

    if ($token == $token_tmp) {
        if(isset($_SESSION['carrito']['productos'][$codigo])){
            $_SESSION['carrito']['productos'][$codigo]+=1; 
        }else{
            $_SESSION['carrito']['productos'][$codigo]=1;
        }

        $datos['numero'] = count($_SESSION['carrito']['productos']);
        $datos['ok'] = true;
        
    } else{
        $datos['ok'] = false;
    }   

}else{
    $datos['ok'] = false;
}

echo json_encode($datos);
