<?php
use modelo\PaisModelo as Pais;
use modelo\EstadoModelo as Estado;
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
    $config = new Mensaje();
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
                    'ciudad' => $valor['ciudad'],
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
            if ($_POST['id'] != '') {
                $id_aspirante = $_POST['id'];
            }
            else
            {
                $response = $aspirante->registrar_aspirante($_POST['cedula'], $_POST['ciudad'],$_POST['primer_nombre'],$_POST['segundo_nombre'],$_POST['primer_apellido'],$_POST['segundo_apellido'],$_POST['genero'],$_POST['correo'],$_POST['direccion'],$_POST['telefono']);
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
    $listar_emprendimientos = $postulacion->emprendimientos_propuestos();
    require_once "vista/" . $pagina . "Vista.php";
} else {
    echo "Pagina en construccion";
}