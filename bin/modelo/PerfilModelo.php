<?php
namespace modelo;
use config\connect\connectDB as connectDB;
class PerfilModelo extends connectDB
{
    private $id;
    private $telefono;
    private $correo;

    public function datos_UserU($datos)
    {
        $resultado = $this->conex->prepare("SELECT * FROM usuario WHERE cedula ='$datos'");
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function modificar($id,$telefono,$correo,$clave)
    {
        try {
            $this->conex->query("UPDATE usuario SET telefono = '$telefono', correo = '$correo', clave = '$clave' WHERE id = '$id'");
            return 1;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function cargar($id)
    {
        $resultado = $this->conex->prepare("SELECT * FROM usuario WHERE
            id = '$id'
            ");
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