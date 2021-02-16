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
			<div class="main-body">
				<div class="page-wrapper">
					<div class="page-body">
						<div class="col-sm-12" style="padding-top:20px">
							<div class="card">
								<div class="card-header">
									<h5>Atualizações para o banco de dados disponíveis</h5>
									<span>Para instalar aperte o botão aplicar.</span>
									<div class="card-header-right"><i class="icofont icofont-spinner-alt-5"></i></div>
								</div>
								<div class="row card-block">
									<div class="col-md-12">
										<ul class="list-view">
											<li>																			

												<?php

												if(!permissao("attdb")){
													echo '<div style="display: contents;">
													<div class="col-md-12">
													<center><div class="alert alert-danger background-danger" style="width: 30%;">
													<strong>Erro!</strong> Sua subconta não tem permissão para acessar essa página.
													</div></center>
													</div>
													</div>';
												} else {

													if(isset($_POST['aplicar'])){


														$PegaEstadoAtual = $PDO->prepare("SELECT * FROM att_db WHERE id = :id");
														$PegaEstadoAtual->bindValue(":id", $_POST['id']);
														$PegaEstadoAtual->execute();
														$EstadoAtual = $PegaEstadoAtual->fetch();

														try {
															$PDO2 = new PDO('mysql:host='.$iphospedagem.';dbname='.$server['uservestacp']."_hotel", $server['uservestacp']."_hotel", $server['senhavestacp']);
															$PDO2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
														} catch(PDOException $e) {
															echo '<script>alert("Erro de conexão ao hotel: ' . utf8_encode($e->getMessage()).'");</script>';
														}

														if($informacao['status'] == "2" && $server['estado'] == "ligado")
																	echo '<div class="alert alert-danger background-danger">
																<strong>Erro!</strong> O emulador está ligado, desligue!
																</div>';	
														else if($EstadoAtual['tipo'] == "mobi"){

															$VerCatalogo = $PDO2->prepare("SELECT caption FROM catalog_pages WHERE id = :id");
															$VerCatalogo->bindValue(":id", $EstadoAtual['page_id']);
															$VerCatalogo->execute();
															$Temc = $VerCatalogo->fetch();
															if(!$Temc){
																try{
																	$Execatt = $PDO2->prepare($EstadoAtual['sql']);
																	$Execatt->execute();
																	$continualoja = true;
																} catch(PDOException $e) {
																	echo '<div class="alert alert-danger background-danger">Erro ao executar SQL: '.$e.'</div>';
																	$continualoja = false;
																}
																if($continualoja){
																	addlog('Executou a atualização '.$_POST['id'].' (Catálogo).');
																	sendRCONCommand2('reload_items', '', $ipvps, $server['portamus']);
																	sleep(3);
																	sendRCONCommand2('reload_catalog', '', $ipvps, $server['portamus']);
																	echo '<div class="alert alert-success background-success">Atualização feita com sucesso</div>';

																	$insereAtualizacao = $PDO->prepare("INSERT INTO `atualizacoes_servidores` (`atualizacao`, `servidor`) VALUES (:a, :s);");
																	$insereAtualizacao->bindValue(":s", $server['id']);
																	$insereAtualizacao->bindValue(":a", $_POST['id']);
																	$insereAtualizacao->execute();

																}
															}
															else {
																echo '<div class="alert alert-danger background-danger">Você já realizou essa atualização!</div>';
															}
														} else {
															try{
																$Execatt = $PDO2->prepare($EstadoAtual['sql']);
																$Execatt->execute();
																addlog('Executou a atualização '.$_POST['id'].'.');

																echo '<div class="alert alert-success background-success">Atualização feita com sucesso</div>';

																$insereAtualizacao = $PDO->prepare("INSERT INTO `atualizacoes_servidores` (`atualizacao`, `servidor`) VALUES (:a, :s);");
																$insereAtualizacao->bindValue(":s", $server['id']);
																$insereAtualizacao->bindValue(":a", $_POST['id']);
																$insereAtualizacao->execute();

															} catch(PDOException $e) {
																echo '<div class="alert alert-danger background-danger">Erro ao executar SQL: '.$e.'</div>';															
															}
														}

													}

													$noticias = $PDO->prepare("SELECT *,(SELECT visual FROM admin WHERE login = user) AS visual FROM att_db WHERE id > ".$server['att_db']." ORDER BY id DESC");
													$noticias->execute();
													while($noticia = $noticias->fetch()){


														$noticias = $PDO->prepare("SELECT id FROM atualizacoes_servidores WHERE atualizacao = :id AND servidor = :s");
														$noticias->bindValue(":s", $server['id']);
														$noticias->bindValue(":id", $noticia['id']);
														$noticias->execute();

														if($noticias->rowCount() == 0)
															echo'<!--- ---->
														<div class="card list-view-media">
														<div class="card-block">
														<div class="media">
														<a class="media-left">
														<img class="media-object card-list-img" draggable="false" src="https://www.habbo.com/habbo-imaging/avatarimage?hb=img&figure='.$noticia['visual'].'&action=sit,crr=667&gesture=sml&direction=2&head_direction=2&size=m&img_format=png" alt="Foto de usuário">
														<br><center>Por '.$noticia['user'].'</center>
														<br><center>Tipo: '.$noticia['tipo'].'</center>
														<br><center>Data: '.date('d/m/y', $noticia['data']).'</center>
														</a>
														<div class="media-body">
														<div class="col-xs-12">
														<center><h6 class="d-inline-block">'.$noticia['titulo'].'</h6></center>
														</div>
														'.html_entity_decode($noticia['mensagem']).'
														</div><form method="POST"><input type="hidden" name="id" value="'.$noticia['id'].'"><button name="aplicar" type="submit" class="btn btn-primary" style="border-radius: 8px;">Aplicar</button></form>
														</div>
														</div>
														</div>
														</li> <!--- ---->';
														else {
															echo "<center><h2>Não há atualizações disponíveis.</h2></center>";
															break;
														}
													}
													?> 

												</ul>
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
<script type="text/javascript" src="galaxyservers/bower_components/jquery/js/jquery.min.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/jquery-ui/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/popper.js/js/popper.min.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/jquery-slimscroll/js/jquery.slimscroll.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/modernizr/js/modernizr.js"></script>
<script src="galaxyservers/assets/pages/widget/amchart/amcharts.min.js"></script>
<script src="galaxyservers/assets/pages/widget/amchart/serial.min.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/chart.js/js/Chart.js"></script>
<script type="text/javascript" src="galaxyservers/assets/pages/todo/todo.js"></script>
<script type="text/javascript" src="galaxyservers/assets/js/script.js"></script>
<script type="text/javascript" src="galaxyservers/assets/js/bootstrap-growl.min.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/i18next/js/i18next.min.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/i18next-xhr-backend/js/i18nextXHRBackend.min.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/i18next-browser-languagedetector/js/i18nextBrowserLanguageDetector.min.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/jquery-i18next/js/jquery-i18next.min.js"></script>
<script type="text/javascript" src="galaxyservers/assets/pages/notification/notification.js"></script>
<script type="text/javascript" src="galaxyservers/assets/pages/dashboard/custom-dashboard.min.js"></script>
<script type="text/javascript" src="galaxyservers/assets/js/SmoothScroll.js"></script>
<script src="galaxyservers/assets/js/pcoded.min.js"></script>
<script src="galaxyservers/assets/js/demo-12.js"></script>
<script src="galaxyservers/assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script type="text/javascript" src="galaxyservers/assets/js/script.min.js"></script>
</body>
</html>
</html><?php } else header('Location: ../index'); ?>