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
						<div class="row">
							<div class="col-lg-12">
								<div class="tab-content">
									<div class="tab-pane active" role="tabpanel">
										<div class="card">
											<div class="card-header">
												<h5 class="card-header-text">Instalar player de rádio</h5>
												<span>O player é compatível com Shoutcast v2 e com as CMS's disponibilizadas pela GalaxyServers. Para comprar o Streaming clique <a target="_blank" href="http://cliente.galaxyservers.com.br/cart.php?gid=4">aqui</a>.</span>
											</div>
											<div class="card-block">
												<div>
													<?php
													set_time_limit(0);

													if(!permissao("playerradio")){
														echo '<div style="display: contents;">
														<div class="col-md-12">
														<center><div class="alert alert-danger background-danger" style="width: 30%;">
														<strong>Erro!</strong> Sua subconta não tem permissão para acessar essa página.
														</div></center>
														</div>
														</div>';
													} else {

														if (isset($_POST['instalar']))
														{
															$ip = $_POST['ipradio'];
															$ip = str_replace("http://", "", $ip);
															$ip = str_replace("https://", "", $ip);	
															$ip = str_replace("/", "", $ip);
															$ip = str_replace(":", "", $ip);
															$player = $_POST['player'];
															$porta = $_POST['portaradio'];	
															$porta = str_replace("/", "", $porta);
															$porta = str_replace(":", "", $porta);
															if(empty($ip)){
																echo '<div class="alert alert-danger background-danger">
																<strong>Erro!</strong> IP da rádio vazio.
																</div>';
															} else if(empty($porta)){
																echo '<div class="alert alert-danger background-danger">
																<strong>Erro!</strong> Porta da rádio vazio.
																</div>';
															} else {

																$linkhotel = str_replace("http:", "", str_replace("https:", "", str_replace("/", "", $server['linkhotel'])));

																/// Faz login no servidor ftp
																$con_id = ftp_connect($iphospedagem) or die( '<script>alert("Erro ao conectar no servidor")</script>');
																ftp_login( $con_id, $server['uservestacp'], $server['senhavestacp']);
																ftp_pasv($con_id, true) or die('<script>alert("Cannot switch to passive mode")</script>'); 

																/// Cria o arquivo de configuração com ip e senha do streaming
																$arquivo_configuracao = '<?php $ipp = "'.$ip.'"; $portphb = "'.$porta.'"; ?>';
																$nomearquivoc = "c:/xampp/htdocs/galaxyservers/emuladores/configcms.php";
																$fpc = fopen($nomearquivoc, "w");
																$escreve = fwrite($fpc, $arquivo_configuracao); 

																/// Apaga a pasta da rádio se ela existir
																function ftp_rdel ($handle, $path) {
																	if (@ftp_delete ($handle, $path) === false) {
																		if ($children = @ftp_nlist ($handle, $path)) {
																			foreach ($children as $p)
																				ftp_rdel ($handle,  $p);
																		}
																		@ftp_rmdir ($handle, $path);
																	}
																}
																if (ftp_nlist($con_id, './web/'.$linkhotel.'/public_html/templates/GalaxyServers/radio/') == true)
																	ftp_rdel($con_id, './web/'.$linkhotel.'/public_html/templates/GalaxyServers/radio/');
																
																/// Cria novamente a pasta rádio
																ftp_mkdir($con_id, '/web/'.$linkhotel.'/public_html/templates/GalaxyServers/radio');
																ftp_mkdir($con_id, '/web/'.$linkhotel.'/public_html/templates/GalaxyServers/radio/'.$player);

																/// Envia o arquivo de configuração da rádio
																ftp_put($con_id, '/web/'.$linkhotel.'/public_html/templates/GalaxyServers/radio/config.php', $nomearquivoc,FTP_BINARY);

																/// Limpa conteúdo do arquivo de configuração temporário
																$fpc = fopen($nomearquivoc, "w");
																$escreve = fwrite($fpc, "");

																/// Envia os arquivos do Player para o hotel
																$sourcedir="galaxyservers/player_radio/".$player."/"; 
																$ftpserver=$iphospedagem; 
																$ftpusername=$server['uservestacp']; 
																$ftppass=$server['senhavestacp']; 
																$ftpremotedir= '/web/'.$linkhotel.'/public_html/templates/GalaxyServers/radio/'.$player;
																$ftpconnect = ftp_connect($ftpserver); 
																$ftplogin = ftp_login($ftpconnect, $ftpusername, $ftppass); 
																ftp_pasv($ftpconnect, true) or die('<script>alert("Não foi possível alternar para o modo passivo")</script>'); 
																if((!$ftpconnect) || (!$ftplogin))  
																{ 
																	die('<script>alert("Não foi conectar ao servidor ftp")</script>'); 
																} 
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
																	@ob_flush(); 
																	flush(); 
																	ob_start(); 
																} 
																$from=getcwd(); 
																$fulldest=$from."\\$sourcedir"; 
																direction($fulldest); 

																/// Envia o código do player para o hotel
																ftp_put($con_id, '/web/'.$linkhotel.'/public_html/templates/GalaxyServers/radio/player.php','c:/xampp/htdocs/galaxyservers/player_radio/'.$player.'.php',FTP_BINARY);

																/// Insere o include do player na client do hotel
																$h = fopen('php://temp', 'r+');
																ftp_fget($con_id, $h, './web/'.$linkhotel.'/public_html/templates/GalaxyServers/client.php', FTP_BINARY, 0);
																$fstats = fstat($h);
																fseek($h, 0);
																$contentsclient = fread($h, $fstats['size']); 

																if(!empty($contentsclient))
																	$novaclient = $contentsclient.' <?= include "radio/player.php";?>';

																$nomearquivoc22 = $nomearquivoc;
																$fpc22 = fopen($nomearquivoc22, "w");
																$escreve = fwrite($fpc22, $novaclient." <!-- RadioVerGalaxyServers -->");

																$patternverifica = '/RadioVerGalaxyServers/';
																if (preg_match($patternverifica, $contentsclient)){
																	echo '<div class="alert alert-success background-success">
																	<strong>Sucesso!</strong> Player atualizado com sucesso.
																	</div>';
																} else if (ftp_put( $con_id, './web/'.$linkhotel.'/public_html/templates/GalaxyServers/client.php', $nomearquivoc22, FTP_BINARY  ) ) {
																	echo '<div class="alert alert-success background-success">
																	<strong>Sucesso!</strong> Player instalado com sucesso.
																	</div>';
																}

																/// Limpa conteúdo do arquivo de configuração temporário
																$fpc = fopen($nomearquivoc, "w");
																$escreve = fwrite($fpc, "");

															}
														}
														?>
														<form method="POST">
															<center>

																<div class="row">
																	<label class="col-sm-4 col-lg-2 col-form-label">Selecione o Player</label>
																	<div class="col-sm-8 col-lg-10">
																		<div class="input-group">
																			<select class="form-control" id="player" name="player" style="width: 18%">
																				<option value="playernormal">Player normal</option>
																				<option value="playergalaxia">Player galáxia</option>
																				<option value="playernatal">Player natal</option>	
																				<option value="playerhabblive">Player Habblive</option>																		<option value="playerneon">Player neon</option>				
																			</select>
																		</div>
																	</div>
																</div>

																<div class="row">
																	<label class="col-sm-4 col-lg-2 col-form-label">IP da Rádio</label>
																	<div class="col-sm-8 col-lg-10">
																		<div class="input-group">
																			<input type="text" name="ipradio" class="form-control" placeholder="IP do Shoutcast. Exemplo: stm1.galaxyservers.com.br" required>
																		</div>
																	</div>
																</div>

																<div class="row">
																	<label class="col-sm-4 col-lg-2 col-form-label">Porta Rádio</label>
																	<div class="col-sm-8 col-lg-10">
																		<div class="input-group">
																			<input type="text" name="portaradio" class="form-control" placeholder="Porta DJ do Shoutcast. ex: 8083" required>
																		</div>
																	</div>
																</div>
																<br>
																<button style="border-radius: 8px;" type="submit" name="instalar" class="btn btn-primary btn-square">Instalar</button>
															</form></center>
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