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
												<h5 class="card-header-text">Atualize seu emulador</h5>
												<span>Atualize o seu emulador clicando no botão abaixo.</span>
											</div>
											<div class="card-block">
												<div>
													<form method="POST">
														<?php 

														if(!permissao("attemu")){
															echo '<div style="display: contents;">
															<div class="col-md-12">
															<center><div class="alert alert-danger background-danger" style="width: 30%;">
															<strong>Erro!</strong> Sua subconta não tem permissão para acessar essa página.
															</div></center>
															</div>
															</div>';
														} else {


															if(isset($_POST['atualizar'])){


																if($server['uservestacp'] == "space")
																	echo '<div class="alert alert-danger background-danger">
																<strong>Erro!</strong> Você não pode atualizar o emulador.
																</div>';

																else if($informacao['status'] == "2" && $server['estado'] == "ligado")
																	echo '<div class="alert alert-danger background-danger">
																<strong>Erro!</strong> O emulador está ligado, desligue!
																</div>';	
																else{
																	$pasta = "galaxyservers/emuladores/sourcegalaxy"; 
																	$pastad = "galaxyservers/emuladores/".$server['uservestacp'];
																	if(!is_dir($pastad)){
																		mkdir($pastad,0777);
																		chmod($pastad,0777);
																	}
																	$aberta = opendir($pasta);
																	while($res=readdir($aberta)){
																		@copy($pasta."/".$res,$pastad. "/".$res);	
																	}

																	echo '<div class="alert alert-success background-success">
																	<strong>Sucesso!</strong> Emulador atualizado.
																	</div>'; 

																	$getversao = $PDO->prepare("UPDATE servidores SET versao_emu = :versao WHERE id = :id");
																	$getversao->bindValue(":versao", versaoemu());
																	$getversao->bindValue(":id", $server['id']);
																	$getversao->execute();

																	addlog('Atualizou o emulador.');
																}

															}
															?>
															<center>Alterações: <?php
															$getversao = $PDO->prepare("SELECT mensagem FROM emulador");
															$getversao->execute();
															echo $getversao->fetch()['mensagem'];
															?></center>
															<br><br>
															<center><button type="submit" style="border-radius: 8px;" name="atualizar" class="btn btn-primary btn-square">Atualizar</button></center>
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