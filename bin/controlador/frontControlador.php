<?php 


	namespace bin\controlador;

	use config\componentes\configSistema as configSistema;

	class frontControlador extends configSistema{
		private $pagina;
		private $directory;
		private $controlador;

		public function __construct($request){
			if (isset($request["pagina"])) {
				$this->pagina = $request["pagina"];
				$sistem = new configSistema();
				$this->directory = $sistem->_Dir_Control_();
				$this->controlador = $sistem->_Control_();
				$this->validarpagina();
			}else{
				die("<script>window.location='?pagina=Diplomado'</script>");
			}
		}

		private function validarpagina(){
			$pattern = preg_match_all("/^[a-zA-Z0-9-@\/.=:_#$]{1,700}$/", $this->pagina);
			if ($pattern == 1) {
				$this->_loadPage($this->pagina);
			}else{
				die('La url ingresada es inválida');
			}
		}

		private function _loadPage($pagina){
			if(file_exists($this->directory.$pagina.$this->controlador)){
				require_once($this->directory.$pagina.$this->controlador);
			}else{
				$pagina = "Diplomado";
				if(file_exists($this->directory.$pagina.$this->controlador)){
					die("<script>window.location='?pagina=Diplomado'</script>");
			}else{
				die("<script>window.location='?pagina=Error404'</script>");
			}
		}
	}

 }
?>