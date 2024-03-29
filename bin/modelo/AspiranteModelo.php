<?php
namespace modelo;
use config\connect\connectDB as connectDB;
class AspiranteModelo extends connectDB
{
    private $id;
    private $id_usuario;
    private $cedula;
    private $id_ciudad;
    private $nombre;
    private $apellido;
    private $correo;
    private $direccion;
    private $telefono;
    private $imagen;
    private $id_rol;
    private $status;

    public function registrar_aspirante($cedula, $id_ciudad, $primer_nombre, $segundo_nombre, $primer_apellido, $segundo_apellido, $genero, $correo, $direccion, $telefono, $clave)
    {
        $validar_expresion = $this->validar_expresiones($cedula,$primer_nombre,$segundo_nombre,$primer_apellido,$segundo_apellido,$genero,$correo,$direccion,$telefono);
         if ($validar_expresion['resultado']) {
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = $validar_expresion['mensaje'];
        } else {
            try {
                $query = "INSERT INTO usuario(
                    cedula,
                    id_ciudad,
                    primer_nombre,
                    segundo_nombre,
                    primer_apellido,
                    segundo_apellido,
                    genero,
                    correo,
                    direccion,
                    telefono,
                    clave
                )
                VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
                $stmt = $this->conex->prepare($query);
                $stmt->execute([$cedula, $id_ciudad, $primer_nombre, $segundo_nombre, $primer_apellido, $segundo_apellido, $genero, $correo, $direccion, $telefono, $clave]);
        
                $respuesta["resultado"]=1;
                $respuesta["mensaje"]="Registro Exitoso.";
            } catch (Exception $e) {
                $respuesta['resultado'] = 0;
                $respuesta['mensaje'] = $e->getMessage();
            }
        }
        return $respuesta;
    }
    

    public function modificar($id, $cedula, $id_ciudad, $primer_nombre, $segundo_nombre, $primer_apellido, $segundo_apellido, $genero, $correo, $direccion, $telefono)
    {
        $expresiones_regulares = $this->validar_expresiones($cedula, $primer_nombre, $segundo_nombre, $primer_apellido, $segundo_apellido, $genero, $correo, $direccion, $telefono);
        $validar_modificar = $this->validar_modificar($cedula, $id);
        $validar_expresionID = $this->validar_expresion_id($id);
        
        if ($validar_expresionID['resultado']) {
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = $validar_expresionID['mensaje'];
        } else if ($this->existe($id) == false) {
            $respuesta['resultado'] = 4;
            $respuesta['mensaje'] = "El Usuario no Existe";
        } else if ($validar_modificar) {
            $respuesta['resultado'] = 3;
            $respuesta['mensaje'] = "La Cédula ya existe";
        } else if ($expresiones_regulares['resultado']) {
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = $expresiones_regulares['mensaje'];
        } else {
            try {
                $query = "UPDATE usuario SET cedula = ?, id_ciudad = ?, primer_nombre = ?, segundo_nombre = ?, primer_apellido = ?, segundo_apellido = ?, genero = ?, telefono = ?, correo = ?, direccion = ? WHERE id = ?";
                $stmt = $this->conex->prepare($query);
                $stmt->execute([$cedula, $id_ciudad, $primer_nombre, $segundo_nombre, $primer_apellido, $segundo_apellido, $genero, $telefono, $correo, $direccion, $id]);
                
                $respuesta['resultado'] = 1;
                $respuesta['mensaje'] = "Modificación exitosa";
            } catch (Exception $e) {
                $respuesta['resultado'] = 0;
                $respuesta['mensaje'] = $e->getMessage();
            }
        }
        return $respuesta;
    }
    
    public function eliminar($id)
    {
        $validar_expresionID = $this->validar_expresion_id($id);
        
        if ($validar_expresionID['resultado']) {
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = $validar_expresionID['mensaje'];
        } else if ($this->existe($id) == false) {
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = "El Usuario no Existe";
        } else {
            try {
                $query = "DELETE FROM aspirante_emprendimiento WHERE id_usuario = ?";
                $stmt = $this->conex->prepare($query);
                $stmt->execute([$id]);
                
                $respuesta["resultado"] = 1;
                $respuesta["mensaje"] = "Eliminación exitosa";
            } catch (Exception $e) {
                $respuesta['resultado'] = 0;
                $respuesta['mensaje'] = $e->getMessage();
            }
        }
        return $respuesta;
    }    

    public function listar()
    {
        $resultado = $this->conex->prepare("SELECT * FROM aspirante_emprendimiento ae INNER JOIN usuario u on ae.id_usuario = u.id GROUP BY u.id");
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
    {
        $resultado = $this->conex->prepare("SELECT * FROM usuario WHERE id = '$id'");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
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

    public function validar_expresion_id($id){
        if(!preg_match('/^[0-9]+$/', $id)){
            $respuesta["resultado"]=true;
            $respuesta["mensaje"]="El campo ID solo debe contener números";
        }else{
            $respuesta["resultado"]=false;
            $respuesta["mensaje"]="";
        }
        return $respuesta;
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
        }else if(!preg_match_all($er_nombre,$primer_apellido) || trim($primer_apellido)==''){
            $respuesta["resultado"]=true;
            $respuesta["mensaje"]="El campo Primer apellido debe contener solo letras de 2 a 30 caracteres, siendo la primera en mayúscula.";
        }else if(!preg_match_all($er_genero,$genero) || trim($genero)==''){
            $respuesta["resultado"]=true;
            $respuesta["mensaje"]="Debe seleccionar un Genero.";
        }else if(!preg_match_all($er_telefono,$telefono) || trim($telefono)==''){
            $respuesta["resultado"]=true;
            $respuesta["mensaje"]="El campo telefono debe contener Solo numeros de 11 digitos";
        }else if(!preg_match_all($er_correo,$correo) || trim($correo)==''){
            $respuesta["resultado"]=true;
            $respuesta["mensaje"]="El campo Correo debe ser ejemplo@gmail.com";
        }else if(!preg_match_all($er_direccion,$direccion) || trim($direccion)==''){
            $respuesta["resultado"]=true;
            $respuesta["mensaje"]="El campo dirección debe contener Solo letras de 2 a 200 caracteres, siendo la primera en mayúscula.";
        }else if($segundo_nombre!='' || $segundo_apellido!=''){
            if(!preg_match_all($er_nombre,$segundo_nombre) || trim($segundo_nombre)==''){
                $respuesta["resultado"]=true;
                $respuesta["mensaje"]="El campo Segundo nombre debe contener solo letras de 2 a 30 caracteres, siendo la primera en mayúscula.";
            }else if(!preg_match_all($er_nombre,$segundo_apellido) || trim($segundo_apellido)==''){
                $respuesta["resultado"]=true;
                $respuesta["mensaje"]="El campo Segundo apellido debe contener solo letras de 2 a 30 caracteres, siendo la primera en mayúscula.";
            }else{
                $respuesta["resultado"]=false;
                $respuesta["mensaje"]="";
            }
        }else{
            $respuesta["resultado"]=false;
            $respuesta["mensaje"]="";
        }
        return $respuesta;
    }

    

    public function listadoaspirantes_aula($id_aula)
    {
        $id_emprendimiento = 0;
        $r = array();
        try {
            //Obtener el id_emprendimiento del aula
            $emprendimiento = $this->conex->prepare("select e.id as id_emprendimiento from aula as a INNER JOIN emprendimiento_modulo as em ON a.id_emprendimiento_modulo=em.id INNER JOIN emprendimiento as emp ON em.id_emprendimiento=emp.id INNER JOIN emprendimiento as e ON e.id=em.id_emprendimiento WHERE a.id=:id_aula;");
            $emprendimiento->BindParam(":id_aula", $id_aula);
            $emprendimiento->execute();
            foreach($emprendimiento as $e){
                $id_emprendimiento = $e['id_emprendimiento'];
            }

            //Buscar todos los aspirantes del emprendimiento
            $resultado = $this->conex->prepare("SELECT a.id, concat(a.cedula,' / ',a.primer_apellido, ' ',a.segundo_apellido, ' ',a.primer_nombre, ' ',a.segundo_nombre) as aspirante, a.id as id_aspirante from usuario as a INNER JOIN aspirante_emprendimiento as b ON b.id_usuario=a.id WHERE b.id_emprendimiento='$id_emprendimiento';");
            $resultado->execute();
            $x = '';
            if ($resultado) {
                foreach ($resultado as $f) {
                    $id_estudiante = $f['id_aspirante'];
                    $existentes = $this->conex->prepare("select a.id as id from aula as a INNER JOIN aula_estudiante as b ON a.id=b.id_aula INNER JOIN usuario as e on b.id_estudiante=e.id INNER JOIN emprendimiento_modulo as em ON a.id_emprendimiento_modulo=em.id INNER JOIN emprendimiento as emp ON em.id_emprendimiento=emp.id WHERE a.id=:id_aula AND e.id=:id_estudiante;");
                    $existentes->BindParam(":id_aula", $id_aula);
                    $existentes->BindParam(":id_estudiante", $id_estudiante);
                    $existentes->execute();
                    $seleted = '';
                    
                    foreach($existentes as $e){
                        $seleted = $e['id']!=null ? 'selected': '';
                    }

                    $x = $x . '<option value="' . $f[0] . '"  '.$seleted.'>' . $f[1] . '</option>';
                }

            }



            /*$existentes = $this->conex->prepare("select em.id as id_emprendimiento, e.id as id_estudiante, concat(e.cedula, ' / ', e.apellido, ' ', e.nombre) as estudiante from aula as a INNER JOIN aula_estudiante as b ON a.id=b.id_aula INNER JOIN usuario as e on b.id_estudiante=e.id INNER JOIN emprendimiento_modulo as em ON a.id_emprendimiento_modulo=em.id INNER JOIN emprendimiento as emp ON em.id_emprendimiento=emp.id WHERE a.id=:id_aula;");
            $existentes->BindParam(":id_aula", $id_aula);
            $existentes->execute();

            $x = '';
            if ($existentes) {

                foreach ($existentes as $d) {
                    $x = $x . '<option value="' . $d['id_estudiante'] . '"  selected>' . $d['estudiante'] . '</option>';
                    $id_emprendimiento = $d['id_emprendimiento'];
                }

            }*/
            

            $r['resultado'] = 'listadoaspirantes_aula';
            $r['mensaje'] = $x;

        } catch (Exception $e) {
            $r['resultado'] = 'error';
            $r['mensaje'] = $e->getMessage();

        }
        return $r;
    }

    public function listadoaspirantes($emprendimiento)
    {
        $r = array();
        try {

            $resultado = $this->conex->prepare("select a.id, concat(a.cedula,' / ',a.primer_apellido, ' ',a.segundo_apellido, ' ',a.primer_nombre, ' ',a.segundo_nombre) as aspirante from usuario as a, aspirante_emprendimiento as b WHERE b.id_emprendimiento=:emprendimiento AND a.id = b.id_usuario;
            ");
            $resultado->BindParam(":emprendimiento", $emprendimiento);

            $resultado->execute();

            $x = '';
            if ($resultado) {

                foreach ($resultado as $f) {
                    $x = $x . '<option value="' . $f[0] . '">' . $f[1] . '</option>';
                }

            }

            $r['resultado'] = 'listadoaspirantes';
            $r['mensaje'] = $x;

        } catch (Exception $e) {
            $r['resultado'] = 'error';
            $r['mensaje'] = $e->getMessage();

        }
        return $r;
    }

}