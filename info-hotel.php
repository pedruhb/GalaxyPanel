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
												<h5 class="card-header-text">Sobre o Hotel</h5>
											</div>
											<?php
											try {
												$PDO2 = new PDO('mysql:host='.$iphospedagem.';dbname='.$server['uservestacp']."_hotel", $server['uservestacp']."_hotel", $server['senhavestacp']);
												$PDO2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

												$infoserver2 = $PDO2->prepare("SELECT (SELECT users_online FROM server_status) as userson, (select count(id) from users) as usertotal, (select loaded_rooms from server_status) as quartoscarregados, (select record_on from server_status) as recordon, (select uptime from server_status) as uptime, (select ultimaatualizacao from server_status) as ultimaatualizacao, (SELECT VERSION()) as mysql_version");
												$infoserver2->execute();
												$informacao = $infoserver2->fetch();

											} catch(PDOException $e) {
												echo '<script>alert("Erro de conexão ao hotel: ' . utf8_encode($e->getMessage()).'");</script>';

												$informacao['userson'] = 0;
												$informacao['usertotal'] = 0;
												$informacao['quartoscarregados'] = 0;
												$informacao['recordon'] = 0;
												$informacao['ultimaatualizacao'] = 0;
												$informacao['uptime']= 0;
											}


											$infoserver22 = $PDO->prepare("SELECT count(id) as totalemblema from emblemas where usuario = '".$server['uservestacp']."'");
											$infoserver22->execute();
											$informacao2 = $infoserver22->fetch();

											if(!permissao("infohotel")){
												echo '<div style="display: contents;">
												<div class="col-md-12">
												<center><div class="alert alert-danger background-danger" style="width: 30%;">
												<strong>Erro!</strong> Sua subconta não tem permissão para acessar essa página.
												</div></center>
												</div>
												</div>';
											} else {
												?>
												<div class="card-block">
													<div class="view-info">
														<div class="row">
															<div class="col-lg-12">
																<div class="general-info">
																	<div class="row">
																		<div class="col-lg-12 col-xl-6">
																			<div class="table-responsive">
																				<table class="table m-0">
																					<tbody>
																						<tr>
																							<th scope="row">Usuários Online</th>
																							<td><?php echo $informacao['userson']; ?></td>
																						</tr>
																						<tr>
																							<th scope="row">Quartos Carregados</th>
																							<td><?php echo $informacao['quartoscarregados']; ?></td>
																						</tr>
																						<tr>
																							<th scope="row">Record de onlines</th>
																							<td><?php echo $informacao['recordon']; ?></td>
																						</tr>
																						<tr>
																							<th scope="row">Uptime do Emulador</th>
																							<td><?php echo $informacao['uptime']; ?></td>
																						</tr>
																						<tr>
																							<th scope="row">Última build</th>
																							<td><?php echo $informacao['ultimaatualizacao']; ?></td>
																						</tr>
																						<?php
// Server credentials

																						$vst_username = $uservestacp;
																						$vst_password = $passvestacp;
																						$vst_command = 'v-list-user';

// Account
																						$username = $server['uservestacp'];
																						$format = 'json';

// Prepare POST query
																						$postvars = array(
																							'user' => $vst_username,
																							'password' => $vst_password,
																							'cmd' => $vst_command,
																							'arg1' => $username,
																							'arg2' => $format
																						);
																						$postdata = http_build_query($postvars);

// Send POST query via cURL
																						$postdata = http_build_query($postvars);
																						$curl = curl_init();
																						curl_setopt($curl, CURLOPT_URL, $vst_hostname);
																						curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
																						curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
																						curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
																						curl_setopt($curl, CURLOPT_POST, true);
																						curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
																						$answer = curl_exec($curl);
//echo $answer;
																						$pegavalores = explode('"', $answer);

																						function bytesToSize($bytes) {
																							$sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
																							if ($bytes == 0) return 'n/a';
																							$i = intval(floor(log($bytes) / log(1024)));
																							if ($i == 0) return $bytes . ' ' . $sizes[$i]; 
																							return round(($bytes / pow(1024, $i)),1,PHP_ROUND_HALF_UP). ' ' . $sizes[$i];
																						}

//echo '<br><br><br><br>';
//echo "Limite em megabytes: ".$pegavalores[65];
//echo "<br>Usado em megabytes: ".$pegavalores[141];
//echo "<br>";
																						$porcentagem = explode('.', ($pegavalores[65] - $pegavalores[141])/$pegavalores[65] * 100);
																						$porcentagem = $porcentagem['0']/100;
																						?>

																						<tr>
																							<th scope="row">Uso de espaço (<?php echo $porcentagem;?>% de <?php echo bytesToSize($pegavalores[65].'000000'); ?>)</th>
																							<td>
																								<div class="progress" style="
																								width: 160px;
																								">
																								<div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $porcentagem;?>"
																									aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $porcentagem;?>%">
																									<?php echo $porcentagem;?>% de <?php echo bytesToSize($pegavalores[65].'000000'); ?>
																								</div>
																							</div>
																						</td>
																						<tr>
																							<th scope="row">Protocolo</th>
																							<td><?php echo $server['http'];?>://</td>
																						</tr>
																					</tr>
																				</tbody>
																			</table>
																		</div>
																	</div>
																	<div class="col-lg-12 col-xl-6">
																		<div class="table-responsive">
																			<table class="table">
																				<tbody>
																					<tr>
																						<th scope="row">Versão do PHP</th>
																						<td>5.6.36</td>
																					</tr>
																					<tr>
																						<th scope="row">Versão do MySQL</th>
																						<td><?php echo $informacao['mysql_version']; ?></td>
																					</tr>
																					<tr>
																						<th scope="row">Sistema Operacional</th>
																						<td>CentOS 7 e Windows Server</td>
																					</tr>
																					<tr>
																						<th scope="row">Emblemas upados</th>
																						<td><?php echo $informacao2['totalemblema'];?></td>
																					</tr>
																					<tr>
																						<th scope="row">Link</th>
																						<td><a href="<?= $server['http']?>://<?= str_replace("https://", "", str_replace("http://", "", $server['linkhotel']));?>" target="_blank"><?= $server['http']?>://<?= str_replace("https://", "", str_replace("http://", "", $server['linkhotel']));?></a></td>
																					</tr>
																					<tr>
																						<th scope="row">Uso de banda</th>
																						<td><?php 

																						echo bytesToSize($pegavalores[161].'000000');
																						?>.</td>
																					</tr>
																				</tbody>
																			</table>
																		</div>
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