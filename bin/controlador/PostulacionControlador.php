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

$config = new configSistema();

if (!is_file($config->_Dir_Model_().$pagina.$config->_MODEL_())) {
    echo "Falta definir la clase " . $pagina;
    exit;
}

if (is_file($config->_Dir_Vista_().$pagina.$config->_VISTA_())) {
    //$o = new Postulacion();
    $usuario = new Usuario();
    $aspirante = new Aspirante();
    $aspirante_emprendimiento = new AspiranteEmprendimiento();
    $postulacion = new Postulacion();
    $emprendimiento = new Emprendimiento();
    $modulo = 'Postulación:';

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
            usleep(5);
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
                    'direccion' => $valor['direccion']
                ]);
            }
            return 0;
        }
        else if ($accion == 'registrar') {
            print_r($_POST['emprendimiento']);
            return 0;
            if ($_POST['id'] != '') {
                $id_aspirante = $_POST['id'];
            }
            else
            {
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
                $response = $aspirante->registrar_aspirante($_POST['cedula'], $_POST['ciudad'],$_POST['primer_nombre'],$_POST['segundo_nombre'],$_POST['primer_apellido'],$_POST['segundo_apellido'],$_POST['genero'],$_POST['correo'],$_POST['direccion'],$_POST['telefono'], $clave);
                if($response)
                {
                    $datos = $usuario->buscar_cedula($_POST['cedula']);
                    $id_aspirante = $datos[0]['id'];
                    echo "alert('".$_POST['cedula']."')";
                }
                else
                {
                    $config->informacion('Postulación', $response);
                    exit();
                }
            }
            if(!empty($_POST['emprendimiento'])){
                foreach($_POST['emprendimiento'] as $id_emprendimiento){
                    $response = $aspirante_emprendimiento->incluir($id_aspirante, $id_emprendimiento);
                } 
            }else{
                echo "<script>
                swal({
                    title: '¡ERROR!',
                    text: 'Esto es un mensaje de error',
                    type: 'error',
                });</script>";
            }
            //$config->confirmar('Postulación', 'Registro exitoso');
            //return 0;
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
        else if ($accion == "cargar_emprendimientos") {
            $consulta = $emprendimiento->cemprendimiento();
            echo json_encode([
                'datos' => $consulta,
                'resultado' => 'cargar_emprendimientos'
            ]);
            return 0;
        } 
        
    } /*
        else if ($accion == 'recuperar') {
            $aspirante_emprendimiento->set_user($_POST['user']);
            $infoRD = $o->datos_UserRU();
            if (!empty($infoRD)) {
                foreach ($infoRD as $datos) {
                    $nombre = $datos['nombre'];
                    $apellido = $datos['apellido'];
                    $correo = $datos['correo'];
                    $telefono = $datos['telefono'];
                    $clave = $datos['clave'];
                }
                if ($_POST['nombre'] == $nombre && $_POST['apellido'] == $apellido && $_POST['correo'] == $correo && $_POST['telefono'] == $telefono) {
                    mail($correo, 'Recuperación de contraseña', 'Su contraseña es: ' . $clave, 'Aula virtual-diplomado', 'Aula virtual-diplomado');
                    $config->confirmar('Correo gmail:', 'Se envio la clave al correo: ' . $correo);
                } else {
                    $config->informacion($modulo, 'Verifique sus datos');
                }
                return 0;
            } else {
                $config->informacion($modulo, 'Verifique sus datos');
            }
            return 0;
        }*/
        $r3 = $emprendimiento->listar();
    $listar_emprendimientos = $postulacion->emprendimientos_propuestos();
    require_once "vista/" . $pagina . "Vista.php";
} else {
    echo "Pagina en construccion";
}