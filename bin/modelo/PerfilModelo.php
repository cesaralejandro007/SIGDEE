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
        try {
            $sql = "SELECT * FROM usuario WHERE cedula = ?";
            $stmt = $this->conex->prepare($sql);
            $stmt->execute([$datos]);
            $respuestaArreglo = $stmt->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }
    

    public function verificarcambio_password($cedula)
    {
        try {
            $sql = "SELECT clave FROM usuario WHERE cedula = ?";
            $stmt = $this->conex->prepare($sql);
            $stmt->execute([$cedula]);
            $respuestaArreglo = $stmt->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }


    public function cambiar_password($cedula, $clave_encriptada, $preguntas_encriptadas)
    {
        try {
            $stmt = $this->conex->prepare("UPDATE usuario SET clave = ?, preguntas_seguridad = ? WHERE cedula = ?");
            $stmt->execute([$clave_encriptada, $preguntas_encriptadas, $cedula]);
            return 1; // Éxito
        } catch (Exception $e) {
            return $e->getMessage(); // Manejo de errores
        }
    }
    

    public function modificar($id, $telefono, $correo)
    {
        $validar_expresion = $this->validar_expresiones($correo, $telefono);
        if ($validar_expresion['resultado']) {
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = $validar_expresion['mensaje'];
        } else {
            try {
                // Usar una consulta preparada con un array para los valores
                $stmt = $this->conex->prepare("UPDATE usuario SET telefono = ?, correo = ? WHERE id = ?");
                $stmt->execute([$telefono, $correo, $id]);
    
                $respuesta["resultado"] = 1;
                $respuesta["mensaje"] = "Modificación exitosa.";
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
