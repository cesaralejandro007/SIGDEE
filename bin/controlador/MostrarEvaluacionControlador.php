<?php
use modelo\UnidadEvaluacionModelo as UnidadEvaluacion;
use modelo\configNotificacionModelo as Mensaje;
use modelo\PermisosModelo as Permiso;
use modelo\BitacoraModelo as Bitacora;
use modelo\EstudianteEvaluacionModelo as EstudianteEvaluacion;
use modelo\NotificacionesModelo as notificacion;
use modelo\AulaEstudianteModelo as AulaEstudiante;
use modelo\EstudianteModelo as Estudiante;
use modelo\AulaDocenteModelo as AulaDocente;
use modelo\DocenteModelo as Docente;
use config\componentes\configSistema as configSistema;

$config = new configSistema();
$bitacora = new Bitacora();

session_start();
if (!isset($_SESSION['usuario'])) {
	$redirectUrl = '?pagina=' . configSistema::_LOGIN_();
    echo '<script>window.location="' . $redirectUrl . '"</script>';
    die();
}

$str = $pagina;

// Dividir el string
$partes = explode('&', $str); 

// Obtener MostrarEvaluacion 
$pagina = $partes[0];

// Obtener valor
$valores = explode('=', $partes[1]);
$id_evaluaciones = $valores[1];

//obtener ruta del directorio
$url = $_SERVER['REQUEST_URI'];
$partes = parse_url($url);
if(isset($partes['host'])) {
  $host = $partes['host']; 
} else {
  $host = '';
}
$ruta = $partes['path'];
$ruta = pathinfo($ruta, PATHINFO_DIRNAME); 
$url_base = $host . $ruta . "/SIGDEE";



if (!is_file($config->_Dir_Model_().'UnidadEvaluacion'.$config->_MODEL_())) {
    echo "Falta definir la clase " . $pagina;
    exit;
}


