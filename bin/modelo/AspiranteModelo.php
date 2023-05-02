<?php
namespace modelo;
use config\connect\connectDB as connectDB;
class AspiranteModelo extends connectDB
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

    public function registrar_aspirante($cedula,$primer_nombre,$segundo_nombre,$primer_apellido,$segundo_apellido,$genero,$correo,$direccion,$telefono)
    {
            try {
                $this->conex->query("INSERT INTO usuario(
        					cedula,
        					primer_nombre,
                            segundo_nombre,
        					primer_apellido,
                            segundo_apellido,
                            genero,
        					correo,
        					direccion,
        					telefono
        					)
        				VALUES(
        					'$cedula',
        					'$primer_nombre',
                            '$segundo_nombre',
        					'$primer_apellido',
                            '$segundo_apellido',
                            '$genero',
        					'$correo',
        					'$direccion',
        					'$telefono'
        				)");
                    return true;
            } catch (Exception $e) {
                return false;
            }
    }

    public function modificar($id,$cedula,$primer_nombre,$segundo_nombre,$primer_apellido,$segundo_apellido,$genero,$correo,$direccion,$telefono)
    {
        $expresiones_regulares = $this->validar_expresiones($nombre,$apellido);
        $validar_modificar = $this->validar_modificar($cedula, $id);
        if ($this->existe($id)==false) {
            $respuesta['resultado'] = 4;
            $respuesta['mensaje'] = "El Usuario de no Existe";
        }else if ($validar_modificar) {
            $respuesta['resultado'] = 3;
            $respuesta['mensaje'] = "Nombre ya existe";
        }else if($expresiones_regulares){
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = "Verifique, no coincide con el formato solicitado";
        } else {
            try {
                $this->conex->query("UPDATE usuario  SET cedula = '$cedula', nombre = '$nombre', correo = '$correo',  direccion = '$direccion', apellido = '$apellido', telefono = '$telefono' WHERE id = '$id'");
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

        if ($this->existe($id)==false) {
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = "El Usuario de no Existe";
        }else{
            try {
                $this->conex->query("DELETE FROM aspirante_emprendimiento WHERE id_usuario ='$id'");
                $respuesta["resultado"]=1;
                $respuesta["mensaje"]="Eliminación exitosa";
                return $respuesta;
            } catch (Exception $e) {
                $respuesta['resultado'] = 0;
                $respuesta['mensaje'] = $e->getMessage();
            }
        }         
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
        $resultado = $this->conex->prepare("SELECT id, cedula, nombre, apellido, correo, direccion, telefono, clave, imagen FROM usuario WHERE id = '$id'");
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

    public function validar_expresiones($nombre,$apellido){
        $er_nombre = '/^[a-zA-Z\x{00f1}\x{00d1}\x{00E0}-\x{00FC}\b ]*$/u';
        $er_telefono= '/([0-9][ -]*){8}/';
        $m = false;
        if(!preg_match_all($er_nombre,$nombre) || trim($nombre)==''){
           $m = true;
        }else if(!preg_match_all($er_nombre,$apellido) || trim($apellido)==''){
            $m = true;
        }
        return $m;
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
            $resultado = $this->conex->prepare("SELECT a.id, concat(a.cedula, ' / ', a.apellido, ' ', a.nombre) as aspirante, a.id as id_aspirante from usuario as a INNER JOIN aspirante_emprendimiento as b ON b.id_usuario=a.id WHERE b.id_emprendimiento='$id_emprendimiento';");
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

            $resultado = $this->conex->prepare("select a.id, concat(a.cedula, ' / ', a.apellido, ' ', a.nombre) as aspirante from usuario as a, aspirante_emprendimiento as b WHERE b.id_emprendimiento=:emprendimiento AND a.id = b.id_usuario;
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