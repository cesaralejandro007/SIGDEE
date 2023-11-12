<?php
use modelo\EstudianteEvaluacionModelo as EstudianteEvaluacion;
use modelo\AulaModelo as Aula;
use modelo\AreaEmprendimientoModelo as AreaEmprendimiento;
use modelo\ModuloModelo as Modulo;
use modelo\EmprendimientoModelo as Emprendimiento;
use modelo\UnidadModelo as Unidad;
use modelo\EvaluacionModelo as Evaluacion;
use modelo\configNotificacionModelo as Mensaje;
use config\componentes\configSistema as configSistema;

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
$unidad = new Unidad();
$evaluacion = new Evaluacion();
$estudiante_evaluacion = new EstudianteEvaluacion();
if (is_file($config->_Dir_Vista_().$pagina.$config->_VISTA_())) {

    if(count(array_filter($_SESSION['usuario'])) == 0) {
        $redirectUrl = '?pagina=' . configSistema::_LOGIN_();
        echo '<script>window.location="' . $redirectUrl . '"</script>';
        die();
    }

    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
        switch($accion){
            case 'consulta_aprobados_reprobados':
                $resultados =  $aula
                            ->mostrar_notas_estudiantes($_POST['aula']);
                echo json_encode([
                    'grafica' => 'consulta_aprobados_reprobados',
                    'head' => $resultados['head'],
                    'estudiantes' => $resultados['estudiantes']
                ]);
                return 0;
            break;
            case 'listadoareas':
                //llamo al metodo de la clase aulajuan que lista las aulas
                $respuesta = $area->listadoareas();
                usleep(5);
                echo json_encode($respuesta);
                return 0;
            break;
            case 'listadoareas_app':
                //llamo al metodo de la clase aulajuan que lista las aulas
                $respuesta = $area->listadoareas_app();
                usleep(5);
                echo json_encode($respuesta);
                return 0;
            break;
            case 'listadoemprendimientos':
                $respuesta = $emprendimiento->listadoemprendimientos($_POST['area']);
                usleep(5);
                echo json_encode($respuesta);
                return 0;
            break;
            case 'listadoemprendimientos_app':
                $respuesta = $emprendimiento->listadoemprendimientos_app($_POST['area']);
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
            case 'listadoaulas_app':
                $respuesta = $aula->listarAulas_app($_POST['area'], $_POST['emprendimiento']);
                usleep(5);
                echo json_encode($respuesta);
                return 0;
            break;
            case 'codificarURL_AE':
                echo configSistema::_M10_();
            break;
            case 'codificarURL_E':
                echo configSistema::_M11_();
            break;
            case 'codificarURL_A':
                echo configSistema::_M03_();
            break;
            case 'codificarURL_AU':
                echo configSistema::_MAULAS_($_POST['aula']);
            break;
            case 'codificarURL_AUE':
                echo configSistema::_MUNIDAD_($_POST['unidadeva']);
            break;
        }
        return 0;
    }
    require_once "vista/" . $pagina . "Vista.php";
} else {
    echo "pagina en construccion";
}