<?php
use modelo\UnidadModelo as Unidad;
use modelo\AulaModelo as Aula;
use modelo\UnidadContenidoModelo as UnidadContenido;
use modelo\UnidadEvaluacionModelo as UnidadEvaluacion;
use modelo\EvaluacionModelo as Evaluacion;
use modelo\ContenidoModelo as Contenido;
use modelo\NotificacionesModelo as notificacion;

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

$str = $pagina;
// Dividir el string 
$partes = explode('&', $str);
// Obtener Unidad
$pagina = $partes[0];
// Obtener valor
$valor = explode('=', $partes[1]);
$id_unidad = $valor[1];

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

    $unidad = new Unidad();
    $unidad_contenido = new UnidadContenido();
    $unidad_evaluacion = new UnidadEvaluacion();
    $evaluaciones = new Evaluacion();
    $contenidos = new Contenido();
    $notificacion = new notificacion();
    $bitacora = new Bitacora();
    $config = new Mensaje();
    $permiso_usuario = new Permiso();
    $modulo = 'Unidad';

    //Establecer el id_usuario_rol para bitacora
    $id_usuario_rol = $bitacora->buscar_id_usuario_rol($_SESSION['usuario']["tipo_usuario"],$_SESSION['usuario']["id"]);
    $entorno = $bitacora->buscar_id_entorno('Unidad');
    $fecha = date('Y-m-d h:i:s', time());

    if (isset($_POST['ReporteUnidad'])) {
        require_once "reportes/reportesUnidad.php";
    }

    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
        switch ($accion) {
            case 'registrar':
                $response = $unidad->incluir($_POST['nombre'], $_POST['descripcion'], $_POST['id_aula']);
                if ($response["resultado"]==1) {
                echo json_encode([
                    'estatus' => '1',
                    'icon' => 'success',
                    'title' => $modulo,
                    'message' => $response["mensaje"]
                ]);
                $bitacora->incluir($id_usuario_rol,$entorno,$fecha,"Registro");
                return 0;
                } else {
                    echo json_encode([
                        'estatus' => '2',
                        'icon' => 'info',
                        'title' => $modulo,
                        'message' => $response["mensaje"]
                    ]);
                    return 0;
                }
            exit;
                break;
            case 'eliminar':
                $response = $unidad->eliminar($_POST['id']);
                if ($response['resultado'] == 1) {
                echo json_encode([
                    'estatus' => '1',
                    'icon' => 'success',
                    'title' => "Unidad: ",
                    'message' => $response['mensaje']
                ]);
                //$bitacora->incluir($id_usuario_rol,$entorno,$fecha,"Eliminación");
                return 0;
            } else  {
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'info',
                    'title' => $modulo,
                    'message' => $response['mensaje']
                ]);
                return 0;
            }
                break;
            case 'modificar':
                $response = $unidad->modificar($_POST['id'], $_POST['nombre'], $_POST['descripcion'], $_POST['id_aula']);
                if ($response['resultado']== 1) {
                echo json_encode([
                    'estatus' => '1',
                    'icon' => 'success',
                    'title' => $modulo,
                    'message' => $response['mensaje']
                ]);
                //$bitacora->incluir($id_usuario_rol,$entorno,$fecha,"Modificacion");
                return 0;
            } else {
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'info',
                    'title' => $modulo,
                    'message' => $response['mensaje']
                ]);
                return 0;
            }
                break;

            case 'enviarevaluacion':
                $unidad->set_id($_POST['id']);
                $unidad->set_nombre($_POST['nombre']);
                $unidad->set_descripcion($_POST['descripcion']);
                $unidad->set_id_aula($_POST['id_aula']);
                $response = $unidad->modificar();
                if ($response == true) {
                    $config->confirmar($modulo, 'Modificacion exitosa ');
                    return 0;
                } else {
                    $config->error($modulo, 'Registro no modificado, El nombre ya existe!');
                    return 0;
                }
                break;
                case 'eliminarContenido':
                    $response = $contenidos->eliminar_contenido_unidad($_POST['id']);
                    if ($response["resultado"] == 1) {
                        echo json_encode([
                            'estatus' => '1',
                            'icon' => 'success',
                            'title' => "Contenido unidad",
                            'message' => $response["mensaje"]
                        ]);
                        return 0;
                    } else {
                        echo json_encode([
                            'estatus' => '2',
                            'icon' => 'info',
                            'title' => "Contenido unidad",
                            'message' => $response["mensaje"]
                        ]);
                        return 0;
                    }
                    break;
                case 'eliminarEvaluacion':
                    $response= $evaluaciones->elmininarEvaluacion_unidad($_POST['id']);
                    if ($response["resultado"] == 1) {
                        echo json_encode([
                            'estatus' => '1',
                            'icon' => 'success',
                            'title' => "Evaluación unidad",
                            'message' => $response["mensaje"]
                        ]);
                        return 0;
                    } else {
                        echo json_encode([
                            'estatus' => '2',
                            'icon' => 'info',
                            'title' => "Evaluación unidad",
                            'message' => $response["mensaje"]
                        ]);
                        return 0;
                    }
                    break;
            case 'editar':
                $unidad->set_id($_POST['id']);
                $datos = $unidad->cargar($_POST['id']);
                foreach ($datos as $valor) {
                    echo json_encode([
                        'id' => $valor[0],
                        'nombre' => $valor[1],
                        'descripcion' => $valor[2],
                        'id_aula' => $valor[3],
                    ]);
                }
                return 0;
                break;
                case 'editarEvaluacion':

                    $datos = $evaluaciones->cargarEvaluacion($_POST['id']);
                    foreach ($datos as $valor) {
                        $id = $valor['id'];
                        $nombre = $valor['nombre'];
                        $finicio = $valor['fecha_inicio'];
                        $fcierre = $valor['fecha_cierre'];
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
                            'id_unica' =>$_POST['id'],
                            'id' =>  $id,
                            'nombre' => $nombre,
                            'fechai' => $fieditar,
                            'fechac' => $fceditar
                        ]);
                    return 0;
                    break;
            case 'mostrar_contenidos':
                $listar = $contenidos->mostrar($_POST['id_unidad']);
                print_r($listar);
                return 0;
                break;
            case 'guardar_contenidos':
                $id_usuario_rolC = $bitacora->buscar_id_usuario_rol($_SESSION['usuario']["tipo_usuario"],$_SESSION['usuario']["id"]);
                $entornoC = $bitacora->buscar_id_entorno('Agregar Contenido');
                $fechaC = date('Y-m-d h:i:s', time());

                $valores = json_decode($_POST['contenidos']);
                $unidad_contenido->set_id_unidad($_POST['id_unidad']);
                $unidad_contenido->limpiar();
                $error = false;
                $codigo_error = 0;
                $mensaje_error = '';
                if(isset($valores)){
                    
                    foreach ($valores as $id_contenido) {
                        $unidad_contenido->set_id_unidad($_POST['id_unidad']);
                        $unidad_contenido->set_id_contenido($id_contenido);
                        $respuesta = $unidad_contenido->incluir();
                        if($respuesta["resultado"] != 1){
                            $error = true;
                            $codigo_error = $respuesta["resultado"];
                            $mensaje_error = $respuesta["mensaje"];
                        }
                    }
                    
                }
                if($error == true){
                    echo json_encode([
                        'estatus' => $codigo_error,
                        'icon' => 'error',
                        'title' => 'Contenidos',
                        'message' => $mensaje_error
                    ]);
                } else{
                    echo json_encode([
                        'estatus' => '1',
                        'icon' => 'success',
                        'title' => 'Contenidos',
                        'message' => 'Registro Exitoso'
                    ]);
                    $bitacora->incluir($id_usuario_rolC,$entornoC,$fechaC,"Agregar Contenido");
                }
                
                return 0;
                break;
                
            case 'guardar_evaluacion':

                $id_usuario_rolE = $bitacora->buscar_id_usuario_rol($_SESSION['usuario']["tipo_usuario"],$_SESSION['usuario']["id"]);
                $entornoE = $bitacora->buscar_id_entorno('Agregar Evaluacion');
                $fechaE = date('Y-m-d h:i:s', time());
                if (!empty($_POST['fecha_inicio']) && !empty($_POST['fecha_cierre'])) {
                    $fi = explode(" ", $_POST['fecha_inicio']);
                    $fechai = $fi[0];
                    $horai = $fi[1];
                    $ffi = explode("/", $fechai);
                    $fisql = $ffi[2] . "-" . $ffi[1] . "-" . $ffi[0] . " " . $horai;
    
                    $fc = explode(" ", $_POST['fecha_cierre']);
                    $fechac = $fc[0];
                    $horac = $fc[1];
                    $ffc = explode("/", $fechac);
                    $fcsql = $ffc[2] . "-" . $ffc[1] . "-" . $ffc[0] . " " . $horac;
                    $response = $unidad_evaluacion->incluir($_POST['evaluacion'], $_POST['id_unidad'], $fisql, $fcsql);
                    if ($response['resultado']==1) {
                        $id_unidad_evaluacion = $unidad_evaluacion->obtener_id_unidad_evaluacion();
                        /*Creando la notificacion de una evaluacion creada*/
                        $notificacion->guardar_notificacion($id_usuario_rolE, $id_unidad_evaluacion[0]['unidad_evaluacion'], date('Y-m-d h:i:s', time()), 'Evaluación creada');
                        echo json_encode([
                            'estatus' => '1',
                            'icon' => 'success',
                            'title' => 'Agregar Evaluación',
                            'message' => $response['mensaje']
                        ]);
                        $bitacora->incluir($id_usuario_rolE,$entornoE,$fechaE,"Agregar Evaluacion");
                    }else{
                        echo json_encode([
                            'estatus' => $response['resultado'],
                            'icon' => 'info',
                            'title' => 'Agregar Evaluación',
                            'message' => $response['mensaje']
                        ]);
                    }
                }else{
                    echo json_encode([
                        'estatus' => "2",
                        'icon' => 'info',
                        'title' => 'Agregar Evaluación',
                        'message' => "Complete los campos fecha"
                    ]);
                }
                return 0;
                break;
            case 'modificarevaluacion':

                $id_usuario_rolE = $bitacora->buscar_id_usuario_rol($_SESSION['usuario']["tipo_usuario"],$_SESSION['usuario']["id"]);
                $entornoE = $bitacora->buscar_id_entorno('Agregar Evaluacion');
                $fechaE = date('Y-m-d h:i:s', time());
                $fi = explode(" ", $_POST['fecha_inicio']);
                $fechai = $fi[0];
                $horai = $fi[1];
                $ffi = explode("/", $fechai);
                $fisql = $ffi[2] . "-" . $ffi[1] . "-" . $ffi[0] . " " . $horai;

                $fc = explode(" ", $_POST['fecha_cierre']);
                $fechac = $fc[0];
                $horac = $fc[1];
                $ffc = explode("/", $fechac);
                $fcsql = $ffc[2] . "-" . $ffc[1] . "-" . $ffc[0] . " " . $horac;
                $response = $unidad_evaluacion->modificarEvaluacion($_POST['id'], $_POST['evaluacion'], $_POST['id_unidad'], $fisql, $fcsql);
                if ($response['resultado']==1) {
                    $id_unidad_evaluacion = $unidad_evaluacion->obtener_id_unidad_evaluacion();
                    /*Creando la notificacion de una evaluacion creada*/
                    $notificacion->guardar_notificacion($id_usuario_rolE, $id_unidad_evaluacion[0]['unidad_evaluacion'], date('Y-m-d h:i:s', time()), 'Evaluación modificada');
                    echo json_encode([
                        'estatus' => '1',
                        'icon' => 'success',
                        'title' => 'Modificar Evaluación',
                        'message' => $response['mensaje']
                    ]);
                    //$bitacora->incluir($id_usuario_rolE,$entornoE,$fechaE,"Modificar Evaluación");
                }else if ($response['resultado']==2) {
                    echo json_encode([
                        'estatus' => '2',
                        'icon' => 'info',
                        'title' => 'Modificar Evaluación',
                        'message' => $response['mensaje']
                    ]);
                }
                else if ($response['resultado']==3) {
                    echo json_encode([
                        'estatus' => '3',
                        'icon' => 'info',
                        'title' => 'Modificar Evaluación',
                        'message' => $response['mensaje']
                    ]);
                }
                return 0;
                break;
            case 'buscar_evaluacion':
                $datos = $evaluaciones->cargar($_POST['id_evaluacion']);
                foreach ($datos as $valor) {
                    echo json_encode([
                        'id' => $valor['id'],
                        'nombre' => $valor['nombre'],
                    ]);
                }
                return 0;
                break;
        }
    }
    if (isset($id_unidad)) {
        $mostrar_unidad = $unidad->cargar($id_unidad);
        if($mostrar_unidad != null){
            $listar_contenidos = $unidad_contenido->listar($id_unidad);
            $listar_evaluaciones = $unidad_evaluacion->listar($id_unidad);
            //$mostrar_contenidos = $contenidos->mostrar($id_unidad);
            //$mostrar_evaluaciones = $evaluaciones->mostrar($id_unidad);
        }
        else
        {
            require_once "vista/error_404Vista.php";
            exit;
        }
        
    }
    $response = $permiso_usuario->mostrarpermisos($_SESSION['usuario']["id"],$_SESSION['usuario']["tipo_usuario"],"Unidad");
    $response3 = $permiso_usuario->mostrarpermisos($_SESSION['usuario']["id"],$_SESSION['usuario']["tipo_usuario"],"Agregar Contenido");
    $response2 = $permiso_usuario->mostrarpermisos($_SESSION['usuario']["id"],$_SESSION['usuario']["tipo_usuario"],"Agregar Evaluacion");
    $m_e = $evaluaciones->mostrar_evaluaciones();
    require_once "vista/" . $pagina . "Vista.php";
} else {
    echo "Pagina en construccion";
}