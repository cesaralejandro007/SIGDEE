<?php
namespace modelo;
use config\connect\connectDB as connectDB;
class EmprendimientoModuloModelo extends connectDB
{
    private $id;
    private $id_modulo;
    private $id_emprendimiento;
    private $status;


    public function incluir($id_modulo,$id_emprendimiento,$status)
    {
        $existe_emprendimieto_modulo = $this->validar_emprendimiento_modulo($id_modulo, $id_emprendimiento);
        $existe_modulo = $this->validar_modulo($id_modulo);
        $existe_emprendimieto = $this->validar_emprendimiento($id_emprendimiento);
        $validar_expresionID = $this->validar_expresion_id($id_modulo,$id_emprendimiento);
        if ($validar_expresionID['resultado']) {
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = $validar_expresionID['mensaje'];
        }else{
            if($existe_modulo==false){
                $respuesta['resultado'] = 4;
                $respuesta['mensaje'] = "No existe el modulo";
            }else if($existe_emprendimieto==false){
                $respuesta['resultado'] = 5;
                $respuesta['mensaje'] = "No existe el emprendimieto";
            }else if($existe_emprendimieto_modulo == false and $status == "true") {
                try {
                    $this->conex->query("INSERT INTO emprendimiento_modulo(
                        id_modulo,
                        id_emprendimiento
                        )
                        VALUES(
                        '$id_modulo',
                        '$id_emprendimiento'
                    )");
                    $respuesta['resultado'] = 1;
                    $respuesta['mensaje'] = "Registro exitoso";
                } catch (Exception $e) {
                    return $e->getMessage();
                }
            }else if ($existe_emprendimieto_modulo == true and $status == "false") {
                $emprendimiento_aula = $this->validar_emprendimiento_aula($id_modulo, $id_emprendimiento);
                if($emprendimiento_aula){
                    $resultado = $this->conex->prepare("DELETE from emprendimiento_modulo
                        WHERE
                        id_emprendimiento = '$id_emprendimiento' and id_modulo = '$id_modulo'
                        ");
                    try {
                        $resultado->execute();
                        $fila = $resultado->rowCount();
                        if ($fila > 0) {
                            $respuesta['resultado'] = 1;
                            $respuesta['mensaje'] = "Eliminación exitosa";
                        } else {
                            $respuesta['resultado'] = 2;
                            $respuesta['mensaje'] = "El Modulo no puede ser borrardo, existen vinculos con Emprendimiento Modulo.";
                        }
                    } catch (Exception $e) {
                        return $e->getMessage();
                    }
                }else{
                    $respuesta['resultado'] = 2;
                    $respuesta['mensaje'] = "El Modulo no puede ser borrardo, existen vinculo con Aula.";
                }
            }else if ($existe_emprendimieto_modulo == false and $status == "false") {
                $respuesta['resultado'] = 3;
                $respuesta['mensaje'] = "No existe el registro emprendimieto modulo";
            }else {
                $respuesta['resultado'] = 1;
                $respuesta['mensaje'] = "Registro exitoso";
            }
        }
        return $respuesta;
    }

    public function validar_modulo($id)
    {
        try {
            $resultado = $this->conex->prepare("SELECT * FROM modulo WHERE id='$id'");
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

    public function validar_emprendimiento($id)
    {
        try {
            $resultado = $this->conex->prepare("SELECT * FROM emprendimiento WHERE id='$id'");
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

    public function modificar()
    {
        $validar_modificar = $this->validar_modificar($this->id_modulo, $this->id);
        if ($validar_modificar) {
            return false;
        } else {
            try {
                $this->conex->query("UPDATE emprendimiento_modulo SET id_modulo = '$this->id_modulo', id_emprendimiento = '$this->id_emprendimiento' WHERE id = '$this->id'");
                return true;
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }
    }

    public function eliminar()
    {
        if ($this->existe($this->id)) {
            try {
                $this->conex->query("DELETE from emprendimiento_modulo
					WHERE id = '$this->id'");
                return true;
            } catch (Exception $e) {
                return $e->getMessage();
            }
        } else {
            return false;
        }
    }

    public function listar()
    {
        $resultado = $this->conex->prepare("SELECT a.id as id_emprendimiento, t.id as id, t.id_modulo as id_modulo, a.id_modulo as area FROM emprendimiento_modulo t INNER JOIN area_emprendimiento a ON a.id= t.id_emprendimiento");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    //Posiblemente se elimine este metodo
    public function buscar($id_emprendimiento, $id_modulo)
    {
        $resultado = $this->conex->prepare("SELECT tm.id as id, t.nombre as tipo, m.nombre as modelo FROM emprendimiento as t INNER JOIN emprendimiento_modulo as tm ON t.id= tm.id_emprendimiento INNER JOIN modulo as m ON m.id=tm.id_modulo WHERE t.id= '$id_emprendimiento' AND m.id='$id_modulo'");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }


    public function buscar_emprendimiento_modulo($id_emprendimiento, $id_modulo)
    {
        $result = 0;
        try {
            $resultado = $this->conex->query("SELECT tm.id as id, t.nombre as tipo, m.nombre as modelo FROM emprendimiento as t INNER JOIN emprendimiento_modulo as tm ON t.id= tm.id_emprendimiento INNER JOIN modulo as m ON m.id=tm.id_modulo WHERE t.id= '$id_emprendimiento' AND m.id='$id_modulo' LIMIT 1");
            if($resultado){
                foreach($resultado as $r){
                  $result = $r['id'];  
                }
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $result;
    }

    public function mostrar_modulos($id_tipo)
    {
        try {
            $resul = $this->conex->query("SELECT m.nombre as nombre, m.id as id FROM emprendimiento as t INNER JOIN emprendimiento_modulo as tm ON t.id= tm.id_emprendimiento INNER JOIN modulo as m ON m.id=tm.id_modulo WHERE t.id='$id_tipo'");
            if ($resul) {
                $res = "<option value=''>Seleccione</option>";
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
    public function mostrar_tipos($id_emprendimiento)
    {
        try {
            $resul = $this->conex->query("SELECT t.id_modulo as id_modulo, t.id as id 	FROM emprendimiento_modulo as t INNER JOIN area_emprendimiento as a ON a.id= t.id_emprendimiento WHERE a.id = '$id_emprendimiento'");
            if ($resul) {
                $res = "<option value='0'>--Seleccione--</option>";
                foreach ($resul as $r) {
                    $res = $res . "<option value='" . $r['id'] . "'>";
                    $res = $res . $r['id_modulo'];
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
    public function validar_registro($id_modulo)
    {
        try {
            $resultado = $this->conex->prepare("SELECT * FROM emprendimiento_modulo WHERE id_modulo='$id_modulo'");
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

    public function validar_modificar($id_modulo, $id)
    {
        try {
            $resultado = $this->conex->prepare("SELECT * FROM emprendimiento_modulo WHERE id_modulo='$id_modulo' AND id<>'$id'");
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
            $resultado = $this->conex->prepare("SELECT * FROM emprendimiento_modulo WHERE id='$id'");
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
    public function cmud_emprendimeinto($id)
    {
        $resultado = $this->conex->prepare("SELECT em.id_emprendimiento as idemprendimiento ,e.nombre as nombreemprendimiento, em.id_modulo as idmodulo FROM emprendimiento_modulo em, emprendimiento e WHERE e.id = em.id_emprendimiento and em.id_emprendimiento ='$id'
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

    public function validar_emprendimiento_modulo($id_modulo, $id_emprendimiento)
    {
        $resultado = $this->conex->prepare("SELECT * FROM emprendimiento_modulo WHERE id_emprendimiento = '$id_emprendimiento' and id_modulo ='$id_modulo'");
        try {
            $resultado->execute();
            $respuesta1 = $resultado->rowCount();
            if ($respuesta1 > 0) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }

    public function validar_emprendimiento_aula($id_modulo, $id_emprendimiento)
    {
        $resultado = $this->conex->prepare("SELECT * FROM emprendimiento,emprendimiento_modulo,aula WHERE emprendimiento.id = emprendimiento_modulo.id_emprendimiento AND aula.id_emprendimiento_modulo = emprendimiento_modulo.id and emprendimiento_modulo.id_emprendimiento = '$id_emprendimiento' and emprendimiento_modulo.id_modulo ='$id_modulo'");
        try {
            $resultado->execute();
            $respuesta1 = $resultado->rowCount();
            if ($respuesta1 > 0) {
                return false;
            } else {
                return true;
            }
        } catch (Exception $e) {
            return false;
        }
    }

    public function validar_expresion_id($id_modulo,$id_emprendimiento){
        if(!preg_match('/^[0-9]+$/', $id_modulo)){
            $respuesta["resultado"]=true;
            $respuesta["mensaje"]="El campo id_modulo solo debe contener números";
        }else if(!preg_match('/^[0-9]+$/', $id_emprendimiento)){
            $respuesta["resultado"]=true;
            $respuesta["mensaje"]="El campo id_emprendimiento solo debe contener números";
        }else{
            $respuesta["resultado"]=false;
            $respuesta["mensaje"]="";
        }
        return $respuesta;
    }
}