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
            try {
                $sql = "INSERT INTO ciudades (id, id_estado, nombre) VALUES (?, ?, ?)";
                $stmt = $this->conex->prepare($sql);
                $stmt->execute([$id, $id_estado, $nombre]);
            } catch (Exception $e) {
                return $e->getMessage(); // En caso de error, devuelve el mensaje de error
            }
        }
        return 0;
    }
    public function validar_registro($id)
    {
        try {
            $sql = "SELECT * FROM ciudades WHERE id = ?";
            $stmt = $this->conex->prepare($sql);
            $stmt->execute([$id]);
            $fila = $stmt->fetchAll();
    
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
            $sql = "SELECT * FROM area_emprendimiento WHERE id = ?";
            $stmt = $this->conex->prepare($sql);
            $stmt->execute([$id]);
            $fila = $stmt->fetchAll();
    
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