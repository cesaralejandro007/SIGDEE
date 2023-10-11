<?php
use modelo\BitacoraModelo as Bitacora;
use modelo\AspiranteModelo as Aspirante;
use config\componentes\configSistema as configSistema;


$config = new configSistema();


$aspirante = new Aspirante();

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

    require_once "vista/" . $pagina . "Vista.php";
} else {
    echo "Pagina en construccion";
}