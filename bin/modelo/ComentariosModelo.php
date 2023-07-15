<?php
namespace modelo;
use config\connect\connectDB as connectDB;
class ComentariosModelo extends connectDB
{
    private $id;
    private $mensaje;
    private $id_publicacion;
    private $fecha;
    private $cedula_usuario;


    public function incluir($mensaje, $id_publicacion, $cedula_usuario)
    {
        $this->mensaje = $mensaje;
        $this->id_publicacion = $id_publicacion;
        $this->cedula_usuario = $cedula_usuario;
            
        try {
            $this->conex->query("INSERT INTO comentario(
				mensaje,
                id_publicacion,
                cedula_usuario
				)
				VALUES(
					'$this->mensaje',
                    '$this->id_publicacion',
                    '$this->cedula_usuario'
				)");
                $respuesta['resultado'] = 1;
                $respuesta['mensaje'] = "Registro exitoso";
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuesta;
    }

    public function modificar($id, $mensaje)
    {
        $this->mensaje = $mensaje;
        $this->id = $id;

        try {
            $this->conex->query("UPDATE comentario SET mensaje = '$mensaje' WHERE id = '$id'");
            $respuesta['resultado'] = 1;
            $respuesta['mensaje'] = "Modificacion exitosa";
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuesta;
    }

    public function eliminar($id)
    {
        $this->id = $id;
        if ($this->existe($id)==false) {
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = "El comentario no existe";
        } else {
            try {
                $this->conex->query("DELETE from comentario
					WHERE
					id = '$this->id'
					");
                $respuesta['resultado'] = 1;
                $respuesta['mensaje'] = "Eliminación exitosa";
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }
        return $respuesta;
    }

    public function listarcomentario($id)
    {
        $resul = $this->conex->prepare("SELECT c.id as id, c.mensaje as mensaje, date_format(c.fecha, '%d-%m-%Y %H:%m:%s') as fecha, u.primer_nombre as nombre, u.primer_apellido as apellido, c.cedula_usuario as cedula, c.id_publicacion as id_publicacion FROM comentario c INNER JOIN usuario u ON c.cedula_usuario= u.cedula WHERE id_publicacion='$id' ORDER BY c.fecha");
        try {
            $resul->execute();
            $num = $resul->rowCount();
            $respuestaArreglo = $resul->fetchAll();
            if ($num > 0) {
                return $respuestaArreglo;
            } else {
                return 'false';
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }

    }

    public function cargar($id)
    {
        $resultado = $this->conex->prepare("SELECT * FROM comentario WHERE id = '$id'");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }


    public function validar_registro($id)
    {
        try {
            $resultado = $this->conex->prepare("SELECT * FROM comentario WHERE id='$id'");
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

    private function existe($id)
    {
        try {
            $resultado = $this->conex->prepare("SELECT * FROM comentario WHERE id='$id'");
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