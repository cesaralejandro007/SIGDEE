<?php
session_start();
use modelo\ChatModelo as Chat;
use modelo\LoginModelo as login;
use config\componentes\configSistema as configSistema;
$chat = new Chat();
$config = new configSistema();
$login = new login();

if (!isset($_SESSION['usuario'])) {
	$redirectUrl = '?pagina=' . configSistema::_LOGIN_();
    echo '<script>window.location="' . $redirectUrl . '"</script>';
    die();
}

if (!is_file($config->_Dir_Model_().$pagina.$config->_MODEL_())) {
    echo "Falta definir la clase " . $pagina;
    exit;
} 
if (is_file("vista/" . $pagina . "Vista.php")) {

	$private_key = $login->obtener_clave_privada($_SESSION['id_usuario']);
    
    $t_private_key = base64_decode($private_key[0]["privatekey"]);

    $decrypted = [];
    foreach ($_SESSION['usuario'] as $k => $v) {
        openssl_private_decrypt($v, $decrypted_data, $t_private_key);
        $decrypted[$k] = $decrypted_data;
    }

    if(count(array_filter($decrypted)) == 0) {
        $redirectUrl = '?pagina=' . configSistema::_LOGIN_();
        echo '<script>window.location="' . $redirectUrl . '"</script>';
        die();
    }

	if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
		if ($accion == 'eliminar') {
			$respuesta = $chat->eliminar($_POST["id"]);
			$array[] = array('id' =>$_POST["id"],'accion' =>'eliminar');
			echo json_encode($array);
		}
		return 0;
		exit;
	}
	if(isset($_POST["name"])&&isset($_POST["message"])){
			$respuesta = $chat->incluir($decrypted["id"],$_POST["message"]);
			$idmensaje = $chat->buscar($decrypted["id"],$_POST["message"]);
			$dataTime = "<br><span>".date('d M Y H:i:s')."</span>";
			$array[] = array('name' => $_POST["name"], 'message' => $_POST["message"], "dataTime" => $dataTime, "id" => $idmensaje[0]['id']);
			echo json_encode($array);
			die();
	}
	$r1 = $chat->listar();
    require_once "vista/" . $pagina . "Vista.php";
} else {
    echo "pagina en construccion";
}