<?php
namespace modelo;
use config\connect\connectDB as connectDB;
class UnidadEvaluacionModelo extends connectDB{
	private $id; 
	private $id_unidad;
	private $id_evaluacion;
	private $fecha_inicio;
	private $fecha_cierre;

	public	function set_id($valor){
		$this->id = $valor;
	}
	public	function set_id_unidad($valor){
		$this->id_unidad = $valor;
	}
	public	function set_id_evaluacion($valor){
		$this->id_evaluacion = $valor;
	}
	public	function set_fecha_inicio($valor){
		$this->fecha_inicio = $valor;
	}
	public	function set_fecha_cierre($valor){
		$this->fecha_cierre = $valor;
	}

	public	function get_id(){
		return $this->id;
	}
	public	function get_id_unidad(){
		return $this->id_unidad;
	}
	public	function get_id_evaluacion(){
		return $this->id_evaluacion;
	}
	public	function get_fecha_inicio(){
		return $this->fecha_inicio;
	}
	public	function get_fecha_cierre(){
		return $this->fecha_cierre;
	}
	
	

	public	function incluir(){
		$resf = $this->validarfecha($this->fecha_inicio,$this->fecha_cierre);
		if($resf){
		try {
			$this->conex->query("INSERT INTO unidad_evaluaciones(id_unidad, id_evaluacion, fecha_inicio, fecha_cierre)
			VALUES('$this->id_unidad', '$this->id_evaluacion', '$this->fecha_inicio', '$this->fecha_cierre')");
			$respuesta['resultado'] = 1;
			$respuesta['mensaje'] = 'Evaluación agregada';
		} catch(Exception $e) {
			return $e->getMessage();
		}
	}else{
		$respuesta['resultado'] = 2;
		$respuesta['mensaje'] = "Verifique la fecha de apertura";
	}
	return $respuesta;
	}

	public function modificarEvaluacion()
    {
		$resf = $this->validarfecha($this->fecha_inicio,$this->fecha_cierre);
		if($resf){
            try {
                $this->conex->query("UPDATE unidad_evaluaciones SET id_unidad = '$this->id_unidad',id_evaluacion = '$this->id_evaluacion', fecha_inicio = '$this->fecha_inicio', fecha_cierre = '$this->fecha_cierre' WHERE id = '$this->id'");
                $respuesta['resultado'] = 1;
                $respuesta['mensaje'] = "Modificacion exitoso";
            } catch (Exception $e) {
                $respuesta['resultado'] = 0;
                $respuesta['mensaje'] = $e->getMessage();
            }
		}else{
				$respuesta['resultado'] = 3;
				$respuesta['mensaje'] = "Verifique la fecha de apertura";
		}
        return $respuesta;
    }

	public	function limpiar(){

		try {
			$this->conex->query("DELETE from unidad_evaluaciones 
				WHERE
				id_unidad = '$this->id_unidad'
				");
			return true;
		} catch(Exception $e) {
			return $e->getMessage();
		}
	}
	public function listar($id_unidad)
    {
        $resultado = $this->conex->prepare("SELECT ue.id as unidad_evaluacion ,e.id as id, e.nombre as nombre, e.archivo_adjunto as archivo, ue.fecha_inicio as inicio, ue.fecha_cierre as cierre FROM unidad as u INNER JOIN unidad_evaluaciones as ue ON u.id=ue.id_unidad INNER JOIN evaluaciones as e ON e.id=ue.id_evaluacion WHERE u.id='$id_unidad'");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function obtener_id_unidad_evaluacion()
    {
        $resultado = $this->conex->prepare("SELECT ue.id as unidad_evaluacion FROM unidad_evaluaciones as ue ORDER BY ue.id DESC LIMIT 1;");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

	public	function relacion_modulo($id_unidad, $id_evaluacion){
		try{
			
			$resultado = $this->conex->prepare("SELECT p.id as unidad_evaluaciones FROM unidad_evaluaciones p
				INNER JOIN rol r ON p.id_unidad= r.id INNER JOIN modulo_sistema m ON m.id=p.id_evaluacion WHERE r.id= '$id_unidad' AND m.id= '$id_evaluacion'");
			$resultado->execute();	
			$fila = $resultado->fetchAll();
			if($fila){
				return true;    
			}
			else{
				return false;;
			}
		}catch(Exception $e){
			return false;
		}
	}
	public function cargar($id_unidad_evaluacion)
    {
        $resultado = $this->conex->prepare("SELECT ue.id as id, e.descripcion as descripcion, e.nombre as nombre, e.archivo_adjunto as archivo, ue.fecha_inicio as inicio, ue.fecha_cierre as cierre FROM unidad as u INNER JOIN unidad_evaluaciones as ue ON u.id=ue.id_unidad INNER JOIN evaluaciones as e ON e.id=ue.id_evaluacion WHERE ue.id= '$id_unidad_evaluacion'
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
	public function validarfecha($fecha_apertura, $fecha_cierre)
    {
        date_default_timezone_set('America/Caracas');
 
        $fecha_at = strtotime(date("d-m-Y h:i:s"))-100;
        $fecha_ap = strtotime($fecha_apertura);
        $fecha_ac = strtotime($fecha_cierre);

        if($fecha_ap <= $fecha_ac && $fecha_ap >= $fecha_at){
            return true;
        }else{
            return false;
        }
    }
}
?>