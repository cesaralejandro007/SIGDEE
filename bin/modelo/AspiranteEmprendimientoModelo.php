<?php
namespace modelo;
use config\connect\connectDB as connectDB;
class AspiranteEmprendimientoModelo extends connectDB{
	private $id; 
	private $id_usuario;
	private $id_emprendimiento;

	public function set_id($valor){
		$this->id = $valor;
	}
	public function set_id_usuario($valor){
		$this->id_usuario = $valor;
	}
	public function set_id_emprendimiento($valor){
		$this->id_emprendimiento = $valor;
	}
	

	public function get_id(){
		return $this->id;
	}
	public function get_id_usuario(){
		return $this->id_usuario;
	}
	public function get_id_emprendimiento(){
		return $this->id_emprendimiento;
	}
	

	public function incluir($id_usuario, $id_emprendimiento){
		
		try {
			$this->conex->query("INSERT INTO aspirante_emprendimiento(
				id_usuario, id_emprendimiento)
			VALUES('$id_usuario', '$id_emprendimiento')");
			return true;
		} catch(Exception $e) {
			return $e->getMessage();
		}
	}


	public function modificar(){
		$validar_modificar = $this->validar_modificar($this->id_usuario, $this->id);
		if ($validar_modificar) {
			return false;
		}
		else{
			$co = $this->conecta();
			$this->conex->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			try {
				$this->conex->query("UPDATE aspirante_emprendimiento SET id_usuario = '$this->id_usuario', id_emprendimiento = '$this->id_emprendimiento' WHERE id = '$this->id'");
				return true;
			} catch(Exception $e) {
				return $e->getMessage();
			}
		}
	}

	public function eliminar(){
		if($this->existe($this->id)){
			try {
				$this->conex->query("DELETE from aspirante_emprendimiento 
					WHERE id = '$this->id'");
				return true;
			} catch(Exception $e) {
				return $e->getMessage();
			}
		}
		else{
			return false;
		}
	}

	public function listar(){
		$resultado = $this->conex->prepare("SELECT a.id as id_emprendimiento, t.id as id, t.id_usuario as id_usuario, a.id_usuario as area FROM aspirante_emprendimiento t INNER JOIN area_emprendimiento a ON a.id= t.id_emprendimiento");
		$respuestaArreglo = [];
		try{
			$resultado->execute();
			$respuestaArreglo = $resultado->fetchAll();
		}catch(Exception $e){
			return $e->getMessage();
		}
		return $respuestaArreglo;
	}

	public function buscar($id_emprendimiento, $id_usuario){
		$resultado = $this->conex->prepare("SELECT tm.id as id, t.nombre as tipo, m.nombre as modelo FROM emprendimiento as t INNER JOIN aspirante_emprendimiento as tm ON t.id= tm.id_emprendimiento INNER JOIN modulo as m ON m.id=tm.id_usuario WHERE t.id= '$id_emprendimiento' AND m.id='$id_usuario'");
		$respuestaArreglo = [];
		try{
			$resultado->execute();
			$respuestaArreglo = $resultado->fetchAll();
		}catch(Exception $e){
			return $e->getMessage();
		}
		return $respuestaArreglo;
	}

	public function mostrar_modulos($id_tipo){
		try{
			$resul = $this->conex->query("SELECT m.nombre as nombre, m.id as id FROM emprendimiento as t INNER JOIN aspirante_emprendimiento as tm ON t.id= tm.id_emprendimiento INNER JOIN modulo as m ON m.id=tm.id_usuario WHERE t.id='$id_tipo'");
			if($resul){
				$res = "<option value=''>Seleccione</option>";
				foreach($resul as $r){
					$res = $res."<option value='".$r['id']."'>";
					$res = $res.$r['nombre'];
					$res = $res."</option>";
				}
				return $res; 
			}
			else{
				return '';
			}
			
		}catch(Exception $e){
			return $e->getMessage();
		}
	}

	public function validar_modificar($id_usuario, $id){
		try{
			$resultado = $this->conex->prepare("SELECT * FROM aspirante_emprendimiento WHERE id_usuario='$id_usuario' AND id<>'$id'");
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

	public function existe($id){
		try{
			$resultado = $this->conex->prepare("SELECT * FROM aspirante_emprendimiento WHERE id='$id'");
			$resultado->execute();
			$fila = $resultado->fetchAll();
			if($fila){
				return true;
			}
			else{
				return false; 
			}
			
		}catch(Exception $e){
			return false;
		}
	}	
}
?>