<?php

ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

/// Api Bot Discord by PHB

define('GALAXYSERVERS', 1);	
include "galaxyservers/config.php";

### dados MySQL do GalaxyPanel
$hostnamePRO = $hostname;
$usernamePRO = $username;
$passwordPRO = $password;
$databasePRO = $database;
$iphospedagem = "ns1.galaxyservers.com.br";


$funcao = "";
if(isset($_GET['funcao']))
	$funcao = $_GET['funcao'];
if($funcao == "total_habbo"){

	try {
		$PDOPRO = new PDO('mysql:host=' .$hostnamePRO. ';dbname=' . $databasePRO, $usernamePRO, $passwordPRO);
		$PDOPRO ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$ContagemPRO = $PDOPRO->prepare("SELECT id FROM servidores WHERE ativo='Y';");
		$ContagemPRO->execute();
		$ContagemPRO = $ContagemPRO->rowCount();

		echo $ContagemPRO-1;

	} catch(PDOException $e) {
		echo 'Erro de conexão: ' . utf8_encode($e->getMessage())." (Habbo)";
	}
} else if($funcao == "total_clientes"){ 
	echo file_get_contents('https://cliente.galaxyservers.com.br/bot_discord_total_clientes.php');
} else if($funcao == "conta_users_on"){

	$nomehotel = $_GET['hotelname'];
	$nomehotel = '%'.$nomehotel.'%';

	if($nomehotel == "%%")
		die('Você deve digitar o nome do hotel!');

	### Conexão MySQL GalaxyPanel 
	try {
		$PDOPRO = new PDO('mysql:host=' .$hostnamePRO. ';dbname=' . $databasePRO, $usernamePRO, $passwordPRO);
		$PDOPRO ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch(PDOException $e) {
		echo 'Erro de conexão: ' . utf8_encode($e->getMessage())." (Habbo PRO)";
	}

	$SelecionaHotelECO = $PDOPRO->prepare("SELECT id,uservestacp,senhavestacp,linkhotel,http FROM servidores WHERE nomehotel LIKE :nomehotelgalaxy  and ativo = 'Y'  LIMIT 1");
	$SelecionaHotelECO->bindParam(':nomehotelgalaxy', $nomehotel);
	$SelecionaHotelECO->execute();
	$HotelECO = $SelecionaHotelECO->fetch();
	if(empty($HotelECO['linkhotel']) || $HotelECO['linkhotel'] == null){
		echo ':menciona, nenhum hotel encontrado com esse nome.';
	} else {
		try {
			$PDOUSERPRO = new PDO('mysql:host=' .$iphospedagem. ';dbname=' . $HotelECO['uservestacp']."_hotel", $HotelECO['uservestacp']."_hotel", $HotelECO['senhavestacp']);
			$PDOUSERPRO ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch(PDOException $e) {
			die(':menciona, erro ao obter informações do hotel.');
		}

		$SelectUserPRO = $PDOUSERPRO->prepare("SELECT users_online, status FROM server_status");
		$SelectUserPRO->execute();
		$UserOPRO = $SelectUserPRO->fetch();

		if($UserOPRO['status'] == "2")
			$onlines = $UserOPRO['users_online'];
		else
			$onlines = 0;

		die(':menciona, há '.$onlines.' usuários onlines no '.$HotelECO['http'].'://'.$HotelECO['linkhotel']);
	}
} else if($funcao == "ping_servidor"){
	echo "Para mais informações, acesse: https://status.galaxyservers.com.br/";

} else if($funcao == "habbotop"){
	$json = file_get_contents("https://painel.galaxyservers.com.br/api_habbos/onlines/1");
	$h = json_decode($json);
	foreach ($h as $key => $value) {
		echo ":menciona, o hotel com mais usuários onlines é o ".$value[0].", ele está com ".$value[2]." onlines, o link para o hotel é ".$value[1];
		return;
	}
}

?>
