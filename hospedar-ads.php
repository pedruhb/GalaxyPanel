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
									<h4 class="sub-title">Hospedar ADS</h4>
									<?php
									if(isset($_POST['hospedar'])){

										### Declaração de variáveis
										$filename = $_FILES['arquivo']['name'];
										$filedata = $_FILES['arquivo']['tmp_name'];
										$filesize = $_FILES['arquivo']['size'];
										$extensao_arquivo = strrchr($filename,'.');

										### Faz o curl e envia a ads para o servidor
										$cfile = curl_file_create($filedata, 'image/'.$extensao_arquivo, $filename);
										$headers = array("Content-Type:multipart/form-data");
										$postfields = array("file" => $cfile);
										$ch = curl_init();
										$options = array(
											CURLOPT_URL => "http://beeimg.com/api/upload/file/text/",
											CURLOPT_HEADER => false,
											CURLOPT_POST => 1,
											CURLOPT_HTTPHEADER => $headers,
											CURLOPT_POSTFIELDS => $postfields,
											CURLOPT_INFILESIZE => $filesize,
											CURLOPT_RETURNTRANSFER => true
										);
										curl_setopt_array($ch, $options);
										$saida = curl_exec($ch);
										echo '<div class="alert alert-success background-success">
										<strong>Successo!</strong> '.$saida.'
										</div>';
										curl_close($ch);
									}
									?> 
									<form method="post" enctype="multipart/form-data">
										<div class="row">
											<div class="row" style="
											margin-left: 10px;
											">
											<label class="col-sm-4 col-lg-5 col-form-label">Imagem</label>									
											<input type="file" name="arquivo" class="form-control" required="" style="
											margin-left: 15px;
											"> 

										</div>
									</div>
									<br><br>
									<center><button type="submit" style="border-radius: 8px;" name="hospedar" class="btn btn-primary m-b-0">Hospedar</button></center>
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