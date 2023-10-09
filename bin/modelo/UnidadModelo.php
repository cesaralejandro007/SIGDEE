<?php
namespace modelo;
use config\connect\connectDB as connectDB;
class UnidadModelo extends connectDB
{
    private $id;
    private $nombre;
    private $descripcion;
    private $id_aula;

    public function incluir($id, $nombre, $descripcion, $id_aula)
    {
        $validar_nombre = $this->validar_registro($nombre);
        if ($validar_nombre) {
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = "Nombre ya existe";
        }    
        else {
            try {
                $sql = "INSERT INTO unidad (nombre, descripcion, id_aula) VALUES (?, ?, ?)";
                $stmt = $this->conex->prepare($sql);
                $stmt->execute([$nombre, $descripcion, $id_aula]);
                $respuesta['resultado'] = 1;
                $respuesta['mensaje'] = "Registro exitoso";
            } catch (Exception $e) {
                $respuesta['resultado'] = 0;
                $respuesta['mensaje'] = $e->getMessage();
            }
        }
        return $respuesta;
    }

    public function modificar($id, $nombre, $descripcion, $id_aula)
    {
        $validar_modificar = $this->validar_modificar($nombre, $id);
        $validar_unidad = $this->existe($id);
        if ($validar_unidad == false) {
            $respuesta['resultado'] = 3;
            $respuesta['mensaje'] = "La unidad no Existe";
        } 
        else if ($validar_modificar) {
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = "Nombre ya existe";
        } 
        else {
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
        $validar_contenido = $this->relacion_contenido($id);
        $validar_evaluacion = $this->relacion_evaluacion($id);
        if (!$this->existe($id)) {
            $respuesta['resultado'] = 3;
            $respuesta['mensaje'] = "La unidad no Existe";
            return $respuesta;
        } 
        else if ($validar_contenido) {
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = "No puede ser borrada, existe un vínculo con un contenido";
        }
        else if ($validar_evaluacion) {
            $respuesta['resultado'] = 2;
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
    
    private function validar_expresiones($valor)
    {
        $er_nombre = '/^[a-zA-Z\x{00f1}\x{00d1}\x{00E0}-\x{00FC}\b ]*$/u';
        $m = false;
        if (!preg_match_all($er_nombre, $valor) || trim($valor) == '') {
            $m = true;
        }
        return $m;
    }
    

}