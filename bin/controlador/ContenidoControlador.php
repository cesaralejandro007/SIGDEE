<?php
use modelo\ContenidoModelo as Contenido;
use modelo\configNotificacionModelo as Mensaje;
use modelo\PermisosModelo as Permiso;
use modelo\BitacoraModelo as Bitacora;
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

    $contenido = new Contenido();
    $permiso_usuario = new Permiso();
    $config = new Mensaje();
    $bitacora = new Bitacora();
    $modulo = 'Contenido';
    
    $response = $permiso_usuario->mostrarpermisos($_SESSION['usuario']["id"],$_SESSION['usuario']["tipo_usuario"],"Contenidos");
    //Establecer el id_usuario_rol para bitacora
    $id_usuario_rol = $bitacora->buscar_id_usuario_rol($_SESSION['usuario']["tipo_usuario"], $_SESSION['usuario']["id"]);
    $entorno = $bitacora->buscar_id_entorno('Contenidos');
    $fecha = date('Y-m-d h:i:s', time());

    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
        if ($accion == 'registrar') {
            if ($response[0]["registrar"] == "true"){
                $ruta = "content/contenidos/";
                if (isset($_FILES['archivo']['name'])) {
                    $nombre_archivo = $_FILES['archivo']['name'];
                    $subir = $ruta . "/" . $nombre_archivo;
                    if (move_uploaded_file($_FILES['archivo']['tmp_name'], $subir)) {
                        $response = $contenido->incluir($_POST['nombre'], $_POST['descripcion'], $nombre_archivo);
                        if ($response['resultado']==1) {
                            echo json_encode([
                                'estatus' => '1',
                                'icon' => 'success',
                                'title' => $modulo,
                                'message' => $response['mensaje']
                            ]);
                            $bitacora->incluir($id_usuario_rol,$entorno,$fecha,"Registro");
                        }else if($response['resultado']==2) {
                            echo json_encode([
                                'estatus' => '0',
                                'icon' => 'info',
                                'title' => $modulo,
                                'message' => $response['mensaje']
                            ]);
                        } else if($response['resultado']==3) {
                            echo json_encode([
                                'estatus' => '0',
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
                }else {
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
                $response = $contenido->eliminar($_POST['id']);
                if ($response['resultado']==1) {
                    echo json_encode([
                        'estatus' => '1',
                        'icon' => 'success',
                        'title' => $modulo,
                        'message' => $response['mensaje'] 
                    ]);
                    $bitacora->incluir($id_usuario_rol,$entorno,$fecha,"Eliminación");
                }else if ($response['resultado']==2) {
                    echo json_encode([
                        'estatus' => '0',
                        'icon' => 'info',
                        'title' => $modulo,
                        'message' => $response['mensaje'] 
                    ]);
                }else if ($response['resultado']==3) {
                    echo json_encode([
                        'estatus' => '0',
                        'icon' => 'info',
                        'title' => $modulo,
                        'message' => $response['mensaje'] 
                    ]);
                }else{
                    echo json_encode([
                        'estatus' => '0',
                        'icon' => 'error',
                        'title' => $modulo,
                        'message' => $response['mensaje'] 
                    ]);
                }
                return 0;
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
                $response = $contenido->modificar($_POST['id'], $_POST['nombre'], $_POST['descripcion']);
                if ($response['resultado']==1) {
                    if (isset($_FILES['archivo']['tmp_name'])) {
                        $ruta = "content/contenidos";
                        $nombre_archivo = $_POST['nombre_antes'];
                        $antes = $ruta . "/" . $nombre_archivo;
                        $subir = $ruta . "/" . $_FILES['archivo']['name'];
                        unlink($antes);
                        move_uploaded_file($_FILES['archivo']['tmp_name'], $subir);
                        $contenido->cambiar_archivo($_POST['id'], $_FILES['archivo']['name']);
                    }
                    echo json_encode([
                        'estatus' => '1',
                        'icon' => 'success',
                        'title' => $modulo,
                        'message' => $response['mensaje'] 
                    ]);
                    $bitacora->incluir($id_usuario_rol,$entorno,$fecha,"Modificacion");
                }
                else if($response['resultado']==2) {
                    echo json_encode([
                        'estatus' => '0',
                        'icon' => 'info',
                        'title' => $modulo,
                        'message' => $response['mensaje']
                    ]);
                } else if($response['resultado']==3) {
                    echo json_encode([
                        'estatus' => '0',
                        'icon' => 'info',
                        'title' => $modulo,
                        'message' => $response['mensaje']
                    ]);
                }else{
                    echo json_encode([
                        'estatus' => '0',
                        'icon' => 'error',
                        'title' => $modulo,
                        'message' => $response['mensaje']
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
            $datos = $contenido->cargar($_POST['id']);
            foreach ($datos as $valor) {
                echo json_encode([
                    'id' => $valor['id'],
                    'nombre' => $valor['nombre'],
                    'descripcion' => $valor['descripcion'],
                    'archivo_adjunto' =>  _URL_.'/content/contenidos/'.$valor['archivo_adjunto'],
                ]);
            }
            return 0;
        }
    }

    $r1 = $contenido->listar();
    $datos = [];
    if (isset($response[0]["nombreentorno"])) {
        require_once "vista/" . $pagina . "Vista.php";
    }else{
        require_once "vista/error_Permisos.php";
    }
} else {
    echo "Pagina en construccion";
}