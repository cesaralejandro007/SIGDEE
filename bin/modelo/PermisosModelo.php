<?php
namespace modelo;
use config\connect\connectDB as connectDB;
class PermisosModelo extends connectDB
{
    private $id_rol;
    private $id_entorno;
    private $entorno;
    private $registrar;
    private $consultar;
    private $eliminar;
    private $modificar;
    private $tipo_usuario;
    private $idusuario;
    private $modulos;

    public function gestionarpermisos($id_rol, $id_entorno, $entorno, $registrar, $consultar, $eliminar, $modificar)
    {
        $existepermisos = $this->validarpermisos($id_rol, $id_entorno);
        $validarrol = $this->validar_rol($id_rol);
        $validarentrono = $this->validar_entorno($id_entorno);
        $validar_expresionID = $this->validar_expresion_id($id_rol, $id_entorno);
        
        if ($validar_expresionID['resultado']) {
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = $validar_expresionID['mensaje'];
        } else {
            if ($validarrol == false) {
                $respuesta['resultado'] = 5;
                $respuesta['mensaje'] = "No existe el rol";
            } elseif ($validarentrono == false) {
                $respuesta['resultado'] = 6;
                $respuesta['mensaje'] = "No existe el entorno del sistema";
            } else {
                try {
                    if ($existepermisos == false and $entorno == "true") {
                        $stmt = $this->conex->prepare("INSERT INTO permiso(
                            id_rol,
                            id_entorno,
                            registrar,
                            modificar,
                            eliminar,
                            consultar
                        ) VALUES (?, ?, ?, ?, ?, ?)");
                        $stmt->execute([$id_rol, $id_entorno, $registrar, $modificar, $eliminar, $consultar]);
                        $respuesta['resultado'] = 1;
                        $respuesta['mensaje'] = "Permisos Registrados";
                    } else if ($existepermisos == true and $entorno == "false") {
                        $stmt = $this->conex->prepare("DELETE FROM permiso WHERE id_entorno = ? AND id_rol = ?");
                        $stmt->execute([$id_entorno, $id_rol]);
                        $respuesta['resultado'] = 2;
                        $respuesta['mensaje'] = "Permisos Eliminados";
                    } else if ($existepermisos == false) {
                        $respuesta['resultado'] = 4;
                        $respuesta['mensaje'] = "El registro permiso no existe";
                    } else if ($existepermisos == true and $entorno == "true") {
                        $stmt = $this->conex->prepare("UPDATE permiso SET registrar = ?, modificar = ?, eliminar = ?, consultar = ? WHERE id_rol = ? AND id_entorno = ?");
                        $stmt->execute([$registrar, $modificar, $eliminar, $consultar, $id_rol, $id_entorno]);
                        $respuesta['resultado'] = 3;
                        $respuesta['mensaje'] = "Permisos Actualizados";
                    }
                } catch (Exception $e) {
                    $respuesta['resultado'] = 0;
                    $respuesta['mensaje'] = $e->getMessage();
                }
            }
        }
        return $respuesta;
    }
    

    public function validar_rol($id)
    {
        try {
            $resultado = $this->conex->prepare("SELECT * FROM rol WHERE id='$id'");
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
    public function validar_entorno($id)
    {
        try {
            $resultado = $this->conex->prepare("SELECT * FROM entorno_sistema WHERE id='$id'");
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

    public function modulos_relacionados()
    {
        try {
            $modulo = $this->conex->query("SELECT * from entorno_sistema");
            if ($modulo) {
                return $modulo;
            } else {
                return '';
            }
        } catch (Exception $e) {
            $respuesta['resultado'] = 0;
            $respuesta['mensaje'] = $e->getMessage();
        }
    }

    public function cargar($id)
    {
        $resultado = $this->conex->prepare("SELECT id, nombre FROM rol WHERE
        id = '$id'
        ");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            $respuesta['resultado'] = 0;
            $respuesta['mensaje'] = $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function cpermisos($id)
    {
        $resultado = $this->conex->prepare("SELECT * FROM permiso WHERE
        permiso.id_rol = '$id'
        ");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            $respuesta['resultado'] = 0;
            $respuesta['mensaje'] = $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function validarpermisos($id_rol, $id_entorno)
    {
        $resultado = $this->conex->prepare("SELECT * FROM permiso WHERE  permiso.id_rol = '$id_rol' and permiso.id_entorno = '$id_entorno'");
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

    public function mostrarentronos($idusuario,$tipo_usuario)
    {
        $resultado = $this->conex->prepare("SELECT e.nombre as nombreentorno FROM usuario u, usuarios_roles ur, rol r,permiso p, entorno_sistema e WHERE u.id = ur.id_usuario and r.id = ur.id_rol and r.id = p.id_rol and e.id= p.id_entorno and u.id='$idusuario' and r.nombre='$tipo_usuario'");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            $respuesta['resultado'] = 0;
            $respuesta['mensaje'] = $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function mostrarpermisos($idusuario,$tipo_usuario,$modulo)
    {
        $resultado = $this->conex->prepare("SELECT e.nombre as nombreentorno ,p.registrar as registrar,p.consultar as consultar, p.modificar as modificar, p.eliminar as eliminar FROM usuario u, usuarios_roles ur, rol r,permiso p, entorno_sistema e WHERE u.id = ur.id_usuario and r.id = ur.id_rol and r.id = p.id_rol and e.id= p.id_entorno and u.id='$idusuario' and e.nombre='$modulo' and r.nombre='$tipo_usuario'");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            $respuesta['resultado'] = 0;
            $respuesta['mensaje'] = $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function validar_expresion_id($id_rol,$id_entorno){
        if(!preg_match('/^[0-9]+$/', $id_rol)){
            $respuesta["resultado"]=true;
            $respuesta["mensaje"]="El campo ID_rol solo debe contener números";
        }else if(!preg_match('/^[0-9]+$/', $id_entorno)){
            $respuesta["resultado"]=true;
            $respuesta["mensaje"]="El campo ID_entorno solo debe contener números";
        }else{
            $respuesta["resultado"]=false;
            $respuesta["mensaje"]="";
        }
        return $respuesta;
    }
}