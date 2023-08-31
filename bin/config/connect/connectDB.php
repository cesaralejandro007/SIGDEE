<?php 

	namespace config\connect;
	use config\componentes\configSistema as configSistema;
	use \PDO;

	 class connectDB {

		protected $conex;

		public function __construct(){
			$pool = new ConnectionPool();
			//usar método no estático
			$this->conex = $pool->getConnection();
		
		  }
		
		  public function __destruct(){
			$pool = new ConnectionPool();
			$pool->release($this->conex);
		  
		  }		

		public function query($sql) {
			try{
				return $this->conex->query($sql);
			}catch (PDOException $e) {
				print "¡Error!: " . $e->getMessage() . "<br/>";
				die();
			}
		}
	  }
	  
	  //Pool de conexiones
	  
	  class ConnectionPool  extends configSistema{

		private $puerto;
		private $usuario;
		private $password;
		private $local;
		private $nameDB;

		public function __construct(){
			$this->usuario = parent::_USER_();
			$this->password = parent::_PASS_();
			$this->local = parent::_LOCAL_();
			$this->nameDB = parent::_BD_();
		}

	    private $pool = [];

		public function getConnection(){

			if(count($this->pool) > 0){
			  return array_pop($this->pool);
			} else {
				$conn = new PDO("mysql:host={$this->local};dbname={$this->nameDB}", $this->usuario , $this->password); 
			  return $conn;
			}
		
		  }
	  
		public function release($conn){

			$this->pool[] = $conn;
		
		}
	  
	  }
 ?>




