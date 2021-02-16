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
												<span>Faça a configuração de sua CMS.</span>
											</div>
											<div class="card-block">
												<div>
													<form method="POST">
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


															if(isset($_POST['configurar'])){

### variables
$favicon = $_POST['favicon'];
$logo = $_POST['logo'];
$facebook = $_POST['facebook'];
$missao = $_POST['missao'];
$visual = $_POST['visual'];
$moedas_iniciais = $_POST['moedas_iniciais'];
$duckets_iniciais = $_POST['duckets_iniciais'];
$diamantes_iniciais = $_POST['diamantes_iniciais'];
$diamantes_ref = $_POST['diamantes_ref'];
$email_servidor = $_POST['email_servidor'];
$email_email = $_POST['email_email'];
$email_senha = $_POST['email_senha'];
$quartoinicial = $_POST['quartoinicial'];
$discord = $_POST['discord'];
$visuais = $_POST['visuais'];

if($visuais == "br"){
	$figuremap = "figuremap_br.xml";
	$figuredata = "figuredata_br.xml";
} else {
	$figuremap = "figuremap.xml";
	$figuredata = "figuredata.xml";
}


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
$config["favicon"] = "'.$favicon.'"; /// Link do favicon em PNG
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
$hotel["homeRoom"] = '.$quartoinicial.'; /// ID do quarto inicial (0 vai pro looby)
$hotel["external_Variables"] = "'.$server['http'].'://'.$linkswf.'/gamedata/variables.php?hotelurl='.$server['http'].'://'.str_replace("http://", "", str_replace("https://", "", $server['linkhotel'])).'";
$hotel["external_Variables_Override"] = "'.$server['http'].'://'.$linkswf.'/gamedata/override/external_override_variables.txt";
$hotel["external_Texts"] = "'.$server['http'].'://'.$linkswf.'/gamedata/texts.php?user='.$server['uservestacp'].'";
$hotel["external_Texts_Override"] = "'.$server['http'].'://'.$linkswf.'/gamedata/override/override_texts.php?user='.$server['uservestacp'].'";
$hotel["productdata"] = "'.$server['http'].'://'.$linkswf.'/gamedata/productdata.txt";
$hotel["furnidata"] = "'.$server['http'].'://'.$linkswf.'/gamedata/furnidata.php?user='.$server['uservestacp'].'";
$hotel["figuremap"] = "'.$server['http'].'://'.$linkswf.'/gamedata/'.$figuremap.'";
$hotel["figuredata"] = "'.$server['http'].'://'.$linkswf.'/gamedata/'.$figuredata.'";
$hotel["swfFolder"] = "'.$server['http'].'://'.$linkswf.'/gordon/GALAXYSERVERS";
$hotel["swfFolderSwf"] = "'.$server['http'].'://'.$linkswf.'/gordon/GALAXYSERVERS/'.$nomeswfarquivo.time().'";

$config["linklogo"] = "'.$logo.'"; /// Link da logo do hotel

$config["facebookLogin"] = false; 
$config["facebookAPPID"] = "334162590sdaf292528";
$config["facebookAPPSecret"] = "ce2504ff5adsfa3ff7a6a2fa6d984cd8836";

/* Configurações do email para sistema de recuperar senha */
$email["mailServerHost"] = "'.$email_servidor.'";
$email["mailServerPort"] = 587;
$email["SMTPSecure"] = "TLS";
$email["mailUsername"] = "'.$email_email.'";
$email["mailPassword"] = "'.$email_senha.'";
$email["mailLogo"] = "https://i.imgur.com/XbyUs4z.png";
$email["mailTemplate"] = "/system/app/plugins/PHPmailer/temp/resetpassword.html";

/* Redes Sociais */
$config["facebook"] = "'.$facebook.'"; // Link página do facebook
$config["facebookEnable"] = true; /// ativa/desativa facebook
$config["twitter"] = "https://twitter.com/Habbo";
$config["twitterEnable"] = false;

/* Registro*/
$config["startMotto"] = "'.$missao.'"; // Missão inicial
$config["startLook"] = "'.$visual.'"; // Visual inicial
$config["credits"] = "'.$moedas_iniciais.'";
$config["duckets"] = "'.$duckets_iniciais.'";
$config["diamonds"] = "'.$diamantes_iniciais.'";
$config["diamondsRef"] = "'.$diamantes_ref.'";
$config["registerEnable"] = true; // True ativa registro / false desativa

/* Google recaptcha */
$config["recaptchaSiteKey"] = "6LdzewwUAAAAABkJ3vsdfCDca9qmLGDaWAHqMRtFEs2";
$config["recaptchaSiteKeyEnable"] = false;

/* Buy VIP Settings */
$config["vipCost"] = "25";
$config["vipRankToGet"] = "3";
$config["vipBadge"] = "vip";

$config["discord"] = "'.$discord.'";

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

	addlog('Configurou a CMS.');

} else {
	echo '<div class="alert alert-danger background-danger">
	<strong>Erro!</strong> Erro ao configurar cms.
	</div>';	
}
$fpc = fopen($nomearquivoc, "w");
$escreve = fwrite($fpc, "");

															}

															$linkhotel = str_replace("http:", "", str_replace("https:", "", str_replace("/", "", $server['linkhotel'])));
															$con_id = ftp_connect($iphospedagem) or die( '<div class="alert alert-danger">Não conectou em: '.$servidor.'</div>');
															ftp_login( $con_id, $server['uservestacp'], $server['senhavestacp']);
															ftp_pasv($con_id, true) or die('<script>alert("Cannot switch to passive mode")</script>'); 
															$h = fopen('php://temp', 'r+');
															@ftp_fget($con_id, $h, './web/'.$linkhotel.'/public_html/system/brain-config.php', FTP_BINARY, 0);
															$fstats = fstat($h);
															fseek($h, 0);
															@$contentsclient = fread($h, $fstats['size']); 
															if(!empty($contentsclient)){
function pegaValor($variavel){
	global $contentsclient;														
	$var = explode('$config["'.$variavel.'"] = "', $contentsclient);
	@$var = explode('";', $var[1])[0];
	return $var;

}
function pegaValorEmail($variavel){
	global $contentsclient;
	$var = explode('$email["'.$variavel.'"] = "', $contentsclient);
	@$var = explode('";', $var[1])[0];
	return $var;
}
function pegaValorHotel($variavel){
	global $contentsclient;
	$var = explode('$hotel["'.$variavel.'"] = ', $contentsclient);
	@$var = explode(';', $var[1])[0];
	return $var;
}
function pegaValorHotel2($variavel){
	global $contentsclient;
	$var = explode('$hotel["'.$variavel.'"] = "', $contentsclient);
	@$var = explode('";', $var[1])[0];
	return $var;
}
															} else {
echo '<div class="alert alert-danger background-danger">
<strong>Erro!</strong> Verifique se o arquivo brain-config existe! Recomendamos redefinir os padrões.
</div>';	
															}

															?>

															<div class="row">
