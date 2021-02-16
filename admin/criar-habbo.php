<?php include "../galaxyservers/global.php";
if(empty($_SESSION['useradmin'])){
	echo '<script>location.href="index";</script>';
}
if (!empty($_SESSION['useradmin'])){

	ini_set('display_errors',1);
	ini_set('display_startup_erros',1);
	error_reporting(E_ALL);

	include "nav.php";
	?>
	<div class="pcoded-content">
		<div class="pcoded-inner-content">
			<div class="main-body">
				<div class="page-wrapper">
					<div class="page-body">
						<div class="">
							<div class="card">
								<div class="card-header">
									<h5>Criar Habbo</h5>
									<span>Aqui irá criar hospedagem, emulador e enviar todos os arquivos necessários.</span>
									<div class="card-header-right"><i class="icofont icofont-spinner-alt-5"></i></div>
									<div class="card-header-right">
										<i class="icofont icofont-spinner-alt-5"></i>
									</div>
								</div>
								<div class="card-block">
									<?php

									if(isset($_POST['criarhotel'])){

										$linkdohotel = str_replace("/", "", str_replace("http://", "", str_replace("https://", "", $_POST['linkhotel'])));
										$likedominio1 = $linkdohotel.'%';
										$likedominio2 = 'https://'.$linkdohotel.'%';
										$likedominio3 = 'http://'.$linkdohotel.'%';
										$selecionaHps = $PDO->prepare("SELECT * FROM servidores WHERE linkhotel like :dominio1 or linkhotel like :dominio2 or linkhotel like :dominio3;");
										$selecionaHps->bindParam(':dominio1', $likedominio1);
										$selecionaHps->bindParam(':dominio2', $likedominio2);
										$selecionaHps->bindParam(':dominio3', $likedominio3);
										$selecionaHps->execute();
										$hpscount = $selecionaHps->rowCount();
										if($hpscount != 0){
											loginerror("Já existe um hotel com esse domínio \"".$linkdohotel."\".");
											$continua = false;
										} else {
											if(strlen($_POST['uservestacp']) >= 9){
												loginerror("O usuário deve ter no máximo 8 caracteres.");
												$continua = false;
											} else {
												$verificaNome = $PDO->prepare("SELECT id FROM servidores WHERE nomehotel = :nomehotel");
												$verificaNome->bindParam(':nomehotel', $_POST['nomehotel']);
												$verificaNome->execute();

												if($verificaNome->rowCount() > 0){
													loginerror("Já existe um hotel com esse nome!");
													$continua = false;
												} else $continua = true;
											}
										}

										$pegaplanos = $PDO->prepare("SELECT vesta_package,compilar_swf FROM planos WHERE id = :id");
										$pegaplanos->bindParam(":id", $_POST['plano']);
										$pegaplanos->execute();
										$planos = $pegaplanos->fetch();

										if($planos['compilar_swf'] == true)
											if(!empty($_SESSION['timestamp-swf'])){
												$conta = time() - $_SESSION['timestamp-swf'];

												if($conta < 120){
													$conta2=$conta-120;
													loginerror("Você deve esperar mais ".str_replace("-", "", $conta2)." segundos para usar essa função novamente.");
													$continua = false;
												} 
												else 
													$continua = true;

											} else $continua = true;

											if($continua){
												$http = $_POST['http'];
												$containserts = $PDO->prepare("SELECT COUNT(id) as totalinsert FROM servidores WHERE nomeusuario = :uservestacp");
												$containserts->bindParam(":uservestacp", $_POST['uservestacp']);
												$containserts->execute();
												$conta = $containserts->fetch();
												if($conta['totalinsert'] == 0){
													$containserts = $PDO->prepare("SELECT COUNT(id) as totalinsert FROM servidores WHERE uservestacp = :uservestacp");
													$containserts->bindParam(":uservestacp", $_POST['uservestacp']);
													$containserts->execute();
													$conta = $containserts->fetch();
													if($conta['totalinsert'] == 0){

														$bancodedadoshp = $_POST['uservestacp']."_hotel";
														$timenow = time();
														$apikeygalaxy = md5($_POST['uservestacp']."galaxyservers".$_POST['senhavestacp']);

		$adicionadb = $PDO->prepare("INSERT INTO `servidores` (`nomeusuario`, `nomehotel`, `linkhotel`, `uservestacp`, `senhavestacp`, `emailcliente`, `portatcp`, `portamus`, `criadoem`, `apikey`, `plano`,`http`,`versao_emu`,`att_db`) VALUES (:uservestacp, :nomehotel, :linkhotel, :uservestacp, :senhavestacp, :emailcliente, :tcp, :mus, :data, :apikey, :plano, :http, :vemu, :adb);");
														$adicionadb->bindParam(':uservestacp', $_POST['uservestacp']);
														$adicionadb->bindParam(':nomehotel', $_POST['nomehotel']);
														$adicionadb->bindParam(':linkhotel', $linkdohotel);
														$adicionadb->bindParam(':senhavestacp', $_POST['senhavestacp']);
														$adicionadb->bindParam(':emailcliente', $_POST['emailcliente']);
														$adicionadb->bindParam(':tcp', $_POST['portatcp']);
														$adicionadb->bindParam(':mus', $_POST['portamus']);
														$adicionadb->bindParam(':data', $timenow);
														$adicionadb->bindParam(':apikey',$apikeygalaxy);
														$adicionadb->bindParam(':plano', $_POST['plano']);
														$adicionadb->bindParam(':http', $_POST['http']);
															$adicionadb->bindValue(':vemu', versaoemu());
															$adicionadb->bindValue(':adb', ultimaatt());
														if($adicionadb->execute()){
															$idservidor = $PDO->lastInsertId();
															$insereconfigs = $PDO->prepare("INSERT INTO `config_servidores` (`servidor`, `nomehotel`, `ultimaalteracao`) VALUES ('".$idservidor."', :nomehotel, '".time()."');");
															$insereconfigs->bindParam(":nomehotel", $_POST['nomehotel']);
															$insereconfigs->execute();

#region Cria o emulador
	$pasta = "../galaxyservers/emuladores/sourcegalaxy"; //pasta que sera copiada
	$pastad = "../galaxyservers/emuladores/".$_POST['uservestacp'];//pasta de destino pode ou nÃao estar criada
	if(!is_dir($pastad)){//verifica se existe a pasta de destino
	mkdir($pastad,0777);//cria a pasta
	chmod($pastad,0777);//muda a permissao
	}$aberta = opendir($pasta);//abre a pasta para ver os arquivos
	while($res=readdir($aberta)){//vendo os arquivos da pasta
	@copy($pasta."/".$res,$pastad. "/".$res); //copiando os arquivos
}

    $pasta2 = "../galaxyservers/emuladores/sourcegalaxy/Config"; //pasta que sera copiada
	$pastad2 = "../galaxyservers/emuladores/".$_POST['uservestacp']."/Config";//pasta de destino pode ou nÃo estar criada
	if(!is_dir($pastad2)){//verifica se existe a pasta de destino
	mkdir($pastad2,0777);//cria a pasta
	chmod($pastad2,0777);//muda a permissao
	}$aberta2 = opendir($pasta2);//abre a pasta para ver os arquivos
	while($res2=readdir($aberta2)){//vendo os arquivos da pasta
	@copy($pasta2."/".$res2,$pastad2. "/".$res2); //copiando os arquivos
}

$fp = fopen("../galaxyservers/emuladores/".$_POST['uservestacp']."/galaxyserverligar.bat", "w");
$escreve = fwrite($fp, "cd C:/xampp/htdocs/galaxyservers/emuladores/".$_POST['uservestacp']."/
	start emukk.exe
	exit");

fclose($fp);
// Configura o arquivo config.ini
$nomearquivo = "../galaxyservers/emuladores/".$_POST['uservestacp']."/Config/config.ini";
$conteudo = "### Arquivo de configuração do Galaxy Server!
### Emulador programado por PHB.

## Configuração MYSQL
db.hostname=".$iphospedagem."
db.port=3306
db.username=".$_POST['uservestacp']."_hotel
db.password=".$_POST['senhavestacp']."
db.name=".$_POST['uservestacp']."_hotel

## MySQL pooling setup (controla a quantidade de conexões)
db.pool.minsize=10
db.pool.maxsize=250

## Game TCP/IP Configuração
game.tcp.bindip=".$ipvps."
game.tcp.port=".$_POST['portatcp']."
game.tcp.conlimit=100000
game.tcp.conperip=3
game.tcp.enablenagles=true

## MUS TCP/IP Configuração
mus.tcp.bindip=".$ipvps."
mus.tcp.port=".$_POST['portamus']."
mus.tcp.allowedaddr=".$ipvps."

## Client Configuração
client.ping.enabled=1
client.ping.interval=3
client.maxrequests=300

## Configuração do Nome do seu hotel
hotel.name=".$_POST['nomehotel']."
license=".$_POST['nomehotel']." Hotel
game.legacy.figure_mutant=1

# Rank Mánimo de Staff
MineRankStaff=7

## Hall da Fama na client (0 = não / 1 = sim)
halldafama=0

## Tipo (1 = gotw/ 2 =diamantes/ 3 = duckets/ 4 =moedas)
tipohall=2";

$fp = fopen("$nomearquivo", "w");
$escreve = fwrite($fp, "$conteudo");
fclose($fp);

// Configura o arquivo extras.ini
$nomearquivo1 = "../galaxyservers/emuladores/".$_POST['uservestacp']."/Config/extras.ini";
$conteudo1 = "## Nome dos pontos (GOTW)
coin.points.name=GOTW
### Nome moedas
coin.credits.name=Créditos
### Nome duckets
coin.duckets.name=Duckets
### Nome diamantes
coin.diamonds.name=Diamantes

## Staffs
staff.effect.inroom=false
staff.mensg.inroom=false

## Camera (cuidado ao mecher nos links)
camera.enable=true
camera.api.http=".$http."://".$linkdohotel."/camera/
camera.output.pictures=".$http."://".$linkdohotel."/camera/pictures/
camera.picture.purchase.alert.id=false
camera.photo.publish.price.duckets=10
camera.photo.purchase.item_id=1100001495
camera.photo.purchase.price.coins=00
camera.photo.purchase.price.duckets=10
camera.preview.maxcache=1000

## Rank mínimo para ter acesso a ferramente de embaixador
ambassador.minrank=6

## Emblema staff sobre a cabeça
emblemacabeca.staff=false
emblemacabeca.embaixador=true

## Configuração dos Quartos
Quartovip=0
Prisao=0

## Premio por atividade
PremioPorAtividade=true
MensagemAoReceber=true
Intervalo=30


NiveltotalGames=200
CodEmblemaNivel=NV

### Nick de quem pode usar o comando reiniciar
ReiniciarPermissao=PHB

## Rank que vai aparecer balão embaixador
RankEmbaixador=7

### Premiação diária
PremiacaoDiaria=false
";

$fp1 = fopen("$nomearquivo1", "w");
$escreve1 = fwrite($fp1, "$conteudo1");
fclose($fp1);


### Insere LOG
addlog_admin($_SESSION['useradmin'], "Criou um Habbo: ".$_POST['uservestacp']);

### Mensagem emulador criado
echo '<div class="alert alert-info background-info">
<strong>Sucesso!</strong> O emulador do '.$_POST['nomehotel'].' Hotel foi criado! - <a href="acessarcomouser/'.$_POST['uservestacp'].'">Acessar como '.$_POST['nomehotel'].'</a></code>
</div>';
#endregion criaemulador

#region cria conta de usuário no vesta

// Server credentials
$vst_username = $uservestacp;
$vst_password = $passvestacp;
$vst_returncode = 'yes';
$vst_command = 'v-add-user';

### cria conta de usuário
$username = $_POST['uservestacp'];
$password = $_POST['senhavestacp'];
$email = 'pedrohenrique12342@gmail.com';
$package = $planos["vesta_package"];
$fist_name = 'ADM';
$last_name = $_SESSION['useradmin'];

// Prepare POST query
$postvars = array(
	'user' => $vst_username,
	'password' => $vst_password,
	'returncode' => $vst_returncode,
	'cmd' => $vst_command,
	'arg1' => $username,
	'arg2' => $password,
	'arg3' => $email,
	'arg4' => $package,
	'arg5' => $fist_name,
	'arg6' => $last_name
);
$postdata = http_build_query($postvars);

// Send POST query via cURL
$postdata = http_build_query($postvars);
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $vst_hostname);
curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
$answer = curl_exec($curl);

// Check result
if($answer == 0) {
	echo '<div class="alert alert-info background-info">
	<strong>Sucesso!</strong> Conta de hospedagem criada.</code>
	</div>';
   /// echo "User account has been successfuly created\n";
} else {
	echo '<div class="alert alert-danger background-danger">
	<strong>Erro!</strong> Erro ao criar conta de hospedagem (Erro '.$answer.').</code>
	</div>';
}
#endregion

#region adiciona domínio na hospedagem
$vst_command2 = 'v-add-domain';

// New Domain
$username = $_POST['uservestacp'];
$domain = $linkdohotel;

// Prepare POST query
$postvars = array(
	'user' => $vst_username,
	'password' => $vst_password,
	'returncode' => $vst_returncode,
	'cmd' => $vst_command2,
	'arg1' => $username,
	'arg2' => $domain
);
$postdata = http_build_query($postvars);

// Send POST query via cURL
$postdata = http_build_query($postvars);
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $vst_hostname);
curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
$answer = curl_exec($curl);

// Check result
if($answer == 0) {
	echo '<div class="alert alert-info background-info">
	<strong>Sucesso!</strong> Domínio adicionado com sucesso</code>
	</div>';
} else {
	echo '<div class="alert alert-danger background-danger">
	<strong>Erro!</strong> Erro ao adicionar domínio (Erro '.$answer.').</code>
	</div>';
}
#endregion

# region Cria banco de dados
// New Database
$vst_username = $uservestacp;
$vst_password = $passvestacp;
$vst_command = 'v-add-database';
$db_name = 'hotel';
$db_user = 'hotel';
$db_pass = $_POST['senhavestacp'];

// Prepare POST query
$postvars = array(
	'user' => $vst_username,
	'password' => $vst_password,
	'returncode' => $vst_returncode,
	'cmd' => $vst_command,
	'arg1' => $username,
	'arg2' => $db_name,
	'arg3' => $db_user,
	'arg4' => $db_pass
);
$postdata = http_build_query($postvars);

// Send POST query via cURL
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $vst_hostname);
curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
$answer = curl_exec($curl);

// Check result
if($answer == 0) {
	echo '<div class="alert alert-info background-info">
	<strong>Sucesso!</strong> Banco de dados criado com sucesso</code>
	</div>';
} else {
	echo '<div class="alert alert-danger background-danger">
	<strong>Erro!</strong> Erro ao criar banco de dados (Erro '.$answer.').</code>
	</div>';
}
#endregion

#region Faz upload do banco de dados
try{
	$PDO2 = new PDO('mysql:host='.$iphospedagem.';dbname='.$_POST['uservestacp']."_hotel", $_POST['uservestacp']."_hotel", $_POST['senhavestacp']);
	$importa = $PDO2->prepare(file_get_contents("../galaxyservers/emuladores/database_gservers.sql"));
	$importa->execute();
	echo '<div class="alert alert-success background-success">
	<strong>Sucesso!</strong> Banco de dados instalado.
	</div>';
}catch(Exception $e){
	echo '<div class="alert alert-danger background-danger">
	<strong>Erro!</strong> Erro ao instalar banco de dados. ('.$e.')
	</div>';
}
#endregion

#region Faz o upload da CMS 
#### Configura a CMS

if($planos['compilar_swf'] == "true"){
	$nome_habboswf = $_POST['uservestacp'];

	if($_POST['swf'] == 1 || $_POST['swf'] == "1"){

		file_get_contents($dominio.'/admin/editacompilador.php?nomehotel='.$_POST['nomehotel'].'&linkhotel='.$linkdohotel.'&uservestacp='.$_POST['uservestacp'].'&http='.$_POST['http']);
		exec("cd C:/xampp\htdocs\galaxyservers\CompilaHabboSwf\ && start Compilador.exe");

	} else if($_POST['swf'] == 2 || $_POST['swf'] == "2"){
		file_get_contents($dominio.'/admin/editacompilador2.php?nomehotel='.$_POST['nomehotel'].'&linkhotel='.$linkdohotel.'&uservestacp='.$_POST['uservestacp'].'&http='.$_POST['http']);
		exec("cd C:/xampp\htdocs\galaxyservers\CompilaHabboSwf2\ && start Compilador.exe");
	} 

}
else
	$nome_habboswf = "Habbo";

$arquivo_configuracao_cms = '<?php
if(!defined("BRAIN_CMS")) 
{ 
	die("Você não pode acessar esse arquivo..."); 
}

$db["host"] = "localhost";
$db["port"] = "3306";
$db["user"] = "'.$_POST['uservestacp'].'_hotel"; 
$db["pass"] = "'.$_POST['senhavestacp'].'";
$db["db"] = "'.$_POST['uservestacp'].'_hotel";

/* Emulador */
$config["hotelEmu"] = "plusemu"; /// Não mecha

/* API KEY GalaxyServers */
$config["apikey"] = "'.md5($_POST['uservestacp']."galaxyservers".$_POST['senhavestacp']).'";/// Chave API do GalaxyPanel
$config["linkgalaxypanel"] = "'.$dominio.'"; 

/* Configurações do site */
$config["hotelUrl"] = "'.$http.'://'.$linkdohotel.'";
$config["skin"] = "GalaxyServers"; 
$config["lang"] = "en";
$config["hotelName"] = "'.$_POST['nomehotel'].'"; // Nome do hotel
$config["favicon"] = "https://i.imgur.com/6pY70ee.png"; /// Link do favicon em PNG
$config["staffCheckHk"] = false;
$config["staffCheckHkMinimumRank"] = 4; // Rank mínimo para ter o HouseKeeping
$config["maintenance"] = false; //Manuntenção | true ativa e false desativa
$config["maintenancekMinimumRankLogin"] = 4; 
$config["groupBadgeURL"] = "'.$http.'://'.$linkdohotel.'/habbo-imaging/badge/";
$config["badgeURL"] = "'.$http.'://cdn.galaxyservers.com.br/emblema.php?cod="; 

/* Configurações da client */
$hotel["emuHost"] = "'.$ipemuclient.'"; 
$hotel["emuPort"] = "'.$_POST['portatcp'].'";  
$hotel["staffCheckClient"] = false;
$hotel["staffCheckClientMinimumRank"] = 3;
$hotel["homeRoom"] = 0; /// ID do quarto inicial (0 vai pro looby)
$hotel["external_Variables"] = "'.$http.'://'.$linkswf.'/gamedata/variables.php?hotelurl='.$http.'://'.$linkdohotel.'";
$hotel["external_Variables_Override"] = "'.$http.'://'.$linkswf.'/gamedata/override/external_override_variables.txt";
$hotel["external_Texts"] = "'.$http.'://'.$linkswf.'/gamedata/texts.php?user='.$_POST['uservestacp'].'";
$hotel["external_Texts_Override"] = "'.$http.'://'.$linkswf.'/gamedata/override/override_texts.php?user='.$_POST['uservestacp'].'";
$hotel["productdata"] = "'.$http.'://'.$linkswf.'/gamedata/productdata.txt";
$hotel["furnidata"] = "'.$http.'://'.$linkswf.'/gamedata/furnidata_galaxyservers.xml";
$hotel["figuremap"] = "'.$http.'://'.$linkswf.'/gamedata/figuremap.xml";
$hotel["figuredata"] = "'.$http.'://'.$linkswf.'/gamedata/figuredata.xml";
$hotel["swfFolder"] = "'.$http.'://'.$linkswf.'/gordon/GALAXYSERVERS";
$hotel["swfFolderSwf"] = "'.$http.'://'.$linkswf.'/gordon/GALAXYSERVERS/'.$nome_habboswf.'.swf";

$config["linklogo"] = "http://habbox.com/text/HabNew/'.$_POST['nomehotel'].'"; /// Link da logo do hotel

$config["facebookLogin"] = false; 
$config["facebookAPPID"] = "334162590sdaf292528";
$config["facebookAPPSecret"] = "ce2504ff5adsfa3ff7a6a2fa6d984cd8836";

/* Configurações do email para sistema de recuperar senha */
$email["mailServerHost"] = "localhost";
$email["mailServerPort"] = 587;
$email["SMTPSecure"] = "TLS";
$email["mailUsername"] = "noreply@'.str_replace('http://', '', str_replace('https://', '', $linkdohotel)).'";
$email["mailPassword"] = "'.$_POST['senhavestacp'].'";
$email["mailLogo"] = "https://i.imgur.com/XbyUs4z.png";
$email["mailTemplate"] = "/system/app/plugins/PHPmailer/temp/resetpassword.html";

/* Redes Sociais */
$config["facebook"] = "https://www.facebook.com/GalaxyServersHosting/"; // Link página do facebook
$config["facebookEnable"] = true; /// ativa/desativa facebook
$config["twitter"] = "https://twitter.com/Habbo";
$config["twitterEnable"] = false;

/* Registro*/
$config["startMotto"] = "Sou novo no '.$_POST['nomehotel'].'"; // Missão inicial
$config["startLook"] = "hr-802-61.fa-1201-63.lg-280-110.ch-255-1408.hd-180-10.sh-906-1408"; // Visual inicial
$config["credits"] = "1000";
$config["duckets"] = "0";
$config["diamonds"] = "0";
$config["diamondsRef"] = "10";
$config["registerEnable"] = true; // True ativa registro / false desativa

/* Google recaptcha */
$config["recaptchaSiteKey"] = "6LdzewwUAAAAABkJ3vsdfCDca9qmLGDaWAHqMRtFEs2";
$config["recaptchaSiteKeyEnable"] = false;

/* Buy VIP Settings */
$config["vipCost"] = "25";
$config["vipRankToGet"] = "3";
$config["vipBadge"] = "vip";

$config["discord"] = "0";

date_default_timezone_set("America/Sao_Paulo");
?>';

$nomearquivocms = "../galaxyservers/galaxycms/configcms.php";
$fpc = fopen($nomearquivocms, "w");
$escreve = fwrite($fpc, $arquivo_configuracao_cms);
$linkhotel = str_replace("http:", "", str_replace("https:", "", str_replace("/", "", $_POST['linkhotel'])));
$con_id = ftp_connect($iphospedagem) or die( '<div class="alert alert-danger">Não conectou em: '.$iphospedagem.'</div>');
ftp_login($con_id, $_POST['uservestacp'], $_POST['senhavestacp']);
ftp_pasv($con_id, true) or die('<script>alert("Cannot switch to passive mode")</script>'); 
ftp_mkdir($con_id, '/web/'.$linkhotel.'/public_html/system');
if (ftp_put( $con_id, '/web/'.$linkhotel.'/public_html/system/brain-config.php', $nomearquivocms, FTP_BINARY  ) ) {
	echo '<!--<div class="alert alert-success background-success">
	<strong>Sucesso!</strong> CMS configurada.
	</div>-->';
}
else {
	echo '<div class="alert alert-danger background-danger">
	<strong>Erro!</strong> Erro ao configurar cms.
	</div>';
} 
$fpc = fopen($nomearquivocms, "w");
$escreve = fwrite($fpc, "");
### FIM
ob_start(); 
set_time_limit(0); 
$sourcedir="../galaxyservers/galaxycms/".$_POST["cms"]."/"; //this is the folder that you want to upload with all subfolder and files of it.
$ftpserver=$iphospedagem; //ftp domain name
$ftpusername=$_POST['uservestacp'];  //ftp user name 
$ftppass=$_POST['senhavestacp']; //ftp passowrd
$ftpremotedir= '/web/'.$linkhotel.'/public_html'; //ftp main folder
$ftpconnect = ftp_connect($ftpserver); 
$ftplogin = ftp_login($ftpconnect, $ftpusername, $ftppass); 
ftp_pasv($ftpconnect, true) or die('<script>alert("Cannot switch to passive mode")</script>'); 
if((!$ftpconnect) || (!$ftplogin))  
{ 
	echo '<script>alert("Não foi possível conectar ao servidor FTP.")</script>'; 
	die(); 
} 
function direction($dirname) 
{ 
	global $from,$fulldest,$ftpremotedir,$ftpconnect,$ftpremotedir; 
	chdir($dirname."\\"); 
	$directory = opendir("."); 
	while($information=readdir($directory))  
	{ 
		if ($information!='.' and $information!='..' and $information!="Thumbs.db") 
		{  
			$readinfo="$dirname\\$information"; 
			$localfil=str_replace("".$from."\\","",$dirname).""; 
			$localfold="$localfil\\$information"; 
			$ftpreplacer=str_replace(array("\\\\","\\"),array("/","/"),"$ftpremotedir\\".str_replace("".$fulldest."","",$dirname)."\\$information"); 

			if(!is_dir($information)) 
			{ 
				$loading = ftp_put($ftpconnect, $ftpreplacer, $readinfo, FTP_BINARY); 
			} 
			else 
			{  
				@ftp_mkdir($ftpconnect, $ftpreplacer); 
				direction("$dirname\\$information"); 
				chdir($dirname."\\"); 
				fls(); 
			} 
		} 
	} 
	closedir ($directory); 
} 
function fls() 
{ 
	ob_end_flush(); 
	ob_flush(); 
	flush(); 
	ob_start(); 
} 
$from=getcwd(); 
$fulldest=$from."\\$sourcedir"; 
direction($fulldest); 
ftp_close($ftpconnect); 
echo '<div class="alert alert-success background-success">
<strong>Sucesso!</strong> CMS instalada.
</div>';


#endregion

}  else {
	echo '<div class="alert alert-danger background-danger">
	<strong>Erro!</strong> Erro ao criar emulador.</code>
	</div>';						
}
}
} else {
	echo '<div class="alert alert-danger background-danger">
	<strong>Erro!</strong> Já existe um hotel com esses dados.</code>
	</div>';
}
}
}
$pegaportas = $PDO->prepare("select portatcp + 2 as tcpnovo, portamus + 2 as musnovo from servidores order by id desc limit 1");
$pegaportas->execute();
$porta = $pegaportas->fetch();
?>
<form method="POST" name="criarhotel">
	<div class="form-group row">
		<label class="col-sm-2 col-form-label">Nome do Hotel</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" name="nomehotel" placeholder="Somente primeiro nome! exemplo: Space" required>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label">Link do hotel</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" name="linkhotel" value="" placeholder="galaxyservers.com.br" required>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label">Usuario</label>
		<div class="col-sm-10">
			<input type="text" id="user" class="form-control" onkeyup="funcaoJavascript()" name="uservestacp" placeholder="spacehotel" required>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label">Senha</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" name="senhavestacp" value="<?= substr(md5(time()), -10);?>" placeholder="spacehp123passvesta2018" required>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label">CMS</label>
		<div class="col-sm-10">
			<select class="form-control" name="cms">
				<?php
				$getArtdicles = $PDO->prepare("SELECT * FROM cms ORDER BY id");
				$getArtdicles->execute();
				while($dnews = $getArtdicles->fetch())
				{
					?>
					<option value="<?= $dnews['pasta'];?>"><?= $dnews['nome'];?></option>
				<?php } ?>
			</select>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label">HTTP/HTTPS</label>
		<div class="col-sm-10">
			<select class="form-control" name="http">
				<option value="http">http://</option>
				<option value="https">https://</option>
			</select>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label">Plano</label>
		<div class="col-sm-10">
			<select class="form-control" name="plano">
				<?php
				$getArtdicles = $PDO->prepare("SELECT id,plano FROM planos ORDER BY id");
				$getArtdicles->execute();
				while($dnews = $getArtdicles->fetch())
				{
					?>
					<option value="<?php echo $dnews['id']?>"><?php echo utf8_encode($dnews['plano'])?> (<?php echo utf8_encode($dnews['id'])?>)</option>
				<?php } ?>
			</select>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label">SWF</label>
		<div class="col-sm-10">
			<select class="form-control" name="swf">
				<option value="1">Estilo Padrão</option>
				<option value="2">Estilo 2</option>
			</select>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label">Email</label>
		<div class="col-sm-10">
			<input type="mail" class="form-control" name="emailcliente" placeholder="Email do cliente" required>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label">Porta TCP</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" name="portatcp" placeholder="3000" value="<?php if(empty($porta['tcpnovo']))echo'3000';else echo $porta['tcpnovo'];?>" autocomplete="off" required readonly>
		</div>
	</div>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label">Porta MUS</label>
		<div class="col-sm-10">
			<input type="text" class="form-control" name="portamus" placeholder="3001" value="<?php if(empty($porta['musnovo']))echo'3001';else echo $porta['musnovo'];?>" autocomplete="off" required readonly>
		</div>
	</div>
	<center><button name="criarhotel" type="submit" class="btn btn-primary btn-square">Criar Conta</button></center>
