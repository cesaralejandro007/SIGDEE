<?php
namespace modelo;
use config\connect\connectDB as connectDB;
use \PDO;
class RespaldobdModelo extends connectDB
{

  public function verificar_password($cedula)
  {
      $resultado = $this->conex->prepare("SELECT usuario.clave as clave,rol.nombre as rol FROM usuario,usuarios_roles,rol WHERE cedula = '$cedula' AND rol.nombre = 'Super Usuario' AND usuarios_roles.id_usuario = usuario.id AND rol.id = usuarios_roles.id_rol ");
      try {
          $resultado->execute();
          $respuestaArreglo = $resultado->fetchAll();
      } catch (Exception $e) {
          return $e->getMessage();
      }
      return $respuestaArreglo;
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

}