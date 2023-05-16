<?php
use modelo\LoginModelo as login;
use modelo\configNotificacionModelo as Mensaje;
use modelo\PermisosModelo as Permiso;
use modelo\RolModelo as Rol;
use config\componentes\configSistema as configSistema;

$config = new configSistema();

session_start();
if (!is_file($config->_Dir_Model_().$pagina.$config->_MODEL_())) {
    echo "Falta definir la clase " . $pagina;
    exit;
}

if (is_file($config->_Dir_Vista_().$pagina.$config->_VISTA_())) {
    $login = new login();
    $config = new Mensaje();
    $rol = new Rol();
    $permiso_usuario = new Permiso();
    $modulo = 'Iniciar Sesion:';

    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
        if ($accion == 'ingresar') {
            $tipo = $_POST['tipo'];
            $usuario = $_POST['user'];
            
            //encriptacion
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
            $claveencriptada = encrypt($_POST['password'], $clave);
            $login->set_tipo($tipo);
            $login->set_user($usuario);
            $login->set_password($claveencriptada);
            $responseU = $login->verificarU();
            $infoU = $login->datos_UserU();
            if($responseU == 0){
                $config->error($modulo, 'Verifique sus datos');
                return 0;
            }
            else
            if($responseU == 2){
                $config->informacion('Error', 'No posee aulas asignadas con el rol elegido');
                return 0;
            }
            else
            if ($responseU == 1) {
                if (!empty($infoU)) {
                    foreach ($infoU as $datos) {
                        $_SESSION['usuario'] = array('id' => $datos['id'], 'nombre' => $datos['nombre'], 'apellido' => $datos['apellido'], 'genero' => $datos['genero'], 'cedula' => $datos['cedula'], 'correo' => $datos['correo'], 'telefono' => $datos['telefono'], 'idrol' => $datos['idrol'], 'tipo_usuario' => $datos['nombreusuario']);
                        $id_rol = $rol->obtener_rol($datos['cedula'], $datos['nombreusuario']);
                        if ($id_rol == null) {
                            $config->informacion('Error', 'No tiene privilegios para acceder');
                            exit();
                        }
                        $_SESSION['rol'] = $id_rol;
                    }
                }
                $config->confirmar($modulo, 'Inicio exitoso');
                return 0;
            } else {
                $config->error($modulo, 'Verifique sus datos');
                return 0;
            }
        } else if ($accion == 'recuperar') {
            $login->set_user($_POST['user']);
            $infoRD = $login->datos_UserRU();
            if (!empty($infoRD)) {
                foreach ($infoRD as $datos) {
                    $nombre = $datos['primer_nombre'];
                    $apellido = $datos['primer_apellido'];
                    $correo = $datos['correo'];
                    $telefono = $datos['telefono'];
                    $clave = $datos['clave'];
                }
                if ($_POST['nombre'] == $nombre && $_POST['apellido'] == $apellido && $_POST['correo'] == $correo && $_POST['telefono'] == $telefono) {
                    mail($correo, 'Recuperación de contraseña', 'Su contraseña es: ' . $clave, 'Aula virtual-diplomado', 'Aula virtual-diplomado');
                    $config->confirmar('Correo gmail:', 'Se envio la clave al correo: ' . $correo);
                } else {
                    $config->error($modulo, 'Verifique sus datos');
                }
                return 0;
            } else {
                $config->error($modulo, 'Verifique sus datos');
            }
            return 0;
        }
    } else {
        session_destroy();
    }
    $r2 = $login->listartipo_usuario();
    require_once "vista/" . $pagina . "Vista.php";
} else {
    echo "Pagina en construccion";
}