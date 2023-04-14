<?php
use modelo\BitacoraModelo as Bitacora;
use modelo\AspiranteModelo as Aspirante;
use config\componentes\configSistema as configSistema;

$config = new configSistema();

$aspirante = new Aspirante();

session_start();
if (!isset($_SESSION['usuario'])) {
    header('location:?pagina=login');
}

if (!is_file($config->_Dir_Model_().$pagina.$config->_MODEL_())) {
    echo "Falta definir la clase " . $pagina;
    exit;
}

if (is_file($config->_Dir_Vista_().$pagina.$config->_VISTA_())) {

    require_once "vista/" . $pagina . "Vista.php";
} else {
    echo "Pagina en construccion";
}