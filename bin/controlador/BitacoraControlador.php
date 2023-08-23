<?php  
use modelo\PermisosModelo as Permiso;
use modelo\BitacoraModelo as Bitacora;
use config\componentes\configSistema as configSistema;
use modelo\LoginModelo as login;

$config = new configSistema();
$login = new login();
session_start();
if (!isset($_SESSION['usuario'])) {
    header('location:?pagina=Login');
}
if (!is_file($config->_Dir_Model_().$pagina.$config->_MODEL_())) {
    echo "Falta definir la clase " . $pagina;
    exit;
}
if (is_file($config->_Dir_Vista_().$pagina.$config->_VISTA_())) {

    $private_key = $login->obtener_clave_privada($_SESSION['id_usuario']);
    
    $t_private_key = base64_decode($private_key[0]["privatekey"]);

    $decrypted = [];
    foreach ($_SESSION['usuario'] as $k => $v) {
        openssl_private_decrypt($v, $decrypted_data, $t_private_key);
        $decrypted[$k] = $decrypted_data;
    }


    $permiso_usuario = new Permiso();
    $bitacora = new Bitacora();
    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
        if ($accion == 'consultarfechabitacora') {
            $info_completa=[];
            $consul_bitacora = $bitacora->listar_bitacora_rango($_POST['fecha_inicio'],$_POST['fecha_fin']);
            if(isset($consul_bitacora['resultado'])){
                if($consul_bitacora['resultado']== 2) {
                    echo json_encode([
                        'estatus' => '2',
                        'icon' => 'error',
                        'title' => "Bitacora",
                        'message' => $consul_bitacora['mensaje']
                    ]);
                }
            }else{
                foreach ($consul_bitacora as $r) {
                    $info_completa[]=[  
                    "fecha"    =>    $r['fecha'],
                    "usuario"    =>    $r['usuario'],
                    "rol"    =>    $r['rol'],
                    "entorno"    =>    $r['entorno'],
                    "accion"  =>$r['accion'],
                ];
                }
                echo json_encode($info_completa);
            }
        }else if($_POST['accion'] == 'limpiar_bitacora'){
            $limpiar_bitacora = $bitacora->limpieza_bitacora($_POST['fecha_inicio'],$_POST['fecha_cierre']);
            if(isset($limpiar_bitacora['resultado'])){
                if($limpiar_bitacora['resultado']== 2) {
                    echo json_encode([
                        'estatus' => '0',
                        'icon' => 'error',
                        'title' => "Bitacora",
                        'message' => $limpiar_bitacora['mensaje']
                    ]);
                }else if($limpiar_bitacora['resultado']== 3) {
                    echo json_encode([
                        'estatus' => '0',
                        'icon' => 'error',
                        'title' => "Bitacora",
                        'message' => $limpiar_bitacora['mensaje']
                    ]);
                }
            }else if($limpiar_bitacora){
                echo json_encode([
                    'estatus' => '1',
                    'icon' => 'success',
                    'title' => 'bitacora',
                    'message' => 'Eliminación exitosa'
                ]);
            }else{
                echo json_encode([
                    'estatus' => '0',
                    'icon' => 'error',
                    'title' => 'bitacora',
                    'message' => 'Registro no eliminado'
                ]);
            }
        }
        return 0;
    }
    $r1 = $bitacora->listar();
    $datos = [];
    require_once "vista/" . $pagina . "Vista.php";
} else {
    echo "Pagina en construccion";
}