<label class="col-sm-4 col-lg-2 col-form-label">Link do favicon</label>
<div class="col-sm-8 col-lg-10">
	<div class="input-group">
		<input type="text" name="favicon" value="<?= pegaValor("favicon");?>" class="form-control" placeholder="Link direto para o favicon, recomendamos o imgur ou o GalaxyADS para hospedar." required>
	</div>
</div>
															</div>

															<div class="row">
<label class="col-sm-4 col-lg-2 col-form-label">Link da logo</label>
<div class="col-sm-8 col-lg-10">
	<div class="input-group">
		<input type="text" name="logo" value="<?= pegaValor("linklogo");?>" class="form-control" placeholder="Link direto para a logo, recomendamos o imgur ou o GalaxyADS para hospedar." required>
	</div>
</div>
															</div>

															<div class="row">
<label class="col-sm-4 col-lg-2 col-form-label">Página Facebook</label>
<div class="col-sm-8 col-lg-10">
	<div class="input-group">
		<input type="text" name="facebook" value="<?= pegaValor("facebook"); ?>" class="form-control" placeholder="Exemplo: https://www.facebook.com/GalaxyServersHosting/" required>
	</div>
</div>
															</div>


															<div class="row">
<label class="col-sm-4 col-lg-2 col-form-label">ID quarto inicial</label>
<div class="col-sm-8 col-lg-10">
	<div class="input-group">
		<input type="number" name="quartoinicial" value="<?= pegaValorHotel("homeRoom"); ?>" class="form-control" placeholder="Exemplo: 1" required>
	</div>
</div>
															</div>


															<div class="row">
<label class="col-sm-4 col-lg-2 col-form-label">Missão inicial</label>
<div class="col-sm-8 col-lg-10">
	<div class="input-group">
		<input type="text" name="missao" value="<?= pegaValor("startMotto"); ?>" class="form-control" placeholder="Exemplo: Sou novo no hotel!" required>
	</div>
</div>
															</div>

															<div class="row">
