<?php
namespace modelo;
use config\connect\connectDB as connectDB;
class AulaDocenteModelo extends connectDB
{
    private $id;
    private $id_aula;
    private $id_docente;

    public function incluir($id_aula, $id_docente)
    {
        $this->id_aula = $id_aula;
        $this->id_docente = $id_docente;

        try {
            $this->conex->query("INSERT INTO aula_docente(
				id_aula, id_docente)
			VALUES('$this->id_aula', '$this->id_docente')");
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }

    }

    public function modificar($id_docente, $id)
    {
        $this->id_docente = $id_docente;
        $this->id = $id;
            try {
                $this->conex->query("UPDATE aula_docente SET id_docente = '$this->id_docente' WHERE id = '$this->id'");
                return true;
            } catch (Exception $e) {
                return $e->getMessage();
            }
    }

    public function eliminar($id)
    {
        $this->id = $id;

        if ($this->existe()) {
            try {
                $this->conex->query("DELETE from aula_docente
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
        $resultado = $this->conex->prepare("SELECT a.id as id_docente, t.id as id, t.id_aula as id_aula, a.id_aula as area FROM aula_docente t INNER JOIN area_emprendimiento a ON a.id= t.id_docente");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }
    public function buscar($id_docente, $id_aula)
    {
        $this->id_docente = $id_docente;
        $this->id_aula = $id_aula;

        $resultado = $this->conex->prepare("SELECT tm.id as id, t.nombre as tipo, m.nombre as modelo FROM aula_docente as t INNER JOIN tipo_modulo as tm ON t.id= tm.id_docente INNER JOIN modulo_emprendimiento as m ON m.id=tm.id_aula WHERE t.id= '$this->id_docente' AND m.id='$this->id_aula'");
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
            $resul = $this->conex->query("SELECT m.nombre as nombre, m.id as id FROM aula_docente as t INNER JOIN tipo_modulo as tm ON t.id= tm.id_docente 	INNER JOIN modulo_emprendimiento as m ON m.id=tm.id_aula WHERE t.id='$id_tipo'");
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
    public function mostrar_tipos($id_docente)
    {
        $this->id_docente = $id_docente;

        try {
            $resul = $this->conex->query("SELECT t.id_aula as id_aula, t.id as id 	FROM aula_docente as t INNER JOIN area_emprendimiento as a ON a.id= t.id_docente WHERE a.id = '$this->id_docente'");
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
            $resultado = $this->conex->prepare("SELECT * FROM aula_docente WHERE id_aula='$id_aula'");
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
            $resultado = $this->conex->prepare("SELECT * FROM aula_docente WHERE id='$this->id'");
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

    //Cargar las areas de emprendimiento que imparte el docente
    public function docente_areas($cedula)
    {
        $resultado = $this->conex->prepare("SELECT ae.id as id ,ae.nombre as nombre FROM usuario u INNER JOIN aula_docente ad ON u.id=ad.id_docente INNER JOIN aula a ON a.id=ad.id_aula INNER JOIN emprendimiento_modulo em ON a.id_emprendimiento_modulo=em.id INNER JOIN emprendimiento e ON e.id=em.id_emprendimiento INNER JOIN area_emprendimiento ae ON e.id_area=ae.id WHERE u.cedula='$cedula' GROUP BY ae.id");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    //Cargar los emprendimientos que imparte el docente segun el area de emprendimiento
    public function docente_emprendimientos($cedula, $area)
    {
        $resultado = $this->conex->prepare("SELECT e.id as id ,e.nombre as nombre FROM usuario u INNER JOIN aula_docente ad ON u.id=ad.id_docente INNER JOIN aula a ON a.id=ad.id_aula INNER JOIN emprendimiento_modulo em ON a.id_emprendimiento_modulo=em.id INNER JOIN emprendimiento e ON e.id=em.id_emprendimiento INNER JOIN area_emprendimiento ae ON e.id_area=ae.id WHERE u.cedula='$cedula' AND ae.id='$area' GROUP BY e.id;");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    //Cargar los cursos que imparte el docente segun el emprendimiento
    public function listar_modulos($cedula, $area, $emprendimiento)
    {
        $resultado = $this->conex->prepare("SELECT a.id as id ,m.nombre as nombre FROM usuario u INNER JOIN aula_docente ad ON u.id=ad.id_docente INNER JOIN aula a ON a.id=ad.id_aula INNER JOIN emprendimiento_modulo em ON a.id_emprendimiento_modulo=em.id INNER JOIN emprendimiento e ON e.id=em.id_emprendimiento INNER JOIN area_emprendimiento ae ON e.id_area=ae.id INNER JOIN modulo m ON em.id_modulo=m.id WHERE u.cedula='$cedula' AND ae.id='$area' AND e.id='$emprendimiento'");
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
        $this->id_aula = $id_aula;
        $resultado = $this->conex->prepare("SELECT  u.cedula as cedula, u.id as id, CONCAT(u.primer_nombre, ' ', u.segundo_nombre) as nombre, CONCAT(u.primer_apellido, ' ', u.segundo_apellido) as apellido, u.imagen as foto FROM aula a INNER JOIN aula_docente ae ON a.id=ae.id_aula INNER JOIN usuario u ON u.id= ae.id_docente WHERE a.id=' $this->id_aula'");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

        public function listadodocentes()
    {
        $r = array();
        try {

            $resultado = $this->conex->prepare("select u.id, concat(u.cedula,' / ',u.primer_apellido, ' ',u.segundo_apellido, ' ',u.primer_nombre, ' ',u.segundo_nombre) as usuarios from usuario as u, rol as r, usuarios_roles as ur where u.id=ur.id_usuario and ur.id_rol=r.id and r.nombre='Docente';");

            $resultado->execute();

            $x = '<option disabled selected>Seleccione</option>';
            if ($resultado) {

                foreach ($resultado as $f) {
                    $x = $x . '<option value="' . $f[0] . '">' . $f[1] . '</option>';
                }

            }

            $r['resultado'] = 'listadodocentes';
            $r['mensaje'] = $x;

        } catch (Exception $e) {
            $r['resultado'] = 'error';
            $r['mensaje'] = $e->getMessage();

        }
        return $r;
    }

    public function listadodocentes_aula($id_aula, $id_docente)
    {
        $r = array();
        try {
            $id_docente_aula = 0;
            $nombre_aula = '';
            $docente_aula = $this->conex->prepare("select ad.id, a.nombre from aula_docente ad INNER JOIN aula a on a.id=ad.id_aula WHERE ad.id_aula=:id_aula AND ad.id_docente=:id_docente;");
            $docente_aula->BindParam(':id_aula', $id_aula);
            $docente_aula->BindParam(':id_docente', $id_docente);
            $docente_aula->execute();
            foreach($docente_aula as $da){
                $id_docente_aula = $da[0];
                $nombre_aula = $da[1];
            }

            $existente = $this->conex->prepare("select d.id as id from usuario as d INNER JOIN aula_docente as b on d.id=b.id_docente INNER JOIN aula as a ON a.id=b.id_aula INNER JOIN emprendimiento_modulo as em ON a.id_emprendimiento_modulo=em.id INNER JOIN emprendimiento as emp ON emp.id=em.id_emprendimiento WHERE a.id=:id_aula;");
            $existente->BindParam(':id_aula', $id_aula);
            $existente->execute();

            $resultado = $this->conex->prepare("select u.id, concat(u.cedula,' / ',u.primer_apellido, ' ',u.segundo_apellido, ' ',u.primer_nombre, ' ',u.segundo_nombre) as usuarios from usuario as u, rol as r, usuarios_roles as ur where u.id=ur.id_usuario and ur.id_rol=r.id and r.nombre='Docente';");
            $resultado->execute();

            $x = '';
            if ($resultado) {
                $encontro = false;
                foreach ($resultado as $f) {
                    foreach ($existente as $d) {
                        if ($f[0] == $d['id']) {
                            $x = $x . '<option value="' . $f[0] . '" selected>' . $f[1] . '</option>';
                            $encontro = true;
                        }

                    }
                    if ($encontro == false) {
                        $x = $x . '<option value="' . $f[0] . '">' . $f[1] . '</option>';
                    }

                    $encontro = false;
                }

            }

            $r['resultado'] = 'listadodocentes_aula';
            $r['mensaje'] = $x;
            $r['aula'] = $id_aula;
            $r['docente_aula'] = $id_docente_aula;
            $r['nombre_aula'] = $nombre_aula;

        } catch (Exception $e) {
            $r['resultado'] = 'error';
            $r['mensaje'] = $e->getMessage();

        }
        return $r;
    }
}