<?php
require 'serverside.php';
$table_data->get('vista_usuario', 'id', array('id','cedula', 'primer_nombre','segundo_nombre','primer_apellido','segundo_apellido','genero','correo','direccion','telefono'));
?>	