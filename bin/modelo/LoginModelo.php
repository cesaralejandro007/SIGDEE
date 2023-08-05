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
        $resultado = $this->conex->prepare("SELECT u.id as id_usuario, r.nombre as rol FROM usuario u, usuarios_roles ur, rol r WHERE u.id = ur.id_usuario AND ur.id_rol = r.id AND r.nombre = '$this->tipousuario' AND u.cedula ='$this->user'");
        try {
            $resultado->execute();
            $respuesta1 = $resultado->rowCount();
            $datos = $resultado->fetchAll();
            $estudiante = $resultado->rowCount() ? $datos[0]['id_usuario'] : 0;
            if($datos === null) {
                return 0;
            }
            else
            if ($respuesta1 > 0 && ($datos[0]['rol']=== "Super Usuario" || $datos[0]['rol']=== "Administrador")) {
                return 1;
            }
            else
            if ($respuesta1 > 0 && $datos[0]['rol']== "Estudiante") {
                $aula_estudiante = $this->conex->prepare("SELECT  * FROM aula_estudiante WHERE id_estudiante=$estudiante");
                $aula_estudiante->execute();
                $respuesta2 = $aula_estudiante->rowCount();
                if($respuesta2 > 0){
                    return 1;
                }
                else{
                    return 2;
                }
            }
            else
            if ($respuesta1 > 0 && $datos[0]['rol']== "Docente") {
                $aula_docente = $this->conex->prepare("SELECT  * FROM aula_docente WHERE id_docente= $estudiante");
                $aula_docente->execute();
                $respuesta2 = $aula_docente->rowCount();
                if($respuesta2 > 0){
                    return 1;
                }
                else{
                    return 2;
                }
            }
            
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function datos_UserU()
    {
        $resultado = $this->conex->prepare("SELECT u.id as id, u.cedula as cedula, CONCAT(u.primer_nombre, ' ', u.segundo_nombre) as nombre, CONCAT(u.primer_apellido, ' ', u.segundo_apellido) as apellido ,u.genero as genero, u.correo as correo, u.direccion as direccion, u.telefono as telefono, u.clave as clave,r.id as idrol ,r.nombre as nombreusuario, u.ultimo_acceso as ultimo_acceso FROM usuario u, usuarios_roles ur, rol r WHERE u.id = ur.id_usuario AND ur.id_rol = r.id AND r.nombre = '$this->tipousuario' AND u.cedula ='$this->user'");
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function comprobar_usuario($cedula)
    {
        $resultado = $this->conex->prepare("SELECT * FROM usuario WHERE cedula=$cedula");
        try {
            $resultado->execute();
            $respuesta2 = $resultado->rowCount();
            if($respuesta2 > 0){
                return true;
            }
            else{
                return false;
            }
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


    public function actualizar_fecha_acceso($cedula)
    {   
        $resultado = $this->conex->query("UPDATE usuario SET ultimo_acceso = NOW()  WHERE cedula = '$cedula'");
        try {
            $resultado->execute();
            return 1;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function cambiar_password($cedula,$clave_encriptada)
    {   
        $resultado = $this->conex->query("UPDATE usuario SET clave = '$clave_encriptada' WHERE cedula = '$cedula'");
        try {
            $resultado->execute();
            return 1;
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
    
    /**************************************
    *  CREAR TOKEN DE SEGURIDAD AL ACCEDER
    **************************************/
    public function token($id, $email){
        //VALIDAR QUE ID DEL USUARIO EXISTA EN LA BD
        if ($this->existe($id)==false) {
            $respuesta['resultado'] = 4;
            $respuesta['mensaje'] = "El Usuario no Existe";
        }
        else {
            //ESTABLECER LA ZONA HORARIA
            date_default_timezone_set('America/Caracas');
            $time = time();

            //CREAR LA FECHA DE EXPIRACION (A 1 HORA)
            $fecha = date('Y-m-d H:i:s', $time + (60*60));
            //CREAR EL TOKEN CON RESPECTO A LA FECHA EN UNIX, CORREO Y ID DE USUARIO
            $token = hash("sha256", $time . $email. $id);
            try {
                $this->conex->query("UPDATE usuario SET token = '$token', fecha_expiracion = '$fecha' WHERE id = '$id'");
                $respuesta['resultado'] = 1;
                $respuesta['mensaje'] = "Modificación exitosa";
                $respuesta['token'] = $token;
            } catch (Exception $e) {
                $respuesta['resultado'] = 0;
                $respuesta['mensaje'] = $e->getMessage();
            }
        }
        return $respuesta;
    }

    public function existe($id)
    {
        try {
            $resultado = $this->conex->prepare("SELECT * FROM usuario WHERE id='$id'");
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