<?php
namespace modelo;
use config\connect\connectDB as connectDB;
class PaisModelo extends connectDB
{
    private $id;
    private $nombre;

    public function incluir($id, $nombre)
    {
        $validar_pais = $this->validar_registro($id);
        if (!$validar_pais) {
            $this->conex->query("INSERT INTO paises(id, nombre) VALUES('$id', '$nombre')");
        }
        return 0;
    }

    public function validar_registro($id)
    {
        try {
            $resultado = $this->conex->prepare("SELECT * FROM paises WHERE id='$id'");
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