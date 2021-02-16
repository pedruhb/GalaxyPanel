<?php

define('GALAXYSERVERS', 1);	
include "../galaxyservers/config.php";

try {
	$PDO = new PDO('mysql:host=' .$hostname. ';dbname=' . $database, $username, $password);
	$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
	die('{"status": 1}');
}

if(!isset($_GET['usuario']) || !isset($_GET['senha']) || !isset($_GET['alert']) || !isset($_GET['user']) || !isset($_GET['mensagem']))
	die('{"status": 2, "mensagem": "isset"}');

if(empty($_GET['alert']) || empty($_GET['user']) || empty($_GET['usuario']) || empty($_GET['senha']) || empty($_GET['mensagem']))
	die('{"status": 2, "mensagem": "empty"}');

$usuario = $_GET['usuario'];
$senha = $_GET['senha'];
$alert = $_GET['alert'];

$contauser = $PDO->prepare("SELECT COUNT(ID) as total,uservestacp,senhavestacp,ativo,login_dados,portamus FROM servidores where uservestacp = :usuario and senhavestacp = :senha");
$contauser->bindParam(':usuario', $usuario);
$contauser->bindParam(':senha', $senha);
$contauser->execute();
$contauserr = $contauser->fetch();


function RconEmuLDR($command, $data, $ipvp2s, $mus) {
	$rconData = $command.chr(1).$data;
	$rcon = @socket_create(AF_INET, SOCK_STREAM, getprotobyname('tcp'));
	@socket_connect($rcon, $ipvp2s, $mus);
	@socket_send($rcon, $rconData, strlen($rconData), MSG_DONTROUTE);
	@socket_close($rcon);
}


if($contauserr['total'] != 1)
	die('{"status": 2}');
else if($contauserr['login_dados'] == 'N')
	die('{"status": 3}');
else if($contauserr['ativo'] == 'N')
	die('{"status": 4}');
else {

	try {
		$PDO2 = new PDO('mysql:host='.$iphospedagem.';dbname='.$contauserr['uservestacp']."_hotel", $contauserr['uservestacp']."_hotel", $contauserr['senhavestacp']);
		$PDO2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$infoserver2 = $PDO2->prepare("SELECT status FROM server_status");
		$infoserver2->execute();
		$informacao = $infoserver2->fetch();

		$statusint = $informacao['status'];

	} catch(PDOException $e) {
		die('{"status": 7}');
	} 
	

	if($statusint == "2"){

		if($alert == "hotelalert"){
			$adicionalog = $PDO->prepare("INSERT INTO `log_servidores` (`log`, `autor`, `ip`, `data`) VALUES ('Enviou um hotel alert através do APP.', '".$usuario."', '', '".time()."');");
			$adicionalog->execute();

			RconEmuLDR('hotel_alert', $_GET['mensagem'], $ipvps, $contauserr['portamus']);

			echo '{"status": 8}';
		} 
		else if($alert == "staffalert"){
			$adicionalog = $PDO->prepare("INSERT INTO `log_servidores` (`log`, `autor`, `ip`, `data`) VALUES ('Enviou um staff alert através do APP.', '".$usuario."', '', '".time()."');");
			$adicionalog->execute();

			RconEmuLDR('staff_alert', $_GET['mensagem'].":"."GalaxyPanel APP", $ipvps, $contauserr['portamus']);

			echo '{"status": 8}';
		} else if($alert == "useralert"){

			$user = $PDO2->prepare("SELECT id,online FROM users WHERE username = :username");
			$user->bindParam(":username", $_GET['user']);
			$user->execute();
			$userr = $user->fetch();

			if($user->rowCount() == 0){
				echo '{"status": 11}';
			} else if($userr['online'] == "1"){

				$adicionalog = $PDO->prepare("INSERT INTO `log_servidores` (`log`, `autor`, `ip`, `data`) VALUES ('Enviou um useralert através do APP.', '".$usuario."', '', '".time()."');");
				$adicionalog->execute();

				RconEmuLDR('alert_user', $userr['id'].':'.$_GET['mensagem'], $ipvps, $contauserr['portamus']);

				echo '{"status": 8}';

			} else {
				echo '{"status": 10}';
			}

		}

	} else {
		echo '{"status": 9}';
	}

}

?>