<?php
use modelo\PaisModelo as Pais;
use modelo\EstadoModelo as Estado;
use modelo\CiudadModelo as Ciudad;
use modelo\EstudianteModelo as Estudiante;
use modelo\configNotificacionModelo as Mensaje;
use modelo\PermisosModelo as Permiso;
use modelo\BitacoraModelo as Bitacora;
use modelo\UsuariosRolesModelo as UsuariosRoles;
use modelo\LoginModelo as login;
use config\componentes\configSistema as configSistema;
$login = new login();
$config = new configSistema();
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

	$estudiante = new Estudiante();
	$permiso_usuario = new Permiso();
	$usuario_rol = new UsuariosRoles();
	$bitacora = new Bitacora();
	$modulo = 'Estudiante';
    
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

	$response = $permiso_usuario->mostrarpermisos($decrypted["id"],$decrypted["tipo_usuario"],"Estudiantes");
    //Establecer el id_usuario_rol para bitacora
	$id_usuario_rol = $bitacora->buscar_id_usuario_rol($decrypted["tipo_usuario"], $decrypted["id"]);
	$entorno = $bitacora->buscar_id_entorno('Estudiantes');
	$fecha = date('Y-m-d h:i:s', time());

	if (isset($_POST['accion'])) {
		$accion = $_POST['accion'];
		if ($accion == 'registrar') {
			if ($response[0]["registrar"] == "true"){
				$r2 = $usuario_rol->buscar_rol('Estudiante');
				$r1 = $estudiante->buscarestudiante($_POST['cedula']);
				if (empty($r1)==false && empty($r2)==false) {
					$responseincluirEstudiante = $usuario_rol->incluirEstudiantes($r1[0]['id'],$r2[0]['id']);
					if ($responseincluirEstudiante['resultado']==1) {
						echo json_encode([
							'estatus' => '1',
							'icon' => 'success',
							'title' => $modulo,
							'message' => $responseincluirEstudiante['mensaje']
						]);
						$bitacora->incluir($id_usuario_rol,$entorno,$fecha,"Registro");
					}else if ($responseincluirEstudiante['resultado']==2) {
						echo json_encode([
							'estatus' => '2',
							'icon' => 'info',
							'title' => $modulo,
							'message' => $responseincluirEstudiante['mensaje']
						]);
					}else{
						echo json_encode([
							'estatus' => '2',
							'icon' => 'error',
							'title' => $modulo,
							'message' => $responseincluirEstudiante['mensaje']
						]);
					}  
					return 0;
					exit;
				}else{  
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
					$clave_nueva ="Diplomado";
					$clave = password_hash($clave_nueva, PASSWORD_DEFAULT);
                    buscar_elemento($array_paises, $_POST['pais'], 'pais');
                    buscar_elemento($array_estados, $_POST['estado'], 'estado');
                    buscar_elemento($array_ciudades, $_POST['ciudad'], 'ciudad');
                    $response = $estudiante->incluir($_POST['cedula'], $_POST['ciudad'], $_POST['primer_nombre'],$_POST['segundo_nombre'],$_POST['primer_apellido'],$_POST['segundo_apellido'],$_POST['genero'],$_POST['correo'],$_POST['direccion'],$_POST['telefono'],$clave);
					if ($response['resultado']==1) {
						$r2 = $usuario_rol->buscar_rol('Estudiante');
						$r1 = $estudiante->buscarEstudiante($_POST['cedula']);
						$response1 = $usuario_rol->incluirEstudiantes($r1[0]['id'],$r2[0]['id']);
						echo json_encode([
							'estatus' => '1',
							'icon' => 'success',
							'title' => $modulo,
							'message' => $response['mensaje']
						]);
						$bitacora->incluir($id_usuario_rol,$entorno,$fecha,"Registro");
						return 0;
					} else if ($response['resultado']==2) {
						echo json_encode([
							'estatus' => '2',
							'icon' => 'info',
							'title' => $modulo,
							'message' => $response['mensaje']
						]);
						return 0;
					} 
					else if ($response['resultado']==3) {
						echo json_encode([
							'estatus' => '2',
							'icon' => 'info',
							'title' => $modulo,
							'message' => $response['mensaje']
						]);
						
					} else{
						echo json_encode([
							'estatus' => '2',
							'icon' => 'error',
							'title' => $modulo,
							'message' => $response['mensaje']
						]);
					}  
					return 0;
					exit;
				}
			}else{
				echo json_encode([
					'estatus' => '0',
					'icon' => 'error',
					'title' => $modulo,
					'message' => 'No tiene permisos para registrar.'
				]);
				return 0;
				exit;
			} 
		}else if ($accion == 'eliminar') {
			if ($response[0]["eliminar"] == "true"){
				$r2 = $usuario_rol->buscar_rol('Estudiante');
				$response_rol = $usuario_rol->eliminarE($_POST['id'],$r2[0]['id']);
				if ($response_rol['resultado']==1) {
					echo json_encode([
						'estatus' => '1',
						'icon' => 'success',
						'title' => $modulo,
						'message' => $response_rol['mensaje']
					]);
					$bitacora->incluir($id_usuario_rol,$entorno,$fecha,"Eliminación");
				} else if($response_rol['resultado']==2) {
					echo json_encode([
						'estatus' => '2',
						'icon' => 'info',
						'title' => $modulo,
						'message' => $response_rol['mensaje']
					]);
				}else if($response_rol['resultado']==3) {
					echo json_encode([
						'estatus' => '2',
						'icon' => 'info',
						'title' => $modulo,
						'message' => $response_rol['mensaje']
					]);
				}else{
					echo json_encode([
						'estatus' => '2',
						'icon' => 'error',
						'title' => $modulo,
						'message' => $response['mensaje']
					]);
				}  
				return 0;
				exit;
			}else{
				echo json_encode([
					'estatus' => '0',
					'icon' => 'error',
					'title' => $modulo,
					'message' => 'No tiene permisos para eliminar el registro.'
				]);
				return 0;
				exit;
			} 
		} else if ($accion == 'modificar') {
			if ($response[0]["modificar"] == "true"){
                buscar_elemento($array_paises, $_POST['pais'], 'pais');
                buscar_elemento($array_estados, $_POST['estado'], 'estado');
                buscar_elemento($array_ciudades, $_POST['ciudad'], 'ciudad');
                $response = $estudiante->modificar($_POST['id'], $_POST['ciudad'], $_POST['cedula'],$_POST['primer_nombre'],$_POST['segundo_nombre'],$_POST['primer_apellido'],$_POST['segundo_apellido'],$_POST['genero'],$_POST['correo'],$_POST['direccion'],$_POST['telefono']);
				if ($response['resultado']==1) {
					echo json_encode([
						'estatus' => '1',
						'icon' => 'success',
						'title' => $modulo,
						'message' => $response['mensaje']
					]);
					$bitacora->incluir($id_usuario_rol,$entorno,$fecha,"Modificacion");
				} else if ($response['resultado']==2) {
					echo json_encode([
						'estatus' => '2',
						'icon' => 'info',
						'title' => $modulo,
						'message' => $response['mensaje']
					]);
				}else if ($response['resultado']==3) {
					echo json_encode([
						'estatus' => '2',
						'icon' => 'info',
						'title' => $modulo,
						'message' => $response['mensaje']
					]);
				}else if ($response['resultado']==4) {
					echo json_encode([
						'estatus' => '2',
						'icon' => 'info',
						'title' => $modulo,
						'message' => $response['mensaje']
					]);
				}else{
					echo json_encode([
						'estatus' => '2',
						'icon' => 'error',
						'title' => $modulo,
						'message' => $response['mensaje']
					]);
				}  
				return 0;
				exit;
			}else{
				echo json_encode([
					'estatus' => '0',
					'icon' => 'error',
					'title' => $modulo,
					'message' => 'No tiene permisos para modificar el registro.'
				]);
				return 0;
				exit;
			} 
		} else if ($accion == 'editar') {
			$datos = $estudiante->cargar($_POST['id']);
			foreach ($datos as $valor) {
				echo json_encode([
					'id' => $valor['id'],
					'cedula' => $valor['cedula'],
					'primer_nombre' => $valor['primer_nombre'],
					'segundo_nombre' => $valor['segundo_nombre'],
					'primer_apellido' => $valor['primer_apellido'],
					'segundo_apellido' => $valor['segundo_apellido'],
					'genero' => $valor['genero'],
					'telefono' => $valor['telefono'],
					'correo' => $valor['correo'],
					'direccion' => $valor['direccion']
				]);
			}
			return 0;
		}else if($accion == 'listadopaises'){
            $r = array();
            $x = '<option disabled selected>Seleccione</option>';
            
            foreach ($array_paises as $key) {
                $x = $x . '<option value="' . $key['id'] . '">' . $key['name'] . '</option>';
            }
            $r['resultado'] = 'listadopaises';
            $r['mensaje'] = $x;

            echo json_encode($r);
            return 0;
        } else if($accion == 'listadoestados'){
            $r = array();
            $x = '<option disabled selected>Seleccione</option>';
            
            foreach ($array_estados as $estado) {
                if($estado['id_country'] == $_POST['pais']){
                    $x = $x . '<option value="' . $estado['id'] . '">' . $estado['name'] . '</option>';
                }
            }
            $r['resultado'] = 'listadoestados';
            $r['mensaje'] = $x;

            echo json_encode($r);
            return 0;
        } else if($accion == 'listadociudades'){
            $r = array();
            $x = '<option disabled selected>Seleccione</option>';
            
            foreach ($array_ciudades as $ciudad) {
                if($ciudad['id_state'] == $_POST['estado']){
                    $x = $x . '<option value="' . $ciudad['id'] . '">' . $ciudad['name'] . '</option>';
                }
            }
            $r['resultado'] = 'listadociudades';
            $r['mensaje'] = $x;

            echo json_encode($r);
            return 0;
        }
		else if ($accion == 'editarregistrar') {
			$datos = $estudiante->cargarregistrar($_POST['cedula']);
			if (empty($datos[0]['id'])) {
				echo json_encode([
					'estatus' => '0',
					'icon' => 'info',
					'title' => $modulo,
					'message' => $datos['mensaje']
				]);
			} else if (!empty($datos[0]['id'])) {
				foreach ($datos as $valor) {
					echo json_encode([
						'id' => $valor['id'],
						'cedula' => $valor['cedula'],
						'primer_nombre' => $valor['primer_nombre'],
						'segundo_nombre' => $valor['segundo_nombre'],
						'primer_apellido' => $valor['primer_apellido'],
						'segundo_apellido' => $valor['segundo_apellido'],
						'genero' => $valor['genero'],
						'telefono' => $valor['telefono'],
						'correo' => $valor['correo'],
						'direccion' => $valor['direccion']
					]);
				}
			}
			return 0;
		}
	}
	$r1 = $estudiante->listar();
	$datos = [];
	if (isset($response[0]["nombreentorno"])) {
		require_once "vista/" . $pagina . "Vista.php";
	}else{
		require_once "vista/error_Permisos.php";
	}
} else {
	echo "Pagina en construccion";
}