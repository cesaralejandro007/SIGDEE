<?php
use modelo\EstudianteModelo as Estudiante;
use modelo\configNotificacionModelo as Mensaje;
use modelo\PermisosModelo as Permiso;
use modelo\BitacoraModelo as Bitacora;
use modelo\UsuariosRolesModelo as UsuariosRoles;
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
    $estudiante = new Estudiante();
    $permiso_usuario = new Permiso();
    $usuario_rol = new UsuariosRoles();
    $bitacora = new Bitacora();
    $modulo = 'Estudiante';
    $response = $permiso_usuario->mostrarpermisos($_SESSION["usuario"]["id"],$_SESSION["usuario"]["tipo_usuario"],"Estudiantes");
    //Establecer el id_usuario_rol para bitacora
    $id_usuario_rol = $bitacora->buscar_id_usuario_rol($_SESSION["usuario"]["tipo_usuario"], $_SESSION["usuario"]["id"]);
    $entorno = $bitacora->buscar_id_entorno('Estudiantes');
    $fecha = date('Y-m-d h:i:s', time());

    if (isset($_POST['ReporteEstudiante'])) {
        require_once "reportes/reportesEstudiantes.php";
    }

    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
        if ($accion == 'registrar') {
            $r1 = $estudiante->buscarestudiante($_POST['cedula']);
            $r2 = $usuario_rol->buscar_rol('Estudiante');
            if (empty($r1)==false && empty($r2)==false) {
                $responseincluirEstudiates = $usuario_rol->incluirEstudiantes($r1[0]['id'],$r2[0]['id']);
                if ($responseincluirEstudiates['resultado']==1) {
                    echo json_encode([
                        'estatus' => '1',
                        'icon' => 'success',
                        'title' => $modulo,
                        'message' => $responseincluirEstudiates['mensaje']
                    ]);
                    $bitacora->incluir($id_usuario_rol,$entorno,$fecha,"Registro");
                }else if ($responseincluirEstudiates['resultado']==2) {
                    echo json_encode([
                        'estatus' => '2',
                        'icon' => 'info',
                        'title' => $modulo,
                        'message' => $responseincluirEstudiates['mensaje']
                    ]);
                }else if ($responseincluirEstudiates['resultado']==3) {
                    echo json_encode([
                        'estatus' => '2',
                        'icon' => 'info',
                        'title' => $modulo,
                        'message' => $responseincluirEstudiates['mensaje']
                    ]);
                }else{
                    echo json_encode([
                        'estatus' => '2',
                        'icon' => 'error',
                        'title' => $modulo,
                        'message' => $responseincluirEstudiates['mensaje']
                    ]);
                }  
                return 0;
                exit;
            }else{

                function Codificar($string)
                {
                    $codec = '';
                    for ($i = 0; $i < strlen($string); $i++) {
                        $codec = $codec . base64_encode($string[$i]) . "#";
                    }
                    $string = base64_encode(base64_encode($codec));
                    $string = base64_encode($string);
                    return $string;
                }
            
                function Decodificar($string)
                {
                    $decodec = '';
                    $string  = base64_decode(base64_decode($string));
                    $string  = base64_decode($string);
                    $string  = explode("#", $string);
            
                    foreach ($string as $str) {
                        $decodec = $decodec . base64_decode($str);
                    }
                    return $decodec;
                }
                $clave_nueva ="Diplomado";
                $clave = password_hash($clave_nueva, PASSWORD_DEFAULT);
                $response = $estudiante->incluir($_POST['cedula'],$_POST['primer_nombre'],$_POST['segundo_nombre'],$_POST['primer_apellido'],$_POST['segundo_apellido'],$_POST['genero'],$_POST['correo'],$_POST['direccion'],$_POST['telefono'],$clave);
                if ($response['resultado']==1) {
                    $r1 = $estudiante->buscarestudiante($_POST['cedula']);
                    $r2 = $usuario_rol->buscar_rol('Estudiante');
                    $response1 = $usuario_rol->incluirEstudiantes($r1[0]['id'],$r2[0]['id']);
                    echo json_encode([
                        'estatus' => '1',
                        'icon' => 'success',
                        'title' => $modulo,
                        'message' => $response['mensaje']
                    ]);
                    $bitacora->incluir($id_usuario_rol,$entorno,$fecha,"Registro");
                    return 0;
                } else if ($response['resultado']==2) {
                    echo json_encode([
                        'estatus' => '2',
                        'icon' => 'info',
                        'title' => $modulo,
                        'message' => $response['mensaje']
                    ]);
                    return 0;
                } 
                else if ($response['resultado']==3) {
                    echo json_encode([
                        'estatus' => '2',
                        'icon' => 'info',
                        'title' => $modulo,
                        'message' => $response['mensaje']
                    ]);
                    
                } else{
                    echo json_encode([
                        'estatus' => '2',
                        'icon' => 'error',
                        'title' => $modulo,
                        'message' => $response['mensaje']
                    ]);
                }  
                return 0;
                exit;
            }
        } else if ($accion == 'eliminar') {
            $r2 = $usuario_rol->buscar_rol('Estudiante');
            $response_rol = $usuario_rol->eliminarE($_POST['id'],$r2[0]['id']);
            if ($response_rol['resultado']==1) {
                echo json_encode([
                    'estatus' => '1',
                    'icon' => 'success',
                    'title' => $modulo,
                    'message' => $response_rol['mensaje']
                ]);
                $bitacora->incluir($id_usuario_rol,$entorno,$fecha,"Eliminación");
                return 0;
            } else if ($response_rol['resultado']==2) {
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'info',
                    'title' => $modulo,
                    'message' => $response_rol['mensaje']
                ]);
                return 0;
            }else if ($response_rol['resultado']==3) {
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'info',
                    'title' => $modulo,
                    'message' => $response_rol['mensaje']
                ]);
                return 0;
            }else{
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'error',
                    'title' => $modulo,
                    'message' => $response_rol['mensaje']
                ]);
            }
        } else if ($accion == 'modificar') {
            $response = $estudiante->modificar($_POST['id'],$_POST['cedula'],$_POST['primer_nombre'],$_POST['segundo_nombre'],$_POST['primer_apellido'],$_POST['segundo_apellido'],$_POST['genero'],$_POST['correo'],$_POST['direccion'],$_POST['telefono']);
            if ($response['resultado']==1) {
                echo json_encode([
                    'estatus' => '1',
                    'icon' => 'success',
                    'title' => $modulo,
                    'message' => $response['mensaje']
                ]);
                $bitacora->incluir($id_usuario_rol,$entorno,$fecha,"Modificacion");
                return 0;
            }else if ($response['resultado']==2) {
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'info',
                    'title' => $modulo,
                    'message' => $response['mensaje']
                ]);
                return 0;
            }else if ($response['resultado']==3) {
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'info',
                    'title' => $modulo,
                    'message' => $response['mensaje']
                ]);
                return 0;
            }else if ($response['resultado']==4) {
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'info',
                    'title' => $modulo,
                    'message' => $response['mensaje']
                ]);
                return 0;
            }else{
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'error',
                    'title' => $modulo,
                    'message' => $response_rol['mensaje']
                ]);
            }
        } else if ($accion == 'editar') {
            $datos = $estudiante->cargar($_POST['id']);
            foreach ($datos as $valor) {
                echo json_encode([
                    'id' => $valor['id'],
                    'cedula' => $valor['cedula'],
                    'primer_nombre' => $valor['primer_nombre'],
                    'segundo_nombre' => $valor['segundo_nombre'],
                    'primer_apellido' => $valor['primer_apellido'],
                    'segundo_apellido' => $valor['segundo_apellido'],
                    'genero' => $valor['genero'],
                    'telefono' => $valor['telefono'],
                    'correo' => $valor['correo'],
                    'direccion' => $valor['direccion']
                ]);
            }
            return 0;
        }else if ($accion == 'editarregistrar') {
            $datos = $estudiante->cargarregistrar($_POST['cedula']);
            if (empty($datos[0]['id'])) {
                echo json_encode([
                    'estatus' => '0',
                    'icon' => 'info',
                    'title' => $modulo,
                    'message' => $datos['mensaje']
                ]);
            } else if (!empty($datos[0]['id'])) {
                foreach ($datos as $valor) {
                    echo json_encode([
                        'id' => $valor['id'],
                        'cedula' => $valor['cedula'],
                        'primer_nombre' => $valor['primer_nombre'],
                        'segundo_nombre' => $valor['segundo_nombre'],
                        'primer_apellido' => $valor['primer_apellido'],
                        'segundo_apellido' => $valor['segundo_apellido'],
                        'genero' => $valor['genero'],
                        'telefono' => $valor['telefono'],
                        'correo' => $valor['correo'],
                        'direccion' => $valor['direccion']
                    ]);
                }
            }
            return 0;
        } else if ($accion == 'buscar') {
            $datos1 = $estudiante->buscar($_POST['buscarE']);
            echo $datos1;
        } else if($accion == 'listadoareas'){
            $r = array();
            $data = file_get_contents($config->_JSON_()."countries.json");
            $paises = json_decode(utf8_encode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $data)), true);
            $x = '<option disabled selected>Seleccione</option>';
            
            foreach ($paises as $pais) {
                $x = $x . '<option value="' . $pais['id'] . '">' . $pais['name'] . '</option>';
            }
            $r['resultado'] = 'listadoareas';
            $r['mensaje'] = $x;

            echo json_encode($r);
        } else if($accion == 'listadoemprendimientos'){
            $r = array();
            $data_2 = file_get_contents($config->_JSON_()."states.json");
            $estados = json_decode(utf8_encode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $data_2)), true);
            $x = '<option disabled selected>Seleccione</option>';
            
            foreach ($estados as $estado) {
                if($estado['id_country'] == $_POST['area']){
                    $x = $x . '<option value="' . $estado['id'] . '">' . $estado['name'] . '</option>';
                }
            }
            $r['resultado'] = 'listadoemprendimientos';
            $r['mensaje'] = $x;

            echo json_encode($r);
        }
        
        return 0;
    }
    $r1 = $estudiante->listar();          

    $datos = [];
    if (isset($response[0]["nombreentorno"])) {
        require_once "vista/" . $pagina . "Vista.php";
    }else{
        require_once "vista/error_Permisos.php";
    }
} else {
    echo "Pagina en construccion";
}