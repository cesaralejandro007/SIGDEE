<?php
namespace modelo;
use config\connect\connectDB as connectDB;
class AulaEstudianteModelo extends connectDB
{
    private $id;
    private $id_aula;
    private $id_estudiante;

    public function incluir($id_aula, $id_estudiante)
    {
        $this->id_aula = $id_aula;
        $this->id_estudiante = $id_estudiante;

        try {
            $this->conex->query("INSERT INTO aula_estudiante(
				id_aula, id_estudiante)
			VALUES('$this->id_aula', '$this->id_estudiante')");
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }

    }

    public function modificar($id_aula, $id_estudiante, $id)
    {
        $this->id_aula = $id_aula;
        $this->id_estudiante = $id_estudiante;
        $this->id = $id;

        $validar_modificar = $this->validar_modificar();
        if ($validar_modificar) {
            return false;
        } else {
            try {
                $this->conex->query("UPDATE aula_estudiante SET id_aula = '$this->id_aula', id_estudiante = '$this->id_estudiante' WHERE id = '$this->id'");
                return true;
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }
    }

    public function eliminar($id)
    { 
        $this->id = $id;
        if ($this->existe()) {
            try {
                $this->conex->query("DELETE from aula_estudiante
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
        $resultado = $this->conex->prepare("SELECT a.id as id_estudiante, t.id as id, t.id_aula as id_aula, a.id_aula as area FROM aula_estudiante t INNER JOIN area_emprendimiento a ON a.id= t.id_estudiante");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }
    public function buscar($id_estudiante, $id_aula)
    {
        $resultado = $this->conex->prepare("SELECT tm.id as id, t.nombre as tipo, m.nombre as modelo FROM aula_estudiante as t INNER JOIN tipo_modulo as tm ON t.id= tm.id_estudiante INNER JOIN modulo_emprendimiento as m ON m.id=tm.id_aula WHERE t.id= '$id_estudiante' AND m.id='$id_aula'");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function mostrar_modulos($id_tipo)
    {
        try {
            $resul = $this->conex->query("SELECT m.nombre as nombre, m.id as id FROM aula_estudiante as t INNER JOIN tipo_modulo as tm ON t.id= tm.id_estudiante 	INNER JOIN modulo_emprendimiento as m ON m.id=tm.id_aula WHERE t.id='$id_tipo'");
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
    public function mostrar_tipos($id_estudiante)
    {
        try {
            $resul = $this->conex->query("SELECT t.id_aula as id_aula, t.id as id 	FROM aula_estudiante as t INNER JOIN area_emprendimiento as a ON a.id= t.id_estudiante WHERE a.id = '$id_estudiante'");
            if ($resul) {
                $res = "<option value='0'>--Seleccione--</option>";
                foreach ($resul as $r) {
                    $res = $res . "<option value='" . $r['id'] . "'>";
                    $res = $res . $r['id_aula'];
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
    public function validar_registro($id_aula)
    {
        try {
            $resultado = $this->conex->prepare("SELECT * FROM aula_estudiante WHERE id_aula='$id_aula'");
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

    private function validar_modificar()
    {
        try {
            $resultado = $this->conex->prepare("SELECT * FROM aula_estudiante WHERE id_aula='$this->id_aula' AND id<>'$this->id'");
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

    private function existe()
    {
        try {
            $resultado = $this->conex->prepare("SELECT * FROM aula_estudiante WHERE id='$this->id'");
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

    public function limpiar($id_aula)
    {
        $this->id_aula = $id_aula;  
        try {
            $this->conex->query("DELETE from aula_estudiante
				WHERE
				id_aula = '$this->id_aula'
				");
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function relacion_aula($id_aula, $id_estudiante)
    {
        try {

            $resultado = $this->conex->prepare("SELECT ae.id as confirma FROM aula_estudiante ae INNER JOIN estudiante e ON ae.id_estudiante=e.id INNER JOIN aula a ON a.id=ae.id_aula WHERE e.id= '$id_aula' AND a.id= '$id_estudiante'");
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

    public function verificar_estudiante($id_estudiante, $id_unidad, $fecha)
    {
        $confirm = 0;
        try {
            $resultado = $this->conex->prepare("SELECT *FROM usuario u INNER JOIN aula_estudiante ae ON u.id=ae.id_estudiante INNER JOIN aula a ON a.id=ae.id_aula INNER JOIN unidad un ON a.id=un.id_aula INNER JOIN unidad_evaluaciones ue ON un.id=ue.id_unidad INNER JOIN evaluaciones e ON e.id=ue.id_evaluacion WHERE ue.id='$id_unidad' AND u.id='$id_estudiante';");
            $resultado->execute();
            $fila = $resultado->fetchAll();
            if ($fila) {
                $confirm = 1;
                $con_fecha = $this->conex->prepare("SELECT *FROM usuario u INNER JOIN aula_estudiante ae ON u.id=ae.id_estudiante INNER JOIN aula a ON a.id=ae.id_aula INNER JOIN unidad un ON a.id=un.id_aula INNER JOIN unidad_evaluaciones ue ON un.id=ue.id_unidad INNER JOIN evaluaciones e ON e.id=ue.id_evaluacion WHERE ue.id='$id_unidad' AND u.id='$id_estudiante' AND '$fecha' BETWEEN ue.fecha_inicio AND ue.fecha_cierre;");
                $con_fecha->execute();
                $fila_2 = $con_fecha->fetchAll();
                if($fila_2){
                    $confirm = 2;
                }
            } else {
                $confirm = 0;
            }

        } catch (Exception $e) {
            $confirm = 0;
        }
        return $confirm;
    }

    public function verificar($id_estudiante, $id_unidad)
    {
        try {
            $resultado = $this->conex->prepare("SELECT *FROM usuario u INNER JOIN aula_estudiante ae ON u.id=ae.id_estudiante INNER JOIN aula a ON a.id=ae.id_aula INNER JOIN unidad un ON a.id=un.id_aula INNER JOIN unidad_evaluaciones ue ON un.id=ue.id_unidad INNER JOIN evaluaciones e ON e.id=ue.id_evaluacion WHERE ue.id='$id_unidad' AND u.id='$id_estudiante';");
            $resultado->execute();
            $fila = $resultado->fetchAll();
            if ($fila) {
                return 'true';
            } else {
                return 'false';
            }

        } catch (Exception $e) {
            return 'false';
        }
    }


    public function listare($cedula)
    {
        $resultado = $this->conex->prepare("SELECT  a.id as id ,a.nombre as nombre FROM usuario u, aula_estudiante ae, aula a WHERE u.id = ae.id_estudiante and ae.id_aula = a.id and u.cedula ='$cedula'");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }
    public function listar_por_aula($id_aula)
    {
        $resultado = $this->conex->prepare("SELECT u.cedula as cedula, u.id as id, CONCAT(u.primer_nombre, ' ', u.segundo_nombre) as nombre, CONCAT(u.primer_apellido, ' ', u.segundo_apellido) as apellido, u.imagen as foto FROM aula a INNER JOIN aula_estudiante ae ON a.id=ae.id_aula INNER JOIN usuario u ON u.id= ae.id_estudiante WHERE a.id='$id_aula'");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function listardocente($id)
    {
        $resultado = $this->conex->prepare("SELECT CONCAT('Prof: ',usuario.primer_nombre, ' ', usuario.primer_apellido) as nombre_docente FROM usuario,aula_estudiante,aula,aula_docente WHERE aula_estudiante.id_aula = aula.id and aula.id = aula_docente.id_aula and aula_docente.id_docente = usuario.id and aula_estudiante.id_estudiante = $id");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    
}