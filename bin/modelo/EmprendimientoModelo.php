<?php
namespace modelo;
use config\connect\connectDB as connectDB;
class EmprendimientoModelo extends connectDB
{
    private $id;
    private $nombre;
    private $id_area;
    private $status;

    public function incluir($nombre,$id_area)
    {
        $validar_registro = $this->validar_registro($nombre);
        $expresiones_regulares = $this->validar_expresiones($nombre);
        if ($validar_registro) {
            $respuesta['resultado'] = 3;
            $respuesta['mensaje'] = "Nombre ya existe";
        }else if ($expresiones_regulares['resultado']) {
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = $expresiones_regulares['mensaje'];
        } else{
            try {
                $this->conex->query("INSERT INTO emprendimiento(
					nombre, id_area, estatus)
					VALUES('$nombre', '$id_area', 'true')");
                $respuesta['resultado'] = 1;
                $respuesta['mensaje'] = "Registro exitoso";
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }
        return $respuesta;
    }

    public function modificar($id,$nombre,$id_area)
    {
        $validar_modificar = $this->validar_modificar($nombre, $id);
        $expresiones_regulares = $this->validar_expresiones($nombre);

        if ($this->existe($id)==false) {
            $respuesta['resultado'] = 4;
            $respuesta['mensaje'] = "El Emprendimiento de no Existe";
        }else if ($validar_modificar) {
            $respuesta['resultado'] = 3;
            $respuesta['mensaje'] = "Nombre ya existe";
        }else if ($expresiones_regulares['resultado']) {
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = $expresiones_regulares['mensaje'];
        }else{
            try {
                $this->conex->query("UPDATE emprendimiento SET nombre = '$nombre', id_area = '$id_area' WHERE id = '$id'");
                $respuesta['resultado'] = 1;
                $respuesta['mensaje'] = "Modificación exitoso";
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }
        return $respuesta;
    }

    public function actualizarstatus($id,$status)
    {
        try {
            $this->conex->query("UPDATE emprendimiento SET estatus = '$status' WHERE id = '$id'");
            if($status=="true"){
                $respuesta['resultado'] = 1;
                $respuesta['mensaje'] = "Activado";
            }else{
                $respuesta['resultado'] = 2;
                $respuesta['mensaje'] = "Desactivado";
            }

        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuesta;
    }

    public function cemprendimiento()
    {
        $resultado = $this->conex->prepare("SELECT * FROM emprendimiento");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function eliminar($id)
    {
        if ($this->existe($id)==false) {
            $respuesta['resultado'] = 4;
            $respuesta['mensaje'] = "El Emprendimiento no Existe";
            return $respuesta;
        }else if($this->relacionEmprendimientoModulo($id)){
            $respuesta['resultado'] = 3;
            $respuesta['mensaje'] = 'No puede ser borrardo, existe un vinculo con Emprendimiento-modulo';
        } else if($this->relacionAspirante($id)){
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = 'No puede ser borrardo, existe un vinculo con Aspirante-Emprendimiento';
        } else{
            try {
                $this->conex->query("DELETE from emprendimiento
                    WHERE
                    id = '$id'
                    ");
                $respuesta['resultado'] = 1;
                $respuesta['mensaje'] = "Eliminación exitosa";
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }
        return $respuesta;
    }

    public function listar()
    {
        $resultado = $this->conex->prepare("SELECT a.id as id_area, t.id as id, t.nombre as nombre, a.nombre as area FROM emprendimiento t INNER JOIN area_emprendimiento a ON a.id= t.id_area");
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
        $resultado = $this->conex->prepare("SELECT t.id as id, t.nombre as nombre, a.id as id_area, a.nombre as area FROM emprendimiento t INNER JOIN area_emprendimiento a ON a.id= t.id_area WHERE
			t.id = '$id'
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
            $resul = $this->conex->query("SELECT * FROM emprendimiento");
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
            $resultado = $this->conex->prepare("SELECT * FROM emprendimiento WHERE nombre='$nombre'");
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
            $resultado = $this->conex->prepare("SELECT * FROM emprendimiento WHERE nombre='$nombre' AND id<>'$id'");
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
            $resultado = $this->conex->prepare("SELECT * FROM emprendimiento WHERE id='$id'");
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
    public function mostrar_tipos($id_area)
    {
        try {
            $resul = $this->conex->query("SELECT t.nombre as nombre, t.id as id 	FROM emprendimiento as t INNER JOIN area_emprendimiento as a ON a.id= t.id_area WHERE a.id = '$id_area'");
            if ($resul) {
                $res = "<option value='0'>Seleccione</option>";
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

    public function relacionEmprendimientoModulo($id)
    {
        try {

            $resultado = $this->conex->prepare("SELECT *FROM emprendimiento_modulo em INNER JOIN emprendimiento e ON e.id= em.id_emprendimiento INNER JOIN modulo m ON m.id=em.id_modulo WHERE e.id='$id'");
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
    public function relacionAspirante($id)
    {
        try {

            $resultado = $this->conex->prepare("SELECT * FROM aspirante_emprendimiento WHERE id_emprendimiento='$id'");
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

 public function reporteEstudianteEmprendimiento($id_area){
        $total = 0;
        $emprendimientos = [];
        $estudiantes = 0;
        $reprobados = 0;

        //Consulta para obtener el total de emprendimientos de un area
        $resultado = $this->conex->prepare("SELECT COUNT(e.id) as cant_emprendimiento FROM area_emprendimiento a INNER JOIN emprendimiento e ON a.id=e.id_area WHERE a.id='$id_area';");
        $resultado->execute();
        if($resultado){
            foreach($resultado as $r){
                $total = $r['cant_emprendimiento'];
            }
        }

        //Consulta para obtener el total de emprendimientos de un area
        $query_emprendimientos = $this->conex->prepare("SELECT e.id as emprendimiento, e.nombre as nombre FROM area_emprendimiento a INNER JOIN emprendimiento e ON a.id=e.id_area WHERE a.id='$id_area';");
        $query_emprendimientos->execute();
        if($query_emprendimientos){
            foreach($query_emprendimientos as $r){
                //Consulta para obtener la cantidad de estudiantes por cada emprendimiento
                $query_estudiantes = $this->conex->prepare("SELECT u.id as cant_estudiante FROM emprendimiento e INNER JOIN emprendimiento_modulo em ON e.id= em.id_emprendimiento INNER JOIN modulo m ON em.id_modulo= m.id INNER JOIN aula a ON a.id_emprendimiento_modulo= em.id INNER JOIN aula_estudiante ae ON a.id= ae.id_aula INNER JOIN usuario u ON ae.id_estudiante= u.id WHERE e.id=".$r['emprendimiento']." GROUP BY u.id;");
                $query_estudiantes->execute();
                $cantidad = 0;
                if($query_estudiantes){
                    foreach($query_estudiantes as $count){
                    $estudiantes++; 
                        $cantidad++;
                    }
                }
                $emprendimientos[] = ([
                    "name"=> $r['nombre'],
                    "y" => $cantidad
                ]); 
            }
        }

        $r['estudiantes'] = $estudiantes;
        $r['total'] = $total;
        $r['emprendimientos'] = $emprendimientos;

        return $r;
    }

        public function listadoemprendimientos($area)
    {
        $r = array();
        try {

            $resultado = $this->conex->prepare("select emprendimiento.id, emprendimiento.nombre from emprendimiento
            where id_area =:area AND estatus='true'");
	    $resultado->BindParam(":area", $area);
            $resultado->execute();

            $x = '<option disabled selected>Seleccione</option>';
            if ($resultado) {

                foreach ($resultado as $f) {
                    $x = $x . '<option value="' . $f[0] . '">' . $f[1] . '</option>';
                }

            }

            $r['resultado'] = 'listadoemprendimientos';
            $r['mensaje'] = $x;

        } catch (Exception $e) {
            $r['resultado'] = 'error';
            $r['mensaje'] = $e->getMessage();

        }
        return $r;
    }

}
