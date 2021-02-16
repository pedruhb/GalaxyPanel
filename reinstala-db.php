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
												<h5 class="card-header-text">Reinstalar banco de dados</h5>
												<span>Reinstalar seu banco de dados fará você perder todo o progresso do hotel, incluindo usuários, quartos e items.</span>
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
														
														if (isset($_POST['reinstalar']))
														{
															if($status == "ligado"){															
																echo '<div class="alert alert-danger background-danger">
																<strong>Erro!</strong> Desligue o emulador para reinstalar o banco de dados.
																</div>';
															} else {
																

																if($_POST['senha'] != $server['senhavestacp']){
																	echo '<div class="alert alert-danger background-danger">
																	<strong>Erro!</strong> sua senha está inválida.
																	</div>';
																}
																else {
																	/// Abre uma conexão MYSQL
																	$PDO2 = new PDO('mysql:host='.$iphospedagem.';dbname='.$server['uservestacp']."_hotel", $server['uservestacp']."_hotel", $server['senhavestacp']);

																	/// Exclui todas as tabelas do banco de dados 
																	$selecionatabelas = $PDO2->prepare("SELECT concat('DROP TABLE IF EXISTS ', table_name, ';') as tabelas FROM information_schema.tables WHERE table_schema = '".$server['uservestacp']."_hotel"."';");
																	$selecionatabelas->execute();
																	while($sqlexcluir = $selecionatabelas->fetch()){
																		$excluitabelas = $PDO2->prepare($sqlexcluir[0]);
																		$excluitabelas->execute();
																	}

																	/// Importa .SQL para o banco de dados
																	$importa = $PDO2->prepare(file_get_contents("galaxyservers/emuladores/database_gservers.sql"));
																	$importa->execute();


																	$infoserver2 = $PDO2->prepare("UPDATE `server_status` SET `status`='0'");
																	$infoserver2->execute();

																	echo '<div class="alert alert-success background-success">
																	<strong>Sucesso!</strong> Banco de dados reinstalado.
																	</div>';

																	addlog('Reinstalou o banco de dados.');
																}
															}
														}
														?>
														<center>
															<form method="POST">

																<div class="row">
																	<label class="col-sm-4 col-lg-2 col-form-label">Confirme sua senha</label>
																	<div class="col-sm-8 col-lg-10">
																		<div class="input-group">
																			<input type="password" name="senha" class="form-control" placeholder="Confirme a sua senha para realizar a reinstalação." required>
																		</div>
																	</div>
																</div>


																<button type="submit" name="reinstalar" style="border-radius: 8px;" class="btn btn-primary btn-square" onclick="return confirm('Tem certeza que deseja reinstalar o banco de dados? você irá perder todo o progresso do hotel, incluindo usuários, quartos e items!')">Reinstalar</button>
															</form>
														</center>
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