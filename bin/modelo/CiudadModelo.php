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
}