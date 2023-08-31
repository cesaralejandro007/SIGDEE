<?php
namespace modelo;
use config\connect\connectDB as connectDB;
class PostulacionModelo extends connectDB
{
    private $id;
    private $id_aspirante;
    private $id_emprendimiento;

    public function set_id($valor)
    {
        $this->id = $valor;
    }

    public function set_id_aspirante($valor)
    {
        $this->id_aspirante = $valor;
    }

    public function set_id_emprendimiento($valor)
    {
        $this->id_emprendimiento = $valor;
    }

    public function get_id()
    {
        return $this->id;
    }

    public function get_id_aspirante()
    {
        return $this->id_aspirante;
    }

    public function get_id_emprendimiento()
    {
        return $this->id_emprendimiento;
    }

    public function incluir()
    {
        $validar_nombre = $this->validar_registro($this->id_aspirante, $this->id_emprendimiento);
        if (!$validar_nombre) {
            try {
                $this->conex->query("INSERT INTO aspirante_emprendimiento(id_aspirante, id_emprendimiento)
					VALUES('$this->id_aspirante', '$this->id_emprendimiento')");
                return true;
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }
    }

    public function eliminar()
    {
        $validar_tipo = $this->relacion_tipo($this->id);
        if ($validar_tipo) {
            return "2";
        } else
        if ($this->existe($this->id)) {
            try {
                $this->conex->query("DELETE from aspirante_emprendimiento
						WHERE
						id = '$this->id'
						");
                return "1";
            } catch (Exception $e) {
                return $e->getMessage();
            }
        } else {
            return "3";
        }
    }

    public function listar_aspirante_emprendimientos()
    {
        $resultado = $this->conex->prepare("SELECT id, nombre FROM aspirante_emprendimiento");
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
        $resultado = $this->conex->prepare("SELECT a.id as id, a.nombre as aspirante_emprendimiento, d.id as id_docente, d.cedula as cedula, d.nombre as nombre, d.apellido as apellido FROM aspirante_emprendimiento as a INNER JOIN aspirante_emprendimiento_docente as ad ON a.id=ad.id_aspirante_emprendimiento INNER JOIN usuario as d ON d.id= ad.id_docente WHERE a.id ='$id'
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


    public function emprendimientos_propuestos()
    {
        try {
            $res = '';
            $resul = $this->conex->query("SELECT * FROM area_emprendimiento");
            if ($resul) {
                foreach ($resul as $r) {
                    $res = $res . "<div class='d-flex'>";
                    $res = $res . "<table id='emprendimiento' class='table table-striped table-hover table-bordered'>";
                    $res = $res . " <thead><tr><th scope='col'>" . $r['nombre'] . "</th></tr> </th></thead>";
                    $emprend = $this->conex->query("SELECT e.id, e.nombre FROM emprendimiento as e INNER JOIN area_emprendimiento as a ON e.id_area=a.id WHERE a.id='" . $r['id'] . "' AND e.estatus='true' ");
                    if ($emprend) {

                        foreach ($emprend as $e) {
                            $res = $res . "<tbody id=''>   <tr>";
                            $res = $res . "<td style='display:none;'>";
                            $res = $res . "<input type='text' name='' style='display:none;' value='" . $e['id'] . "'/>";
                            $res = $res . "</td></tr>";
                            $res = $res . "<tr><td>";
                            $res = $res . "<div class='form-check'>";
                            $res = $res . "<input class='form-check-input' name='emprendimiento[]' type='checkbox' value='" . $e['id'] . "'>";
                            $res = $res . "<label class='form-check-label' for='1'>" . $e['nombre'] . "</label>";
                            $res = $res . "</div>";
                            $res = $res . "</td></tr> </tbody>";

                        }
                    }
                    $res = $res . "</table>";
                    $res = $res . "</div>";

                }
                return $res;
            } else {
                return '';
            }

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function validar_registro($id_usuario, $id_emprendimiento)
    {
        try {
            $resultado = $this->conex->prepare("SELECT * FROM aspirante_emprendimiento WHERE id_usuario='$id_usuario' AND id_emprendimiento='$id_emprendimiento'");
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
            $resultado = $this->conex->prepare("SELECT * FROM aspirante_emprendimiento WHERE nombre='$nombre' AND id<>'$id'");
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
            $resultado = $this->conex->prepare("SELECT * FROM aspirante_emprendimiento WHERE id='$id'");
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

}