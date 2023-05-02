<?php
namespace modelo;
use config\connect\connectDB as connectDB;
class UsuarioModelo extends connectDB
{
    private $id;
    private $id_usuario;
    private $cedula;
    private $nombre;
    private $apellido;
    private $correo;
    private $direccion;
    private $telefono;
    private $imagen;
    private $id_rol;
    private $status;

    public function incluir($cedula,$primer_nombre,$segundo_nombre,$primer_apellido,$segundo_apellido,$genero,$correo,$direccion,$telefono)
    {
        $validar_registro = $this->validar_registro($cedula);
        $validar_expresion = $this->validar_expresiones($cedula,$primer_nombre,$segundo_nombre,$primer_apellido,$segundo_apellido,$genero,$correo,$direccion,$telefono);
        if ($validar_registro==false) {
            $respuesta["resultado"]=3;
            $respuesta["mensaje"]="La cedula ya se encuentra registrada.";
        }else if ($validar_expresion['resultado']) {
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = $validar_expresion['mensaje'];
        } else {
            try {
                $this->conex->query("INSERT INTO usuario(cedula, primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,genero,correo, direccion, telefono)
					VALUES('$cedula', '$primer_nombre','$segundo_nombre', '$primer_apellido','$segundo_apellido','$genero', '$correo', '$direccion','$telefono')");
                $respuesta["resultado"]=1;
                $respuesta["mensaje"]="Registro Exitoso.";
            } catch (Exception $e) {
                $respuesta['resultado'] = 0;
                $respuesta['mensaje'] = $e->getMessage();
            }
        }
        return $respuesta;
    }

    public function registrar_aspirante($cedula,$nombre,$apellido,$correo)
    {
        $validar_registro = $this->validar_registro($cedula);
        if ($validar_registro) {
            $respuesta["resultado"]=2;
            $respuesta["mensaje"]="La cedula ya se encuentra registrada.";
        } else {
            try {
                $this->conex->query("INSERT INTO usuario(cedula, nombre,  apellido, correo)
                    VALUES('$cedula', '$nombre', '$apellido', '$correo')");
                    $respuesta["resultado"]=1;
                    $respuesta["mensaje"]="Registro Exitoso.";
            } catch (Exception $e) {
                $respuesta['resultado'] = 0;
                $respuesta['mensaje'] = $e->getMessage();
            }
        }
        return $respuesta;
    }

    public function gestionarrol($id_usuario,$id_rol,$status)
    {
        $validar = $this->validarrol($id_rol, $id_usuario);
        if ($validar == false and $status == "true") {
            try {
                $this->conex->query("INSERT INTO usuarios_roles(
                    id_usuario,
                    id_rol
					)
					VALUES(
                    '$id_usuario',
					'$id_rol'
				)");
                $respuesta["resultado"]=1;
                $respuesta["mensaje"]="Roles Registrados.";
            } catch (Exception $e) {
                $respuesta['resultado'] = 0;
                $respuesta['mensaje'] = $e->getMessage();
            }
        } else if ($validar == true and $status == "false") {
            try {
                $this->conex->query("DELETE from usuarios_roles
					WHERE
					id_usuario = '$id_usuario' and id_rol = '$id_rol'
					");
                $respuesta["resultado"]=2;
                $respuesta["mensaje"]="Roles Eliminados.";
            } catch (Exception $e) {
                $respuesta['resultado'] = 0;
                $respuesta['mensaje'] = $e->getMessage();
            }
        } else {
                $respuesta["resultado"]=1;
                $respuesta["mensaje"]="Registro Exitoso.";
        }
        return $respuesta;
    }

    public function modificar($id,$cedula,$primer_nombre,$segundo_nombre,$primer_apellido,$segundo_apellido,$genero,$correo,$direccion,$telefono)
    {
        $validar_modificar = $this->validar_modificar($cedula, $id);
        $validar_expresion = $this->validar_expresiones($cedula,$primer_nombre,$segundo_nombre,$primer_apellido,$segundo_apellido,$genero,$correo,$direccion,$telefono);
        if ($this->existe_usuario_rol($cedula)==false) {
            $respuesta['resultado'] = 4;
            $respuesta['mensaje'] = "El Usuario no Existe";
            return $respuesta;
        }
        else if ($validar_modificar) {
            $respuesta['resultado'] = 3;
            $respuesta['mensaje'] = "La cedula ya se encuetra registrada.";
        }else if ($validar_expresion['resultado']) {
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = $validar_expresion['mensaje'];
        }  else {
            try {
                $this->conex->query("UPDATE usuario  SET cedula = '$cedula', primer_nombre = '$primer_nombre', segundo_nombre = '$segundo_nombre', genero = '$genero',correo = '$correo',  direccion = '$direccion', primer_apellido = '$primer_apellido', segundo_apellido = '$segundo_apellido',telefono = '$telefono' WHERE id = '$id'");
                $respuesta["resultado"]=1;
                $respuesta["mensaje"]="Modificación exitosa.";
            } catch (Exception $e) {
                $respuesta['resultado'] = 0;
                $respuesta['mensaje'] = $e->getMessage();
            }
        }
        return $respuesta;
    }

    public function eliminar($cedula,$id)
    {
   
        $validacion_rol = $this->validar_relacion_rol($cedula);
        $validacion_Aspirante = $this->validar_relacion_aspirante($id);
        $validacion_Censo = $this->validar_relacion_censo($id);
        $validacion_evalucion = $this->validar_estudiante_evaluacion($id);
        $validacion_aula_estudiante = $this->validar_estudiante_aula($id);
        if ($this->existe_usuario_rol($cedula)==false) {
            $respuesta['resultado'] = 6;
            $respuesta['mensaje'] = "El Usuario no Existe";
            return $respuesta;
        }else{
            if ($validacion_rol){
                $respuesta["resultado"]=6;
                $respuesta["mensaje"]="El Usuario no puede ser borrado, existe un vinculo con Rol.";
                return $respuesta;
            }else if($validacion_Aspirante){
                $respuesta["resultado"]=5;
                $respuesta["mensaje"]="El Usuario no puede ser borrado, existe un vinculo con Aspirante.";
                return $respuesta;
            }else if($validacion_Censo){
                $respuesta["resultado"]=4;
                $respuesta["mensaje"]="El Usuario no puede ser borrado, existe un vinculo con Censo.";
                return $respuesta;
            }else if($validacion_aula_estudiante){
                $respuesta["resultado"]=3;
                $respuesta["mensaje"]="El Usuario no puede ser borrado, existe un vinculo con Aula Estudiante.";
                return $respuesta;
            }else if($validacion_evalucion){
                $respuesta["resultado"]=2;
                $respuesta["mensaje"]="El Usuario no puede ser borrado, existe un vinculo con Evaluacion de Estudiante.";
                return $respuesta;
            }else{
                try {
                    $this->conex->query("DELETE from usuario WHERE cedula = '$cedula'");
                    $respuesta['resultado'] = 1;
                    $respuesta['mensaje'] = "Eliminacion exitosa";
                    return $respuesta;
                } catch (Exception $e) {
                    $respuesta['resultado'] = 0;
                    $respuesta['mensaje'] = $e->getMessage();
                }
            } 
        } 
    }

    public function validar_relacion_rol($cedula)
    {
        try {
            $resultado = $this->conex->prepare("SELECT * FROM usuario,usuarios_roles,rol WHERE usuario.id = usuarios_roles.id_usuario and rol.id = usuarios_roles.id_rol AND usuario.cedula ='". $cedula ."'");
            $resultado->execute();
            $fila = $resultado->rowCount();
            if ($fila > 0) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return 'false';
        }
    }

    public function validar_relacion_aspirante($id)
    {
        try {
            $resultado = $this->conex->prepare("SELECT * FROM aspirante_emprendimiento WHERE id_usuario ='".$id."'");
            $resultado->execute();
            $fila = $resultado->fetchAll();
            if ($fila) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return 'false';
        }
    }
    public function validar_relacion_censo($id)
    {
        try {
            $resultado = $this->conex->prepare("SELECT * FROM censo WHERE id_usuario ='".$id."'");
            $resultado->execute();
            $fila = $resultado->fetchAll();
            if ($fila) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return 'false';
        }
    }

    public function validar_estudiante_evaluacion($id)
    {
        try {
            $resultado = $this->conex->prepare("SELECT * FROM estudiante_evaluacion WHERE id_usuario ='".$id."'");
            $resultado->execute();
            $fila = $resultado->fetchAll();
            if ($fila) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return 'false';
        }
    }

    public function validar_estudiante_aula($id)
    {
        try {
            $resultado = $this->conex->prepare("SELECT * FROM aula_estudiante WHERE id_estudiante ='".$id."'");
            $resultado->execute();
            $fila = $resultado->fetchAll();
            if ($fila) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return 'false';
        }
    }

    public function listar()
    {
        $resultado = $this->conex->prepare("SELECT * FROM usuario");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }


    public function cargar_rol()
    {
        try {
            $modulo = $this->conex->query("SELECT * from rol");
            if ($modulo) {
                return $modulo;
            } else {
                return '';
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function cargar($id)
    {
        $resultado = $this->conex->prepare("SELECT id, cedula, primer_nombre, segundo_nombre,primer_apellido, segundo_apellido, genero, correo, direccion, telefono, clave, imagen FROM usuario WHERE id = '$id'");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function buscar_cedula($cedula)
    {
        $resultado = $this->conex->prepare("SELECT *FROM usuario WHERE cedula ='$cedula'; ");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function buscar_id($id)
    {
        $result = 0;
        try {
            $resultado = $this->conex->query("SELECT id FROM usuario WHERE id ='$id';");
            if($resultado){
                foreach($resultado as $r){
                  $result = $r['id'];  
                }
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $result;
    }

    public function validar_registro($cedula)
    {
        try {
            $resultado = $this->conex->prepare("SELECT * FROM usuario WHERE cedula='$cedula'");
            $resultado->execute();
            $fila = $resultado->fetchAll();
            if ($fila) {
                return false;
            } else {
                return true;
            }
        } catch (Exception $e) {
            return false;
        }
    }

    public function existe_usuario_rol($cedula)
    {
        try {
            $resultado = $this->conex->prepare("SELECT * FROM usuario WHERE cedula='$cedula'");
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

    public function validar_modificar($cedula, $id)
    {
        try {
            $resultado = $this->conex->prepare("SELECT * FROM usuario WHERE cedula='$cedula' AND id<>'$id'");
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

    public function validarrol($id_rol, $id_usuario)
    {
        $resultado = $this->conex->prepare("SELECT * FROM usuarios_roles WHERE usuarios_roles.id_rol = '$id_rol' and usuarios_roles.id_usuario = '$id_usuario'");
        try {
            $resultado->execute();
            $respuesta1 = $resultado->rowCount();
            if ($respuesta1 > 0) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }

    public function crolesuser($id)
    {
        $resultado = $this->conex->prepare("SELECT r.id as id_rol, u.cedula as cedula, r.nombre as nombre FROM usuario u ,usuarios_roles ur ,rol r WHERE u.id = ur.id_usuario and r.id = ur.id_rol and u.id ='$id'
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

    public function validar_expresiones($cedula,$primer_nombre,$segundo_nombre,$primer_apellido,$segundo_apellido,$genero,$correo,$direccion,$telefono){
        $er_cedula = '/^[0-9]{7,8}$/';
        $er_nombre = '/^[A-ZÁÉÍÓÚ][a-zñáéíóú\s]{2,30}$/';
        $er_genero = '/^[A-ZÁÉÍÓÚ][a-zñáéíóú]{7,8}$/';
        $er_correo = '/^[A-Za-z0-9]{3,25}[@]{1}[A-Za-z0-9]{3,8}[.]{1}[A-Za-z]{2,4}$/';
        $er_telefono= '/^[0-9]{10,11}$/';
        $er_direccion = '/^[A-ZÁÉÍÓÚa-zñáéíóú0-9,.#%$^&*:\s]{2,200}$/';
        if(!preg_match_all($er_cedula,$cedula) || trim($cedula)==''){
            $respuesta["resultado"]=true;
            $respuesta["mensaje"]="El campo Cedula debe ser 99999999 y solo de 7 a 8 caracteres";
        }else if(!preg_match_all($er_nombre,$primer_nombre) || trim($primer_nombre)==''){
            $respuesta["resultado"]=true;
            $respuesta["mensaje"]="El campo Primer nombre debe contener solo letras de 2 a 30 caracteres, siendo la primera en mayúscula.";
        }else if(!preg_match_all($er_nombre,$segundo_nombre) || trim($segundo_nombre)==''){
            $respuesta["resultado"]=true;
            $respuesta["mensaje"]="El campo Segundo nombre debe contener solo letras de 2 a 30 caracteres, siendo la primera en mayúscula.";
        }else if(!preg_match_all($er_nombre,$primer_apellido) || trim($primer_apellido)==''){
            $respuesta["resultado"]=true;
            $respuesta["mensaje"]="El campo Primer apellido debe contener solo letras de 2 a 30 caracteres, siendo la primera en mayúscula.";
        }else if(!preg_match_all($er_nombre,$segundo_apellido) || trim($segundo_apellido)==''){
            $respuesta["resultado"]=true;
            $respuesta["mensaje"]="El campo Segundo apellido debe contener solo letras de 2 a 30 caracteres, siendo la primera en mayúscula.";
        }else if(!preg_match_all($er_genero,$genero) || trim($genero)==''){
            $respuesta["resultado"]=true;
            $respuesta["mensaje"]="Debe seleccionar un Genero.";
        }else if(!preg_match_all($er_telefono,$telefono) || trim($telefono)==''){
            $respuesta["resultado"]=true;
            $respuesta["mensaje"]="El campo telefono debe contener Solo numeros de 11 digitos";
        }
        else if(!preg_match_all($er_correo,$correo) || trim($correo)==''){
            $respuesta["resultado"]=true;
            $respuesta["mensaje"]="El campo Correo debe ser ejemplo@gmail.com";
        }else if(!preg_match_all($er_direccion,$direccion) || trim($direccion)==''){
            $respuesta["resultado"]=true;
            $respuesta["mensaje"]="El campo dirección debe contener Solo letras de 2 a 200 caracteres, siendo la primera en mayúscula.";
        }else{
            $respuesta["resultado"]=false;
            $respuesta["mensaje"]="";
        }
        return $respuesta;
    }
}