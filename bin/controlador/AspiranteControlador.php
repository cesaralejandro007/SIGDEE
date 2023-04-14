<?php
use modelo\BitacoraModelo as Bitacora;
use modelo\AspiranteModelo as Aspirante;
use config\componentes\configSistema as configSistema;

$config = new configSistema();

$aspirante = new Aspirante();

session_start();
if (!isset($_SESSION['usuario'])) {
    header('location:?pagina=login');
}

if (!is_file($config->_Dir_Model_().$pagina.$config->_MODEL_())) {
    echo "Falta definir la clase " . $pagina;
    exit;
}

if (is_file($config->_Dir_Vista_().$pagina.$config->_VISTA_())) {
    $bitacora = new Bitacora();
    $modulo = "Aspirante";
        //Establecer el id_usuario_rol para bitacora
        $id_usuario_rol = $bitacora->buscar_id_usuario_rol($_SESSION["usuario"]["tipo_usuario"], $_SESSION["usuario"]["id"]);
        $entorno = $bitacora->buscar_id_entorno('Aspirantes');
        $fecha = date('Y-m-d h:i:s', time());
    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
        if ($accion == 'eliminar') {
            $response = $aspirante->eliminar($_POST['id']);
            if ($response["resultado"]==1) {
                echo json_encode([
                    'estatus' => '1',
                    'icon' => 'success',
                    'title' => "Aspirante",
                    'message' => $response["mensaje"]
                ]);
                $bitacora->incluir($id_usuario_rol,$entorno,$fecha,"Eliminación");
            }  else if($response["resultado"]==2){
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'success',
                    'title' => "Aspirante",
                    'message' => $response["mensaje"]
                ]);
            }else if($response["resultado"]==3){
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'success',
                    'title' => "Aspirante",
                    'message' => $response["mensaje"]
                ]);
            }else {
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
            $response = $aspirante->modificar($_POST['id'],$_POST['cedula'],$_POST['nombre'],$_POST['apellido'],$_POST['telefono'],$_POST['correo'],$_POST['direccion']);
            if ($response["resultado"]==1) {
                echo json_encode([
                    'estatus' => '1',
                    'icon' => 'success',
                    'title' => "Aspirante",
                    'message' => $response["mensaje"]
                ]);
                $bitacora->incluir($id_usuario_rol,$entorno,$fecha,"Eliminación");
            }  else if($response["resultado"]==2){
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'success',
                    'title' => "Aspirante",
                    'message' => $response["mensaje"]
                ]);
            }else if($response["resultado"]==3){
                echo json_encode([
                    'estatus' => '2',
                    'icon' => 'success',
                    'title' => "Aspirante",
                    'message' => $response["mensaje"]
                ]);
            }else if($response["resultado"]==4){
            echo json_encode([
                'estatus' => '2',
                'icon' => 'success',
                'title' => "Aspirante",
                'message' => $response["mensaje"]
            ]);
        }else {
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
            $datos = $aspirante->cargar($_POST['id']);
            foreach ($datos as $valor) {
                echo json_encode([
                    'id' => $valor['id'],
                    'cedula' => $valor['cedula'],
                    'nombre' => $valor['nombre'],
                    'apellido' => $valor['apellido'],
                    'telefono' => $valor['telefono'],
                    'correo' => $valor['correo'],
                    'direccion' => $valor['direccion'],
                    'clave' => $valor['clave'],
                ]);
            }
            return 0;
        }
    }
    $r1 = $aspirante->listar();
    $datos = [];
    require_once "vista/" . $pagina . "Vista.php";
} else {
    echo "Pagina en construccion";
}