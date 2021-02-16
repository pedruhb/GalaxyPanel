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
							<?php
							if(isset($_SESSION['subconta'])){
								echo '<br><div style="display: contents;">
								<div class="col-md-12">
								<center><div class="alert alert-danger background-danger">
								<strong>Erro!</strong> Sua subconta não tem permissão para acessar essa página.
								</div></center>
								</div>
								</div>';
							} else { 

								$vst_username = $uservestacp;
								$vst_password = $passvestacp;
								$vst_command = 'v-list-user-backups';
								$username = $server['uservestacp'];
								$format = 'json';
								$postvars = array(
									'user' => $vst_username,
									'password' => $vst_password,
									'cmd' => $vst_command,
									'arg1' => $username,
									'arg2' => $format
								);
								$postdata = http_build_query($postvars);

								$postdata = http_build_query($postvars);
								$curl = curl_init();
								curl_setopt($curl, CURLOPT_URL, $vst_hostname);
								curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
								curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
								curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
								curl_setopt($curl, CURLOPT_POST, true);
								curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
								$answer = curl_exec($curl);
								$UserData = json_decode($answer, true);
								$Ksort = json_decode($answer, true);
								$UserData = array_reverse($UserData);
								ksort($Ksort);

								if(isset($_POST['download'])){

									$downloadname = $_POST['downloadname'];

									if(strpos("g".$downloadname, $server['uservestacp'])){

										$file_url = 'http://'.$iphospedagem.':8083/download/backup/?backup=' . $downloadname;

										echo '<meta http-equiv="refresh" content="0; url='.$file_url.'">';

									}
								}
								?>
								<div class="card-header">
									<h5>Backups</h5>
									<span>Nosso sistema guarda backups! faça o download aqui.</span>
								</div>
								<div class="card-block table-border-style">
									<div class="table-responsive">
										<table class="table table-framed">
											<thead>
												<tr>
													<th>Data</th>
													<th>Tempo de exec.</th>
													<th>Tamanho</th>
													<th>Download</th>
												</tr>
											</thead>
											<tbody>
												<?php
												foreach($UserData as $Username => $Array)
												{
													$data = explode('-', $Array['DATE']);
													$data = $data[2]."/".$data[1]."/".$data[0];

													$time = explode(":", $Array['TIME']);
													$time = $time[0].":".$time[1];

													echo '
													<tr>
													<td style="padding-top: 21px">'.$data.' '.$time.'</td>
													<td style="padding-top: 21px">'.$Array['RUNTIME'].' min</td>
													<td style="padding-top: 21px">'.$Array['SIZE'].'MB</td>
													<td><form name="download" method="POST"><input name="downloadname" value="'.$Username.'" type="hidden"><button type="submit" name="download" class="btn btn-info">Baixar</button></form></td>
													</tr>
													';
												} 
												?>
											</tbody>
										</table>
									</div>
								<?php }?>
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
</body>
</html><?php } else header('Location: ../index'); ?>