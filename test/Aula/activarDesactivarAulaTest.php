<?php 
use PHPUnit\Framework\TestCase;
use modelo\AulaModelo as Aula;

class activarDesactivarAulaTest extends TestCase{
	private $Aula;

	public function setUp():void{
		$this->Aula = new Aula();
	}
    //No existe el aula que se desea activa o desactivar
	public function testValidaExiste(){
		$respuesta = $this->Aula->actualizarstatus(100, "true");
		$this->assertEquals(0, $respuesta['resultado']);
	}
	
	public function testActivarAula(){
		$respuesta = $this->Aula->actualizarstatus(10, "true");
		$this->assertEquals(1, $respuesta['resultado']);
	}

    public function testDesactivarAula(){
		$respuesta = $this->Aula->actualizarstatus(10, "false");
		$this->assertEquals(2, $respuesta['resultado']);
	}
}
 ?>