<?php
namespace modelo;
use config\connect\connectDB as connectDB;
class EstudianteModelo extends connectDB
{
    private $id;
    private $cedula;
    private $nombre;
    private $apellido;
    private $telefono;
    private $correo;
    private $direccion;

    public function incluir($cedula, $id_ciudad, $primer_nombre,$segundo_nombre,$primer_apellido,$segundo_apellido,$genero,$correo,$direccion,$telefono,$clave)
    {
        $validar_registro = $this->existeregistrar($cedula);
        $validar_expresion = $this->validar_expresiones($cedula,$primer_nombre,$segundo_nombre,$primer_apellido,$segundo_apellido,$genero,$correo,$direccion,$telefono);
        if ($validar_registro) {
            $respuesta['resultado'] = 3;
            $respuesta['mensaje'] = "La cedula esta repetida";
        }else if ($validar_expresion['resultado']) {
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = $validar_expresion['mensaje'];
        } else {
            try {
                $this->conex->query("INSERT INTO usuario(
        					cedula,
        					id_ciudad,
        					primer_nombre,
                            segundo_nombre,
        					primer_apellido,
                            segundo_apellido,
                            genero,
        					telefono,
        					correo,
        					direccion,
                            clave
        					)
        				VALUES(
        					'$cedula',
        					'$id_ciudad',
        					'$primer_nombre',
                            '$segundo_nombre',
        					'$primer_apellido',
                            '$segundo_apellido',
                            '$genero',
        					'$telefono',
        					'$correo',
        					'$direccion',
                            '$clave'
        				)");
            $respuesta['resultado'] = 1;
            $respuesta['mensaje'] = "Registro exitoso";
            } catch (Exception $e) {
                $respuesta['resultado'] = 0;
                $respuesta['mensaje'] = $e->getMessage();
            }
        }
        return $respuesta;
    }

    public function modificar($id,$id_ciudad,$cedula,$primer_nombre,$segundo_nombre,$primer_apellido,$segundo_apellido,$genero,$correo,$direccion,$telefono)
    {
        $validar_modificar = $this->validar_modificar($cedula, $id);
        $validar_expresion = $this->validar_expresiones($cedula,$primer_nombre,$segundo_nombre,$primer_apellido,$segundo_apellido,$genero,$correo,$direccion,$telefono);
        if ($this->existe($id)==false) {
            $respuesta['resultado'] = 4;
            $respuesta['mensaje'] = "El Usuario no Existe";
        }else if ($validar_modificar) {
            $respuesta['resultado'] = 3;
            $respuesta['mensaje'] = 'Registro no modificado, la Cedula ya existe';
        }else if ($validar_expresion['resultado']) {
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = $validar_expresion['mensaje'];
        }else {
            try {
                $this->conex->query("UPDATE usuario SET cedula= '$cedula', id_ciudad= '$id_ciudad', primer_nombre = '$primer_nombre',segundo_nombre = '$segundo_nombre', primer_apellido = '$primer_apellido', segundo_apellido = '$segundo_apellido', genero = '$genero', telefono = '$telefono', correo = '$correo' , direccion = '$direccion' WHERE id = '$id'");
            $respuesta['resultado'] = 1;
            $respuesta['mensaje'] = "Modificación exitosa";
            } catch (Exception $e) {
                $respuesta['resultado'] = 0;
                $respuesta['mensaje'] = $e->getMessage();
            }
        }
        return $respuesta;
    }

