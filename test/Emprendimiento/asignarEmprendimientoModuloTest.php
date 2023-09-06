<?php 
use PHPUnit\Framework\TestCase;
use modelo\EmprendimientoModuloModelo as EmprendimientoModulo;
use modelo\EmprendimientoModelo as Emprendimiento;
class asignarEmprendimientoModuloTest extends TestCase{
	private $emprendimiento_Modulo;
    private $emprendimiento;

	public function setUp():void{
		$this->emprendimiento_Modulo = new EmprendimientoModulo();
        $this->emprendimiento= new Emprendimiento();
	}
	
	//1-Cuando se intenta asignar un  emprendimiento modulo y no existe el modulo
		public function testValidarModulo(){
		$respuesta = $this->emprendimiento_Modulo->incluir(20,1,"true");
		$this->assertEquals(4, $respuesta['resultado']);
	}
	
	//2-Cuando se intenta asignar un emprendimiento modulo y no existe el emprendimiento
	 public function testValidarEmprendimiento(){
		$respuesta = $this->emprendimiento_Modulo->incluir(16,9,"true");
		$this->assertEquals(5, $respuesta['resultado']);
    }
}

 ?>