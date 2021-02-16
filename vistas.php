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
												<h5 class="card-header-text">Trocar vista</h5>
												<span>Selecione uma vista.</span>
											</div>
											<div class="card-block">
												<div>

													<?php
													if(!permissao("vistas")){
														echo '<div style="display: contents;">
														<div class="col-md-12">
														<center><div class="alert alert-danger background-danger" style="width: 30%;">
														<strong>Erro!</strong> Sua subconta não tem permissão para acessar essa página.
														</div></center>
														</div>
														</div>';
													} else {


														if(isset($_POST['redefinir'])){

															$getArtdicles = $PDO->prepare("UPDATE servidores SET vistaclient = 'padrao' WHERE id = ".$server['id']);
															$getArtdicles->execute();

															echo '<div class="alert alert-success background-success">
															<strong>Sucesso!</strong> Vista redefinida!
															</div>';
														}


														if(isset($_POST['aplicar'])){
															$vista = "vista:".$_POST['vista'];
															$getArtdicles = $PDO->prepare("UPDATE servidores SET vistaclient = :vista WHERE id = ".$server['id']);
															$getArtdicles->bindParam(":vista", $vista);
															$getArtdicles->execute();
															echo '<div class="alert alert-success background-success">
															<strong>Sucesso!</strong> Vista aplicada!
															</div>';
														}
														?>
														<center>
															<div class="well well-lg" style="padding: 5px;">
																<center>
																	<iframe id="vista_preview" src="" width="100%" height="475" frameborder="0">Browser not compatible.</iframe>
																</center>
															</div>
															<form method="POST">
																<center>
																	<select class="form-control" id="vista" name="vista" style="width: 18%" onchange="alteraDivR()">
																		<?php
																		$getArtdicles = $PDO->prepare("SELECT id,timestamp,nome FROM vista_padrao ORDER BY timestamp DESC");
																		$getArtdicles->execute();
																		while($dnews = $getArtdicles->fetch())
																		{
																			if(empty($dnews['nome']))
																				$nomevista = 'Vista do dia '.date('d/m/y', $dnews['timestamp']);
																			else
																				$nomevista = utf8_encode($dnews['nome']);

																			echo '<option value="'.$dnews['id'].'">'.$nomevista.'</option>';
																		} 
																		?>
																	</select>
																	<br>
																	<button style="border-radius: 8px;" type="submit" name="aplicar" class="btn btn-primary btn-square">Aplicar vista</button>
																	<button style="border-radius: 8px;" type="submit" name="redefinir" class="btn btn-primary btn-square">Redefinir</button>
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
			var e = document.getElementById("vista");
			var e2 = document.getElementById("vista_preview");
			e2.src = "/visuvista.php?id="+e.value;
		}
		window.onload = function(){ alteraDivR(); }
	</script>
</body>
</html><?php } else header('Location: ../index'); ?>