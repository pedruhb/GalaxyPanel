<?php
include "galaxyservers/global.php";
if(!empty($_SESSION['nomeusuario'])){

	$infoserver = $PDO->prepare("SELECT * FROM servidores WHERE nomeusuario = '".$_SESSION['nomeusuario']."'");
	$infoserver->execute();
	$server = $infoserver->fetch();
	$_SESSION['senhaatualdb'] = $server['senhavestacp'];

	?>
	<?php include 'galaxyservers/nav.php';?>
	<div class="pcoded-content">
		<div class="pcoded-inner-content">
			<div class="main-body user-profile">
				<div class="page-wrapper">
					<div class="page-body">
						<div class="card">
							<div class="card-block">
								<div class="m-b-20">
									<h4 class="sub-title">Altere o domínio do hotel</h4>
									<form method="POST" enctype="multipart/form-data">	

										<?php

										if(isset($_SESSION['subconta'])){
											echo '<br><div style="display: contents;">
											<div class="col-md-12">
											<center><div class="alert alert-danger background-danger">
											<strong>Erro!</strong> Sua subconta não tem permissão para acessar essa página.
											</div></center>
											</div>
											</div>';
										} else { 

function removehttp($string){
return str_replace("http", "", str_replace("https", "", str_replace("/", "", str_replace(":", "", str_replace(" ", "", $string)))));
}

if(isset($_POST['salvar-config'])){

$dominio = removehttp($_POST['dominio']);
$dominioatual = removehttp($server['linkhotel']);
$dominio = strtolower($dominio);
$likedominio1 = $dominio.'%';
$likedominio2 = 'https://'.$dominio.'%';
$likedominio3 = 'http://'.$dominio.'%';
$selecionaHps = $PDO->prepare("SELECT * FROM servidores WHERE linkhotel like :dominio1 or linkhotel like :dominio2 or linkhotel like :dominio3;");
$selecionaHps->bindParam(':dominio1', $likedominio1);
$selecionaHps->bindParam(':dominio2', $likedominio2);
$selecionaHps->bindParam(':dominio3', $likedominio3);
$selecionaHps->execute();
$hpscount = $selecionaHps->rowCount();

$linknovocompleto = strtolower($server['http']).'://'.strtolower($dominio);

if($informacao['status'] == "2"){
	loginerror("O emulador está ligado.");
} else if($dominioatual == $dominio){
	loginerror("O domínio é o mesmo do atual.");
} else if($hpscount != 0){
	loginerror("Já existe um hotel com esse domínio \"".$dominio."\".");
} else {

#region ADD DOMINIO NA HOSPEDAGEM
$postvars = array(
	'user' => $uservestacp,
	'password' => $passvestacp,
	'returncode' => 'yes',
	'cmd' => 'v-add-domain',
	'arg1' => $server['uservestacp'],
	'arg2' => $dominio
);
$postdata = http_build_query($postvars);
$postdata = http_build_query($postvars);
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $vst_hostname);
curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
$answer = curl_exec($curl);
if($answer == 0) {

$con_id = ftp_connect($iphospedagem) or die('<div class="alert alert-danger">Não conectou em: '.$iphospedagem.'</div>');
ftp_login( $con_id, $server['uservestacp'], $server['senhavestacp']);
ftp_pasv($con_id, true) or die('<script>alert("Cannot switch to passive mode")</script>'); 
if(ftp_rename($con_id, '/web/'.$dominioatual.'/', '/web/GalaxyServers/'))
#endregion	

#region Remove domínio antigo da hospedagem
$postvars = array(
	'user' => $uservestacp,
	'password' => $passvestacp,
	'returncode' => 'yes',
	'cmd' => 'v-delete-domain',
	'arg1' => $server['uservestacp'],
	'arg2' => $dominioatual
);
$postdata = http_build_query($postvars);
$postdata = http_build_query($postvars);
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $vst_hostname);
curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
$answer = curl_exec($curl);
if($answer == 0) {
	echo '<div class="alert alert-info background-info">
	<strong>Sucesso!</strong> Domínio deletado com sucesso</code>
	</div>';
} else {
	echo '<div class="alert alert-danger background-danger">
	<strong>Erro!</strong> Erro ao deletar domínio (Erro '.$answer.').</code>
	</div>';
}
#endregion
#region FTP
if(ftp_rename($con_id, '/web/'.$dominio.'/', '/web/GalaxyServers2/'))
ftp_rename($con_id, '/web/GalaxyServers/', '/web/'.$dominio.'/');
ftp_rename($con_id, '/web/GalaxyServers2/', '/web/'.$dominioatual.'/');
#endregion	

#region Configura a CMS
if($planoi['compilar_swf'] == "true")
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
$db["user"] = "'.$server['uservestacp']."_hotel".'"; 
$db["pass"] = "'.$server['senhavestacp'].'";
$db["db"] = "'.$server['uservestacp']."_hotel".'";

$config["apikey"] = "'.md5($server['uservestacp']."galaxyservers".$server['senhavestacp']).'"; 

/* Emulador */
$config["hotelEmu"] = "plusemu"; /// Não mexa

/* Configurações do site */
	$config["hotelUrl"] = "'.$linknovocompleto.'"; /// Link do Hotel
$config["skin"] = "GalaxyServers"; 
$config["lang"] = "en";
$config["hotelName"] = "'.$server['nomehotel'].'"; // Nome do hotel
$config["favicon"] = "https://i.imgur.com/6pY70ee.png"; /// Link do favicon em PNG
$config["staffCheckHk"] = false;
$config["staffCheckHkMinimumRank"] = 4; // Rank mínimo para ter o HouseKeeping
$config["maintenance"] = false; //Manuntenção | true ativa e false desativa
$config["maintenancekMinimumRankLogin"] = 4; 
$config["groupBadgeURL"] = "'.$linknovocompleto.'/habbo-imaging/badge/";
$config["badgeURL"] = "http://swf.galaxypanel.top/emblema.php?cod="; 

/* Configurações da client */
$hotel["emuHost"] = "'.$ipemuclient.'"; 
$hotel["emuPort"] = "'.$server['portatcp'].'";  
$hotel["staffCheckClient"] = false;
$hotel["staffCheckClientMinimumRank"] = 3;
$hotel["homeRoom"] = 0; /// ID do quarto inicial (0 vai pro looby)
$hotel["external_Variables"] = "'.$server['http'].'://'.$linkswf.'/gamedata/variables.php?hotelurl='.$server['http'].'://'.str_replace("http://", "", str_replace("https://", "", $dominio)).'";
$hotel["external_Variables_Override"] = "'.$server['http'].'://'.$linkswf.'/gamedata/override/external_override_variables.txt";
$hotel["external_Texts"] = "'.$server['http'].'://'.$linkswf.'/gamedata/texts.php?user='.$server['uservestacp'].'";
$hotel["external_Texts_Override"] = "'.$server['http'].'://'.$linkswf.'/gamedata/override/override_texts.php?user='.$server['uservestacp'].'";
$hotel["productdata"] = "'.$server['http'].'://'.$linkswf.'/gamedata/productdata.txt";
$hotel["furnidata"] = "'.$server['http'].'://'.$linkswf.'/gamedata/furnidata_galaxyservers.xml";
$hotel["figuremap"] = "'.$server['http'].'://'.$linkswf.'/gamedata/figuremap.xml";
$hotel["figuredata"] = "'.$server['http'].'://'.$linkswf.'/gamedata/figuredata.xml";
$hotel["swfFolder"] = "'.$server['http'].'://'.$linkswf.'/gordon/GALAXYSERVERS";
$hotel["swfFolderSwf"] = "'.$server['http'].'://'.$linkswf.'/gordon/GALAXYSERVERS/'.$nomeswfarquivo.'";

$config["linklogo"] = "http://habbox.com/text/HabNew/'.$server['nomehotel'].'"; /// Link da logo do hotel

$config["facebookLogin"] = false; 
$config["facebookAPPID"] = "334162590sdaf292528";
$config["facebookAPPSecret"] = "ce2504ff5adsfa3ff7a6a2fa6d984cd8836";

/* Configurações do email para sistema de recuperar senha */
$email["mailServerHost"] = "localhost";
$email["mailServerPort"] = 587;
$email["SMTPSecure"] = "TLS";
$email["mailUsername"] = "noreply@'.str_replace('http://', '', str_replace('https://', '', $server['linkhotel'])).'";
$email["mailPassword"] = "'.$server['senhavestacp'].'";
$email["mailLogo"] = "https://i.imgur.com/XbyUs4z.png";
$email["mailTemplate"] = "/system/app/plugins/PHPmailer/temp/resetpassword.html";

/* Redes Sociais */
$config["facebook"] = "https://www.facebook.com/GalaxyServersHosting/"; // Link página do facebook
$config["facebookEnable"] = true; /// ativa/desativa facebook
$config["twitter"] = "https://twitter.com/Habbo";
$config["twitterEnable"] = false;

/* Registro*/
$config["startMotto"] = "Sou novo no '.$server['nomehotel'].'"; // Missão inicial
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
$nomearquivoc = "galaxyservers/emuladores/configcms.php";
$fpc = fopen($nomearquivoc, "w");
$escreve = fwrite($fpc, $arquivo_configuracao);
ftp_put( $con_id, '/web/'.$dominio.'/public_html/system/brain-config.php', 'galaxyservers/emuladores/configcms.php', FTP_BINARY  );
$fpc = fopen($nomearquivoc, "w");
$escreve = fwrite($fpc, "");
#endregion 
#region Database
$usercompleto = $server['uservestacp'];
$attServer = $PDO->prepare("UPDATE servidores SET linkhotel = :link where uservestacp = :user");
$attServer->bindParam(':link', $dominio);
$attServer->bindParam(':user', $usercompleto);
$attServer->execute();
#endregion
#region Edita no emulador
$PegaEstadoAtual = $PDO->prepare("SELECT * FROM config_servidores WHERE servidor = '".$server['id']."'");
$PegaEstadoAtual->execute();
$EstadoAtual = $PegaEstadoAtual->fetch();
$ExtrasConfig = "## Nome dos pontos (GOTW)
coin.points.name=".utf8_decode($EstadoAtual['nomegotw'])."
### Nome moedas
coin.credits.name=".utf8_decode($EstadoAtual['nomemoedas'])."
### Nome duckets
coin.duckets.name=".utf8_decode($EstadoAtual['nomeduckets'])."
### Nome diamantes
coin.diamonds.name=".utf8_decode($EstadoAtual['nomediamantes'])."

## Staffs
staff.effect.inroom=false
staff.mensg.inroom=false

## Camera (cuidado ao mecher nos links)
camera.enable=true
camera.api.http=".$server['http']."://".$dominio."/camera/
camera.output.pictures=".$server['http']."://".$dominio."/camera/pictures/
camera.picture.purchase.alert.id=false
camera.photo.publish.price.duckets=10
camera.photo.purchase.item_id=1100001495
camera.photo.purchase.price.coins=00
camera.photo.purchase.price.duckets=10
camera.preview.maxcache=1000

## Rank mínimo para ter acesso a ferramente de embaixador
ambassador.minrank=".$EstadoAtual['rankminimoferramentaemb']."

## Emblema staff sobre a cabeça
emblemacabeca.staff=".$EstadoAtual['emblemacabecastaff']."
emblemacabeca.embaixador=".$EstadoAtual['emblemacabecaemb']."

## Configuração dos Quartos
Quartovip=".$EstadoAtual['quartovip']."
Prisao=".$EstadoAtual['quartoprisao']."

## Premio por atividade
PremioPorAtividade=".$EstadoAtual['premioporatividade']."
MensagemAoReceber=true
Intervalo=".$EstadoAtual['tempoon']."

# Comando Premiar
NiveltotalGames=".$EstadoAtual['nivelmax']."
CodEmblemaNivel=".$EstadoAtual['emblemapremiar']."

### Nick de quem pode usar o comando reiniciar
ReiniciarPermissao=".$EstadoAtual['reiniciargalaxy']."

## Rank que vai aparecer balão embaixador
RankEmbaixador=".$EstadoAtual['rankbalaoemb']."

### Premiação diária
PremiacaoDiaria=".$EstadoAtual['premiodiario'];
#endregion
	echo '<div class="alert alert-info background-info">
	<strong>Sucesso!</strong> Domínio adicionado com sucesso</code>
	</div>';
} else {
	echo '<div class="alert alert-danger background-danger">
	<strong>Erro!</strong> Erro ao adicionar domínio (Erro '.$answer.').</code>
	</div>';
}
#endregion
#region Adiciona log na DB
addlog('Trocou o domínio do hotel.');
#endregion
}
}

