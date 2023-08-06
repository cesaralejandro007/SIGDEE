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


        $id_usuario_rol = $bitacora->buscar_id_usuario_rol($_SESSION["usuario"]["tipo_usuario"], $_SESSION["usuario"]["id"]);
        $entorno = $bitacora->buscar_id_entorno('Permisos');
        $fecha = date('Y-m-d h:i:s', time());

        $accion = $_POST['accion'];
    if ($accion == 'respaldarbd') {
       $response = $respaldobd->respaldarbd();
        if ($response==1) {
            $bitacora->incluir($id_usuario_rol,$entorno,$fecha,"Respaldo de BD");
            echo json_encode([
                'estatus' => '1',
                'icon' => 'success',
                'title' => 'Respaldo BD',
                'message' => 'La Base de datos fue respaldado con exito'
            ]);
        }else{
            echo json_encode([
                'estatus' => '2',
                'icon' => 'info',
                'title' => 'Respaldo BD',
                'message' => 'Error BD'
            ]);
        }
        return 0;
        }
    } 
    require_once "vista/" . $pagina . "Vista.php";
} else {
    echo "Pagina en construcción";
}