<?php
	define("BASE_URL", "http://127.0.0.1/webSocket/?url=inicio");
	define("SOKECT_FRONTEND", "127.0.0.1:12345");
	define("SOKECT_BACKEND_IP", "127.0.0.1");
	define("SOKECT_FRONTEND_PORT", "12345");

	require("webSocket.php");



	set_time_limit(0);



	function wsOnMessage($clientID, $message, $messageLength, $binary) {
		global $Server;
		$ip = long2ip( $Server->wsClients[$clientID][6] );

		if ($messageLength == 0) {
			$Server->wsClose($clientID);
			return;
		}


		if ( sizeof($Server->wsClients) == 1 )
			$Server->wsSend($clientID, "There isn't anyone else in the room, but I'll still listen to you. --Your Trusty Server");
		else

			foreach ( $Server->wsClients as $id => $client )
				if ( $id != $clientID )
					$Server->wsSend($id, $message);
	}

	function wsOnOpen($clientID)
	{
		global $Server;
		$ip = long2ip( $Server->wsClients[$clientID][6] );

		$Server->log( "$ip ($clientID) has connected." );


		foreach ( $Server->wsClients as $id => $client )
			if ( $id != $clientID )
				$Server->wsSend($id, "Visitor $clientID ($ip) has joined the room.");
	}


	function wsOnClose($clientID, $status) {
		global $Server;
		$ip = long2ip( $Server->wsClients[$clientID][6] );

		$Server->log( "$ip ($clientID) has disconnected." );


		foreach ( $Server->wsClients as $id => $client )
			$Server->wsSend($id, "Visitor $clientID ($ip) has left the room.");
	}


	$Server = new PHPWebSocket();
	$Server->bind('message', 'wsOnMessage');
	$Server->bind('open', 'wsOnOpen');
	$Server->bind('close', 'wsOnClose');

	$Server->wsStartServer(SOKECT_BACKEND_IP, SOKECT_FRONTEND_PORT);





?>