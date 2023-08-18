<?php
namespace modelo;
use config\connect\connectDB as connectDB;
class AreaEmprendimientoModelo extends connectDB
{
    private $id;
    private $nombre;

    public function incluir($nombre)
    {
        $validar_nombre = $this->validar_registro($nombre);
        $expresiones_regulares = $this->validar_expresiones($nombre);
        if ($validar_nombre) {
            $respuesta['resultado'] = 3;
            $respuesta['mensaje'] = "Nombre ya existe";
        }
        else if ($expresiones_regulares['resultado']) {
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = $expresiones_regulares['mensaje'];
        }       
         else {
            try {
                $this->conex->query("INSERT INTO area_emprendimiento(nombre) VALUES('$nombre')");
                $respuesta['resultado'] = 1;
                $respuesta['mensaje'] = "Registro exitoso";
            } catch (Exception $e) {
                $respuesta['resultado'] = 0;
                $respuesta['mensaje'] = $e->getMessage();
            }
        }
        return $respuesta;
    }

    public function modificar($id, $nombre)
    {
        $validar_modificar = $this->validar_modificar($nombre, $id);
        $expresiones_regulares = $this->validar_expresiones($nombre);
        if ($this->existe($id)==false) {
            $respuesta['resultado'] = 4;
            $respuesta['mensaje'] = "El Area de Emprendimiento no Existe";
        }else if($validar_modificar) {
            $respuesta['resultado'] = 3;
            $respuesta['mensaje'] = "Nombre ya existe";
        } 
        else if ($expresiones_regulares['resultado']) {
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = $expresiones_regulares['mensaje'];
        } 
        else {
            try {
                $this->conex->query("UPDATE area_emprendimiento SET nombre = '$nombre' WHERE id = '$id'");
                $respuesta['resultado'] = 1;
                $respuesta['mensaje'] = "Modificación exitosa";
            } catch (Exception $e) {
                $respuesta['resultado'] = 0;
                $respuesta['mensaje'] = $e->getMessage();
            }
        }
        return $respuesta;
    }


    public function eliminar($id)
    {
        $validar_tipo = $this->relacion_tipo($id);

        if ($this->existe($id)==false) {
            $respuesta['resultado'] = 3;
            $respuesta['mensaje'] = "El Area de Emprendimiento no Existe";
            return $respuesta;
        }else{
            if ($validar_tipo) {
                $respuesta['resultado'] = 2;
                $respuesta['mensaje'] = "No puede ser borrardo, existe un vinculo en Emprendimiento";
            } else{
                try {
                    $this->conex->query("DELETE from area_emprendimiento
                        WHERE
                        id = '$id'
                        ");
                    $respuesta['resultado'] = 1;
                    $respuesta['mensaje'] = "Eliminacion exitosa";
                } catch (Exception $e) {
                    $respuesta['resultado'] = 0;
                    $respuesta['mensaje'] = $e->getMessage();
                }
            } 
            return $respuesta;
        }
    }

    public function listar()
    {
        $resultado = $this->conex->prepare("SELECT id, nombre FROM area_emprendimiento");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function buscar($id)
    {
        $resultado = $this->conex->prepare("SELECT id, nombre FROM area_emprendimiento WHERE
			id = '$id'
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
            $resul = $this->conex->query("SELECT * FROM area_emprendimiento");
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
            $resultado = $this->conex->prepare("SELECT * FROM area_emprendimiento WHERE nombre='$nombre'");
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
            $resultado = $this->conex->prepare("SELECT * FROM area_emprendimiento WHERE nombre='$nombre' AND id<>'$id'");
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

    public function relacion_tipo($id)
    {
        try {

            $resultado = $this->conex->prepare("SELECT a.id as area FROM area_emprendimiento a
				INNER JOIN emprendimiento t ON a.id=t.id_area WHERE a.id='" . $id . "'");
            $resultado->execute();
            $fila = $resultado->fetchAll();
            if ($fila) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return 'false';
        }
    }

    public function existe($id)
    {
        try {
            $resultado = $this->conex->prepare("SELECT * FROM area_emprendimiento WHERE id='$id'");
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

    public function validar_expresiones($nombre){
        $er_nombre = '/^[A-ZÁÉÍÓÚa-zñáéíóú,.#%$^&*:\s]{3,30}$/';
        if(!preg_match_all($er_nombre,$nombre) || trim($nombre)==''){
            $respuesta["resultado"]=true;
            $respuesta["mensaje"]="El campo Nombre de contener solo letras de 3 a 30 caracteres, siendo la primera en mayúscula.";
        }else{
            $respuesta["resultado"]=false;
            $respuesta["mensaje"]="";
        }
        return $respuesta;
    }
    public function listadoareas()
    {
        $r = array();
        try {
            $resultado = $this->conex->prepare("SELECT area_emprendimiento.id, area_emprendimiento.nombre FROM area_emprendimiento");
            $resultado->execute();
            $x = '<option disabled selected>Seleccione</option>';
            if ($resultado) {
                foreach ($resultado as $f) {
                    $x = $x . '<option value="' . $f[0] . '">' . $f[1] . '</option>';
                }
            }
            $r['resultado'] = 'listadoareas';
            $r['mensaje'] = $x;
        } catch (Exception $e) {
            $r['resultado'] = 'error';
            $r['mensaje'] = $e->getMessage();

        }
        return $r;
    }
    public function reporteUbicacionArea($pais, $estado, $ciudad, $id_area){
        $total_estudiantes = 0;
        $aprobados = 0;
        $ejemplo = [];
        $cantidad_estudiantes = 0;
        if($ciudad != null){
        $query_ciudades = $this->conex->prepare("SELECT id, nombre FROM ciudades;");
        $query_ciudades->execute();
            if($query_ciudades)
            {
                foreach($query_ciudades as $ciudades)
                {
                    $query_estudiantes_ciudades = $this->conex->prepare("SELECT u.id as id_estudiante FROM usuario u INNER JOIN aula_estudiante ae ON u.id=ae.id_estudiante INNER JOIN aula a ON a.id= ae.id_aula INNER JOIN emprendimiento_modulo em ON a.id_emprendimiento_modulo=em.id INNER JOIN emprendimiento e ON e.id=em.id_emprendimiento INNER JOIN area_emprendimiento aem ON aem.id=e.id_area INNER JOIN ciudades c ON c.id=u.id_ciudad WHERE aem.id='$id_area' AND c.id='$ciudad' GROUP BY u.id;");
                    $query_ciudades->execute();
                    $cantidad = $query_ciudades->num_rows;
                }
            }
        }




        //Consulta de todos lo estudiantes que cursan el area de emprendimiento seleccionado
        $query_estudiantes = $this->conex->prepare("SELECT ae.id_estudiante as id_estudiante FROM usuario u INNER JOIN aula_estudiante ae ON u.id=ae.id_estudiante INNER JOIN aula a ON a.id= ae.id_aula INNER JOIN emprendimiento_modulo em ON a.id_emprendimiento_modulo=em.id INNER JOIN emprendimiento e ON e.id=em.id_emprendimiento INNER JOIN area_emprendimiento aem ON aem.id=e.id_area WHERE aem.id='$id_area' GROUP BY u.id;");
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
}