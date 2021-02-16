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
												<h5 class="card-header-text">Gerenciar arquivos via FTP.</h5>
											</div>
											<div class="card-block">
												<div class="view-info">
													<div class="row">
														<?php
														if(isset($_SESSION['subconta'])){
															echo '<div style="display: contents;">
															<div class="col-md-12">
															<center><div class="alert alert-danger background-danger">
															<strong>Erro!</strong> Sua subconta não tem permissão para acessar essa página.
															</div></center>
															</div>
															</div>';
														} else { ?>
															<div style="margin-left: 2%">
																Host: <?php echo $ipftp;?><br>
																Porta: 21<br>
																Usuário: <?php echo $server['uservestacp'];?><br>
																Senha: a mesma do painel.<br><br>Para baixar o FileZilla clique <a href="https://filezilla-project.org/download.php" target="_blank">aqui.</a>
																<br>Para baixar o WinSCP clique <a href="https://winscp.net/eng/download.php" target="_blank">aqui.</a><br>
																Para aprender a usar o filezilla, clique <a href="https://faq.galaxyservers.com.br/2018/12/26/como-conectar-ao-filezilla/" target="_blank">aqui</a>
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