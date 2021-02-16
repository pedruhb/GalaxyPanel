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
					<div class="page-header card">
						<div class="row align-items-end">
							<div class="col-lg-8">
								<div class="page-header-title">
									<i class="icofont icofont-list bg-c-blue"></i>
									<div class="d-inline">
										<h4>Tutoriais</h4>
										<span>Nós disponibilizamos aqui vários tutoriais para ajudar você!</span>
									</div>
								</div>
							</div>
							<div class="col-lg-4">
								<div class="page-header-breadcrumb">
								</div>
							</div>
						</div>
					</div>
					<div class="page-body">
						<div class="row">
							<div class="col-sm-12">
								<div class="card">
									<div class="card-header">
										<h5>Tutoriais</h5>
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
												$tutos = $PDO->prepare("SELECT * FROM tutoriais ORDER BY id DESC");
												$tutos->execute();
												while($tutorial = $tutos->fetch()){
													?>
													<li>
														<div class="card list-view-media">
															<div class="card-block">
																<div class="media">
																	<div class="media-body">
																		<div class="col-xs-12">
																			<h6 class="d-inline-block"><?php echo $tutorial['titulo'];?></h6>
																		</div>
																		<div class="f-13 text-muted m-b-15">
																			<?php echo difer_data(date('Y-m-d G:i:s', $tutorial['data']));?>
																		</div>
																		<?= html_entity_decode($tutorial['post']);?>
																	</div>
																</div>
															</div>
														</div>
													</li>
													<?php }?>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
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
<script type="text/javascript" src="../../galaxyservers/bower_components/jquery/js/jquery.min.js"></script>
<script type="text/javascript" src="../../galaxyservers/bower_components/jquery-ui/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="../../galaxyservers/bower_components/popper.js/js/popper.min.js"></script>
<script type="text/javascript" src="../../galaxyservers/bower_components/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../../galaxyservers/bower_components/jquery-slimscroll/js/jquery.slimscroll.js"></script>
<script type="text/javascript" src="../../galaxyservers/bower_components/modernizr/js/modernizr.js"></script>
<script type="text/javascript" src="../../galaxyservers/bower_components/modernizr/js/css-scrollbars.js"></script>
<script src="../../galaxyservers/assets/pages/jquery.filer/js/jquery.filer.min.js"></script>
<script src="../../galaxyservers/assets/pages/filer/custom-filer.js" type="text/javascript"></script>
<script src="../../galaxyservers/assets/pages/filer/jquery.fileuploads.init.js?a=a" type="text/javascript"></script>
<script type="text/javascript" src="../../galaxyservers/bower_components/i18next/js/i18next.min.js"></script>
<script type="text/javascript" src="../../galaxyservers/bower_components/i18next-xhr-backend/js/i18nextXHRBackend.min.js"></script>
<script type="text/javascript" src="../../galaxyservers/bower_components/i18next-browser-languagedetector/js/i18nextBrowserLanguageDetector.min.js"></script>
<script type="text/javascript" src="../../galaxyservers/bower_components/jquery-i18next/js/jquery-i18next.min.js"></script>
<script src="../../galaxyservers/assets/js/pcoded.min.js"></script>
<script src="../../galaxyservers/assets/js/demo-12.js"></script>
<script src="../../galaxyservers/assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script type="text/javascript" src="../../galaxyservers/assets/js/script.js"></script>
</body>
</html><?php } else header('Location: ../index'); ?>