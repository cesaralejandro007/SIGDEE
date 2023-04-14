<?php
use modelo\UsuarioModelo as Usuario;
use modelo\PermisosModelo as Permiso;
use modelo\BitacoraModelo as Bitacora;
use modelo\RolModelo as Rol;
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
    $usuario = new Usuario();
    $rol = new Rol();
    $bitacora = new Bitacora();
    $modulo = 'Usuario: ';
    $id_usuario_rol = $bitacora->buscar_id_usuario_rol($_SESSION["usuario"]["tipo_usuario"], $_SESSION["usuario"]["id"]);
    $entorno = $bitacora->buscar_id_entorno('Usuarios');
    $fecha = date('Y-m-d h:i:s', time());
//  id  cedula  nombre  usuario clave imagen  id_rol
    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
        if ($accion == 'registrar') {
            $clave = "m3m0c0d3";
            function encrypt($string, $key)
            {
                $result = '';
                for ($i = 0; $i < strlen($string); $i++) {
                    $char = substr($string, $i, 1);
                    $keychar = substr($key, ($i % strlen($key)) - 1, 1);
                    $char = chr(ord($char) + ord($keychar));
                    $result .= $char;
                }
                return base64_encode($result);
            }       
            $claveencriptada = encrypt($_POST['clave'], $clave);
            $response = $usuario->incluir($_POST['cedula'],$_POST['nombre'],$_POST['apellido'],$_POST['correo'],$_POST['direccion'],$_POST['telefono'],$claveencriptada);
            if ($response["resultado"]==1) {
                echo json_encode([
                    'estatus' => '1',
                    'icon' => 'success',
                    'title' => $modulo,
                    'message' => $response["mensaje"]
                ]);
                $bitacora->incluir($id_usuario_rol,$entorno,$fecha,"Registro");
                return 0;
            } else if ($response["resultado"]==2) {
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'error',
                    'title' => $modulo,
                    'message' => $response["mensaje"]
                ]);
                return 0;
            } else if ($response["resultado"]==3) {
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'info',
                    'title' => $modulo,
                    'message' => $response["mensaje"]
                ]);
                return 0;
            }else{
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'error',
                    'title' => $modulo,
                    'message' => $response["mensaje"]
                ]);
                return 0;
            }
            exit;
        } else if ($accion == 'eliminar') {
            $response = $usuario->eliminar($_POST['cedula'],$_POST['id']);
            if ($response['resultado'] == 1) {
                echo json_encode([
                    'estatus' => '1',
                    'icon' => 'success',
                    'title' => "Usuario: ",
                    'message' => $response['mensaje']
                ]);
                $bitacora->incluir($id_usuario_rol,$entorno,$fecha,"Eliminación");
            } else if($response['resultado']== 2) {
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'info',
                    'title' => $modulo,
                    'message' => $response['mensaje']
                ]);
            }else if($response['resultado']== 3) {
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'info',
                    'title' => $modulo,
                    'message' => $response['mensaje']
                ]);
            }
            else if($response['resultado']== 4) {
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'info',
                    'title' => $modulo,
                    'message' => $response['mensaje']
                ]);
            }
            else if($response['resultado']== 5) {
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'info',
                    'title' => $modulo,
                    'message' => $response['mensaje']
                ]);
            }            
            else if($response['resultado']== 6) {
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
                    'message' => $response["mensaje"]
                ]);
            }
            return 0;
            exit;
        } else if ($accion == 'modificar') {
            $response = $usuario->modificar($_POST['id'],$_POST['cedula'],$_POST['nombre'],$_POST['apellido'],$_POST['correo'],$_POST['direccion'],$_POST['telefono'],$_POST['clave']);
            if ($response['resultado']== 1) {
                echo json_encode([
                    'estatus' => '1',
                    'icon' => 'success',
                    'title' => $modulo,
                    'message' => $response['mensaje']
                ]);
                $bitacora->incluir($id_usuario_rol,$entorno,$fecha,"Modificacion");
            }else if($response['resultado']== 2) {
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'error',
                    'title' => $modulo,
                    'message' => $response['mensaje']
                ]);
            }else if($response['resultado']== 3) {
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'info',
                    'title' => $modulo,
                    'message' => $response['mensaje']
                ]);
            }else if($response['resultado']== 4) {
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'info',
                    'title' => $modulo,
                    'message' => $response['mensaje']
                ]);
            } else {
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'info',
                    'title' => $modulo,
                    'message' => $response['mensaje']
                ]);
            }
            return 0;
            exit;
        } else if ($accion == 'editar') {
            $datos = $usuario->cargar($_POST['id']);
            foreach ($datos as $valor) {
                echo json_encode([
                    'id' => $valor['id'],
                    'cedula' => $valor['cedula'],
                    'nombre' => $valor['nombre'],
                    'apellido' => $valor['apellido'],
                    'correo' => $valor['correo'],
                    'direccion' => $valor['direccion'],
                    'telefono' => $valor['telefono'],
                    'clave' => $valor['clave'],
                ]);
            }
            return 0;
        } else if ($accion == 'registrarroles') {
            $response = $usuario->gestionarrol($_POST['idusuario'],$_POST['idrol'],$_POST['status']);
            if ($response['resultado']== 1) {
                echo json_encode([
                    'estatus' => '1',
                    'icon' => 'success',
                    'title' => $modulo,
                    'message' => $response['mensaje']
                ]);
                $bitacora->incluir($id_usuario_rol,$entorno,$fecha,"Registro de rol");
            }else if($response['resultado']== 2) {
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'success',
                    'title' => $modulo,
                    'message' => $response['mensaje']
                ]);
                $bitacora->incluir($id_usuario_rol,$entorno,$fecha,"Eliminación de rol");
            }else {
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'error',
                    'title' => $modulo,
                    'message' => $response['mensaje']
                ]);
            }
            return 0;
            exit;
        } else if ($accion == "cargarroles") {
            $cargarr = $usuario->crolesuser($_POST['id_usuario']);
            echo json_encode($cargarr);
            return 0;
        }
    }
    $cargar_roles = $usuario->cargar_rol();
    $r1 = $usuario->listar();
    $r2 = $rol->listar();
    $datos = [];
    require_once "vista/" . $pagina . "Vista.php";
} else {
    echo "Pagina en construccion";
}