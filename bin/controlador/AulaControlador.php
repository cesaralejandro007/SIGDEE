<?php
use modelo\AulaModelo as Aula;
use modelo\AreaEmprendimientoModelo as AreaEmprendimiento;
use modelo\AulaEstudianteModelo as AulaEstudiante;
use modelo\AulaDocenteModelo as AulaDocente;
use modelo\EmprendimientoModelo as Emprendimiento;
use modelo\ModuloModelo as Modulo;
use modelo\EmprendimientoModuloModelo as EmprendimientoModulo;
use modelo\DocenteModelo as Docente;
use modelo\UnidadModelo as Unidad;
use modelo\configNotificacionModelo as Mensaje;
use modelo\PublicacionesModelo as Publicaciones;
use modelo\EstudianteModelo as Estudiante;
use modelo\AspiranteModelo as Aspirante;
use modelo\UsuariosRolesModelo as UsuariosRoles;
use modelo\UsuarioModelo as Usuario;
use modelo\PermisosModelo as Permisos;
use modelo\BitacoraModelo as Bitacora;
use modelo\ComentariosModelo as Comentarios;
use config\componentes\configSistema as configSistema;


$config = new configSistema();


session_start();
if (!isset($_SESSION['usuario'])) {
	$redirectUrl = '?pagina=' . configSistema::_LOGIN_();
    echo '<script>window.location="' . $redirectUrl . '"</script>';
    die();
}

if($pagina == "Aula"){
    $pagina = "Aula";
}else{
$str = $pagina;
// Dividir el string original
$partes = explode('&', $str);
// Obtener Aula
$aula_tmp = explode('"', $partes[0]);
$pagina = $aula_tmp[0];
// Obtener el valor número
$valor_tmp = explode('=', $partes[2]);
$valor = $valor_tmp[1];
$visualizar = explode('"', $partes[1])[0];
}

if (!is_file($config->_Dir_Model_().$pagina.$config->_MODEL_())) {
    echo "Falta definir la clase " . $parte;
    exit;
}

