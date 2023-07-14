<?php
namespace modelo;
use config\connect\connectDB as connectDB;
class UnidadModelo extends connectDB
{
    private $id;
    private $nombre;
    private $descripcion;
    private $id_aula;


    public function incluir($id,$nombre, $descripcion, $id_aula)
    {
        $validar_nombre = $this->validar_registro($nombre);
        if ($validar_nombre) {
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = "Nombre ya existe";
        }    
         else {
            try {
                $this->conex->query("INSERT INTO unidad(
                    nombre,
                    descripcion,
                    id_aula
                    )
                VALUES(
                    '$nombre',
                    '$descripcion',
                    '$id_aula'
                )");
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
        if ($validar_unidad==false) {
            $respuesta['resultado'] = 3;
            $respuesta['mensaje'] = "La unidad no Existe";
        } 
        else
        if ($validar_modificar) {
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = "Nombre ya existe";
        } 
        else {
            try {
                 $this->conex->query("UPDATE unidad SET nombre= '$nombre',descripcion = '$descripcion',id_aula = '$id_aula' WHERE id = '$id'");
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
        if ($this->existe($id)==false) {
            $respuesta['resultado'] = 3;
            $respuesta['mensaje'] = "La unidad no Existe";
            return $respuesta;
        }else
        if ($validar_contenido) {
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = "No puede ser borrardo, existe un vinculo con un contenido";
        }
        else
        if ($validar_evaluacion) {
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = "No puede ser borrardo, existe un vinculo con una evaluacion";
        } else{
                try {
                    $this->conex->query("DELETE from unidad
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

    public function listar()
    {
        $resultado = $this->conex->prepare("SELECT * FROM unidad");
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
        $resultado = $this->conex->prepare("SELECT * FROM unidad WHERE
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
        $resultado = $this->conex->prepare("SELECT u.nombre as unidad, u.id as id, u.descripcion From unidad as u WHERE u.id_aula='$id'
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
    
    public function listarUnidades($id_aula)
    {
        $r = array();
        try {

            $resultado = $this->conex->prepare("SELECT u.id as id, u.nombre as nombre FROM aula a INNER JOIN unidad u ON a.id= u.id_aula WHERE a.id='$id_aula'");
            $resultado->execute();

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

    private function relacion_contenido($id)
    {
        try {

            $resultado = $this->conex->prepare("SELECT u.id unidad FROM unidad u INNER JOIN unidad_contenido ue ON u.id=ue.id_unidad WHERE u.id='" . $id . "'");
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

    private function relacion_evaluacion($id)
    {
        try {
            $resultado = $this->conex->prepare("SELECT u.id unidad FROM unidad u INNER JOIN unidad_evaluaciones ue ON u.id=ue.id_unidad WHERE u.id='" . $id . "'");
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

    private function validar_expresiones($valor){
        $er_nombre = '/^[a-zA-Z\x{00f1}\x{00d1}\x{00E0}-\x{00FC}\b ]*$/u';
        $m = false;
        if(!preg_match_all($er_nombre,$valor) || trim($valor)==''){
           $m = true;
        }
        return $m;
    }

}