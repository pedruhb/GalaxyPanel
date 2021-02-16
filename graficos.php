<?php
include "galaxyservers/global.php";
if(!empty($_SESSION['nomeusuario'])){

	$infoserver = $PDO->prepare("SELECT * FROM servidores WHERE nomeusuario = '".$_SESSION['nomeusuario']."'");
	$infoserver->execute();
	$server = $infoserver->fetch();
	$_SESSION['senhaatualdb'] = $server['senhavestacp'];

	?>
	<?php include 'galaxyservers/nav.php';?>
	<div class="pcoded-content">
		<div class="pcoded-inner-content">
			<div class="main-body user-profile">
				<div class="page-wrapper">
					<div class="page-body">
						<div class="card">
							<div class="card-header">
								<h5>Gráficos</h5>
								<span>Confira aqui o histórico de usuários online e quartos carregados de hotel.</span>
							</div>
							<div class="card-block">


								<script>
									window.onload = function() {
										var chart = new CanvasJS.Chart("chartContainer", {
											animationEnabled: true,
											theme: "light2",
											zoomEnabled: true,
											data: [{
												type: "spline",
												name: "Usuários online",
												connectNullData: true,
												showInLegend: true,
												color: "#5985ee",
												dataPoints: [
												<?php
												date_default_timezone_set('America/Sao_Paulo');
												try{
													$emblemas = $PDO2->prepare("SELECT * FROM graficos_galayservers order by id LIMIT 1000 ");
													$emblemas->execute();
													while($emblema = $emblemas->fetch()){ 

														$timestamp = $emblema["timestamp"];

														$data = date('d', $emblema["timestamp"]).'/'.date('m', $emblema["timestamp"]).'/'.date('y', $emblema["timestamp"])." ".date('H', $emblema["timestamp"]).":".date('i', $emblema["timestamp"]);

														echo '{ label: "'.$data.'",  y: '.$emblema['onlines'].'  },';
													}
												}
												catch(Exception $e){
													echo "<script>alert('Erro ao obter, caso você não tenha atualizado, atualize seu banco de dados para utilizar essa função.');</script>";
												}
												?>

												]
											},
											{
												type: "spline",
												name: "Quartos carregados",
												connectNullData: true,
												showInLegend: true,
												color: "#e66793",
												dataPoints: [
												<?php
												date_default_timezone_set('America/Sao_Paulo');
												try{
													$emblemas = $PDO2->prepare("SELECT * FROM graficos_galayservers order by id LIMIT 1000 ");
													$emblemas->execute();
													while($emblema = $emblemas->fetch()){ 

														$timestamp = $emblema["timestamp"]-10800;

														$data = date('d', $timestamp).'/'.date('m', $timestamp).'/'.date('y', $timestamp)." ".date('H', $timestamp).":".date('i', $timestamp);

														echo '{ label: "'.$data.'",  y: '.$emblema['quartos'].'  },';
													}
												}
												catch(Exception $e){
													echo "<script>alert('Erro ao obter, caso você não tenha atualizado, atualize seu banco de dados para utilizar essa função.');</script>";
												}
												?>

												]
											}],
										});
										chart.render();
									}
								</script>
							</head>
							<body>
								<div id="chartContainer" style="height: 370px; width: 100%;"></div>
								<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
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
<script type="text/javascript" src="galaxyservers/bower_components/jquery/js/jquery.min.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/jquery-ui/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/popper.js/js/popper.min.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/jquery-slimscroll/js/jquery.slimscroll.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/modernizr/js/modernizr.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/modernizr/js/css-scrollbars.js"></script>
<script src="galaxyservers/assets/pages/jquery.filer/js/jquery.filer.min.js"></script>
<script src="galaxyservers/assets/pages/filer/custom-filer.js" type="text/javascript"></script>
<script src="galaxyservers/assets/pages/filer/jquery.fileuploads.init.js?a=a" type="text/javascript"></script>
<script type="text/javascript" src="galaxyservers/bower_components/i18next/js/i18next.min.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/i18next-xhr-backend/js/i18nextXHRBackend.min.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/i18next-browser-languagedetector/js/i18nextBrowserLanguageDetector.min.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/jquery-i18next/js/jquery-i18next.min.js"></script>
<script src="galaxyservers/assets/js/pcoded.min.js"></script>
<script src="galaxyservers/assets/js/demo-12.js"></script>
<script src="galaxyservers/assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script type="text/javascript" src="galaxyservers/assets/js/script.js"></script>
<script src="galaxyservers/bower_components/datatables.net/js/jquery.dataTables.min.js?a"></script>
<script src="galaxyservers/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="galaxyservers/assets/pages/data-table/js/jszip.min.js"></script>
<script src="galaxyservers/assets/pages/data-table/js/pdfmake.min.js"></script>
<script src="galaxyservers/assets/pages/data-table/js/vfs_fonts.js"></script>
<script src="galaxyservers/assets/pages/data-table/extensions/autofill/js/dataTables.select.min.js"></script>
<script src="galaxyservers/bower_components/datatables.net-buttons/js/buttons.print.min.js"></script>
<script src="galaxyservers/bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="galaxyservers/bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="galaxyservers/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="galaxyservers/bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
</body>
</html><?php } else header('Location: ../index'); ?>