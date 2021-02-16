
<?php
include "galaxyservers/global.php";
if(!empty($_SESSION['nomeusuario'])){

	$infoserver = $PDO->prepare("SELECT * FROM servidores WHERE nomeusuario = '".$_SESSION['nomeusuario']."'");
	$infoserver->execute();
	$server = $infoserver->fetch();
	$_SESSION['senhaatualdb'] = $server['senhavestacp'];
	?>
	<?php include 'galaxyservers/nav.php';?>
	<link rel="stylesheet" type="text/css" href="https://cliente.galaxyservers.com.br/assets/css/font-awesome.min.css">
	<div class="pcoded-content">
		<div class="pcoded-inner-content">
			<div class="main-body">
				<div class="page-wrapper">
					<div class="page-body">
						<div class="row">
							<?php
							try {
								$PDO2 = new PDO('mysql:host='.$iphospedagem.';dbname='.$server['uservestacp']."_hotel", $server['uservestacp']."_hotel", $server['senhavestacp']);
								$PDO2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
								$infoserver2 = $PDO2->prepare("SELECT (SELECT users_online FROM server_status) as userson, (select count(id) from users) as usertotal, (select loaded_rooms from server_status) as quartoscarregados, (select record_on from server_status) as recordon, (select status from server_status) as status");
								$infoserver2->execute();
								$informacao = $infoserver2->fetch();

							} catch(PDOException $e) {
								$informacao['userson'] = 0;
								$informacao['usertotal'] = 0;
								$informacao['quartoscarregados'] = 0;
								$informacao['recordon'] = 0;
								//echo '<script>alert("Erro de conexão ao hotel: ' . utf8_encode($e->getMessage()).'");</script>';
							}
							?>

							<div class="col-md-6 col-xl-3">
								<div class="card widget-card-1">
									<div class="card-block-small">
										<i class="icofont icofont-ui-user bg-c-blue card1-icon"></i>
										<span class="text-c-blue f-w-600">Usuários Online</span>
										<h4><?php echo $informacao['userson'];?></h4>
										<div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-6 col-xl-3">
								<div class="card widget-card-1">
									<div class="card-block-small">
										<i class="icofont icofont-ui-user-group bg-c-green card1-icon"></i>
										<span class="text-c-green f-w-600">Usuários Total</span>
										<h4><?php echo $informacao['usertotal'];?></h4>
										<div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-6 col-xl-3">
								<div class="card widget-card-1">
									<div class="card-block-small">
										<i class="icofont icofont-ui-home bg-c-pink card1-icon"></i>
										<span class="text-c-pink f-w-600">Quartos</span>
										<h4><?php echo $informacao['quartoscarregados'];?></h4>
										<div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-6 col-xl-3">
								<div class="card widget-card-1">
									<div class="card-block-small">
										<i class="icofont icofont-win-trophy bg-c-yellow card1-icon"></i>
										<span class="text-c-yellow f-w-600">Record de ON's</span>
										<h4><?php echo $informacao['recordon'];?></h4>
									</div>
								</div>
							</div>

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
										</form>

										<a title="Entrar no hotel" target="_blank" style="border-radius: 8px;" href="<?= $server['http'];?>://<?= $server['linkhotel'];?>" tyle="border-radius: 8px;" class="btn btn-primary"><i class="fa fa-globe" aria-hidden="true"></i></a>

									</div>
									
								<?php }?>
								
								<?php
								$attnadb = false;
								
								/*$noticias = $PDO->prepare("SELECT * FROM att_db ORDER BY id DESC LIMIT 5");
								$noticias->execute();
								while($noticia = $noticias->fetch()){
									if($noticias->rowCount() > 0){
										$noticias = $PDO->prepare("SELECT id FROM atualizacoes_servidores WHERE atualizacao = :id AND servidor = :s");
										$noticias->bindValue(":s", $server['id']);
										$noticias->bindValue(":id", $noticia['id']);
										$noticias->execute();
										if(!empty($noticias->fetch()['id']))
											$attnadb = true;
									}
								}
								*/

								$noticias = $PDO->prepare("SELECT * FROM att_db WHERE id > ".$server['att_db']." ORDER BY id DESC");
								$noticias->execute();
								while($noticia = $noticias->fetch()){


									$noticias = $PDO->prepare("SELECT id FROM atualizacoes_servidores WHERE atualizacao = :id AND servidor = :s");
									$noticias->bindValue(":s", $server['id']);
									$noticias->bindValue(":id", $noticia['id']);
									$noticias->execute();

									if($noticias->rowCount() == 0)
										$attnadb = true;
									else {
										$attnadb = false;
										break;
									}

								}

								if($attnadb)
									echo '<br><br><br><br><div class="col-md-12">
								<center><div class="alert alert-warning background-warning" style="width: 40%;" >
								<strong>Atenção!</strong> Há uma atualização de banco de dados pendente, clique <a href="/att-db" style=" color: white; ">aqui</a> para atualizar.
								</div></center>
								</div>
								';
								?>

								<?php
								if(versaoemu() != $server['versao_emu'])
									echo '<br><br><br><br><div class="col-md-12">
								<center><div class="alert alert-warning background-warning" style="width: 40%;" >
								<strong>Atenção!</strong> Há uma atualização de emulador pendente, clique <a href="/att-emu" style=" color: white; ">aqui</a> para atualizar.
								</div></center>
								</div>
								<div class="col-sm-12" style="padding-top:7px">';
								else
									echo '<div class="col-sm-12" style="padding-top:20px">'; 
								?>

								<div class="card">
									<div class="card-header">
										<h5>Gráficos</h5>
										<span>Confira aqui o histórico de usuários online e quartos carregados de hotel.</span>
									</div>
									<div class="card-block">


										<script>
											window.onload = function() {
												var chart = new CanvasJS.Chart("chartContainer", {
													animationEnabled: true,
													theme: "light2",
													zoomEnabled: true,
													data: [{
														type: "spline",
														name: "Usuários online",
														connectNullData: true,
														showInLegend: true,
														color: "#5985ee",
														dataPoints: [
														<?php
														date_default_timezone_set('America/Sao_Paulo');
														try{
															$emblemas = $PDO2->prepare("SELECT * FROM graficos_galayservers order by id desc");
															$emblemas->execute();
															while($emblema = $emblemas->fetch()){ 

																$timestamp = $emblema["timestamp"];

																$data = date('d', $emblema["timestamp"]).'/'.date('m', $emblema["timestamp"]).'/'.date('y', $emblema["timestamp"])." ".date('H', $emblema["timestamp"]).":".date('i', $emblema["timestamp"]);

																echo '{ label: "'.$data.'",  y: '.$emblema['onlines'].'  },';
															}
														}
														catch(Exception $e){
															echo "<script>alert('Erro ao obter, caso você não tenha atualizado, atualize seu banco de dados para utilizar essa função.');</script>";
														}
														?>

														]
													},
													{
														type: "spline",
														name: "Quartos carregados",
														connectNullData: true,
														showInLegend: true,
														color: "#e66793",
														dataPoints: [
														<?php
														date_default_timezone_set('America/Sao_Paulo');
														try{
															$emblemas = $PDO2->prepare("SELECT * FROM graficos_galayservers order by id desc ");
															$emblemas->execute();
															while($emblema = $emblemas->fetch()){ 

																$timestamp = $emblema["timestamp"]-10800;

																$data = date('d', $timestamp).'/'.date('m', $timestamp).'/'.date('y', $timestamp)." ".date('H', $timestamp).":".date('i', $timestamp);

																echo '{ label: "'.$data.'",  y: '.$emblema['quartos'].'  },';
															}
														}
														catch(Exception $e){
															echo "<script>alert('Erro ao obter, caso você não tenha atualizado, atualize seu banco de dados para utilizar essa função.');</script>";
														}
														?>

														]
													}],
												});
												chart.render();
											}
										</script>
									</head>
									<body>
										<div id="chartContainer" style="height: 370px; width: 100%;"></div>
										<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
									</div>										
								</div>

								<div class="card">
									<div class="card-header">
										<h5>Notícias dos desenvolvedores.</h5>
										<div class="card-header-right"><i class="icofont icofont-spinner-alt-5"></i></div>
									</div>
									<div class="row card-block">
										<div class="col-md-12">
											<ul class="list-view">
												<?php
												function difer_data($data) { 
													$agora = new DateTime();        
													try {       
														$data_ref = new DateTime($data);            
													} catch (Exception $e) {        
														echo $e->getMessage();        
														return NULL;    
													}       
													$prefixo = ($data_ref > $agora) ? "Faltam" : "Publicado há";    
													$intervalo = $data_ref->diff($agora);  
													extract((array) $intervalo);     
													if ($y >= 1) {        
														$sufixo = "{$y} " . ($y == 1 ? "ano":"anos");    
													} else if ($m >= 1) {        
														$sufixo = "{$m} " . ($m == 1  ? "mês":"meses");    
													} else if ($d > 7) {        
														$sufixo = floor($d / 7) . " " . ($d <= 14 ? "semana":"semanas");    
													} else if ($d >= 1) {
														$sufixo = "{$d} " . ($d == 1  ? "dia":"dias");    
													} else if ($h >= 1) {
														$sufixo = "{$h} " . ($h == 1  ? "hora":"horas") ;    
													} else if ($i >= 1) {
														$sufixo = "{$i} " . ($i == 1  ? "minuto":"minutos");    
													} else { 
														$sufixo = "{$s} segundos";   
													}     return "{$prefixo} {$sufixo}";
												} 
												?>
												<?php 

												if(isset($_POST['like']) || isset($_POST['deslike'])){

													if(isset($_POST['like'])){
														$tipo = "like";
														$id = $_POST['like'];
													}
													else {
														$tipo = "deslike";
														$id = $_POST['deslike'];
													}

													$verLikes = $PDO->prepare("SELECT id FROM like_noticia WHERE noticia = :id and servidor = :servidor;");
													$verLikes->bindParam(":id", $id);
													$verLikes->bindValue(":servidor", $server['id']);
													$verLikes->execute();
													$likes = $verLikes->rowCount();

													if($likes != 0){

														$deletaLike = $PDO->prepare("DELETE FROM like_noticia WHERE noticia = :1 AND servidor= :2");
														$deletaLike->bindParam(":1", $id);
														$deletaLike->bindValue(":2", $server['id']);
														$deletaLike->execute();

														$verLikes = $PDO->prepare("INSERT INTO `like_noticia` (`noticia`, `servidor`, `tipo`) VALUES (:1, :2, :3);");
														$verLikes->bindParam(":1", $id);
														$verLikes->bindValue(":2", $server['id']);
														$verLikes->bindParam(":3", $tipo);
														$verLikes->execute();

													} else {
														$verLikes = $PDO->prepare("INSERT INTO `like_noticia` (`noticia`, `servidor`, `tipo`) VALUES (:1, :2, :3);");
														$verLikes->bindParam(":1", $id);
														$verLikes->bindValue(":2", $server['id']);
														$verLikes->bindParam(":3", $tipo);
														$verLikes->execute();
													}
												}

												$noticias = $PDO->prepare("SELECT *,(SELECT visual FROM admin WHERE login = usuario) AS visual FROM noticias ORDER BY id DESC LIMIT 3");
												$noticias->execute();
												while($noticia = $noticias->fetch()){ 

													$pegaLikes = $PDO->prepare("SELECT id FROM like_noticia WHERE noticia = :id and tipo = 'like';");
													$pegaLikes->bindValue(":id", $noticia['id']);
													$pegaLikes->execute();
													$likes = $pegaLikes->rowCount();

													$pegaDeslikes = $PDO->prepare("SELECT id FROM like_noticia WHERE noticia = :id and tipo = 'deslike';");
													$pegaDeslikes->bindValue(":id", $noticia['id']);
													$pegaDeslikes->execute();
													$deslikes = $pegaDeslikes->rowCount();

													?>
													<!--- ---->
													<li>
														<div class="card list-view-media">
															<div class="card-block">
																<div class="media">
																	<a class="media-left">
																		<img class="media-object card-list-img" draggable="false" 
																		src="https://www.habbo.com/habbo-imaging/avatarimage?hb=img&figure=<?= $noticia['visual'];?>&action=sit,crr=667&gesture=sml&direction=2&head_direction=2&size=m&img_format=png" alt="Foto do usuário <?= $noticia['usuario'];?>">
																	</a>
																	<div class="media-body">
																		<div class="col-xs-12">
																			<h6 class="d-inline-block">
																				<?= $noticia['usuario'];?></h6>
																				<label class="label label-info">Desenvolvedor</label>
																			</div>
																			<div class="f-13 text-muted m-b-15">
																				<?= difer_data(date('Y-m-d G:i:s', $noticia['timestamp']));?>
																			</div>
																			<p><?= $noticia['noticia'];?></p>

																			<form method="post">
																				<div style="float: right;">
																					<button title="Curtir notícia" class="btn like btn-primary" style="border: 1px solid transparent; border-radius: 4px;" value="<?= $noticia['id'];?>" name="like">
																						<span class="fa fa-thumbs-up" aria-hidden="true"></span> 
																						<span class="likes"><?= $likes;?></span>
																					</button>
																					<button title="Descurtir notícia" class="btn dislike btn-danger" style="border: 1px solid transparent; border-radius: 4px;" value="<?= $noticia['id'];?>" name="deslike">
																						<span class="fa fa-thumbs-down" aria-hidden="true"></span>  
																						<span class="dislikes"><?= $deslikes;?></span>
																					</button>
																				</div>
																			</form>

																		</div>
																	</div>
																</div>
															</div>
															</li> <!--- ----><?php 
														}
														?> 
													</ul>
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
<script src="galaxyservers/assets/pages/widget/amchart/amcharts.min.js"></script>
<script src="galaxyservers/assets/pages/widget/amchart/serial.min.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/chart.js/js/Chart.js"></script>
<script type="text/javascript" src="galaxyservers/assets/js/script.js"></script>
<script type="text/javascript" src="galaxyservers/assets/js/bootstrap-growl.min.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/i18next/js/i18next.min.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/i18next-xhr-backend/js/i18nextXHRBackend.min.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/i18next-browser-languagedetector/js/i18nextBrowserLanguageDetector.min.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/jquery-i18next/js/jquery-i18next.min.js"></script>
<script type="text/javascript" src="https://icofont.com/main.97357a947b24409abb1a.js"></script>
<script type="text/javascript" src="galaxyservers/assets/pages/dashboard/custom-dashboard.min.js"></script>
<script type="text/javascript" src="galaxyservers/assets/js/SmoothScroll.js"></script>
<script src="galaxyservers/assets/js/pcoded.min.js"></script>
<script src="galaxyservers/assets/js/demo-12.js"></script>
<script src="galaxyservers/assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script type="text/javascript" src="galaxyservers/assets/js/script.min.js"></script>
<script type="text/javascript" src="galaxyservers/assets/pages/todo/todo.js?"></script>
</body>
</html>
</html><?php } else header('Location: ../index'); ?>