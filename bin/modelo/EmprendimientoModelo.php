<?php
namespace modelo;
use config\connect\connectDB as connectDB;
class EmprendimientoModelo extends connectDB
{
    private $id;
    private $nombre;
    private $id_area;
    private $status;

    public function incluir($nombre, $id_area)
    {
        $validar_area_emprendimiento = $this->existe_area_emprendimiento($id_area);
        $validar_registro = $this->validar_registro($nombre);
        $expresiones_regulares = $this->validar_expresiones($nombre);
        $validar_expresionIDarea = $this->validar_expresion_id($id_area);
    
        if ($validar_expresionIDarea['resultado']) {
            $respuesta['resultado'] = 4;
            $respuesta['mensaje'] = $validar_expresionIDarea['mensaje'];
        } else if ($validar_area_emprendimiento == false) {
            $respuesta['resultado'] = 4;
            $respuesta['mensaje'] = "No existe área de emprendimiento";
        } else if ($validar_registro) {
            $respuesta['resultado'] = 3;
            $respuesta['mensaje'] = "Nombre ya existe";
        } else if ($expresiones_regulares['resultado']) {
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = $expresiones_regulares['mensaje'];
        } else {
            try {
                $sql = "INSERT INTO emprendimiento (nombre, id_area, estatus) VALUES (?, ?, 'true')";
                $stmt = $this->conex->prepare($sql);
                $stmt->execute([$nombre, $id_area]);
                $respuesta['resultado'] = 1;
                $respuesta['mensaje'] = "Registro exitoso";
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }
        return $respuesta;
    }
    

    public function existe_area_emprendimiento($id)
    {
        try {
            $sql = "SELECT * FROM area_emprendimiento WHERE id = ?";
            $stmt = $this->conex->prepare($sql);
            $stmt->execute([$id]);
            $fila = $stmt->rowCount();
    
            if ($fila > 0) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }
    
    public function modificar($id, $nombre, $id_area)
    {
        $existe_registro_emprendimiento = $this->validar_registro_emprendimiento($nombre, $id);
        $expresiones_regulares = $this->validar_expresiones($nombre);
        $validar_expresionID = $this->validar_expresion_id($id);
        $validar_expresionIDarea = $this->validar_expresion_id($id_area);
        
        if ($validar_expresionID['resultado']) {
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = $validar_expresionID['mensaje'];
        } else if ($validar_expresionIDarea['resultado']) {
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = $validar_expresionIDarea['mensaje'];
        } else if ($this->existe($id) == false) {
            $respuesta['resultado'] = 5;
            $respuesta['mensaje'] = "El Emprendimiento no Existe";
        } else if ($this->existe_area_emprendimiento($id_area) == false) {
            $respuesta['resultado'] = 4;
            $respuesta['mensaje'] = "No existe el área de emprendimiento";
        } else if ($existe_registro_emprendimiento) {
            $respuesta['resultado'] = 3;
            $respuesta['mensaje'] = "Nombre ya existe";
        } else if ($expresiones_regulares['resultado']) {
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = $expresiones_regulares['mensaje'];
        } else {
            try {
                $sql = "UPDATE emprendimiento SET nombre = ?, id_area = ? WHERE id = ?";
                $stmt = $this->conex->prepare($sql);
                $stmt->execute([$nombre, $id_area, $id]);
                $respuesta['resultado'] = 1;
                $respuesta['mensaje'] = "Modificación exitosa";
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }
        return $respuesta;
    }
    

    public function actualizarstatus($id, $status)
    {
        $existe_emprendimieto = $this->validar_emprendimiento($id);
        $validar_expresionID = $this->validar_expresion_id($id);
    
        if ($validar_expresionID['resultado']) {
            $respuesta['resultado'] = 3;
            $respuesta['mensaje'] = $validar_expresionID['mensaje'];
        } else {
            if ($existe_emprendimieto == false) {
                $respuesta['resultado'] = 3;
                $respuesta['mensaje'] = "No existe el emprendimiento";
            } else {
                try {
                    if ($status == "true" || $status == "false") {
                        $sql = "UPDATE emprendimiento SET estatus = ? WHERE id = ?";
                        $stmt = $this->conex->prepare($sql);
                        $stmt->execute([$status, $id]);
                        if ($status == "true") {
                            $respuesta['resultado'] = 1;
                            $respuesta['mensaje'] = "Activado";
                        } else {
                            $respuesta['resultado'] = 2;
                            $respuesta['mensaje'] = "Desactivado";
                        }
                    } else {
                        $respuesta['resultado'] = 4;
                        $respuesta['mensaje'] = "Estado incorrecto";
                    }
                } catch (Exception $e) {
                    return $e->getMessage();
                }
            }
        }
        return $respuesta;
    }    

    public function validar_emprendimiento($id)
    {
        try {
            $sql = "SELECT * FROM emprendimiento WHERE id = ?";
            $stmt = $this->conex->prepare($sql);
            $stmt->execute([$id]);
            $fila = $stmt->rowCount();
            if ($fila > 0) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }

    public function eliminar($id)
    {
        $validar_expresionID = $this->validar_expresion_id($id);
        if ($validar_expresionID['resultado']) {
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = $validar_expresionID['mensaje'];
        } else if ($this->existe($id) == false) {
            $respuesta['resultado'] = 4;
            $respuesta['mensaje'] = "El Emprendimiento no Existe";
            return $respuesta;
        } else if ($this->relacionEmprendimientoModulo($id)) {
            $respuesta['resultado'] = 3;
            $respuesta['mensaje'] = 'No puede ser borrado, existe un vínculo con Emprendimiento-modulo';
        } else if ($this->relacionAspirante($id)) {
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = 'No puede ser borrado, existe un vínculo con Aspirante-Emprendimiento';
        } else {
            try {
                $sql = "DELETE FROM emprendimiento WHERE id = ?";
                $stmt = $this->conex->prepare($sql);
                $stmt->execute([$id]);
                
                $fila = $stmt->rowCount();
                if ($fila > 0) {
                    $respuesta['resultado'] = 1;
                    $respuesta['mensaje'] = "Eliminación exitosa";
                } else {
                    $respuesta['resultado'] = 4;
                    $respuesta['mensaje'] = "No se encontraron registros para eliminar";
                }
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

    public function cargar_emprendimiento()
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
    
    public function listarEmprendimientos($id)
    {
        $resultado = $this->conex->prepare("SELECT t.id as id, t.nombre as nombre, a.id as id_area, a.nombre as area FROM emprendimiento t INNER JOIN area_emprendimiento a ON a.id= t.id_area WHERE a.id = '$id' ");
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
                $res = "";
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

    public function validar_registro_emprendimiento($nombre, $id)
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

    public function validar_expresiones($nombre){
        $er_nombre = '/^[A-ZÁÉÍÓÚa-zñáéíóú,-.\s]{3,30}$/';
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
    public function reporteEstudiantesPorEmprendimiento()
    {
        $total = 0;
        $emprendimientos = [];
        $estudiantes = 0;
        $reprobados = 0;

        //Consulta para obtener el total de emprendimientos de un area
        $resultado = $this->conex->prepare("SELECT COUNT(e.id) as cant_emprendimiento FROM emprendimiento e;");
        $resultado->execute();
        if($resultado){
            foreach($resultado as $r){
                $total = $r['cant_emprendimiento'];
            }
        }

        //Consulta para obtener el total de emprendimientos de un area
        $query_emprendimientos = $this->conex->prepare("SELECT e.id as emprendimiento, e.nombre as nombre FROM area_emprendimiento a INNER JOIN emprendimiento e ON a.id=e.id_area");
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

}
