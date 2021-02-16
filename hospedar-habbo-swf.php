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
	if($planoi['editar_swf'] == "false"){
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
							<div class="card-header">
								<h5 class="card-header-text">Hospedar Habbo.swf</h5>
								<span>O arquivo hospedado será substituído no servidor, sempre use o arquivo original como base em suas edições para evitar problemas! (tamanho máx 10mb)</span>
							</div>
							<div class="card-block">
								<div>
									<?php
									if(!permissao("hospswf")){
										echo '<div style="display: contents;">
										<div class="col-md-12">
										<center><div class="alert alert-danger background-danger" style="width: 30%;">
										<strong>Erro!</strong> Sua subconta não tem permissão para acessar essa página.
										</div></center>
										</div>
										</div>';
									} else {

										if (isset($_POST['hospedar']))
										{
											$extensoes_autorizadas = array( '.swf','.SWF', );
											$arquivo = $_FILES['arquivo'];
											$nome_arquivo = $arquivo['name'];
											$tamanho_arquivo = $arquivo['size'];
											$arquivo_temp = $arquivo['tmp_name'];
											$extensao_arquivo = strrchr($nome_arquivo,'.');

											if ( ! isset( $_FILES['arquivo'] ) ) {
												exit('<div class="alert alert-danger background-danger">
													<strong>Erro!</strong> Nenhum arquivo enviado
													</div>');
											}

											if (!empty( $extensoes_autorizadas ) && !in_array( $extensao_arquivo, $extensoes_autorizadas ) ) {
												echo '<div class="alert alert-danger background-danger">
												<strong>Erro!</strong> Você deve fazer o upload de um arquivo .swf
												</div>';
											} else {

												$servidor = $ipftpswf;
												$caminho_absoluto = $caminhoftpswf;
												$con_id = ftp_connect($servidor) or die( '<script>alert("Não conectou em: '.$servidor.'");</script>');
												ftp_login( $con_id, $userftpswf, $senhaftpswf );
												ftp_pasv($con_id, true) or die('<script>alert("Não foi possível entrar no modo passivo.")</script>'); 

												if (ftp_put($con_id, $caminho_absoluto.$server['uservestacp'].'.swf', $arquivo_temp, FTP_BINARY  ) ) 
												{
													echo '<div class="alert alert-success background-success">
													<button type="button" class="close" data-dismiss="alert" aria-label="Close">
													<i class="icofont icofont-close-line-circled text-white"></i>
													</button>
													<strong>Sucesso!</strong> Envio realizado, talvez demore para atualizar por causa da cache.
													</div>';
													addlog('Hospedou uma Habbo.swf');
												} else {
													echo '<div class="alert alert-danger background-danger">
													<button type="button" class="close" data-dismiss="alert" aria-label="Close">
													<i class="icofont icofont-close-line-circled text-white"></i>
													</button>
													<strong>Erro!</strong> Erro ao enviar.
													</div>';	
												}
											}
										}
										?>
										<center>
											<form method="POST" enctype="multipart/form-data">
												<div class="row">
													<div class="row" style="margin-left: 10px;">
														<label class="col-form-label" style="padding-left:15px">Habbo.swf</label>								
														<input type="file" name="arquivo" class="form-control" required="" style="margin-left: 15px;"> 
													</div>
												</div>
												<br><br>
												<button type="submit" style="border-radius: 8px;" name="hospedar" class="btn btn-primary btn-square">Hospedar</button>
											</form>
											<br>
											<form method="post">
												<a href="habboswf.php?hotel=<?= $server['uservestacp'];?>" target="_blank" class="btn btn-primary btn-square" style="border-radius: 8px;">Download</a>
											</form></center>
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