<?php 

	namespace config\connect;
	use config\componentes\configSistema as configSistema;
	use \PDO;

	 class connectDB extends configSistema{

		private $puerto;
		private $usuario;
		private $password;
		private $local;
		private $nameDB;
		protected $conex;
		protected $pool = [];

		public function __construct(){
			$this->usuario = parent::_USER_();
			$this->password = parent::_PASS_();
			$this->local = parent::_LOCAL_();
			$this->nameDB = parent::_BD_();
			$this->conex = $this->getConnection();
		}

		public function __destruct(){
			$this->release($this->conex);
		}		

		protected function getConnection(){
			try {
				if(count($this->pool) > 0){
					return array_pop($this->pool);
				} else {
					$conn = new PDO("mysql:host={$this->local};dbname={$this->nameDB}", $this->usuario , $this->password); 
				return $conn;
				}
			} catch (PDOException $e) {
				//manejar error
				$this->logError($e); 
			}
		}
		
		protected function release($conn){
			try {  
				$this->pool[] = $conn;
			} catch (Exception $e) {
				//manejar error
				$this->logError($e);
			}
		}

		protected function query($sql) {
			try{
				return $this->conex->query($sql);
			}catch (PDOException $e) {
				print "¡Error!: " . $e->getMessage() . "<br/>";
				die();
			}
		}
	}

 ?>