    public function listar()
    {
        $resultado = $this->conex->prepare("SELECT u.id as id, u.cedula as cedula, u.primer_nombre as primer_nombre, u.segundo_nombre as segundo_nombre, u.primer_apellido as primer_apellido, u.segundo_apellido as segundo_apellido, u.genero as genero, u.telefono as telefono, u.correo as correo, u.direccion as direccion FROM usuario u INNER JOIN usuarios_roles ur ON ur.id_usuario=u.id INNER JOIN rol r ON ur.id_rol=r.id WHERE r.nombre='Estudiante';");
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

    public function cargarregistrar($cedula)
    {
        if ($this->existeregistrar($cedula)==false) {
            $respuestaArreglo['resultado'] = 0;
            $respuestaArreglo['mensaje'] = "El Usuario no Existe";
        }else{
            $resultado = $this->conex->prepare("SELECT * FROM usuario WHERE
                cedula = '$cedula'
                ");
            $respuestaArreglo = [];
            try {
                $resultado->execute();
                $respuestaArreglo = $resultado->fetchAll();
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }
        return $respuestaArreglo;
    }

    public function existeregistrar($cedula)
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

    public function buscarestudiante($valor)
    {
        $resultado = $this->conex->prepare("SELECT * FROM usuario WHERE cedula = '$valor'");
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

    public function ReporteDireccion($id_estado, $id_pais){
        $respuesta = array();
        $respuesta['descripcion'] = '';
        $respuesta['datos'] = '';
        $total = 0;
        try{
            if($id_estado != 'null'){
                $resultado = $this->conex->prepare("SELECT c.id as id, c.nombre as nombre FROM estados e INNER JOIN ciudades c ON e.id= c.id_estado WHERE e.id=$id_estado;");
                $resultado->execute();
                if($resultado){
                    foreach($resultado as $ciudades){
                        $query = $this->conex->prepare("SELECT u.id, u.primer_nombre FROM usuario u INNER JOIN aula_estudiante ae ON ae.id_estudiante=u.id INNER JOIN ciudades c ON c.id=u.id_ciudad WHERE c.id=".$ciudades['id']." GROUP BY u.id;");
                        $query->execute();
                        $arrDatos=$query->fetchAll();             
                        $cantidad_estudiantes = count($arrDatos);
                        $datos[] = ([
                            "name"=> $ciudades['nombre'],
                            "y" => $cantidad_estudiantes
                        ]); 
                        $total =+ $cantidad_estudiantes;
                    }
                }                
                $respuesta['descripcion'] = 'Ciudades';
                $respuesta['datos'] = $datos;
                $respuesta['cantidad'] = $total;
            }else
            if($id_pais != 'null'){
                $resultado = $this->conex->prepare("SELECT e.id as id, e.nombre as nombre FROM paises p INNER JOIN estados e ON p.id= e.id_pais WHERE p.id=$id_pais;");
                $resultado->execute();
                if($resultado){
                    foreach($resultado as $estado){
                        $query = $this->conex->prepare("SELECT u.id, u.primer_nombre FROM usuario u INNER JOIN aula_estudiante ae ON ae.id_estudiante=u.id INNER JOIN ciudades c ON c.id=u.id_ciudad INNER JOIN estados e ON c.id_estado= e.id WHERE e.id=".$estado['id']." GROUP BY u.id;");
                        $query->execute();
                        $arrDatos=$query->fetchAll();             
                        $cantidad_estudiantes = count($arrDatos);
                        $datos[] = ([
                            "name"=> $estado['nombre'],
                            "y" => $cantidad_estudiantes
                        ]); 
                        $total =+ $cantidad_estudiantes;
                    }
                } 
                $respuesta['descripcion'] = 'Estados';
                $respuesta['datos'] = $datos;
                $respuesta['cantidad'] = $total;
            }
            else{
                $resultado = $this->conex->prepare("SELECT p.id as id, p.nombre as nombre FROM paises p;");
                $resultado->execute();
                if($resultado){
                    foreach($resultado as $pais){
                        $query = $this->conex->prepare("SELECT u.id, u.primer_nombre FROM usuario u INNER JOIN aula_estudiante ae ON ae.id_estudiante=u.id INNER JOIN ciudades c ON c.id=u.id_ciudad INNER JOIN estados e ON c.id_estado= e.id INNER JOIN paises p ON p.id=e.id_pais WHERE p.id=".$pais['id']." GROUP BY u.id;");
                        $query->execute();
                        $arrDatos=$query->fetchAll();             
                        $cantidad_estudiantes = count($arrDatos);
                        $datos[] = ([
                            "name"=> $pais['nombre'],
                            "y" => $cantidad_estudiantes
                        ]); 
                        $total =+ $cantidad_estudiantes;
                    }
                } 
                $respuesta['descripcion'] = 'Paises';
                $respuesta['cantidad'] = $total;
                $respuesta['datos'] = $datos;

            }
            $respuesta['status'] = 200;
        }catch(Exception $e){
            $respuesta['status'] = 500;
            $respuesta['descripcion'] = $e->getMessage();
        }
        return $respuesta;
    }

    public function DireccionArea($id_area, $id_estado, $id_pais){
        $respuesta = array();
        $respuesta['descripcion'] = '';
        $respuesta['datos'] = '';
        $total = 0;
        try{
            if($id_estado != 'null'){
                //Reporte de estudiantes de cada ciudad de un estado seleccionado y de un area de emprendimiento en especifico
                $resultado = $this->conex->prepare("SELECT c.id as id, c.nombre as nombre FROM estados e INNER JOIN ciudades c ON e.id= c.id_estado WHERE e.id=$id_estado;");
                $resultado->execute();
                if($resultado){
                    foreach($resultado as $ciudades){
                        $query = $this->conex->prepare("SELECT u.id, u.primer_nombre FROM usuario u INNER JOIN aula_estudiante ae ON ae.id_estudiante=u.id INNER JOIN ciudades c ON c.id=u.id_ciudad INNER JOIN aula a ON a.id=ae.id_aula INNER JOIN emprendimiento_modulo em ON em.id=a.id_emprendimiento_modulo INNER JOIN emprendimiento e ON e.id=em.id_emprendimiento INNER JOIN area_emprendimiento aem ON aem.id=e.id_area WHERE c.id=".$ciudades['id']." AND aem.id=".$id_area." GROUP BY u.id;");
                        $query->execute();
                        $arrDatos=$query->fetchAll();             
                        $cantidad_estudiantes = count($arrDatos);
                        $datos[] = ([
                            "name"=> $ciudades['nombre'],
                            "y" => $cantidad_estudiantes
                        ]); 
                        $total =+ $cantidad_estudiantes;
                    }
                }                
                $respuesta['descripcion'] = 'Ciudades';
                $respuesta['datos'] = $datos;
                $respuesta['cantidad'] = $total;
            }else
            if($id_pais != 'null'){
                //Reporte de estudiantes de cada estado de un pais seleccionado y de un area de emprendimiento en especifico
                $resultado = $this->conex->prepare("SELECT e.id as id, e.nombre as nombre FROM paises p INNER JOIN estados e ON p.id= e.id_pais WHERE p.id=$id_pais;");
                $resultado->execute();
                if($resultado){
                    foreach($resultado as $estado){
                        $query = $this->conex->prepare("SELECT u.id, u.primer_nombre FROM usuario u INNER JOIN aula_estudiante ae ON ae.id_estudiante=u.id INNER JOIN ciudades c ON c.id=u.id_ciudad INNER JOIN estados e ON c.id_estado= e.id INNER JOIN aula a ON a.id=ae.id_aula INNER JOIN emprendimiento_modulo em ON em.id=a.id_emprendimiento_modulo INNER JOIN emprendimiento eo ON eo.id=em.id_emprendimiento INNER JOIN area_emprendimiento aem ON aem.id=eo.id_area WHERE e.id=".$estado['id']." AND aem.id=".$id_area." GROUP BY u.id;");
                        $query->execute();
                        $arrDatos=$query->fetchAll();             
                        $cantidad_estudiantes = count($arrDatos);
                        $datos[] = ([
                            "name"=> $estado['nombre'],
                            "y" => $cantidad_estudiantes
                        ]); 
                        $total =+ $cantidad_estudiantes;
                    }
                } 
                $respuesta['descripcion'] = 'Estados';
                $respuesta['datos'] = $datos;
                $respuesta['cantidad'] = $total;
            }
            else{
                //Reporte de estudiantes de cada pais de un area de emprendimiento en especifico
                $resultado = $this->conex->prepare("SELECT p.id as id, p.nombre as nombre FROM paises p;");
                $resultado->execute();
                if($resultado){
                    foreach($resultado as $pais){
                        $query = $this->conex->prepare("SELECT u.id, u.primer_nombre FROM usuario u INNER JOIN aula_estudiante ae ON ae.id_estudiante=u.id INNER JOIN ciudades c ON c.id=u.id_ciudad INNER JOIN estados e ON c.id_estado= e.id INNER JOIN paises p ON p.id=e.id_pais INNER JOIN aula a ON a.id=ae.id_aula INNER JOIN emprendimiento_modulo em ON em.id=a.id_emprendimiento_modulo INNER JOIN emprendimiento eo ON eo.id=em.id_emprendimiento INNER JOIN area_emprendimiento aem ON aem.id=eo.id_area  WHERE p.id=".$pais['id']." AND aem.id=".$id_area." GROUP BY u.id;");
                        $query->execute();
                        $arrDatos=$query->fetchAll();             
                        $cantidad_estudiantes = count($arrDatos);
                        $datos[] = ([
                            "name"=> $pais['nombre'],
                            "y" => $cantidad_estudiantes
                        ]); 
                        $total =+ $cantidad_estudiantes;
                    }
                } 
                $respuesta['descripcion'] = 'Paises';
                $respuesta['cantidad'] = $total;
                $respuesta['datos'] = $datos;

            }
            $respuesta['status'] = 200;
        }catch(Exception $e){
            $respuesta['status'] = 500;
            $respuesta['descripcion'] = $e->getMessage();
        }
        return $respuesta;
    }

    public function DireccionEmprendimiento($id_emprendimiento, $id_estado, $id_pais){
        $respuesta = array();
        $respuesta['descripcion'] = '';
        $respuesta['datos'] = '';
        $total = 0;
        try{
            if($id_estado != 'null'){
                //Reporte de estudiantes de cada ciudad de un estado seleccionado y de un emprendimiento en especifico
                $resultado = $this->conex->prepare("SELECT c.id as id, c.nombre as nombre FROM estados e INNER JOIN ciudades c ON e.id= c.id_estado WHERE e.id=$id_estado;");
                $resultado->execute();
                if($resultado){
                    foreach($resultado as $ciudades){
                        $query = $this->conex->prepare("SELECT u.id, u.primer_nombre FROM usuario u INNER JOIN aula_estudiante ae ON ae.id_estudiante=u.id INNER JOIN ciudades c ON c.id=u.id_ciudad INNER JOIN aula a ON a.id=ae.id_aula INNER JOIN emprendimiento_modulo em ON em.id=a.id_emprendimiento_modulo INNER JOIN emprendimiento e ON e.id=em.id_emprendimiento WHERE c.id=".$ciudades['id']." AND e.id=".$id_emprendimiento." GROUP BY u.id;");
                        $query->execute();
                        $arrDatos=$query->fetchAll();             
                        $cantidad_estudiantes = count($arrDatos);
                        $datos[] = ([
                            "name"=> $ciudades['nombre'],
                            "y" => $cantidad_estudiantes
                        ]); 
                        $total =+ $cantidad_estudiantes;
                    }
                }                
                $respuesta['descripcion'] = 'Ciudades';
                $respuesta['datos'] = $datos;
                $respuesta['cantidad'] = $total;
            }else
            if($id_pais != 'null'){
                //Reporte de estudiantes de cada estado de un pais seleccionado y de un area de emprendimiento en especifico
                $resultado = $this->conex->prepare("SELECT e.id as id, e.nombre as nombre FROM paises p INNER JOIN estados e ON p.id= e.id_pais WHERE p.id=$id_pais;");
                $resultado->execute();
                if($resultado){
                    foreach($resultado as $estado){
                        $query = $this->conex->prepare("SELECT u.id, u.primer_nombre FROM usuario u INNER JOIN aula_estudiante ae ON ae.id_estudiante=u.id INNER JOIN ciudades c ON c.id=u.id_ciudad INNER JOIN estados e ON c.id_estado= e.id INNER JOIN aula a ON a.id=ae.id_aula INNER JOIN emprendimiento_modulo em ON em.id=a.id_emprendimiento_modulo INNER JOIN emprendimiento eo ON eo.id=em.id_emprendimiento WHERE e.id=".$estado['id']." AND eo.id=".$id_emprendimiento." GROUP BY u.id;");
                        $query->execute();
                        $arrDatos=$query->fetchAll();             
                        $cantidad_estudiantes = count($arrDatos);
                        $datos[] = ([
                            "name"=> $estado['nombre'],
                            "y" => $cantidad_estudiantes
                        ]); 
                        $total =+ $cantidad_estudiantes;
                    }
                } 
                $respuesta['descripcion'] = 'Estados';
                $respuesta['datos'] = $datos;
                $respuesta['cantidad'] = $total;
            }
            else{
                //Reporte de estudiantes de cada pais de un area de emprendimiento en especifico
                $resultado = $this->conex->prepare("SELECT p.id as id, p.nombre as nombre FROM paises p;");
                $resultado->execute();
                if($resultado){
                    foreach($resultado as $pais){
                        $query = $this->conex->prepare("SELECT u.id, u.primer_nombre FROM usuario u INNER JOIN aula_estudiante ae ON ae.id_estudiante=u.id INNER JOIN ciudades c ON c.id=u.id_ciudad INNER JOIN estados e ON c.id_estado= e.id INNER JOIN paises p ON p.id=e.id_pais INNER JOIN aula a ON a.id=ae.id_aula INNER JOIN emprendimiento_modulo em ON em.id=a.id_emprendimiento_modulo INNER JOIN emprendimiento eo ON eo.id=em.id_emprendimiento  WHERE p.id=".$pais['id']." AND eo.id=".$id_emprendimiento." GROUP BY u.id;");
                        $query->execute();
                        $arrDatos=$query->fetchAll();             
                        $cantidad_estudiantes = count($arrDatos);
                        $datos[] = ([
                            "name"=> $pais['nombre'],
                            "y" => $cantidad_estudiantes
                        ]); 
                        $total =+ $cantidad_estudiantes;
                    }
                } 
                $respuesta['descripcion'] = 'Paises';
                $respuesta['cantidad'] = $total;
                $respuesta['datos'] = $datos;

            }
            $respuesta['status'] = 200;
        }catch(Exception $e){
            $respuesta['status'] = 500;
            $respuesta['descripcion'] = $e->getMessage();
        }
        return $respuesta;
    }

    public function DireccionCursos($id_curso, $id_estado, $id_pais){
        $respuesta = array();
        $respuesta['descripcion'] = '';
        $respuesta['datos'] = '';
        $total = 0;
        try{
            if($id_estado != 'null'){
                //Reporte de estudiantes de cada ciudad de un estado seleccionado y de un curso en especifico
                $resultado = $this->conex->prepare("SELECT c.id as id, c.nombre as nombre FROM estados e INNER JOIN ciudades c ON e.id= c.id_estado WHERE e.id=$id_estado;");
                $resultado->execute();
                if($resultado){
                    foreach($resultado as $ciudades){
                        $query = $this->conex->prepare("SELECT u.id, u.primer_nombre FROM usuario u INNER JOIN aula_estudiante ae ON ae.id_estudiante=u.id INNER JOIN ciudades c ON c.id=u.id_ciudad INNER JOIN aula a ON a.id=ae.id_aula WHERE c.id=".$ciudades['id']." AND a.id=".$id_curso." GROUP BY u.id;");
                        $query->execute();
                        $arrDatos=$query->fetchAll();             
                        $cantidad_estudiantes = count($arrDatos);
                        $datos[] = ([
                            "name"=> $ciudades['nombre'],
                            "y" => $cantidad_estudiantes
                        ]); 
                        $total =+ $cantidad_estudiantes;
                    }
                }                
                $respuesta['descripcion'] = 'Ciudades';
                $respuesta['datos'] = $datos;
                $respuesta['cantidad'] = $total;
            }else
            if($id_pais != 'null'){
                //Reporte de estudiantes de cada estado de un pais seleccionado y de un curso en especifico
                $resultado = $this->conex->prepare("SELECT e.id as id, e.nombre as nombre FROM paises p INNER JOIN estados e ON p.id= e.id_pais WHERE p.id=$id_pais;");
                $resultado->execute();
                if($resultado){
                    foreach($resultado as $estado){
                        $query = $this->conex->prepare("SELECT u.id, u.primer_nombre FROM usuario u INNER JOIN aula_estudiante ae ON ae.id_estudiante=u.id INNER JOIN ciudades c ON c.id=u.id_ciudad INNER JOIN estados e ON c.id_estado= e.id INNER JOIN aula a ON a.id=ae.id_aula WHERE e.id=".$estado['id']." AND a.id=".$id_curso." GROUP BY u.id;");
                        $query->execute();
                        $arrDatos=$query->fetchAll();             
                        $cantidad_estudiantes = count($arrDatos);
                        $datos[] = ([
                            "name"=> $estado['nombre'],
                            "y" => $cantidad_estudiantes
                        ]); 
                        $total =+ $cantidad_estudiantes;
                    }
                } 
                $respuesta['descripcion'] = 'Estados';
                $respuesta['datos'] = $datos;
                $respuesta['cantidad'] = $total;
            }
            else{
                //Reporte de estudiantes de cada pais de un curso en especifico
                $resultado = $this->conex->prepare("SELECT p.id as id, p.nombre as nombre FROM paises p;");
                $resultado->execute();
                if($resultado){
                    foreach($resultado as $pais){
                        $query = $this->conex->prepare("SELECT u.id, u.primer_nombre FROM usuario u INNER JOIN aula_estudiante ae ON ae.id_estudiante=u.id INNER JOIN ciudades c ON c.id=u.id_ciudad INNER JOIN estados e ON c.id_estado= e.id INNER JOIN paises p ON p.id=e.id_pais INNER JOIN aula a ON a.id=ae.id_aula WHERE p.id=".$pais['id']." AND a.id=".$id_curso." GROUP BY u.id;");
                        $query->execute();
                        $arrDatos=$query->fetchAll();             
                        $cantidad_estudiantes = count($arrDatos);
                        $datos[] = ([
                            "name"=> $pais['nombre'],
                            "y" => $cantidad_estudiantes
                        ]); 
                        $total =+ $cantidad_estudiantes;
                    }
                } 
                $respuesta['descripcion'] = 'Paises';
                $respuesta['cantidad'] = $total;
                $respuesta['datos'] = $datos;

            }
            $respuesta['status'] = 200;
        }catch(Exception $e){
            $respuesta['status'] = 500;
            $respuesta['descripcion'] = $e->getMessage();
        }
        return $respuesta;
    }
}