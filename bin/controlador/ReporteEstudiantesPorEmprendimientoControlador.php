<?php
use modelo\EmprendimientoModelo as Emprendimiento;
use modelo\AulaModelo as Aula;
use modelo\AreaEmprendimientoModelo as AreaEmprendimiento;
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
$unidad = new Unidad();
$evaluacion = new Evaluacion();
$emprendimiento = new Emprendimiento();
$area = new AreaEmprendimiento();
if (is_file($config->_Dir_Vista_().$pagina.$config->_VISTA_())) {
    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
        switch($accion){
            case 'reporte_estudiante_emprendimiento':
                $resultados =  $emprendimiento->reporteEstudianteEmprendimiento($_POST['area']);
                echo json_encode([
                    'resultado' => $resultados['total'],
                    'estudiantes' => $resultados['estudiantes'],
                    'datos' => $resultados['emprendimientos']
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
        }
    }
    require_once "vista/" . $pagina . "Vista.php";
} else {
    echo "pagina en construccion";
}