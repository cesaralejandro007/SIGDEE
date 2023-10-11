<?php
use modelo\PaisModelo as Pais;
use modelo\EstadoModelo as Estado;
use modelo\CiudadModelo as Ciudad;
use modelo\BitacoraModelo as Bitacora;
use modelo\PermisosModelo as Permiso;
use modelo\AspiranteModelo as Aspirante;
use config\componentes\configSistema as configSistema;


$config = new configSistema();
$aspirante = new Aspirante();

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

    $bitacora = new Bitacora();
    $permiso_usuario = new Permiso();
    $response = $permiso_usuario->mostrarpermisos($_SESSION['usuario']["id"],$_SESSION['usuario']["tipo_usuario"],"Aspirantes");
    $modulo = "Aspirante";

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

     //Establecer el id_usuario_rol para bitacora
    $id_usuario_rol = $bitacora->buscar_id_usuario_rol($_SESSION['usuario']["tipo_usuario"], $_SESSION['usuario']["id"]);
    $entorno = $bitacora->buscar_id_entorno('Aspirantes');
    $fecha = date('Y-m-d h:i:s', time());
    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
        if ($accion == 'eliminar') {
            if ($response[0]["eliminar"] == "true"){
                $response = $aspirante->eliminar($_POST['id']);
                if ($response["resultado"]==1) {
                    echo json_encode([
                        'estatus' => '1',
                        'icon' => 'success',
                        'title' => "Aspirante",
                        'message' => $response["mensaje"]
                    ]);
                    $bitacora->incluir($id_usuario_rol,$entorno,$fecha,"Eliminación");
                }  else if($response["resultado"]==2){
                    echo json_encode([
                        'estatus' => '2',
                        'icon' => 'success',
                        'title' => "Aspirante",
                        'message' => $response["mensaje"]
                    ]);
                }else if($response["resultado"]==3){
                    echo json_encode([
                        'estatus' => '2',
                        'icon' => 'success',
                        'title' => "Aspirante",
                        'message' => $response["mensaje"]
                    ]);
                }else {
                    echo json_encode([
                        'estatus' => '0',
                        'icon' => 'error',
                        'title' => $modulo,
                        'message' => $respuesta['mensaje']
                    ]);
                }
                return 0;
                exit;
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
                buscar_elemento($array_paises, $_POST['pais'], 'pais');
                buscar_elemento($array_estados, $_POST['estado'], 'estado');
                buscar_elemento($array_ciudades, $_POST['ciudad'], 'ciudad');    
                $response = $aspirante->modificar($_POST['id'],$_POST['cedula'], $_POST['ciudad'],$_POST['primer_nombre'],$_POST['segundo_nombre'],$_POST['primer_apellido'],$_POST['segundo_apellido'],$_POST['genero'],$_POST['correo'],$_POST['direccion'],$_POST['telefono']);
                if ($response["resultado"]==1) {
                    echo json_encode([
                        'estatus' => '1',
                        'icon' => 'success',
                        'title' => "Aspirante",
                        'message' => $response["mensaje"]
                    ]);
                    $bitacora->incluir($id_usuario_rol,$entorno,$fecha,"Eliminación");
                }  else if($response["resultado"]==2){
                    echo json_encode([
                        'estatus' => '2',
                        'icon' => 'success',
                        'title' => "Aspirante",
                        'message' => $response["mensaje"]
                    ]);
                }else if($response["resultado"]==3){
                    echo json_encode([
                        'estatus' => '2',
                        'icon' => 'success',
                        'title' => "Aspirante",
                        'message' => $response["mensaje"]
                    ]);
                }else if($response["resultado"]==4){
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'success',
                    'title' => "Aspirante",
                    'message' => $response["mensaje"]
                ]);
                }else {
                    echo json_encode([
                        'estatus' => '0',
                        'icon' => 'error',
                        'title' => $modulo,
                        'message' => $respuesta['mensaje']
                    ]);
                }
                    return 0;
                    exit;
            }else{
                echo json_encode([
                    'estatus' => '0',
                    'icon' => 'error',
                    'title' => $modulo,
                    'message' => 'No tiene permisos para editar el registro.'
                ]);
                return 0;
                exit;
            }
        } else if ($accion == 'editar') {
            $datos = $aspirante->cargar($_POST['id']);
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
        } else if ($accion == 'consultarpermisos') {
            $response = $permiso_usuario->mostrarpermisos($_SESSION['usuario']["ID"],$_SESSION['usuario']["tipo_usuario"],"Aspirantes");
            echo json_encode($response);
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
        }
    }
   
    $r1 = $aspirante->listar();
    $datos = [];
    if (isset($response[0]["nombreentorno"])) {
        require_once "vista/" . $pagina . "Vista.php";
    }else{
        require_once "vista/error_Permisos.php";
    }
} else {
    echo "Pagina en construccion";
}