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
								<h5>Tutorial</h5>
								<div class="card-header-right"><i class="icofont icofont-spinner-alt-5"></i></div>
								<div class="card-header-right">
									<i class="icofont icofont-spinner-alt-5"></i>
								</div>
							</div>
							<div class="card-block">
								<?php
								if (isset($_POST['postarnoticia']))
								{
									$selecionatodos = $PDO->prepare("INSERT INTO `tutoriais` (`user`, `titulo`, `post`, `data`) VALUES ('".$_SESSION['useradmin']."', :titulo, :tutorial, '".time()."');");
									$selecionatodos->bindParam(':tutorial', $_POST['tutorial']);
									$selecionatodos->bindParam(':titulo', $_POST['titulo']);
									$selecionatodos->execute();
									echo '<div class="alert alert-info background-info">
									<strong>Sucesso!</strong> Tutorial postado com sucesso.
									</div>';

										addlog_admin($_SESSION['useradmin'], "Postou um tutorial.");

								}
								?>
								<form method="POST">
									Título
									<input type="text" class="form-control" name="titulo" placeholder="Título do tutorial." required>
									<br>				
									<textarea name="tutorial"  rows="15" cols="80"></textarea>
									<br>										
									<center><button class="btn btn-primary" style="border-radius: 8px;" type="submit" name="postarnoticia" >Postar</button></center>
									<br>
								</form>
								<table class="table table-framed">
									<thead>
										<tr>
											<th>#</th>
											<th>Usuário</th>
											<th>Título</th>
											<th>Data</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<?php 
										if (isset($_POST['deletanoticia']))
										{
											$apaganoticia = $PDO->prepare("DELETE FROM tutoriais WHERE id = ".$_POST['idnoticia']);
											$apaganoticia->execute();
											addlog_admin($_SESSION['useradmin'], "Apagou um tutorial.");
										}
										$vernoticias = $PDO->prepare("SELECT * FROM tutoriais ORDER BY id DESC");
										$vernoticias->execute();
										while($noticia = $vernoticias->fetch()){

											echo '																<tr>
											<th scope="row">'.$noticia['id'].'</th>
											<td>'.$noticia['user'].'</td>
											<td>'.$noticia['titulo'].'</td>
											<td>'.date('d/m/y', $noticia['data']).'</td>
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
<script src="https://cdn.ckeditor.com/4.9.2/full-all/ckeditor.js"></script>
  <script>
    CKEDITOR.replace( 'tutorial' );
    

CKEDITOR.replace( textarea );
  </script>
</body>
</html>
<?php } ?>