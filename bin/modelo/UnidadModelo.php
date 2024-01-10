<?php
namespace modelo;
use config\connect\connectDB as connectDB;
class UnidadModelo extends connectDB
{
    private $id;
    private $nombre;
    private $descripcion;
    private $id_aula;

    public function incluir($nombre, $descripcion, $id_aula)
    {
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->id_aula = $id_aula;

        $existeaula = $this->validar_aula($this->id_aula);
        $validar_nombre = $this->validar_registro($this->nombre);
        $expresiones_regulares = $this->validar_expresiones($this->nombre, $this->descripcion);
        if ($validar_nombre) {
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = "Nombre ya existe";
        }else if($existeaula == false){
            $respuesta['resultado'] = 3;
            $respuesta['mensaje'] = "No existe el aula";
        }
        else if ($expresiones_regulares['resultado']) {
            $respuesta['resultado'] = 4;
            $respuesta['mensaje'] = $expresiones_regulares['mensaje'];
        } 
        else {
            try {
                $this->conex->query("INSERT INTO unidad (nombre, descripcion, id_aula) VALUES ('$this->nombre', '$this->descripcion', '$this->id_aula')");
                
                $respuesta['resultado'] = 1;
                $respuesta['mensaje'] = "INSERT INTO unidad (nombre, descripcion, id_aula) VALUES ('$this->nombre', '$this->descripcion', '$this->id_aula')";
            } catch (Exception $e) {
                $respuesta['resultado'] = 0;
                $respuesta['mensaje'] = $e->getMessage();
            }
        }
        return $respuesta;
    }

	public function validar_aula($id)
    {
        try {
            $sql = "SELECT * FROM aula WHERE id = ?";  
            $values = [$id];
            $stmt = $this->conex->prepare($sql); 
            $stmt->execute($values);
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

    public function modificar($id, $nombre, $descripcion, $id_aula)
    {
        $validar_expresionID = $this->validar_expresion_id($id);
        $validar_expresionIdAula = $this->validar_expresion_id($id_aula);
        $validar_modificar = $this->validar_modificar($nombre, $id);
        $validar_unidad = $this->existe($id);
        $existeaula = $this->validar_aula($id_aula);
        $expresiones_regulares = $this->validar_expresiones($nombre, $descripcion);
        if ($validar_expresionID['resultado']) {
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = $validar_expresionID['mensaje'];
        }else
        if ($validar_expresionIdAula['resultado']) {
            $respuesta['resultado'] = 3;
            $respuesta['mensaje'] = $validar_expresionID['mensaje'];
        }else
        if ($validar_unidad == false) {
            $respuesta['resultado'] = 4;
            $respuesta['mensaje'] = "La unidad no Existe";
        } 
        else if ($validar_modificar) {
            $respuesta['resultado'] = 5;
            $respuesta['mensaje'] = "Nombre de la unidad ya existe";
        } 
        else if($existeaula == false){
            $respuesta['resultado'] = 6;
            $respuesta['mensaje'] = "No existe el aula";
        }
        else if ($expresiones_regulares['resultado']) {
            $respuesta['resultado'] = 7;
            $respuesta['mensaje'] = $expresiones_regulares['mensaje'];
        }else {
            try {
                $sql = "UPDATE unidad SET nombre = ?, descripcion = ?, id_aula = ? WHERE id = ?";
                $stmt = $this->conex->prepare($sql);
                $stmt->execute([$nombre, $descripcion, $id_aula, $id]);
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
        $validar_expresionID = $this->validar_expresion_id($id);
        $validar_contenido = $this->relacion_contenido($id);
        $validar_evaluacion = $this->relacion_evaluacion($id);
        if ($validar_expresionID['resultado']) {
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = $validar_expresionID['mensaje'];
        }else if (!$this->existe($id)) {
            $respuesta['resultado'] = 3;
            $respuesta['mensaje'] = "La unidad no Existe";
            return $respuesta;
        } 
        else if ($validar_contenido) {
            $respuesta['resultado'] = 4;
            $respuesta['mensaje'] = "No puede ser borrada, existe un vínculo con un contenido";
        }
        else if ($validar_evaluacion) {
            $respuesta['resultado'] = 5;
            $respuesta['mensaje'] = "No puede ser borrada, existe un vínculo con una evaluación";
        } 
        else {
            try {
                $sql = "DELETE FROM unidad WHERE id = ?";
                $stmt = $this->conex->prepare($sql);
                $stmt->execute([$id]);
                $respuesta['resultado'] = 1;
                $respuesta['mensaje'] = "Eliminación exitosa";
            } catch (Exception $e) {
                $respuesta['resultado'] = 0;
                $respuesta['mensaje'] = $e->getMessage();
            }
        }
        return $respuesta;
    }

    public function listar()
    {
        $sql = "SELECT * FROM unidad";
        $resultado = $this->conex->prepare($sql);
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
        $sql = "SELECT * FROM unidad WHERE id = ?";
        $resultado = $this->conex->prepare($sql);
        $respuestaArreglo = [];
        try {
            $resultado->execute([$id]);
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }


    public function validar_registro($nombre)
    {
        try {
            $resultado = $this->conex->prepare("SELECT * FROM Unidad WHERE nombre='$nombre'");
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
            $resultado = $this->conex->prepare("SELECT * FROM unidad WHERE nombre='$nombre' AND id<>'$id'");
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
            $resultado = $this->conex->prepare("SELECT * FROM unidad WHERE id='$id'");
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
        $sql = "SELECT u.nombre as unidad, u.id as id, u.descripcion FROM unidad as u WHERE u.id_aula = ?";
        $resultado = $this->conex->prepare($sql);
        $respuestaArreglo = [];
        try {
            $resultado->execute([$id]);
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }
    
    public function listarUnidades($id_aula)
    {
        $r = array();
        try {
            $sql = "SELECT u.id as id, u.nombre as nombre FROM aula a INNER JOIN unidad u ON a.id = u.id_aula WHERE a.id = ?";
            $resultado = $this->conex->prepare($sql);
            $resultado->execute([$id_aula]);
    
            $x = '<option disabled selected>Seleccione</option>';
            if ($resultado) {
                foreach ($resultado as $f) {
                    $x = $x . '<option value="' . $f[0] . '">' . $f[1] . '</option>';
                }
            }
    
            $r['resultado'] = 'listadounidades';
            $r['mensaje'] = $x;
        } catch (Exception $e) {
            $r['resultado'] = 'error';
            $r['mensaje'] = $e->getMessage();
        }
        return $r;
    }
    
    // Métodos privados...
    
    private function relacion_contenido($id)
    {
        $sql = "SELECT u.id unidad FROM unidad u INNER JOIN unidad_contenido ue ON u.id = ue.id_unidad WHERE u.id = ?";
        $resultado = $this->conex->prepare($sql);
        $resultado->execute([$id]);
        $fila = $resultado->fetchAll();
        if ($fila) {
            return true;
        } else {
            return false;
        }
    }
    
    private function relacion_evaluacion($id)
    {
        $sql = "SELECT u.id unidad FROM unidad u INNER JOIN unidad_evaluaciones ue ON u.id = ue.id_unidad WHERE u.id = ?";
        $resultado = $this->conex->prepare($sql);
        $resultado->execute([$id]);
        $fila = $resultado->fetchAll();
        if ($fila) {
            return true;
        } else {
            return false;
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