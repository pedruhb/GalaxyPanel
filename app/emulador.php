<?php

define('GALAXYSERVERS', 1);	
include "../galaxyservers/config.php";

try {
	$PDO = new PDO('mysql:host=' .$hostname. ';dbname=' . $database, $username, $password);
	$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
	die('{"status": 1}');
}

if(!isset($_GET['usuario']) || !isset($_GET['senha']))
	die('{"status": 2}');

if(empty($_GET['usuario']) || empty($_GET['senha']))
	die('{"status": 2}');

$usuario = $_GET['usuario'];
$senha = $_GET['senha'];

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

		$adicionalog = $PDO->prepare("INSERT INTO `log_servidores` (`log`, `autor`, `ip`, `data`) VALUES ('Desligou o emulador através do APP.', '".$usuario."', '', '".time()."');");
		$adicionalog->execute();

		RconEmuLDR('desligaremulador', '', $ipvps, $contauserr['portamus']);

		$atualizastatus = $PDO->prepare("UPDATE servidores SET estado = 'desligado' WHERE portamus = '".$contauserr['portamus']."'");
		$atualizastatus->execute();

		echo '{"status": 5}';

	} else {


		$adicionalog = $PDO->prepare("INSERT INTO `log_servidores` (`log`, `autor`, `ip`, `data`) VALUES ('Ligou o emulador através do APP.', '".$usuario."', '', '".time()."');");
		$adicionalog->execute();


		$atualizastatus = $PDO->prepare("UPDATE servidores SET estado = 'ligado' WHERE portamus = '".$contauserr['portamus']."'");
		$atualizastatus->execute();

		popen("C:/xampp/htdocs/galaxyservers/emuladores/".$contauserr['uservestacp']."/galaxyserverligar.bat", "r");

		echo '{"status": 6}';
	}

}

?>