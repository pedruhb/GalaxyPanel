<?php
define('GALAXYSERVERS', 1);	
include "galaxyservers/config.php";

header('Content-Type: application/json');

try {
	$PDO = new PDO('mysql:host=' .$hostname. ';dbname=' . $database, $username, $password);
	$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$PDO2 = new PDO('mysql:host='.$iphospedagem.';dbname=mysql', "pedro", "92712296Cruz");
	$PDO2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
	echo '{"erro": "Não foi possível conectar ao servidor MySQL.", "pdoexception": "'.str_replace("", "92712296Cruz", $e).'"}';
	return;
}

if(isset($_GET['ordem'])){
	if(strtolower($_GET['ordem']) == "contar"){
		$selecionaServidores = $PDO->prepare("SELECT id FROM servidores WHERE ativo = 'Y';");
		$selecionaServidores->execute();
		$servidores = $selecionaServidores->rowCount();
		echo $servidores;
		return;
	}
}

$arrayHoteis = array();

$selecionaServidores = $PDO->prepare("SELECT id,nomehotel,linkhotel,uservestacp,senhavestacp,http,plano FROM servidores WHERE ativo = 'Y' AND indexar = 'Y';");
$selecionaServidores->execute();
while($servidores = $selecionaServidores->fetch()){

	try{
		$PDO2->query("USE ".$servidores['uservestacp']."_hotel;");
		$getInfo = $PDO2->prepare("SELECT * FROM server_status;");
		$getInfo->execute();
		$info = $getInfo->fetch();

		if($info['status'] == "2")
			$onlines = $info['users_online'];
		else
			$onlines = 0;
		
		$arrayHoteis[$servidores['id']] = array($servidores['nomehotel'],$servidores['http']."://".$servidores['linkhotel'],$onlines,$info['record_on'],$info['loaded_rooms'],$info['status'],$info['uptime'], $servidores['plano']);
	}
	catch(Exception $e){

	}
}



if(isset($_GET['ordem'])){
	if(strtolower($_GET['ordem']) == "nome"){
		asort($arrayHoteis);
	} else if(strtolower($_GET['ordem']) == "onlines" || $_GET['ordem'] == "onlinesa"){
		uasort($arrayHoteis, function ($a, $b) {
			return $a[2] < $b[2];
		});
	}
}


if($_GET['limite'] > 0 &&  $_GET['ordem'] == "onlines")
	$output = array_slice($arrayHoteis, 0, $_GET['limite']);
else if( $_GET['ordem'] == "onlinesa")
	$output = array_slice($arrayHoteis, 3, $_GET['limite']);
else
	$output = $arrayHoteis;

echo json_encode($output);

?>