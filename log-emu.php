<?php
include "galaxyservers/global.php";
if(!empty($_SESSION['nomeusuario'])){
	$infoserver = $PDO->prepare("SELECT * FROM servidores WHERE nomeusuario = '".$_SESSION['nomeusuario']."'");
	$infoserver->execute();
	$server = $infoserver->fetch();
	$_SESSION['senhaatualdb'] = $server['senhavestacp'];

	$caminho = "./galaxyservers/emuladores/".$server['uservestacp']."/logs/Console.log";

	if(@$_GET['get'] == "a"){

		echo utf8_encode(file_get_contents($caminho));
		return;
	}

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

									<div class="card">
										<div class="card-block">
											<div class="m-b-20">
												<h4 class="sub-title">Gerencie seu emulador</h4>

												<?php
												
												if (isset($_POST['desligaremu']))
												{
													if(!permissao("emulador")){
														echo '<div style="display: contents;">
														<div class="col-md-12">
														<center><div class="alert alert-danger background-danger" style="width: 30%;">
														<strong>Erro!</strong> Sua subconta não tem permissão para realizar essa ação.
														</div></center>
														</div>
														</div>';
													} else {
														if($informacao['status'] == "0" && $server['estado'] == "desligado")
															echo '<div style="display: contents;">
														<div class="col-md-12">
														<center><div class="alert alert-danger background-danger" style="width: 30%;">
														<strong>Erro!</strong> O emulador não está ligado!
														</div></center>
														</div>
														</div>';
														else {
															if($server['estado'] == "atualizando"){
																echo '<div style="display: contents;">
																<div class="col-md-12">
																<center><div class="alert alert-danger background-danger" style="width: 30%;">
																<strong>Erro!</strong> O emulador está sendo atualizado!
																</div></center>
																</div>
																</div>';	
															} else {
																RconEmuLDR('desligaremulador', '', $ipvps, $server['portamus']);

																$atualizastatus = $PDO->prepare("UPDATE servidores SET estado = 'desligado' WHERE portamus = '".$server['portamus']."'");
																$atualizastatus->execute();

																addlog('Desligou o emulador.');
															}
														}
													}
												}

												if (isset($_POST['reiniciaremu']))
												{
													if(!permissao("emulador")){
														echo '<div style="display: contents;">
														<div class="col-md-12">
														<center><div class="alert alert-danger background-danger" style="width: 30%;">
														<strong>Erro!</strong> Sua subconta não tem permissão para realizar essa ação.
														</div></center>
														</div>
														</div>';
													} else {

														if($server['estado'] == "atualizando"){
															echo '<div style="display: contents;">
															<div class="col-md-12">
															<center><div class="alert alert-danger background-danger" style="width: 30%;">
															<strong>Erro!</strong> O emulador está sendo atualizado!
															</div></center>
															</div>
															</div>';	
														} else {


															if($informacao['status'] == "0" && $server['estado'] == "desligado")
																echo '<div style="display: contents;">
															<div class="col-md-12">
															<center><div class="alert alert-danger background-danger" style="width: 30%;">
															<strong>Erro!</strong> O emulador não está ligado!
															</div></center>
															</div>
															</div>';
															else {
																RconEmuLDR('reiniciaremulador', '', $ipvps, $server['portamus']);

																addlog('Reiniciou o emulador.');
															}
														}
													}
												}

												if (isset($_POST['ligaremu']))
												{
													if(!permissao("emulador")){
														echo '<div style="display: contents;">
														<div class="col-md-12">
														<center><div class="alert alert-danger background-danger" style="width: 30%;">
														<strong>Erro!</strong> Sua subconta não tem permissão para realizar essa ação.
														</div></center>
														</div>
														</div>';
													} else {
														if($informacao['status'] == "2" && $server['estado'] == "ligado")
															echo '<div style="display: contents;">
														<div class="col-md-12">
														<center><div class="alert alert-danger background-danger" style="width: 30%;">
														<strong>Erro!</strong> O emulador já está ligado!
														</div></center>
														</div>
														</div>';															
														else {

															if($server['estado'] == "atualizando"){
																echo '<div style="display: contents;">
																<div class="col-md-12">
																<center><div class="alert alert-danger background-danger" style="width: 30%;">
																<strong>Erro!</strong> O emulador está sendo atualizado!
																</div></center>
																</div>
																</div>';	
															} else {

																popen("C:/xampp/htdocs/galaxyservers/emuladores/".$server['uservestacp']."/galaxyserverligar.bat", "r");

																$atualizastatus = $PDO->prepare("UPDATE servidores SET estado = 'ligado' WHERE portamus = ".$server['portamus']);
																$atualizastatus->execute();

																addlog('Ligou o emulador.');

																echo '<div style="display: contents;">
																<div class="col-md-12">
																<center><div class="alert alert-success background-success" style="width: 50%;">
																<strong>Successo!</strong> Comando executado com êxito!
																</div></center>
																</div>
																</div>';
															}
														}
													}
												}
												if (isset($_POST['manutencao']))
												{		
													if(!permissao("emulador")){
														echo '<div style="display: contents;">
														<div class="col-md-12">
														<center><div class="alert alert-danger background-danger" style="width: 30%;">
														<strong>Erro!</strong> Sua subconta não tem permissão para realizar essa ação.
														</div></center>
														</div>
														</div>';
													} else {

														$linkhotel = str_replace("http:", "", str_replace("https:", "", str_replace("/", "", $server['linkhotel'])));
														$con_id = ftp_connect($iphospedagem) or die( '<div class="alert alert-danger">Não conectou em: '.$servidor.'</div>');
														ftp_login( $con_id, $server['uservestacp'], $server['senhavestacp']);
														ftp_pasv($con_id, true) or die('<script>alert("Cannot switch to passive mode")</script>'); 
														$h = fopen('php://temp', 'r+');
														ftp_fget($con_id, $h, './web/'.$linkhotel.'/public_html/system/brain-config.php', FTP_BINARY, 0);
														$fstats = fstat($h);
														fseek($h, 0);
														$contentsclient = fread($h, $fstats['size']); 
														if(!empty($contentsclient)){
															$novaclient = $contentsclient;
															$nomearquivoc22 = "c:/xampp/htdocs/galaxyservers/galaxycms/configcms.php";
															$fpc22 = fopen($nomearquivoc22, "w");
															$escreve = fwrite($fpc22, $novaclient);
															$patternverifica = 'config["maintenance"] = true';
															if (strpos($novaclient, $patternverifica)){
																$nomearquivoc22 = "c:/xampp/htdocs/galaxyservers/galaxycms/configcms.php";
																$fpc22 = fopen($nomearquivoc22, "w");
																$escreve = fwrite($fpc22, str_replace('config["maintenance"] = true', 'config["maintenance"] = false', $novaclient));
																ftp_put( $con_id, './web/'.$linkhotel.'/public_html/system/brain-config.php', $nomearquivoc22, FTP_BINARY  );
																echo '<div class="col-md-12">
																<center><div class="alert alert-success background-success" style="width: 30%;">
																A manutenção foi desativada!
																</div></center>
																</div>';

																addlog('Desativou a manutenção.');

															} else {
																$nomearquivoc22 = "c:/xampp/htdocs/galaxyservers/galaxycms/configcms.php";
																$fpc22 = fopen($nomearquivoc22, "w");
																$escreve = fwrite($fpc22, str_replace('config["maintenance"] = false', 'config["maintenance"] = true', $novaclient));
																ftp_put( $con_id, './web/'.$linkhotel.'/public_html/system/brain-config.php', $nomearquivoc22, FTP_BINARY  );
																echo '<div class="col-md-12">
																<center><div class="alert alert-success background-success" style="width: 30%;">
																A manutenção foi ativada!
																</div></center>
																</div>';
																addlog('Ativou a manutenção.');
															}
														} else {
															echo '<div class="col-md-12">
															<center><div class="alert alert-danger background-danger" style="width: 30%;">
															Erro ao ativar a manutenção!
															</div></center>
															</div>';
														}
														$nomearquivoc22 = "c:/xampp/htdocs/galaxyservers/galaxycms/configcms.php";
														$fpc22 = fopen($nomearquivoc22, "w");
														$escreve = fwrite($fpc22, "");
													}
												}
												?>

												<?php if(permissao("emulador")){ ?>
													<form method="POST" style="display: contents;">
														<div class="col-md-12">
															<center>
																<button title="Ligar Emulador" name="ligaremu" style="border-radius: 8px;" data-type="inverse" data-align="right" data-from="top" class="btn btn-success"><i class="icofont icofont-ui-play"></i>Ligar Emulador</button>

																<button  title="Desligar Emulador" type="submit" style="border-radius: 8px;" name="desligaremu" data-type="inverse" data-align="right" data-from="top" class="btn btn-danger" ><i class="icofont icofont-ui-power"></i>Desligar Emulador</button>

																<button title="Reiniciar Emulador" name="reiniciaremu" style="border-radius: 8px;" data-type="inverse" data-align="right" data-from="top" class="btn btn-primary"><i class="icofont icofont-ui-rotation"></i>Reiniciar Emulador</button>

																<button title="Ativar/Desativar a manutenção" name="manutencao" style="background-color: #ffb64d; border-color: #ffb64d;border-radius: 8px;" data-type="inverse" data-align="right" data-from="top" class="btn btn-primary"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Manutenção</button>

															</div>
														</form>
													<?php }?>
												</div>
											</div>
										</center>
									</div>


									<div class="tab-pane active" role="tabpanel" style=" padding-left: 22%; ">
										<div class="col-xl-8"><div class="card">
											<div class="card-header">
												<?php
												if(!permissao("logemulador")){
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
														<div class="view-info">
															<div class="row">
																<div>
																	<textarea id="setTimea" style="margin-top: 0px;margin-bottom: 0px;height: 600px;width: 600%;border:  none; background-color: white" disabled><?= utf8_encode(file_get_contents($caminho));?></textarea>
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
</div>
</div>
<?php }?>
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
<script>
	$(function() {
		setTimea();
		function setTimea() {
			setTimeout(setTimea, 200);
			$('#setTimea').load("/log-emu.php?get=a");;
		}
	});
</script>
</body>
</html><?php } else header('Location: ../index'); ?>