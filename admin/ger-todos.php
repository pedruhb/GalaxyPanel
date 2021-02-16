<?php include "../galaxyservers/global.php";
if(empty($_SESSION['useradmin'])){
	echo '<script>location.href="index";</script>';
}
if (!empty($_SESSION['useradmin'])){

	include "nav.php";
	?>
	<div class="pcoded-content">
<div class="pcoded-inner-content">
	<div class="main-body">
<div class="page-wrapper">
	<div class="page-body">
<div class="card">
	<div class="card-header">
<h5>Emuladores</h5>
<span>Escolha a ação que será enviada para todos os emuladores abaixo.</a></span>
<div class="card-header-right"><i class="icofont icofont-spinner-alt-5"></i></div>
<div class="card-header-right">
	<i class="icofont icofont-spinner-alt-5"></i>
</div>
	</div>
	<div class="card-block">
<?php
error_reporting(0);

if (isset($_POST['desligartodos']))
{
	$atualizastatus = $PDO->prepare("UPDATE servidores SET estado = 'desligado'");
	$atualizastatus->execute();
	
	$selecionatodos1 = $PDO->prepare("SELECT portamus FROM servidores WHERE estado = 'ligado'");
	$selecionatodos1->execute();
	while($selecao1 = $selecionatodos1->fetch()){
sendRCONCommand('desligaremulador', '', $ipvps, $selecao1['portamus']);
	}
	
	echo '<div class="alert alert-success background-success">
	<strong>Sucesso!</strong> Todos os emuladores ligados foram desligados!
	</div>'; 
	addlog_admin($_SESSION['useradmin'], "Desligou todos os emuladores.");
}

if (isset($_POST['reiniciartodos']))
{
	$selecionatodos1 = $PDO->prepare("SELECT portamus FROM servidores WHERE estado = 'ligado'");
	$selecionatodos1->execute();
	while($selecao1 = $selecionatodos1->fetch()){
sendRCONCommand('reiniciaremulador', '', $ipvps, $selecao1['portamus']);
	}
	echo '<div class="alert alert-success background-success">
	<strong>Sucesso!</strong> Todos os emuladores ligados foram reiniciados!
	</div>'; 
	addlog_admin($_SESSION['useradmin'], "Reiniciou todos os emuladores.");
}

if (isset($_POST['atualizartodos']))
{
	$selecionatodos = $PDO->prepare("SELECT * FROM servidores WHERE estado = 'desligado' AND ativo = 'Y'");
	$selecionatodos->execute();

	$selecionatodos2 = $PDO->prepare("UPDATE servidores SET estado = 'atualizando' WHERE ativo = 'Y'");
	$selecionatodos2->execute();

	while($selecao = $selecionatodos->fetch()){
$pasta = "../galaxyservers/emuladores/sourcegalaxy"; //pasta que sera copiada
$pastad = "../galaxyservers/emuladores/".$selecao['uservestacp'];//pasta de destino pode ou n estar criada
if(!is_dir($pastad)){//verifica se existe a pasta de destino
mkdir($pastad,0777);//cria a pasta
chmod($pastad,0777);//muda a permissao
}$aberta = opendir($pasta);//abre a pasta para ver os arquivos
while($res=readdir($aberta)){//vendo os arquivos da pasta
@copy($pasta."/".$res,$pastad. "/".$res); //copiando os arquivos
}
}
echo '<div class="alert alert-success background-success">
<strong>Sucesso!</strong> Emuladores que estavam desligados foram atualizados!
</div>'; 
$adicionalog = $PDO->prepare("INSERT INTO `log_admin` (`log`, `autor`, `ip`, `data`) VALUES ('Atualizou todos os emuladores.', '".$_SESSION['useradmin']."', '', '".time()."');");
$adicionalog->execute();
$selecionatodos = $PDO->prepare("UPDATE servidores SET estado = 'desligado' WHERE ativo = 'Y'");
$selecionatodos->execute();
}

if (isset($_POST['ligartodos']))
{
	$selecionatodos = $PDO->prepare("SELECT * FROM servidores WHERE ativo = 'Y'");
	$selecionatodos->execute();
	while($selecao = $selecionatodos->fetch()){
popen("C:/xampp/htdocs/galaxyservers/emuladores/".$selecao['uservestacp']."/galaxyserverligar.bat", "r");
	}
	$atualizastatus = $PDO->prepare("UPDATE servidores SET estado = 'ligado' WHERE ativo = 'Y'");
	$atualizastatus->execute();
	echo '<div class="alert alert-success background-success">
	<strong>Sucesso!</strong> Todos os emuladores foram ligados!
	</div>'; 
	addlog_admin($_SESSION['useradmin'], "Atualizou todos os emuladores");
}

if (isset($_POST['alertartodos']))
{
	$conteudoalert = 'O hotel será reiniciado para uma rápida atualização, volte em instantes.';
	$selecionatodos1 = $PDO->prepare("SELECT portamus FROM servidores WHERE estado = 'ligado' AND ativo = 'Y'");
	$selecionatodos1->execute();
	while($selecao1 = $selecionatodos1->fetch()){
sendRCONCommand('hotel_alert', $conteudoalert, $ipvps, $selecao1['portamus']);
	}
	echo '<div class="alert alert-success background-success">
	<strong>Sucesso!</strong> Todos os emuladores ligados foram alertados!
	</div>'; 
	addlog_admin($_SESSION['useradmin'], "Alertou todos os emuladores");
}

if (isset($_POST['configemu']))
{
	$selecionatodos1 = $PDO->prepare("SELECT * FROM servidores;");
	$selecionatodos1->execute();
	while($selecao1 = $selecionatodos1->fetch()){
$PrincipalConfig = "### Arquivo de configuração do Galaxy Server!
### Emulador programado por PHB.

## Configuração MYSQL
db.hostname=".$iphospedagem."
db.port=3306
db.username=".gs($selecao1['uservestacp'])."_hotel
db.password=".gs($selecao1['senhavestacp'])."
db.name=".gs($selecao1['uservestacp'])."_hotel

## MySQL pooling setup (controla a quantidade de conexões)
db.pool.minsize=10
db.pool.maxsize=250

## Game TCP/IP Configuração
game.tcp.bindip=".$ipvps."
game.tcp.port=".gs($selecao1['portatcp'])."
game.tcp.conlimit=100000
game.tcp.conperip=3
game.tcp.enablenagles=true

## MUS TCP/IP Configuração
mus.tcp.bindip=".$ipvps."
mus.tcp.port=".gs($selecao1['portamus'])."
mus.tcp.allowedaddr=".$ipvps."

## Client Configuração
client.ping.enabled=1
client.ping.interval=3
client.maxrequests=300

## Configuração do Nome do seu hotel
hotel.name=".gs($selecao1['nomehotel'])."
license=".gs($selecao1['nomehotel'])." Hotel
game.legacy.figure_mutant=1

# Rank Mánimo de Staff
MineRankStaff=7

## Hall da Fama na client (0 = não / 1 = sim)
halldafama=0

## Tipo (1 = gotw/ 2 =diamantes/ 3 = duckets/ 4 =moedas)
tipohall=2";
$CaminhoConfig = "../galaxyservers/emuladores/".gs($selecao1['uservestacp'])."/Config/config.ini";

$fp = fopen($CaminhoConfig, "w");
$escreve = fwrite($fp, $PrincipalConfig);
fclose($fp);
	}
	echo '<div class="alert alert-success background-success">
	<strong>Sucesso!</strong> Todos os emuladores foram configurados!
	</div>'; 
	addlog_admin($_SESSION['useradmin'], "Configurou todos os emuladores");
}

if (isset($_POST['configports']))
{
	$selecionatodos1 = $PDO->prepare("SELECT * FROM servidores;");
	$selecionatodos1->execute();
	while($selecao1 = $selecionatodos1->fetch()){

$portanova_tcp = $selecao1['id'];
$portanova_mus = $selecao1['id'];

$Att = $PDO->prepare("UPDATE servidores set portatcp = '3".$portanova_tcp."', portamus = '".$portanova_mus."1' WHERE id = '".$selecao1['id']."'");
$Att->execute();
	}
	echo '<div class="alert alert-success background-success">
	<strong>Sucesso!</strong> Todos as portas foram configuradas.
	</div>'; 
	addlog_admin($_SESSION['useradmin'], "Configurou a porta todos os emuladores");

}

if (isset($_POST['configcms']))
{
	set_time_limit(0);

	$selecionatodos1 = $PDO->prepare("SELECT * FROM servidores WHERE ativo = 'Y';");
	$selecionatodos1->execute();
	while($server = $selecionatodos1->fetch()){

if($server['habboswf'] == 'Y')
	$nomeswfarquivo = $server['uservestacp'].".swf?CameraFuncionando";
else 
	$nomeswfarquivo = "Habbo.swf?";
$arquivo_configuracao = '<?php
if(!defined("BRAIN_CMS")) 
{ 
	die("Você não pode acessar esse arquivo..."); 
}

$db["host"] = "localhost";
$db["port"] = "3306";
$db["user"] = "'.$server['uservestacp'].'_hotel"; 
$db["pass"] = "'.$server['senhavestacp'].'";
$db["db"] = "'.$server['uservestacp'].'_hotel";

$config["apikey"] = "'.md5($server['uservestacp']."galaxyservers".$server['senhavestacp']).'"; /// Chave API do GalaxyPanel
$config["linkgalaxypanel"] = "'.$dominio.'";

/* Emulador */
$config["hotelEmu"] = "plusemu"; /// Não mexa

/* Configurações do site */
$config["hotelUrl"] = "'.$server['http'].'://'.str_replace("http://", "", str_replace("https://", "", $server['linkhotel'])).'"; /// Link do Hotel
$config["skin"] = "GalaxyServers"; 
$config["lang"] = "en";
$config["hotelName"] = "'.$server['nomehotel'].'"; // Nome do hotel
$config["favicon"] = "https://i.imgur.com/6pY70ee.png"; /// Link do favicon em PNG
$config["staffCheckHk"] = false;
$config["staffCheckHkMinimumRank"] = 4; // Rank mínimo para ter o HouseKeeping
$config["maintenance"] = false; //Manuntenção | true ativa e false desativa
$config["maintenancekMinimumRankLogin"] = 4; 
$config["groupBadgeURL"] = "'.$server['http'].'://'.str_replace("http://", "", str_replace("https://", "", $server['linkhotel'])).'/habbo-imaging/badge/";
$config["badgeURL"] = "http://'.$linkswf.'/emblema.php?cod="; 

/* Configurações da client */
$hotel["emuHost"] = "'.$ipemuclient.'"; 
$hotel["emuPort"] = "'.$server['portatcp'].'";  
$hotel["staffCheckClient"] = false;
$hotel["staffCheckClientMinimumRank"] = 3;
$hotel["homeRoom"] = 0; /// ID do quarto inicial (0 vai pro looby)
$hotel["external_Variables"] = "'.$server['http'].'://'.$linkswf.'/gamedata/variables.php?hotelurl='.$server['http'].'://'.str_replace("http://", "", str_replace("https://", "", $server['linkhotel'])).'";
$hotel["external_Variables_Override"] = "'.$server['http'].'://'.$linkswf.'/gamedata/override/external_override_variables.txt";
$hotel["external_Texts"] = "'.$server['http'].'://'.$linkswf.'/gamedata/texts.php?hotelname='.$server['nomehotel'].'";
$hotel["external_Texts_Override"] = "'.$server['http'].'://'.$linkswf.'/gamedata/override/override_texts.php?hotelname='.$server['nomehotel'].'";
$hotel["productdata"] = "'.$server['http'].'://'.$linkswf.'/gamedata/productdata.txt";
$hotel["furnidata"] = "'.$server['http'].'://'.$linkswf.'/gamedata/furnidata_galaxyservers.xml";
$hotel["figuremap"] = "'.$server['http'].'://'.$linkswf.'/gamedata/figuremap.xml";
$hotel["figuredata"] = "'.$server['http'].'://'.$linkswf.'/gamedata/figuredata.xml";
$hotel["swfFolder"] = "'.$server['http'].'://'.$linkswf.'/gordon/GALAXYSERVERS";
$hotel["swfFolderSwf"] = "'.$server['http'].'://'.$linkswf.'/gordon/GALAXYSERVERS/'.$nomeswfarquivo.time().'";

$config["linklogo"] = "http://habbox.com/text/HabNew/'.$server['nomehotel'].'"; /// Link da logo do hotel

$config["facebookLogin"] = false; 
$config["facebookAPPID"] = "334162590sdaf292528";
$config["facebookAPPSecret"] = "ce2504ff5adsfa3ff7a6a2fa6d984cd8836";

/* Configurações do email para sistema de recuperar senha */
$email["mailServerHost"] = "localhost";
$email["mailServerPort"] = 587;
$email["SMTPSecure"] = "TLS";
$email["mailUsername"] = "Coloque um email aqui";
$email["mailPassword"] = "Coloque a senha do email aqui";
$email["mailLogo"] = "https://i.imgur.com/XbyUs4z.png";
$email["mailTemplate"] = "/system/app/plugins/PHPmailer/temp/resetpassword.html";

/* Redes Sociais */
$config["facebook"] = "https://www.facebook.com/GalaxyServersHosting/"; // Link página do facebook
$config["facebookEnable"] = true; /// ativa/desativa facebook
$config["twitter"] = "https://twitter.com/Habbo";
$config["twitterEnable"] = false;

/* Registro*/
$config["startMotto"] = "Sou novo no '.$server['nomehotel'].'!"; // Missão inicial
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

date_default_timezone_set("America/Sao_Paulo");
?>';
$nomearquivoc = "../galaxyservers/galaxycms/configcms.php";
$fpc = fopen($nomearquivoc, "w");
$escreve = fwrite($fpc, $arquivo_configuracao);
$linkhotel = str_replace("http:", "", str_replace("https:", "", str_replace("/", "", $server['linkhotel'])));

$con_id = ftp_connect($iphospedagem) or die( '<div class="alert alert-danger">Não conectou em: '.$servidor.' "'.$server['uservestacp'].'".</div>');
ftp_login( $con_id, $server['uservestacp'], $server['senhavestacp']);
ftp_pasv($con_id, true) or die('<script>alert("Cannot switch to passive mode "'.$server['uservestacp'].'".")</script>'); 
if (ftp_put( $con_id, '/web/'.$linkhotel.'/public_html/system/brain-config.php', '../galaxyservers/galaxycms/configcms.php', FTP_BINARY  ) ) {
	echo '<div class="alert alert-success background-success">
	<strong>Sucesso!</strong> CMS do "'.$server['uservestacp'].'" foi configurada.
	</div>';
} else {
	echo '<div class="alert alert-danger background-danger">
	<strong>Erro!</strong> Erro ao configurar cms do "'.$server['uservestacp'].'".
	</div>';	
}
$fpc = fopen($nomearquivoc, "w");
$escreve = fwrite($fpc, "");
sleep(3);
	}
	echo '<div class="alert alert-success background-success">
	<strong>Sucesso!</strong> Todos as cms foram configuradas.
	</div>'; 
	addlog_admin($_SESSION['useradmin'], "Configurou a cms de todos os hotéis.");

}
if(isset($_POST['ligabot'])){
	$SelecionaHotel = $PDO->prepare("SELECT * FROM servidores WHERE botdiscord not like 'desativado'");
	$SelecionaHotel->execute();
	while($hotel = $SelecionaHotel->fetch()){
                   popen("C:/xampp/htdocs/galaxyservers/emuladores/".$hotel['uservestacp']."/bot_discord/iniciar.bat", "r"); /// liga o bot
                   $attStatus = $PDO->prepare("UPDATE servidores SET botdiscord = 'ligado' WHERE id = '".$hotel['id']."';");
                   $attStatus->execute();

               }
           }
           ?>
           <form method="POST">
           	<center><button class="btn btn-primary" style="border-radius: 8px;" type="submit" name="desligartodos">Desligar todos os emuladores</button></center>
           	<br>
           	<center><button class="btn btn-primary" style="border-radius: 8px;" type="submit" name="ligartodos">Ligar emuladores desligados</button></center>
           	<br>
           	<center><button class="btn btn-primary" style="border-radius: 8px;" type="submit" name="reiniciartodos">Reiniciar emuladores ligados</button></center>
           	<br>
           	<center><button class="btn btn-primary" style="border-radius: 8px;" type="submit" name="atualizartodos">Atualizar emuladores desligados</button></center>
           	<br>
           	<center><button class="btn btn-primary" style="border-radius: 8px;" type="submit" name="alertartodos">Alertar todos os emuladores ligados</button></center>
           	<br>
           	<center><button class="btn btn-primary" style="border-radius: 8px;" type="submit" name="configports">Reconfigurar portas mus e tcp</button></center>
           	<br>
           	<center><button class="btn btn-primary" style="border-radius: 8px;" type="submit" name="configemu">Configurar emuladores</button></center>
           	<br>
           	<center><button class="btn btn-primary" style="border-radius: 8px;" type="submit" name="configcms">Configurar todas as cms</button></center>
           	<br>
           	<center><button class="btn btn-primary" style="border-radius: 8px;" type="submit" name="ligabot">Ligar bots</button></center>
           	<br>
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
</body>
</html>
<?php } ?>