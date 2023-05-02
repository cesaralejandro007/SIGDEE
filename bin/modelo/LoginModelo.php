<?php
namespace modelo;
use config\connect\connectDB as connectDB;
class LoginModelo extends connectDB
{
    private $user;
    private $password;
    private $tipousuario;
    public function set_user($valor)
    {
        $this->user = $valor;
    }
    public function set_password($valor)
    {
        $this->password = $valor;
    }
    public function get_user()
    {
        return $this->user;
    }
    public function set_tipo($valor)
    {
        $this->tipousuario = $valor;
    }

    public function get_password()
    {
        return $this->password;
    }

    public function verificarU()
    {
        $resultado = $this->conex->prepare("SELECT  * FROM usuario u, usuarios_roles ur, rol r WHERE u.id = ur.id_usuario AND ur.id_rol = r.id AND r.nombre = '$this->tipousuario' AND u.cedula ='$this->user' AND u.clave ='$this->password'");
        try {
            $resultado->execute();
            $respuesta1 = $resultado->rowCount();
            if ($respuesta1 > 0) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public function datos_UserU()
    {
        $resultado = $this->conex->prepare("SELECT u.id as id, u.cedula as cedula,u.primer_nombre as primer_nombre,u.segundo_nombre as segundo_nombre, u.primer_apellido as primer_apellido,u.segundo_apellido as segundo_apellido,u.genero as genero, u.correo as correo, u.direccion as direccion, u.telefono as telefono, u.clave as clave,r.id as idrol ,r.nombre as nombreusuario FROM usuario u, usuarios_roles ur, rol r WHERE u.id = ur.id_usuario AND ur.id_rol = r.id AND r.nombre = '$this->tipousuario' AND u.cedula ='$this->user' AND u.clave ='$this->password'");
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }
    public function datos_UserRU()
    {
        $resultado = $this->conex->prepare("SELECT * FROM usuario WHERE cedula ='$this->user'");
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function listartipo_usuario()
    {
        $resultado = $this->conex->prepare("SELECT nombre FROM rol");
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