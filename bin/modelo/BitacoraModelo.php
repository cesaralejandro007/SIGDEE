<?php
namespace modelo;
use config\connect\connectDB as connectDB;
class BitacoraModelo extends connectDB
{
    private $id;
    private $id_usuario_roles;
    private $id_entorno;
    private $fecha;
    private $accion;

    public function incluir($id_usuario_roles,$id_entorno,$fecha,$accion)
    {
        try {
            $this->conex->query("INSERT INTO bitacora(id_usuario_roles, id_entorno, accion, fecha)
            VALUES('$id_usuario_roles', '$id_entorno','$accion', '$fecha')");
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function listar()
    {
        $resultado = $this->conex->prepare("SELECT b.id as id, date_format(b.fecha, '%d-%m-%Y %H:%m:%s') as fecha, concat(u.cedula, ' / ', u.apellido, ' ', u.nombre) as usuario, r.nombre as rol, e.nombre as entorno, b.accion as accion FROM bitacora b INNER JOIN usuarios_roles ur ON b.id_usuario_roles= ur.id INNER JOIN rol r ON ur.id_rol=r.id INNER JOIN usuario u ON u.id=ur.id_usuario INNER JOIN entorno_sistema e ON e.id=b.id_entorno;");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function buscar_id_usuario_rol($nombre, $id_usuario)
    {
        $resultado = $this->conex->prepare("SELECT ur.id as id FROM usuarios_roles as ur INNER JOIN usuario u ON ur.id_usuario=u.id INNER JOIN rol r ON r.id=ur.id_rol WHERE r.nombre= '$nombre' AND u.id='$id_usuario'");
        $dato= "";
        
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
            foreach($respuestaArreglo as $r){
                $dato = $r['id'];
            }
            return $dato;
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function buscar_id_entorno($entorno){
        $resultado = $this->conex->prepare("SELECT id FROM entorno_sistema WHERE nombre='$entorno';");
        $dato= "";
        
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
            foreach($respuestaArreglo as $r){
                $dato = $r['id'];
            }
            return $dato;
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

}