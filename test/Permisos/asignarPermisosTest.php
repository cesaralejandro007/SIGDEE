<?php 
use PHPUnit\Framework\TestCase;
use modelo\PermisosModelo as Permisos;

class asignarPermisosTest extends TestCase{
	private $Permisos;

	public function setUp():void{
		$this->Permisos = new Permisos();
	}
	
	public function testInclir(){
		$id_rol = 5;
		$id_entorno = 17;
		$entorno = "true";
		$registrar = "true";
		$consultar = "true";
		$eliminar = "true";
		$modificar = "true";
		$respuesta = $this->Permisos->gestionarpermisos($id_rol,$id_entorno,$entorno,$registrar,$consultar,$eliminar,$modificar);
		$this->assertEquals(1, $respuesta['resultado']);
	}
	
	public function testEliminar(){
		$id_rol = 5;
		$id_entorno = 17;
		$entorno = "false";
		$registrar = "true";
		$consultar = "true";
		$eliminar = "true";
		$modificar = "true";
		$respuesta = $this->Permisos->gestionarpermisos($id_rol,$id_entorno,$entorno,$registrar,$consultar,$eliminar,$modificar);
		$this->assertEquals(2, $respuesta['resultado']);
	}

	public function testActualizar(){
		$id_rol = 5;
		$id_entorno = 2;
		$entorno = "true";
		$registrar = "true";
		$consultar = "true";
		$eliminar = "false";
		$modificar = "false";
		$respuesta = $this->Permisos->gestionarpermisos($id_rol,$id_entorno,$entorno,$registrar,$consultar,$eliminar,$modificar);
		$this->assertEquals(3, $respuesta['resultado']);
	}
	public function testExisteRol(){
		$id_rol = 523423;
		$id_entorno = 2;
		$entorno = "true";
		$registrar = "true";
		$consultar = "true";
		$eliminar = "false";
		$modificar = "false";
		$respuesta = $this->Permisos->gestionarpermisos($id_rol,$id_entorno,$entorno,$registrar,$consultar,$eliminar,$modificar);
		$this->assertEquals(5, $respuesta['resultado']);
	}
	public function testExisteEntorno(){
		$id_rol = 5;
		$id_entorno = 223423;
		$entorno = "true";
		$registrar = "true";
		$consultar = "true";
		$eliminar = "true";
		$modificar = "true";
		$respuesta = $this->Permisos->gestionarpermisos(5,223423,"true","true","false","false","true");
		$this->assertEquals(6, $respuesta['resultado']);
	}
}

 ?>