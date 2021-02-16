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
									$selecionatodos = $PDO->prepare("INSERT INTO `emblemas_game` (`titulo`, `codigo`, `qnt`, `user`, `timestamp`) VALUES ('".gs($_POST['titulo'])."', '".gs($_POST['codigo'])."', '".gs($_POST['qnt'])."', '".$_SESSION['useradmin']."', '".time()."');");
									$selecionatodos->execute();
									echo '<div class="alert alert-info background-info">
									<strong>Sucesso!</strong> Adicionado ao banco de dados.
									</div>';

									addlog_admin($_SESSION['useradmin'], "Postou um emblema game.");


								}
								?>
								<form method="POST">
									Título:
									<input type="text" class="form-control" name="titulo" placeholder="Título. Ex: Emblemas Natal" required>
									<br>
									Código:
									<input type="text" class="form-control" name="codigo" placeholder="Código. Ex: NV" required>
									<br>
									Quantidade: <select name="qnt" class="form-control">
										<option value="100">100</option>
										<option value="200">200</option>
									</select>	
									<br>														
									<center><button class="btn btn-primary" type="submit" style="border-radius: 8px;" name="postarnoticia" >Postar</button></center>
									<br>
								</form>
								<table class="table table-framed">
									<thead>
										<tr>
											<th>#</th>
											<th>Usuário</th>
											<th>Código</th>
											<th>Quantidade</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<?php 
										if (isset($_POST['deletanoticia']))
										{
											$apaganoticia = $PDO->prepare("DELETE FROM emblemas_game WHERE id = ".$_POST['idnoticia']);
											$apaganoticia->execute();
										}
										$vernoticias = $PDO->prepare("SELECT * FROM emblemas_game ORDER BY id DESC");
										$vernoticias->execute();
										while($noticia = $vernoticias->fetch()){

											echo '																<tr>
											<th scope="row">'.$noticia['id'].'</th>
											<td>'.$noticia['user'].'</td>
											<td>'.$noticia['codigo'].'</td>
											<td>'.$noticia['qnt'].'</td>
											<td><form action="" name="deletanoticia" method="POST"><input type="hidden" name="idnoticia" value="'.$noticia["id"].'"><input type="submit"  name="deletanoticia" value="Remover"  class="btn btn-danger" style="padding: 5px;"/></span></form></td>
											</tr>';
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