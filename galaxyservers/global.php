<?php
session_start();
define('GALAXYSERVERS', 1);	
include "config.php";
try {
	$PDO = new PDO('mysql:host=' .$hostname. ';dbname=' . $database, $username, $password);
	$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
	echo 'Erro de conexão: ' . utf8_encode($e->getMessage());
}

function loginerror($mensagem)
{
	echo '<div class="alert alert-danger background-danger"><strong>Erro!</strong> '.$mensagem.'</div>';
}

function loginsucess($mensagem)
{
	echo '<div class="alert alert-success background-success">'.$mensagem.'</div>';
}

function sendRCONCommand($command, $data, $ipvp2s, $mus) {
	global $PDO;
	$rconData = $command . chr(1) .$data;
	$rcon = socket_create(AF_INET, SOCK_STREAM, getprotobyname('tcp'));
	if(!@socket_connect($rcon, $ipvp2s, $mus)){
		$servidor = $PDO->prepare("SELECT nomeusuario FROM servidores WHERE portamus = '".$mus."'");
		$servidor->execute();
		$servido = $servidor->fetch();
		echo '<div class="alert alert-danger background-danger">
		<strong>Erro!</strong> Erro ao executar comando no emulador do usuário "'.$servido['nomeusuario'].'".
		</div>';
	}
	@socket_send($rcon, $rconData, strlen($rconData), MSG_DONTROUTE);
	socket_close($rcon);
}

function RconEmuLDR($command, $data, $ipvp2s, $mus) {
	$rconData = $command . chr(1) .$data;
	$rcon = socket_create(AF_INET, SOCK_STREAM, getprotobyname('tcp'));
	if(!@socket_connect($rcon, $ipvp2s, $mus)){
		echo '<div style="display: contents;">
		<div class="col-md-12">
		<center><div class="alert alert-danger background-danger" style="width: 30%;">
		<strong>Erro!</strong> Não foi possível executar o comando!
		</div></center>
		</div>
		</div>';
	} else {
		echo '<div style="display: contents;">
		<div class="col-md-12">
		<center><div class="alert alert-success background-success" style="width: 50%;">
		<strong>Successo!</strong> Comando executado com êxito!
		</div></center>
		</div>
		</div>';
	}
	@socket_send($rcon, $rconData, strlen($rconData), MSG_DONTROUTE);
	socket_close($rcon);
}

function sendRCONCommand2($command, $data, $ipvp2s, $mus) {
	$rconData = $command . chr(1) .$data;
	$rcon = socket_create(AF_INET, SOCK_STREAM, getprotobyname('tcp'));
	@socket_connect($rcon, $ipvp2s, $mus);
	@socket_send($rcon, $rconData, strlen($rconData), MSG_DONTROUTE);
	socket_close($rcon);
}

function gs($sql)
{
	$sql = preg_replace("/(from|select|insert|delete|where|drop table|show tables|#|\*|–|\\\\)/i","",$sql);
	$sql = trim($sql);
	$sql = strip_tags($sql);
	$sql = addslashes($sql);
	return $sql;
}

if(!empty($_SERVER["HTTP_CF_CONNECTING_IP"]))$meuip=$_SERVER["HTTP_CF_CONNECTING_IP"];
else if(!empty($_SERVER["REMOTE_ADDR"]))$meuip=$_SERVER["REMOTE_ADDR"];
else $meuip = "IP desconhecido";



### Verifica se tem banimento por IP
$seleciona = $PDO->prepare("SELECT id FROM bans WHERE ip = '".$meuip."'");
$seleciona->execute();
$resultado = $seleciona->rowCount();
if($resultado > 0)	
	exit('<title>GalaxyPanel - Banido!</title><script>alert("Você foi banido! entre em contato com nossa equipe em caso de dúvidas.");location.href="http://galaxyservers.com.br"</script>');

### Verifica se a senha da session é a mesma logada
if (!empty($_SESSION['nomeusuario'])){
	if($_SESSION['senhalogin'] != $_SESSION['senhaatualdb']){
		$_SESSION['nomeusuario'] = NULL;
		echo '<script>location.href="index";</script>';
		return;
	}
}

function discord_msg1($log, $meuip, $identifica_discord, $usuario){
	global $nome_bot;
	$dataPacket2 = array(
		'content' => "",
		'username' => $nome_bot,
		'embeds' => array(
			array(
				'timestamp' => date(DateTime::ISO8601),
				'description' => '',
				'color' => '5653183',
				'author' => array(
					'name' => $log
				),
				'fields' => array(
					array(
						'name' => 'Usuário',
						'value' => $usuario,
						'inline' => true
					),
					array(
						'name' => "IP",
						'value' => $meuip,
						'inline' => true
					),
					array(
						'name' => 'Servidor',
						'value' => $identifica_discord,
						'inline' => true
					)
				)
			)
		)
	);

	return $dataPacket2;
}

