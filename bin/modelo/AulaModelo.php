<?php
namespace modelo;
use config\connect\connectDB as connectDB;
class AulaModelo extends connectDB
{
    private $id;
    private $nombre;
    private $id_emprendimiento_modulo;
    private $status;

   
    public function incluir($nombre, $id_emprendimiento_modulo)
    {

        $validar_nombre = $this->validar_registro($nombre);
        $expresiones_regulares = $this->validar_expresiones($nombre);

        if ($validar_nombre) {
            $respuesta['resultado'] = 0;
            $respuesta['mensaje'] = "El nombre ya existe";
        }   
        else if ($expresiones_regulares['resultado']) {
            $respuesta['resultado'] = 0;
            $respuesta['mensaje'] = $expresiones_regulares['mensaje'];
        }   
         else {
            try {
                $this->conex->query("INSERT INTO aula(nombre, id_emprendimiento_modulo, estatus)
                    VALUES('$nombre', '$id_emprendimiento_modulo', 'true')");
                $respuesta['resultado'] = 1;
                $respuesta['mensaje'] = "Registro exitoso";
            } catch (Exception $e) {
                $respuesta['resultado'] = 0;
                $respuesta['mensaje'] = $e->getMessage();
            }
        }
        return $respuesta;
    }
    public function buscar($nombre)
    {
        $resultado = $this->conex->prepare("SELECT count(nombre) as cantidad FROM aula WHERE nombre LIKE '%" . $nombre . "%'");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }
    public function encontrar($id)
    {
        $resultado = $this->conex->prepare("SELECT * FROM aula WHERE id= '$id'");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function modificar($nombre, $id)
    {
        $validar_aula = $this->existe($id);   
        $validar_modificar = $this->validar_modificar($nombre, $id);
        $expresiones_regulares = $this->validar_expresiones($nombre);

        if (!$validar_aula) {
            $respuesta['resultado'] = 0;
            $respuesta['mensaje'] = "No existe el aula";
        }   
        else
        if ($validar_modificar) {
            $respuesta['resultado'] = 0;
            $respuesta['mensaje'] = "Ya existe el mismo nombre para otra aula";
        }
        else if ($expresiones_regulares['resultado']) {
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = $expresiones_regulares['mensaje'];
        }   else {
            try {
                $this->conex->query("UPDATE aula SET nombre = '$nombre' WHERE id = '$id'");
               $respuesta['resultado'] = 1;
                $respuesta['mensaje'] = "Modificacion existosa";
            } catch (Exception $e) {
                $respuesta['resultado'] = 0;
                $respuesta['mensaje'] = $e->getMessage();
            }
        }
        return $respuesta;
    }

    public function eliminar($id)
    {
        if($this->existe($id)) {
                $resultado = $this->conex->prepare("DELETE from aula
					WHERE
					id = '$id'
					");
            try {
                $resultado->execute();
                $fila = $resultado->rowCount();
                if ($fila > 0) {
                    $respuesta['resultado'] = 1;
                    $respuesta['mensaje'] = "Registro exitoso";
                } else {
                    $respuesta['resultado'] = 2;
                    $respuesta['mensaje'] = "El Aula no puede ser borrardo, existen vinculos con Emprendimiento Modulo.";
                }
            } catch (Exception $e) {
                return $e->getMessage();
            }
        } 
        return $respuesta;
    }

    public function listar_aulas()
    {
        $resultado = $this->conex->prepare("SELECT id, nombre FROM aula");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function listar()
    {
        $resultado = $this->conex->prepare("SELECT a.id as id, ae.nombre as area, e.nombre as emprendimiento, a.nombre as aula, u.nombre as docente FROM area_emprendimiento as ae INNER JOIN emprendimiento e ON ae.id=e.id_area INNER JOIN emprendimiento_modulo as em ON em.id_emprendimiento=e.id INNER JOIN aula as a ON a.id_emprendimiento_modulo= em.id INNER JOIN aula_docente as ad ON a.id= ad.id_aula INNER JOIN usuario u ON u.id=ad.id_docente WHERE a.estatus='true'");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }
    public function cargar($id)
    {
        $resultado = $this->conex->prepare("SELECT a.id as id, a.nombre as aula, d.id as id_docente, d.cedula as cedula, d.nombre as nombre, d.apellido as apellido FROM aula as a INNER JOIN aula_docente as ad ON a.id=ad.id_aula INNER JOIN usuario as d ON d.id= ad.id_docente WHERE a.id ='$id'
			");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function mostrar()
    {
        try {
            $resul = $this->conex->query("SELECT * FROM aula");
            if ($resul) {
                $res = "<option value='0'>--Seleccione--</option>";
                foreach ($resul as $r) {
                    $res = $res . "<option value='" . $r['id'] . "'>";
                    $res = $res . $r['nombre'];
                    $res = $res . "</option>";
                }
                return $res;
            } else {
                return '';
            }

        } catch (Exception $e) {
            return $e->getMessage();
        }

    }

    public function validar_registro($nombre)
    {
        try {
            $resultado = $this->conex->prepare("SELECT * FROM aula WHERE nombre='$nombre'");
            $resultado->execute();
            $fila = $resultado->fetchAll();
            if ($fila) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }

    public function validar_modificar($nombre, $id)
    {
        try {
            $resultado = $this->conex->prepare("SELECT * FROM aula WHERE nombre='$nombre' AND id<>'$id'");
            $resultado->execute();
            $fila = $resultado->fetchAll();
            if ($fila) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }

    public function buscar_ultimo()
    {
        $resultado = $this->conex->prepare("SELECT id FROM aula ORDER BY id desc LIMIT 1");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function existe($id)
    {
        try {
            $resultado = $this->conex->prepare("SELECT * FROM aula WHERE id='$id'");
            $resultado->execute();
            $fila = $resultado->fetchAll();
            if ($fila) {
                return true;
            } else {
                return false;
            }

        } catch (Exception $e) {
            return false;
        }
    }

    public function listadoaulas()
    {
        $response = $this->mostrarpermisos($_SESSION["usuario"]["id"],$_SESSION["usuario"]["tipo_usuario"],"Aula");
        $r = array();
        try {

            $resultado = $this->conex->prepare("select
			a.id as id_area,
			a.nombre as nombre_area,
			b.id as id_emprendimiento,
			b.nombre as nombre_empredimiento,
			c.id as id_aula,
			c.nombre as nombre_aula,
			e.id as id_modulo,
			e.nombre as nombre_modulo,
			f.id as id_docente,
			concat(f.cedula, ' / ', f.apellido, ' ', f.nombre) as docente
			FROM
			area_emprendimiento as a,
			emprendimiento as b,
			aula as c,
			emprendimiento_modulo as d,
			modulo as e,
			usuario as f,
			aula_docente as g
			WHERE
			c.id_emprendimiento_modulo = d.id
			AND
			d.id_emprendimiento = b.id
			AND
			b.id_area = a.id
			AND
			d.id_modulo = e.id
			AND
			g.id_aula = c.id
			AND g.id_docente = f.id;");

            $resultado->execute();

            $x = '';
            if ($resultado) {

                foreach ($resultado as $f) {
                    $x = $x . '<tr>';

                    $x = $x . '<td class="project-actions text-left d-none">';
                    $x = $x . $f[0] . '</td>';
                    $x = $x . '<td class="project-actions text-left">';
                    $x = $x . $f[1] . '</td>';

                    $x = $x . '<td class="project-actions text-left d-none">';
                    $x = $x . $f[2] . '</td>';
                    $x = $x . '<td class="project-actions text-left">';
                    $x = $x . $f[3] . '</td>';

                    $x = $x . '<td class="project-actions text-left d-none">';
                    $x = $x . $f[6] . '</td>';
                    $x = $x . '<td class="project-actions text-left">';
                    $x = $x . $f[7] . '</td>';

                    $x = $x . '<td class="project-actions text-left d-none">';
                    $x = $x . $f[4] . '</td>';
                    $x = $x . '<td class="project-actions text-left">';
                    $x = $x . $f[5] . '</td>';

                    $x = $x . '<td class="project-actions text-left d-none">';
                    $x = $x . $f[8] . '</td>';
                    $x = $x . '<td class="project-actions text-left">';
                    $x = $x . $f[9] . '</td>';

                    $x = $x . '<td class="project-actions text-left">';
                    $x = $x . '<div class="d-flex">';
                    for ($i = 0; $i < count($response); $i++) {
                        if (isset($response[$i]["modificar"])) {
                            if ($response[$i]["modificar"] == 'true') {
                                $x = $x . '<button class="btn btn-sm" onclick="edita_aula(' . $f[4] . ');">';
                                $x = $x . '<i class="fas fa-edit"></i>Editar';
                                $x = $x . '</button>';
                                break;}}}
                    for ($i = 0; $i < count($response); $i++) {
                        if (isset($response[$i]["eliminar"])) {
                            if ($response[$i]["eliminar"] == 'true') {
                                $x = $x . '<button class="btn btn-sm" type="button" onclick="elimina_aula(' . $f[4] . ');">';
                                $x = $x . '<i class="fas fa-trash"></i>Eliminar';
                                $x = $x . '</button>';
                                break;}}}
                    $x = $x . '</div>';
                    $x = $x . '</td>';

                    $x = $x . '</tr>';

                }

            }

            $r['resultado'] = 'listadoaulas';
            $r['mensaje'] = $x;

        } catch (Exception $e) {
            $r['resultado'] = 'error';
            $r['mensaje'] = $e->getMessage();

        }
        return $r;
    }

    public function mostrar_aulas()
    {
        
        $resultado = $this->conex->prepare("select
            a.id as id_area,
            a.nombre as nombre_area,
            b.id as id_emprendimiento,
            b.nombre as nombre_empredimiento,
            c.id as id_aula,
            c.nombre as nombre_aula,
            e.id as id_modulo,
            e.nombre as nombre_modulo,
            f.id as id_docente,
            concat(f.cedula, ' / ', f.apellido, ' ', f.nombre) as docente
            FROM
            area_emprendimiento as a,
            emprendimiento as b,
            aula as c,
            emprendimiento_modulo as d,
            modulo as e,
            usuario as f,
            aula_docente as g
            WHERE
            c.id_emprendimiento_modulo = d.id
            AND
            d.id_emprendimiento = b.id
            AND
            b.id_area = a.id
            AND
            d.id_modulo = e.id
            AND
            g.id_aula = c.id
            AND g.id_docente = f.id;");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function mostrarpermisos($idusuario,$tipo_usuario,$modulo)
    {
        $resultado = $this->conex->prepare("SELECT e.nombre as nombreentorno ,p.registrar as registrar,p.consultar as consultar, p.modificar as modificar, p.eliminar as eliminar FROM usuario u, usuarios_roles ur, rol r,permiso p, entorno_sistema e WHERE u.id = ur.id_usuario and r.id = ur.id_rol and r.id = p.id_rol and e.id= p.id_entorno and u.id='$idusuario' and e.nombre='$modulo' and r.nombre='$tipo_usuario'");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }


    public function listarAulas($id_area_emprendimiento, $id_emprendimiento)
    {
        $r = array();
        try {

            $resultado = $this->conex->prepare("SELECT a.id as id, a.nombre as nombre FROM area_emprendimiento ae INNER JOIN emprendimiento e ON ae.id=e.id_area INNER JOIN emprendimiento_modulo em ON em.id_emprendimiento=e.id INNER JOIN aula a ON a.id_emprendimiento_modulo=em.id WHERE ae.id='$id_area_emprendimiento' AND e.id='$id_emprendimiento'");

            $resultado->execute();

            $x = '<option disabled selected>Seleccione</option>';
            if ($resultado) {

                foreach ($resultado as $f) {
                    $x = $x . '<option value="' . $f[0] . '">' . $f[1] . '</option>';
                }

            }

            $r['resultado'] = 'listadoaulas';
            $r['mensaje'] = $x;

        } catch (Exception $e) {
            $r['resultado'] = 'error';
            $r['mensaje'] = $e->getMessage();

        }
        return $r;
    }

    public function actualizarstatus($id,$status)
    {
        try {
            $this->conex->query("UPDATE aula SET estatus = '$status' WHERE id = '$id'");
            if($status =="true"){
                $respuesta['resultado'] = 1;
                $respuesta['mensaje'] = "Registro exitoso";
            }else{
                $respuesta['resultado'] = 2;
                $respuesta['mensaje'] = "Eliminación exitoso";
            }

        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuesta;
    }

    public function chequearaulas()
    {
        $resultado = $this->conex->prepare("SELECT id,estatus FROM aula");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function reporteAprobadosReprobados($id_aula){
        $total_estudiantes = 0;
        $aprobados = 0;
        $ejemplo = [];
        //Consulta de todos lo estudiantes que cursan el aula seleccionado
        $query_estudiantes = $this->conex->prepare("SELECT ae.id_estudiante as id_estudiante FROM aula a INNER JOIN aula_estudiante ae ON a.id= ae.id_aula WHERE a.id='$id_aula'");
        $query_estudiantes->execute();
        if($query_estudiantes){
            foreach($query_estudiantes as $estudiante){
                $nota_final = 0;
                //Consulta para obtener el total de unidades que posee el aula
                $query_unidades = $this->conex->prepare("SELECT u.id as id, u.nombre as nombre FROM aula a INNER JOIN unidad u ON a.id= u.id_aula WHERE a.id='$id_aula';");
                $query_unidades->execute();
                if($query_unidades){
                    $total_unidades = 0;
                    $calificacion_unidad= 0;
                    foreach($query_unidades as $unidad){
                        $final_evaluacion = 0;
                        //Consulta de las evaluaciones que posee la unidad
                        $query_evaluaciones = $this->conex->prepare("SELECT ue.id as id, ue.id_unidad, ue.id_evaluacion FROM unidad u INNER JOIN unidad_evaluaciones ue ON u.id=ue.id_unidad WHERE u.id='".$unidad['id']."'");
                        $query_evaluaciones->execute();
                        if ($query_evaluaciones) {
                            $calificacion_evaluacion = 0;
                            $total_evaluacion = 0;
                            foreach($query_evaluaciones as $evaluacion){
                                //Consulta para obtener la calificacion de la evaluacion de un estudiante en especifico
                                $query_calificacion = $this->conex->prepare("SELECT ee.calificacion as calificacion FROM estudiante_evaluacion ee INNER JOIN unidad_evaluaciones ue ON ee.id_unidad_evaluacion=ue.id WHERE ue.id='".$evaluacion['id']."' AND ee.id_usuario='".$estudiante['id_estudiante']."';");
                                $query_calificacion->execute();
                                if ($query_calificacion) {
                                    foreach($query_calificacion as $calificacion){
                                        $nota = $calificacion['calificacion'] != NULL ? $calificacion['calificacion'] : 0;
                                        $calificacion_evaluacion= $nota+$calificacion_evaluacion;
                                    }
                                }
                                $total_evaluacion++;
                            }
                            $final_evaluacion =  $calificacion_evaluacion / $total_evaluacion;
                        }
                        $calificacion_unidad = $final_evaluacion + $calificacion_unidad;
                        $total_unidades++;
                    }
                    $nota_final = $calificacion_unidad/$total_unidades;

                    
                }
                $aprobados = $nota_final >9.49 ? +1 : +0;
                $total_estudiantes++;
            }
            $reprobados = $total_estudiantes-$aprobados;
            //$r['aprobados']= $ejemplo;
            if($total_estudiantes!=0){
            $r['aprobados']= ($aprobados/$total_estudiantes)* 100;
            $r['reprobados']= ($reprobados/$total_estudiantes)* 100;
        }else{
            $r['resultado'] = 1;
            $r['mensaje'] = "No existen registros";
        }
        }
        return $r;
    } 

    public function validar_expresiones($nombre){
        $er_nombre = '/^[A-ZÁÉÍÓÚa-zñáéíóú0-9,.#%$^&*:\s]{3,40}$/';
        if(!preg_match_all($er_nombre,$nombre) || trim($nombre)==''){
            $respuesta["resultado"]=true;
            $respuesta["mensaje"]="El campo Nombre de contener solo letras de 3 a 40 caracteres, siendo la primera en mayúscula.";
        }else{
            $respuesta["resultado"]=false;
            $respuesta["mensaje"]="";
        }
        return $respuesta;
    }

}