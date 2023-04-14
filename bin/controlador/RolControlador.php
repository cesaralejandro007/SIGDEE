<?php
use modelo\RolModelo as Rol;
use modelo\PermisosModelo as Permiso;
use modelo\BitacoraModelo as Bitacora;
use modelo\EntornoSistemaModelo as EntornoSistema;
use config\componentes\configSistema as configSistema;
$config = new configSistema;

session_start();
if (!isset($_SESSION['usuario'])) {
    header('location:?pagina=Login');
}
if (!is_file($config->_Dir_Model_().$pagina.$config->_MODEL_())) {
    echo "Falta definir la clase " . $pagina;
    exit;
}

if (is_file($config->_Dir_Vista_().$pagina.$config->_VISTA_())) {
    $rol = new Rol();
    $permiso = new Permiso();
    $bitacora = new Bitacora();
    $modulo = 'Rol: ';

    if (isset($_POST['accion'])) {

        $id_usuario_rol = $bitacora->buscar_id_usuario_rol($_SESSION["usuario"]["tipo_usuario"], $_SESSION["usuario"]["id"]);
        $entorno = $bitacora->buscar_id_entorno('Permisos');
        $fecha = date('Y-m-d h:i:s', time());

        $accion = $_POST['accion'];
        if ($accion == 'registrar') {
            $response = $rol->incluir($_POST['nombre']);
            if ($response["resultado"]==1) {
                $bitacora->incluir($id_usuario_rol,$entorno,$fecha,"Registro de Rol");
                echo json_encode([
                    'estatus' => '1',
                    'icon' => 'success',
                    'title' => $modulo,
                    'message' => $response["mensaje"]
                ]);
            } else if ($response['resultado'] == 2) {
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'info',
                    'title' => $modulo,
                    'message' => $response["mensaje"]
                ]);
            }else if ($response['resultado'] == 3) {
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'info',
                    'title' => $modulo,
                    'message' => $response["mensaje"]
                ]);
            }else {
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'info',
                    'title' => $modulo,
                    'message' => $response["mensaje"]
                ]);
            }
            return 0;
            exit;
        } else if ($accion == 'eliminar') {
            $response = $rol->eliminar($_POST['id']);
            if ($response['resultado'] == 1) {
                echo json_encode([
                    'estatus' => '1',
                    'icon' => 'success',
                    'title' => $modulo,
                    'message' => $response["mensaje"]
                ]);
                $bitacora->incluir($id_usuario_rol,$entorno,$fecha,"Eliminación de Rol");
            } else if ($response['resultado'] == 2) {
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'info',
                    'title' => $modulo,
                    'message' => $response["mensaje"]
                ]);
            }else if ($response['resultado'] == 3) {
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'info',
                    'title' => $modulo,
                    'message' => $response["mensaje"]
                ]);
            }else if ($response['resultado'] == 4) {
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'info',
                    'title' => $modulo,
                    'message' => $response["mensaje"]
                ]);
            } else {
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'info',
                    'title' => $modulo,
                    'message' => $response["mensaje"]
                ]);
            }
            return 0;
            exit;
        } else if ($accion == 'modificar') {
            $response = $rol->modificar($_POST['id'],$_POST['nombre']);
            if ($response['resultado']== 1) {
                echo json_encode([
                    'estatus' => '1',
                    'icon' => 'success',
                    'title' => $modulo,
                    'message' => $response['mensaje']
                ]);
                $bitacora->incluir($id_usuario_rol,$entorno,$fecha,"Modificacion de Rol");
            }else if ($response['resultado'] == 2) {
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'info',
                    'title' => $modulo,
                    'message' => $response["mensaje"]
                ]);
            }else if ($response['resultado'] == 3) {
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'info',
                    'title' => $modulo,
                    'message' => $response["mensaje"]
                ]);
            } else {
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'info',
                    'title' => $modulo,
                    'message' => $response['mensaje']
                ]);
            }
            return 0;
            exit;
        } else if ($accion == 'editar') {
            $datos = $rol->cargar($_POST['id']);
            foreach ($datos as $valor) {
                echo json_encode([
                    'id' => $valor[0],
                    'nombre' => $valor[1],
                ]);
            }
            return 0;
        } else if ($accion == 'registrarpermisos') {
            $response = $permiso->gestionarpermisos($_POST['id_rol'],$_POST['id_entorno'],$_POST['entorno'],$_POST['registrar'],$_POST['consultar'],$_POST['eliminar'],$_POST['modificar']);
            if ($response['resultado']== 1) {
                echo json_encode([
                    'estatus' => '1',
                    'icon' => 'success',
                    'title' => 'Permisos: ',
                    'message' => $response['mensaje']
                ]);
                $bitacora->incluir($id_usuario_rol,$entorno,$fecha,"Registro de Permisos");
            } else if($response['resultado']== 2) {
                echo json_encode([
                    'estatus' => '1',
                    'icon' => 'success',
                    'title' => 'Permisos: ',
                    'message' => $response['mensaje']
                ]);
                $bitacora->incluir($id_usuario_rol,$entorno,$fecha,"Permisos Eliminados");
            }else if($response['resultado']== 3) {
                echo json_encode([
                    'estatus' => '1',
                    'icon' => 'success',
                    'title' => 'Permisos: ',
                    'message' => $response['mensaje']
                ]);
                $bitacora->incluir($id_usuario_rol,$entorno,$fecha,"Permisos Actualizados");
            }else {
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'info',
                    'title' => $modulo,
                    'message' => $response['mensaje']
                ]);
            }   
            return 0;
            exit;
        } else if ($accion == "cargarp") {
            $cargarp = $permiso->cpermisos($_POST['rol']);
            echo json_encode($cargarp);
            return 0;
        }
    }

    $r1 = $rol->listar();
    $modulopermiso = $permiso->modulos_relacionados();
    $rol_id = '';
    $datos = [];
    require_once "vista/" . $pagina . "Vista.php";
} else {
    echo "Pagina en construccion";
}