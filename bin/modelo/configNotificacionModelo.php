<?php
namespace modelo;
class configNotificacionModelo{
	public function error($title, $message){
		echo json_encode([
			'estatus' => '0',
			'icon' => 'error',
			'title' => $title,
			'message' => $message
		]);
	}

	public function confirmar($title, $message){
		echo json_encode([
			'estatus' => '1',
			'icon' => 'success',
			'title' => $title,
			'message' => $message
		]);
	}

	public function informacion($title, $message){
		echo json_encode([
			'estatus' => '2',
			'icon' => 'info',
			'title' => $title,
			'message' => $message
		]);
	}	
}	
?>