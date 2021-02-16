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
												<h5 class="card-header-text">Gerar logo</h5>
												<span>Gere uma logo para seu hotel aqui.</span>
											</div>
											<div class="card-block">
												<div>
													<?php
													set_time_limit(0);

													if(!permissao("configcms")){
														echo '<div style="display: contents;">
														<div class="col-md-12">
														<center><div class="alert alert-danger background-danger" style="width: 30%;">
														<strong>Erro!</strong> Sua subconta não tem permissão para acessar essa página.
														</div></center>
														</div>
														</div>';
													} else {

														if (isset($_POST['instalar']))
														{
															
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

																$nomearquivoc22 = "c:/xampp/htdocs/galaxyservers/galaxycms/configcms.php";
																$fpc22 = fopen($nomearquivoc22, "w");


																$novoll = '//logo antiga ';
																$novoll2 = "\n".'$config["linklogo"] = "'.$_POST['link_logo'].'";'."\n"."?>";


																$escreve = fwrite($fpc22, str_replace('?>', $novoll2, str_replace('$config["linklogo"]', $novoll, $novaclient)));
																ftp_put( $con_id, './web/'.$linkhotel.'/public_html/system/brain-config.php', $nomearquivoc22, FTP_BINARY  );
																echo '<div class="col-md-12">
																<center><div class="alert alert-success background-success" style="width: 30%;">
																A logo foi aplicada!
																</div></center>
																</div>';
																addlog('Aplicou uma nova logo.');
																
															} else {
																echo '<div class="col-md-12">
																<center><div class="alert alert-danger background-danger" style="width: 30%;">
																Erro ao aplicar a logo!
																</div></center>
																</div>';
															}
															$nomearquivoc22 = "c:/xampp/htdocs/galaxyservers/galaxycms/configcms.php";
															$fpc22 = fopen($nomearquivoc22, "w");
															$escreve = fwrite($fpc22, "");
														

													}
													?>
													<form method="POST">
														<center>
															<div id="scan_result"></div>
															<input type="hidden" name="link_logo" id="link">
															<br>
															<div class="row">
																<label class="col-sm-4 col-lg-2 col-form-label">Selecione o estilo</label>
																<div class="col-sm-8 col-lg-10">
																	<div class="input-group">
																		<select class="form-control" id="logo" style="width: 18%" onchange="fontName()">
																			<option value="habbo_new">Habbo New</option>
																			<option value="habbo_groot">Habbo Groot</option>	
																			<option value="arctic">Artic</option>
																			<option value="basic">Basic</option>
																			<option value="battlebanzai">Battle Banzai</option>	
																			<option value="bensalem">Bensalem</option>	
																			<option value="bensalem_sea">Bensalem Sea</option>															
																			<option value="beta">Beta</option>	
																			<option value="beta_groot">Beta Groot</option>	
																			<option value="bling">Bling</option>	
																			<option value="chinees">Chinês</option>		
																			<option value="dieren">Dieren</option>	
																			<option value="halloween">Halloween Verde</option>	
																			<option value="halloween_2">Halloween Laranja</option>	
																			<option value="iced">Iced</option>	
																			<option value="neonblauw">Neon Azul</option>	
																			<option value="neongroen">Neon Verde</option>	
																			<option value="neonroze">Neon Rosa</option>	
																			<option value="plastic">Plástico</option>	
																			<option value="plastic_1">Plástico 2</option>	
																			<option value="recycle">Recycle</option>	
																			<option value="zilver">Zilver</option>
																			<option value="1">Flat 1</option>
																			<option value="2">Flat 2</option>	
																			<option value="67">Glass Azul</option>	
																			<option value="68">Glass Verde</option>	
																			<option value="69">Glass Rosa</option>	
																			<option value="70">Glass Roxo</option>	
																			<option value="71">Glass Vermelho</option>	
																			<option value="72">Glass Amarelo</option>	
																			<option value="97">Glass Degradê</option>
																			<option value="glass_red">Glass Vinho</option>	
																			<option value="habbid">Habbid Azul</option>	
																			<option value="habbid2">Habbid Vinho</option>	
																			<option value="114">114</option>	
																			<option value="vip">VIP</option>
																			<option value="habboclub">Habbo Club</option>	
																			<option value="habnew">Habnew</option>	
																		</select>
																	</div>
																</div>
															</div>


															<br>
															<button style="border-radius: 8px;" type="submit" name="instalar" class="btn btn-primary btn-square">Aplicar</button>
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
			</div>
		</div>
	</div>
</div>
</div>
<script type="text/javascript">
	window.onload = function() { fontName(); }
	function fontName() {

		var e = document.getElementById("logo");


		document.getElementById('scan_result').innerHTML = '<img src="http://hsource.fr/font/' + e.value + '/<?= $server['nomehotel'];?>.gif" />';
		document.getElementById('link').value = 'http://hsource.fr/font/' + e.value + '/<?= $server['nomehotel'];?>.gif';
		
	}
</script>
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