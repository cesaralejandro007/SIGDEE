<?php
    use modelo\CensoModelo as censo;
    $censo = new censo();
if (!is_file("bin/modelo/AreaEmprendimientoModelo.php")) {
    echo "Falta definir la clase " . $pagina;
    exit;
}
if (is_file("vista/" . $pagina . "Vista.php")) {

    require_once "bin/modelo/EmprendimientoModelo.php";
    $confirma_fecha = $censo->consultar_fecha(date('Y-m-d h:i:s', time()));
    if (isset($_POST['accion'])) {
        $accion = $_POST['accion'];
        if ($accion == 'visualizar-censo') {
            $datos = $censo->cargar(date('Y-m-d h:i:s', time()));
            foreach ($datos as $valor) {
                echo json_encode([
                    'id' => $valor['id'],
                    'fecha_apertura' => $valor['fecha_apertura'],
                    'fecha_cierre' => $valor['fecha_cierre'],
                    'descripcion' => $valor['descripcion'],
                ]);
            }
            return 0;
        }
        
    }
    require_once "vista/" . $pagina . "Vista.php";
} else {
    echo "pagina en construccion";
}