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
    header('location:?pagina=Login');
}
if (!is_file($config->_Dir_Model_().$pagina.$config->_MODEL_())) {
    echo "Falta definir la clase " . $pagina;
    exit;
}

if (is_file($config->_Dir_Vista_().$pagina.$config->_VISTA_())) {

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
    $id_usuario_rol = $bitacora->buscar_id_usuario_rol($_SESSION["usuario"]["tipo_usuario"], $_SESSION["usuario"]["id"]);
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
                    'title' => "Usuario: ",
                    'message' => $response['mensaje']
                ]);
                $bitacora->incluir($id_usuario_rol,$entorno,$fecha,"Eliminación");
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
                $bitacora->incluir($id_usuario_rol,$entorno,$fecha,"Modificacion");
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
                case 'eliminarEvaluacion':
                    $response= $evaluaciones->elmininarEvaluacion_unidad($_POST['id']);
                    if ($response["resultado"] == 1) {
                        echo json_encode([
                            'estatus' => '1',
                            'icon' => 'success',
                            'title' => $modulo,
                            'message' => $response["mensaje"]
                        ]);
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
                        echo json_encode([
                            'id' => $valor["id"],
                            'nombre' => $valor["nombre"],
                            'fechai' => $valor["fecha_inicio"],
                            'fechac' => $valor["fecha_cierre"]
                        ]);
                    }
                    return 0;
                    break;
            case 'mostrar_contenidos':
                $listar = $contenidos->mostrar($_GET['id_unidad']);
                print_r($listar);
                return 0;
                break;
            case 'mostrar_evaluaciones':
                $listar = $evaluaciones->mostrar($_GET['id_unidad']);
                echo $listar;
                return 0;
                break;
            case 'guardar_contenidos':
                $id_usuario_rolC = $bitacora->buscar_id_usuario_rol($_SESSION["usuario"]["tipo_usuario"], $_SESSION["usuario"]["id"]);
                $entornoC = $bitacora->buscar_id_entorno('Agregar Contenido');
                $fechaC = date('Y-m-d h:i:s', time());

                $valores = json_decode($_POST['contenidos']);
                if(isset($valores)){
                    $unidad_contenido->set_id_unidad($_POST['id_unidad']);
                    $unidad_contenido->limpiar();
                    foreach ($valores as $id_contenido) {
                            $unidad_contenido->set_id_unidad($_POST['id_unidad']);
                            $unidad_contenido->set_id_contenido($id_contenido);
                            $unidad_contenido->incluir();
                        }
                    }else{
                        $unidad_contenido->limpiar();
                }
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'success',
                    'title' => 'Contenidos',
                    'message' => 'Registro Exitoso'
                ]);
                $bitacora->incluir($id_usuario_rolC,$entornoC,$fechaC,"Agregar Contenido");
                return 0;
                break;
                
            case 'guardar_evaluacion':

                $id_usuario_rolE = $bitacora->buscar_id_usuario_rol($_SESSION["usuario"]["tipo_usuario"], $_SESSION["usuario"]["id"]);
                $entornoE = $bitacora->buscar_id_entorno('Agregar Evaluacion');
                $fechaE = date('Y-m-d h:i:s', time());

                $unidad_evaluacion->set_id_evaluacion($_POST['evaluacion']);
                $unidad_evaluacion->set_id_unidad($_POST['id_unidad']);
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
                $unidad_evaluacion->set_fecha_inicio($fisql);
                $unidad_evaluacion->set_fecha_cierre($fcsql);
                $response = $unidad_evaluacion->incluir();
                if ($response['resultado']==1) {
                    $id_unidad_evaluacion = $unidad_evaluacion->obtener_id_unidad_evaluacion();
                    /*Creando la notificacion de una evaluacion creada*/
                    $notificacion->set_id_usuarios_roles($id_usuario_rolE);
                    $notificacion->set_id_unidad_evaluaciones($id_unidad_evaluacion[0]['unidad_evaluacion']);
                    $notificacion->set_fecha(date('Y-m-d h:i:s', time()));
                    $notificacion->set_mensaje('Evaluación creada');
                    $notificacion->guardar_notificacion();
                    echo json_encode([
                        'estatus' => '2',
                        'icon' => 'success',
                        'title' => 'Evaluación agregada',
                        'message' => $response['mensaje']
                    ]);
                    $bitacora->incluir($id_usuario_rolE,$entornoE,$fechaE,"Agregar Evaluacion");
                }else if ($response['resultado']==2) {
                    echo json_encode([
                        'estatus' => '3',
                        'icon' => 'info',
                        'title' => 'Evaluación agregada',
                        'message' => $response['mensaje']
                    ]);
                }
                return 0;
                break;
            case 'modificarevaluacion':

                $id_usuario_rolE = $bitacora->buscar_id_usuario_rol($_SESSION["usuario"]["tipo_usuario"], $_SESSION["usuario"]["id"]);
                $entornoE = $bitacora->buscar_id_entorno('Modificar Evaluacion');
                $fechaE = date('Y-m-d h:i:s', time());

                $unidad_evaluacion->set_id_evaluacion($_POST['evaluacion']);
                $unidad_evaluacion->set_id_unidad($_POST['id_unidad']);
                $unidad_evaluacion->set_fecha_inicio($_POST['fecha_inicio']);
                $unidad_evaluacion->set_fecha_cierre($_POST['fecha_cierre']);
                $response = $unidad_evaluacion->modificarEvaluacion();
                if ($response['resultado']==1) {
                    $id_unidad_evaluacion = $unidad_evaluacion->obtener_id_unidad_evaluacion();
                    /*Creando la notificacion de una evaluacion creada*/
                    $notificacion->set_id_usuarios_roles($id_usuario_rolE);
                    $notificacion->set_id_unidad_evaluaciones($id_unidad_evaluacion[0]['unidad_evaluacion']);
                    $notificacion->set_fecha(date('Y-m-d h:i:s', time()));
                    $notificacion->set_mensaje('Evaluación Modificada');
                    $notificacion->guardar_notificacion();
                    echo json_encode([
                        'estatus' => '1',
                        'icon' => 'success',
                        'title' => 'Evaluación agregada',
                        'message' => $response['mensaje']
                    ]);
                    $bitacora->incluir($id_usuario_rolE,$entornoE,$fechaE,"Modificar Evaluación");
                }else if ($response['resultado']==2) {
                    echo json_encode([
                        'estatus' => '2',
                        'icon' => 'info',
                        'title' => 'Evaluación agregada',
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
    if (isset($_GET['id_unidad'])) {
        $id_unidad = $_GET['id_unidad'];
        $mostrar_unidad = $unidad->cargar($id_unidad);
        $listar_contenidos = $unidad_contenido->listar($id_unidad);
        $listar_evaluaciones = $unidad_evaluacion->listar($id_unidad);
        //$mostrar_contenidos = $contenidos->mostrar($id_unidad);
        //$mostrar_evaluaciones = $evaluaciones->mostrar($id_unidad);
    }
    $response = $permiso_usuario->mostrarpermisos($_SESSION["usuario"]["id"],$_SESSION["usuario"]["tipo_usuario"],"Unidad");
    $response3 = $permiso_usuario->mostrarpermisos($_SESSION["usuario"]["id"],$_SESSION["usuario"]["tipo_usuario"],"Agregar Contenido");
    $response2 = $permiso_usuario->mostrarpermisos($_SESSION["usuario"]["id"],$_SESSION["usuario"]["tipo_usuario"],"Agregar Evaluacion");
    $m_e = $evaluaciones->mostrar_evaluaciones();
    require_once "vista/" . $pagina . "Vista.php";
} else {
    echo "Pagina en construccion";
}