<?php
use modelo\PermisosModelo as Permiso;
use modelo\BitacoraModelo as Bitacora;
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
    $permiso_usuario = new Permiso();
    $bitacora = new Bitacora();
    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
        if ($accion == 'consultarfechabitacora') {
            $r1 = $bitacora->listar_bitacora_rango($_POST['fecha_inicio'],$_POST['fecha_fin']);
            echo json_encode($r1);
            return 0;
        }
    }
    $r1 = $bitacora->listar();
    $datos = [];
    require_once "vista/" . $pagina . "Vista.php";
} else {
    echo "Pagina en construccion";
}