function discord_msg2($mensagem, $descri){
	global $nome_bot;
	$dataPacket2 = array(
		'content' => "",
		'username' => $nome_bot,
		'embeds' => array(
			array(
				'timestamp' => date(DateTime::ISO8601),
				'description' => $descri,
				'color' => '5653183',
				'author' => array(
					'name' => $mensagem
				)
			)
		)
	);
	return $dataPacket2;
}

function envia_discord($dataPacket){
	global $discord_wh;
	$dataString = json_encode($dataPacket);
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $discord_wh);
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $dataString);
	$output = curl_exec($curl);
	$output = json_decode($output, true);
	if (curl_getinfo($curl, CURLINFO_HTTP_CODE) != 204) {
		echo "Falha " . curl_getinfo($curl, CURLINFO_HTTP_CODE) . "<br><br>";
		print_r($output);
	}
	curl_close($curl);
}

function addlog_admin($usuario, $log){
	global $discord_alerts;
	global $meuip;
	global $identifica_discord;
	global $PDO;
	global $_SESSION;

	$adicionalog = $PDO->prepare("INSERT INTO `log_admin` (`log`, `autor`, `ip`, `data`) VALUES (:log, :usuario, '".$meuip."', '".time()."');");
	$adicionalog->bindParam(':log', $log);
	$adicionalog->bindValue(':usuario', $_SESSION['useradmin']);
	$adicionalog->execute();

	if($discord_alerts){
		envia_discord(discord_msg1($log, $meuip, $identifica_discord, $usuario));
	}
}

function versaoemu(){
	global $PDO;
	$getversao = $PDO->prepare("SELECT versao FROM emulador;");
	$getversao->execute();
	return $getversao->fetch()['versao'];
}

function ultimaatt(){
	global $PDO;
	$getversao = $PDO->prepare("SELECT id FROM att_db ORDER BY id desc LIMIT 1");
	$getversao->execute();
	return $getversao->fetch()['id'];
}

function addlog($log){
	global $meuip;
	global $_SESSION;
	global $PDO;

	if(isset($_SESSION['subconta']))
		$log = $log." (Subconta ".$_SESSION['subconta'].")";

	$adicionalog = $PDO->prepare("INSERT INTO `log_servidores` (`log`, `autor`, `ip`, `data`) VALUES (:log, :usuario, '".$meuip."', '".time()."');");
	$adicionalog->bindParam(':log', $log);
	$adicionalog->bindParam(':usuario', $_SESSION['nomeusuario']);
	$adicionalog->execute();

}

function permissao($permissao){
	global $_SESSION;
	global $PDO;
	if(!isset($_SESSION['subconta'])){
		return true;
	} else {

		$pegaPermissaoo = $PDO->prepare("SELECT usuario FROM sub_contas WHERE id = :id");
		$pegaPermissaoo->bindParam(':id', $_SESSION['subconta']);
		$pegaPermissaoo->execute();
		$permissao2o = $pegaPermissaoo->fetch();
		if($permissao2o){

			$pegaPermissao = $PDO->prepare("SELECT ".$permissao." AS resultado FROM sub_contas_perm WHERE id = :id");
			$pegaPermissao->bindParam(':id', $_SESSION['subconta']);
			$pegaPermissao->execute();
			$permissao2 = $pegaPermissao->fetch()['resultado'];

			if(strpos($permissao2, 'true') !== false){
				return true;
			}
			else {
				return false;
			}
		} else {
			$_SESSION['nomeusuario'] = NULL;
			$_SESSION['subconta'] = NULL;
			return false;
		}
	}
}

### Verifica se o domínio acessado é o mesmo das config.
//$protocolo = strtolower(preg_replace('/[^a-zA-Z]/','',$_SERVER['SERVER_PROTOCOL']));
//$dominiorecebido = $protocolo.'://'.$_SERVER['HTTP_HOST'];
//if($dominio != $dominiorecebido)
//	die("Galaxy Server 2.0.3 - Powered by PHB.");
//echo '<!-------- recebido: '.$dominiorecebido.' \ configurado: '.$dominio.' -------><script>location.href="'.$dominio.'";</script>';

if(!isset($_SESSION['useradmin'])){

	if(isset($filemanagertawk)){

	} else {
		echo '<!--Start of Tawk.to Script-->
		<script type="text/javascript">
		var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
		(function(){
			var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
			s1.async=true;
			s1.src=\'https://embed.tawk.to/5d3e5e529b94cd38bbe9bcc3/default\';
			s1.charset=\'UTF-8\';
			s1.setAttribute(\'crossorigin\',\'*\');
			s0.parentNode.insertBefore(s1,s0);
			})();
			</script>
			<!--End of Tawk.to Script-->';
		}
	}

	?>