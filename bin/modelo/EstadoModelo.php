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
            try {
                $sql = "INSERT INTO estados(id, id_pais, nombre) VALUES (?, ?, ?)";
                $stmt = $this->conex->prepare($sql);
                $params = [$id, $id_pais, $nombre];
                $stmt->execute($params);
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }
        return 0;
    }
    

    public function validar_registro($id)
    {
        try {
            $sql = "SELECT * FROM estados WHERE id = ?";
            $stmt = $this->conex->prepare($sql);
            $params = [$id];
            $stmt->execute($params);
    
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
            $params = [$id];
            $stmt->execute($params);
    
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

    public function listadoestados($pais)
    {
        $r = array();
        try {
            $resultado = $this->conex->prepare("SELECT estados.id, estados.nombre FROM estados
            where id_pais =:pais");
	        $resultado->BindParam(":pais", $pais);
            $resultado->execute();
            $x = '<option disabled selected>Seleccione</option>';
            if ($resultado) {
                foreach ($resultado as $f) {
                    $x = $x . '<option value="' . $f[0] . '">' . $f[1] . '</option>';
                }
            }

            $r['resultado'] = 'listadoestados';
            $r['mensaje'] = $x;

        } catch (Exception $e) {
            $r['resultado'] = 'error';
            $r['mensaje'] = $e->getMessage();
        }
        return $r;
    }

    public function listadoestados_app($pais)
    {
        $r = array();
        try {
            $resultado = $this->conex->prepare("SELECT estados.id, estados.nombre FROM estados
            where id_pais =:pais");
             $resultado->BindParam(":pais", $pais);
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
            $r['resultado'] = 'listadoestados_app';
            $r['datos'] = $x;
        } catch (Exception $e) {
            $r['resultado'] = 'error';
            $r['datos'] = $e->getMessage();

        }
        return $r;
    }
}