$infoserver = $PDO->prepare("SELECT * FROM servidores WHERE nomeusuario = '".$_SESSION['nomeusuario']."'");
$infoserver->execute();
$server = $infoserver->fetch();

?>
<strong>Nameserver 1:</strong> ns1.galaxyservers.com.br
<br>
<strong>Nameserver 2:</strong> ns2.galaxyservers.com.br
<br><br>
Você pode usar o subdomínio ".galaxyservers.com.br", ou usar um domínio próprio caso esteja apontado para o nosso servidor!
<br><strong>Lembre-se, após o registro do domínio, o mesmo não pode ser editado, só comprando outro!</strong>
<br><b>Atenção: para você colocar um domínio no hotel, o mesmo deve ser previamente registrado, domínios são pagos, caso você queira por um gratuito clique <a href="https://cliente.galaxyservers.com.br/index.php?rp=/knowledgebase/4/Adicionando-um-dominio-gratis-ao-seu-hotel.html" target="_blank">aqui</a>.</b>
<br>
<br>
<div class="row">
	<label class="col-sm-4 col-lg-2 col-form-label">Domínio</label>
	<div class="col-sm-8 col-lg-10">
		<div class="input-group">		
			<input type="text" value="<?php echo $server['linkhotel'];?>" name="dominio" class="form-control" placeholder="Link sem http. ex: galaxyservers.com.br" required>
		</div>
	</div>
