<?php
use modelo\LoginModelo as login;
use modelo\configNotificacionModelo as Mensaje;
use modelo\PermisosModelo as Permiso;
use modelo\RolModelo as Rol;
use config\componentes\configSistema as configSistema;
session_start();

$config = new configSistema();

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

        function isBase64($str) {
            $decoded = base64_decode($str, true);
            return ($decoded !== false) && (base64_encode($decoded) === $str);
        }
        

        if ($accion == 'ingresar') {
            $num_intentos = isset($_COOKIE['intentos'][$_POST['user']]) ? $_COOKIE['intentos'][$_POST['user']] : 1;
            $tipo = $_POST['tipo'];
            $usuario = $_POST['user'];        
            $claveencriptada = $_POST['password'];
            $login->set_tipo($tipo);
            $login->set_user($usuario);

            if (isBase64($claveencriptada)) {

                $privateKeyPath = 'RSA/private.key';
                
                // Lee la clave privada desde el archivo
                $privateKeyContents = file_get_contents($privateKeyPath);
                $privateKey = openssl_pkey_get_private($privateKeyContents);
                $encryptedData = base64_decode($_POST['password']);
                
                $decryptedData = '';

                openssl_private_decrypt($encryptedData, $decryptedData, $privateKey);
                    $claveencriptada = $decryptedData;
                    $login->set_password($decryptedData);
                if ($privateKey === false) {
                    die('Error al cargar la clave privada');
                }
                
            } else {
                $login->set_password($claveencriptada);
            }
            $responseU = $login->verificarU();
            $infoU = $login->datos_UserU();
            if($_POST['tipo']=="" || $_POST['user']==""  || $claveencriptada==""/*  || $_POST['captcha'] == "" */ ){
                echo json_encode([
                    'estatus' => '3',
                    'message' => "Complete los datos solicitados."
                ]);   
            }else if($responseU == 0){   
                if($login->comprobar_usuario($usuario)){  
                    if($num_intentos <= 3){             
                        setcookie('intentos[' . $_POST['user'] . ']', $num_intentos + 1, time() + 30); 
                    } 
                    if ($num_intentos >= 3) {
                        $mensaje->error($modulo,"El usuario: ".$_POST['user']." se encuentra bloqueado, Intente nuevamente en 30 segundos.");
                        return 0; 
                    }
                    $contador = 3 - $num_intentos;
                    $error_message = "Credenciales incorrectas, tiene ".$contador." intentos.";
                    $mensaje->error($modulo,$error_message);     
                    return 0; 
                }else{
                    echo json_encode([
                        'estatus' => '2',
                        'message' => "El usuario no existe."
                    ]);   
                }       
            }
            else if($responseU == 2){
                $mensaje->informacion('Error', 'No posee aulas asignadas con el rol elegido');
                return 0;
            }
            else if ($responseU == 1) {
                if (!empty($infoU)) {
                    if ($num_intentos >= 3) {
                        $mensaje->error($modulo,"El usuario: ".$_POST['user']." se encuentra bloqueado, Intente nuevamente en 30 segundos.");
                        return 0; 
                    }else if(password_verify($claveencriptada, $infoU[0]['clave'])){

                        setcookie('intentos', 0, time() - 3600);

                        foreach ($infoU as $datos) {
                            $id_rol = $rol->obtener_rol($datos['cedula'], $datos['nombreusuario']);
                            if ($id_rol == null) {
                                $mensaje->informacion('Error', 'No tiene privilegios para acceder');
                                exit();
                            }
                            $token = $login->token($datos['id'], $datos['correo'], $datos['idrol']);

                            $login->actualizar_fecha_acceso($_POST['user']);
                            $_SESSION['usuario'] = array('token' => $token['token'], 'id' => $datos['id'], 'nombre' => $datos['nombre'], 'apellido' => $datos['apellido'], 'genero' => $datos['genero'], 'cedula' => $datos['cedula'], 'correo' => $datos['correo'], 'telefono' => $datos['telefono'], 'idrol' => $datos['idrol'], 'tipo_usuario' => $datos['nombreusuario'], 'ultimo_acceso' => $datos['ultimo_acceso']);
                            
                            $_SESSION['rol'] = $id_rol;
                            
                        }
                        $mensaje->confirmar($modulo, 'Inicio exitoso');
                        $login->actualizar_fecha_acceso($_POST['user']);
                        return 0;
                    }else{
                        if($num_intentos <= 3){             
                            setcookie('intentos[' . $_POST['user'] . ']', $num_intentos + 1, time() + 30); 
                        }  
                        $contador = 3 - $num_intentos;
                        $error_message = "Credenciales incorrectas, tiene ".$contador." intentos.";
                        $mensaje->error($modulo, $error_message);
                    }
                }
            }else{
                $error_message = "Error BD";
                $mensaje->error($modulo, $error_message);
                return 0;
            }
            return 0;
        } else if ($accion == 'verificar_usuario') {
            $login->set_user($_POST['cedula']);
            $infoVD = $login->datos_UserRU();
            if (!empty($infoVD)) {
                foreach ($infoVD as $valor) {
                    echo json_encode([
                        'cedula' => $valor['cedula'],
                        'primer_nombre' => $valor['primer_nombre'],
                        'primer_apellido' => $valor['primer_apellido'],
                        'preguntas_seguridad' => Decodificar($valor['preguntas_seguridad'])
                    ]);
                }
            }else{
                echo 0;
            }
            return 0;
        }else if ($accion == 'cambiar_clave') {
             //ENCRIPTAR CLAVE (password_hash)
            $clave_encriptada_nueva = password_hash($_POST['clave_actualizada'], PASSWORD_DEFAULT);
            $resul = $login->cambiar_password($_POST['cedula'],$clave_encriptada_nueva);
            if($resul ==1 ){
                echo json_encode([
                    'estatus' => $resul,
                    'icon' => 'success',
                    'title' => 'Exito',
                    'message' => "Su contraseña ha sido cambiada exitosamente"
                ]);
            }else{
                echo json_encode([
                    'estatus' => 2,
                    'icon' => 'error',
                    'title' => 'Error',
                    'message' => "BD"
                ]);
            }
            return 0;
        }else if ($accion == 'codificarURL') {
            echo configSistema::_M01_();
            return 0;
        }else if($accion = "generar_llaves_rsa" && isset($_POST['counter'])) {
            $config = [
                "config" => "C:/xampp/php/extras/openssl/openssl.cnf",
                "private_key_bits" => 2048,
                'private_key_type' => OPENSSL_KEYTYPE_RSA
            ];
            
            $res = openssl_pkey_new($config);
            openssl_pkey_export($res, $privKey, NULL, $config);
            
            $details = openssl_pkey_get_details($res);
            $pubKey = $details['key'];
        
            
            // Guardar la clave privada en un archivo .key
            file_put_contents('RSA/private.key', $privKey);
            
            // Guardar la clave pública en un archivo .pub
            file_put_contents('RSA/public.key', $pubKey);

            echo base64_encode($pubKey);
            return 0;
        }else if($accion = "obtener_datos") {
            $login->set_tipo($_POST['tipo']);
            $login->set_user($_POST['user']);
            $infoU = $login->datos_UserU();
            echo json_encode($infoU);
            return 0;
        }
    }else {
        session_destroy();
    }
    $r2 = $login->listartipo_usuario();
    require_once "vista/" . $pagina . "Vista.php";
} else {
    echo "Pagina en construccion";
}