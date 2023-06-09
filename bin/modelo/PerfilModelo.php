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

    public function verificarcambio_password($cedula,$clave_encriptada)
    {
        $resultado = $this->conex->prepare("SELECT * FROM usuario WHERE cedula = '$cedula' AND clave ='$clave_encriptada'");
        try {
            $resultado->execute();
            $respuesta1 = $resultado->rowCount();
           if( $respuesta1 > 0){
            return 1;
           }else{
            return 0;
           }
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function cambiar_password($cedula,$clave_encriptada,$preguntas_encriptadas)
    {   
        $resultado = $this->conex->query("UPDATE usuario SET clave = '$clave_encriptada', preguntas_seguridad = '$preguntas_encriptadas' WHERE cedula = '$cedula'");
        try {
            $resultado->execute();
            return 1;
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function modificar($id,$telefono,$correo)
    {
        try {
            $this->conex->query("UPDATE usuario SET telefono = '$telefono', correo = '$correo' WHERE id = '$id'");
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