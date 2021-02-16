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
												<h5 class="card-header-text">Reinstalar CMS</h5>
												<span>Escolha a CMS que deseja instalar.</span>
											</div>
											<div class="card-block">
												<div>
									
<?php
								if(!permissao("recms")){
									echo '<div style="display: contents;">
									<div class="col-md-12">
									<center><div class="alert alert-danger background-danger" style="width: 30%;">
									<strong>Erro!</strong> Sua subconta não tem permissão para acessar essa página.
									</div></center>
									</div>
									</div>';
								} else {
							

									if (isset($_POST['reinstalar'])){

				$getCMS = $PDO->prepare("SELECT * FROM cms WHERE id = :id");
				$getCMS->bindParam(":id", $_POST['cms']);
				$getCMS->execute();
				$getCMS2= $getCMS->fetch();

if($server['plano'] < $getCMS2['plano_minimo']){
echo '<div class="alert alert-danger background-danger">
	<strong>Erro!</strong> Seu plano não tem essa cms.
	</div>';
}
					else	if($_POST['senha'] != $server['senhavestacp']){
																	echo '<div class="alert alert-danger background-danger">
																	<strong>Erro!</strong> sua senha está inválida.
																	</div>';
																} else			{
										$nomepasta = $getCMS2['pasta'];	
										error_reporting(0);
										set_time_limit(0); 	


if($planoi['compilar_swf'] == "true")
	$nomeswfarquivo = $server['uservestacp'].".swf?CameraFuncionando";
else 
	$nomeswfarquivo = "Habbo.swf?";

#### Configura a CMS
$arquivo_configuracao = '<?php
if(!defined("BRAIN_CMS")) 
{ 
	die("Você não pode acessar esse arquivo... Powered by GalaxyServers."); 
}

$db["host"] = "localhost";
$db["port"] = "3306";
$db["user"] = "'.$server['uservestacp']."_hotel".'";  /// Usuário do banco de dados
$db["pass"] = "'.$server['senhavestacp'].'"; /// Senha do banco de dados
$db["db"] = "'.$server['uservestacp']."_hotel".'"; /// Nome do banco de dados

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
$config["badgeURL"] = "http://cdn.galaxyservers.com.br/emblema.php?cod="; 

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
$hotel["swfFolderSwf"] = "'.$server['http'].'://'.$linkswf.'/gordon/GALAXYSERVERS/'.$nomeswfarquivo.'";

$config["linklogo"] = "https://habbox.com/cache/scripts/fontgenerator/functions/events.php?font=HabNew&str='.$server['nomehotel'].'"; /// Link da logo do hotel

$config["facebookLogin"] = false; 
$config["facebookAPPID"] = "334162590sdaf292528";
$config["facebookAPPSecret"] = "ce2504ff5adsfa3ff7a6a2fa6d984cd8836";

/* Configurações do email para sistema de recuperar senha */
    /// Recomendamos o uso do smtp do gmail.
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
ftp_mkdir($con_id, '/web/'.$linkhotel.'/public_html');
ftp_mkdir($con_id, '/web/'.$linkhotel.'/public_html/system');
if (ftp_put( $con_id, '/web/'.$linkhotel.'/public_html/system/brain-config.php', 'galaxyservers/galaxycms/configcms.php', FTP_BINARY  ) ) {
	echo '<!--<div class="alert alert-success background-success">
	<strong>Sucesso!</strong> CMS configurada.
	</div>-->';
}
else {
	echo '<div class="alert alert-danger background-danger">
	<strong>Erro!</strong> Erro ao configurar cms.
	</div>';
} 
$fpc = fopen($nomearquivoc, "w");
$escreve = fwrite($fpc, "");
### FIM
ob_start(); 
$linkhotel = str_replace("http:", "", str_replace("https:", "", str_replace("/", "", $server['linkhotel'])));
$sourcedir= "galaxyservers/galaxycms/".$nomepasta."/"; //this is the folder that you want to upload with all subfolder and files of it.
$ftpserver=$iphospedagem; //ftp domain name
$ftpusername=$server['uservestacp'];  //ftp user name 
$ftppass=$server['senhavestacp']; //ftp passowrd
$ftpremotedir= '/web/'.$linkhotel.'/public_html'; //ftp main folder
$ftpconnect = ftp_connect($ftpserver); 
$ftplogin = ftp_login($ftpconnect, $ftpusername, $ftppass); 
ftp_pasv($ftpconnect, true) or die('<script>alert("Não foi possível alternar para o modo passivo")</script>'); 
if((!$ftpconnect) || (!$ftplogin))  
{ 
	die('<script>alert("Não foi conectar ao servidor ftp")</script>'); 
} 

function ftp_rdel ($handle, $path) {

	if (@ftp_delete ($handle, $path) === false) {

		if ($children = @ftp_nlist ($handle, $path)) {
			foreach ($children as $p)
				ftp_rdel ($handle,  $p);
		}

		@ftp_rmdir ($handle, $path);
	}
}
if (ftp_nlist($ftpconnect, './web/'.$linkhotel.'/public_html/templates/') == true) {
	ftp_rdel($ftpconnect, './web/'.$linkhotel.'/public_html/templates/');
}

if (ftp_nlist($ftpconnect, './web/'.$linkhotel.'/public_html/system/app/classes/') == true) {
	ftp_rdel($ftpconnect, './web/'.$linkhotel.'/public_html/system/app/classes/');
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
				ftp_mkdir($ftpconnect, $ftpreplacer); 
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
<strong>Sucesso!</strong> CMS reinstalada.
</div>';

addlog('Reinstalou a CMS.');
}
}
?>
<center>
	<div class="well well-lg" style="padding: 5px;">
		<center>
			<div id="imagem_cms" style="display:none">
				<img draggable="false" id="imagem1" width="310" style="border-radius: 5px;">
				<img draggable="false" id="imagem2" width="310" style="border-radius: 5px;">
				<img draggable="false" id="imagem3" width="310" style="border-radius: 5px;">
			</div>
		</center>
	</div>
	<form method="POST">
		<center>
			<select class="form-control" id="cms" name="cms" style="width: 18%" onchange="alteraDivR()">
				<?php
				$getArtdicles = $PDO->prepare("SELECT * FROM cms ORDER BY id DESC");
				$getArtdicles->execute();
				while($dnews = $getArtdicles->fetch())
				{
					if($server['plano'] >= $dnews['plano_minimo'])
						echo '<option value ="'.$dnews['id'].'">'.$dnews['nome'].'</option>';
					else
						echo '<option disabled>'.$dnews['nome'].' - Requer plano '.$dnews['plano_minimo'].'</option>';
				} 
				?>
			</select>
			<br>
								<div class="row">
																	<label class="col-sm-4 col-lg-2 col-form-label">Confirme sua senha</label>
																	<div class="col-sm-8 col-lg-10">
																		<div class="input-group">
																			<input type="password" name="senha" class="form-control" placeholder="Confirme a sua senha para realizar a reinstalação." required>
																		</div>
																	</div>
																</div>
			<button style="border-radius: 8px;" type="submit" name="reinstalar" class="btn btn-primary btn-square" onclick="return confirm('Tem certeza que deseja reinstalar a cms? você perderá todas as edições realizadas.')">Reinstalar</button>
		</form></center>
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
<script type="text/javascript">
	function alteraDivR(){
		var e = document.getElementById("cms");
		switch(e.value){
			<?php
			$getArtdicles = $PDO->prepare("SELECT print1,print2,print3,id FROM cms ORDER BY id");
			$getArtdicles->execute();
			while($dnews = $getArtdicles->fetch())
			{
				echo "case '".$dnews['id']."':";
				echo "\n";
				echo "$('#imagem1').attr('src', '".$dnews['print1']."');";
				echo "\n";
				echo "$('#imagem2').attr('src', '".$dnews['print2']."');";
				echo "\n";
				echo "$('#imagem3').attr('src', '".$dnews['print3']."');";
				echo "\n";
				echo "break;";
				echo "\n";
			} ?>
			default:
			console.log('Erro');
		}
		$("#imagem_cms").css("display", '');
	}
	window.onload = function(){ alteraDivR(); }
</script>
</body>
</html><?php } else header('Location: ../index'); ?>