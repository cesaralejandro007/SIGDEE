<?php
use modelo\PaisModelo as Pais;
use modelo\EstadoModelo as Estado;
use modelo\CiudadModelo as Ciudad;
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

    $array_paises = json_decode(utf8_encode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', file_get_contents($config->_JSON_()."countries.json"))), true);
    $array_estados = json_decode(utf8_encode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', file_get_contents($config->_JSON_()."states.json"))), true);
    $array_ciudades = json_decode(utf8_encode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', file_get_contents($config->_JSON_()."cities.json"))), true);  

    function buscar_elemento($array, $id, $clase){
        $pais = new Pais();
        $estado = new Estado();
        $ciudad = new Ciudad();
        foreach ($array as $key) {
            if($key['id'] == $id){
                switch($clase){
                    case 'pais':
                        $pais->incluir($key['id'], $key['name']);
                    break;
                    case 'estado':
                        $estado->incluir($key['id'], $key['id_country'], $key['name']);
                    break;
                    case 'ciudad':
                        $ciudad->incluir($key['id'], $key['id_state'], $key['name']);
                    break;
                }
            }
        }
    }
    $id_usuario_rol = $bitacora->buscar_id_usuario_rol($_SESSION["usuario"]["tipo_usuario"], $_SESSION["usuario"]["id"]);
    $entorno = $bitacora->buscar_id_entorno('Usuarios');
    $fecha = date('Y-m-d h:i:s', time());
//  id  cedula  nombre  usuario clave imagen  id_rol
    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
        if ($accion == 'registrar') {

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
            buscar_elemento($array_paises, $_POST['pais'], 'pais');
            buscar_elemento($array_estados, $_POST['estado'], 'estado');
            buscar_elemento($array_ciudades, $_POST['ciudad'], 'ciudad');
            $response = $usuario->incluir($_POST['cedula'], $_POST['ciudad'], $_POST['primer_nombre'],$_POST['segundo_nombre'],$_POST['primer_apellido'],$_POST['segundo_apellido'],$_POST['genero'],$_POST['correo'],$_POST['direccion'],$_POST['telefono'],$clave);
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
            }
            else if($response['resultado']== 7) {
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
            buscar_elemento($array_paises, $_POST['pais'], 'pais');
            buscar_elemento($array_estados, $_POST['estado'], 'estado');
            buscar_elemento($array_ciudades, $_POST['ciudad'], 'ciudad');
            $response = $usuario->modificar($_POST['id'], $_POST['ciudad'], $_POST['cedula'],$_POST['primer_nombre'],$_POST['segundo_nombre'],$_POST['primer_apellido'],$_POST['segundo_apellido'],$_POST['genero'],$_POST['correo'],$_POST['direccion'],$_POST['telefono']);
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
                    'primer_nombre' => $valor['primer_nombre'],
                    'segundo_nombre' => $valor['segundo_nombre'],
                    'primer_apellido' => $valor['primer_apellido'],
                    'segundo_apellido' => $valor['segundo_apellido'],
                    'genero' => $valor['genero'],
                    'correo' => $valor['correo'],
                    'direccion' => $valor['direccion'],
                    'telefono' => $valor['telefono']
                ]);
            }
            return 0;
    }else if($accion == 'listadopaises'){
        $r = array();
        $x = '<option disabled selected>Seleccione</option>';
        
        foreach ($array_paises as $key) {
            $x = $x . '<option value="' . $key['id'] . '">' . $key['name'] . '</option>';
        }
        $r['resultado'] = 'listadopaises';
        $r['mensaje'] = $x;

        echo json_encode($r);
        return 0;
    } else if($accion == 'listadoestados'){
        $r = array();
        $x = '<option disabled selected>Seleccione</option>';
        
        foreach ($array_estados as $estado) {
            if($estado['id_country'] == $_POST['pais']){
                $x = $x . '<option value="' . $estado['id'] . '">' . $estado['name'] . '</option>';
            }
        }
        $r['resultado'] = 'listadoestados';
        $r['mensaje'] = $x;

        echo json_encode($r);
        return 0;
    } else if($accion == 'listadociudades'){
        $r = array();
        $x = '<option disabled selected>Seleccione</option>';
        
        foreach ($array_ciudades as $ciudad) {
            if($ciudad['id_state'] == $_POST['estado']){
                $x = $x . '<option value="' . $ciudad['id'] . '">' . $ciudad['name'] . '</option>';
            }
        }
        $r['resultado'] = 'listadociudades';
        $r['mensaje'] = $x;

        echo json_encode($r);
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