<?php
namespace modelo;
use config\connect\connectDB as connectDB;
class ChatModelo extends connectDB
{
    private $id;
    private $nombre;

    public function incluir($id,$mensaje)
    {
        try {
            $this->conex->query("INSERT INTO chat_virtual(id_usuario,mensaje) VALUES('$id','$mensaje')");
        } catch (Exception $e) {
            $respuesta['resultado'] = 0;
            $respuesta['mensaje'] = $e->getMessage();
        }
    }

    public function eliminar($id)
    {
            try {
                $this->conex->query("DELETE from chat_virtual
						WHERE
						id = '$id'
						");
            $respuesta['resultado'] = 1;
            $respuesta['mensaje'] = "Eliminación exitosa";
            } catch (Exception $e) {
                $respuesta['resultado'] = 0;
                $respuesta['mensaje'] = $e->getMessage();
            }
        return $respuesta;
    }

    public function listar()
    {
        $resultado = $this->conex->prepare("SELECT chat_virtual.id as id,chat_virtual.id_usuario as id_usuario, usuario.cedula as cedula,usuario.primer_nombre as nombre,usuario.primer_apellido as apellido, chat_virtual.mensaje as mensajes, chat_virtual.fecha as fecha FROM chat_virtual,usuario WHERE  chat_virtual.id_usuario = usuario.id GROUP BY chat_virtual.id ORDER BY chat_virtual.fecha ASC");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function buscar($id,$mensaje)
    {
        $resultado = $this->conex->prepare("SELECT id FROM chat_virtual WHERE id_usuario ='$id' AND mensaje='$mensaje' LIMIT 1");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }
}