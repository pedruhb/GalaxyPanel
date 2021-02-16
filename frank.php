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
							<?php
							if(!permissao("frank")){
								echo '<div style="display: contents;">
								<div class="col-md-12">
								<center><div class="alert alert-danger background-danger" style="width: 30%;">
								<strong>Erro!</strong> Sua subconta não tem permissão para acessar essa página.
								</div></center>
								</div>
								</div>';
							} else {
								?>
								<div class="card-block">
									<div class="m-b-20">
										<?php
										try {
											$PDO2 = new PDO('mysql:host='.$iphospedagem.';dbname='.$server['uservestacp']."_hotel", $server['uservestacp']."_hotel", $server['senhavestacp']);
											$PDO2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
										} catch(PDOException $e) {
											echo '<script>alert("Erro de conexão ao hotel: ' . utf8_encode($e->getMessage()).'");</script>';
										}
										if(isset($_POST['salvar']))
										{

												$keycredits = $PDO2->prepare("UPDATE server_settings SET value = :value WHERE `key`='frank.give.credits';");
												$keycredits->bindValue(":value", $_POST['creditos']);
												$keycredits->execute();

												$keyduckets = $PDO2->prepare("UPDATE server_settings SET value = :value WHERE `key`='frank.give.duckets';");
												$keyduckets->bindValue(":value", $_POST['duckets']);
												$keyduckets->execute();

												$keydiamonds = $PDO2->prepare("UPDATE server_settings SET value = :value WHERE `key`='frank.give.diamonds';");
												$keydiamonds->bindValue(":value", $_POST['diamantes']);
												$keydiamonds->execute();

												$keygotw = $PDO2->prepare("UPDATE server_settings SET value = :value WHERE `key`='frank.give.gotws';");
												$keygotw->bindValue(":value", $_POST['gotw']);
												$keygotw->execute();

												$keyfurni = $PDO2->prepare("UPDATE server_settings SET value = :value WHERE `key`='frank.give.furni';");
												$keyfurni->bindValue(":value", $_POST['mobi']);
												$keyfurni->execute();


												addlog('Editou o frank.');

												$mensagem = '<div class="alert alert-success background-success">
												<strong>Successo!</strong> alterações salvas.
												</div>';
											
										}

										$keycredits = $PDO2->prepare("SELECT value FROM server_settings WHERE `key`='frank.give.credits';");
										$keycredits->execute();
										$credits = $keycredits->fetch();

										$keyduckets = $PDO2->prepare("SELECT value FROM server_settings WHERE `key`='frank.give.duckets';");
										$keyduckets->execute();
										$duckets = $keyduckets->fetch();

										$keydiamonds = $PDO2->prepare("SELECT value FROM server_settings WHERE `key`='frank.give.diamonds';");
										$keydiamonds->execute();
										$diamonds = $keydiamonds->fetch();

										$keygotw = $PDO2->prepare("SELECT value FROM server_settings WHERE `key`='frank.give.gotws';");
										$keygotw->execute();
										$gotw = $keygotw->fetch();									

										$keyfurni = $PDO2->prepare("SELECT value FROM server_settings WHERE `key`='frank.give.furni';");
										$keyfurni->execute();
										$furni = $keyfurni->fetch();

										?>
										<span>Editando o frank</span>
										<form method="POST">	
											<br>
											<?php
											if(isset($mensagem))
												echo $mensagem;
											?>
											<div class="row">
												<label class="col-sm-4 col-lg-2 col-form-label">Créditos</label>
												<div class="col-sm-8 col-lg-10">
													<div class="input-group">
														<input  name="creditos" value="<?php echo $credits['value'];?>" class="form-control">
													</div>
												</div>
											</div>
											<div class="row">
												<label class="col-sm-4 col-lg-2 col-form-label">Duckets</label>
												<div class="col-sm-8 col-lg-10">
													<div class="input-group">
														<input name="duckets" value="<?php echo $duckets['value'];?>" class="form-control">
													</div>
												</div>
											</div>
											<div class="row">
												<label class="col-sm-4 col-lg-2 col-form-label">Diamantes</label>
												<div class="col-sm-8 col-lg-10">
													<div class="input-group">
														<input name="diamantes" value="<?php echo $diamonds['value'];?>" class="form-control">
													</div>
												</div>
											</div>
											<div class="row">
												<label class="col-sm-4 col-lg-2 col-form-label">GOTW</label>
												<div class="col-sm-8 col-lg-10">
													<div class="input-group">
														<input name="gotw" value="<?php echo $gotw['value'];?>" class="form-control">
													</div>
												</div>
											</div>
											<div class="row">
												<label class="col-sm-4 col-lg-2 col-form-label">Mobi (ID)</label>
												<div class="col-sm-8 col-lg-10">
													<div class="input-group">
														<input  name="mobi" value="<?php echo $furni['value'];?>" class="form-control">
													</div>
												</div>
											</div>
										</div>
										<center><button type="submit" style="border-radius: 8px;" name="salvar" class="btn btn-primary m-b-0">Salvar</button></center>
									</form>
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