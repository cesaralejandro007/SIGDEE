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

    public function incluir($id_usuario_roles, $id_entorno, $fecha, $accion)
    {
        try {
            $sql = "INSERT INTO bitacora (id_usuario_roles, id_entorno, accion, fecha) VALUES (?, ?, ?, ?)";
            $stmt = $this->conex->prepare($sql);
            $stmt->execute([$id_usuario_roles, $id_entorno, $accion, $fecha]);
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }    

    public function listar_bitacora_rango($fechai, $fechaf)
    {
        $validar_expresion = $this->validar_expresiones($fechai, $fechaf);
        if ($validar_expresion['resultado']) {
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = $validar_expresion['mensaje'];
            return $respuesta;
        } else {
            try {
                $sql = "SELECT b.id AS id, DATE_FORMAT(b.fecha, '%d-%m-%Y %H:%i:%s') AS fecha, CONCAT(u.cedula, ' / ', u.primer_apellido, ' ', u.primer_nombre) AS usuario, r.nombre AS rol, e.nombre AS entorno, b.accion AS accion
                        FROM bitacora b
                        INNER JOIN usuarios_roles ur ON b.id_usuario_roles = ur.id
                        INNER JOIN rol r ON ur.id_rol = r.id
                        INNER JOIN usuario u ON u.id = ur.id_usuario
                        INNER JOIN entorno_sistema e ON e.id = b.id_entorno
                        WHERE b.fecha BETWEEN ? AND ?";
                
                $stmt = $this->conex->prepare($sql);
                $stmt->execute(array($fechai, $fechaf)); // Pasamos los valores en un array
                $resultadoArreglo = $stmt->fetchAll();
                return $resultadoArreglo;
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }
    }

    public function limpieza_bitacora($fechai, $fechaf)
    {
        $validar_expresion = $this->validar_expresiones($fechai, $fechaf);
        $existen_registros_bitacora = $this->existe_registros($fechai, $fechaf);
    
        if ($validar_expresion['resultado']) {
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = $validar_expresion['mensaje'];
            return $respuesta;
        } else if (!$existen_registros_bitacora) {
            $respuesta['resultado'] = 3;
            $respuesta['mensaje'] = "No existen registros en la bitácora";
            return $respuesta;
        } else {
            try {
                $sql = "DELETE FROM bitacora WHERE fecha BETWEEN ? AND ?";
                
                $stmt = $this->conex->prepare($sql);
                $stmt->execute(array($fechai, $fechaf));
                return true;
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }
    }

    public function existe_registros($fechai, $fechaf)
    {
        try {
            $sql = "SELECT COUNT(*) FROM bitacora WHERE fecha BETWEEN ? AND ?";
            $stmt = $this->conex->prepare($sql);
            $stmt->execute(array($fechai, $fechaf));
            $count = $stmt->fetchColumn();
    
            return $count > 0;
        } catch (Exception $e) {
            return false;
        }
    }

    public function listar()
    {
        $resultado = $this->conex->prepare("SELECT b.id as id, date_format(b.fecha, '%d-%m-%Y %H:%m:%s') as fecha, concat(u.cedula, ' / ', u.primer_apellido, ' ', u.primer_nombre) as usuario, r.nombre as rol, e.nombre as entorno, b.accion as accion FROM bitacora b INNER JOIN usuarios_roles ur ON b.id_usuario_roles= ur.id INNER JOIN rol r ON ur.id_rol=r.id INNER JOIN usuario u ON u.id=ur.id_usuario INNER JOIN entorno_sistema e ON e.id=b.id_entorno");
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
        $respuestaArreglo = [];
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

    public function validar_expresiones($fecha_inicio,$fecha_fin){
        $er_fecha ="/^\d{4}-\d{2}-\d{2} \d{1,2}:\d{1,2}$/";
        if(!preg_match_all($er_fecha,$fecha_inicio)){
            $respuesta["resultado"]=true;
            $respuesta["mensaje"]="El formato fecha campo 1 es invalido";
        }else if(!preg_match_all($er_fecha,$fecha_fin)){
            $respuesta["resultado"]=true;
            $respuesta["mensaje"]="El formato fecha campo 2 es invalido";
        }else{
            $respuesta["resultado"]=false;
            $respuesta["mensaje"]="";
        }
        return $respuesta;
    }

}