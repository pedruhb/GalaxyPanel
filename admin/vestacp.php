<?php include "../galaxyservers/global.php";
if(empty($_SESSION['useradmin'])){
	echo '<script>location.href="index";</script>';
}
if (!empty($_SESSION['useradmin'])){

	include "nav.php";
	?>
	<div class="pcoded-content">
		<iframe src="https://<?= $iphospedagem;?>:8083" style=" top:0px; left:0px; bottom:0px; right:0px; width:100%; height:1000px; border:none; margin:0; padding:0; overflow:hidden; z-index:;"></iframe>
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