<?php
use modelo\CensoModelo as censo;
use modelo\PermisosModelo as Permiso;
use modelo\configNotificacionModelo as Mensaje;
use modelo\BitacoraModelo as Bitacora;

use config\componentes\configSistema as configSistema;
use component\initComponents as initComponents;
use component\header as header;

$config = new configSistema();

session_start();
if (!isset($_SESSION['usuario'])) {
    header('location:?pagina=login');
}

if (!is_file($config->_Dir_Model_().$pagina.$config->_MODEL_())) {
    echo "Falta definir la clase " . $pagina;
    exit;
}

if (is_file($config->_Dir_Vista_().$pagina.$config->_VISTA_())) {
    $permiso_usuario = new Permiso();
    $censo = new censo();
    $config = new Mensaje();
    $bitacora = new Bitacora();
    $modulo = 'Censo';

    //Establecer el id_usuario_rol para bitacora
    $id_usuario_rol = $bitacora->buscar_id_usuario_rol($_SESSION["usuario"]["tipo_usuario"], $_SESSION["usuario"]["id"]);
    $entorno = $bitacora->buscar_id_entorno('Censo');
    $fecha = date('Y-m-d h:i:s', time());

    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
        if ($accion == 'registrar') {
            $respuesta = $censo->incluir($_SESSION['usuario']['id'], $_POST['fecha_apertura'],$_POST['fecha_cierre'], $_POST['descripcion']);
            if ($respuesta['resultado']==1) {
                echo json_encode([
                    'estatus' => '1',
                    'icon' => 'success',
                    'title' => $modulo,
                    'message' => $respuesta['mensaje']
                ]);
                $bitacora->incluir($id_usuario_rol,$entorno,$fecha,"Registro");
            }else if($respuesta['resultado']==2){
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'info',
                    'title' => $modulo,
                    'message' => $respuesta['mensaje']
                ]);
            }else {
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'info',
                    'title' => $modulo,
                    'message' => 'El registro no fue procesado'
                ]); 
            }
            return 0;
            exit;
        }else if ($accion == 'eliminar') {
            $respuesta = $censo->eliminar($_POST['id']);
            if ($respuesta['resultado']==1) {
                echo json_encode([
                    'estatus' => '1',
                    'icon' => 'success',
                    'title' => $modulo,
                    'message' => 'Eliminación exitosa'
                ]);
                $bitacora->incluir($id_usuario_rol,$entorno,$fecha,"Eliminación");
            } else if ($respuesta['resultado']==2){
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'info',
                    'title' => $modulo,
                    'message' =>  $respuesta['mensaje']
                ]);
            }else {
                echo json_encode([
                    'estatus' => '0',
                    'icon' => 'error',
                    'title' => $modulo,
                    'message' => 'Registro no eliminado'
                ]);
            }
            return 0;
            exit;
        } else if ($accion == 'modificar') {
            $respuesta = $censo->modificar($_POST['id'],$_POST['fecha_apertura'],$_POST['fecha_cierre'],$_POST['descripcion']);
            if ($respuesta['resultado']==1) {
                echo json_encode([
                    'estatus' => '1',
                    'icon' => 'success',
                    'title' => $modulo,
                    'message' => $respuesta['mensaje']
                ]);
                $bitacora->incluir($id_usuario_rol,$entorno,$fecha,"Modificacion");
            }else if($respuesta['resultado']==2){
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'info',
                    'title' => $modulo,
                    'message' => $respuesta['mensaje']
                ]);
            }else if($respuesta['resultado']==3){
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'info',
                    'title' => $modulo,
                    'message' => $respuesta['mensaje']
                ]);
            }else {
                echo json_encode([
                    'estatus' => '0',
                    'icon' => 'error',
                    'title' => $modulo,
                    'message' => $respuesta['mensaje']
                ]);
            }
            return 0;
            exit;
        } else if ($accion == 'editar') {
            $datos = $censo->buscar($_POST['id']);

            foreach ($datos as $valor) {
                $id = $valor['id'];
                $finicio = $valor['fecha_apertura'];
                $fcierre = $valor['fecha_cierre'];
                $descripcion = $valor['descripcion'];
            }

            $fi = explode(" ", $finicio);
            $fechai = $fi[0];
            $horai = $fi[1];
            $ffi = explode("-", $fechai);
            $fieditar = $ffi[2] . "/" . $ffi[1] . "/" . $ffi[0] . " " . $horai;

            $fc = explode(" ", $fcierre);
            $fechac = $fc[0];
            $horac = $fc[1];
            $ffc = explode("-", $fechac);
            $fceditar = $ffc[2] . "/" . $ffc[1] . "/" . $ffc[0] . " " . $horac;

            echo json_encode([
                'id' => $id,
                'fecha_apertura' => $fieditar,
                'fecha_cierre' => $fceditar,
                'descripcion' => $descripcion,
            ]);
            return 0;
        }
    }
    $response = $permiso_usuario->mostrarpermisos($_SESSION["usuario"]["id"],$_SESSION["usuario"]["tipo_usuario"],"Censo");

    $r1 = $censo->listar();
    $datos = [];

    $components = new initComponents();
    $header = new header();
    require_once "vista/".$pagina."Vista.php";
} else {
    echo "Pagina en construccion";
}