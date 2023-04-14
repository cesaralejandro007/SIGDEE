<?php
namespace modelo;
use config\connect\connectDB as connectDB;
class EntornoSistemaModelo extends connectDB{
	private $id;
    private $nombre;

	public function listar(){
		$resultado = $this->conex->prepare("SELECT id, nombre FROM entorno_sistema");
		$respuestaArreglo = [];
		try{
			$resultado->execute();
			$respuestaArreglo = $resultado->fetchAll();
		}catch(Exception $e){
			return $e->getMessage();
		}
		return $respuestaArreglo;
	}
}
?>
