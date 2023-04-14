<?php
namespace modelo;
use config\connect\connectDB as connectDB;
class ContenidoModelo extends connectDB
{
    private $id;
    private $nombre;
    private $descripcion;
    private $archivo_adjunto;

    
    public function incluir($nombre, $descripcion, $archivo_adjunto)
    {
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->archivo_adjunto = $archivo_adjunto;

        $validar_registro = $this->validar_registro($nombre);
        $expresiones_regulares = $this->validar_expresiones($nombre,$descripcion);
        if ($validar_registro) {
            $respuesta['resultado'] = 3;
            $respuesta['mensaje'] = "Nombre ya existe";
        }else if ($expresiones_regulares['resultado']) {
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = $expresiones_regulares['mensaje'];
        }else {
            try {
                $this->conex->query("INSERT INTO contenido(nombre, descripcion, archivo_adjunto)
                    VALUES('$this->nombre','$this->descripcion','$this->archivo_adjunto')");
                 $respuesta['resultado'] = 1;
                 $respuesta['mensaje'] = "Registro exitoso";
            } catch (Exception $e) {
                $respuesta['resultado'] = 0;
                $respuesta['mensaje'] = $e->getMessage();
            }
        }
        return $respuesta;
    }

    public function modificar($id, $nombre, $descripcion)
    {
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->id = $id;
        $validar_modificar = $this->validar_modificar($nombre, $id);
        $expresiones_regulares = $this->validar_expresiones($nombre,$descripcion);

        if ($this->existe($id)==false) {
            $respuesta['resultado'] = 4;
            $respuesta['mensaje'] = "El Contenido no Existe";
        }else if($validar_modificar) {
            $respuesta['resultado'] = 3;
            $respuesta['mensaje'] = "Nombre ya existe";
        } 
        else if($expresiones_regulares['resultado']){
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = $expresiones_regulares['mensaje'];
        }
        else {
            try {
                $this->conex->query("UPDATE contenido SET nombre= '$this->nombre',descripcion = '$this->descripcion' WHERE id = '$this->id'");
                $respuesta['resultado'] = 1;
                $respuesta['mensaje'] = "Modificación exitoso";
            } catch (Exception $e) {
                $respuesta['resultado'] = 0;
                $respuesta['mensaje'] = $e->getMessage();
            }
        }
    return $respuesta;
    }

    public function eliminar($id)
    {
        $validar_contenido = $this->Validar_contenido_unidad($id);

        if ($this->existe($id)==false) {
            $respuesta['resultado'] = 3;
            $respuesta['mensaje'] = "El Contenido no Existe";
            return $respuesta;
        }else{
            if($validar_contenido) {
                $respuesta['resultado'] = 2;
                $respuesta['mensaje'] = "El Contenido no puede ser borrardo, existe un vinculo con Unidad Contenido.";
            }
            else{
                try {
                    $this->conex->query("DELETE from contenido
                    WHERE
                    id = '$id'
                    ");
                    $respuesta['resultado'] = 1;
                    $respuesta['mensaje'] = "Eliminación exitosa";
                } catch (Exception $e) {
                    $respuesta['resultado'] = 0;
                    $respuesta['mensaje'] = $e->getMessage();
                }
            }
            return $respuesta;
        }
    }
    
    public function validar_modificar($nombre, $id)
    {
        try {
            $resultado = $this->conex->prepare("SELECT * FROM contenido WHERE nombre='$nombre' AND id<>'$id'");
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

    public function cambiar_archivo($id, $archivo_adjunto){
        $this->id = $id;
        $this->archivo_adjunto = $archivo_adjunto;

        try {
            $this->conex->query("UPDATE contenido SET archivo_adjunto= '$this->archivo_adjunto' WHERE id = '$this->id'");
            return true;
        } catch(Exception $e) {
            return $e->getMessage();
        }
        
    }

    public function listar(){
        $resultado = $this->conex->prepare("SELECT * FROM contenido");
        $respuestaArreglo = [];
        try{
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        }catch(Exception $e){
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }
    
    public function mostrar($id_unidad)
    {
        try {
            $resul = $this->conex->query("SELECT id, nombre as contenido FROM contenido");
            if ($resul) {
                $res = "";
                foreach ($resul as $r) {
                    $activo = '';
                    $sql = $this->conex->query("SELECT c.id as id, c.nombre as nombre FROM contenido c INNER JOIN unidad_contenido uc ON c.id=uc.id_contenido WHERE uc.id_unidad= '$id_unidad' AND c.id=".$r['id']."");
                    if ($sql->fetchAll()) {
                        $activo = "selected";
                    }   
                    $res = $res . "<option class='val' value='".$r['id'] ."' ".$activo." >";
                    $res = $res . $r['contenido'];
                    $res = $res . "</option>";
                }
                return $res;
            } else {return '';}
        } catch (Exception $e) {return $e->getMessage();}
    }

    private function validar_registro($nombre)
    {
        try {
            $resultado = $this->conex->prepare("SELECT * FROM contenido WHERE nombre='$nombre'");
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

    private function Validar_contenido_unidad($id)
    {
        try {
            $resultado = $this->conex->prepare("SELECT * FROM unidad_contenido,contenido WHERE contenido.id = unidad_contenido.id_contenido and contenido.id ='$id'");
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

    private function existe($id)
    {
        try {
            $resultado = $this->conex->prepare("SELECT * FROM contenido WHERE id='$id'");
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

    public function cargar($id){
        $resultado = $this->conex->prepare("SELECT * FROM contenido WHERE
            id = '$id'
            ");
        $respuestaArreglo = [];
        try{
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        }catch(Exception $e){
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function validar_expresiones($nombre,$descripcion){
        $er_nombre = '/^[A-ZÁÉÍÓÚa-zñáéíóú,.#%$^&*:\s]{3,30}$/';
        $er_descripcion = '/^[A-ZÁÉÍÓÚa-zñáéíóú,.#%$^&*:\s]{3,200}$/';
        if(!preg_match_all($er_nombre,$nombre) || trim($nombre)==''){
            $respuesta["resultado"]=true;
            $respuesta["mensaje"]="El campo Nombre de contener solo letras de 3 a 30 caracteres, siendo la primera en mayúscula.";
        }
        else if(!preg_match_all($er_descripcion,$descripcion) || trim($descripcion)==''){
            $respuesta["resultado"]=true;
            $respuesta["mensaje"]="El campo descripción debe contener de 3 a 200 letras.";
        }else{
            $respuesta["resultado"]=false;
            $respuesta["mensaje"]="";
        }
        return $respuesta;
    }
    
}