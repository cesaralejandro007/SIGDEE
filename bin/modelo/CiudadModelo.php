<?php
namespace modelo;
use config\connect\connectDB as connectDB;
class CiudadModelo extends connectDB
{
    private $id;
    private $id_estado;
    private $nombre;

    public function incluir($id, $id_estado, $nombre)
    {
        $validar = $this->validar_registro($id);
        if (!$validar) {
            $this->conex->query("INSERT INTO ciudades(id, id_estado, nombre) VALUES('$id', '$id_estado', '$nombre')");
        }
        return 0;
    }

    public function validar_registro($id)
    {
        try {
            $resultado = $this->conex->prepare("SELECT * FROM ciudades WHERE id='$id'");
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
    public function listadociudades($estado)
    {
        $r = array();
        try {
            $resultado = $this->conex->prepare("SELECT ciudades.id, ciudades.nombre FROM ciudades
            where id_estado =:estado");
	        $resultado->BindParam(":estado", $estado);
            $resultado->execute();
            $x = '<option disabled selected>Seleccione</option>';
            if ($resultado) {
                foreach ($resultado as $f) {
                    $x = $x . '<option value="' . $f[0] . '">' . $f[1] . '</option>';
                }
            }

            $r['resultado'] = 'listadociudades';
            $r['mensaje'] = $x;

        } catch (Exception $e) {
            $r['resultado'] = 'error';
            $r['mensaje'] = $e->getMessage();
        }
        return $r;
    }
}