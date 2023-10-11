<?php
use modelo\PerfilModelo as Perfil;
use modelo\configNotificacionModelo as Mensaje;
use modelo\PermisosModelo as Permiso;
use modelo\BitacoraModelo as Bitacora;
use config\componentes\configSistema as configSistema;
$configuracion = new configSistema();

session_start();
if (!isset($_SESSION['usuario'])) {
	$redirectUrl = '?pagina=' . configSistema::_LOGIN_();
    echo '<script>window.location="' . $redirectUrl . '"</script>';
    die();
}

if (!is_file($configuracion->_Dir_Model_().$pagina.$configuracion->_MODEL_())) {
    echo "Falta definir la clase " . $pagina;
    exit;
}
$perfil = new Perfil();
$config = new Mensaje();
$modulo = 'Perfil';

if (is_file($configuracion->_Dir_Vista_().$pagina.$configuracion->_VISTA_())) {

        if(count(array_filter($_SESSION['usuario'])) == 0) {
        $redirectUrl = '?pagina=' . configSistema::_LOGIN_();
        echo '<script>window.location="' . $redirectUrl . '"</script>';
        die();
    }

    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];

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


        if ($accion == 'modificarperfil') {

/*             function Codificar($string)
            {
                $codec = '';
                for ($i = 0; $i < strlen($string); $i++) {
                    $codec = $codec . base64_encode($string[$i]) . "#";
                }
                $string = base64_encode(base64_encode($codec));
                $string = base64_encode($string);
                return $string;
            }

            $claveencriptada = Codificar($_POST['clave']);
 */

            $response = $perfil->modificar($_POST['id'],$_POST['telefono'],$_POST['correo']);
            if ($response["resultado"]==1) {
                echo json_encode([
                    'estatus' => '1',
                    'icon' => 'success',
                    'title' => $modulo,
                    'message' => $response["mensaje"]
                ]);
            }else{
                echo json_encode([
                    'estatus' => '0',
                    'icon' => 'error',
                    'title' => $modulo,
                    'message' => $response["mensaje"]
                ]);
            }
            return 0;
            exit;
        }else if ($accion == 'modificarfotoperfil') {
        if (isset($_FILES['archivo']['tmp_name'])) {
            $ruta = "content/usuarios/";
            move_uploaded_file($_FILES['archivo']['tmp_name'], 
            $ruta.$_POST['cedula'].'.png');
                echo json_encode([
                    'estatus' => '1',
                    'icon' => 'success',
                    'title' => $modulo,
                    'message' => 'Modificacion exitosa'
                ]);
        } else {
            echo json_encode([
                'estatus' => '2',
                'icon' => 'info',
                'title' => $modulo,
                'message' => 'Seleccione Archivos'
            ]);
        } 
            return 0;
        }else if ($accion == 'verificar_perfil') {
            $response = $perfil->verificarcambio_password($_POST['cedula']);
            //VERIFICAR CLAVE (password_hash)
            if(password_verify($_POST['clave_actual'], $response[0]['clave'])){
                echo 1;
            }else{
                echo 0;
            }
            return 0;
        }else if ($accion == 'cambiar_pasword') {
            //CLAVE ENCRIPTADA (password_hash)
            $clave_encriptada_nueva = password_hash($_POST['nueva_clave'], PASSWORD_DEFAULT);
            $preguntas_encriptadas = Codificar($_POST['preguntas_seguridad']);
            $response = $perfil->cambiar_password($_POST['cedula'],$clave_encriptada_nueva,$preguntas_encriptadas);
            if($response == 1){
                echo json_encode([
                    'estatus' => '1',
                    'icon' => 'success',
                    'title' => $modulo,
                    'message' => 'Los datos de seguridad se actualizo correctamente'
                ]);
            }else{
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'error',
                    'title' => $modulo,
                    'message' => 'error BD'
                ]);
            }
            return 0;
        }else if ($accion == 'editarperfil') {
        $datos = $perfil->cargar($_POST['id']);
        foreach ($datos as $valor) {
            echo json_encode([
                'id' => $valor['id'],
                'telefono' => $valor['telefono'],
                'correo' => $valor['correo'],
            ]);
        }
            return 0;
        }
    }

    $infoU = $perfil->datos_UserU($_SESSION['usuario']["cedula"]);

    require_once "vista/" . $pagina . "Vista.php";
} else {
    echo "Pagina en construccion";
}