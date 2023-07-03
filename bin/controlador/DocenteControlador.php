<?php
use modelo\DocenteModelo as Docente;
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
    $docente = new Docente();
    $permiso_usuario = new Permiso();
    $usuario_rol = new UsuariosRoles();
    $bitacora = new Bitacora();
    $config = new Mensaje();
    $modulo = 'Docente';

    //Establecer el id_usuario_rol para bitacora
    $id_usuario_rol = $bitacora->buscar_id_usuario_rol($_SESSION["usuario"]["tipo_usuario"], $_SESSION["usuario"]["id"]);
    $entorno = $bitacora->buscar_id_entorno('Docentes');
    $fecha = date('Y-m-d h:i:s', time());

    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
            if ($accion == 'registrar') {
                $r2 = $usuario_rol->buscar_rol('Docente');
                $r1 = $docente->buscardocente($_POST['cedula']);
                if (empty($r1)==false && empty($r2)==false) {
                    $responseincluirDocente = $usuario_rol->incluirDocentes($r1[0]['id'],$r2[0]['id']);
                    if ($responseincluirDocente['resultado']==1) {
                        echo json_encode([
                            'estatus' => '1',
                            'icon' => 'success',
                            'title' => $modulo,
                            'message' => $responseincluirDocente['mensaje']
                        ]);
                        $bitacora->incluir($id_usuario_rol,$entorno,$fecha,"Registro");
                    }else if ($responseincluirDocente['resultado']==2) {
                        echo json_encode([
                            'estatus' => '2',
                            'icon' => 'info',
                            'title' => $modulo,
                            'message' => $responseincluirDocente['mensaje']
                        ]);
                    }else{
                        echo json_encode([
                            'estatus' => '2',
                            'icon' => 'error',
                            'title' => $modulo,
                            'message' => $responseincluirDocente['mensaje']
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
                    $response = $docente->incluir($_POST['cedula'],$_POST['primer_nombre'],$_POST['segundo_nombre'],$_POST['primer_apellido'],$_POST['segundo_apellido'],$_POST['genero'],$_POST['correo'],$_POST['direccion'],$_POST['telefono'],$clave);
                    if ($response['resultado']==1) {
                        $r2 = $usuario_rol->buscar_rol('Docente');
                        $r1 = $docente->buscardocente($_POST['cedula']);
                        $response1 = $usuario_rol->incluirDocentes($r1[0]['id'],$r2[0]['id']);
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
           }else if ($accion == 'eliminar') {
            $r2 = $usuario_rol->buscar_rol('Docente');
            $response_rol = $usuario_rol->eliminarD($_POST['id'],$r2[0]['id']);
            if ($response_rol['resultado']==1) {
                echo json_encode([
                    'estatus' => '1',
                    'icon' => 'success',
                    'title' => $modulo,
                    'message' => $response_rol['mensaje']
                ]);
                $bitacora->incluir($id_usuario_rol,$entorno,$fecha,"Eliminación");
            } else if($response_rol['resultado']==2) {
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'info',
                    'title' => $modulo,
                    'message' => $response_rol['mensaje']
                ]);
            }else if($response_rol['resultado']==3) {
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'info',
                    'title' => $modulo,
                    'message' => $response_rol['mensaje']
                ]);
            }else{
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'error',
                    'title' => $modulo,
                    'message' => $response['mensaje']
                ]);
            }  
            return 0;
            exit;
        } else if ($accion == 'modificar') {
            $response = $docente->modificar($_POST['id'],$_POST['cedula'],$_POST['primer_nombre'],$_POST['segundo_nombre'],$_POST['primer_apellido'],$_POST['segundo_apellido'],$_POST['genero'],$_POST['correo'],$_POST['direccion'],$_POST['telefono']);
            if ($response['resultado']==1) {
                echo json_encode([
                    'estatus' => '1',
                    'icon' => 'success',
                    'title' => $modulo,
                    'message' => $response['mensaje']
                ]);
                $bitacora->incluir($id_usuario_rol,$entorno,$fecha,"Modificacion");
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
            }else if ($response['resultado']==4) {
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'info',
                    'title' => $modulo,
                    'message' => $response['mensaje']
                ]);
            }else{
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'error',
                    'title' => $modulo,
                    'message' => $response['mensaje']
                ]);
            }  
            return 0;
            exit;
        } else if ($accion == 'editar') {
            $datos = $docente->cargar($_POST['id']);
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
        }
        else if ($accion == 'editarregistrar') {
            $datos = $docente->cargarregistrar($_POST['cedula']);
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
        }
    }
    $response = $permiso_usuario->mostrarpermisos($_SESSION["usuario"]["id"],$_SESSION["usuario"]["tipo_usuario"],"Docentes");
    $r1 = $docente->listar();
    $datos = [];
    require_once "vista/" . $pagina . "Vista.php";
} else {
    echo "Pagina en construccion";
}