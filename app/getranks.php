<?php

define('GALAXYSERVERS', 1);	
include "../galaxyservers/config.php";

try {
	$PDO = new PDO('mysql:host=' .$hostname. ';dbname=' . $database, $username, $password);
	$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
	die('{"status": 5}');
}

if(!isset($_GET['usuario']) || !isset($_GET['senha']))
	die('{"status": 4}');

if(empty($_GET['usuario']) || empty($_GET['senha']))
	die('{"status": 4}');

$usuario = $_GET['usuario'];
$senha = $_GET['senha'];

$contauser = $PDO->prepare("SELECT COUNT(ID) as total,uservestacp,senhavestacp,ativo,login_dados FROM servidores where nomeusuario = :usuario and senhavestacp = :senha");
$contauser->bindParam(':usuario', $usuario);
$contauser->bindParam(':senha', $senha);
$contauser->execute();
$contauserr = $contauser->fetch();

if($contauserr['total'] != 1)
	die('{"status": 4}');
else if($contauserr['login_dados'] == 'N')
	die('{"status": 6}');
else if($contauserr['ativo'] == 'N')
	die('{"status": 7}');
else {

	try {
		$PDO2 = new PDO('mysql:host='.$iphospedagem.';dbname='.$contauserr['uservestacp']."_hotel", $contauserr['uservestacp']."_hotel", $contauserr['senhavestacp']);
		$PDO2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch(PDOException $e) {
		die('{"status": 7}');
	}

	$arrayFinal = [];
	$arrayLogs = [];

	$getLogs = $PDO2->prepare("SELECT id,name FROM ranks");
	$getLogs->execute();
	while($logs = $getLogs->fetch()){ 
		
		array_push($arrayLogs, ["id" => $logs['id'], "nome" => utf8_encode($logs['name'])]);

	}

	$arrayFinal = array('status' => 1, 'ranks' => $arrayLogs);
	echo json_encode($arrayFinal);

}

?>