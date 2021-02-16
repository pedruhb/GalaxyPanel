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
							<div class="card-header">
								<h5>Monetização de acordo com o rank</h5>
								<span>Altere o que o usuário irá receber em créditos de acordo com o rank.</span>
							</div>
							<div class="card-block">
								<?php
								if(!permissao("monetizacao")){
									echo '<div style="display: contents;">
									<div class="col-md-12">
									<center><div class="alert alert-danger background-danger" style="width: 30%;">
									<strong>Erro!</strong> Sua subconta não tem permissão para acessar essa página.
									</div></center>
									</div>
									</div>';
								} else {
									?>
									<form method="post">
										<?php
										$tipo = $_GET['tipo'];
										$rank = $_GET['rank'];

										if($tipo != "tempo" && $tipo != "diario" && $tipo != "eventos"){
											echo '<meta http-equiv="refresh" content=0;url="/index">';
											return;
										}

										try {
											$PDO2 = new PDO('mysql:host='.$iphospedagem.';dbname='.$server['uservestacp']."_hotel".";charset=utf8", $server['uservestacp']."_hotel", $server['senhavestacp']);
											$PDO2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
										} catch(PDOException $e) {
											echo '<script>alert("Erro de conexão ao hotel: ' . utf8_encode($e->getMessage()).'");</script>';
											die();
										}

										if(isset($_POST['salvar'])){

											$moedas = $_POST['moedas'];
											$duckets = $_POST['duckets'];
											$diamantes = $_POST['diamantes'];
											$gotw = $_POST['gotw'];


											$postarNoticia = $PDO2->prepare("UPDATE `ranks` SET `moedas_".$tipo."`= :moedas, `duckets_".$tipo."`= :duckets, `diamantes_".$tipo."`= :diamantes, `gotw_".$tipo."`= :gotw WHERE `id`= :id;");
											$postarNoticia->bindParam(':moedas', $moedas);
											$postarNoticia->bindParam(':duckets', $duckets);
											$postarNoticia->bindParam(':diamantes', $diamantes);
											$postarNoticia->bindParam(':gotw', $gotw);
											$postarNoticia->bindParam(':id', $rank);
											$postarNoticia->execute();

											addlog("Editou a monetização de ".$tipo." do rank ".$rank.".");

											echo '<div class="alert alert-success background-success">
											<strong>Sucesso!</strong> Monetização editada com sucesso.
											</div>';

										}

										$postarNoticia = $PDO2->prepare("SELECT * FROM ranks WHERE id = :codigo");
										$postarNoticia->bindParam(':codigo', $rank);
										$postarNoticia->execute();
										$noticia = $postarNoticia->fetch();
										?>
										<div class="form-group row">
											<label for="example-text-input" class="col-sm-2 col-form-label">Moedas</label>
											<div class="col-sm-10">
												<input class="form-control" type="number" placeholder="Valor que será pago." value="<?= $noticia['moedas_'.$tipo];?>" id="example-text-input" name="moedas" required>
											</div>
										</div>


										<div class="form-group row">
											<label for="example-text-input" class="col-sm-2 col-form-label">Duckets</label>
											<div class="col-sm-10">
												<input class="form-control" type="number" placeholder="Valor que será pago." value="<?= $noticia['duckets_'.$tipo];?>" id="example-text-input" name="duckets" required>
											</div>
										</div>

										<div class="form-group row">
											<label for="example-text-input" class="col-sm-2 col-form-label">Diamantes</label>
											<div class="col-sm-10">
												<input class="form-control" type="number" placeholder="Valor que será pago." value="<?= $noticia['diamantes_'.$tipo];?>" id="example-text-input" name="diamantes" required>
											</div>
										</div>

										<div class="form-group row">
											<label for="example-text-input" class="col-sm-2 col-form-label">GOTW</label>
											<div class="col-sm-10">
												<input class="form-control" type="number" placeholder="Valor que será pago." value="<?= $noticia['gotw_'.$tipo];?>" id="example-text-input" name="gotw" required>
											</div>
										</div>

										<br>
										<center><button type="submit" class="btn btn-primary waves-effect waves-light" name="salvar">Salvar alterações</button></center>
									</form>									
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
<script type="text/javascript" src="/galaxyservers/bower_components/jquery/js/jquery.min.js"></script>
<script type="text/javascript" src="/galaxyservers/bower_components/jquery-ui/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="/galaxyservers/bower_components/popper.js/js/popper.min.js"></script>
<script type="text/javascript" src="/galaxyservers/bower_components/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/galaxyservers/bower_components/jquery-slimscroll/js/jquery.slimscroll.js"></script>
<script type="text/javascript" src="/galaxyservers/bower_components/modernizr/js/modernizr.js"></script>
<script type="text/javascript" src="/galaxyservers/bower_components/modernizr/js/css-scrollbars.js"></script>
<script src="/galaxyservers/assets/pages/jquery.filer/js/jquery.filer.min.js"></script>
<script src="/galaxyservers/assets/pages/filer/custom-filer.js" type="text/javascript"></script>
<script src="/galaxyservers/assets/pages/filer/jquery.fileuploads.init.js?a=a" type="text/javascript"></script>
<script type="text/javascript" src="/galaxyservers/bower_components/i18next/js/i18next.min.js"></script>
<script type="text/javascript" src="/galaxyservers/bower_components/i18next-xhr-backend/js/i18nextXHRBackend.min.js"></script>
<script type="text/javascript" src="/galaxyservers/bower_components/i18next-browser-languagedetector/js/i18nextBrowserLanguageDetector.min.js"></script>
<script type="text/javascript" src="/galaxyservers/bower_components/jquery-i18next/js/jquery-i18next.min.js"></script>
<script src="/galaxyservers/assets/js/pcoded.min.js"></script>
<script src="/galaxyservers/assets/js/demo-12.js"></script>
<script src="/galaxyservers/assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script type="text/javascript" src="/galaxyservers/assets/js/script.js"></script>

<script src="/galaxyservers/bower_components/datatables.net/js/jquery.dataTables.min.js?"></script>
<script src="/galaxyservers/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="/galaxyservers/assets/pages/data-table/js/jszip.min.js"></script>
<script src="/galaxyservers/assets/pages/data-table/js/pdfmake.min.js"></script>
<script src="/galaxyservers/assets/pages/data-table/js/vfs_fonts.js"></script>
<script src="/galaxyservers/assets/pages/data-table/extensions/autofill/js/dataTables.select.min.js"></script>
<script src="/galaxyservers/bower_components/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="/galaxyservers/bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="/galaxyservers/bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/galaxyservers/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="/galaxyservers/bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<script src="/galaxyservers/assets/pages/data-table/extensions/autofill/js/extensions-custom.js"></script>

</body>
</html><?php } else header('Location: ../index'); ?>