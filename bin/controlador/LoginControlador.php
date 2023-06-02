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
    $mensaje = new Mensaje();
    $rol = new Rol();
    $permiso_usuario = new Permiso();
    $modulo = 'Iniciar Sesion:';

    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
        if ($accion == 'ingresar') {
            $tipo = $_POST['tipo'];
            $usuario = $_POST['user'];
            
            //encriptacion
            
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
            
            $claveencriptada = Codificar($_POST['password']);
            $login->set_tipo($tipo);
            $login->set_user($usuario);
            $login->set_password($claveencriptada);
            $responseU = $login->verificarU();
            $infoU = $login->datos_UserU();
            if($responseU == 0){
                $mensaje->error($modulo, 'Verifique sus datos');
                return 0;
            }
            else
            if($responseU == 2){
                $mensaje->informacion('Error', 'No posee aulas asignadas con el rol elegido');
                return 0;
            }
            else
            if ($responseU == 1) {
                if (!empty($infoU)) {
                    foreach ($infoU as $datos) {
                        $id_rol = $rol->obtener_rol($datos['cedula'], $datos['nombreusuario']);
                        if ($id_rol == null) {
                            $mensaje->informacion('Error', 'No tiene privilegios para acceder');
                            exit();
                        }
                        $token = $login->token($datos['id'], $datos['correo'], $datos['idrol']);

                        $_SESSION['usuario'] = array('token' => $token['token'], 'id' => $datos['id'], 'nombre' => $datos['nombre'], 'apellido' => $datos['apellido'], 'genero' => $datos['genero'], 'cedula' => $datos['cedula'], 'correo' => $datos['correo'], 'telefono' => $datos['telefono'], 'idrol' => $datos['idrol'], 'tipo_usuario' => $datos['nombreusuario']);
                        $_SESSION['rol'] = $id_rol;
                        

                    }
                }
                $mensaje->confirmar($modulo, 'Inicio exitoso');
                return 0;
            } else {
                $mensaje->error($modulo, 'Verifique sus datos');
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
                    $mensaje->confirmar('Correo gmail:', 'Se envio la clave al correo: ' . $correo);
                } else {
                    $mensaje->error($modulo, 'Verifique sus datos');
                }
                return 0;
            } else {
                $mensaje->error($modulo, 'Verifique sus datos');
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