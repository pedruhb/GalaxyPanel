<?php include "../galaxyservers/global.php";
if(empty($_SESSION['useradmin'])){
	echo '<script>location.href="../index";</script>';
}
if (!empty($_SESSION['useradmin'])){

	include "nav.php";
	?>
	<div class="pcoded-content">
		<div class="pcoded-inner-content">
			<div class="main-body">
				<div class="page-wrapper">
					<div class="page-body">
						<div class="">
							<div class="card">
								<div class="card-header">
									<h5>Enviar nova atualização do emulador.</h5>
									<span></span>									
									<div class="card-header-right">
										<i class="icofont icofont-spinner-alt-5"></i>
									</div>
								</div>
								<div class="card-block">		
									<?php

									if(isset($_POST['commit'])){

										$path_up = "../galaxyservers/emuladores/sourcegalaxy/";
										if (move_uploaded_file($_FILES['exe']['tmp_name'], $path_up."GalaxyServer.exe")) {

											if (move_uploaded_file($_FILES['pdb']['tmp_name'], $path_up."GalaxyServer.pdb")) {

												loginsucess("Atualização enviada.");

												$SelecionaHotel = $PDO->prepare("UPDATE emulador SET versao = versao+1, mensagem = :mensagem;");
												$SelecionaHotel->bindValue(":mensagem", $_POST['mensagem']);
												$SelecionaHotel->execute();

												addlog_admin("","Lançou uma atualização do emulador.");

											} else {
												echo '<div class="alert alert-danger background-danger">
												<strong>Erro!</strong> Erro ao enviar atualização. (pdb)
												</div>'; 
											}

										} else {
											echo '<div class="alert alert-danger background-danger">
											<strong>Erro!</strong> Erro ao enviar atualização. (exe)
											</div>'; 
										}

									}
									?>
									<form method="post" enctype="multipart/form-data">
										<div class="row">
											<div class="row" style="margin-left: 10px;">
												<label class="col-sm-4 col-lg-5 col-form-label">GalaxyServer.exe</label>                  
												<input type="file" name="exe" class="form-control" required="" style=" margin-left: 15px; "> 
											</div>
										</div>
										<br><br>
										<div class="row">
											<div class="row" style="margin-left: 10px;">
												<label class="col-sm-4 col-lg-5 col-form-label">GalaxyServer.pdb</label>                  
												<input type="file" name="pdb" class="form-control" required="" style=" margin-left: 15px; "> 
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-2 col-form-label">Mensagem</label>
											<div class="col-sm-10">
												<input type="text" class="form-control" name="mensagem" placeholder="" required>
											</div>
										</div>
										<br><br>
										<center><button type="submit" style="border-radius: 8px;" name="commit" class="btn btn-primary m-b-0">Hospedar</button></center>
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
</div>
<script type="text/javascript" src="<?php echo $dominio;?>/galaxyservers/bower_components/jquery/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $dominio;?>/galaxyservers/bower_components/jquery-ui/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo $dominio;?>/galaxyservers/bower_components/popper.js/js/popper.min.js"></script>
<script type="text/javascript" src="<?php echo $dominio;?>/galaxyservers/bower_components/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo $dominio;?>/galaxyservers/bower_components/jquery-slimscroll/js/jquery.slimscroll.js"></script>
<script type="text/javascript" src="<?php echo $dominio;?>/galaxyservers/bower_components/modernizr/js/modernizr.js"></script>
<script src="<?php echo $dominio;?>/galaxyservers/assets/pages/widget/amchart/amcharts.min.js"></script>
<script src="<?php echo $dominio;?>/galaxyservers/assets/pages/widget/amchart/serial.min.js"></script>
<script type="text/javascript" src="<?php echo $dominio;?>/galaxyservers/bower_components/chart.js/js/Chart.js"></script>
<script type="text/javascript" src="<?php echo $dominio;?>/galaxyservers/assets/pages/todo/todo.js"></script>
<script type="text/javascript" src="<?php echo $dominio;?>/galaxyservers/assets/js/script.js"></script>
<script type="text/javascript" src="<?php echo $dominio;?>/galaxyservers/assets/js/bootstrap-growl.min.js"></script>
<script type="text/javascript" src="<?php echo $dominio;?>/galaxyservers/bower_components/i18next/js/i18next.min.js"></script>
<script type="text/javascript" src="<?php echo $dominio;?>/galaxyservers/bower_components/i18next-xhr-backend/js/i18nextXHRBackend.min.js"></script>
<script type="text/javascript" src="<?php echo $dominio;?>/galaxyservers/bower_components/i18next-browser-languagedetector/js/i18nextBrowserLanguageDetector.min.js"></script>
<script type="text/javascript" src="<?php echo $dominio;?>/galaxyservers/bower_components/jquery-i18next/js/jquery-i18next.min.js"></script>
<script type="text/javascript" src="<?php echo $dominio;?>/galaxyservers/assets/pages/notification/notification.js"></script>
<script type="text/javascript" src="<?php echo $dominio;?>/galaxyservers/assets/pages/dashboard/custom-dashboard.min.js"></script>
<script type="text/javascript" src="<?php echo $dominio;?>/galaxyservers/assets/js/SmoothScroll.js"></script>
<script src="<?php echo $dominio;?>/galaxyservers/assets/js/pcoded.min.js"></script>
<script src="<?php echo $dominio;?>/galaxyservers/assets/js/demo-12.js"></script>
<script src="<?php echo $dominio;?>/galaxyservers/assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script type="text/javascript" src="<?php echo $dominio;?>/galaxyservers/assets/js/script.min.js"></script>
<script type="text/javascript">
	funcaoJavascript = function(){
		var a = document.getElementById('user');
		var b = document.getElementById('db');
		if(a.value == "")
			b.value = a.value;
		else 
			b.value = a.value+"_hotel";
	}
</script>
</body>
</html>
<?php }?>