<?php
    namespace modelo;
    use config\connect\connectDB as connectDB;
class RolModelo extends connectDB
{
    private $id;
    private $nombre;

    public function incluir($nombre)
    {
        $validar_nombre = $this->existe_nombre($nombre);
        $expresiones_regulares = $this->validar_expresiones($nombre);
        if ($validar_nombre) {
            $respuesta['resultado'] = 3;
            $respuesta['mensaje'] = "El nombre ya existe.";
        }else if ($expresiones_regulares['resultado']) {
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = $expresiones_regulares['mensaje'];
        }else{
            try {
                $this->conex->query("INSERT INTO rol(
					nombre
					)
					VALUES(
					'$nombre'

				)");
            $respuesta['resultado'] = 1;
            $respuesta['mensaje'] = "Registro exitoso";
            } catch (Exception $e) {
                $respuesta['resultado'] = 0;
                $respuesta['mensaje'] =  $e->getMessage();
            }
        }
        return $respuesta;
    }

    public function modificar($id,$nombre)
    {
        $validar_modificar = $this->validar_modificar($nombre, $id);
        $expresiones_regulares = $this->validar_expresiones($nombre);
        if ($this->existe($id)==false) {
            $respuesta['resultado'] = 3;
            $respuesta['mensaje'] = "El Rol no Existe";
        }
        else if ($validar_modificar){
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = "El nombre ya se encuetra registrado";
        }else if ($expresiones_regulares['resultado']) {
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = $expresiones_regulares['mensaje'];
        }else {
            try {
                $this->conex->query("UPDATE rol SET nombre = '$nombre' WHERE id = '$id'");
                $respuesta["resultado"]=1;
                $respuesta["mensaje"]="Modificación exitosa.";
            } catch (Exception $e) {
                $respuesta["resultado"]=0;
                $respuesta["mensaje"]=$e->getMessage();
            }
        }
        return $respuesta;
    }

    public function eliminar($id)
    {       
        $validar_usuariorol = $this->validar_usuario_rol($id);
        $validar_permisosrol = $this->validar_permisos_rol($id);
        
        if ($this->existe($id)==false) {
            $respuesta['resultado'] = 4;
            $respuesta['mensaje'] = "El Rol no Existe";
        }else if ($validar_usuariorol) {
            $respuesta['resultado'] = 3;
            $respuesta['mensaje'] = "No puede ser borrado, existen usuarios registrados con este rol.";
        } else if($validar_permisosrol){
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = "No puede ser borrado, existen permisos registrados con este rol.";
        }
        else{
            try {
                $this->conex->query("DELETE from rol
					WHERE
					id = '$id'
					");
                $respuesta['resultado'] = 1;
                $respuesta['mensaje'] = "Eliminacion exitosa";
            } catch (Exception $e) {
                $respuesta["resultado"]=0;
                $respuesta["mensaje"]=$e->getMessage();
            }
        }
        return $respuesta;
    }

    public function listar()
    {        $resultado = $this->conex->prepare("SELECT id, nombre FROM rol");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function cargar($id)
    {        $resultado = $this->conex->prepare("SELECT id, nombre FROM rol WHERE
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


    public function existe_nombre($nombre)
    {        try {
            $resultado = $this->conex->prepare("SELECT * FROM rol WHERE nombre='$nombre'");
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

    public function validar_modificar($nombre, $id)
    {        try {
            $resultado = $this->conex->prepare("SELECT * FROM rol WHERE nombre='$nombre' AND id<>'$id'");
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

    public function validar_usuario_rol($id)
    {        
        try {
            $resultado = $this->conex->prepare("SELECT * FROM rol r,usuarios_roles ur,usuario u WHERE r.id= ur.id_rol and ur.id_usuario = u.id AND r.id =".$id."");
            $resultado->execute();
            $fila = $resultado->rowCount();
            if ($fila > 0) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }

    public function validar_permisos_rol($id)
    {        
        try {
            $resultado = $this->conex->prepare("SELECT * FROM permiso WHERE id_rol =".$id."");
            $resultado->execute();
            $fila = $resultado->rowCount();
            if ($fila > 0) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }
    public function existe($id)
    {        try {
            $resultado = $this->conex->prepare("SELECT * FROM rol WHERE id='$id'");
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

    public function obtener_rol($cedula, $tipouser)
    {
        $resultado = $this->conex->prepare("SELECT r.id as id, r.nombre as nombre FROM usuario u, usuarios_roles ur, rol r WHERE u.id = ur.id_usuario AND ur.id_rol = r.id AND r.nombre = '$tipouser' AND u.cedula ='$cedula'");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function validar_expresiones($nombre){
        $er_nombre = '/^[A-ZÁÉÍÓÚ][a-zñáéíóú\s]{3,30}$/';
        if(!preg_match_all($er_nombre,$nombre) || trim($nombre)==''){
            $respuesta["resultado"]=true;
            $respuesta["mensaje"]="El campo Nombre de contener solo letras de 3 a 30 caracteres, siendo la primera en mayúscula.";
        }else{
            $respuesta["resultado"]=false;
            $respuesta["mensaje"]="";
        }
        return $respuesta;
    }
}