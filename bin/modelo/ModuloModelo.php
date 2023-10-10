<?php
namespace modelo;
use config\connect\connectDB as connectDB;
class ModuloModelo extends connectDB
{
    private $id;
    private $nombre;

    public function incluir($nombre)
    {
        $validar_registro = $this->validar_registro($nombre);
        $expresiones_regulares = $this->validar_expresiones($nombre);
        
        if ($validar_registro) {
            $respuesta['resultado'] = 3;
            $respuesta['mensaje'] = "El nombre está repetido";
        } else if ($expresiones_regulares['resultado']) {
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = $expresiones_regulares['mensaje'];
        } else {
            try {
                $sql = "INSERT INTO modulo(nombre) VALUES (?)";
                $stmt = $this->conex->prepare($sql);
                $stmt->execute([$nombre]);
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
        $validar_expresionID = $this->validar_expresion_id($id);
    
        if ($validar_expresionID['resultado']) {
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = $validar_expresionID['mensaje'];
        } else if ($this->existe($id) == false) {
            $respuesta['resultado'] = 4;
            $respuesta['mensaje'] = "El Módulo no Existe";
        } else if ($validar_modificar) {
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = "El nombre está repetido";
        } else if ($expresiones_regulares['resultado']) {
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = $expresiones_regulares['mensaje'];
        } else {
            try {
                $sql = "UPDATE modulo SET nombre = ? WHERE id = ?";
                $stmt = $this->conex->prepare($sql);
                $stmt->execute([$nombre, $id]);
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
        $validar_tipo = $this->validarEmprendimientoModulo($id);
        $validar_expresionID = $this->validar_expresion_id($id);

        if ($validar_expresionID['resultado']) {
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = $validar_expresionID['mensaje'];
        } else if ($this->existe($id) == false) {
            $respuesta['resultado'] = 3;
            $respuesta['mensaje'] = "El Módulo no Existe";
            return $respuesta;
        } else if ($validar_tipo) {
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = "No puede ser borrado, existe un vínculo con Emprendimiento-modulo";
        } else {
            try {
                $sql = "DELETE FROM modulo WHERE id = ?";
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
        $resultado = $this->conex->prepare("SELECT id, nombre FROM modulo");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
                $respuesta['resultado'] = 0;
                $respuesta['mensaje'] = $e->getMessage();
        }
        return $respuestaArreglo;
    }
    public function cargar($id)
    {
        $resultado = $this->conex->prepare("SELECT id, nombre FROM modulo WHERE
			id = '$id'
			");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
                $respuesta['resultado'] = 0;
                $respuesta['mensaje'] = $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function mostrar()
    {
        try {
            $resul = $this->conex->query("SELECT * FROM modulo");
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
                $respuesta['resultado'] = 0;
                $respuesta['mensaje'] = $e->getMessage();
        }

    }

    public function validar_registro($nombre)
    {
        try {
            $resultado = $this->conex->prepare("SELECT * FROM modulo WHERE nombre='$nombre'");
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
            $resultado = $this->conex->prepare("SELECT * FROM modulo WHERE nombre='$nombre' AND id<>'$id'");
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
    public function validarEmprendimientoModulo($id)
    {
        try {
            $resultado = $this->conex->prepare("SELECT * FROM emprendimiento_modulo WHERE id_modulo='$id'");
            $resultado->execute();
            $fila = $resultado->rowCount();
            if ($fila > 0) {
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
            $resultado = $this->conex->prepare("SELECT * FROM modulo WHERE id='$id'");
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

            $resultado = $this->conex->prepare("SELECT * FROM emprendimiento e, emprendimiento_modulo em WHERE e.id = em.id_emprendimiento and e.id = '$id'");
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
        $er_nombre = '/^[A-ZÁÉÍÓÚa-zñáéíóú,.#%$^&*:\s]{3,30}$/';
        if(!preg_match_all($er_nombre,$nombre) || trim($nombre)==''){
            $respuesta["resultado"]=true;
            $respuesta["mensaje"]="El campo Nombre debe tener solo letras de 1 a 30, siendo la primera letra en mayúscula de cada palabra.";
        }else{
            $respuesta["resultado"]=false;
            $respuesta["mensaje"]="";
        }
        return $respuesta;
    }
    

    public function listadomodulos($emprendimiento)
    {
        $r = array();
        try {

            $resultado = $this->conex->prepare("select modulo.id,
            modulo.nombre
            from modulo
            where
            modulo.id in (select id_modulo from emprendimiento_modulo
            where id_emprendimiento =:emprendimiento)");
            $resultado->BindParam(":emprendimiento", $emprendimiento);

            $resultado->execute();

            $x = '<option disabled selected>Seleccione</option>';
            if ($resultado) {

                foreach ($resultado as $f) {
                    $x = $x . '<option value="' . $f[0] . '">' . $f[1] . '</option>';
                }

            }

            $r['resultado'] = 'listadomodulos';
            $r['mensaje'] = $x;

        } catch (Exception $e) {
            $r['resultado'] = 'error';
            $r['mensaje'] = $e->getMessage();

        }
        return $r;
    }

}