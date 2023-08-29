<?php 
use PHPUnit\Framework\TestCase;
use modelo\PermisosModelo as Permisos;

class asignarPermisosTest extends TestCase{
	private $Permisos;

	public function setUp():void{
		$this->Permisos = new Permisos();
	}
	
	public function testInclir(){
		$respuesta = $this->Permisos->gestionarpermisos(5,17,"true","true","true","true","true");
		$this->assertEquals(1, $respuesta['resultado']);
	}
	
	public function testEliminar(){
		$respuesta = $this->Permisos->gestionarpermisos(5,17,"false","true","true","true","true");
		$this->assertEquals(2, $respuesta['resultado']);
	}

	public function testActualizar(){
		$respuesta = $this->Permisos->gestionarpermisos(5,2,"true","true","false","false","true");
		$this->assertEquals(3, $respuesta['resultado']);
	}
	public function testExisteRol(){
		$respuesta = $this->Permisos->gestionarpermisos(523423,2,"true","true","false","false","true");
		$this->assertEquals(5, $respuesta['resultado']);
	}
	public function testExisteEntorno(){
		$respuesta = $this->Permisos->gestionarpermisos(5,223423,"true","true","false","false","true");
		$this->assertEquals(6, $respuesta['resultado']);
	}
}

 ?>