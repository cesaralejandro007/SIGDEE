<?php
use modelo\ModuloModelo as Modulo;
use modelo\configNotificacionModelo as Mensaje;
use modelo\PermisosModelo as Permiso;
use modelo\BitacoraModelo as Bitacora;
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
    $modulo = new Modulo();
    $permiso_usuario = new Permiso();
    $bitacora = new Bitacora();
    $config = new Mensaje();
    $modul = 'Modulos de Emprendimiento';
    $response = $permiso_usuario->mostrarpermisos($_SESSION["usuario"]["id"],$_SESSION["usuario"]["tipo_usuario"],"Modulo");
    //Establecer el id_usuario_rol para bitacora
    $id_usuario_rol = $bitacora->buscar_id_usuario_rol($_SESSION["usuario"]["tipo_usuario"], $_SESSION["usuario"]["id"]);
    $entorno = $bitacora->buscar_id_entorno('Modulo');
    $fecha = date('Y-m-d h:i:s', time());

    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
        if ($accion == 'registrar') {
            if ($response[0]["registrar"] == "true"){
                $respuesta = $modulo->incluir($_POST['nombre']);
                if ($respuesta['resultado']==1) {
                    echo json_encode([
                        'estatus' => '1',
                        'icon' => 'success',
                        'title' => $modul,
                        'message' => $respuesta['mensaje']
                    ]);
                    $bitacora->incluir($id_usuario_rol,$entorno,$fecha,"Registro");
                } else if ($respuesta['resultado']==2){
                    echo json_encode([
                        'estatus' => '2',
                        'icon' => 'info',
                        'title' => $modul,
                        'message' => $respuesta['mensaje']
                    ]);
                }else if ($respuesta['resultado']==3){
                    echo json_encode([
                        'estatus' => '2',
                        'icon' => 'info',
                        'title' => $modul,
                        'message' => $respuesta['mensaje']
                    ]);
                }else{
                    echo json_encode([
                        'estatus' => '2',
                        'icon' => 'error',
                        'title' => $modul,
                        'message' => $respuesta['mensaje']
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
                $respuesta = $modulo->eliminar($_POST['id']);
                if ($respuesta['resultado']==1) {
                    echo json_encode([
                        'estatus' => '1',
                        'icon' => 'success',
                        'title' => $modul,
                        'message' => $respuesta['mensaje']
                    ]);
                    $bitacora->incluir($id_usuario_rol,$entorno,$fecha,"Eliminación");
                } else if ($respuesta['resultado'] == 2) {
                    echo json_encode([
                        'estatus' => '2',
                        'icon' => 'info',
                        'title' => $modul,
                        'message' => $respuesta['mensaje']
                    ]);
                } else if ($respuesta['resultado'] == 3){
                    echo json_encode([
                        'estatus' => '0',
                        'icon' => 'error',
                        'title' => $modul,
                        'message' => $respuesta['mensaje']
                    ]);
                }else{
                    echo json_encode([
                        'estatus' => '2',
                        'icon' => 'error',
                        'title' => $modul,
                        'message' => $respuesta['mensaje']
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
                $respuesta = $modulo->modificar($_POST['id'],$_POST['nombre']);
                if ($respuesta['resultado']==1) {
                    echo json_encode([
                        'estatus' => '1',
                        'icon' => 'success',
                        'title' => $modul,
                        'message' => $respuesta['mensaje']
                    ]);
                    $bitacora->incluir($id_usuario_rol,$entorno,$fecha,"Modificacion");
                } else if ($respuesta['resultado'] == 2) {
                    echo json_encode([
                        'estatus' => '0',
                        'icon' => 'info',
                        'title' => $modul,
                        'message' => $respuesta['mensaje']
                    ]);
                }else if ($respuesta['resultado'] == 3) {
                    echo json_encode([
                        'estatus' => '0',
                        'icon' => 'info',
                        'title' => $modul,
                        'message' => $respuesta['mensaje']
                    ]);
                }else{
                    echo json_encode([
                        'estatus' => '2',
                        'icon' => 'error',
                        'title' => $modul,
                        'message' => $respuesta['mensaje']
                    ]);
                }
                return 0;
                exit;
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
            $datos = $modulo->cargar($_POST['id']);
            foreach ($datos as $valor) {
                echo json_encode([
                    'id' => $valor[0],
                    'nombre' => $valor[1],
                ]);
            }
            return 0;
        }
    }

    $r1 = $modulo->listar();
    $datos = [];
    if (isset($response[0]["nombreentorno"])) {
        require_once "vista/" . $pagina . "Vista.php";
    }else{
        require_once "vista/error_Permisos.php";
    }
} else {
    echo "Pagina en construccion";
}