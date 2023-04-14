<?php
namespace modelo;
use config\connect\connectDB as connectDB;
class NotificacionesModelo extends connectDB
{
    private $id;
    private $mensaje;
    private $id_unidad_evaluaciones;
    private $id_usuarios_roles;
    private $fecha;

    public function set_id($valor)
    {
        $this->id = $valor;
    }
    public function set_mensaje($valor)
    {
        $this->mensaje = $valor;
    }
    public function set_id_unidad_evaluaciones ($valor)
    {
        $this->id_unidad_evaluaciones  = $valor;
    }
    public function set_id_usuarios_roles ($valor)
    {
        $this->id_usuarios_roles  = $valor;
    }
    public function set_fecha($valor)
    {
        $this->fecha = $valor;
    }
   
    public function get_id()
    {
        return $this->id;
    }

    public function get_mensaje()
    {
        return $this->mensaje;
    }

    public function guardar_notificacion(){
        $validar = $this->validar_registro($this->id_usuarios_roles,$this->id_unidad_evaluaciones);
        if($validar=='true'){
            $this->modificar();
        }
        else
            $this->incluir();
    }

    public function incluir()
    {
            try {
                $this->conex->query("INSERT INTO notificaciones(
        					mensaje,
        					id_unidad_evaluaciones ,
        					id_usuarios_roles ,
        					fecha
        					)
        				VALUES(
        					'$this->mensaje',
        					'$this->id_unidad_evaluaciones ',
        					'$this->id_usuarios_roles ',
        					'$this->fecha'
        				)");
            } catch (Exception $e) {
                return $e->getMessage();
            }
    }

    public function modificar()
    {
            try {
                $this->conex->query("UPDATE notificaciones SET fecha = DATE(NOW()) WHERE id_usuarios_roles = '$this->id_usuarios_roles' AND id_unidad_evaluaciones='$this->id_unidad_evaluaciones'");
                return true;
            } catch (Exception $e) {
                return $e->getMessage();
            }
    }

    public function listar($id_usuario, $rol)
    {
        $x = array();
        $array = array();
        if($rol == "Docente" || $rol == "Estudiante"){
        try{
            $rol_ingresado = $rol == 'Docente' ? 'aula_docente ad ON ad.id_docente' : 'aula_estudiante ad ON ad.id_estudiante';
            $rol_buscar = $rol == 'Docente' ? 'Estudiante' : 'Docente';
            $buscar = $this->conex->prepare("SELECT ue.id as unidad_evaluaciones FROM usuario us INNER JOIN  $rol_ingresado=us.id INNER JOIN aula a ON a.id=ad.id_aula INNER JOIN unidad u ON a.id=u.id_aula INNER JOIN unidad_evaluaciones ue ON u.id=ue.id_unidad WHERE us.id=$id_usuario;");
            $buscar->execute();
            if($buscar){        
                $x = array();
                foreach($buscar as $data){
                    $resultado = $this->conex->prepare("SELECT n.id, n.mensaje as mensaje, us.nombre as nombre, us.apellido as apellido, r.nombre as rol, n.fecha as fecha, ur.id as id_usuarios_roles, ue.id as id_unidad_evaluaciones FROM notificaciones n INNER JOIN usuarios_roles ur ON n.id_usuarios_roles=ur.id INNER JOIN unidad_evaluaciones ue ON n.id_unidad_evaluaciones=ue.id INNER JOIN usuario us ON us.id=ur.id_usuario INNER JOIN rol r ON ur.id_rol=r.id INNER JOIN unidad u ON u.id=ue.id_unidad INNER JOIN aula a ON a.id=u.id_aula INNER JOIN aula_docente ad ON ad.id_aula=a.id  WHERE r.nombre='".$rol_buscar."'ORDER BY  fecha DESC LIMIT 4");
                    $resultado->execute();
                    $respuestaArreglo = $resultado->fetchAll();   
                }
                foreach($respuestaArreglo as $r => $valor){
                    $x["modulo"][] = '<a  style="text-decoration: none;" href=?pagina=MostrarEvaluacion&id_unidad_evaluacion='.$valor['id_unidad_evaluaciones'].'> <div class="alert alert-primary alert-dismissible fade show" role="alert">'.$valor['mensaje'].' por '.$valor['nombre'].' '.$valor['apellido'].' Fecha: '.date('d-m-Y h:i:s', strtotime($valor['fecha'])).' <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div></a>';
                }
                foreach($respuestaArreglo as $r => $valor){
                    $x["icono"][] = '<a style="text-decoration: none;" href=?pagina=MostrarEvaluacion&id_unidad_evaluacion='.$valor['id_unidad_evaluaciones'].'><div class="mx-1 alert alert-secondary alert-dismissible fade show" role="alert"> '.$valor['mensaje'].' <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div></a>';
                }
            }
                
        } catch (Exception $e) {
            $x['resultado'] = 'error';
            $x['mensaje'] = $e->getMessage();
        }
    }
    return $x;
    }
    public function cargar($id)
    {
        $resultado = $this->conex->prepare("SELECT * FROM usuario WHERE
			id = '$id'
			");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    private function validar_registro($id_usuarios_roles, $id_unidad_evaluaciones)
    {
        try {
            $resultado = $this->conex->prepare("SELECT * FROM notificaciones WHERE id_usuarios_roles='$id_usuarios_roles' AND id_unidad_evaluaciones='$id_unidad_evaluaciones'");
            $resultado->execute();
            $fila = $resultado->fetchAll();
            if ($fila) {
                return 'true';
            } else {
                return 'false';
            }
        } catch (Exception $e) {
            return 'false';
        }
    }

}