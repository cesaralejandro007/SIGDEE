<?php
use modelo\PaisModelo as Pais;
use modelo\EstadoModelo as Estado;
use modelo\EmprendimientoModelo as Emprendimiento;
use modelo\CiudadModelo as Ciudad;
use modelo\UsuarioModelo as Usuario;
use modelo\AspiranteModelo as Aspirante;
use modelo\configNotificacionModelo as Mensaje;
use modelo\PermisosModelo as Permiso;
use modelo\AspiranteEmprendimientoModelo as AspiranteEmprendimiento;
use modelo\PostulacionModelo as Postulacion;
use config\componentes\configSistema as configSistema;

$mensaje = new Mensaje();
$config = new configSistema();

if (!is_file($config->_Dir_Model_().$pagina.$config->_MODEL_())) {
    echo "Falta definir la clase " . $pagina;
    exit;
}

if (is_file($config->_Dir_Vista_().$pagina.$config->_VISTA_())) {
    $ciudad = new Ciudad();
    $usuario = new Usuario();
    $aspirante = new Aspirante();
    $aspirante_emprendimiento = new AspiranteEmprendimiento();
    $postulacion = new Postulacion();
    $emprendimiento = new Emprendimiento();
    $modulo = 'Postulación:';
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
    $clave = password_hash('Diplomado', PASSWORD_DEFAULT);
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
    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
        if ($accion == 'buscar-usuario') {
            $datos = $usuario->buscar_cedula($_POST['cedula']);
            if($datos != []){
                foreach ($datos as $valor) {
                    echo json_encode([
                        'id' => $valor['id'],
                        'cedula' => $valor['cedula'],
                        'ciudad' => $valor['id_ciudad'],
                        'primer_nombre' => $valor['primer_nombre'],
                        'segundo_nombre' => $valor['segundo_nombre'],
                        'primer_apellido' => $valor['primer_apellido'],
                        'segundo_apellido' => $valor['segundo_apellido'],
                        'genero' => $valor['genero'],
                        'correo' => $valor['correo'],
                        'telefono' => $valor['telefono'],
                        'direccion' => $valor['direccion'],
                        'datos' => 1
                    ]);
                }
            }
            else{
                echo json_encode([
                 'datos' => 0,
                 'cedula' => $_POST['cedula']
                ]);
            }
            
            return 0;
        }
        else if ($accion == 'registrar') {
            $respuesta = [];
            $id_emprendimiento = json_decode($_POST['emprendimientos']);
            $id_aspirante = $_POST['id'];
            $cantidad_emprendimientos = $id_emprendimiento !=null ? count(json_decode($_POST['emprendimientos'])) : 0;
    

            /****Validacion --->  En caso de que no hayan elegido algun estudiante en la lista ****/
            if($id_emprendimiento== null || $cantidad_emprendimientos == 0 || $cantidad_emprendimientos  < 0){
                $respuesta = [
                    'estatus' => '3',
                    'icon' => 'info',
                    'title' => $modulo,
                    'message' => 'Debe elegir un emprendimiento'
                ];
                echo json_encode($respuesta);
                return 0; 
            }
            /******Fin de la validacion ********/   


            /****Validacion --->  En caso de que se reciba un id de emprendimiento que no exista ****/
            $encontrado = true;
            foreach ($id_emprendimiento as $emprende) {
                $emprende = $emprendimiento->existe($emprende);
                if($emprende == 0){
                    $encontrado = false;
                }
            }
            if($encontrado== false){
                $respuesta = [
                    'estatus' => '4',
                    'icon' => 'info',
                    'title' => $modulo,
                    'message' => 'El emprendimiento no existe'
                ];
                echo json_encode($respuesta);
                return 0; 
            }
            /******Fin de la validacion ********/   

            //Registrar pais, estado y ciudad si no existen
            buscar_elemento($array_paises, $_POST['pais'], 'pais');
            buscar_elemento($array_estados, $_POST['estado'], 'estado');
            buscar_elemento($array_ciudades, $_POST['ciudad'], 'ciudad');
            
            if ($_POST['id'] != '') {
                $id_aspirante = $_POST['id'];
            }
            else
            {
                $response = $aspirante->registrar_aspirante($_POST['cedula'], $_POST['ciudad'],$_POST['primer_nombre'],$_POST['segundo_nombre'],$_POST['primer_apellido'],$_POST['segundo_apellido'],$_POST['genero'],$_POST['correo'],$_POST['direccion'],$_POST['telefono'], $clave);
                if ($response["resultado"]==1) {
                    $datos = $usuario->buscar_cedula($_POST['cedula']);
                    $id_aspirante = $datos[0]['id'];
                } else if ($response["resultado"]==2) {
                    echo json_encode([
                        'estatus' => '2',
                        'icon' => 'error',
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
                if($response)
                {
                    $datos = $usuario->buscar_cedula($_POST['cedula']);
                    $id_aspirante = $datos[0]['id'];
                }
                else
                {
                    $mensaje->error('Postulación', 'Error al registrar aspirante');
                    exit();
                }
            }
            if(!empty($_POST['emprendimientos'])){
                $emprendimientos = json_decode($_POST['emprendimientos']);
                foreach($emprendimientos as $id_emprendimiento){
                    $response = $aspirante_emprendimiento->incluir($id_aspirante, $id_emprendimiento);
                } 
                $mensaje->confirmar('Postulación', 'Registro exitoso');
                return 0;
            }else{
                $mensaje->error('Postulación', 'No ha elegido un emprendimiento');
                exit();
            }
            $config->confirmar('Postulación', 'Registro exitoso');
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
        else if($accion = 'listadoemprendimientos'){
            $respuesta = $emprendimiento->mostrar();
            echo json_encode([
                'resultado' => 'listadoemprendimientos',
                'datos' => $respuesta
            ]);
            return 0;
        }
        
    } 
        $r3 = $emprendimiento->listar();
    $listar_emprendimientos = $postulacion->emprendimientos_propuestos();
    require_once "vista/" . $pagina . "Vista.php";
} else {
    echo "Pagina en construccion";
}