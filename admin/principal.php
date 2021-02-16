<?php include "../galaxyservers/global.php";
if(empty($_SESSION['useradmin'])){
	echo '<script>location.href="index";</script>';
}
if (!empty($_SESSION['useradmin'])){

	include "nav.php";
	?>
	<div class="pcoded-content">
		<div class="pcoded-inner-content">
			<div class="main-body">
				<div class="page-wrapper">
					<div class="page-body">
						<div class="row">
							<?php
							$pegatotal1 = $PDO->prepare("SELECT count(id) as total FROM servidores WHERE ativo = 'Y'");
							$pegatotal1->execute();
							$total1 = $pegatotal1->fetch();
							$emuladorestotal = $total1['total'];

							$pegatotal2 = $PDO->prepare("SELECT count(id) as total FROM servidores where estado = 'ligado' and ativo = 'Y'");
							$pegatotal2->execute();
							$total2 = $pegatotal2->fetch();
							$emuladoresligado = $total2['total'];

							$pegatotal3 = $PDO->prepare("SELECT count(id) as total FROM servidores where estado = 'desligado' and ativo = 'Y'");
							$pegatotal3->execute();
							$total3 = $pegatotal3->fetch();
							$emuladoresdesligado = $total3['total'];

							$pegatotal4 = $PDO->prepare("SELECT count(id) as total FROM noticias");
							$pegatotal4->execute();
							$total4 = $pegatotal4->fetch();
							$totalnoticias = $total4['total'];

							$pegatotal4 = $PDO->prepare("SELECT count(id) as total FROM servidores WHERE botdiscord != 'desativado'");
							$pegatotal4->execute();
							$total4 = $pegatotal4->fetch();
							$totaldiscord = $total4['total'];
							?>
							<div class="col-md-6 col-xl-3">
								<div class="card widget-card-1">
									<div class="card-block-small">
										<i class="icofont icofont-ui-user bg-c-blue card1-icon"></i>
										<span class="text-c-blue f-w-600">Clientes ativos</span>
										<h4><?php echo $emuladorestotal;?></h4>
										<div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-6 col-xl-3">
								<div class="card widget-card-1">
									<div class="card-block-small">
										<i class="icofont icofont-ui-user bg-c-blue card1-icon"></i>
										<span class="text-c-blue f-w-600">Bots ativos</span>
										<h4><?= $totaldiscord;?></h4>
										<div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-6 col-xl-3">
								<div class="card widget-card-1">
									<div class="card-block-small">
										<i class="icofont icofont-thumbs-up bg-c-green card1-icon"></i>
										<span class="text-c-green f-w-600">Hotéis Ligados</span>
										<h4><?php echo $emuladoresligado;?></h4>
										<div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-6 col-xl-3">
								<div class="card widget-card-1">
									<div class="card-block-small">
										<i class="icofont icofont-envelope-open bg-c-yellow card1-icon"></i>
										<span class="text-c-yellow f-w-600">Notícias</span>
										<h4><?php echo $totalnoticias;?></h4>
									</div>
								</div>
							</div>
							<div class="col-sm-12">
								<div class="card">
									<div class="card-header">
										<h5>Notícias</h5>
										<div class="card-header-right"><i class="icofont icofont-spinner-alt-5"></i></div>
									</div>
									<div class="row card-block">
										<div class="col-md-12">
											<ul class="list-view">
												<li> 
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
													/*$Todasascontas = $PDO->prepare("SELECT id,uservestacp,senhavestacp FROM servidores");
													$Todasascontas->execute();
													while($conta = $Todasascontas->fetch()){
													$updatekey = $PDO->prepare("UPDATE servidores SET apikey = '".md5($conta['uservestacp']."galaxyservers".$conta['senhavestacp'])."' WHERE id =".$conta['id']);
													$updatekey->execute();
												}*/

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
																					<button disabled title="Curtir notícia" class="btn like btn-primary" style="border: 1px solid transparent; border-radius: 4px;" value="<?= $noticia['id'];?>" name="like">
																						<span class="fa fa-thumbs-up" aria-hidden="true"></span> 
																						<span class="likes"><?= $likes;?></span>
																					</button>
																					<button disabled title="Descurtir notícia" class="btn dislike btn-danger" style="border: 1px solid transparent; border-radius: 4px;" value="<?= $noticia['id'];?>" name="deslike">
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
<script type="text/javascript" src="../galaxyservers/bower_components/jquery/js/jquery.min.js"></script>
<script type="text/javascript" src="../galaxyservers/bower_components/jquery-ui/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="../galaxyservers/bower_components/popper.js/js/popper.min.js"></script>
<script type="text/javascript" src="../galaxyservers/bower_components/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../galaxyservers/bower_components/jquery-slimscroll/js/jquery.slimscroll.js"></script>
<script type="text/javascript" src="../galaxyservers/bower_components/modernizr/js/modernizr.js"></script>
<script src="../galaxyservers/assets/pages/widget/amchart/amcharts.min.js"></script>
<script src="../galaxyservers/assets/pages/widget/amchart/serial.min.js"></script>
<script type="text/javascript" src="../galaxyservers/bower_components/chart.js/js/Chart.js"></script>
<script type="text/javascript" src="../galaxyservers/assets/pages/todo/todo.js"></script>
<script type="text/javascript" src="../galaxyservers/assets/js/script.js"></script>
<script type="text/javascript" src="../galaxyservers/assets/js/bootstrap-growl.min.js"></script>
<script type="text/javascript" src="../galaxyservers/bower_components/i18next/js/i18next.min.js"></script>
<script type="text/javascript" src="../galaxyservers/bower_components/i18next-xhr-backend/js/i18nextXHRBackend.min.js"></script>
<script type="text/javascript" src="../galaxyservers/bower_components/i18next-browser-languagedetector/js/i18nextBrowserLanguageDetector.min.js"></script>
<script type="text/javascript" src="../galaxyservers/bower_components/jquery-i18next/js/jquery-i18next.min.js"></script>
<script type="text/javascript" src="../galaxyservers/assets/pages/notification/notification.js"></script>
<script type="text/javascript" src="../galaxyservers/assets/pages/dashboard/custom-dashboard.min.js"></script>
<script type="text/javascript" src="../galaxyservers/assets/js/SmoothScroll.js"></script>
<script src="../galaxyservers/assets/js/pcoded.min.js"></script>
<script src="../galaxyservers/assets/js/demo-12.js"></script>
<script src="../galaxyservers/assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script type="text/javascript" src="../galaxyservers/assets/js/script.min.js"></script>
</body>
</html>
<?php } ?>