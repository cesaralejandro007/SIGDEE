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

    public function gestionarpermisos($id_rol,$id_entorno,$entorno,$registrar,$consultar,$eliminar,$modificar)
    {
        $validar = $this->validarpermisos($id_rol, $id_entorno);
        if ($validar == false and $entorno == "true") {
            try {
                $this->conex->query("INSERT INTO permiso(
                    id_rol,
                    id_entorno,
                    registrar,
                    modificar,
                    eliminar,
                    consultar
					)
					VALUES(
					'$id_rol',
                    '$id_entorno',
                    '$registrar',
                    '$modificar',
                    '$eliminar',
                    '$consultar'

				)");
                         $respuesta['resultado'] = 1;
                         $respuesta['mensaje'] = "Permisos Registrados";
            } catch (Exception $e) {
                    $respuesta['resultado'] = 0;
                    $respuesta['mensaje'] = $e->getMessage();
            }
        } else if ($validar == true and $entorno == "false") {
            try {
                $this->conex->query("DELETE from permiso
					WHERE
					  id_entorno = '$id_entorno' and id_rol = '$id_rol'
					");
                         $respuesta['resultado'] = 2;
                         $respuesta['mensaje'] = "Permisos Eliminados";
            } catch (Exception $e) {
                    $respuesta['resultado'] = 0;
                    $respuesta['mensaje'] = $e->getMessage();
            }
        } else if($validar == true and $entorno == "true") {
            try {
                $this->conex->query("UPDATE permiso SET  registrar = '$registrar', modificar = '$modificar', eliminar = '$eliminar', consultar = '$consultar' WHERE id_rol = '$id_rol' and id_entorno = '$id_entorno'");
                         $respuesta['resultado'] = 3;
                         $respuesta['mensaje'] = "Permisos Actualizados";
            } catch (Exception $e) {
                    $respuesta['resultado'] = 0;
                    $respuesta['mensaje'] = $e->getMessage();
            }
        }
        return $respuesta;
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

}