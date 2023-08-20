<?php 


	namespace bin\controlador;

	use config\componentes\configSistema as configSistema;

	class frontControlador extends configSistema{
		private $pagina;
		private $directory;
		private $controlador;

		public function __construct($request){
			if (isset($request["pagina"])) {
				$url = configSistema::Seguridad($request["pagina"], 'decodificar');
				$this->pagina = $url;
				$sistem = new configSistema();
				$this->directory = $sistem->_Dir_Control_();
				$this->controlador = $sistem->_Control_();
				$this->validarpagina();
			}else{
				$redirectUrl = '?pagina=' . configSistema::_INICIO_();
				echo '<script>window.location="' . $redirectUrl . '"</script>';
			}
		}

		private function validarpagina(){
			$pattern = preg_match_all("/^[a-zA-Z0-9-@+\/&.=:_#$]{1,700}$/", $this->pagina);
			if ($pattern == 1) {
				$this->_loadPage($this->pagina);
			}else{
				echo $this->pagina;
				require_once "vista/error_URL.php";
			}
		}

		private function _loadPage($pagina){
			if(file_exists($this->directory.$pagina.$this->controlador)){
				require_once($this->directory.$pagina.$this->controlador);
			}else{
				$str = $pagina;
				$partes = explode('&', $str);
				$parte = explode('"', $partes[0])[0]; 
				if(file_exists($this->directory.$parte.$this->controlador)){
					require_once($this->directory.$parte.$this->controlador);
			}else{
				require_once "vista/error_URL.php";
			}
		}
	}

 }
?>