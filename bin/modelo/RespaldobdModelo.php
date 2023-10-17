<?php
namespace modelo;
use config\connect\connectDB as connectDB;
use \PDO;
class RespaldobdModelo extends connectDB
{

  public function verificar_password($cedula)
  {
      $validar_usuario_existe = $this->existe_usuario($cedula);
      if ($validar_usuario_existe == false) {
          $respuesta['resultado'] = 3;
          $respuesta['mensaje'] = "El usuario no existe";
          return $respuesta;
      } else {
          try {
              // Usar una consulta preparada con un array para los valores
              $stmt = $this->conex->prepare("SELECT usuario.clave as clave,rol.nombre as rol FROM usuario,usuarios_roles,rol WHERE cedula = ? AND rol.nombre = 'Super Usuario' AND usuarios_roles.id_usuario = usuario.id AND rol.id = usuarios_roles.id_rol");
              $stmt->execute([$cedula]);
              $respuestaArreglo = $stmt->fetchAll();
              return $respuestaArreglo;
          } catch (Exception $e) {
              return $e->getMessage();
          }
      } 
  }
  

  public function existe_usuario($cedula)
  {
      try {
          // Usar una consulta preparada con un array para los valores
          $stmt = $this->conex->prepare("SELECT * FROM usuario WHERE cedula = ?");
          $stmt->execute([$cedula]);
          $fila = $stmt->rowCount();
          if ($fila > 0) {
              return true;
          } else {
              return false;
          }
      } catch (Exception $e) {
          return false;
      }
  }
  

  public function respaldarBD() {
    try {
    // Desactivar foreign keys
    $this->conex->exec('SET foreign_key_checks = 0');
    // Obtener las tablas
    $tables = $this->conex->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN);

    // Abrir archivo de respaldo
      $retornar = '';
    // Recorrer tablas
    foreach ($tables as $table) {

      // Obtener estructura de la tabla
      $stmt = $this->conex->query("SHOW CREATE TABLE $table");
      $createTableSQL = $stmt->fetch()[1];
      $createTableSQL = preg_replace('/^\s*PRIMARY KEY .*?$/mi', '', $createTableSQL);
      $createTableSQL = preg_replace('/^\s*KEY .*?$/mi', '', $createTableSQL);
      $createTableSQL = preg_replace('/^\s*(FOREIGN KEY|CONSTRAINT|REFERENCES).*$/mi','',$createTableSQL);
      $createTableSQL = preg_replace('/ENGINE\s+AUTO_INCREMENT=\d+/', 'ENGINE', $createTableSQL);
      $createTableSQL = preg_replace('/,\s*\)/', ')', $createTableSQL);
      $createTableSQL = preg_replace('/\)\s*ENGINE/', "\n)\nENGINE", $createTableSQL);
      $createTableSQL = preg_replace('/`id` int\(11\) NOT NULL AUTO_INCREMENT,/', '`id` int(11) NOT NULL,', $createTableSQL);
      // Eliminar líneas en blanco consecutivas
      $createTableSQL = preg_replace('/\n\s*\n/s', "\n", $createTableSQL);
      $retornar .= $createTableSQL .";\n\n";
      // Volcar estructura en archivo
      // Obtener registros
      $rows = $this->conex->query("SELECT * FROM $table");

      // Recorrer e insertar registros
      while ($row = $rows->fetch(PDO::FETCH_ASSOC)) {
        
        $columns = implode("`, `", array_keys($row));
        $values = implode("', '", array_values($row));
      
        $insertSQL = "INSERT INTO $table (`$columns`) VALUES ('$values');\n";
        $retornar .= $insertSQL;
      }
      // Salto de línea entre tablas
      $retornar .= "\n\n";
    }
    // Activar foreign keys
    $this->conex->exec('SET foreign_key_checks = 1');
    
    } catch (PDOException $e) {
      echo "Error generating backup: " . $e->getMessage();
      return false;
    
    }

    return $retornar;
  }

  public function respaldo_parcial(){
      $db_port = '3306'; //Host del Servidor MySQL
      $db_name = 'bdsystem'; //Nombre de la Base de datos
      $db_user = 'admin'; //Usuario de MySQL
      $db_pass = '123456'; //Password de Usuario MySQL
      
      $fecha = date("Ymd"); //Obtenemos la fecha y hora para identificar el respaldo

      // Construimos el nombre de archivo SQL Ejemplo: mibase_20170101-081120.sql
      $salida_sql = 'content/respaldos/'.$db_name.'_'.$fecha.'.sql'; 
      
      //Comando para genera respaldo de MySQL, enviamos las variales de conexion y el destino
      $dump = "mysqldump --user=$db_user --port=$db_port -p--no-create-info $db_name > $salida_sql";
      system($dump, $output); //Ejecutamos el comando para respaldo
      return $dump;


  }


}