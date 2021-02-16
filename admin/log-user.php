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
								<h5>Logs de hotéis</h5>
								<div class="card-header-right"><i class="icofont icofont-spinner-alt-5"></i></div>
								<div class="card-header-right">
									<i class="icofont icofont-spinner-alt-5"></i>
								</div>
							</div>


							<div class="card-block">
								<div class="dt-responsive table-responsive" style="  overflow: hidden;">
									<div class="row">
										<div class="col-xs-12 col-sm-12">
											<table id="autofill" class="table table-striped table-bordered nowrap dataTable" role="grid" aria-describedby="autofill_info">
												<thead>
													<tr role="row"><th class="sorting_asc" tabindex="0" aria-controls="autofill" rowspan="1" colspan="1" aria-sort="descending" aria-label="Name: activate to sort column descending" style="width: 143px;">ID</th><th class="sorting_asc" tabindex="0" aria-controls="autofill" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 143px;">Log</th><th class="sorting" tabindex="0" aria-controls="autofill" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 236px;">IP</th><th class="sorting" tabindex="0" aria-controls="autofill" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" style="width: 102px;">Data</th>
														<th class="sorting" tabindex="0" aria-controls="autofill" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" style="width: 102px;">Usuário</th>
													</tr>
												</thead>
												<tbody>
													<?php 

													### deleta logs de 2 meses atrás
													$tempo_log = time()-5259600;
													$deletaLogs = $PDO->prepare("DELETE FROM log_servidores WHERE data < ".$tempo_log);
													$deletaLogs->execute();

													$verlogsadmin = $PDO->prepare("SELECT * FROM log_servidores order by id desc");
													$verlogsadmin->execute();
													while($logadmin = $verlogsadmin->fetch()){

														echo '																
														<tr>
														<th scope="row">'.$logadmin['id'].'</th>
														<th scope="row">'.$logadmin['log'].'</th>
														<td>'.$logadmin['ip'].'</td>
														<th scope="row">'.date('d/m/y H:i', $logadmin['data']).'</th>
														<td>'.$logadmin['autor'].'</td>
														</tr>';
													}
													?>
												</tbody>
												<tfoot>
												</tfoot>
											</table></div></div></div>
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

<script src="../galaxyservers/bower_components/datatables.net/js/jquery.dataTables.min.js?a"></script>
<script src="../galaxyservers/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="../galaxyservers/assets/pages/data-table/js/jszip.min.js"></script>
<script src="../galaxyservers/assets/pages/data-table/js/pdfmake.min.js"></script>
<script src="../galaxyservers/assets/pages/data-table/js/vfs_fonts.js"></script>
<script src="../galaxyservers/assets/pages/data-table/extensions/autofill/js/dataTables.select.min.js"></script>
<script src="../galaxyservers/bower_components/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="../galaxyservers/bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="../galaxyservers/bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../galaxyservers/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="../galaxyservers/bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<script src="../galaxyservers/assets/pages/data-table/extensions/autofill/js/extensions-custom.js"></script>


</body>
</html>
<?php } ?>