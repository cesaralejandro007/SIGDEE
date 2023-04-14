<?php
namespace modelo;
use config\connect\connectDB as connectDB;
class UsuariosRolesModelo extends connectDB
{
	private $id;
	private $id_usuario;
	private $id_rol;

	public function set_id($valor)
	{
		$this->id = $valor;
	}
	public function set_id_usuario($valor)
	{
		$this->id_usuario = $valor;
	}
	public function set_id_rol($valor)
	{
		$this->id_rol = $valor;
	}

	public function get_id()
	{
		return $this->id;
	}
	public function get_id_usuario()
	{
		return $this->id_usuario;
	}
	public function get_id_rol()
	{
		return $this->id_rol;
	}


    public function incluirDocentes($id_usuario,$id_rol)
	{
		$validar_registro = $this->validar_registroD($id_usuario,$id_rol);
		if ($this->existe($id_usuario)==false) {
            $respuesta['resultado'] = 3;
            $respuesta['mensaje'] = "El Usuario no Existe";
            return $respuesta;
        }
		else if ($validar_registro) {
			$respuesta['resultado'] = 2;
			$respuesta['mensaje'] = "La persona ya encuentra registrado";
		} else {
			try {
				$this->conex->query("INSERT INTO usuarios_roles(
					id_usuario, id_rol)
				VALUES('$id_usuario', '$id_rol')");
				$respuesta['resultado'] = 1;
				$respuesta['mensaje'] = "Registro exitoso";
			} catch (Exception $e) {
                $respuesta['resultado'] = 0;
                $respuesta['mensaje'] = $e->getMessage();
			}
		}
		return $respuesta;
	}

    public function incluirEstudiantes($id_usuario,$id_rol)
	{
		$validar_registro = $this->validar_registroE($id_usuario,$id_rol);
        if ($this->existe($id_usuario)==false) {
            $respuesta['resultado'] = 3;
            $respuesta['mensaje'] = "El Usuario no Existe";
            return $respuesta;
        }
		else if ($validar_registro) {
			$respuesta['resultado'] = 2;
			$respuesta['mensaje'] = "La persona ya encuentra registrado";
		} else {
			try {
				$this->conex->query("INSERT INTO usuarios_roles(
					id_usuario, id_rol)
				VALUES('$id_usuario', '$id_rol')");
				$respuesta['resultado'] = 1;
				$respuesta['mensaje'] = "Registro exitoso";
			} catch (Exception $e) {
                $respuesta['resultado'] = 0;
                $respuesta['mensaje'] = $e->getMessage();
			}
		}
		return $respuesta;
	}

    public function eliminarD($id_usuario,$id_rol)
	{
        if ($this->existe($id_usuario)==false) {
            $respuesta['resultado'] = 3;
            $respuesta['mensaje'] = "El Usuario no Existe";
        }else if ($this->existeaulaEstudiantes($id_usuario)==true) {
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = "El Estudiante no puede ser borrado, se encuentra asignado a un aula";
        }else{
            try {
                $this->conex->query("DELETE from usuarios_roles
                    WHERE id_usuario ='$id_usuario' and id_rol = '$id_rol' ");
                $respuesta['resultado'] = 1;
                $respuesta['mensaje'] = "Eliminacion exitosas";
            } catch (Exception $e) {
                $respuesta['resultado'] = 0;
                $respuesta['mensaje'] = $e->getMessage();
            }
        }
		return $respuesta;
	}


	public function eliminarE($id_usuario,$id_rol)
	{
        if ($this->existe($id_usuario)==false) {
            $respuesta['resultado'] = 3;
            $respuesta['mensaje'] = "El Usuario no Existes";
        }else if ($this->existeaulaDocente($id_usuario)==true) {
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = "El Docente no puede ser borrado, se encuentra asignado a un aula";
        }else{
            try {
                $this->conex->query("DELETE from usuarios_roles
                    WHERE id_usuario ='$id_usuario' and id_rol = '$id_rol' ");
                $respuesta['resultado'] = 1;
                $respuesta['mensaje'] = "Eliminacion exitosas";
            } catch (Exception $e) {
                $respuesta['resultado'] = 0;
                $respuesta['mensaje'] = $e->getMessage();
            }
        }
		return $respuesta;
	}

	public function existeaulaDocente($id)
    {
        try {
            $resultado = $this->conex->prepare("SELECT * FROM aula_docente WHERE id_docente='$id'");
            $resultado->execute();
            $fila = $resultado->rowCount();
            if ($fila > 0) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }

	public function existeaulaEstudiantes($id)
    {
        try {
            $resultado = $this->conex->prepare("SELECT * FROM aula_estudiante WHERE id_estudiante='$id'");
            $resultado->execute();
            $fila = $resultado->rowCount();
            if ($fila > 0) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }

    public function existe_usuario($id)
    {
		$resultado = $this->conex->prepare("SELECT * FROM usuario WHERE id = '$id'");
		$respuestaArreglo = [];
		try {
			$resultado->execute();
			$respuestaArreglo = $resultado->fetchAll();
		} catch (Exception $e) {
			return $e->getMessage();
		}
		return $respuestaArreglo;
    }
    
    public function existe($id)
    {
        try {
            $resultado = $this->conex->prepare("SELECT * FROM usuario WHERE id='$id'");
            $resultado->execute();
            $fila = $resultado->fetchAll();
            if ($fila) {
                return true;
            } else {
                return false;
            }

        } catch (Exception $e) {
            return false;
        }
    }

	public function buscar($id_rol, $id_usuario)
	{
		$resultado = $this->conex->prepare("SELECT tm.id as id, t.nombre as tipo, m.nombre as modelo FROM emprendimiento as t INNER JOIN usuarios_roles as tm ON t.id= tm.id_rol INNER JOIN modulo as m ON m.id=tm.id_usuario WHERE t.id= '$id_rol' AND m.id='$id_usuario'");
		$respuestaArreglo = [];
		try {
			$resultado->execute();
			$respuestaArreglo = $resultado->fetchAll();
		} catch (Exception $e) {
			return $e->getMessage();
		}
		return $respuestaArreglo;
	}

	public function validar_registroD($id_usuario)
	{
		try {
			$resultado = $this->conex->prepare("SELECT * FROM usuarios_roles,rol WHERE usuarios_roles.id_rol = rol.id and usuarios_roles.id_usuario ='$id_usuario' AND rol.nombre='Docente' || rol.nombre='Docentes'");
			$resultado->execute();
			$fila = $resultado->fetchAll();
			if ($fila) {
				return true;
			} else {
				return false;
			}
		} catch (Exception $e) {
			return false;
		}
	}

	public function validar_registroE($id_usuario)
	{
		try {
			$resultado = $this->conex->prepare("SELECT * FROM usuarios_roles,rol WHERE usuarios_roles.id_rol = rol.id and usuarios_roles.id_usuario ='$id_usuario' AND rol.nombre='Estudiante' || rol.nombre='Estudiantes'");
			$resultado->execute();
			$fila = $resultado->fetchAll();
			if ($fila) {
				return true;
			} else {
				return false;
			}
		} catch (Exception $e) {
			return false;
		}
	}

	public function buscar_rol($rol)
	{
		$resultado = $this->conex->prepare("SELECT * FROM rol WHERE nombre = '$rol'");
		$respuestaArreglo = [];
		try {
			$resultado->execute();
			$respuestaArreglo = $resultado->fetchAll();
		} catch (Exception $e) {
			return $e->getMessage();
		}
		return $respuestaArreglo;
	}
}