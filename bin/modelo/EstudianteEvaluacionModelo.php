<?php
namespace modelo;
use config\connect\connectDB as connectDB;
class EstudianteEvaluacionModelo extends connectDB{
	private $id; 
	private $id_estudiante;
	private $id_unidad_evaluacion;
	private $descripcion;
	private $archivo_adjunto;
	private $fecha_entrega;
	private $calificacion;

	public function set_id($valor){
		$this->id = $valor;
	}
	public function set_id_estudiante($valor){
		$this->id_estudiante = $valor;
	}
	public function set_id_unidad_evaluacion($valor){
		$this->id_unidad_evaluacion = $valor;
	}
	public function set_descripcion($valor){
		$this->descripcion = $valor;
	}
	public function set_archivo_adjunto($valor){
		$this->archivo_adjunto = $valor;
	}
	public function set_fecha_entrega($valor){
		$this->fecha_entrega = $valor;
	}
	public function set_calificacion($valor){
		$this->calificacion = $valor;
	}

	public function get_id(){
		return $this->id;
	}
	public function get_id_estudiante(){
		return $this->id_estudiante;
	}
	public function get_id_unidad_evaluacion(){
		return $this->id_unidad_evaluacion;
	}
	public function get_descripcion(){
		return $this->descripcion;
	}
	public function get_archivo_adjunto(){
		return $this->archivo_adjunto;
	}
	public function get_fecha_entrega(){
		return $this->fecha_entrega;
	}
	public function get_calificacion(){
		return $this->calificacion;
	}
	

	public function incluir($id_estudiante, $id_unidad_evaluacion, $fecha_entrega, $descripcion, $archivo_adjunto){
		try {

			$sql = "INSERT INTO estudiante_evaluacion(id_usuario, id_unidad_evaluacion, fecha_entrega, descripcion, archivo_adjunto)
			VALUES(?,?,?,?,?)";
			
			$values = [$id_estudiante, $id_unidad_evaluacion, $fecha_entrega, $descripcion, $archivo_adjunto];

			$stmt = $this->conex->prepare($sql); 

			$stmt->execute($values);

			return true;
		} catch(Exception $e) {
			return $e->getMessage();
		}
		
	}

	public function limpiar(){

		try {			
			$sql = "DELETE from estudiante_evaluacion WHERE id_usuario = ?"; 

			$values = [$this->id_estudiante];

			$stmt = $this->conex->prepare($sql); 

			$stmt->execute($values);

			return true;
		} catch(Exception $e) {
			return $e->getMessage();
		}
	}
	public function listar($id_estudiante)
	{
		try {
			$sql = "SELECT ue.id as unidad_evaluacion ,e.id as id, e.nombre as nombre, e.archivo_adjunto as archivo, ue.fecha_inicio as inicio, ue.fecha_cierre as cierre FROM unidad as u INNER JOIN unidad_evaluaciones as ue ON u.id=ue.id_usuario INNER JOIN evaluaciones as e ON e.id=ue.id_unidad_evaluacion WHERE u.id= ? ";
            
            $respuestaArreglo = [];

            $values = [$id_estudiante];

            $stmt = $this->conex->prepare($sql); 

            $stmt->execute($values);

            $respuestaArreglo = $stmt->fetchAll();

		} catch (Exception $e) {
			return $e->getMessage();
		}
		return $respuestaArreglo;
	}

