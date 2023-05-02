<?php
namespace modelo;
use config\connect\connectDB as connectDB;
class ChatModelo extends connectDB
{
    private $id;
    private $nombre;

    public function incluir($cedula,$mensaje)
    {
        try {
            $this->conex->query("INSERT INTO chat_virtual(cedula_usuario,mensajes) VALUES('$cedula','$mensaje')");
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
        $resultado = $this->conex->prepare("SELECT chat_virtual.id as id, chat_virtual.cedula_usuario as cedula,usuario.primer_nombre as nombre,usuario.primer_apellido as apellido, chat_virtual.mensajes as mensajes, chat_virtual.facha as fecha FROM chat_virtual,usuario WHERE  chat_virtual.cedula_usuario = usuario.cedula ORDER BY chat_virtual.facha ASC");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function buscar($cedula,$mensaje)
    {
        $resultado = $this->conex->prepare("SELECT id FROM chat_virtual WHERE cedula_usuario='$cedula' AND mensajes='$mensaje' LIMIT 1");
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