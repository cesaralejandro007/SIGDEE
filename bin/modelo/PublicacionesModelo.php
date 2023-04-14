<?php
namespace modelo;
use config\connect\connectDB as connectDB;
class PublicacionesModelo extends connectDB
{
    private $id;
    private $titulo;
    private $mensaje;
    private $archivo;
    private $id_aula;
    private $cedula_usuario;


    public function incluir($titulo,$mensaje,$id_aula,$cedula_usuario)
    {
            try {
                $this->conex->query("INSERT INTO publicacion(
					titulo,
					mensaje,
                    id_aula,
                    cedula_usuario
					)
				VALUES(
					'$titulo',
					'$mensaje',
                    '$id_aula',
                    '$cedula_usuario'
				)");
                $respuesta['resultado'] = 1;
                $respuesta['mensaje'] = "Registro exitoso";
            } catch (Exception $e) {
                return $e->getMessage();
            }
        return $respuesta;
    }

    public function modificar($id,$titulo,$mensaje,$id_aula)
    {
        try {
            $this->conex->query("UPDATE publicacion SET titulo= '$titulo',mensaje = '$mensaje' ,id_aula = '$id_aula' WHERE id = '$id'");
            $respuesta['resultado'] = 1;
            $respuesta['mensaje'] = "Modificación exitosa";
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuesta;
    }

    public function eliminar($id)
    {
        if ($this->existe($id)==false) {
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = "La publicación no Existe";
        } else {
            try {
                $this->conex->query("DELETE from publicacion
					WHERE
					id = '$id'
					");
                $respuesta['resultado'] = 1;
                $respuesta['mensaje'] = "Eliminación exitosa";
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }
        return $respuesta;
    }

    public function listarpublicacion($id)
    {
        $resultado = $this->conex->prepare("SELECT p.id as id, p.titulo as titulo, p.mensaje as mensaje, date_format(p.fecha, '%d-%m-%Y %H:%m:%s') as fecha, u.nombre as nombre, u.apellido as apellido, p.cedula_usuario as cedula FROM publicacion p INNER JOIN usuario u ON p.cedula_usuario= u.cedula WHERE id_aula='$id' ORDER BY p.fecha");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $num = $resultado->rowCount();
            $respuestaArreglo = $resultado->fetchAll();
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
        $resultado = $this->conex->prepare("SELECT * FROM publicacion WHERE id = '$id'");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }


    public function validar_registro($nombre)
    {
        try {
            $resultado = $this->conex->prepare("SELECT * FROM Unidad WHERE nombre='$nombre'");
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
            $resultado = $this->conex->prepare("SELECT * FROM publicacion WHERE id='$id'");
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