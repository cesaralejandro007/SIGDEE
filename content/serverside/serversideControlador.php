<?php
require 'connectServerside/serverside.php';

switch ($_GET['Dato']) {
    case 'Usuario':
        $table_data->get('vista_usuario', 'id', array('id','cedula', 'primer_nombre','segundo_nombre','primer_apellido','segundo_apellido','genero','correo','direccion','telefono'));
        break;
    
    case 'Area_emprendimiento':
        $table_data->get('vista_area_emprendimiento', 'id', array('id','nombre'));
        break;
}
?>	
