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
            try {
                $sql = "INSERT INTO paises (id, nombre) VALUES (?, ?)";
                $stmt = $this->conex->prepare($sql);
                $stmt->execute([$id, $nombre]);
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }
        return 0;
    }
    

    public function validar_registro($id)
    {
        try {
            $sql = "SELECT * FROM paises WHERE id = ?";
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
    public function listadopaises()
    {
        $r = array();
        try {
            $resultado = $this->conex->prepare("SELECT paises.id, paises.nombre FROM paises");
            $resultado->execute();
            $x = '<option disabled selected>Seleccione</option>';
            if ($resultado) {
                foreach ($resultado as $f) {
                    $x = $x . '<option value="' . $f[0] . '">' . $f[1] . '</option>';
                }
            }
            $r['resultado'] = 'listadopaises';
            $r['mensaje'] = $x;
        } catch (Exception $e) {
            $r['resultado'] = 'error';
            $r['mensaje'] = $e->getMessage();
        }
        return $r;
    }

    public function listadopaises_app()
    {
        $r = array();
        try {
            $resultado = $this->conex->prepare("SELECT paises.id, paises.nombre FROM paises");
            $resultado->execute();
            $x = [];
            if ($resultado) {
                foreach ($resultado as $f) {
                    $x[] = array(
                        'value' => $f[0],
                        'text' => $f[1]
                    ); 
                }
            }
            $r['resultado'] = 'listadopaises_app';
            $r['datos'] = $x;
        } catch (Exception $e) {
            $r['resultado'] = 'error';
            $r['datos'] = $e->getMessage();

        }
        return $r;
    }
}