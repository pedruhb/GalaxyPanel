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
							<?php
							$caminho = "../galaxyservers/error_log";
							if(isset($_POST['limparlog'])){
								$fpc = fopen($caminho, "w");
								$escreve = fwrite($fpc, "");
							}
							?>
							<h5 class="card-header-text">Error log do painel</h5>
							<form method="POST">
								<button name="limparlog" style="float:right;background-color: #4680ff;border-color: #4680ff;color: #fff;cursor: pointer;display: inline-block;font-weight: 400;text-align: center;white-space: nowrap;vertical-align: middle;-webkit-user-select: none;-moz-user-select: none;-ms-user-select: none;user-select: none;border: 1px solid transparent;padding: .5rem .75rem;font-size: 1rem;line-height: 1.25;border-radius: .25rem;transition: all .15s ease-in-out;" type="submit">Limpar Logs</button>																</form>
							</div>
							<div class="card-block">
								<div class="view-info">
									<div class="row">
										<div>
											<textarea id="elemento" style="margin-top: 0px;margin-bottom: 0px;height: 700px;width: 991px;border:  none; background-color: white" disabled><?php echo utf8_encode(file_get_contents($caminho)); ?></textarea>
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