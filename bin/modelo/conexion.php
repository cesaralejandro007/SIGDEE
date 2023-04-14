<?php
class Conexion{
    private $ip = "localhost";
    private $bd = "bdsystem";
    private $usuario = "root";
    private $contrasena = ""; 
    protected function conecta(){

        $pdo = new PDO("mysql:host=".$this->ip.";port=3306; dbname=".$this->bd."",$this->usuario,$this->contrasena);

        $pdo->exec("set names utf8");
        return $pdo;
    }
}
?>