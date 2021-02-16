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
									<h4 class="sub-title">Editando a mensagem de bem vindo</h4>
									<form method="POST" enctype="multipart/form-data">	
										<?php
										
										if(!permissao("bemvindo")){
											echo '<div style="display: contents;">
											<div class="col-md-12">
											<center><div class="alert alert-danger background-danger" style="width: 30%;">
											<strong>Erro!</strong> Sua subconta não tem permissão para acessar essa página.
											</div></center>
											</div>
											</div>';
										} else {

											try {
												$PDO2 = new PDO('mysql:host='.$iphospedagem.';dbname='.$server['uservestacp']."_hotel", $server['uservestacp']."_hotel", $server['senhavestacp']);
												$PDO2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
											} catch(PDOException $e) {
												echo '<script>alert("Erro de conexão ao hotel: ' . utf8_encode($e->getMessage()).'");</script>';
											}	

											if(isset($_POST['remover']))
											{
												$att = $PDO2->prepare("UPDATE `server_locale` SET `value`= 'off' WHERE  `key`='user.login.message';");
												$att->execute();

												addlog('Removeu a mensagem de boas vindas.');

												sendRCONCommand2('reload_lang', '', $ipvps, $server['portamus']);
											}

											if(isset($_POST['salvar']))
											{
												$att = $PDO2->prepare("UPDATE `server_locale` SET `value`= :mensagem WHERE  `key`='user.login.message';");
												$att->bindParam(':mensagem', $_POST['mensagem']);
												$att->execute();

												addlog('Editou a mensagem de boas vindas.');

												sendRCONCommand2('reload_lang', '', $ipvps, $server['portamus']);

											}

											$PegaValue = $PDO2->prepare("SELECT `value` FROM `server_locale` WHERE  `key`='user.login.message';");
											$PegaValue->execute();
											$Value = $PegaValue->fetch();

											?>
											<div class="row">
												<label class="col-sm-4 col-lg-2 col-form-label">Mensagem</label>
												<div class="col-sm-8 col-lg-10">
													<div class="input-group">
														<textarea class="form-control" name="mensagem" style="height: 211px;"><?= $Value['value'];?></textarea>
													</div>
												</div>
											</div>
											<center>%username% - Nome de usuário | %hotelname% - Nome do hotel | %userson% - Usuários online</center>
										</div>
										<center><button type="submit" style="border-radius: 8px;" name="salvar" class="btn btn-primary m-b-0">Salvar</button>
										</center>
									</form>
									<br>
									<center><form method="post"><button type="submit" style="border-radius: 8px;" name="remover" class="btn btn-danger m-b-0">Remover</button></form></center>
								</div>
							<?php }?>
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