if (is_file($config->_Dir_Vista_().$pagina.$config->_VISTA_())) {
    
    if(count(array_filter($_SESSION['usuario'])) == 0) {
        $redirectUrl = '?pagina=' . configSistema::_LOGIN_();
        echo '<script>window.location="' . $redirectUrl . '"</script>';
        die();
    }
    
    $usuario_rol = $bitacora->buscar_id_usuario_rol($_SESSION['usuario']["tipo_usuario"],$_SESSION['usuario']["id"]);
    $entorno = $bitacora->buscar_id_entorno('Unidad');
    $fecha = date('Y-m-d h:i:s', time());
    
    $unidad_evaluacion = new UnidadEvaluacion();
    $estudiante_evaluacion = new EstudianteEvaluacion();
    $aula_estudiante = new AulaEstudiante();
    $estudiante = new Estudiante();
    $aula_docente = new AulaDocente();
    $docente = new Docente();
    $msg = new Mensaje();
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
                $ruta = "content/entregas/".$id_evaluaciones;
                //$nombre_archivo = $_FILES['archivo']['name'];
                $nombre_archivo = $_SESSION['usuario']["id"];
                if (!file_exists($ruta)) {
                    mkdir($ruta, 0777, true);
                }
                $subir = $ruta."/".$nombre_archivo;
                if(move_uploaded_file($_FILES['archivo']['tmp_name'], $subir)){
                    //Validar si el usuario no es un estudiante
                    if (!$estudiante->existe($_SESSION['usuario']["id"])) {
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
                    if($aula_estudiante->verificar($_SESSION['usuario']["id"], $id_evaluaciones)== false){
                         echo json_encode([
                            'estatus' => '3',
                            'icon' => 'info',
                            'title' => 'Entrega',
                            'message' => 'El estudiante no pertenece al aula'
                        ]);
                        return 0;
                    }
                    //Si ese usuario pertenece al aula
                    else{
                        $response = $estudiante_evaluacion->incluir($_SESSION['usuario']["id"], $id_evaluaciones, date('Y-m-d h:i:s', time()), $_POST['descripcion'], $nombre_archivo);
                        if ($response) {
                            /*Creando la notificacion de una evaluacion entregada*/
                            $notificacion->guardar_notificacion($usuario_rol, $id_evaluaciones, date('Y-m-d h:i:s', time()), 'Evaluación entregada');

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
                        'message' => 'Error en el archivo que desea entregar'
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
                    $msg->confirmar($modulo, 'Eliminación exitosa');
                    return 0;
                } else {
                    $msg->error($modulo, 'Registro no eliminado');
                    return 0;
                }
            break;
            case 'modificar':
                $unidad_evaluacion->set_id($_POST['id']);
                if ($response == true) {
                    $bitacora->incluir($usuario_rol,$entorno,$fecha,"Modificación Evaluación");
                    $msg->confirmar($modulo, 'Modificacion exitosa ');
                    return 0;
                } else {
                    $msg->error($modulo, 'Registro no modificado, El nombre ya existe!');
                    return 0;
                }
            break;
            case 'modificar_entrega':
                //Validar que exista el estudiante
                if (!$estudiante->existe($_SESSION['usuario']["id"])) {
                    echo json_encode([
                        'estatus' => '2',
                        'icon' => 'info',
                        'title' => 'Modificar calificación',
                        'message' => 'El estudiante no existe'
                    ]);
                    return 0;
                }
                else
                //En caso de que el usuario no este cursando esa aula
                if($aula_estudiante->verificar($_SESSION['usuario']["id"], $id_evaluaciones)== false){
                     echo json_encode([
                        'estatus' => '3',
                        'icon' => 'info',
                        'title' => 'Modificar calificación',
                        'message' => 'El estudiante no pertenece al aula'
                    ]);
                    return 0;
                }
                else{            
                    $response = $estudiante_evaluacion->modificar($_POST['id'], $_POST['descripcion'], date('Y-m-d h:i:s', time()), $_SESSION['usuario']["id"], $id_evaluaciones);
                    if($response['resultado'] != 1){
                        $msg->informacion('Entrega', $response['mensaje']);
                    }
                    else{
                        $ruta = "content/entregas/".$id_evaluaciones;
                        //$nombre_archivo = $_FILES['archivo']['name'];
                        $nombre_archivo = $_SESSION['usuario']["id"];
                        if (!file_exists($ruta)) {
                            mkdir($ruta, 0777, true);
                        }
                        $subir = $ruta."/".$nombre_archivo;
                        if(isset($_FILES['archivo']['tmp_name'])){
                            unlink($subir);
                            move_uploaded_file($_FILES['archivo']['tmp_name'], $subir);
                        }
    
                        $notificacion->guardar_notificacion($usuario_rol, $id_evaluaciones, date('Y-m-d h:i:s', time()), 'Entrega de evaluación modificada');
                        $bitacora->incluir($usuario_rol,$entorno,$fecha,"Modificación de Entrega de Evaluación");
                        $msg->confirmar('Entrega', $response['mensaje']);
                    }
                    
                } 
                return 0; 
                exit;
            break;
            case 'editar':
                $datos = $estudiante_evaluacion->editar($_SESSION['usuario']["id"], $_POST['id']);
                foreach ($datos as $valor) {
                    echo json_encode([
                        'id' => $valor['id'],
                        'descripcion' => $valor['descripcion'],
                        'archivo_adjunto' => $valor['archivo_adjunto'],
                        'unidad_eval' => $valor['unidad_eval'],
                        'id_estudent' => $_SESSION['usuario']["id"],
                        'url_base' => _URL_.'/content/entregas/'.$valor['unidad_eval'].'/'.$_SESSION['usuario']["id"],
                    ]);
                }
                return 0;
                exit;
            break;
            case 'mostrar-calificacion':
                //Validar que existe ese estudiante para esa evaluacion


                //Validar que haya sido calificado
                $datos = $estudiante_evaluacion->mostrar_calificacion($_POST['id_estudiante'], $id_evaluaciones);
                foreach ($datos as $valor) {
                    if(isset($valor[3])){
                        echo json_encode([
                            'id_estudiante' => $valor[0],
                            'estudiante' => $valor[1],
                            'calificacion' => $valor[2],
                            'id_evaluacion' => $valor[3],
                            'descripcion' => $valor[4],
                            'fecha' => date('d-m-Y h:i:s', strtotime($valor[5])),
                            'unidad' => $valor[6],
                            'archivo' => _URL_.'/content/entregas/'.$valor[6].'/'.$valor[7],
                            'doc' => $valor[7],
                            
                        ]);
                    }
                    else{
                        echo json_encode([
                            'id_estudiante' => $valor[0],
                            'estudiante' => $valor[1],
                            'calificacion' => '',
                            'id_evaluacion' => false,
                            'unidad' => $valor[2]
                        ]);
                    }
                    return 0;
                }
                return 0;
                exit;
            break;
            case 'calificar':
                $result = $docente->existe($_SESSION['usuario']["id"]);
                if (!$result) {
                    echo json_encode([
                        'estatus' => '2',
                        'icon' => 'info',
                        'title' => 'Calificar Evaluación',
                        'message' => $result
                    ]);
                    return 0;
                }
                else
                //En caso de que el usuario no este cursando esa aula
                if($aula_docente->verificar($_SESSION['usuario']["id"], $id_evaluaciones)== false){
                     echo json_encode([
                        'estatus' => '3',
                        'icon' => 'info',
                        'title' => 'Calificar Evaluación',
                        'message' => 'El estudiante no pertenece al aula'
                    ]);
                    return 0;
                }
                //Si ese usuario pertenece al aula
                else{
                    $response = $estudiante_evaluacion->calificar($_POST['id_estudiante'], $_POST['id_unidad_evaluacion'], $_POST['calificacion']);
                    if ($response['resultado']== 1) {
                        echo json_encode([
                            'estatus' => '1',
                            'icon' => 'success',
                            'title' => $modulo,
                            'message' => $response['mensaje']
                        ]);
                        $bitacora->incluir($usuario_rol,$entorno,$fecha,"Calificación de evaluacion");
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

                }
                exit;
            break;
            case 'modificar_calificacion':
                if (!$estudiante->existe($_SESSION['usuario']["id"])) {
                    echo json_encode([
                        'estatus' => '2',
                        'icon' => 'info',
                        'title' => 'Modificar calificación',
                        'message' => 'El estudiante no existe'
                    ]);
                    return 0;
                }
                else
                //En caso de que el usuario no este cursando esa aula
                if($aula_estudiante->verificar($_SESSION['usuario']["id"], $id_evaluaciones)== false){
                     echo json_encode([
                        'estatus' => '3',
                        'icon' => 'info',
                        'title' => 'Modificar calificación',
                        'message' => 'El estudiante no pertenece al aula'
                    ]);
                    return 0;
                }
                //Si ese usuario pertenece al aula
                else{
                    $response = $estudiante_evaluacion->modificar_calificacion($_POST['id_evaluacion'], $_POST['calificacion']);
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
                }
                exit;
            break;
        }
    }
    /*
    * Verifico que se ha pasado por url el id de la evaluacion seleccionada 
    * en una unidad de aula
    */
    if (isset($id_evaluaciones)) {
        $id_unidad_evaluacion = $id_evaluaciones;
        $mostrar_unidad = $unidad_evaluacion->cargar($id_unidad_evaluacion); 
        if($mostrar_unidad == null){
            require_once "vista/error_404Vista.php";
            exit;
        }
        else{
            $mostrar_estudiante_evaluacion = $estudiante_evaluacion->cargar($_SESSION['usuario']["id"], $id_unidad_evaluacion);
            $nombre_evaluacion_entregada = $mostrar_estudiante_evaluacion!=null ? $mostrar_estudiante_evaluacion[0]['descripcion'] : '<p style="color:red;">No ha entregado</p>';
            $fecha_entrega = $mostrar_estudiante_evaluacion!=null ?date('d-m-Y h:i:s', strtotime($mostrar_estudiante_evaluacion[0]['fecha'])) : '';
            $calificacion = $mostrar_estudiante_evaluacion!=null ? $mostrar_estudiante_evaluacion[0]['calificacion'] : '';
            $descripcion_evaluacion = $mostrar_estudiante_evaluacion!=null ? $mostrar_estudiante_evaluacion[0]['descripcion']: '';
            $archivo_evaluacion = $mostrar_estudiante_evaluacion!=null ? '<a target="_blank" href="'._URL_.'/content/entregas/'.$id_unidad_evaluacion.'/'.$_SESSION['usuario']["id"].'"> Documento Ajunto <i class="fas fa-cloud-download-alt"></i></a>'  : '';
            $nombre_archivo = $mostrar_unidad[0]['archivo'];
            $examen = '<a target="_blank" href="'._URL_.'/content/evaluaciones/'.$nombre_archivo.'"> Documento Ajunto <i class="fas fa-cloud-download-alt"></i></a>';
    
            $id = $mostrar_estudiante_evaluacion!=null ? $mostrar_estudiante_evaluacion[0]['id'] : '';
            $consultar = $id != null ? $estudiante_evaluacion->validar_actualizacion($id) : '';
            $entregas = $estudiante_evaluacion->mostrarEntregas($nombre_archivo = $mostrar_unidad[0]['id']);
            $status = 0;
            if($aula_estudiante->verificar_estudiante($_SESSION['usuario']["id"], $mostrar_unidad[0]['id'], date('Y-m-d h:i:s', time()))== 2){
                $status = 2;
            }
            else
            if($aula_estudiante->verificar_estudiante($_SESSION['usuario']["id"], $mostrar_unidad[0]['id'], date('Y-m-d h:i:s', time()))== 1){
                $status = 1;
            }
        }
    }
    require_once "vista/MostrarEvaluacionVista.php";
}else {
    echo "Pagina en construccion";
}