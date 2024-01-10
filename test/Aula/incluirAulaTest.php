<?php 
use PHPUnit\Framework\TestCase;
use modelo\AulaModelo as Aula;
use modelo\AulaEstudianteModelo as AulaEstudiante;
use modelo\AulaDocenteModelo as AulaDocente;
use modelo\EmprendimientoModelo as Emprendimiento;
use modelo\ModuloModelo as Modulo;
use modelo\EmprendimientoModuloModelo as EmprendimientoModulo;
use modelo\DocenteModelo as Docente;
use modelo\EstudianteModelo as Estudiante;
use modelo\UsuariosRolesModelo as UsuariosRoles;
use modelo\UsuarioModelo as Usuario;

class incluirAulaTest extends TestCase{
	private $aula;
	private $aula_estudiante;
	private $modulo_e;
	private $emprendimiento;
	private $emprendimiento_modulo;
	private $docente;
	private $aula_docente;
	private $estudiante;
	private $usuario;
	private $modulo = 'Aula';

	public function setUp():void{
		$this->aula = new Aula();
		$this->aula_estudiante = new AulaEstudiante();
		$this->modulo_e = new Modulo();
		$this->emprendimiento = new Emprendimiento();
		$this->emprendimiento_modulo = new EmprendimientoModulo();
		$this->docente = new Docente();
		$this->aula_docente = new AulaDocente();
		$this->estudiante = new Estudiante();
		$this->usuario = new Usuario();
		$this->usuario_rol = new UsuariosRoles();
		$this->modulo = 'Aula';
	}

	//1-Cuando no encuentra el id_emprendimiento_modulo
	public function testIdEmprendimientoModulo(){
		$id_emprendimiento = 10;
		$id_modulo = 10;
		$id_emprendimiento_modulo = $this->emprendimiento_modulo->buscar_emprendimiento_modulo($id_emprendimiento, $id_modulo);
		if($id_emprendimiento_modulo == 0){
			$respuesta = [
				'estatus' => '0',
				'icon' => 'info',
				'title' => $this->modulo,
				'message' => 'No existe el emprendimiento modulo'
			];
		}
		$this->assertEquals(0, $respuesta['estatus']);
	}

	//2-Cuando se supera los 30 estudiantes en el aula
	public function testSuperaMaximoEstudiantes(){
		$respuesta = [];
		$estudiantes = [124, 145, 2, 10];
		$cantidad_estudiantes = count($estudiantes);
		if($cantidad_estudiantes > 3){
			$respuesta = [
				'estatus' => '0',
				'icon' => 'info',
				'title' => $this->modulo,
				'message' => 'El limite de estudiante es de 30'
			];
		}
		$this->assertEquals(0, $respuesta['estatus']);
	}

	//3-Cuando no hay estudiantes en la lista
	public function testEstudiantesVacio(){
		$respuesta = [];
		$id_estudiantes = [];
		if($id_estudiantes== null){
			$respuesta = [
				'estatus' => '3',
				'icon' => 'info',
				'title' => $this->modulo,
				'message' => 'Debe asignar estudiantes al aula'
			];
		}
		$this->assertEquals(3, $respuesta['estatus']);
	}

	//4-No se encuentra los usuarios con el id de los estudiantes indicados
	public function testIdsEstudiantes(){
		$respuesta = [];
		$id_estudiantes = [11, 15];
		$encontrado = true;
		foreach ($id_estudiantes as $id_estudiante) {
			$id_estudiante = $this->usuario->buscar_id($id_estudiante);
			if($id_estudiante == 0){
				$encontrado = false;
			}
		}
		if($encontrado== false){
			$respuesta = [
				'estatus' => '4',
				'icon' => 'info',
				'title' => $this->modulo,
				'message' => 'El usuario no existe'
			];
		}
		$this->assertEquals(4, $respuesta['estatus']);
	}

	//5-No se encuentra el id del docente indicado
	public function testIdDocente(){
		$respuesta = [];
		$id_docente = 100;
		$validar_docente = $this->docente->buscar_docente($id_docente);   
		if($validar_docente== 0 || empty($id_docente)){
			$respuesta = [
				'estatus' => '5',
				'icon' => 'info',
				'title' => $this->modulo,
				'message' => 'Se debe elegir un docente que exista'
			];
		}
		$this->assertEquals(5, $respuesta['estatus']);
	}

	//6-Registro correcto
	public function testCreacionCorrecta(){
		$respuesta = [];
		$id_estudiantes = [51];
		$id_emprendimiento = 34;
		$id_modulo = 39;
		$id_docente = 50;
		$nombre = 'Nueva aula';
		$cantidad_estudiantes = $id_estudiantes !=null ? count($id_estudiantes) : 0;
		$id_emprendimiento_modulo = $this->emprendimiento_modulo->buscar_emprendimiento_modulo($id_emprendimiento, $id_modulo);
		$respuesta = $this->aula->incluir($nombre, $id_emprendimiento_modulo);
		if ($respuesta['resultado']==1) {
			$buscar_id = $this->aula->buscar_ultimo();
			$this->aula_docente->incluir($buscar_id[0]['id'], $id_docente);
			foreach ($id_estudiantes as $id_estudiante) {
				$this->aula_estudiante->incluir($buscar_id[0]['id'], $id_estudiante);
				$r2 = $this->usuario_rol->buscar_rol('Estudiante');
				$this->usuario_rol->incluirEstudiantes($id_estudiante,$r2[0]['id']);
			}
			$respuesta = [
				'estatus' => '1',
				'icon' => 'success',
				'title' => $this->modulo,
				'message' => $respuesta['mensaje']
			];
		} else {
			$respuesta = [
				'estatus' => '2',
				'icon' => 'info',
				'title' => $this->modulo,
				'message' => $respuesta['mensaje']
			];
		}
		$this->assertEquals(1, $respuesta['estatus']);
	}
	
}

?>