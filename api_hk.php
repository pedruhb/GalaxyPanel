<?php
define('GALAXYSERVERS', 1);	
include "galaxyservers/config.php";

header('Content-Type: application/json');

try {
	$PDO = new PDO('mysql:host=' .$hostname. ';dbname=' . $database, $username, $password);
	$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
	echo '{"erro": "Não foi possível conectar ao servidor MySQL."}';
	return;
}

if(!isset($_GET['api']))
	die('{"erro": "API Key em branco."}');

if(!isset($_GET['r']))
	die('{"erro": "Request em branco."}');

$selecionaServidores = $PDO->prepare("SELECT * FROM servidores WHERE apikey = :api;");
$selecionaServidores->bindValue(':api', $_GET['api']);
$selecionaServidores->execute();
if($selecionaServidores->RowCount() != 1)
	die('{"erro": "API Key inválida."}');
$server = $selecionaServidores->fetch();


if($_GET['r'] == "emblemas"){

	$arrayEmblemas = [];
	$selecionaServidores = $PDO->prepare("SELECT id,codigo,nome,descricao FROM emblemas WHERE usuario = :usuario;");
	$selecionaServidores->bindParam(":usuario", $server['uservestacp']);
	$selecionaServidores->execute();
	while($servidores = $selecionaServidores->fetch()){
		array_push($arrayEmblemas, [
			"codigo" => $servidores['codigo'],
			"nome" => $servidores['nome'], 
			"descricao" => $servidores['descricao'],
			"link" => "https://swf.galaxyservers.com.br/emblema.php?cod=".$servidores['codigo']
		]);
	}
	echo json_encode($arrayEmblemas);

} else if($_GET['r'] == "infoserver"){

	$vst_command = 'v-list-user';
	$username = $server['uservestacp'];
	$format = 'json';
	$postvars = array(
		'user' => $uservestacp,
		'password' => $passvestacp,
		'cmd' => $vst_command,
		'arg1' => $username,
		'arg2' => $format
	);
	$postdata = http_build_query($postvars);
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $vst_hostname);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
	$answer = curl_exec($curl);
	$pegavalores = explode('"', $answer);
	$porcentagem = explode('.', ($pegavalores[65] - $pegavalores[141])/$pegavalores[65] * 100);
	$porcentagem = $porcentagem['0']/100;
	echo '{"limite": "'.$pegavalores[65].'", "usado": "'.$pegavalores[141].'", "porcentagem": "'.ceil($porcentagem).'"}';
}



else {
	die('{"erro": "Request inválido."}');
}

?>