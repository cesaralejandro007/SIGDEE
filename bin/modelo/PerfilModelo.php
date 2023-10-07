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

    public function verificarcambio_password($cedula)
    {
        $resultado = $this->conex->prepare("SELECT clave FROM usuario WHERE cedula = '$cedula'");
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
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
        $validar_expresion = $this->validar_expresiones($correo,$telefono);
        if ($validar_expresion['resultado']) {
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = $validar_expresion['mensaje'];
        }else{
            try {
                $this->conex->query("UPDATE usuario SET telefono = '$telefono', correo = '$correo' WHERE id = '$id'");
                $respuesta["resultado"]=1;
                $respuesta["mensaje"]="Modificación exitosa.";
            } catch (Exception $e) {
                $respuesta['resultado'] = 0;
                $respuesta['mensaje'] = $e->getMessage();
            }
        }
        return $respuesta;
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
    public function validar_expresiones($correo,$telefono){
        $er_correo = '/^[A-Za-z0-9]{3,40}[@]{1}[A-Za-z0-9]{3,8}[.]{1}[A-Za-z]{2,4}$/';
        $er_telefono= '/^[0-9]{10,11}$/';
        
        if(!preg_match_all($er_telefono,$telefono) || trim($telefono)==''){
            $respuesta["resultado"]=true;
            $respuesta["mensaje"]="El campo telefono debe contener Solo numeros de 11 digitos";
        }else if(!preg_match_all($er_correo,$correo) || trim($correo)==''){
            $respuesta["resultado"]=true;
            $respuesta["mensaje"]="El campo Correo debe ser ejemplo@gmail.com";
        }else{
            $respuesta["resultado"]=false;
            $respuesta["mensaje"]="";
        }
        return $respuesta;
    }
}
