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
    die("<script>window.location='?url=principal'</script>");
}


  $components = new initComponents();
  $header = new header();
  $emprendimiento = new Emprendimiento();

  if (is_file($config->_Dir_Vista_().$pagina.$config->_VISTA_())) {
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