<?php
use modelo\EmprendimientoModelo as Emprendimiento;
use modelo\EmprendimientoModuloModelo as EmprendimientoModulo;
use modelo\AreaEmprendimientoModelo as AreaEmprendimiento;
use modelo\configNotificacionModelo as Mensaje;
use modelo\PermisosModelo as Permiso;
use modelo\BitacoraModelo as Bitacora;
use modelo\ModuloModelo as Modulo;

use config\componentes\configSistema as configSistema;

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

    $area = new AreaEmprendimiento();
    $emprendimiento = new Emprendimiento();
    $modulo = new Modulo();
    $permiso_usuario = new Permiso();
    $emprendimiento_Modulo = new EmprendimientoModulo();
    $bitacora = new Bitacora();
    $config = new Mensaje();
    $modul = 'Emprendimiento';
    $response = $permiso_usuario->mostrarpermisos($_SESSION['usuario']["id"],$_SESSION['usuario']["tipo_usuario"],"Emprendimiento");
    //Establecer el id_usuario_rol para bitacora
    $id_usuario_rol = $bitacora->buscar_id_usuario_rol($_SESSION['usuario']["tipo_usuario"], $_SESSION['usuario']["id"]);
    $entorno = $bitacora->buscar_id_entorno('Emprendimiento');
    $fecha = date('Y-m-d h:i:s', time());

    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
        if ($accion == 'registrar') {
            if ($response[0]["registrar"] == "true"){
                $response = $emprendimiento->incluir($_POST['nombre'],$_POST['id_area']);
                if ($response['resultado']==1) {
                    echo json_encode([
                        'estatus' => '1',
                        'icon' => 'success',
                        'title' => $modul,
                        'message' => $response['mensaje']
                    ]);
                    $bitacora->incluir($id_usuario_rol,$entorno,$fecha,"Registro");
                } else if ($response['resultado']==2) {
                    echo json_encode([
                        'estatus' => '2',
                        'icon' => 'info',
                        'title' => $modul,
                        'message' => $response['mensaje']
                    ]);
                }else if ($response['resultado']==3) {
                    echo json_encode([
                        'estatus' => '2',
                        'icon' => 'info',
                        'title' => $modul,
                        'message' => $response['mensaje']
                    ]);
                }else if ($response['resultado']==4) {
                    echo json_encode([
                        'estatus' => '2',
                        'icon' => 'info',
                        'title' => $modul,
                        'message' => $response['mensaje']
                    ]);
                }else {
                    echo json_encode([
                        'estatus' => '0',
                        'icon' => 'error',
                        'title' => $modul,
                        'message' => $response['mensaje']
                    ]);
                }
                return 0;
                exit;
            }else{
                echo json_encode([
                    'estatus' => '0',
                    'icon' => 'error',
                    'title' => $modul,
                    'message' => 'No tiene permisos para registrar.'
                ]);
                return 0;
                exit;
            } 
        } else if ($accion == 'eliminar') {
            if ($response[0]["eliminar"] == "true"){
                $response = $emprendimiento->eliminar($_POST['id']);
                if ($response['resultado']==1) {
                    echo json_encode([
                        'estatus' => '1',
                        'icon' => 'success',
                        'title' => $modul,
                        'message' => $response['mensaje']
                    ]);
                    $bitacora->incluir($id_usuario_rol,$entorno,$fecha,"Eliminación");
                } else if ($response == 2) {
                    echo json_encode([
                        'estatus' => '2',
                        'icon' => 'info',
                        'title' => $modul,
                        'message' => $response['mensaje']
                    ]);
                }else if ($response == 3) {
                    echo json_encode([
                        'estatus' => '2',
                        'icon' => 'info',
                        'title' => $modul,
                        'message' => $response['mensaje']
                    ]);
                }else if ($response == 4) {
                    echo json_encode([
                        'estatus' => '2',
                        'icon' => 'info',
                        'title' => $modul,
                        'message' => $response['mensaje']
                    ]);
                }  else {
                    echo json_encode([
                        'estatus' => '2',
                        'icon' => 'info',
                        'title' => $modul,
                        'message' => $response['mensaje']
                    ]);
                }
                return 0;
                exit;
            }else{
                echo json_encode([
                    'estatus' => '0',
                    'icon' => 'error',
                    'title' => $modul,
                    'message' => 'No tiene permisos para eliminar el registro.'
                ]);
                return 0;
                exit;
            } 
        } else if ($accion == 'modificar') {
            if ($response[0]["modificar"] == "true"){
                $response = $emprendimiento->modificar($_POST['id'],$_POST['nombre'],$_POST['id_area']);
                if ($response['resultado']==1) {
                    echo json_encode([
                        'estatus' => '1',
                        'icon' => 'success',
                        'title' => $modul,
                        'message' => $response['mensaje']
                    ]);
                    $bitacora->incluir($id_usuario_rol,$entorno,$fecha,"Modificacion");
                    return 0;
                } else if ($response['resultado']==2){
                    echo json_encode([
                        'estatus' => '2',
                        'icon' => 'info',
                        'title' => $modul,
                        'message' => $response['mensaje']
                    ]);
                    return 0;
                }else if ($response['resultado']==3){
                    echo json_encode([
                        'estatus' => '2',
                        'icon' => 'info',
                        'title' => $modul,
                        'message' => $response['mensaje']
                    ]);
                    return 0;
                }else if ($response['resultado']==4){
                    echo json_encode([
                        'estatus' => '2',
                        'icon' => 'info',
                        'title' => $modul,
                        'message' => $response['mensaje']
                    ]);
                    return 0;
                }else if ($response['resultado']==5){
                    echo json_encode([
                        'estatus' => '2',
                        'icon' => 'info',
                        'title' => $modul,
                        'message' => $response['mensaje']
                    ]);
                    return 0;
                }else {
                    echo json_encode([
                        'estatus' => '2',
                        'icon' => 'info',
                        'title' => $modul,
                        'message' => $response['mensaje']
                    ]);
                    return 0;
                }
            }else{
                echo json_encode([
                    'estatus' => '0',
                    'icon' => 'error',
                    'title' => $modul,
                    'message' => 'No tiene permisos para modificar el registro.'
                ]);
                return 0;
                exit;
            } 
        } else if ($accion == 'editar') {
            $datos = $emprendimiento->cargar($_POST['id']);
            foreach ($datos as $valor) {
                echo json_encode([
                    'id' => $valor[0],
                    'nombre' => $valor[1],
                    'id_area' => $valor[2],
                ]);
            }
            return 0;
        } else if ($accion == 'registrarme') {
            $response = $emprendimiento_Modulo->incluir($_POST['idmodulo'],$_POST['idemprendimiento'],$_POST['status']);
            if ($response['resultado']==1) {
                echo json_encode([
                    'estatus' => '1',
                    'icon' => 'success',
                    'title' => $modul,
                    'message' => $response['mensaje']
                ]);
                return 0;
            } else if ($response['resultado']==2) {
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'info',
                    'title' => $modul,
                    'message' => $response['mensaje']
                ]);
                return 0;
            }else if ($response['resultado']==3) {
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'info',
                    'title' => $modul,
                    'message' => $response['mensaje']
                ]);
                return 0;
            }
            else if ($response['resultado']==4) {
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'info',
                    'title' => $modul,
                    'message' => $response['mensaje']
                ]);
                return 0;
            }
            else if ($response['resultado']==5) {
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'info',
                    'title' => $modul,
                    'message' => $response['mensaje']
                ]);
                return 0;
            }
            exit;
        } else if ($accion == "cargarme") {
            $cargarme = $emprendimiento_Modulo->cmud_emprendimeinto($_POST['id_emprendimiento']);
            echo json_encode($cargarme);
            return 0;
        } else if ($accion == "act_des") {
            $des_act = $emprendimiento->actualizarstatus($_POST['idemprendimiento'],$_POST['status']);
            if ($des_act['resultado']==1) {
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'success',
                    'title' => $modul,
                    'message' => $des_act['mensaje']
                ]);
            }else if ($des_act['resultado']==2) {
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'success',
                    'title' => $modul,
                    'message' => $des_act['mensaje']
                ]);
            }else if ($des_act['resultado']==3) {
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'error',
                    'title' => $modul,
                    'message' => $des_act['mensaje']
                ]);
            }else{
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'error',
                    'title' => $modul,
                    'message' => $des_act['mensaje']
                ]);
            }
            return 0;
            exit;
        } else if ($accion == "cargarcheckem") {
            $cargarem = $emprendimiento->cargar_emprendimiento();
            echo json_encode($cargarem);
            return 0;
        }
    }
    $r1 = $emprendimiento->listar();
    $r2 = $area->listar();
    $r3 = $modulo->listar();
    $datos = [];
    if (isset($response[0]["nombreentorno"])) {
        require_once "vista/" . $pagina . "Vista.php";
    }else{
        require_once "vista/error_Permisos.php";
    }
} else {
    echo "Pagina en construccion";
}