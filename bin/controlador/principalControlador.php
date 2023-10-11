<?php 
use component\initComponents as initComponents;
use component\header as header;
use modelo\Permisos as permiso;
use modelo\EmprendimientoModelo as Emprendimiento;
use modelo\configNotificacionModelo as Mensaje;
use config\componentes\configSistema as configSistema;

$config = new configSistema();
session_start();
if (!isset($_SESSION['usuario'])) {
	$redirectUrl = '?pagina=' . configSistema::_LOGIN_();
    echo '<script>window.location="' . $redirectUrl . '"</script>';
    die();
}
    $components = new initComponents();
    $header = new header();
    $emprendimiento = new Emprendimiento();

  if (is_file($config->_Dir_Vista_().$pagina.$config->_VISTA_())) {

    if(count(array_filter($_SESSION['usuario'])) == 0) {
        $redirectUrl = '?pagina=' . configSistema::_LOGIN_();
        echo '<script>window.location="' . $redirectUrl . '"</script>';
        die();
    }

    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
        switch($accion){
            case 'reporte_estudiante_emprendimiento':
                $resultados =  $emprendimiento->reporteEstudiantesPorEmprendimiento();
                echo json_encode([
                    'resultado' => $resultados['total'],
                    'estudiantes' => $resultados['estudiantes'],
                    'datos' => $resultados['emprendimientos']
                ]);
                return 0;
            break;

        }
    }
    require_once "vista/" . $pagina . "Vista.php";
} else {
    echo "pagina en construccion";
}

 ?>