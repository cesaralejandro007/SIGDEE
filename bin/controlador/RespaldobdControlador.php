<?php
use config\componentes\configSistema as configSistema;
use modelo\RespaldobdModelo as Respaldobd;
use modelo\BitacoraModelo as Bitacora;
$config = new configSistema();
$respaldobd = new Respaldobd();
$bitacora = new Bitacora();
session_start();
if (!isset($_SESSION['usuario'])) {
    header('location:?pagina=login');
}
if (!is_file($config->_Dir_Model_().$pagina.$config->_MODEL_())) {
    echo "Falta definir la clase " . $pagina;
    exit;
}
if (is_file($config->_Dir_Vista_().$pagina.$config->_VISTA_())) {
    if (isset($_POST['accion'])) {
    $accion = $_POST['accion'];
    if ($accion == 'verificar_password') {
        $response = $respaldobd->verificar_password($_POST['cedula']);
        //VERIFICAR CLAVE (password_hash)
        if(password_verify($_POST['clave_actual'], $response[0]['clave']) && $response[0]['rol']=="Super Usuario"){
            echo 1;
        }else if($response[0]['rol'] !="Super Usuario"){
            echo 2;
        }else{
            echo 0;
        }
        return 0;
    }else if ($accion == 'respaldarbd') {
        $response = $respaldobd->respaldarbd();
        if ($response){
           echo $response;
        }
        return 0;
    }
    } 
    require_once "vista/" . $pagina . "Vista.php";
} else {
    echo "Pagina en construcción";
}