<?php
use config\componentes\configSistema as configSistema;
use modelo\NotificacionesModelo as Notificacion;
$Notificacion = new Notificacion();
use modelo\LoginModelo as login;

$config = new configSistema();
$login = new login();
session_start();
if (!isset($_SESSION['usuario'])) {
    header('location:?pagina=login');
}


if (!is_file($config->_Dir_Model_().$pagina.$config->_MODEL_())) {
    echo "Falta definir la clase " . $pagina;
    exit;
}

if (is_file($config->_Dir_Vista_().$pagina.$config->_VISTA_())) {

    $private_key = $login->obtener_clave_privada($_SESSION['id_usuario']);
    
    $t_private_key = base64_decode($private_key[0]["privatekey"]);

    $decrypted = [];
    foreach ($_SESSION['usuario'] as $k => $v) {
        openssl_private_decrypt($v, $decrypted_data, $t_private_key);
        $decrypted[$k] = $decrypted_data;
    }

    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
    if ($accion == 'cargar') {
        $r1 = $Notificacion->listar($decrypted["id"],$decrypted["tipo_usuario"]);
        echo json_encode($r1);
        return 0;
        }
    } 
    require_once "vista/" . $pagina . "Vista.php";

} else {
    echo "Pagina en construccion";
}