	public function relacion_modulo($id_estudiante, $id_unidad_evaluacion){
		try{
			$sql = "SELECT p.id as estudiante_evaluacion FROM estudiante_evaluacion p INNER JOIN rol r ON p.id_estudiante= r.id INNER JOIN modulo_sistema m ON m.id=p.id_unidad_evaluacion WHERE r.id= ? AND m.id= ?"; 

            $values = [$id_estudiante, $id_unidad_evaluacion];

            $stmt = $this->conex->prepare($sql); 

            $stmt->execute($values);

            $fila = $stmt->fetchAll();
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

	public function cargar($id_estudiante, $id_unidad_evaluacion)
	{
		try {
			$sql = "SELECT ee.calificacion as calificacion, ee.id as id, ee.descripcion as descripcion, ee.archivo_adjunto as archivo, ee.fecha_entrega as fecha FROM estudiante_evaluacion as ee INNER JOIN unidad_evaluaciones as ue ON ee.id_unidad_evaluacion=ue.id INNER JOIN usuario as e ON e.id= ee.id_usuario WHERE e.id= ? AND ue.id= ?"; 
			
			$respuestaArreglo = [];
            
			$values = [$id_estudiante, $id_unidad_evaluacion];

            $stmt = $this->conex->prepare($sql); 

            $stmt->execute($values);

            $respuestaArreglo = $stmt->fetchAll();

		} catch (Exception $e) {
			return $e->getMessage();
		}
		return $respuestaArreglo;
	}

	public function editar($id_estudiante, $id_unidad_evaluacion)
	{
		try {
			$sql = "SELECT ee.id as id, ee.descripcion as descripcion, ee.archivo_adjunto as archivo_adjunto, ee.fecha_entrega as fecha, ue.id as unidad_eval, e.id as id_estudent FROM estudiante_evaluacion as ee INNER JOIN unidad_evaluaciones as ue ON ee.id_unidad_evaluacion=ue.id INNER JOIN usuario as e ON e.id= ee.id_usuario WHERE e.id= ? AND ee.id= ? "; 
			
			$respuestaArreglo = [];
            
			$values = [$id_estudiante, $id_unidad_evaluacion];

            $stmt = $this->conex->prepare($sql); 

            $stmt->execute($values);

            $respuestaArreglo = $stmt->fetchAll();
		} catch (Exception $e) {
			return $e->getMessage();
		}
		return $respuestaArreglo;
	}

	public function modificar(){
		try {

			$sql = "UPDATE estudiante_evaluacion SET id_usuario= ?, id_unidad_evaluacion = ?, fecha_entrega = ?, descripcion = ? WHERE id = ?";  

			$values = [
				$this->id_estudiante,
				$this->id_unidad_evaluacion,
				$this->fecha_entrega,
				$this->descripcion,
				$this->id,
			];

			$stmt = $this->conex->prepare($sql); 

			$stmt->execute($values);
			
			return true;
		} catch(Exception $e) {
			return $e->getMessage();
		}
	}

	public function mostar_calificacion($id)
	{
		$resultado = $this->conex->prepare("SELECT ee.id as id, ee.archivo_adjunto as archivo_adjunto, concat(e.cedula, ' / ', e.primer_nombre, ' ', e.primer_apellido) as estudiante, ee.calificacion as calificacion FROM estudiante_evaluacion as ee INNER JOIN unidad_evaluaciones as ue ON ee.id_unidad_evaluacion=ue.id INNER JOIN usuario as e ON e.id= ee.id_usuario WHERE ee.id='$id'");
		$respuestaArreglo = [];
		try {
			$resultado->execute();
			$respuestaArreglo = $resultado->fetchAll();
		} catch (Exception $e) {
			return $e->getMessage();
		}
		return $respuestaArreglo;
	}

	public function calificar($id, $calificacion){
		$validar_evaluacion = $this->existe($id);
		if ($validar_evaluacion==false) {
            $respuesta['resultado'] = 3;
            $respuesta['mensaje'] = "La evaluacion que indica no existe";
        } 
        else{
			try {
				$this->conex->query("UPDATE estudiante_evaluacion SET calificacion = '$calificacion' WHERE id = '$id'");
				$respuesta['resultado'] = 1;
                $respuesta['mensaje'] = "Calificación guardada";
			} catch(Exception $e) {
				$respuesta['resultado'] = 0;
                $respuesta['mensaje'] = $e->getMessage();
			}
        }
        return $respuesta;
	}

	public function mostrarEntregas($evaluacion){
		$resultado = $this->conex->prepare("SELECT e.id, ee.id as id, u.id as id_estudiante, u.cedula as cedula, CONCAT(u.primer_nombre, ' ', u.segundo_nombre, ' ', u.primer_apellido, ' ', u.segundo_apellido) as nombre_estudiante, ee.id as id_evaluacion, ee.calificacion as calificacion, ee.descripcion as descripcion_evaluacion, ee.fecha_entrega as fecha, ee.archivo_adjunto as archivo FROM rol r INNER JOIN usuarios_roles ur ON r.id=ur.id_rol INNER JOIN usuario u ON u.id=ur.id_usuario INNER JOIN estudiante_evaluacion ee ON ee.id_usuario=u.id INNER JOIN unidad_evaluaciones ue ON ue.id=ee.id_unidad_evaluacion INNER JOIN evaluaciones e ON e.id= ue.id_evaluacion WHERE ue.id='$evaluacion' AND r.nombre='Estudiante' GROUP BY u.id;");
		$respuestaArreglo = [];
		try{
			$resultado->execute();
			$respuestaArreglo = $resultado->fetchAll();
		}catch(Exception $e){
			return $e->getMessage();
		}
		return $respuestaArreglo;
	}

	public function reporteAprobadosReprobados($id_aula, $id_unidad, $id_evaluacion){
		$total = 0;
		$aprobados = 0;
		$reprobados = 0;

		//Consulta para obtener el total de estudiantes de un aula
		$resultado = $this->conex->prepare("SELECT COUNT(ae.id) as cant_estudiante FROM aula a INNER JOIN aula_estudiante ae ON a.id=ae.id_aula WHERE a.id='$id_aula';");
		$resultado->execute();
        if($resultado){
        	foreach($resultado as $r){
        		$total = $r['cant_estudiante'];
        	}
        }

        //Consulta para obtener el total de estudiantes aprobados
		$query_aprobados = $this->conex->prepare("SELECT COUNT(*) as aprobados FROM estudiante_evaluacion ee INNER JOIN unidad_evaluaciones ue ON ee.id_unidad_evaluacion=ue.id INNER JOIN evaluaciones e ON e.id=ue.id_evaluacion INNER JOIN unidad u ON u.id=ue.id_unidad WHERE u.id='$id_unidad' AND e.id='$id_evaluacion' AND ee.calificacion>9.49;");
		$query_aprobados->execute();
        if($query_aprobados){
        	foreach($query_aprobados as $r){
        		$aprobados = $r['aprobados'];
        	}
        }

        $reprobados = $total-$aprobados;



        $r['aprobados']= ($aprobados/$total)* 100;
        $r['reprobados']= ($reprobados/$total)* 100;
        return $r;
	}

	public function existe($id)
    {
        try {
            $resultado = $this->conex->prepare("SELECT * FROM estudiante_evaluacion WHERE id='$id'");
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

}
?>