<label class="col-sm-4 col-lg-2 col-form-label">Visual Inicial</label>
<div class="col-sm-8 col-lg-10">
	<div class="input-group">
		<input type="text" name="visual" value="<?= pegaValor("startLook"); ?>" class="form-control" placeholder="Tome cuidado ao mexer aqui, se você colocar algo errado poderá causar alguns bugs." required>
	</div>
</div>
															</div>



															<div class="row">
<label class="col-sm-4 col-lg-2 col-form-label">Moedas iniciais</label>
<div class="col-sm-8 col-lg-10">
	<div class="input-group">
		<input type="text" name="moedas_iniciais" value="<?= pegaValor("credits"); ?>" class="form-control" placeholder="Exemplo: 10" max="99999" required>
	</div>
</div>
															</div>

															<div class="row">
<label class="col-sm-4 col-lg-2 col-form-label">Duckets iniciais</label>
<div class="col-sm-8 col-lg-10">
	<div class="input-group">
		<input type="text" name="duckets_iniciais" value="<?= pegaValor("duckets"); ?>" class="form-control" placeholder="Exemplo: 10" max="99999" required>
	</div>
</div>
															</div>

															<div class="row">
<label class="col-sm-4 col-lg-2 col-form-label">Diamantes iniciais</label>
<div class="col-sm-8 col-lg-10">
	<div class="input-group">
		<input type="text" name="diamantes_iniciais" value="<?= pegaValor("diamonds"); ?>" class="form-control" placeholder="Exemplo: 10" max="99999" required>
	</div>
</div>
															</div>

															<div class="row">
<label class="col-sm-4 col-lg-2 col-form-label">Diamantes referências</label>
<div class="col-sm-8 col-lg-10">
	<div class="input-group">
		<input type="text" name="diamantes_ref" value="<?= pegaValor("diamondsRef"); ?>" class="form-control" placeholder="Valor pago por referência, caso sua cms tenha suporte." max="1000" required>
	</div>
</div>
															</div>

															<div class="row">
<label class="col-sm-4 col-lg-2 col-form-label">Discord</label>
<div class="col-sm-8 col-lg-10">
	<div class="input-group">
		<input type="text" name="discord" value="<?= pegaValor("discord"); ?>" class="form-control" placeholder="Id do servidor do discord" max="1000" required>
	</div>
</div>
															</div>

															<div class="row">
<label class="col-sm-4 col-lg-2 col-form-label">Visuais</label>
<div class="col-sm-8 col-lg-10">
	<div class="input-group">
		<select name="visuais" class="form-control">
			<option <?php if(pegaValorHotel2("figuremap") == ($server['http'].'://'.$linkswf.'/gamedata/figuremap.xml'))echo'selected ';?> value="todos">Todos os visuais</option>
			<option <?php if(pegaValorHotel2("figuremap") == ($server['http'].'://'.$linkswf.'/gamedata/figuremap_br.xml'))echo'selected ';?> value="br">Somente os do Habbo BR</option>
		</select>
	</div>
</div>
															</div>

															<br>
															<div class="card">
<div class="card-header">
	<h5 class="card-header-text">Configurações de envio de email</h5>
	<span>É necessário realizar essa configuração para que o sistema possa enviar email de recuperação de senha em algumas cms disponíveis.</span>
</div>


<div class="row" style="margin-left: 0;">
	<label class="col-sm-4 col-lg-2 col-form-label">Servidor</label>
	<div class="col-sm-8 col-lg-3">
		<div class="input-group">
			<select name="email_servidor"  class="form-control">
				<option value="smtp.gmail.com">Gmail</option>
			</select>	
		</div>
	</div>
</div>

<div class="row" style="margin-left: 0;">
	<label class="col-sm-4 col-lg-2 col-form-label">Email</label>
	<div class="col-sm-8 col-lg-10">
		<div class="input-group">
			<input type="text" name="email_email" value="<?= pegaValorEmail("mailUsername"); ?>" class="form-control" placeholder="Exemplo: teste@gmail.com">
		</div>
	</div>
</div>

<div class="row" style="margin-left: 0;">
	<label class="col-sm-4 col-lg-2 col-form-label">Senha</label>
	<div class="col-sm-8 col-lg-10">
		<div class="input-group">
			<input type="text" name="email_senha" value="<?= pegaValorEmail("mailPassword"); ?>" class="form-control" placeholder="A mesma utilizada para login no Gmail.">
		</div>
	</div>
</div>
															</div>

															<center><button type="submit" style="border-radius: 8px;" name="configurar" class="btn btn-primary btn-square">Configurar</button><br>Caso queira redefinir as configurações, clique <a href="redefinir-configuracao-cms">aqui</a>.</center>
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