</div>
</div>
<center><button type="submit" style="border-radius: 8px;" name="salvar-config" class="btn btn-primary m-b-0">Salvar</button></center>
</form>
</div>
</div><?php }?>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<script type="text/javascript" src="../../galaxyservers/bower_components/jquery/js/jquery.min.js"></script>
<script type="text/javascript" src="../../galaxyservers/bower_components/jquery-ui/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="../../galaxyservers/bower_components/popper.js/js/popper.min.js"></script>
<script type="text/javascript" src="../../galaxyservers/bower_components/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../../galaxyservers/bower_components/jquery-slimscroll/js/jquery.slimscroll.js"></script>
<script type="text/javascript" src="../../galaxyservers/bower_components/modernizr/js/modernizr.js"></script>
<script type="text/javascript" src="../../galaxyservers/bower_components/modernizr/js/css-scrollbars.js"></script>
<script src="../../galaxyservers/assets/pages/jquery.filer/js/jquery.filer.min.js"></script>
<script src="../../galaxyservers/assets/pages/filer/custom-filer.js" type="text/javascript"></script>
<script src="../../galaxyservers/assets/pages/filer/jquery.fileuploads.init.js?a=a" type="text/javascript"></script>
<script type="text/javascript" src="../../galaxyservers/bower_components/i18next/js/i18next.min.js"></script>
<script type="text/javascript" src="../../galaxyservers/bower_components/i18next-xhr-backend/js/i18nextXHRBackend.min.js"></script>
<script type="text/javascript" src="../../galaxyservers/bower_components/i18next-browser-languagedetector/js/i18nextBrowserLanguageDetector.min.js"></script>
<script type="text/javascript" src="../../galaxyservers/bower_components/jquery-i18next/js/jquery-i18next.min.js"></script>
<script src="../../galaxyservers/assets/js/pcoded.min.js"></script>
<script src="../../galaxyservers/assets/js/demo-12.js"></script>
<script src="../../galaxyservers/assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script type="text/javascript" src="../../galaxyservers/assets/js/script.js"></script>
</body>
</html><?php } else header('Location: ../index'); ?>