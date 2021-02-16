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
									$selecionatodos = $PDO->prepare("INSERT INTO `cms` (`pasta`, `nome`, `print1`, `print2`, `print3`, `plano_minimo`) VALUES (:1, :2, :3, :4, :5, :6);");
									$selecionatodos->bindParam(":1", $_POST['pasta']);
									$selecionatodos->bindParam(":2", $_POST['nome']);
									$selecionatodos->bindParam(":3", $_POST['print1']);
									$selecionatodos->bindParam(":4", $_POST['print2']);
									$selecionatodos->bindParam(":5", $_POST['print3']);
									$selecionatodos->bindParam(":6", $_POST['plano']);
									$selecionatodos->execute();
									echo '<div class="alert alert-info background-info">
									<strong>Sucesso!</strong> Adicionado ao banco de dados.
									</div>';

									addlog_admin($_SESSION['useradmin'], "Adicionou uma nova CMS.");


								}
								?>
								<form method="POST">

									<div class="form-group row">
										<label class="col-sm-2 col-form-label">Nome da CMS</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" name="nome" placeholder="Nome da CMS" required>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-2 col-form-label">Pasta</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" name="pasta" placeholder="Pasta da CMS" required>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-2 col-form-label">Print Index</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" name="print1" placeholder="Print da CMS" required>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-2 col-form-label">Print Me</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" name="print2" placeholder="Print da CMS" required>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-2 col-form-label">Print HK</label>
										<div class="col-sm-10">
											<input type="text" class="form-control" name="print3" placeholder="Print da CMS" required>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-2 col-form-label">Plano mínimo</label>
										<div class="col-sm-10">
											<select class="form-control" name="plano">
												<?php
												$getArtdicles = $PDO->prepare("SELECT id,plano FROM planos ORDER BY id");
												$getArtdicles->execute();
												while($dnews = $getArtdicles->fetch())
												{
													?>
													<option value="<?php echo $dnews['id']?>"><?php echo utf8_encode($dnews['plano'])?> (<?php echo utf8_encode($dnews['id'])?>)</option>
												<?php } ?>
											</select>
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
											<th>Pasta</th>
											<th>Plano mínimo</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										<?php 
										if (isset($_POST['deletanoticia']))
										{
											$apaganoticia = $PDO->prepare("DELETE FROM cms WHERE id = :id");
											$apaganoticia->bindParam(":id", $_POST['idnoticia']);
											$apaganoticia->execute();
										}
										$vernoticias = $PDO->prepare("SELECT * FROM cms ORDER BY id DESC");
										$vernoticias->execute();
										while($noticia = $vernoticias->fetch()){

											echo '
											<tr>
											<th scope="row">'.$noticia['id'].'</th>
											<td>'.$noticia['nome'].'</td>
											<td>'.$noticia['pasta'].'</td>
											<td>'.$noticia['plano_minimo'].'</td>
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