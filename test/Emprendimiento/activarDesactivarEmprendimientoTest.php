<?php 
use PHPUnit\Framework\TestCase;
use modelo\EmprendimientoModelo as Emprendimiento;
class activarDesactivarEmprendimientoTest extends TestCase{
    private $emprendimiento;

	public function setUp():void{
        $this->emprendimiento= new Emprendimiento();
	}
	
	//1-cuando el usuairo activa o desactiva un emprendimiento que no existe
		public function testValidarEmprendimientoStatus(){
		$respuesta = $this->emprendimiento->actualizarstatus(20,"true");
		$this->assertEquals(3, $respuesta['resultado']);
	}
}

 ?>