<?php
use config\componentes\configSistema as configSistema;
use modelo\NotificacionesModelo as Notificacion;
$Notificacion = new Notificacion();

$config = new configSistema();
session_start();
if (!isset($_SESSION['usuario'])) {
	$redirectUrl = '?pagina=' . configSistema::_LOGIN_();
    echo '<script>window.location="' . $redirectUrl . '"</script>';
    die();
}


if (!is_file($config->_Dir_Model_().$pagina.$config->_MODEL_())) {
    echo "Falta definir la clase " . $pagina;
    exit;
}

if (is_file($config->_Dir_Vista_().$pagina.$config->_VISTA_())) {

    if(count(array_filter($_SESSION['usuario'])) == 0) {
        $redirectUrl = '?pagina=' . configSistema::_LOGIN_();
        echo '<script>window.location="' . $redirectUrl . '"</script>';
        die();
    }

    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
    if ($accion == 'cargar') {
        $r1 = $Notificacion->listar($_SESSION['usuario']["id"],$_SESSION['usuario']["tipo_usuario"]);
        echo json_encode($r1);
        return 0;
        }
    } 
    require_once "vista/" . $pagina . "Vista.php";

} else {
    echo "Pagina en construccion";
}