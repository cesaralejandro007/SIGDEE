<?php 

	namespace config\componentes;

	define("_URL_", "http://localhost/dashboard/www/SIGDEE");
	define("_BD_", "bdsystem");
	define("_PASS_", "");
	define("_USER_", "root");
	define("_LOCAL_", "localhost");
	define("DIRECTORY_CONTROL", "bin/controlador/");
	define("DIRECTORY_MODEL", "bin/modelo/");
	define("DIRECTORY_VISTA", "vista/");
	define("MODEL", "Modelo.php");
	define("CONTROLADOR", "Controlador.php");
	define("VISTA", "Vista.php");
	define("SOKECT_FRONTEND", "127.0.0.1:12345");
	define("EVALUACION", "content/evaluaciones/");
	define("ENTREGAS", "content/entregas/");
	define("CONTENIDO", "content/contenidos/");
	define("JSON", "content/json/");

	class configSistema{
		public function _int(){
			if(!file_exists("bin/controlador/frontControlador.php")){
				return "Error configSistema";
			}
		}
		
		public static function Seguridad($string, $accion = null)
		{
			// Clave de cifrado fija (asegúrate de que sea segura y manténla secreta)
			$claveFija = "D1pl0mad0";
			// Vector de inicialización fijo (asegúrate de que sea único para cada cifrado)
			$iv = "1234567890123456";
			// Método de cifrado y opciones
			$metodo = "AES-256-CBC";
		
			if ($accion == 'codificar') {
				$salida = openssl_encrypt($string, $metodo, $claveFija, 0, $iv);
				$salida = base64_encode($salida);
			} elseif ($accion == 'decodificar') {
				$string = base64_decode($string);
				$salida = openssl_decrypt($string, $metodo, $claveFija, 0, $iv);
			}
			return $salida;
			unset($metodo,$llave,$iv,$accion,$sting,$salida);
		}
		
		public static function _M01_() {
			echo self::Seguridad('principal', 'codificar');
		}

		public static function _M02_() {
			echo self::Seguridad('Chat', 'codificar');
		}

		public static function _M03_() {
			echo self::Seguridad('Aula', 'codificar');
		}

		public static function _M04_() {
			echo self::Seguridad('Aspirante', 'codificar');
		}

		public static function _M05_() {
			echo self::Seguridad('Censo', 'codificar');
		}

		public static function _M06_() {
			echo self::Seguridad('Contenido', 'codificar');
		}

		public static function _M07_() {
			echo self::Seguridad('Evaluacion', 'codificar');
		}

		public static function _M08_() {
			echo self::Seguridad('Estudiante', 'codificar');
		}

		public static function _M09_() {
			echo self::Seguridad('Docente', 'codificar');
		}

		public static function _M10_() {
			echo self::Seguridad('AreaEmprendimiento', 'codificar');
		}

		public static function _M11_() {
			echo self::Seguridad('Emprendimiento', 'codificar');
		}

		public static function _M12_() {
			echo self::Seguridad('Modulo', 'codificar');
		}

		public static function _M13_() {
			echo self::Seguridad('ReportesEstadisticos', 'codificar');
		}

		public static function _M14_() {
			echo self::Seguridad('ReporteEstudiantesPorEmprendimiento', 'codificar');
		}

		public static function _M15_() {
			echo self::Seguridad('Usuario', 'codificar');
		}

		public static function _M16_() {
			echo self::Seguridad('Rol', 'codificar');
		}

		public static function _M17_() {
			echo self::Seguridad('Bitacora', 'codificar');
		}

		public static function _M18_() {
			echo self::Seguridad('Respaldobd', 'codificar');
		}
		
		public static function _M19_() {
			echo self::Seguridad('EntornoSistema', 'codificar');
		}

		public static function _M20_() {
			echo self::Seguridad('Notificaciones', 'codificar');
		}
		public static function _M21_() {
			echo self::Seguridad('ReporteDireccion', 'codificar');
		}

		public static function _M22_() {
			echo self::Seguridad('Ayuda', 'codificar');
		}

		public static function _INICIO_() {
			return self::Seguridad('Diplomado', 'codificar');
		}

		public static function _LOGIN_() {
			return self::Seguridad('Login', 'codificar');
		}

		public static function _MAULAS_($id_aula) {
			$aulas = "Aula&visualizar=true&aula=".$id_aula;
			echo self::Seguridad($aulas, 'codificar');
		}
		public static function _MUNIDAD_($id_unidad) {
			$unidad = "Unidad&id_unidad=".$id_unidad;
			echo self::Seguridad($unidad, 'codificar');
		}
		public static function _MUNIDADEVA_($id_unidadEVA) {
			$unidad = "MostrarEvaluacion&id_unidad_evaluacion=".$id_unidadEVA;
			echo self::Seguridad($unidad, 'codificar');
		}
		
		public static function _ML_() {
			echo self::Seguridad('Login', 'codificar');
		}
		public static function _MD_() {
			echo self::Seguridad('Diplomado', 'codificar');
		}

		public static function _MP_() {
			echo self::Seguridad('Postulacion', 'codificar');
		}

		public static function _MPERF_() {
			echo self::Seguridad('Perfil', 'codificar');
		}

		public static function _MERROR_() {
			echo self::Seguridad('Error404', 'codificar');
		}

		public static function _M23_() {
			echo self::Seguridad('ConsultaNotas', 'codificar');
		}
		
		public function _URL_(){
			return _URL_;
		}
		public function _BD_(){
			return _BD_;
		}
		public function _PASS_(){
			return _PASS_;
		}
		public function _USER_(){
			return _USER_;
		}
		public function _LOCAL_(){
			return _LOCAL_;
		}
		public function _Dir_Control_(){
			return DIRECTORY_CONTROL; 
		}
		public function _Dir_Model_(){
			return DIRECTORY_MODEL; 
		}
		public function _Dir_Vista_(){
			return DIRECTORY_VISTA; 
		}
		public function _MODEL_(){
			return MODEL;
		}
		public function _Control_(){
			return CONTROLADOR;
		}
		public function _VISTA_(){
			return VISTA;
		}
		public function _Websocket_(){
			return SOKECT_FRONTEND;
		}
		public function _EVALUACION_(){
			return EVALUACION;
		}
		public function _ENTREGAS_(){
			return ENTREGAS;
		}
		public function _CONTENIDO_(){
			return CONTENIDO;
		}
		public function _JSON_(){
			return JSON;
		}
	}

 ?>