</form>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<script type="text/javascript" src="../galaxyservers/bower_components/jquery/js/jquery.min.js"></script>
<script type="text/javascript" src="../galaxyservers/bower_components/jquery-ui/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="../galaxyservers/bower_components/popper.js/js/popper.min.js"></script>
<script type="text/javascript" src="../galaxyservers/bower_components/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../galaxyservers/bower_components/jquery-slimscroll/js/jquery.slimscroll.js"></script>
<script type="text/javascript" src="../galaxyservers/bower_components/modernizr/js/modernizr.js"></script>
<script src="../galaxyservers/assets/pages/widget/amchart/amcharts.min.js"></script>
<script src="../galaxyservers/assets/pages/widget/amchart/serial.min.js"></script>
<script type="text/javascript" src="../galaxyservers/bower_components/chart.js/js/Chart.js"></script>
<script type="text/javascript" src="../galaxyservers/assets/pages/todo/todo.js"></script>
<script type="text/javascript" src="../galaxyservers/assets/js/script.js"></script>
<script type="text/javascript" src="../galaxyservers/assets/js/bootstrap-growl.min.js"></script>
<script type="text/javascript" src="../galaxyservers/bower_components/i18next/js/i18next.min.js"></script>
<script type="text/javascript" src="../galaxyservers/bower_components/i18next-xhr-backend/js/i18nextXHRBackend.min.js"></script>
<script type="text/javascript" src="../galaxyservers/bower_components/i18next-browser-languagedetector/js/i18nextBrowserLanguageDetector.min.js"></script>
<script type="text/javascript" src="../galaxyservers/bower_components/jquery-i18next/js/jquery-i18next.min.js"></script>
<script type="text/javascript" src="../galaxyservers/assets/pages/notification/notification.js"></script>
<script type="text/javascript" src="../galaxyservers/assets/pages/dashboard/custom-dashboard.min.js"></script>
<script type="text/javascript" src="../galaxyservers/assets/js/SmoothScroll.js"></script>
<script src="../galaxyservers/assets/js/pcoded.min.js"></script>
<script src="../galaxyservers/assets/js/demo-12.js"></script>
<script src="../galaxyservers/assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script type="text/javascript" src="../galaxyservers/assets/js/script.min.js"></script>
<script type="text/javascript">
	funcaoJavascript = function(){
		var a = document.getElementById('user');
		var b = document.getElementById('db');
		if(a.value == "")
			b.value = a.value;
		else 
			b.value = a.value+"_hotel";
	}
</script>
</body>
</html>
<?php } ?>