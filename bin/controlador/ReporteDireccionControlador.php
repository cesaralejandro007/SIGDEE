<?php
use modelo\AulaModelo as Aula;
use modelo\AreaEmprendimientoModelo as AreaEmprendimiento;
use modelo\ModuloModelo as Modulo;
use modelo\EmprendimientoModelo as Emprendimiento;
use modelo\PaisModelo as Pais;
use modelo\EstadoModelo as Estado;
use modelo\CiudadModelo as Ciudad;
use modelo\configNotificacionModelo as Mensaje;
use config\componentes\configSistema as configSistema;
use modelo\EstudianteModelo as Estudiante;
$config = new configSistema();
session_start();
if (!isset($_SESSION['usuario'])) {
	$redirectUrl = '?pagina=' . configSistema::_LOGIN_();
    echo '<script>window.location="' . $redirectUrl . '"</script>';
    die();
}

$aula = new Aula();
$area = new AreaEmprendimiento();
$emprendimiento = new Emprendimiento();
$modulo = new Modulo();
$pais = new Pais();
$estado = new Estado();
$ciudad = new Ciudad();
$estudiante = new Estudiante();
if (is_file($config->_Dir_Vista_().$pagina.$config->_VISTA_())) {

    if(count(array_filter($_SESSION['usuario'])) == 0) {
        $redirectUrl = '?pagina=' . configSistema::_LOGIN_();
        echo '<script>window.location="' . $redirectUrl . '"</script>';
        die();
    }
    
    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
        switch($accion){
          /*  case 'aprobados_reprobados':
                $resultados =  $estudiante_evaluacion
                            ->reporteAprobadosReprobados($_POST['aula'], $_POST['unidad'],$_POST['evaluacion']);
                $estudiantes = $resultados['aprobados'] > 0 || $resultados['aprobados']> 0 ? true : false;
                echo json_encode([
                    'grafica' => 'aprobados_reprobados',
                    'aprobados' => $resultados['aprobados'],
                    'reprobados' => $resultados['reprobados'],
                    'estudiantes' => $estudiantes
                ]);
                return 0;
            break;
            case 'aprobados_reprobados_aula':
                $resultados =  $aula
                            ->reporteAprobadosReprobados($_POST['aula']);
                $estudiantes = $resultados['aprobados'] > 0 || $resultados['aprobados']> 0 ? true : false;
                echo json_encode([
                    'grafica' => 'aprobados_reprobados_aula',
                    'aprobados' => $resultados['aprobados'],
                    'reprobados' => $resultados['reprobados'],
                    'estudiantes' => $estudiantes
                ]);
                return 0;
            break;*/
            case 'estudiantes_areas':
                $pais = $_POST['pais'] != null ? $_POST['pais'] : '';
                $estado = $_POST['estado'] != null ? $_POST['estado'] : '';
                $ciudad = $_POST['ciudad'] != null ? $_POST['ciudad'] : '';
                $area = $_POST['area'] != null ? $_POST['area'] : '';
                $resultados =  $area->reporteUbicacionArea($pais, $estado, $ciudad, $area);
                $estudiantes_status = $resultados['aprobados'] > 0 || $resultados['aprobados']> 0 ? true : false;
                echo json_encode([
                    'grafica' => 'estudiantes_areas',
                    'aprobados' => $resultados['aprobados'],
                    'reprobados' => $resultados['reprobados'],
                    'estudiantes_status' => $estudiantes_status
                ]);
                return 0;
            break;
            case 'buscar_direcciones':
                $pais = $_POST['pais'] != null ? $_POST['pais'] : null;
                $estado = $_POST['estado'] != null ? $_POST['estado'] : null;
                $resultados =  $estudiante->ReporteDireccion($estado, $pais);
                //$estudiantes_status = $resultados['aprobados'] > 0 || $resultados['aprobados']> 0 ? true : false;
                usleep(5);
                echo json_encode([
                    'status' => $resultados['status'],
                    'descripcion' => $resultados['descripcion'],
                    'datos' => $resultados['datos'],
                    'cantidad' => $resultados['cantidad'],
                    'reporte' => 'buscar_direcciones'
                ]);
                return 0;
            break;
            case 'direcciones_area':
                $pais = $_POST['pais'] != null ? $_POST['pais'] : null;
                $estado = $_POST['estado'] != null ? $_POST['estado'] : null;
                $resultados =  $estudiante->DireccionArea($_POST['area'],$estado, $pais);
                //$estudiantes_status = $resultados['aprobados'] > 0 || $resultados['aprobados']> 0 ? true : false;
                usleep(5);
                echo json_encode([
                    'status' => $resultados['status'],
                    'descripcion' => $resultados['descripcion'],
                    'datos' => $resultados['datos'],
                    'cantidad' => $resultados['cantidad'],
                    'reporte' => 'direcciones_area'
                ]);
                return 0;
            break;
            case 'direcciones_emprendimiento':
                $pais = $_POST['pais'] != null ? $_POST['pais'] : null;
                $estado = $_POST['estado'] != null ? $_POST['estado'] : null;
                $resultados =  $estudiante->DireccionEmprendimiento($_POST['emprendimiento'],$estado, $pais);
                //$estudiantes_status = $resultados['aprobados'] > 0 || $resultados['aprobados']> 0 ? true : false;
                usleep(5);
                echo json_encode([
                    'status' => $resultados['status'],
                    'descripcion' => $resultados['descripcion'],
                    'datos' => $resultados['datos'],
                    'cantidad' => $resultados['cantidad'],
                    'reporte' => 'direcciones_area'
                ]);
                return 0;
            break;
            case 'direcciones_curso':
                $pais = $_POST['pais'] != null ? $_POST['pais'] : null;
                $estado = $_POST['estado'] != null ? $_POST['estado'] : null;
                $resultados =  $estudiante->DireccionCursos($_POST['curso'],$estado, $pais);
                usleep(5);
                echo json_encode([
                    'status' => $resultados['status'],
                    'descripcion' => $resultados['descripcion'],
                    'datos' => $resultados['datos'],
                    'cantidad' => $resultados['cantidad'],
                    'reporte' => 'direcciones_curso'
                ]);
                return 0;
            break;
            case 'listadoareas':
                $respuesta = $area->listadoareas();
                usleep(5);
                echo json_encode([
                    'resultado' => $respuesta['resultado'],
                    'mensaje' => $respuesta['mensaje']
                ]);
                return 0;
            break;
            case 'listadoemprendimientos':
                $respuesta = $emprendimiento->listadoemprendimientos($_POST['area']);
                usleep(5);
                echo json_encode($respuesta);
                return 0;
            break;
            case 'listadoaulas':
                $respuesta = $aula->listarAulas($_POST['area'], $_POST['emprendimiento']);
                usleep(5);
                echo json_encode($respuesta);
                return 0;
            break;
            case 'listadopaises':
                //llamo al metodo de la clase aulajuan que lista las aulas
                $respuesta = $pais->listadopaises();
                usleep(5);
                echo json_encode($respuesta);
                return 0;
            break;
            case 'listadoestados':
                $respuesta = $estado->listadoestados($_POST['pais']);
                usleep(5);
                echo json_encode($respuesta);
                return 0;
            break;
            case 'listadociudades':
                $respuesta = $ciudad->listadociudades($_POST['estado']);
                usleep(5);
                echo json_encode($respuesta);
                return 0;
            break;
        }
    }
    require_once "vista/" . $pagina . "Vista.php";
} else {
    echo "pagina en construccion";
}