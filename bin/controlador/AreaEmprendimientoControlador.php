<?php
use modelo\configNotificacionModelo as config;
use modelo\PermisosModelo as Permiso;
use modelo\AreaEmprendimientoModelo as AreaEmprendimiento;
use modelo\BitacoraModelo as Bitacora;
use config\componentes\configSistema as configSistema;
use modelo\UsuarioModelo as Usuario;


$conf = new configSistema();

session_start();
if (!isset($_SESSION['usuario'])) {
    header('location:?pagina=login');
}

if (!is_file($conf->_Dir_Model_().$pagina.$conf->_MODEL_())) {
    echo "Falta definir la clase " . $pagina;
    exit;
}

if (is_file($conf->_Dir_Vista_().$pagina.$conf->_VISTA_())) {
    $area = new AreaEmprendimiento();
    $usuario = new Usuario();
    $permiso_usuario = new Permiso();
    $bitacora = new Bitacora();
    $config = new config();
    $modulo = 'Area de Emprendimiento';

    //Establecer el id_usuario_rol para bitacora
$id_usuario_rol = $bitacora->buscar_id_usuario_rol($_SESSION["usuario"]["tipo_usuario"], $_SESSION["usuario"]["id"]);
    $entorno = $bitacora->buscar_id_entorno('Area de Emprendimiento');
    $fecha = date('Y-m-d h:i:s', time());
    $token = $_SESSION["usuario"]["token"];

    /********************************************
    *   VALIDAR EL TOKEN ANTE CUALQUIER PETICION
    **********************************************/
    if(!isset($token)){
        /****************************************
        *   EN CASO DE OBTENER EL VALOR DEL TOKEN
        *****************************************/
        //MODELO DE COMO DEBEN SER LAS RESPUESTAS
        $json =  array(
            'status' => '404',
            'icon' => 'info',
            'title' => $modulo,
            'message' => 'La autorizacion es requerida'
        ); 
        //PARA MOSTRARLAS CON SU RESPECTIVO STATUS
        echo json_encode($json, http_response_code($json['status']));
        return 0;
    }
    else
    {
        $headers = $token;
        $token_verify = $usuario->validar_token($headers);
        if($token_verify == 'success'){
            if (isset($_POST['accion'])) {
                $accion = $_POST['accion'];
                if ($accion == 'registrar') {
                    $respuesta = $area->incluir($_POST['nombre']);
                    if ($respuesta['resultado']==1) {
                        echo json_encode([
                            'estatus' => '1',
                            'icon' => 'success',
                            'title' => $modulo,
                            'message' => $respuesta['mensaje']
                        ]);
                        $bitacora->incluir($id_usuario_rol,$entorno,$fecha,"Registro");
                    }else if ($respuesta['resultado']==2) {
                        echo json_encode([
                            'estatus' => '2',
                            'icon' => 'info',
                            'title' => $modulo,
                            'message' => $respuesta['mensaje']
                        ]);
                    } else if ($respuesta['resultado']==3) {
                        echo json_encode([
                            'estatus' => '2',
                            'icon' => 'info',
                            'title' => $modulo,
                            'message' => $respuesta['mensaje']
                        ]);
                    } else {
                        echo json_encode([
                            'estatus' => '0',
                            'icon' => 'info',
                            'title' => $modulo,
                            'message' => $respuesta['mensaje']
                        ]);
                    }
                    return 0;
                    exit;
                } else 
                if ($accion == 'eliminar') {
                    $respuesta = $area->eliminar($_POST['id']);
                    if ($respuesta['resultado']==1) {
                        echo json_encode([
                            'estatus' => '1',
                            'token' => $token,
                            'icon' => 'success',
                            'title' => $modulo,
                            'message' => $respuesta['mensaje']
                        ]);
                        $bitacora->incluir($id_usuario_rol,$entorno,$fecha,"Eliminación");
                    } else 
                    if ($respuesta['resultado']==2) {
                        echo json_encode([
                            'estatus' => '2',
                            'icon' => 'info',
                            'title' => $modulo,
                            'message' => $respuesta['mensaje']
                        ]);
                    } else 
                    if ($respuesta['resultado']==3) {
                        echo json_encode([
                            'estatus' => '2',
                            'icon' => 'info',
                            'title' => $modulo,
                            'message' => $respuesta['mensaje']
                        ]);
                    }  else {
                        echo json_encode([
                            'estatus' => '0',
                            'icon' => 'error',
                            'title' => $modulo,
                            'message' => $respuesta['mensaje']
                        ]);
                    }
                    return 0;
                    exit;
                } else if ($accion == 'modificar') {
                    $respuesta = $area->modificar($_POST['id'], $_POST['nombre']);
                    if ($respuesta['resultado']==1) {
                        echo json_encode([
                            'estatus' => '1',
                            'icon' => 'success',
                            'title' => $modulo,
                            'message' => $respuesta['mensaje']
                        ]);
                        $bitacora->incluir($id_usuario_rol,$entorno,$fecha,"Modificacion");
                    }
                    else if($respuesta['resultado']==2) {
                        echo json_encode([
                            'estatus' => '2',
                            'icon' => 'info',
                            'title' => $modulo,
                            'message' => $respuesta['mensaje']
                        ]);
                    }
                    else if($respuesta['resultado']==3) {
                        echo json_encode([
                            'estatus' => '2',
                            'icon' => 'info',
                            'title' => $modulo,
                            'message' => $respuesta['mensaje']
                        ]);
                    }
                    else if ($respuesta['resultado']==4) {
                        echo json_encode([
                            'estatus' => '2',
                            'icon' => 'info',
                            'title' => $modulo,
                            'message' => $respuesta['mensaje']
                        ]);
                    } else {
                        echo json_encode([
                            'estatus' => '0',
                            'icon' => 'error',
                            'title' => $modulo,
                            'message' => $respuesta['mensaje']
                        ]);
                    }
                    return 0;
                    exit;
                } else if ($accion == 'editar') {
                    $datos = $area->buscar($_POST['id']);
                    foreach ($datos as $valor) {
                        echo json_encode([
                            'id' => $valor[0],
                            'nombre' => $valor[1],
                        ]);
                    }
                    return 0;
                }
            }
        }
        else
        if($token_verify == 'expired')
        {
            //MODELO DE COMO DEBEN SER LAS RESPUESTAS
            $json =  array(
                'status' => '303',
                'icon' => 'info',
                'title' => $modulo,
                'message' => 'Token expirado'
            ); 
            //PARA MOSTRARLAS CON SU RESPECTIVO STATUS
            echo json_encode($json, http_response_code($json['status']));
            return 0;
        } 
        else
        {
            //MODELO DE COMO DEBEN SER LAS RESPUESTAS
            $json =  array(
                'status' => '400',
                'icon' => 'info',
                'title' => $modulo,
                'message' => 'No autorizado'
            ); 
            //PARA MOSTRARLAS CON SU RESPECTIVO STATUS
            echo json_encode($json, http_response_code($json['status']));
            return 0;
        } 
    }


    $response = $permiso_usuario->mostrarpermisos($_SESSION["usuario"]["id"],$_SESSION["usuario"]["tipo_usuario"],"Area de Emprendimiento");

    $r1 = $area->listar();
    $datos = [];
    require_once "vista/" . $pagina . "Vista.php";
}  else {
    echo "Pagina en construccion";
}