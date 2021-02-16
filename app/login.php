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

$contauser = $PDO->prepare("SELECT COUNT(ID) as total,nomeusuario,senhavestacp,ativo,login_dados,nomehotel,http,linkhotel FROM servidores where nomeusuario = :usuario and senhavestacp = :senha");
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

	$adicionalog = $PDO->prepare("INSERT INTO `log_servidores` (`log`, `autor`, `ip`, `data`) VALUES ('Logou no painel através do APP.', '".$usuario."', '', '".time()."');");
	$adicionalog->execute();

	die('{"status": 1, "hotelname": "'.$contauserr['nomehotel'].'", "linkhotel": "'.$contauserr['http'].'://'.$contauserr['linkhotel'].'"}');
}

?>