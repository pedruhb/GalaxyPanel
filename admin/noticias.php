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
								<h5>Notícia</h5>
								<span>A notícia postada será exibida a todos os clientes.</a></span>
								<div class="card-header-right"><i class="icofont icofont-spinner-alt-5"></i></div>
								<div class="card-header-right">
									<i class="icofont icofont-spinner-alt-5"></i>
								</div>
							</div>
							<div class="card-block">
								<?php
								if (isset($_POST['postarnoticia']))
								{
									$selecionatodos = $PDO->prepare("INSERT INTO `noticias` (`usuario`, `noticia`, `timestamp`) VALUES ('".$_SESSION['useradmin']."', :noticia, '".time()."');");
									$selecionatodos->bindParam(':noticia', $_POST['noticia']);
									$selecionatodos->execute();
									echo '<div class="alert alert-info background-info">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<i class="icofont icofont-close-line-circled text-white"></i>
									</button>
									<strong>Sucesso!</strong> Notícia postada com sucesso.
									</div>';

									addlog_admin($_SESSION['useradmin'], "Postou uma notícia.");


								}
								?>
								<form method="POST">
									<textarea name="noticia"  rows="15" cols="80"></textarea>
									<br>														
									<center><button class="btn btn-primary" style="border-radius: 8px;" type="submit" name="postarnoticia" >Postar</button></center>
									<br>
								</form>

								<table id="autofill" class="table table-striped table-bordered nowrap dataTable" role="grid" aria-describedby="autofill_info">
									<thead>
										<tr role="row"><th class="sorting_asc" tabindex="0" aria-controls="autofill" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 143px;">ID</th><th class="sorting" tabindex="0" aria-controls="autofill" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 236px;">Usuário</th><th class="sorting" tabindex="0" aria-controls="autofill" rowspan="1" colspan="1" aria-label="Age: activate to sort column ascending" style="width: 47px;">Notícia</th><th class="sorting" tabindex="0" aria-controls="autofill" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending" style="width: 79px;">Data</th>							
											<th class="sorting" tabindex="0" aria-controls="autofill" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending" style="width: 79px;">Remover</th>
										</tr>
									</thead>
									<tbody>
										<?php 
										if (isset($_POST['deletanoticia']))
										{
											$apaganoticia = $PDO->prepare("DELETE FROM noticias WHERE id = ".$_POST['idnoticia']);
											$apaganoticia->execute();
											addlog_admin($_SESSION['useradmin'], "Apagou uma notícia.");
										}
										$vernoticias = $PDO->prepare("SELECT * FROM noticias ORDER BY id DESC");
										$vernoticias->execute();
										while($noticia = $vernoticias->fetch()){

											echo '																<tr>
											<th scope="row">'.$noticia['id'].'</th>
											<td>'.$noticia['usuario'].'</td>
											<td>'.str_replace("<", "", str_replace(">", "", substr_replace(gs($noticia['noticia']), (strlen(gs($noticia['noticia'])) > '80' ? '...' : ''), '80'))).'</td>
											<td>'.date('d/m/y', $noticia['timestamp']).'</td>
											<td><form action="" name="deletanoticia" method="POST"><input type="hidden" name="idnoticia" value="'.$noticia["id"].'"><input type="submit"  name="deletanoticia" value="Remover" /></span></form></td>
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