<?php
namespace modelo;
use config\connect\connectDB as connectDB;
class UnidadContenidoModelo extends connectDB{
	private $id; 
	private $id_unidad;
	private $id_contenido;

	public function set_id($valor){
		$this->id = $valor;
	}
	public function set_id_unidad($valor){
		$this->id_unidad = $valor;
	}
	public function set_id_contenido($valor){
		$this->id_contenido = $valor;
	}

	public function get_id(){
		return $this->id;
	}
	public function get_id_unidad(){
		return $this->id_unidad;
	}
	public function get_id_contenido(){
		return $this->id_contenido;
	}
	
	

	public function incluir(){
		try {
			$this->conex->query("INSERT INTO unidad_contenido(id_unidad, id_contenido)
			VALUES('$this->id_unidad', '$this->id_contenido')");
			return true;
		} catch(Exception $e) {
			return $e->getMessage();
		}
		
	}

	public function limpiar(){

		try {
			$this->conex->query("DELETE from unidad_contenido 
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
        $resultado = $this->conex->prepare("SELECT c.id as id, c.nombre as nombre, c.descripcion as descripcion, c.archivo_adjunto as archivo FROM unidad as u INNER JOIN unidad_contenido as uc ON u.id=uc.id_unidad INNER JOIN contenido as c ON c.id=uc.id_contenido WHERE u.id='$id_unidad'");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }
	public function relacion_modulo($id_unidad, $id_contenido){
		try{
			
			$resultado = $this->conex->prepare("SELECT p.id as unidad_contenido FROM unidad_contenido p
				INNER JOIN rol r ON p.id_unidad= r.id INNER JOIN modulo_sistema m ON m.id=p.id_contenido WHERE r.id= '$id_unidad' AND m.id= '$id_contenido'");
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
}
?>