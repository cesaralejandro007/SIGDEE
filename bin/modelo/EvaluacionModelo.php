<?php
namespace modelo;
use config\connect\connectDB as connectDB;
class EvaluacionModelo extends connectDB
{
    private $id;
    private $nombre;
    private $descripcion;
    private $archivo_adjunto;

    public function incluir($nombre,$descripcion,$archivo_adjunto)
    {
        $validar_registro = $this->validar_registro($nombre);
        $expresiones_regulares = $this->validar_expresiones($nombre,$descripcion);
        if ($validar_registro) {
            $respuesta['resultado'] = 3;
            $respuesta['mensaje'] = "Nombre ya existe";
        }else if ($expresiones_regulares['resultado']) {
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = $expresiones_regulares['mensaje'];
        } else {
            try {
                $this->conex->query("INSERT INTO evaluaciones(nombre, descripcion, archivo_adjunto)
                    VALUES('$nombre','$descripcion', '$archivo_adjunto')");
                 $respuesta['resultado'] = 1;
                 $respuesta['mensaje'] = "Registro exitoso";
            } catch (Exception $e) {
                $respuesta['resultado'] = 0;
                $respuesta['mensaje'] = $e->getMessage();
            }
        }
        return $respuesta;
    }

    public function modificar($id,$nombre,$descripcion){
        $validar_modificar = $this->validar_modificar($nombre, $id);
        $expresiones_regulares = $this->validar_expresiones($nombre,$descripcion);
        $validar_expresionID = $this->validar_expresion_id($id);
        if ($validar_expresionID['resultado']) {
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = $validar_expresionID['mensaje'];
        }else if ($this->existe($id)==false) {
            $respuesta['resultado'] = 3;
            $respuesta['mensaje'] = "La Evaluacion no Existe";
            return $respuesta;
        } else if ($validar_modificar) {
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = "Nombre ya existe";
        }else if ($expresiones_regulares['resultado']) {
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = $expresiones_regulares['mensaje'];
        }else{
            try {
                $this->conex->query("UPDATE evaluaciones SET nombre= '$nombre', descripcion= '$descripcion' WHERE id = '$id'");
                $respuesta['resultado'] = 1;
                $respuesta['mensaje'] = "Modificación exitoso";
            } catch(Exception $e) {
                $respuesta['resultado'] = 0;
                $respuesta['mensaje'] = $e->getMessage();
            }
        }
        return $respuesta;
    }
    
    public function cambiar_archivo($id,$archivo_adjunto){
        try {
            $this->conex->query("UPDATE evaluaciones SET archivo_adjunto= '$archivo_adjunto' WHERE id = '$id'");
            return true;
        } catch(Exception $e) {
            return $e->getMessage();
        }
        
    }

    public function validar_modificar($nombre, $id){
        try{
            $resultado = $this->conex->prepare("SELECT * FROM evaluaciones WHERE nombre='$nombre' AND id<>'$id'");
            $resultado->execute();
            $fila = $resultado->fetchAll();
            if($fila){
                return true;
            }
            else{
                return false;;
            }
        }catch(Exception $e){
            return false;
        }
    }

    public function eliminar($id)
    {
        $validar_evaluacion = $this->relacion_evaluacion($id);
        $validar_expresionID = $this->validar_expresion_id($id);
        if ($validar_expresionID['resultado']) {
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = $validar_expresionID['mensaje'];
        }else if ($this->existe($id)==false) {
            $respuesta['resultado'] = 3;
            $respuesta['mensaje'] = "La Evaluacion no Existe";
            return $respuesta;
        }else{
            if($validar_evaluacion){
                $respuesta['resultado'] = 2;
                $respuesta['mensaje'] = "La evaluación no puede ser borrardo, existe un vinculo con Unidad Evaluación.";
            }else{
                try {
                    $this->conex->query("DELETE from evaluaciones
                    WHERE
                    id = '$id'
                    ");
                    $respuesta['resultado'] = 1;
                    $respuesta['mensaje'] = "Eliminación exitoso";
                } catch (Exception $e) {
                    $respuesta['resultado'] = 0;
                    $respuesta['mensaje'] = $e->getMessage();
                }
            }
        }
        return $respuesta;
    }

    public function elmininarEvaluacion_unidad($id)
    {
        $validar_evaluacion_a_eliminar = $this->relacion_evaluacion_calificacion($id);
        if($validar_evaluacion_a_eliminar){
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = "La evaluación no puede ser borrardo, existe un vinculo con calificación del estudiante.";
        }else{
        try {
                $this->conex->query("DELETE from unidad_evaluaciones
                WHERE
                id = '$id'
                ");
                $respuesta['resultado'] = 1;
                $respuesta['mensaje'] = "Eliminación exitoso";
            } catch (Exception $e) {
                $respuesta['resultado'] = 0;
                $respuesta['mensaje'] = $e->getMessage();
            }
        }
        return $respuesta;
    }


    public function listar()
    {
        $resultado = $this->conex->prepare("SELECT * FROM evaluaciones");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }


    public function mostrar($id_unidad)
    {
        try {
            $resul = $this->conex->query("SELECT id, nombre as evaluacion FROM evaluaciones");
            if ($resul) {

                $res = "";
                foreach ($resul as $r) {
                    $activo = '';
                    $sql = $this->conex->query("SELECT  e.id as id, e.nombre as nombre FROM evaluaciones as e INNER JOIN unidad_evaluaciones as ue ON e.id=ue.id_evaluacion WHERE ue.id_unidad= $id_unidad AND e.id=".$r['id']."");
                    if ($sql->fetchAll()) {
                        $activo = 'selected';
                    }
                    $res = $res . "<option class='val' value='".$r['id'] ."' ".$activo." >";
                    $res = $res . $r['evaluacion'];
                    $res = $res . "</option>";
                }
                return $res;
            } else {return '';}
        } catch (Exception $e) {return $e->getMessage();}
    }
    public function validar_registro($nombre)
    {
        try {
            $resultado = $this->conex->prepare("SELECT * FROM evaluaciones WHERE nombre='$nombre'");
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

    public function existe($id)
    {
        try {
            $resultado = $this->conex->prepare("SELECT * FROM evaluaciones WHERE id='$id'");
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

    public function relacion_evaluacion($id)
    {
        try {
            $resultado = $this->conex->prepare("SELECT * FROM unidad_evaluaciones,evaluaciones WHERE evaluaciones.id = unidad_evaluaciones.id_evaluacion and evaluaciones.id='$id'");
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

    public function relacion_evaluacion_calificacion($id)
    {
        try {
            $resultado = $this->conex->prepare("SELECT * FROM estudiante_evaluacion WHERE id_unidad_evaluacion='$id'");
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

    public function listar_unidad_aula($id)
    {
        $resultado = $this->conex->prepare("SELECT u.nombre as unidad, u.id as id, u.descripcion From unidad as u WHERE
            u.id_aula='$id'
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

    public function cargar($id){
        $resultado = $this->conex->prepare("SELECT * FROM evaluaciones WHERE
            id = '$id'
            ");
        $respuestaArreglo = [];
        try{
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        }catch(Exception $e){
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function cargarEvaluacion($id){
        $resultado = $this->conex->prepare("SELECT * FROM unidad_evaluaciones,evaluaciones WHERE evaluaciones.id = unidad_evaluaciones.id_evaluacion AND
            unidad_evaluaciones.id = '$id'
            ");
        $respuestaArreglo = [];
        try{
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        }catch(Exception $e){
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function mostrar_evaluaciones(){
        $resultado = $this->conex->prepare("SELECT id, nombre FROM evaluaciones");
        $x = [];
        try{
            $resultado->execute();
            $x = '';
            if ($resultado) {
                foreach ($resultado as $f) {
                    $x = $x . '<tr>';
                    $x = $x . '<td class="project-actions text-left" id="evaluacioness" onclick="seleccion_evaluacion('.$f['id'].')">';
                    $x = $x . $f['nombre'] . '</td>';
                    $x = $x . '</tr>';

                }

            }
        }catch(Exception $e){
            return $e->getMessage();
        }
        return $x;
    }

    public function listarEvaluaciones($id_unidad)
    {
        $r = array();
        try {

            $resultado = $this->conex->prepare("SELECT e.id as id, e.nombre as nombre FROM aula a INNER JOIN unidad u ON a.id= u.id_aula INNER JOIN unidad_evaluaciones ue ON ue.id_unidad=u.id INNER JOIN evaluaciones e ON e.id=ue.id_evaluacion WHERE u.id='$id_unidad'");
            $resultado->execute();

            $x = '<option disabled selected>Seleccione</option>';
            if ($resultado) {

                foreach ($resultado as $f) {
                    $x = $x . '<option value="' . $f[0] . '">' . $f[1] . '</option>';
                }

            }

            $r['resultado'] = 'listadoevaluaciones';
            $r['mensaje'] = $x;

        } catch (Exception $e) {
            $r['resultado'] = 'error';
            $r['mensaje'] = $e->getMessage();

        }
        return $r;
    }

    public function validar_expresion_id($id){
        if(!preg_match('/^[0-9]+$/', $id)){
            $respuesta["resultado"]=true;
            $respuesta["mensaje"]="El campo ID solo debe contener números";
        }else{
            $respuesta["resultado"]=false;
            $respuesta["mensaje"]="";
        }
        return $respuesta;
    }

    public function validar_expresiones($nombre,$descripcion){
        $er_nombre = '/^[A-ZÁÉÍÓÚa-zñáéíóú,.#%$^&*:\s]{3,30}$/';
        $er_descripcion = '/^[A-ZÁÉÍÓÚa-zñáéíóú,.#%$^&*:\s]{3,200}$/';
        if(!preg_match_all($er_nombre,$nombre) || trim($nombre)==''){
            $respuesta["resultado"]=true;
            $respuesta["mensaje"]="El campo Nombre de contener solo letras de 3 a 30 caracteres, siendo la primera en mayúscula.";
        }
        else if(!preg_match_all($er_descripcion,$descripcion) || trim($descripcion)==''){
            $respuesta["resultado"]=true;
            $respuesta["mensaje"]="El campo descripción debe contener de 3 a 200 letras.";
        }else{
            $respuesta["resultado"]=false;
            $respuesta["mensaje"]="";
        }
        return $respuesta;
    }
    
}