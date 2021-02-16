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
								<h5>Emblemas Games</h5>
								<span>Preencha os dados abaixo para adicionar.</a></span>
								<div class="card-header-right"><i class="icofont icofont-spinner-alt-5"></i></div>
								<div class="card-header-right">
									<i class="icofont icofont-spinner-alt-5"></i>
								</div>
							</div>
							<div class="card-block">
								<?php
								if (isset($_POST['postarnoticia']))
								{
									$selecionatodos = $PDO->prepare("INSERT INTO `vista_padrao` (`background_back`, `background_background_hotel`, `background_front`, `background_gradient`, `background_gradient_top`, `background_horizon`, `background_hotel_top`, `background_left`, `background_right`, `nome`) VALUES (:1, :2, :3, :4, :5, :6, :7, :8, :9, :10);");
									$selecionatodos->bindParam(":1", $_POST['background_back']);
									$selecionatodos->bindParam(":2", $_POST['background_background_hotel']);
									$selecionatodos->bindParam(":3", $_POST['background_front']);
									$selecionatodos->bindParam(":4", $_POST['background_gradient']);
									$selecionatodos->bindParam(":5", $_POST['background_gradient_top']);
									$selecionatodos->bindParam(":6", $_POST['background_horizon']);
									$selecionatodos->bindParam(":7", $_POST['background_hotel_top']);
									$selecionatodos->bindParam(":8", $_POST['background_left']);
									$selecionatodos->bindParam(":9", $_POST['background_right']);
									$selecionatodos->bindParam(":10", $_POST['nome']);
									$selecionatodos->execute();
									echo '<div class="alert alert-info background-info">
									<strong>Sucesso!</strong> Adicionado ao banco de dados.
									</div>';

									addlog_admin($_SESSION['useradmin'], "Adicionou uma vista da client.");


								}
								?>
								<form method="POST">

									<div class="form-group row">
										<label class="col-sm-2 col-form-label">Nome</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" name="nome" placeholder="Nome" required>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-2 col-form-label">background_back</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" name="background_back" value="meter_level_1_vip_icon_lympix.png" required>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-2 col-form-label">background_background_hotel</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" name="background_background_hotel" value="meter_level_1_vip_icon_lympix.png" required>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-2 col-form-label">background_front</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" name="background_front" value="meter_level_1_vip_icon_lympix.png" required>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-2 col-form-label">background_gradient</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" name="background_gradient" required>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-2 col-form-label">background_gradient_top</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" name="background_gradient_top" required>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-2 col-form-label">background_horizon</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" name="background_horizon" value="meter_level_1_vip_icon_lympix.png" required>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-2 col-form-label">background_hotel_top</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" name="background_hotel_top" required>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-2 col-form-label">background_left</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" name="background_left" required>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-2 col-form-label">background_right</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" name="background_right" required>
										</div>
									</div>
									
									<br>														
									<center><button class="btn btn-primary" type="submit" style="border-radius: 8px;" name="postarnoticia" >Adicionar</button></center>
									<br>
								</form>
								<table class="table table-framed">
									<thead>
										<tr>
											<th>#</th>
											<th>Nome</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<?php 
										if (isset($_POST['deletanoticia']))
										{
											$apaganoticia = $PDO->prepare("DELETE FROM vista_padrao WHERE id = :id");
											$apaganoticia->bindParam(":id", $_POST['idnoticia']);
											$apaganoticia->execute();

											$apaganoticia = $PDO->prepare("UPDATE servidores SET vistaclient = \"padrao\" WHERE vistaclient = :vistaclient");
											$apaganoticia->bindValue(":vistaclient", "vista:".$_POST['idnoticia']);
											$apaganoticia->execute();
										}
										$vernoticias = $PDO->prepare("SELECT * FROM vista_padrao ORDER BY id DESC");
										$vernoticias->execute();
										while($noticia = $vernoticias->fetch()){

											echo '
											<tr>
											<th scope="row">'.$noticia['id'].'</th>
											<td>'.utf8_encode($noticia['nome']).'</td>
											<td><form action="" name="deletanoticia" method="POST"><input type="hidden" name="idnoticia" value="'.$noticia["id"].'"><input type="submit"  name="deletanoticia" value="Remover"  class="btn btn-danger" style="padding: 5px;"/></span></form></td>
											</tr>
											';
										}
										?>
									</tbody>
								</table>
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