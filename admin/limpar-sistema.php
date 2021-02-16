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
						<div class="card">
							<div class="card-header">
								<h5>Limpar sistema</h5>
								<span>Essa função apagará logs e emuladores que não são mais utilizados.</a></span>
								<div class="card-header-right"><i class="icofont icofont-spinner-alt-5"></i></div>
								<div class="card-header-right">
									<i class="icofont icofont-spinner-alt-5"></i>
								</div>
							</div>
							<div class="card-block">
								<?php
								if (isset($_POST['limpar']))
								{

									function unlinkRecursive($dir, $deleteRootToo) 
									{ 
										if(!$dh = opendir($dir)) 
										{ 
											return; 
										} 
										while (false !== ($obj = readdir($dh))) 
										{ 
											if($obj == '.' || $obj == '..') 
											{ 
												continue; 
											} 

											if (!unlink($dir . '/' . $obj)) 
											{ 
												unlinkRecursive($dir.'/'.$obj, true); 
											} 
										} 
										closedir($dh); 
										if ($deleteRootToo) 
										{ 
											rmdir($dir); 
										} 
										return; 
									} 

									$path = "../galaxyservers/emuladores";
									$diretorio = dir($path);

									while($arquivo = $diretorio -> read()){

										if (strpos($arquivo, '.') !== false) {
											
										} else {

											$SelecionaUsuario = $PDO->prepare("SELECT id FROM servidores WHERE uservestacp = :usuario");
											$SelecionaUsuario->bindParam(':usuario', $arquivo);
											$SelecionaUsuario->execute();
											$SelecionaUsuario = $SelecionaUsuario->rowCount();

											if($SelecionaUsuario > 0){
												@unlink($path.'/'.$arquivo.'/logs/errors/Critical_errors.log');
												@unlink($path.'/'.$arquivo.'/logs/errors/Exception_errors.log');
												@unlink($path.'/'.$arquivo.'/logs/errors/Galaxy_ErrorLog.log');
												@unlink($path.'/'.$arquivo.'/logs/errors/MySQL_errors.log');
											} else {

												if($arquivo != "sourcegalaxy" || $arquivo != "sourcebot"){
													unlinkRecursive($path.'/'.$arquivo, true);

													echo '<font color="red">'.$arquivo.'</font>';
													echo "\n";
												}
												
											}


										}

									}
									$diretorio -> close();

									echo '<div class="alert alert-success background-success">
									<strong>Sucesso!</strong> Todos os emuladores foram limpos!
									</div>'; 
									addlog_admin($_SESSION['useradmin'], "Configurou todos os limpos");
								}
								?>
								<form method="POST">
									<center><button class="btn btn-primary" style="border-radius: 8px;" type="submit" name="limpar">Limpar sistema</button></center>
									<br>
								</form>
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