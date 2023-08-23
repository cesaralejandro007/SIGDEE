<?php
use modelo\EvaluacionModelo as Evaluacion;
use modelo\configNotificacionModelo as Mensaje;
use modelo\PermisosModelo as Permiso;
use modelo\BitacoraModelo as Bitacora;
use config\componentes\configSistema as configSistema;
use modelo\LoginModelo as login;

$config = new configSistema();
$login = new login();
session_start();
if (!isset($_SESSION['usuario'])) {
    header('location:?pagina=Login');
}

if (!is_file($config->_Dir_Model_().$pagina.$config->_MODEL_())) {
    echo "Falta definir la clase " . $pagina;
    exit;
}

if (is_file($config->_Dir_Vista_().$pagina.$config->_VISTA_())) {

    $private_key = $login->obtener_clave_privada($_SESSION['id_usuario']);
    
    $t_private_key = base64_decode($private_key[0]["privatekey"]);

    $decrypted = [];
    foreach ($_SESSION['usuario'] as $k => $v) {
        openssl_private_decrypt($v, $decrypted_data, $t_private_key);
        $decrypted[$k] = $decrypted_data;
    }

    $evaluacion= new Evaluacion();
    $permiso_usuario = new Permiso();
    $config = new Mensaje();
    $bitacora = new Bitacora();
    $modulo = 'Evaluacion';

    $response = $permiso_usuario->mostrarpermisos($decrypted["tipo_usuario"], $decrypted["id"],"Evaluaciones");
    //Establecer el id_usuario_rol para bitacora
    $id_usuario_rol = $bitacora->buscar_id_usuario_rol($decrypted["tipo_usuario"], $decrypted["id"]);
    $entorno = $bitacora->buscar_id_entorno('Evaluaciones');
    $fecha = date('Y-m-d h:i:s', time());

    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
        if ($accion == 'registrar') {
            if ($response[0]["registrar"] == "true"){
                $ruta = "content/evaluaciones/";
                if (isset($_FILES['archivo']['name'])) {
                    $nombre_archivo = $_FILES['archivo']['name'];
                $subir = $ruta . "/" . $nombre_archivo;
                if (move_uploaded_file($_FILES['archivo']['tmp_name'], $subir)) {
                    $response = $evaluacion->incluir($_POST['nombre'],$_POST['descripcion'],$nombre_archivo);
                        if ($response['resultado']==1) {
                            echo json_encode([
                                'estatus' => '1',
                                'icon' => 'success',
                                'title' => $modulo,
                                'message' => $response['mensaje']
                            ]);
                            $bitacora->incluir($id_usuario_rol,$entorno,$fecha,"Registro");
                        } else if ($response['resultado']==2) {
                            echo json_encode([
                                'estatus' => '2',
                                'icon' => 'info',
                                'title' => $modulo,
                                'message' => $response['mensaje']
                            ]);
                        }else if ($response['resultado']==3) {
                            echo json_encode([
                                'estatus' => '2',
                                'icon' => 'info',
                                'title' => $modulo,
                                'message' => $response['mensaje']
                            ]);
                        } else {
                            echo json_encode([
                                'estatus' => '0',
                                'icon' => 'error',
                                'title' => $modulo,
                                'message' => $respuesta['mensaje']
                            ]);
                        }
                        return 0;
                        exit;
                    } else {
                        echo json_encode([
                            'estatus' => '2',
                            'icon' => 'info',
                            'title' => $modulo,
                            'message' => 'Nombre Repetido'
                        ]);
                        return 0;
                    } 
                } else {
                    echo json_encode([
                        'estatus' => '2',
                        'icon' => 'info',
                        'title' => $modulo,
                        'message' => 'Seleccione Archivos'
                    ]);
                } 
                return 0;
                exit;
            }else{
                echo json_encode([
                    'estatus' => '0',
                    'icon' => 'error',
                    'title' => $modulo,
                    'message' => 'No tiene permisos para registrar.'
                ]);
                return 0;
                exit;
            } 
        } else if ($accion == 'eliminar') {
            if ($response[0]["eliminar"] == "true"){
                $response = $evaluacion->eliminar($_POST['id']);
                if ($response['resultado']==1) {
                    echo json_encode([
                        'estatus' => '1',
                        'icon' => 'success',
                        'title' => $modulo,
                        'message' => $response['mensaje']
                    ]);
                    $bitacora->incluir($id_usuario_rol,$entorno,$fecha,"Eliminación");
                } else if ($response['resultado']==2) {
                    echo json_encode([
                        'estatus' => '2',
                        'icon' => 'info',
                        'title' => $modulo,
                        'message' => $response['mensaje']
                    ]);
                }else if ($response['resultado']==3) {
                    echo json_encode([
                        'estatus' => '2',
                        'icon' => 'info',
                        'title' => $modulo,
                        'message' => $response['mensaje']
                    ]);
                }
                else {
                    echo json_encode([
                        'estatus' => '0',
                        'icon' => 'error',
                        'title' => $modulo,
                        'message' => $respuesta['mensaje']
                    ]);
                }
                return 0;
                exit;
            }else{
                echo json_encode([
                    'estatus' => '0',
                    'icon' => 'error',
                    'title' => $modulo,
                    'message' => 'No tiene permisos para eliminar el registro.'
                ]);
                return 0;
                exit;
            } 
        } else if ($accion == 'modificar') {
            if ($response[0]["modificar"] == "true"){
                $response = $evaluacion->modificar($_POST['id'],$_POST['nombre'],$_POST['descripcion']);
                if ($response['resultado']==1) {
                    if(isset($_FILES['archivo']['tmp_name'])) {
                        $ruta = "content/evaluaciones";
                        $nombre_archivo = $_POST['nombre_antes'];
                        $antes = $ruta . "/" . $nombre_archivo;
                        $subir = $ruta . "/" . $_FILES['archivo']['name'];
                        unlink($antes);
                        move_uploaded_file($_FILES['archivo']['tmp_name'], $subir);
                        $evaluacion->cambiar_archivo($_POST['id'],$_FILES['archivo']['name']);
                    }
                    echo json_encode([
                        'estatus' => '1',
                        'icon' => 'success',
                        'title' => $modulo,
                        'message' => $response['mensaje']
                    ]);
                    $bitacora->incluir($id_usuario_rol,$entorno,$fecha,"Modificacion");
                } else if($response['resultado']==2) {
                    echo json_encode([
                        'estatus' => '2',
                        'icon' => 'info',
                        'title' => $modulo,
                        'message' => $response['mensaje']
                    ]);
                }else if($response['resultado']==3) {
                    echo json_encode([
                        'estatus' => '2',
                        'icon' => 'info',
                        'title' => $modulo,
                        'message' => $response['mensaje']
                    ]);
                }else{
                    echo json_encode([
                        'estatus' => '0',
                        'icon' => 'error',
                        'title' => $modulo,
                        'message' => $respuesta['mensaje']
                    ]);
                }
                return 0;
                exit;
            }else{
                echo json_encode([
                    'estatus' => '0',
                    'icon' => 'error',
                    'title' => $modulo,
                    'message' => 'No tiene permisos para modificar el registro.'
                ]);
                return 0;
                exit;
            } 
        } else if ($accion == 'editar') {
            $datos = $evaluacion->cargar($_POST['id']);
            foreach ($datos as $valor) {
                echo json_encode([
                    'id' => $_POST['id'],
                    'nombre' => $valor['nombre'],
                    'descripcion' => $valor['descripcion'],
                    'archivo_adjunto' => $valor['archivo_adjunto'],
                ]);
            }
            return 0;
        }
    }
    $r1 = $evaluacion->listar();
    $datos = [];
    if (isset($response[0]["nombreentorno"])) {
        require_once "vista/" . $pagina . "Vista.php";
    }else{
        require_once "vista/error_Permisos.php";
    }
} else {
    echo "Pagina en construccion";
}