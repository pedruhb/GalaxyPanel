
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
								<h5>Hotéis</h5>
								<span>Aqui você poderá ver, editar ou suspender os hotéis.</span>
								<?php
								$containserts = $PDO->prepare("SELECT COUNT(id) as total,(SELECT COUNT(id) FROM servidores WHERE ativo = 'Y') as totalativos,(SELECT COUNT(id) FROM servidores WHERE ativo = 'N' ) as totaldesativados FROM servidores");
								$containserts->execute();
								$conta2 = $containserts->fetch();
								if (isset($_POST['apagaremu']))
								{
									if($_POST["ativo"] == 'Y'){
										$apagaref1 = $PDO->prepare("UPDATE servidores SET ativo='N' where id = :id");
										$apagaref1->bindValue(":id", $_POST['id']);
										$apagaref1->execute();
										sendRCONCommand('desligaremulador', '', $ipvps, $_POST['mus']);
										echo '<div class="alert alert-info background-info">
										<strong>Sucesso!</strong> O hotel foi suspenso.</code>
										</div>'; 
										$pegahp = $PDO->prepare("SELECT nomeusuario FROM servidores WHERE id = :id");
										$pegahp->bindValue(":id", $_POST['id']);
										$pegahp->execute();
										$hp = $pegahp->fetch()['nomeusuario'];
										$pegahp = $PDO->prepare("SELECT nomeusuario,uservestacp FROM servidores WHERE id = :id");
										$pegahp->bindValue(":id", $_POST['id']);
										$pegahp->execute();
										$hp = $pegahp->fetch();
										addlog_admin($_SESSION['useradmin'], "Desativou o hotel \"".$hp['nomeusuario']."\".");
      									### API VESTA CP									
										$postvars = array(
											'user' => $uservestacp,
											'password' => $passvestacp,
											'returncode' => 'yes',
											'cmd' => 'v-suspend-user',
											'arg1' => $hp['uservestacp']
										);
										$postdata = http_build_query($postvars);
      									// Unsusupend user account
										$curl = curl_init();
										curl_setopt($curl, CURLOPT_URL, $vst_hostname);
										curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
										curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
										curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
										curl_setopt($curl, CURLOPT_POST, true);
										curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
										$answer = curl_exec($curl);
      									################
									} else if($_POST["ativo"] == 'N'){
										$apagaref1 = $PDO->prepare("UPDATE servidores SET ativo='Y' where id = :id");
										$apagaref1->bindValue(":id", $_POST['id']);
										$apagaref1->execute();
										echo '<div class="alert alert-info background-info">
										<strong>Sucesso!</strong> O hotel foi ativado.</code>
										</div>'; 
										$pegahp = $PDO->prepare("SELECT nomeusuario,uservestacp,senhavestacp FROM servidores WHERE id = :id");
										$pegahp->bindValue(":id", $_POST['id']);
										$pegahp->execute();
										$hp = $pegahp->fetch();
										addlog_admin($_SESSION['useradmin'], "Ativou o hotel \"".$hp['nomeusuario']."\".");
      									### API VESTA CP									
										$postvars = array(
											'user' => $uservestacp,
											'password' => $passvestacp,
											'returncode' => 'yes',
											'cmd' => 'v-unsuspend-user',
											'arg1' => $hp['uservestacp']
										);
										$postdata = http_build_query($postvars);
      									// Unsusupend user account
										$curl = curl_init();
										curl_setopt($curl, CURLOPT_URL, $vst_hostname);
										curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
										curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
										curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
										curl_setopt($curl, CURLOPT_POST, true);
										curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
										$answer = curl_exec($curl);
      									#################
      									### API VESTA CP									
										$postvars = array(
											'user' => $uservestacp,
											'password' => $passvestacp,
											'returncode' => 'yes',
											'cmd' => 'v-change-database-password',
											'arg1' => $hp['uservestacp'],
											'arg2' => $hp['uservestacp'].'_hotel',
											'arg3' => $hp['senhavestacp']
										);
										$postdata = http_build_query($postvars);
       									// Alter Password Database MYSQL
										$curl = curl_init();
										curl_setopt($curl, CURLOPT_URL, $vst_hostname);
										curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
										curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
										curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
										curl_setopt($curl, CURLOPT_POST, true);
										curl_setopt($curl, CURLOPT_POSTFIELDS, $postdata);
										$answer = curl_exec($curl);
      									#################
									}									
								}
								?>								
								<span>Total de Emuladores: <?php echo $conta2['total'];?> | Ativos: <?php echo $conta2['totalativos'];?> | Desativados: <?php echo $conta2['totaldesativados'];?></span>
								<div class="card-header-right"><i class="icofont icofont-spinner-alt-5"></i></div>
								<div class="card-header-right">
									<i class="icofont icofont-spinner-alt-5"></i>
								</div>
							</div>
							<div class="card-block">
								<div class="card-block table-border-style">
									<div class="table-responsive">
										<table id="autofill" class="table">
											<thead>
												<tr>
													<th>#</th>
													<th>Usuário</th>
													<th>Hotel</th>
													<th>Email</th>
													<th>Portas</th>
													<th>Criação</th>
													<th>Plano</th>
													<th></th>
													<th></th>
												</tr>
											</thead>
											<tbody>
												<?php
												$containserts2 = $PDO->prepare("SELECT * FROM servidores ORDER BY id DESC");
												$containserts2->execute();
												while($conta = $containserts2->fetch()){
													if($conta['ativo'] == 'Y'){
														$block = "SUSPENDER";
														$ativo = "Sim";
														$class = "btn btn-danger";
														$pagina = "gerenciar";
													}
													else {
														$block = "ATIVAR";
														$ativo = "Não";
														$class = "btn btn-info";
														$pagina = "editar";
													}
													echo '<tr>
													<th scope="row">'.$conta['id'].'</th>
													<td><a href="acessarcomouser/'.$conta['nomeusuario'].'">'.$conta['nomeusuario'].'</a></td>
													<td><a target="_blank" href="'.$conta['http'].'://'.$conta['linkhotel'].'">'.$conta['nomehotel'].'</a></td>
													<td>'.$conta['emailcliente'].'</td>
													<td>T '.$conta['portatcp'].' | M '.$conta['portamus'].'</td>
													<td>'.date('d/m/y', $conta['criadoem']).'</td>
													<td>'.$conta['plano'].'</td>
													<td><form action="" name="apagaremu" method="POST"><input type="hidden" name="id" value="'.$conta["id"].'"><input type="hidden" name="mus" value="'.$conta["portamus"].'"><input type="hidden" name="ativo" value="'.$conta['ativo'].'"><input type="submit" class="'.$class.'" style=" padding: 5px; " name="apagaremu" value="'.$block.'" /></form></td>
													<td><a href="'.$pagina.'/'.$conta['id'].'" title="Editar"><button class="btn btn-info btn-icon"><i class="icofont icofont-edit" style="padding-left: 5px;"></i></button></a></td>
													</tr>';
												}
												?>
											</tbody>
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