if (is_file($config->_Dir_Vista_().$pagina.$config->_VISTA_())) {
    if(count(array_filter($_SESSION['usuario'])) == 0) {
        $redirectUrl = '?pagina=' . configSistema::_LOGIN_();
        echo '<script>window.location="' . $redirectUrl . '"</script>';
        die();
    }

    $aula = new Aula();
    $aspirante = new Aspirante();
    $area = new AreaEmprendimiento();
    $aula_estudiante = new AulaEstudiante();
    $modulo_e = new Modulo();
    $emprendimiento = new Emprendimiento();
    $emprendimiento_modulo = new EmprendimientoModulo();
    $docente = new Docente();
    $aula_docente = new AulaDocente();
    $estudiante = new Estudiante();
    $config = new Mensaje();
    $unidad = new Unidad();
    $publicacion = new Publicaciones();
    $comentario = new Comentarios();
    $permiso_usuario = new Permisos();
    $bitacora = new Bitacora();
    $usuario_rol = new UsuariosRoles();
    $usuario = new Usuario();
    $modulo = 'Aula';
    $modulo_unidad = 'Unidad';
    $response = $permiso_usuario->mostrarpermisos($_SESSION['usuario']["id"],$_SESSION['usuario']["tipo_usuario"],"Aula");
    //Establecer el id_usuario_rol para bitacora
    $id_usuario_rol = $bitacora->buscar_id_usuario_rol($_SESSION['usuario']["tipo_usuario"], $_SESSION['usuario']["id"]);
    $entorno = $bitacora->buscar_id_entorno('Aula');
    $fecha = date('Y-m-d h:i:s', time());

    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
        switch ($accion) {
            case 'unidad':

                //Establecer el id_usuario_rol para bitacora
                $id_usuario_rolU = $bitacora->buscar_id_usuario_rol($_SESSION['usuario']["tipo_usuario"], $_SESSION['usuario']["id"]);
                $entornoU = $bitacora->buscar_id_entorno('Unidad');
                $fechaU = date('Y-m-d h:i:s', time());

                $response = $unidad->incluir($_POST['id'],$_POST['nombre'],$_POST['descripcion'],$_POST['id_aula']);
                if ($response) {
                    echo json_encode([
                        'estatus' => '1',
                        'icon' => 'success',
                        'title' => $modulo_unidad,
                        'message' => 'Registro exitoso'
                    ]);
                    $bitacora->incluir($id_usuario_rolU,$entornoU,$fechaU,"Registro");
                    return 0;
                } else {
                    echo json_encode([
                        'estatus' => '2',
                        'icon' => 'info',
                        'title' => $modulo_unidad,
                        'message' => 'La Unidad esta repetida'
                    ]);
                    return 0;
                }
                return 0;
                break;
            case 'registrar': 
                $respuesta = [];
                $id_estudiantes = json_decode($_POST['estudiantes']);
                $cantidad_estudiantes = $id_estudiantes !=null ? count(json_decode($_POST['estudiantes'])) : 0;
                 //Buscar el emprendimiento_modulo de acuerdo al id_emprendimiento y el id_modulo
                 $id_emprendimiento_modulo    = $emprendimiento_modulo->buscar_emprendimiento_modulo($_POST['id_tipo'], $_POST['id_modulo']);

                /****Validacion --->  En caso de que supere la cantidad de estudiantes****/
                if($cantidad_estudiantes > 30){
                    $respuesta = [
                            'estatus' => '0',
                            'icon' => 'info',
                            'title' => $modulo,
                            'message' => 'El limite de estudiante es de 30'
                        ];
                    echo json_encode($respuesta);
                    return 0;
                }
                /******Fin de la validacion ********/       

                /****Validacion --->  En caso de que no exista el id_emprendimiento_modulo ****/
                if($id_emprendimiento_modulo == 0){
                      $respuesta = [
                        'estatus' => '0',
                        'icon' => 'info',
                        'title' => $modulo,
                        'message' => 'No existe el emprendimiento modulo'
                    ];
                    echo json_encode($respuesta);
                    return 0;  
                }
                /******Fin de la validacion ********/       

                /****Validacion --->  En caso de que no hayan elegido algun estudiante en la lista ****/
                if($id_estudiantes== null){
                    $respuesta = [
                        'estatus' => '3',
                        'icon' => 'info',
                        'title' => $modulo,
                        'message' => 'Debe asignar estudiantes al aula'
                    ];
                    echo json_encode($respuesta);
                    return 0; 
                }
                /******Fin de la validacion ********/   


                /****Validacion --->  En caso de que se reciba un id de usuario que no exista ****/
                $encontrado = true;
                foreach ($id_estudiantes as $id_estudiante) {
                    $id_estudiante = $usuario->buscar_id($id_estudiante);
                    if($id_estudiante == 0){
                        $encontrado = false;
                    }
                }
                if($encontrado== false){
                    $respuesta = [
                        'estatus' => '4',
                        'icon' => 'info',
                        'title' => $modulo,
                        'message' => 'El aspirante no existe'
                    ];
                    echo json_encode($respuesta);
                    return 0; 
                }
                /******Fin de la validacion ********/   

                /****Validacion --->  En caso de que se reciba un id de docente que no exista ****/
                $id_docente = $docente->buscar_docente($_POST['docente']);   
                if($id_docente== 0 || empty($_POST['docente'])){
                    $respuesta = [
                        'estatus' => '5',
                        'icon' => 'info',
                        'title' => $modulo,
                        'message' => 'Se debe elegir un docente que exista'
                    ];
                    echo json_encode($respuesta);
                    return 0; 
                }
                /******Fin de la validacion ********/ 

                /****Validacion --->  En caso de que reciba el nombre el blanco ****/   
                if(empty($_POST['nombre'])){
                    $respuesta = [
                        'estatus' => '6',
                        'icon' => 'info',
                        'title' => $modulo,
                        'message' => 'Debe identificar el nombre del aula'
                    ];
                    echo json_encode($respuesta);
                    return 0; 
                }
                /******Fin de la validacion ********/  


                //Registrar el aula con su nombre, y id_emprendimiento_modulo
                $respuesta = $aula->incluir($_POST['nombre'], $id_emprendimiento_modulo);
                if ($respuesta['resultado']==1) {
                    $buscar_id = $aula->buscar_ultimo();
                    $aula_docente->incluir($buscar_id[0]['id'], $_POST['docente']);
                    foreach ($id_estudiantes as $id_estudiante) {
                        $aula_estudiante->incluir($buscar_id[0]['id'], $id_estudiante);
                        $r2 = $usuario_rol->buscar_rol('Estudiante');
                        $usuario_rol->incluirEstudiantes($id_estudiante,$r2[0]['id']);
                    }
                    $respuesta = [
                        'estatus' => '1',
                        'icon' => 'success',
                        'title' => $modulo,
                        'message' => $respuesta['mensaje']
                    ];
                    echo json_encode($respuesta);
                    $bitacora->incluir($id_usuario_rol,$entorno,$fecha,"Registro");

                    return 0;
                } else {
                    $respuesta = [
                        'estatus' => '2',
                        'icon' => 'info',
                        'title' => $modulo,
                        'message' => $respuesta['mensaje']
                    ];
                    echo json_encode($respuesta);
                    return 0;
                }
                break;
            case 'editar':
                $datos = $aula->cargar($_POST['id']);
                foreach ($datos as $valor) {
                    echo json_encode([
                        'id' => $valor[0],
                        'aula' => $valor[1],
                        'id_docente' => $valor[2],
                        'cedula' => $valor[3],
                        'nombre' => $valor[4],
                        'apellido' => $valor[5],
                    ]);
                }
                return 0;
                break;
            case 'eliminar':
                $response = $aula->eliminar($_POST['id']);
                if ($response["resultado"] ==1){
                    echo json_encode([
                        'estatus' => '1',
                        'icon' => 'success',
                        'title' => $modulo,
                        'message' => 'Eliminación exitosa'
                    ]);
                    $bitacora->incluir($id_usuario_rol,$entorno,$fecha,"Eliminación");
                } else if ($response["resultado"] == 2){
                    echo json_encode([
                        'estatus' => '0',
                        'icon' => 'error',
                        'title' => $modulo,
                        'message' => $response["mensaje"]
                    ]);
                }
                return 0;
                break;
            case 'modificar':
                $respuesta = [];
                $id_estudiantes = json_decode($_POST['estudiantes']);
                $cantidad_estudiantes = $id_estudiantes !=null ? count(json_decode($_POST['estudiantes'])) : 0;

                /****Validacion --->  En caso de que no hayan elegido algun estudiante en la lista ****/
                if($id_estudiantes== null){
                    $respuesta = [
                        'estatus' => '0',
                        'icon' => 'info',
                        'title' => $modulo,
                        'message' => 'Debe asignar estudiantes al aula'
                    ];
                    echo json_encode($respuesta);
                    return 0; 
                }
                /******Fin de la validacion ********/ 

                /****Validacion --->  En caso de que supere la cantidad de estudiantes****/
                if($cantidad_estudiantes > 30){
                    $respuesta = [
                        'estatus' => '2',
                        'icon' => 'info',
                        'title' => $modulo,
                        'message' => 'El limite de estudiante es de 30'
                    ];
                    echo json_encode($respuesta);
                    return 0; 
                }
                /******Fin de la validacion ********/  


                /****Validacion --->  En caso de que se reciba un id de usuario que no exista ****/
                $encontrado = true;
                foreach ($id_estudiantes as $id_estudiante) {
                    $id_estudiante = $usuario->buscar_id($id_estudiante);
                    if($id_estudiante == 0){
                        $encontrado = false;
                    }
                }
                if($encontrado== false){
                    $respuesta = [
                        'estatus' => '3',
                        'icon' => 'info',
                        'title' => $modulo,
                        'message' => 'El usuario no existe'
                    ];
                    echo json_encode($respuesta);
                    return 0; 
                }
                /******Fin de la validacion ********/  

                /****Validacion --->  En caso de que se reciba un id de docente que no exista ****/
                $validar_docente = $docente->buscar_docente($_POST['docente']);   
                if($validar_docente== 0 || empty($_POST['docente'])){
                    $respuesta = [
                        'estatus' => '4',
                        'icon' => 'info',
                        'title' => $modulo,
                        'message' => 'Se debe elegir un docente que exista'
                    ];
                    echo json_encode($respuesta);
                    return 0; 
                }
                /******Fin de la validacion ********/

                 /****Validacion --->  En caso de que reciba el nombre el blanco ****/   
                if(empty($_POST['nombre'])){
                    $respuesta = [
                        'estatus' => '5',
                        'icon' => 'info',
                        'title' => $modulo,
                        'message' => 'Debe identificar el nombre del aula'
                    ];
                    echo json_encode($respuesta);
                    return 0; 
                }
                /******Fin de la validacion ********/  

                $response = $aula->modificar($_POST['nombre'], $_POST['id']);
                if ($response['resultado']) {
                    $aula_docente->modificar($_POST['docente'], $_POST['id_aula_docente']);
                    $aula_estudiante->limpiar($_POST['id']);
                    foreach ($id_estudiantes as $id_estudiante) {
                        $aula_estudiante->incluir($_POST['id'], $id_estudiante);
                    }

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
                        'estatus' => '0',
                        'icon' => 'error',
                        'title' => $modulo,
                        'message' => $response['mensaje']
                    ]);
                    return 0;
                }
            break;
         
            case 'act_des':
                $des_act = $aula->actualizarstatus($_POST['id_aula'],$_POST['status']);
                if ($des_act['resultado']==1) {
                    echo json_encode([
                        'estatus' => 'check',
                        'icon' => 'success',
                        'title' => $modulo,
                        'message' => $des_act['mensaje']
                    ]);
                }else if ($des_act["resultado"] == 2){
                    echo json_encode([
                        'estatus' => 'check',
                        'icon' => 'success',
                        'title' => $modulo,
                        'message' => $des_act["mensaje"]
                    ]);
                }
                return 0;
                break;
            case 'cargarcheckem':
                $cargar = $aula->chequearaulas();
                echo json_encode($cargar);
                return 0;
                break;
            case 'listar_tipos':
                $datos = $emprendimiento->mostrar_tipos($_POST['id_area']);
                echo $datos;
                return 0;
                break;
            case 'listar_modulos':
                $datos = $emprendimiento_modulo->mostrar_modulos($_POST['id_tipo']);
                echo $datos;
                return 0;
                break;
            case 'generar_nombre':
                $datos = $emprendimiento_modulo->buscar($_POST['id_tipo'], $_POST['id_modulo']);
                foreach ($datos as $dato) {
                    $emprendimiento = substr($dato['tipo'], 0, 4);
                    $model = substr($dato['modelo'], 0, 4);
                    $nombre_buscar = $emprendimiento . "-" . $model;
                }
                /*$cant = $aula->buscar($nombre_buscar);
                foreach($cant as $c){
                $nro = $c['cantidad']+1;
                $nombre = $nombre_buscar."-".$nro;
                }
                echo $nombre; */
                echo $nombre_buscar;
                return 0;
                break;
            case 'eliminarUnidad':
                $response = $unidad->eliminar($_POST['id']);
                if ($response['resultado'] == 1) {
                echo json_encode([
                    'estatus' => '1',
                    'icon' => 'success',
                    'title' => $modulo_unidad,
                    'message' => $response['mensaje']
                ]);
                $bitacora->incluir($id_usuario_rol,"Unidad",$fecha,"Eliminación");
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
            case 'editarUnidad':
                $datos = $unidad->cargar($_POST['id']);
                foreach ($datos as $valor) {
                    echo json_encode([
                        'id' => $valor['id'],
                        'nombre' => $valor['nombre'],
                        'descripcion' => $valor['descripcion'],
                        'id_aula' => $valor['id_aula']
                    ]);
                }
                break;
            case 'actulizar_unidad':
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
            case 'registrarforo':
                $response = $publicacion->incluir($_POST['titulo'],$_POST['mensaje'],$_POST['id_aula'],$_POST['cedula_usuario']);
                if ($response["resultado"]==1) {
                    echo json_encode([
                        'estatus' => '1',
                        'icon' => 'success',
                        'title' => 'Foro',
                        'message' => $response["mensaje"]
                    ]);
                    return 0;
                } else{
                    echo json_encode([
                        'estatus' => '2',
                        'icon' => 'error',
                        'title' => 'Foro',
                        'message' => 'Error'
                    ]);
                    return 0;
                }
                return 0;
                break;
            case 'eliminarforo':
                $response = $publicacion->eliminar($_POST['id']);
                if ($response["resultado"]==1) {
                    echo json_encode([
                        'estatus' => '1',
                        'icon' => 'success',
                        'title' => 'Foro',
                        'message' => $response["mensaje"]
                    ]);
                    return 0;
                } else if($response["resultado"]==2){
                    echo json_encode([
                        'estatus' => '0',
                        'icon' => 'error',
                        'title' => 'Foro',
                        'message' => $response["mensaje"]
                    ]);
                    return 0;
                }
                return 0;
                break;
            case 'modificarforo':
                $response = $publicacion->modificar($_POST['id'],$_POST['titulo'],$_POST['mensaje'],$_POST['id_aula']);
                if ($response["resultado"]==1){
                    echo json_encode([
                        'estatus' => '1',
                        'icon' => 'success',
                        'title' => 'Foro',
                        'message' => $response["mensaje"]
                    ]);
                    return 0;
                } else {
                    echo json_encode([
                        'estatus' => '0',
                        'icon' => 'error',
                        'title' => 'Foro',
                        'message' => 'Registro no modificado!'
                    ]);
                    return 0;
                }
                return 0;
                break;
            case 'editarforo':
                $datos = $publicacion->cargar($_POST['id']);
                foreach ($datos as $valor) {
                    echo json_encode([
                        'id' => $valor[0],
                        'titulo' => $valor[1],
                        'mensaje' => $valor[2],
                        'id_aula' => $valor[3],
                    ]);
                }
                return 0;
                break;
            case 'cargarcomentarios':
                if ($comentario->listarcomentario($_POST['id']) == 'false') {
                    echo json_encode([
                        'estatus' => '2',
                        'icon' => 'info',
                        'title' => 'Comentarios:',
                        'message' => 'No hay comentarios disponibles...'
                    ]);
                    return 0;

                } else {
                    $array1 = $comentario->listarcomentario($_POST['id']);
                    echo json_encode($array1);
                }
                return 0;
                break;
            case 'comentar':
                if (!empty($_POST['comentario'])) {
                    $response = $comentario->incluir($_POST['comentario'], $_POST['id_publicacion'], $_POST['cedula_usuario']);
                    if ($response["resultado"]==1) {
                        echo json_encode([
                            'estatus' => '1',
                            'icon' => 'success',
                            'title' => 'Comentario',
                            'message' =>  $response["mensaje"]
                        ]);
                    }
                } else {
                    echo json_encode([
                        'estatus' => '2',
                        'icon' => 'info',
                        'title' => 'Comentario',
                        'message' => 'Campo Vacio!'
                    ]);
                }
                return 0;
                break;
            case 'eliminarcomentarios':
                $response = $comentario->eliminar($_POST['id']);
                if ($response["resultado"]==1) {
                    echo json_encode([
                        'estatus' => '1',
                        'icon' => 'success',
                        'title' => 'Comentario',
                        'message' => $response["mensaje"]
                    ]);
                } else {
                    echo json_encode([
                        'estatus' => '0',
                        'icon' => 'error',
                        'title' => 'Comentario',
                        'message' => $response["mensaje"]
                    ]);
                }
                return 0;
                break;
            case 'editarcomentario':
                $datos = $comentario->cargar($_POST['id']);
                foreach ($datos as $valor) {
                    echo json_encode([
                        'id' => $valor[0],
                        'mensaje' => $valor[1],
                        'id_publicacion' => $valor[2],
                    ]);
                }
                return 0;
                break;
            case 'modificarcomentario':
                $response = $comentario->modificar($_POST['id'], $_POST['comentario']);
                if ($response["resultado"]==1) {
                    echo json_encode([
                        'estatus' => '1',
                        'icon' => 'success',
                        'title' => 'Comentario',
                        'message' => $response["mensaje"]
                    ]);
                    return 0;
                } else {
                    echo json_encode([
                        'estatus' => '0',
                        'icon' => 'error',
                        'title' => 'Comentario',
                        'message' => 'Registro no modificado!'
                    ]);
                    return 0;
                }
                return 0;
                break;

            case 'listadoaulas':
                //llamo al metodo de la clase auladocente que lista las aulas
                $respuesta = $aula->listadoaulas($_SESSION['usuario']["id"], $_SESSION['usuario']["tipo_usuario"]);
                usleep(5);
                echo json_encode($respuesta);
                break;
            case 'listadoareas':
                //llamo al metodo de la clase auladocente que lista las aulas
                $respuesta = $area->listadoareas();
                usleep(5);
                echo json_encode($respuesta);
                break;
            case 'listadoemprendimientos':
                //llamo al metodo de la clase auladocente que lista las aulas
                $respuesta = $emprendimiento->listadoemprendimientos($_POST['area']);
                usleep(5);
                echo json_encode($respuesta);
                break;
            case 'listadomodulos':
                //llamo al metodo de la clase auladocente que lista las aulas
                $respuesta = $modulo_e->listadomodulos($_POST['emprendimiento']);
                usleep(5);
                echo json_encode($respuesta);
                break;
            case 'listadodocentes':
                //llamo al metodo de la clase auladocente que lista las aulas
                $respuesta = $aula_docente->listadodocentes();
                usleep(5);
                echo json_encode($respuesta);
                break;
            case 'listadoaspirantes':
                //llamo al metodo de la clase auladocente que lista las aulas
                $respuesta = $aspirante->listadoaspirantes($_POST['emprendimiento']);
                usleep(5);
                echo json_encode($respuesta);
                break;
            case 'editarlistadodocentes':
                //llamo al metodo de la clase auladocente que lista las aulas
                $respuesta = $aula_docente->listadodocentes_aula($_POST['id_aula'],$_POST['id_docente']);
                usleep(5);
                echo json_encode($respuesta);
                break;
            case 'editarlistadoaspirantes':
                //llamo al metodo de la clase auladocente que lista las aulas
                $respuesta = $aspirante->listadoaspirantes_aula($_POST['id_aula']);
                usleep(5);
                echo json_encode($respuesta);
                break;
            case 'codificarURL_AE':
                echo configSistema::_M10_();
                break;
            case 'codificarURL_E':
                echo configSistema::_M11_();
                break;
            case 'codificarURL_M':
                echo configSistema::_M11_();
                break;
            case 'codificarURL_D':
                echo configSistema::_M09_();
                break;
        }
    } else
    if (isset($visualizar)) {
        if(isset($valor)){
            $listar_unidad = $unidad->listar_unidad_aula($valor);
           // if($listar_unidad != null){
                $datos = $aula->encontrar($valor);
                $estudiantes = $aula_estudiante->listar_por_aula($valor);
                $docentes = $aula_docente->listar_por_aula($valor);
        }
    
            if ($publicacion->listarpublicacion($datos[0]['id']) == 'false') {
                $x = 'falso';
            } else {
                $publicaciones = $publicacion->listarpublicacion($datos[0]['id']);
            }
            $unidadpermisos = $permiso_usuario->mostrarpermisos($_SESSION['usuario']["id"],$_SESSION['usuario']["tipo_usuario"],"Unidad");
        //}
        require_once "vista/MostrarAulaVista.php";

        //else   require_once "vista/error_404Vista.php";
    } else {
 
        $r1 = $aula->mostrar_aulas();
        $areas = $area->listar();
        $modulos = $modulo_e->listar();
        $docentes = $docente->listar();
        $estudiantes = $estudiante->listar();
        $datos = [];
        if (isset($response[0]["nombreentorno"])) {
            require_once "vista/" . $pagina . "Vista.php";
        }else{
            require_once "vista/error_Permisos.php";
        }
    }
} else {
    echo "Pagina en construccion";
}