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
								<h5>Atualização de Banco de Dados</h5>
								<span>A atualização postada será exibida a todos os clientes.</a></span>
								<div class="card-header-right"><i class="icofont icofont-spinner-alt-5"></i></div>
								<div class="card-header-right">
									<i class="icofont icofont-spinner-alt-5"></i>
								</div>
							</div>
							<div class="card-block">
								<?php
								if (isset($_POST['postar']))
								{
									$selecionatodos = $PDO->prepare("INSERT INTO `att_db` (`tipo`, `page_id`, `sql`, `titulo`, `mensagem`, `user`, `data`) VALUES (:tipo, :1, :aa, :aa2, :aa3, :phb, :2);");
									$selecionatodos->bindValue(':tipo', $_POST['tipo']);
									$selecionatodos->bindValue(':1', $_POST['pageid']);
									$selecionatodos->bindValue(':aa', $_POST['sql']);
									$selecionatodos->bindValue(':aa2', $_POST['titulo']);
									$selecionatodos->bindValue(':aa3', $_POST['noticia']);
									$selecionatodos->bindValue(':phb', $_SESSION['useradmin']);
									$selecionatodos->bindValue(':2', time());
									$selecionatodos->execute();
									echo '<div class="alert alert-info background-info">
									<strong>Sucesso!</strong> Atualização postada com sucesso.
									</div>';

									addlog_admin($_SESSION['useradmin'], "Atualização postada");


								}
								?>
								<form method="POST">
									<div class="form-group row">
										<label class="col-sm-2 col-form-label">SQL</label>
										<div class="col-sm-10">
											<select class="form-control" name="tipo">
												<option value="mobi">Mobi</option>
												<option value="sql">SQL</option>
											</select>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-2 col-form-label">Título da atualização</label>
										<div class="col-sm-10">
											<input class="form-control" type="text" name="titulo" placeholder="Título">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-2 col-form-label">Page ID</label>
										<div class="col-sm-10">
											<input class="form-control" type="text" name="pageid" placeholder="Page ID">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-2 col-form-label">Mensagem</label>
										<div class="col-sm-10">
											<textarea class="form-control" name="noticia" placeholder="Mensagem" rows="15" cols="80"></textarea>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-2 col-form-label">SQL</label>
										<div class="col-sm-10">
											<textarea class="form-control" name="sql" placeholder="sql" rows="15" cols="80"></textarea>
										</div>
									</div>

									<center><button class="btn btn-primary" style="border-radius: 8px;" type="submit" name="postar" >Postar</button></center>
									<br>
								</form>

								<table id="autofill" class="table table-striped table-bordered nowrap dataTable" role="grid" aria-describedby="autofill_info">
									<thead>
										<tr role="row"><th class="sorting_asc" tabindex="0" aria-controls="autofill" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 143px;">ID</th>
											<th class="sorting" tabindex="0" aria-controls="autofill" rowspan="1" colspan="1" aria-label="Age: activate to sort column ascending" style="width: 47px;">Título</th>
											<th class="sorting" tabindex="0" aria-controls="autofill" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending" style="width: 79px;">Data</th>				
											<th class="sorting" tabindex="0" aria-controls="autofill" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending" style="width: 79px;">Remover</th>
										</tr>
									</thead>
									<tbody>
										<?php 
										if (isset($_POST['deleta']))
										{
											$apaganoticia = $PDO->prepare("DELETE FROM att_db WHERE id = ".$_POST['id']);
											$apaganoticia->execute();
											addlog_admin($_SESSION['useradmin'], "Apagou uma atualização de db.");
										}
										$vernoticias = $PDO->prepare("SELECT * FROM att_db ORDER BY id DESC");
										$vernoticias->execute();
										while($noticia = $vernoticias->fetch()){

											echo '																<tr>
											<th scope="row">'.$noticia['id'].'</th>
											<td>'.$noticia['titulo'].'</td>
											<td>'.date('d/m/y', $noticia['data']).'</td>
											<td><form action="" method="POST"><input type="hidden" name="id" value="'.$noticia["id"].'"><input type="submit"  name="deleta" value="Remover" /></span></form></td>
											</tr>';
										}
										?>
									</tbody>
									<tfoot>
									</tfoot>
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
<script src="<?php echo $dominio;?>/galaxyservers/bower_components/datatables.net/js/jquery.dataTables.min.js?"></script>
<script src="<?php echo $dominio;?>/galaxyservers/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo $dominio;?>/galaxyservers/assets/pages/data-table/js/jszip.min.js"></script>
<script src="<?php echo $dominio;?>/galaxyservers/assets/pages/data-table/js/pdfmake.min.js"></script>
<script src="<?php echo $dominio;?>/galaxyservers/assets/pages/data-table/js/vfs_fonts.js"></script>
<script src="<?php echo $dominio;?>/galaxyservers/assets/pages/data-table/extensions/autofill/js/dataTables.select.min.js"></script>
<script src="<?php echo $dominio;?>/galaxyservers/bower_components/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo $dominio;?>/galaxyservers/bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo $dominio;?>/galaxyservers/bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo $dominio;?>/galaxyservers/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo $dominio;?>/galaxyservers/bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo $dominio;?>/galaxyservers/assets/pages/data-table/extensions/autofill/js/extensions-custom.js"></script>
<script>
	CKEDITOR.replace( 'noticia' );
	

	CKEDITOR.replace( textarea );
</script>
</body>
</html>
<?php } ?>