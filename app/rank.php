<?php

define('GALAXYSERVERS', 1);	
include "../galaxyservers/config.php";

try {
	$PDO = new PDO('mysql:host=' .$hostname. ';dbname=' . $database, $username, $password);
	$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
	die('{"status": 5}');
}

if(!isset($_GET['usuario']) || !isset($_GET['senha']) || !isset($_GET['userlg']) || !isset($_GET['rank']))
	die('{"status": 4, "erro": "isset"}');

if(empty($_GET['usuario']) || empty($_GET['senha']) || empty($_GET['userlg']) || empty($_GET['rank']))
	die('{"status": 4, "erro": "empty"}');

$usuario = $_GET['usuario'];
$senha = $_GET['senha'];
$userlg = $_GET['userlg'];
$rank = preg_replace("/[^0-9]/", "", $_GET['rank']);

$contauser = $PDO->prepare("SELECT COUNT(ID) as total,nomeusuario,uservestacp,senhavestacp,ativo,login_dados FROM servidores where nomeusuario = :usuario and senhavestacp = :senha");
$contauser->bindParam(':usuario', $usuario);
$contauser->bindParam(':senha', $senha);
$contauser->execute();
$contauserr = $contauser->fetch();

if($contauserr['total'] != 1)
	die('{"status": 4, "erro": "404 hotel"}');
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
	
	$getLogs = $PDO2->prepare("SELECT id,rank,username FROM users WHERE username = :username;");
	$getLogs->bindParam(":username", $userlg);
	$getLogs->execute();
	$aa = $getLogs->fetch();


	if(empty($aa['id'])){
		die('{"status": 9}');
	} else if ($rank < 1){
		die('{"status": 10}');
	} else {

		$upateUser2 = $PDO2->prepare("UPDATE `users` SET rank = :rank where `id`= :id");
		$upateUser2->bindParam(':rank', $rank); 
		$upateUser2->bindValue(':id', $aa['id']);
		if(!$upateUser2->execute())
			die('{"status": 11}');

		$adicionalog = $PDO->prepare("INSERT INTO `log_servidores` (`log`, `autor`, `ip`, `data`) VALUES (:msg, '".$usuario."', '', '".time()."');");
		$adicionalog->bindValue(":msg", "Definiu o rank ".$rank." para o ".$aa['username'].".");
		$adicionalog->execute();

		echo json_encode(array("status"=>1,"mensagem" => "Rank \"".$rank."\" definido para o usuário ".$aa['username']."."));


	}
}

?>