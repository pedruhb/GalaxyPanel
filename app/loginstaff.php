<?php

define('GALAXYSERVERS', 1);	
include "../galaxyservers/config.php";

try {
	$PDO = new PDO('mysql:host=' .$hostname. ';dbname=' . $database, $username, $password);
	$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
	die('{"status": 5}');
}

if(!isset($_GET['usuario']) || !isset($_GET['senha']) || !isset($_GET['userlg']) || !isset($_GET['senhalg']))
	die('{"status": 4}');

if(empty($_GET['usuario']) || empty($_GET['senha']) || empty($_GET['userlg']) || empty($_GET['senhalg']))
	die('{"status": 4}');

$usuario = $_GET['usuario'];
$senha = $_GET['senha'];
$userlg = $_GET['userlg'];
$senhalg = $_GET['senhalg'];

$contauser = $PDO->prepare("SELECT COUNT(ID) as total,nomeusuario,uservestacp,senhavestacp,ativo,login_dados FROM servidores where nomeusuario = :usuario and senhavestacp = :senha");
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
	
	$getLogs = $PDO2->prepare("SELECT id,rank,username FROM users WHERE username = :username;");
	$getLogs->bindParam(":username", $userlg);
	$getLogs->execute();
	$aa = $getLogs->fetch();


	if($aa['rank'] == 1){
		die('{"status": 8}');
	}
	else if(empty($aa['id'])){
		die('{"status": 9}');
	} else if ($senhalg == "0000" || $senhalg == "123" || $senhalg == "1234" || $senhalg == "000" || $senhalg == "abc" || $senhalg == "" || empty($senhalg)){
		die('{"status": 10}');
	} else {

		$upateUser2 = $PDO2->prepare("UPDATE `users` SET pin = :pin where `id`= :id");
		$upateUser2->bindParam(':pin', $senhalg); 
		$upateUser2->bindValue(':id', $aa['id']);
		$upateUser2->execute(); 

		$adicionalog = $PDO->prepare("INSERT INTO `log_servidores` (`log`, `autor`, `ip`, `data`) VALUES (:msg, '".$usuario."', '', '".time()."');");
		$adicionalog->bindValue(":msg", "Definiu uma senha staff para o usuário ".$aa['username']);
		$adicionalog->execute();

		echo json_encode(array("status"=>1,"mensagem" => 'Pin '.$senhalg.' cadastrado com sucesso para o usuário '.$aa['username'].'.'));


	}
}

?>