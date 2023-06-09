<?php
use modelo\UnidadEvaluacionModelo as UnidadEvaluacion;
use modelo\configNotificacionModelo as Mensaje;
use modelo\PermisosModelo as Permiso;
use modelo\BitacoraModelo as Bitacora;
use modelo\EstudianteEvaluacionModelo as EstudianteEvaluacion;
use modelo\NotificacionesModelo as notificacion;
use modelo\AulaEstudianteModelo as AulaEstudiante;
use modelo\EstudianteModelo as Estudiante;
use config\componentes\configSistema as configSistema;

$config = new configSistema();
$bitacora = new Bitacora();
session_start();
if (!isset($_SESSION['usuario'])) {
    header('location:?pagina=Login');
}


if (!is_file($config->_Dir_Model_().'UnidadEvaluacion'.$config->_MODEL_())) {
    echo "Falta definir la clase " . $pagina;
    exit;
}

$usuario_rol = $bitacora->buscar_id_usuario_rol($_SESSION["usuario"]["tipo_usuario"], $_SESSION["usuario"]["id"]);
$entorno = $bitacora->buscar_id_entorno('Unidad');
$fecha = date('Y-m-d h:i:s', time());

if (is_file($config->_Dir_Vista_().$pagina.$config->_VISTA_())) {
    
    $unidad_evaluacion = new UnidadEvaluacion();
    $estudiante_evaluacion = new EstudianteEvaluacion();
    $aula_estudiante = new AulaEstudiante();
    $estudiante = new Estudiante();
    $config = new Mensaje();
    $notificacion = new notificacion();
    $modulo = 'Evaluación';
    $permiso = new Permiso();

    if (isset($_POST['ReporteUnidad'])) {
        require_once "reportes/reportesUnidad.php";
    }

    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
        switch($accion){
            case 'entregar':
                $ruta = "content/entregas/".$_GET['id_unidad_evaluacion'];
                //$nombre_archivo = $_FILES['archivo']['name'];
                $nombre_archivo = $_POST['id_estudiante'];
                if (!file_exists($ruta)) {
                    mkdir($ruta, 0777, true);
                }
                $subir = $ruta."/".$nombre_archivo;
                if(move_uploaded_file($_FILES['archivo']['tmp_name'], $subir)){
                    //Validar si el usuario no es un estudiante
                    if (!$estudiante->existe($_POST['id_estudiante'])) {
                        echo json_encode([
                            'estatus' => '2',
                            'icon' => 'info',
                            'title' => 'Entrega',
                            'message' => 'El estudiante no existe'
                        ]);
                        return 0;
                    }
                    else
                    //En caso de que el usuario no este cursando esa aula
                    if($aula_estudiante->verificar($_POST['id_estudiante'], $_GET['id_unidad_evaluacion'])== false){
                         echo json_encode([
                            'estatus' => '2',
                            'icon' => 'info',
                            'title' => 'Entrega',
                            'message' => 'El estudiante no pertenece al aula'
                        ]);
                        return 0;
                    }
                    //Si ese usuario pertenece al aula
                    else{
                        $response = $estudiante_evaluacion->incluir($_POST['id_estudiante'], $_GET['id_unidad_evaluacion'], date('Y-m-d h:i:s', time()), $_POST['descripcion'], $nombre_archivo);
                        if ($response) {
                            /*Creando la notificacion de una evaluacion entregada*/
                            $notificacion->set_id_usuarios_roles($usuario_rol);
                            $notificacion->set_id_unidad_evaluaciones($_GET['id_unidad_evaluacion']);
                            $notificacion->set_fecha(date('Y-m-d h:i:s', time()));
                            $notificacion->set_mensaje('Evaluación entregada');
                            $notificacion->guardar_notificacion();

                            $bitacora->incluir($usuario_rol,$entorno,$fecha,"Entrega Evaluación");
                            echo json_encode([
                                'estatus' => '1',
                                'icon' => 'success',
                                'title' => 'Entrega',
                                'message' => 'Registro exitoso'
                            ]);
                            return 0;
                        } 
                    }
                    
                }
                else{
                    echo json_encode([
                        'estatus' => '2',
                        'icon' => 'info',
                        'title' => 'Entrega',
                        'message' => 'Erro en el archivo que desea entregar'
                    ]);
                }
                return 0;
                exit;
            break;
            case 'eliminar':
                $unidad_evaluacion->set_id($_POST['id']);
                //$response = $unidad_evaluacion->eliminar();
                if ($response == true) {
                    $bitacora->incluir($usuario_rol,$entorno,$fecha,"Eliminación de Evaluación");
                    $config->confirmar($modulo, 'Eliminación exitosa');
                    return 0;
                } else {
                    $config->error($modulo, 'Registro no eliminado');
                    return 0;
                }
            break;
            case 'modificar':
                $unidad_evaluacion->set_id($_POST['id']);
                //$unidad_evaluacion->set_nombre($_POST['nombre']);
                //$unidad_evaluacion->set_descripcion($_POST['descripcion']);
                //$unidad_evaluacion->set_id_aula($_POST['id_aula']);
                //$response = $unidad_evaluacion->modificar();
                if ($response == true) {
                    $bitacora->incluir($usuario_rol,$entorno,$fecha,"Modificación Evaluación");
                    $config->confirmar($modulo, 'Modificacion exitosa ');
                    return 0;
                } else {
                    $config->error($modulo, 'Registro no modificado, El nombre ya existe!');
                    return 0;
                }
            break;
            case 'modificar_entrega':
                $estudiante_evaluacion->set_id($_POST['id']);
                $estudiante_evaluacion->set_descripcion($_POST['descripcion']);
                $estudiante_evaluacion->set_fecha_entrega(date('Y-m-d h:i:s', time())); 
                $estudiante_evaluacion->set_id_estudiante($_SESSION['usuario']['id']);
                $estudiante_evaluacion->set_id_unidad_evaluacion($_GET['id_unidad_evaluacion']);
                $response = $estudiante_evaluacion->modificar();
                if ($response) {
                    $ruta = "content/entregas/".$_GET['id_unidad_evaluacion'];
                    //$nombre_archivo = $_FILES['archivo']['name'];
                    $nombre_archivo = $_SESSION['usuario']['id'];
                    if (!file_exists($ruta)) {
                        mkdir($ruta, 0777, true);
                    }
                    $subir = $ruta."/".$nombre_archivo;
                    if(isset($_FILES['archivo']['tmp_name'])){
                        unlink($subir);
                        move_uploaded_file($_FILES['archivo']['tmp_name'], $subir);
                    }

                    $notificacion->set_id_usuarios_roles($usuario_rol);
                    $notificacion->set_id_unidad_evaluaciones($_GET['id_unidad_evaluacion']);
                    $notificacion->set_fecha(date('Y-m-d h:i:s', time()));
                    $notificacion->set_mensaje('Entrega de evaluación modificada');
                    $notificacion->guardar_notificacion();
                    $bitacora->incluir($usuario_rol,$entorno,$fecha,"Modificación de Entrega de Evaluación");
                    $config->confirmar('Entrega', 'Modificación exitosa');
                } 
                else {
                    $config->informacion('Entrega', 'Modificación no modificada');
                }
                return 0; 
                exit;
            break;
            case 'editar':
                $datos = $estudiante_evaluacion->editar($_SESSION['usuario']['id'], $_POST['id']);
                foreach ($datos as $valor) {
                    echo json_encode([
                        'id' => $valor['id'],
                        'descripcion' => $valor['descripcion'],
                        'archivo_adjunto' => $valor['archivo_adjunto'],
                        'unidad_eval' => $valor['unidad_eval'],
                        'id_estudent' => $_SESSION['usuario']['id']
                    ]);
                }
                return 0;
                exit;
            break;
            case 'mostrar-calificacion':
                $datos = $estudiante_evaluacion->mostar_calificacion($_POST['id']);
                foreach ($datos as $valor) {
                    echo json_encode([
                        'id' => $valor['id'],
                        'calificacion' => $valor['calificacion'],
                        'estudiante' => $valor['estudiante'],
                    ]);
                }
                return 0;
                exit;
            break;
            case 'calificar':
                $response = $estudiante_evaluacion->calificar($_POST['id'], $_POST['calificacion']);
                if ($response['resultado']== 1) {
                    echo json_encode([
                        'estatus' => '1',
                        'icon' => 'success',
                        'title' => $modulo,
                        'message' => $response['mensaje']
                    ]);
                    $bitacora->incluir($usuario_rol,$entorno,$fecha,"Modificacion");
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
                exit;
            break;
        }
    }
    /*
    * Verifico que se ha pasado por url el id de la evaluacion seleccionada 
    * en una unidad de aula
    */
    if (isset($_GET['id_unidad_evaluacion'])) {
        $id_unidad_evaluacion = $_GET['id_unidad_evaluacion']; 
        $mostrar_unidad = $unidad_evaluacion->cargar($id_unidad_evaluacion); 
        if($mostrar_unidad == null){
            require_once "vista/error_404Vista.php";
            exit;
        }
        else{
            $mostrar_estudiante_evaluacion = $estudiante_evaluacion->cargar($_SESSION['usuario']['id'], $id_unidad_evaluacion);
            $nombre_evaluacion_entregada = $mostrar_estudiante_evaluacion!=null ? $mostrar_estudiante_evaluacion[0]['descripcion'] : '<p style="color:red;">No ha entregado</p>';
            $fecha_entrega = $mostrar_estudiante_evaluacion!=null ?date('d-m-Y h:i:s', strtotime($mostrar_estudiante_evaluacion[0]['fecha'])) : '';
            $calificacion = $mostrar_estudiante_evaluacion!=null ? $mostrar_estudiante_evaluacion[0]['calificacion'] : '';
            $descripcion_evaluacion = $mostrar_estudiante_evaluacion!=null ? $mostrar_estudiante_evaluacion[0]['descripcion']: '';
            $archivo_evaluacion = $mostrar_estudiante_evaluacion!=null ? '<a target="_blank" href="../content/entregas/'.$id_unidad_evaluacion.'/'.$_SESSION['usuario']['id'].'"> Documento Ajunto <i class="fas fa-cloud-download-alt"></i></a>'  : '';
            $nombre_archivo = $mostrar_unidad[0]['archivo'];
            $examen = '<a target="_blank" href="../content/evaluaciones/'.$nombre_archivo.'"> Documento Ajunto <i class="fas fa-cloud-download-alt"></i></a>';
    
            $id = $mostrar_estudiante_evaluacion!=null ? $mostrar_estudiante_evaluacion[0]['id'] : '';
            $entregas = $estudiante_evaluacion->mostrarEntregas($nombre_archivo = $mostrar_unidad[0]['id']);
            $status = 0;
            if($aula_estudiante->verificar_estudiante($_SESSION['usuario']['id'], $mostrar_unidad[0]['id'], date('Y-m-d h:i:s', time()))== 2){
                $status = 2;
            }
            else
            if($aula_estudiante->verificar_estudiante($_SESSION['usuario']['id'], $mostrar_unidad[0]['id'], date('Y-m-d h:i:s', time()))== 1){
                $status = 1;
            }
        }
    }
    require_once "vista/MostrarEvaluacionVista.php";
}else {
    echo "Pagina en construccion";
}