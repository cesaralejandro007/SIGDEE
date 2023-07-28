<?php
namespace modelo;
use config\connect\connectDB as connectDB;
class EstadoModelo extends connectDB
{
    private $id;
    private $id_pais;
    private $nombre;

    public function incluir($id, $id_pais, $nombre)
    {
        $validar = $this->validar_registro($id);
        if (!$validar) {
            $this->conex->query("INSERT INTO estados(id, id_pais, nombre) VALUES('$id', '$id_pais', '$nombre')");
        }
        return 0;
    }

    public function validar_registro($id)
    {
        try {
            $resultado = $this->conex->prepare("SELECT * FROM estados WHERE id='$id'");
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