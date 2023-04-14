<?php 
use PHPUnit\Framework\TestCase;
use modelo\PermisosModelo as Permisos;

class asignarPermisosTest extends TestCase{
	private $Permisos;

	public function setUp():void{
		$this->Permisos = new Permisos();
	}
	//1-Cuando el usuario Ingresa un Permisos con el mismo nombre de otro registro
	public function testInclir(){
		$respuesta = $this->Permisos->gestionarpermisos(5,17,"true","true","true","true","true");
		$this->assertEquals(1, $respuesta['resultado']);
	}
	
	//3-Cuando el usuario registra un Permisos correctamente
	public function testEliminar(){
		$respuesta = $this->Permisos->gestionarpermisos(5,17,"false","true","true","true","true");
		$this->assertEquals(2, $respuesta['resultado']);
	}

	//2-Cuando el usuario envia al nombre del Modulo con un valor con caracteres especiales
	public function testActualizar(){
		$respuesta = $this->Permisos->gestionarpermisos(5,2,"true","true","false","false","true");
		$this->assertEquals(3, $respuesta['resultado']);
	}
}

 ?>