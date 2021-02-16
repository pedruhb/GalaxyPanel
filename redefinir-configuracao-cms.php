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
						<div class="row">
							<div class="col-lg-12">
								<div class="tab-content">
									<div class="tab-pane active" role="tabpanel">
										<div class="card">
											<div class="card-header">
												<h5 class="card-header-text">Configurar CMS</h5>
												<span>Será enviado um arquivo de configuração já configurado, só use na cms padrão oferecida pela GalaxyServers.</span>
											</div>
											<div class="card-block">
												
												<div>

													<?php

													if(!permissao("configcms")){
														echo '<div style="display: contents;">
														<div class="col-md-12">
														<center><div class="alert alert-danger background-danger" style="width: 30%;">
														<strong>Erro!</strong> Sua subconta não tem permissão para acessar essa página.
														</div></center>
														</div>
														</div>';
													} else {

														if (isset($_POST['reinstalar']))
														{


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
$hotel["external_Texts"] = "'.$server['http'].'://'.$linkswf.'/gamedata/texts.php?user='.$server['uservestacp'].'";
$hotel["external_Texts_Override"] = "'.$server['http'].'://'.$linkswf.'/gamedata/override/override_texts.php?user='.$server['uservestacp'].'";
$hotel["productdata"] = "'.$server['http'].'://'.$linkswf.'/gamedata/productdata.txt";
$hotel["furnidata"] = "'.$server['http'].'://'.$linkswf.'/gamedata/furnidata.php?user='.$server['uservestacp'].'";
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

$config["discord"] = "0";

date_default_timezone_set("America/Sao_Paulo");
?>';
$nomearquivoc = "galaxyservers/galaxycms/configcms.php";
$fpc = fopen($nomearquivoc, "w");
$escreve = fwrite($fpc, $arquivo_configuracao);
$linkhotel = str_replace("http:", "", str_replace("https:", "", str_replace("/", "", $server['linkhotel'])));

$con_id = ftp_connect($iphospedagem) or die( '<div class="alert alert-danger">Não conectou em: '.$servidor.'</div>');
ftp_login( $con_id, $server['uservestacp'], $server['senhavestacp']);
ftp_pasv($con_id, true) or die('<script>alert("Cannot switch to passive mode")</script>'); 
if (ftp_put( $con_id, '/web/'.$linkhotel.'/public_html/system/brain-config.php', 'galaxyservers/galaxycms/configcms.php', FTP_BINARY  ) ) {
	echo '<div class="alert alert-success background-success">
	<strong>Sucesso!</strong> CMS configurada.
	</div>';
	addlog('Redefiniu as configurações da CMS.');
} else {
	echo '<div class="alert alert-danger background-danger">
	<strong>Erro!</strong> Erro ao configurar cms.
	</div>';	
}
$fpc = fopen($nomearquivoc, "w");
$escreve = fwrite($fpc, "");
														}
														?>
														<center><form method="POST">
<button type="submit" style="border-radius: 8px;" name="reinstalar" class="btn btn-primary btn-square">Configurar</button>
														</form></center>
													</div>
												</div>
											</div>
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
</div>
</div>
<script type="text/javascript" src="galaxyservers/bower_components/jquery/js/jquery.min.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/jquery-ui/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/popper.js/js/popper.min.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/jquery-slimscroll/js/jquery.slimscroll.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/modernizr/js/modernizr.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/modernizr/js/css-scrollbars.js"></script>
<script type="text/javascript" src="galaxyservers/assets/pages/advance-elements/moment-with-locales.min.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="galaxyservers/assets/pages/advance-elements/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/bootstrap-daterangepicker/js/daterangepicker.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/datedropper/js/datedropper.min.js"></script>
<script src="galaxyservers/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="galaxyservers/bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="galaxyservers/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="galaxyservers/bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<script src="galaxyservers/assets/pages/ckeditor/ckeditor.js"></script>
<script src="galaxyservers/assets/pages/chart/echarts/js/echarts-all.js" type="text/javascript"></script>
<script type="text/javascript" src="galaxyservers/bower_components/i18next/js/i18next.min.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/i18next-xhr-backend/js/i18nextXHRBackend.min.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/i18next-browser-languagedetector/js/i18nextBrowserLanguageDetector.min.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/jquery-i18next/js/jquery-i18next.min.js"></script>
<script src="galaxyservers/assets/pages/user-profile.js"></script>
<script src="galaxyservers/assets/js/pcoded.min.js"></script>
<script src="galaxyservers/assets/js/demo-12.js"></script>
<script src="galaxyservers/assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script type="text/javascript" src="galaxyservers/assets/js/script.js"></script>
</body>
</html><?php } else header('Location: ../index'); ?>