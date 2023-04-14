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
    header('location:?pagina=Login');
}

$aula = new Aula();
$area = new AreaEmprendimiento();
$emprendimiento = new Emprendimiento();
$modulo = new Modulo();
$unidad = new Unidad();
$evaluacion = new Evaluacion();
$estudiante_evaluacion = new EstudianteEvaluacion();
if (is_file($config->_Dir_Vista_().$pagina.$config->_VISTA_())) {
    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
        switch($accion){
            case 'aprobados_reprobados':
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
            break;
            case 'listadoareas':
                //llamo al metodo de la clase aulajuan que lista las aulas
                $respuesta = $area->listadoareas();
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
            case 'listadoaulas':
                $respuesta = $aula->listarAulas($_POST['area'], $_POST['emprendimiento']);
                usleep(5);
                echo json_encode($respuesta);
                return 0;
            break;
            case 'listadounidades':
                $respuesta = $unidad->listarUnidades($_POST['aula']);
                usleep(5);
                echo json_encode($respuesta);
                return 0;
            break;
            case 'listadoevaluaciones':
                $respuesta = $evaluacion->listarEvaluaciones($_POST['unidad']);
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