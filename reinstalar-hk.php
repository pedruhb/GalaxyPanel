<?php
include "galaxyservers/global.php";
if(!empty($_SESSION['nomeusuario'])){

	$infoserver = $PDO->prepare("SELECT * FROM servidores WHERE nomeusuario = '".$_SESSION['nomeusuario']."'");
	$infoserver->execute();
	$server = $infoserver->fetch();
	$_SESSION['senhaatualdb'] = $server['senhavestacp'];

	?>
	<?php 
	include 'galaxyservers/nav.php';
	if($planoi['galaxyhk'] == "false"){
		if (headers_sent()) {
			die("<script>window.location.href=/index</script>");
		}
		else{
			exit(header("Location: /index"));
		}
		return;
	}
	?>
	<div class="pcoded-content">
		<div class="pcoded-inner-content">
			<div class="main-body user-profile">
				<div class="page-wrapper">
					<div class="page-body">
						<div class="row">
							<div class="col-lg-12">
								<div class="tab-content">
									<div class="tab-pane active" role="tabpanel">
										<div class="card">
											<div class="card-header">
												<h5 class="card-header-text">Reinstalar HK</h5>
												<span>Instale a versão mais recente do GalaxyHK.</span>
											</div>
											<div class="card-block">

												<div>

													<?php
													if(!permissao("recms")){
														echo '<div style="display: contents;">
														<div class="col-md-12">
														<center><div class="alert alert-danger background-danger" style="width: 30%;">
														<strong>Erro!</strong> Sua subconta não tem permissão para acessar essa página.
														</div></center>
														</div>
														</div>';
													} else {

														if (isset($_POST['reinstalar']))
														{

															if($_POST['senha'] != $server['senhavestacp']){
																echo '<div class="alert alert-danger background-danger">
																<strong>Erro!</strong> sua senha está inválida.
																</div>';
															}
															else {
																$linkhotel = str_replace("http:", "", str_replace("https:", "", str_replace("/", "", $server['linkhotel'])));
																error_reporting(1);
																ini_set('memory_limit', '-1');
																ob_start(); 
																set_time_limit(0); 
																$sourcedir="galaxyservers/galaxycms/galaxyhk/"; 
																$ftpserver=$iphospedagem; 
																$ftpusername=$server['uservestacp'];  
																$ftppass=$server['senhavestacp']; 
																$ftpremotedir= 'web/'.$linkhotel.'/public_html/adminpan'; 
																$ftpconnect = ftp_connect($ftpserver); 
																$ftplogin = ftp_login($ftpconnect, $ftpusername, $ftppass); 
																ftp_pasv($ftpconnect, true) or die('<script>alert("Cannot switch to passive mode")</script>'); 
																if((!$ftpconnect) || (!$ftplogin))  
																{ 
																	echo '<div class="alert alert-danger background-danger">
																	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
																	<i class="icofont icofont-close-line-circled text-white"></i>
																	</button>
																	<strong>Erro!</strong> Não foi possível conectar.
																	</div>'; 
																	die(); 
																} 
																function ftp_rdel ($handle, $path) {

																	if (@ftp_delete ($handle, $path) === false) {

																		if ($children = @ftp_nlist ($handle, $path)) {
																			foreach ($children as $p)
																				ftp_rdel ($handle,  $p);
																		}

																		@ftp_rmdir ($handle, $path);
																	}
																}
																if (ftp_nlist($ftpconnect, './web/'.$linkhotel.'/public_html/adminpan/') == true) {
																	ftp_rdel($ftpconnect, './web/'.$linkhotel.'/public_html/adminpan/');
																}
																ftp_mkdir($ftpconnect, '/web/'.$linkhotel.'/public_html/adminpan/');
																function direction($dirname) 
																{ 
																	global $from,$fulldest,$ftpremotedir,$ftpconnect,$ftpremotedir; 
																	chdir($dirname."\\"); 
																	$directory = opendir("."); 
																	while($information=readdir($directory))  
																	{ 
																		if ($information!='.' and $information!='..' and $information!="Thumbs.db") 
																		{  
																			$readinfo="$dirname\\$information"; 
																			$localfil=str_replace("".$from."\\","",$dirname).""; 
																			$localfold="$localfil\\$information"; 
																			$ftpreplacer=str_replace(array("\\\\","\\"),array("/","/"),"$ftpremotedir\\".str_replace("".$fulldest."","",$dirname)."\\$information"); 

																			if(!is_dir($information)) 
																			{ 
																				$loading = ftp_put($ftpconnect, $ftpreplacer, $readinfo, FTP_BINARY); 
																			} 
																			else 
																			{  
																				ftp_mkdir($ftpconnect, $ftpreplacer); 
																				direction("$dirname\\$information"); 
																				chdir($dirname."\\"); 
																				fls(); 
																			} 
																		} 
																	} 
																	closedir ($directory); 
																} 
																function fls() 
																{ 
																	ob_end_flush(); 
																	ob_flush(); 
																	flush(); 
																	ob_start(); 
																} 
																$from=getcwd(); 
																$fulldest=$from."\\$sourcedir"; 
																direction($fulldest); 
																ftp_close($ftpconnect); 
																echo '<div class="alert alert-success background-success">
																<button type="button" class="close" data-dismiss="alert" aria-label="Close">
																<i class="icofont icofont-close-line-circled text-white"></i>
																</button>
																<strong>Sucesso!</strong> HK reinstalado.
																</div>';

																addlog('Reinstalou o HK.');

																$PDO2 = new PDO('mysql:host='.$iphospedagem.';dbname='.$server['uservestacp']."_hotel", $server['uservestacp']."_hotel", $server['senhavestacp']);								
																$excluitabelas2 = $PDO2->prepare("DROP TABLE IF EXISTS `logs_hk`;");
																$excluitabelas2->execute();
																$inseretabelas = $PDO2->prepare("CREATE TABLE IF NOT EXISTS `logs_hk` (
																	`id` int(11) NOT NULL AUTO_INCREMENT,
																	`log` varchar(200) DEFAULT NULL,
																	`user` int(11) DEFAULT NULL,
																	`data` int(11) DEFAULT NULL,
																	PRIMARY KEY (`id`)
																) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;");
																$inseretabelas->execute();
															}
														}
														?>
														<center>
															<?php if($server['plano'] == "6")echo "Não reinstale se você utilizar a Space CMS.<br><br>";?>
															<form method="POST">
																<div class="row">
																	<label class="col-sm-4 col-lg-2 col-form-label">Confirme sua senha</label>
																	<div class="col-sm-8 col-lg-10">
																		<div class="input-group">
																			<input type="password" name="senha" class="form-control" placeholder="Confirme a sua senha para realizar a reinstalação." required>
																		</div>
																	</div>
																</div>


																<button type="submit" name="reinstalar" style="border-radius: 8px;" class="btn btn-primary btn-square" onclick="return confirm('Tem certeza que deseja reinstalar o HK?')">Reinstalar</button>
															</form>
														</center>
													</div>
													</div><?php }?>
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
<script type="text/javascript" src="galaxyservers/bower_components/jquery/js/jquery.min.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/jquery-ui/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/popper.js/js/popper.min.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/jquery-slimscroll/js/jquery.slimscroll.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/modernizr/js/modernizr.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/modernizr/js/css-scrollbars.js"></script>
<script type="text/javascript" src="galaxyservers/assets/pages/advance-elements/moment-with-locales.min.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="galaxyservers/assets/pages/advance-elements/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/bootstrap-daterangepicker/js/daterangepicker.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/datedropper/js/datedropper.min.js"></script>
<script src="galaxyservers/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="galaxyservers/bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="galaxyservers/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="galaxyservers/bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<script src="galaxyservers/assets/pages/ckeditor/ckeditor.js"></script>
<script src="galaxyservers/assets/pages/chart/echarts/js/echarts-all.js" type="text/javascript"></script>
<script type="text/javascript" src="galaxyservers/bower_components/i18next/js/i18next.min.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/i18next-xhr-backend/js/i18nextXHRBackend.min.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/i18next-browser-languagedetector/js/i18nextBrowserLanguageDetector.min.js"></script>
<script type="text/javascript" src="galaxyservers/bower_components/jquery-i18next/js/jquery-i18next.min.js"></script>
<script src="galaxyservers/assets/pages/user-profile.js"></script>
<script src="galaxyservers/assets/js/pcoded.min.js"></script>
<script src="galaxyservers/assets/js/demo-12.js"></script>
<script src="galaxyservers/assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script type="text/javascript" src="galaxyservers/assets/js/script.js"></script>
</body>
</html><?php } else header('Location: ../index'); ?>