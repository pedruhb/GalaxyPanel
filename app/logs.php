<?php

define('GALAXYSERVERS', 1);	
include "../galaxyservers/config.php";

try {
	$PDO = new PDO('mysql:host=' .$hostname. ';dbname=' . $database, $username, $password);
	$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
	die('{"status": 5}');
}

if(!isset($_GET['usuario']) || !isset($_GET['senha']) || !isset($_GET['limite']))
	die('{"status": 4}');

if(empty($_GET['usuario']) || empty($_GET['senha']) || empty($_GET['limite']))
	die('{"status": 4}');

$usuario = $_GET['usuario'];
$senha = $_GET['senha'];

$contauser = $PDO->prepare("SELECT COUNT(ID) as total,nomeusuario,senhavestacp,ativo,login_dados FROM servidores where nomeusuario = :usuario and senhavestacp = :senha");
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

	if($_GET['limite'] == "100"){
		$arrayLogs = [];
		$getLogs = $PDO->prepare("SELECT log,data FROM log_servidores WHERE autor = :autor ORDER BY id DESC LIMIT 100");
		$getLogs->bindParam(":autor", $usuario);
		$getLogs->execute();

		if($getLogs->rowCount() < 1)
			array_push($arrayLogs, [
				"usuario" => "Não há logs.", "info" => "Vamos divulgar um pouquinho?"
			]);

		while($logs = $getLogs->fetch()){ 
			array_push($arrayLogs, [
				"log" => $logs['log'], "data" => date("d/m/y H:i", strtotime('+2 hours', $logs['data']))
			]);
		}
		$arrayFinal = array('status' => 1, 'logs' => $arrayLogs);
		echo json_encode($arrayFinal);
	} 
	else if($_GET['limite'] == "200"){
		$arrayLogs = [];
		$getLogs = $PDO->prepare("SELECT log,data FROM log_servidores WHERE autor = :autor ORDER BY id DESC LIMIT 200");
		$getLogs->bindParam(":autor", $usuario);
		$getLogs->execute();

			if($getLogs->rowCount() < 1)
			array_push($arrayLogs, [
				"usuario" => "Não há logs.", "info" => "Vamos divulgar um pouquinho?"
			]);
		
		while($logs = $getLogs->fetch()){ 
			array_push($arrayLogs, [
				"log" => $logs['log'], "data" => date("d/m/y H:i", strtotime('+2 hours', $logs['data']))
			]);
		}
		$arrayFinal = array('status' => 1, 'logs' => $arrayLogs);
		echo json_encode($arrayFinal);
	}
}

?>