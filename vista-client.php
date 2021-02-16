<?php
include "galaxyservers/global.php";
if(!empty($_SESSION['nomeusuario'])){

	$infoserver = $PDO->prepare("SELECT * FROM servidores WHERE nomeusuario = '".$_SESSION['nomeusuario']."'");
	$infoserver->execute();
	$server = $infoserver->fetch();
	$_SESSION['senhaatualdb'] = $server['senhavestacp'];

	?>
	<?php 
	include 'galaxyservers/nav.php';
	if($planoi['editar_vista_client'] == "false"){
		if (headers_sent()) {
			die("<script>window.location.href=/index</script>");
		}
		else{
			exit(header("Location: /index"));
		}
		return;
	}
	?>
	<div class="pcoded-content">
		<div class="pcoded-inner-content">
			<div class="main-body user-profile">
				<div class="page-wrapper">
					<div class="page-body">
						<div class="card">
							<div class="card-block">
								<div class="m-b-20">
									<h4 class="sub-title">Hospedar fundo client</h4>
									<?php
										if(!permissao("hospvista")){
									echo '<div style="display: contents;">
									<div class="col-md-12">
									<center><div class="alert alert-danger background-danger" style="width: 30%;">
									<strong>Erro!</strong> Sua subconta não tem permissão para acessar essa página.
									</div></center>
									</div>
									</div>';
								} else {

									if(isset($_POST['resetar'])){
										$AttVista = $PDO->prepare("UPDATE servidores SET vistaclient = 'padrao' WHERE uservestacp = '".$server['uservestacp']."'");
										$AttVista->execute();
										echo '<div class="alert alert-success background-success"><strong>Sucesso!</strong> Fundo resetado! reentre no hotel.</div>';
										
										addlog('Resetou a vista do hotel.');


									}

									if(isset($_POST['hospedar'])){

										$nomeimagens = $server['nomeusuario'].time();

		### Informações da API
		$linkapi = $linkswf_api."/c_images/reception/upload.php"; /// Link da API

		### Declaração de variáveis
		$filenamebackground_gradient = $_FILES['background_gradient']['name'];
		$filedatabackground_gradient = $_FILES['background_gradient']['tmp_name'];
		$filesizebackground_gradient = $_FILES['background_gradient']['size'];
		$extensao_arquivobackground_gradient = str_replace('.', "", strrchr($filenamebackground_gradient,'.'));

		$filenamebackground_hotel_top = $_FILES['background_hotel_top']['name'];
		$filedatabackground_hotel_top = $_FILES['background_hotel_top']['tmp_name'];
		$filesizebackground_hotel_top = $_FILES['background_hotel_top']['size'];
		$extensao_arquivobackground_hotel_top = str_replace('.', "", strrchr($filenamebackground_hotel_top,'.'));

		$filenamebackground_left = $_FILES['background_left']['name'];
		$filedatabackground_left = $_FILES['background_left']['tmp_name'];
		$filesizebackground_left = $_FILES['background_left']['size'];
		$extensao_arquivobackground_left = str_replace('.', "", strrchr($filenamebackground_left,'.'));

		$filenamebackground_right = $_FILES['background_right']['name'];
		$filedatabackground_right = $_FILES['background_right']['tmp_name'];
		$filesizebackground_right = $_FILES['background_right']['size'];
		$extensao_arquivobackground_right = str_replace('.', "", strrchr($filenamebackground_right,'.'));

		### Faz o curl e envia a ads para o servidor
		$cfilebackground_gradient = curl_file_create($filedatabackground_gradient, 'image/'.$extensao_arquivobackground_gradient, $filenamebackground_gradient);

		$cfilebackground_hotel_top = curl_file_create($filedatabackground_hotel_top, 'image/'.$extensao_arquivobackground_hotel_top, $filenamebackground_hotel_top);

		$cfilebackground_left = curl_file_create($filedatabackground_left, 'image/'.$extensao_arquivobackground_left, $filenamebackground_left);

		$cfilebackground_right = curl_file_create($filedatabackground_right, 'image/'.$extensao_arquivobackground_right, $filenamebackground_right);

		$headers = array("Content-Type:multipart/form-data");
		$postfields = array("arquivobackground_gradient" => $cfilebackground_gradient, "nomebackground_gradient" => $filenamebackground_gradient, "arquivobackground_hotel_top" => $cfilebackground_hotel_top, "nomebackground_hotel_top" => $filenamebackground_hotel_top , "arquivobackground_left" => $cfilebackground_left, "nomebackground_left" => $filenamebackground_left, "arquivobackground_right" => $cfilebackground_right, "nomebackground_right" => $filenamebackground_right, "nomeimagens" => $nomeimagens);
		$ch = curl_init();
		$options = array(
			CURLOPT_URL => $linkapi,
			CURLOPT_HEADER => false,
			CURLOPT_POST => 1,
			CURLOPT_HTTPHEADER => $headers,
			CURLOPT_POSTFIELDS => $postfields,
			CURLOPT_INFILESIZE => $filesizebackground_gradient,
			CURLOPT_RETURNTRANSFER => true
		);
		curl_setopt_array($ch, $options);
		$saida = curl_exec($ch);
		echo '<div class="alert alert-success background-success">'.$saida.'</div>';
		curl_close($ch);

		$AttVista = $PDO->prepare("UPDATE servidores SET vistaclient = :vista WHERE uservestacp = '".$server['uservestacp']."'");
		$AttVista->bindParam(':vista', $nomeimagens);
		$AttVista->execute();

		addlog('Hospedou uma vista personalizada.');

	}
	?> 
	<form method="post" enctype="multipart/form-data">
		<div class="row">
			<div class="row" style="margin-left: 10px;">
				<label class="col-sm-4 col-lg-5 col-form-label"><a href="http://swf.galaxyservers.com.br/c_images/reception/summer18_background_gradient.png" target="_blank">background_gradient</a></label>									
				<input type="file" name="background_gradient" class="form-control" required="" style="margin-left: 15px;"> 
			</div>
		</div>
		<br><br>
		<div class="row">
			<div class="row" style="margin-left: 10px;">
				<label class="col-sm-4 col-lg-5 col-form-label"><a href="http://swf.galaxyservers.com.br/c_images/reception/summer18_background_hotel_top.png" target="_blank">background_hotel_top</a></label>									
				<input type="file" name="background_hotel_top" class="form-control" required="" style="margin-left: 15px;"> 
			</div>
		</div>
		<br><br>
		<div class="row">
			<div class="row" style="margin-left: 10px;">
				<label class="col-sm-4 col-lg-5 col-form-label"><a href="http://swf.galaxyservers.com.br/c_images/reception/summer2018_background_left.png" target="_blank">background_left</a></label>									
				<input type="file" name="background_left" class="form-control" required="" style="margin-left: 15px;"> 
			</div>
		</div>
		<br><br>
		<div class="row">
			<div class="row" style="margin-left: 10px;">
				<label class="col-sm-4 col-lg-5 col-form-label"><a href="http://swf.galaxyservers.com.br/c_images/reception/background_right_easter2016.png" target="_blank">background_right</a></label>									
				<input type="file" name="background_right" class="form-control" required="" style="margin-left: 15px;"> 
			</div>
		</div>
		<br><br>
		<center><button type="submit" style="border-radius: 8px;" name="hospedar" class="btn btn-primary m-b-0">Hospedar Vista</button></center><br>
	</form>
	<form method="post">
		<center><button type="submit" style="border-radius: 8px;" name="resetar" class="btn btn-primary m-b-0">Resetar Vista</button></center>
	</form>
</form>
</div>
</div>
</div><?php  } ?>
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
<script src="galaxyservers/assets/pages/jquery.filer/js/jquery.filer2.min.js"></script>
<script src="galaxyservers/assets/pages/filer/custom-filer2.js" type="text/javascript"></script>
<script src="galaxyservers/assets/pages/filer/jquery.fileuploads2.init.js?a=a" type="text/javascript"></script>
<script type="text/javascript" src="galaxyservers/bower_components/i18next/js/i18next.min.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/i18next-xhr-backend/js/i18nextXHRBackend.min.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/i18next-browser-languagedetector/js/i18nextBrowserLanguageDetector.min.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/jquery-i18next/js/jquery-i18next.min.js"></script>
<script src="galaxyservers/assets/js/pcoded.min.js"></script>
<script src="galaxyservers/assets/js/demo-12.js"></script>
<script src="galaxyservers/assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script type="text/javascript" src="galaxyservers/assets/js/script.js"></script>
</body>
</html><?php } else header('Location: ../index'); ?>