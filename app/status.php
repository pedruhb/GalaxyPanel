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

$contauser = $PDO->prepare("SELECT COUNT(ID) as total,uservestacp,senhavestacp,ativo,login_dados,portamus,nomehotel FROM servidores where uservestacp = :usuario and senhavestacp = :senha");
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

		$infoserver2 = $PDO2->prepare("SELECT (SELECT users_online FROM server_status) as userson, (select count(id) from users) as usertotal, (select loaded_rooms from server_status) as quartoscarregados, (select record_on from server_status) as recordon, (select status from server_status) as status, (select uptime from server_status) as uptime, (SELECT COUNT(id) FROM users WHERE rank > 2 AND online = '1') as staffsonlines");
		$infoserver2->execute();
		$informacao = $infoserver2->fetch();

	} catch(PDOException $e) {
		die('{"status": 7}');
	} 
	
	$statusHotel = array(
		"status" => 6, 
		"onlines" => $informacao['userson'], 
		"userstotal" => $informacao['usertotal'], 
		"quartoscarregados" => $informacao['quartoscarregados'],
		"recordon" => $informacao['recordon'],
		"emulador" => $informacao['status'],
		"nomehotel" => $contauserr['nomehotel'],
		"staffsonlines" => $informacao['staffsonlines'], 
		"uptime" => $informacao['uptime']
	);
	echo json_encode($statusHotel);

}

?>