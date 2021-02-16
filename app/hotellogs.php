<?php

define('GALAXYSERVERS', 1);	
include "../galaxyservers/config.php";

try {
	$PDO = new PDO('mysql:host=' .$hostname. ';dbname=' . $database, $username, $password);
	$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
	die('{"status": 5}');
}

if(!isset($_GET['usuario']) || !isset($_GET['senha']) || !isset($_GET['log']))
	die('{"status": 4}');

if(empty($_GET['usuario']) || empty($_GET['senha']) || empty($_GET['log']))
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

	if($_GET['log'] == "chatlogs"){
		$arrayLogs = [];
		$ultimo = "";
		$ultimo2 = "";
		$getLogs = $PDO2->prepare("SELECT *, (SELECT username FROM users WHERE id = user_id) as username FROM chatlogs order by id desc limit 500");
		$getLogs->execute();
		while($logs = $getLogs->fetch()){ 

				if($ultimo == $logs['message'] && $ultimo2 == $logs['timestamp']){
 				/// repetiu
				} else {

					array_push($arrayLogs, [
						"log" => $logs['message'], "info" => "Por ".$logs['username']." em ".date('d/m/y á\s h:i', $logs['timestamp'])
					]);
					$ultimo = $logs['message'];
					$ultimo2 = $logs['timestamp'];

				}

		}
		$arrayFinal = array('status' => 1, 'logs' => $arrayLogs);
		echo json_encode($arrayFinal);
	} else if($_GET['log'] == "stafflogs"){
		$arrayLogs = [];
		$getLogs = $PDO2->prepare("SELECT *, (SELECT username FROM users WHERE id = user_id) as username FROM logs_client_staff WHERE data_String not like '%loginstaff%' order by id desc limit 500");
		$getLogs->execute();
		while($logs = $getLogs->fetch()){ 
			array_push($arrayLogs, [
				"log" => ":".$logs['data_string'], "info" => "Por ".$logs['username']." em ".date('d/m/y á\s h:i', $logs['timestamp'])
			]);
		}
		$arrayFinal = array('status' => 1, 'logs' => $arrayLogs);
		echo json_encode($arrayFinal);
	} else if($_GET['log'] == "consolelogs"){
		$arrayLogs = [];
		$getLogs = $PDO2->prepare("SELECT *, (SELECT username FROM users WHERE id = from_id) as username1, (SELECT username FROM users WHERE id = to_id) as username2 FROM chatlogs_console order by id desc limit 500");
		$getLogs->execute();
		while($logs = $getLogs->fetch()){ 
			array_push($arrayLogs, [
				"log" => $logs['message'], "info" => "De ".$logs['username1']." para ".$logs['username2']." em ".date('d/m/y á\s h:i', $logs['timestamp'])
			]);
		}
		$arrayFinal = array('status' => 1, 'logs' => $arrayLogs);
		echo json_encode($arrayFinal);
	} 
}

?>