<?php
use modelo\EntornoSistemaModelo as EntornoSistema;
use config\componentes\configSistema as configSistema;

$config = new configSistema();

session_start();
if (!isset($_SESSION['usuario'])) {
    header('location:?pagina=Login');
}
if (!is_file($config->_Dir_Model_().$pagina.$config->_MODEL_())) {
    echo "Falta definir la clase " . $pagina;
    exit;
}

if (is_file($config->_Dir_Vista_().$pagina.$config->_VISTA_())) {
    $entorno = new EntornoSistema();
    $modulo = 'Entornos del Sistema';

    $r1 = $entorno->listar();
    $datos = [];
    require_once "vista/" . $pagina . "Vista.php";
} else {
    echo "Pagina en construccion";
}