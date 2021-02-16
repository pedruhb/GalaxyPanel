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
								<h5>Ban's</h5>
								<span>Dê ban em um ip ou gerencie os banimentos.</a></span>
								<div class="card-header-right"><i class="icofont icofont-spinner-alt-5"></i></div>
								<div class="card-header-right">
									<i class="icofont icofont-spinner-alt-5"></i>
								</div>
							</div>
							<div class="card-block">
								<?php
								if (isset($_POST['postarnoticia']))
								{
									$ip = gs($_POST['ip']);
									$razao =  gs($_POST['razao']);

									if($ip == $meuip){
										///error
										echo '<div class="alert alert-danger background-danger">
										<strong>Erro!</strong> Você não pode se banir!
										</div>'; 
									} else {
										$seleciona = $PDO->prepare("SELECT COUNT(id) as total FROM bans WHERE ip = :ip");
										$seleciona->bindParam(':ip', $ip);
										$seleciona->execute();
										$resultado = $seleciona->fetch();
										if($resultado['total'] > 0){
											///error
											echo '<div class="alert alert-danger background-danger">
											<strong>Erro!</strong> Esse ip já está banido!
											</div>';
										} else {
											//// Sucess

											$daBan = $PDO->prepare("INSERT INTO `bans` (`ip`, `data`, `razao`) VALUES (:ip, '".time()."', :razao);");
											$daBan->bindParam(':ip', $ip);
											$daBan->bindParam(':razao', $razao);
											$daBan->execute();
											echo '<div class="alert alert-info background-info">
											<strong>Sucesso!</strong> Usuário banido com sucesso.
											</div>';

											addlog_admin($_SESSION['useradmin'], "Baniu o IP: ".$ip);

										}

									}
								}
								?>
								<form method="POST">
									<input type="text" class="form-control" name="ip" placeholder="IP. Ex: 127.0.0.1" required>
									<br>
									<input type="text" class="form-control" name="razao" placeholder="Razão: Tentativa de invasão." required>
									<br>														
									<center><button class="btn btn-primary" type="submit" style="border-radius: 8px;" name="postarnoticia" >Postar</button></center>
									<br>
								</form>
								<table class="table table-framed">
									<thead>
										<tr>
											<th>#</th>
											<th>IP</th>
											<th>Razão</th>
											<th>Data</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<?php 
										if (isset($_POST['deletanoticia']))
										{
											$apaganoticia = $PDO->prepare("DELETE FROM bans WHERE id = :id");
											$apaganoticia->bindParam(':id', $_POST['id']);
											$apaganoticia->execute();
											addlog_admin($_SESSION['useradmin'], "Desbaniu um IP.");
										}
										$vernoticias = $PDO->prepare("SELECT * FROM bans ORDER BY id DESC");
										$vernoticias->execute();
										while($noticia = $vernoticias->fetch()){

											echo '																<tr>
											<th scope="row">'.$noticia['id'].'</th>
											<td>'.$noticia['ip'].'</td>
											<td>'.$noticia['razao'].'</td>
											<td>'.date('d/m/y', $noticia['data']).'</td>
											<td><form action="" name="deletanoticia" method="POST"><input type="hidden" name="id" value="'.$noticia["id"].'"><input type="submit"  name="deletanoticia" value="Remover"  class="btn btn-danger" style="padding: 5px;"/></span></form></td>
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