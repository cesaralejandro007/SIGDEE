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
            $respuesta['mensaje'] = "El Area de Emprendimiento de no Existe";
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
            $respuesta['mensaje'] = "El Area de Emprendimiento de no Existe";
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

            $resultado = $this->conex->prepare("select area_emprendimiento.id, area_emprendimiento.nombre from
area_emprendimiento");

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
}