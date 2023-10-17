<?php
use config\componentes\configSistema as configSistema;
use modelo\RespaldobdModelo as Respaldobd;
use modelo\BitacoraModelo as Bitacora;
$config = new configSistema();
$respaldobd = new Respaldobd();
$bitacora = new Bitacora();
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

    if(count(array_filter($_SESSION['usuario'])) == 0) {
        $redirectUrl = '?pagina=' . configSistema::_LOGIN_();
        echo '<script>window.location="' . $redirectUrl . '"</script>';
        die();
    }

    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
        if ($accion == 'verificar_password') {
            $response = $respaldobd->verificar_password($_POST['cedula']);
            if (isset($response['resultado'])) {
                if($response['resultado']==3){
                    echo json_encode([
                        'estatus' => '3',
                        'icon' => 'error',
                        'title' => 'Permisos: ',
                        'message' => $response['mensaje']
                    ]);
                }
            }else{
                if(isset($response[0]['rol'])){
                    //VERIFICAR CLAVE (password_hash)
                    if(password_verify($_POST['clave_actual'], $response[0]['clave']) && $response[0]['rol']=="Super Usuario"){
                        echo json_encode([
                            'estatus' => '1',
                            'message' => true
                        ]);
                    }else{
                        echo json_encode([
                            'estatus' => '0',
                            'message' => 'La contraseña no coincide.'
                        ]);
                    }
                }else{
                    echo json_encode([
                        'estatus' => '2',
                        'message' => 'Usted no posee permisos para realizar el respaldo de la BD.'
                    ]);
                }
            }
            return 0;
        }else if($accion == 'verificar_clave_privada') {
            $verificar = "respaldar_true";
            openssl_public_encrypt($verificar, $textEncriptado, base64_decode($_POST['clave_publica']));

            $llavePrivada = openssl_pkey_get_private(base64_decode($_POST['clave_privada']));

            if ($llavePrivada === false) {
                echo json_encode([
                    'estatus' => '0',
                    'message' => 'La clave privada no coincide.'
                ]);
            } else {
                openssl_private_decrypt($textEncriptado, $textDesencriptado, base64_decode($_POST['clave_privada']));
                if ($textDesencriptado === "respaldar_true") {
                    echo json_encode([
                        'estatus' => '1',
                        'message' => true
                    ]);
                } else {
                    echo json_encode([
                        'estatus' => '0',
                        'message' => 'La clave privada no coincide.'
                    ]);
                }            

            }
            return 0;
        }else if ($accion == 'respaldarbd') {
            $response = $respaldobd->respaldarbd();
            if ($response){
            echo $response;
            }
            return 0;
        }else if ($accion == 'respaldo_parcial') {
            $response = $respaldobd->respaldo_parcial();
            if ($response){
            echo $response;
            }
            return 0;
        }
    } 
    require_once "vista/" . $pagina . "Vista.php";
} else {
    echo "Pagina en construcción";
}