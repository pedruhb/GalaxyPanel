<?php include "../galaxyservers/global.php";
if(empty($_SESSION['useradmin'])){
	echo '<script>location.href="../index";</script>';
}
if (!empty($_SESSION['useradmin'])){

	include "nav.php";

	$pegadados = $PDO->prepare("SELECT * FROM servidores WHERE id = :id");
	$pegadados->bindParam(':id', $_GET['user']);
	$pegadados->execute();
	$dados = $pegadados->fetch();

	if(isset($dados['nomehotel'])){
		try {
			$PDO2 = new PDO('mysql:host='.$iphospedagem.';dbname='.$dados['uservestacp']."_hotel", $dados['uservestacp']."_hotel", $dados['senhavestacp']);
			$PDO2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch(PDOException $e) {
			echo '<script>alert("Erro de conexão ao hotel: ' . utf8_encode($e->getMessage()).'");</script>';
		} 
	}

	$infoserver2 = $PDO2->prepare("SELECT (SELECT users_online FROM server_status) as userson, (select count(id) from users) as usertotal, (select loaded_rooms from server_status) as quartoscarregados, (select record_on from server_status) as recordon, (select status from server_status) as status, (select uptime from server_status) as uptime");
	$infoserver2->execute();
	$informacao = $infoserver2->fetch();

	?>
	<div class="pcoded-content">
		<div class="pcoded-inner-content">
			<div class="main-body">
				<div class="page-wrapper">
					<div class="page-body">
						<div class="card-header-right"><center><a href="/admin/editar/<?= $_GET['user'];?>" style="border-radius: 8px;" class="btn btn-primary btn-square">Editar Hotel</a></center></div>
							<div class="row">
								<div class="col-md-6 col-xl-3">
									<div class="card widget-card-1">
										<div class="card-block-small">
											<i class="icofont icofont-ui-user bg-c-blue card1-icon"></i>
											<span class="text-c-blue f-w-600">Usuários Online</span>
											<h4><?php echo $informacao['userson'];?></h4>
											<div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-6 col-xl-3">
									<div class="card widget-card-1">
										<div class="card-block-small">
											<i class="icofont icofont-ui-user-group bg-c-green card1-icon"></i>
											<span class="text-c-green f-w-600">Usuários Total</span>
											<h4><?php echo $informacao['usertotal'];?></h4>
											<div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-6 col-xl-3">
									<div class="card widget-card-1">
										<div class="card-block-small">
											<i class="icofont icofont-ui-home bg-c-pink card1-icon"></i>
											<span class="text-c-pink f-w-600">Quartos</span>
											<h4><?php echo $informacao['quartoscarregados'];?></h4>
											<div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-6 col-xl-3">
									<div class="card widget-card-1">
										<div class="card-block-small">
											<i class="icofont icofont-win-trophy bg-c-yellow card1-icon"></i>
											<span class="text-c-yellow f-w-600">Record de ON's</span>
											<h4><?php echo $informacao['recordon'];?></h4>
										</div>
									</div>
								</div>
							</div>
							<div class="card">
								<div class="card-header">
									<h5>Gerenciar Emulador</h5>
									<span>Aqui você pode gerenciar o emulador do hotel.</span>
									<div class="card-header-right">
										<i class="icofont icofont-spinner-alt-5"></i>
									</div>
								</div>
								<div class="card-block">
									<?php
									$pegadados = $PDO->prepare("SELECT * FROM servidores WHERE id = :id");
									$pegadados->bindParam(':id', $_GET['user']);
									$pegadados->execute();
									$dados = $pegadados->fetch();

									if(!isset($dados['nomehotel'])){
										loginerror("Conta não encontrada.");
									}
									else {

										try {
											$infoserver2 = $PDO2->prepare("SELECT status FROM server_status");
											$infoserver2->execute();
											$informacao2 = $infoserver2->fetch();
											$status = $informacao2['status'];
										} catch(PDOException $e) {
											$status = 33;
										} 

										if($status == "2")
											$status = "ligado";
										else $status = "desligado";

										echo '<center><span style="text-transform: inherit;" >O emulador está  '.$status.'.</span></center><br>';

										if (isset($_POST['desligaremu']))
										{
											if($dados['estado'] == "desligado" && $status == "0")
												echo '<div style="display: contents;">
											<div class="col-md-12">
											<center><div class="alert alert-danger background-danger" style="width: 30%;">
											<strong>Erro!</strong> O emulador não está ligado!
											</div></center>
											</div>
											</div>';
											else {
												sendRCONCommand2('desligaremulador', '', $ipvps, $dados['portamus']);

												$atualizastatus = $PDO->prepare("UPDATE servidores SET estado = 'desligado' WHERE portamus = '".$dados['portamus']."'");
												$atualizastatus->execute();

												addlog_admin($_SESSION['useradmin'], "Desligou o emulador do usuário: ".$dados['uservestacp']);

											}
										}

										if (isset($_POST['reiniciaremu']))
										{
											if($dados['estado'] == "desligado" && $status == "0")
												echo '<div style="display: contents;">
											<div class="col-md-12">
											<center><div class="alert alert-danger background-danger" style="width: 30%;">
											<strong>Erro!</strong> O emulador não está ligado!
											</div></center>
											</div>
											</div>';
											else {
												sendRCONCommand2('reiniciaremulador', '', $ipvps, $dados['portamus']);

												addlog_admin($_SESSION['useradmin'], "Reiniciou o emulador do usuário: ".$dados['uservestacp']);

											}
										}

										if (isset($_POST['ligaremu']))
										{
											if($dados['estado'] == "ligado" && $status == "2")
												echo '<div style="display: contents;">
											<div class="col-md-12">
											<center><div class="alert alert-danger background-danger" style="width: 30%;">
											<strong>Erro!</strong> O emulador já está ligado!
											</div></center>
											</div>
											</div>';															
											else {
												popen("C:/xampp/htdocs/galaxyservers/emuladores/".$dados['uservestacp']."/galaxyserverligar.bat", "r");

												$atualizastatus = $PDO->prepare("UPDATE servidores SET estado = 'ligado' WHERE portamus = '".$dados['portamus']."'");
												$atualizastatus->execute();

												addlog_admin($_SESSION['useradmin'], "Ligou o emulador do usuário: ".$dados['uservestacp']);					

												echo '<div style="display: contents;">
												<div class="col-md-12">
												<center><div class="alert alert-success background-success" style="width: 50%;">
												<strong>Successo!</strong> Comando executado com êxito!
												</div></center>
												</div>
												</div>';
											}
										}


										?>

										<form method="POST" style="display: contents;">
											<div class="col-md-12">
												<center>
													<button title="Ligar Emulador" name="ligaremu" style="border-radius: 8px;" data-type="inverse" data-align="right" data-from="top" class="btn btn-success"><i class="icofont icofont-ui-play"></i>Ligar Emulador</button>

													<button  title="Desligar Emulador" type="submit" style="border-radius: 8px;" name="desligaremu" data-type="inverse" data-align="right" data-from="top" class="btn btn-danger" ><i class="icofont icofont-ui-power"></i>Desligar Emulador</button>

													<button title="Reiniciar Emulador" name="reiniciaremu" style="border-radius: 8px;" data-type="inverse" data-align="right" data-from="top" class="btn btn-primary"><i class="icofont icofont-ui-rotation"></i>Reiniciar Emulador</button>
												</div>
											</form>
											<br>
											<center>O emulador está ligado há <?php echo $informacao['uptime'];?></center>

										</div>
									</div>
								</div>
								<div class="card">
									<div class="card-header">
										<h5>Gerenciar arquivos</h5>
										<span>Aqui você pode gerenciar os arquivos do hotel.</span>
										<div class="card-header-right">
											<i class="icofont icofont-spinner-alt-5"></i>
										</div>
									</div>
									<div class="card-block">
										<iframe src="/admin/filemanager_hotel.php?user=<?= $dados['uservestacp'];?>" width="100%" style=" height: 420px;border: none;"></iframe>
									</div>
								</div>
								<div class="card">
									<div class="card-header">
										<h5 class="card-header-text">Gerenciar banco de dados</h5>
									</div>
									<div class="card-block">
										<div class="view-info">
											<div class="row">
												<div>
													<center><img draggable="false" src="https://www.phpmyadmin.net/static/images/logo-og.png" width="30%">	
														<br><br>
														<a href="<?php echo $phpmyadmin.'?pma_username='.$dados['uservestacp']."_hotel".'&pma_password='.$dados['senhavestacp'] ?>&db=<?php echo $dados['uservestacp']."_hotel"; ?>" target="_blank"><button type="submit" name="db" style="text-transform: inherit;border-radius: 8px;" class="btn btn-primary btn-square">Acessar phpMyAdmin</button></a><br><br>
													</center>
												</div>
											</div>
										</div>
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
<script type="text/javascript" src="<?php echo $dominio;?>/galaxyservers/bower_components/jquery/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $dominio;?>/galaxyservers/bower_components/jquery-ui/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo $dominio;?>/galaxyservers/bower_components/popper.js/js/popper.min.js"></script>
<script type="text/javascript" src="<?php echo $dominio;?>/galaxyservers/bower_components/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo $dominio;?>/galaxyservers/bower_components/jquery-slimscroll/js/jquery.slimscroll.js"></script>
<script type="text/javascript" src="<?php echo $dominio;?>/galaxyservers/bower_components/modernizr/js/modernizr.js"></script>
<script src="<?php echo $dominio;?>/galaxyservers/assets/pages/widget/amchart/amcharts.min.js"></script>
<script src="<?php echo $dominio;?>/galaxyservers/assets/pages/widget/amchart/serial.min.js"></script>
<script type="text/javascript" src="<?php echo $dominio;?>/galaxyservers/bower_components/chart.js/js/Chart.js"></script>
<script type="text/javascript" src="<?php echo $dominio;?>/galaxyservers/assets/pages/todo/todo.js"></script>
<script type="text/javascript" src="<?php echo $dominio;?>/galaxyservers/assets/js/script.js"></script>
<script type="text/javascript" src="<?php echo $dominio;?>/galaxyservers/assets/js/bootstrap-growl.min.js"></script>
<script type="text/javascript" src="<?php echo $dominio;?>/galaxyservers/bower_components/i18next/js/i18next.min.js"></script>
<script type="text/javascript" src="<?php echo $dominio;?>/galaxyservers/bower_components/i18next-xhr-backend/js/i18nextXHRBackend.min.js"></script>
<script type="text/javascript" src="<?php echo $dominio;?>/galaxyservers/bower_components/i18next-browser-languagedetector/js/i18nextBrowserLanguageDetector.min.js"></script>
<script type="text/javascript" src="<?php echo $dominio;?>/galaxyservers/bower_components/jquery-i18next/js/jquery-i18next.min.js"></script>
<script type="text/javascript" src="<?php echo $dominio;?>/galaxyservers/assets/pages/notification/notification.js"></script>
<script type="text/javascript" src="<?php echo $dominio;?>/galaxyservers/assets/pages/dashboard/custom-dashboard.min.js"></script>
<script type="text/javascript" src="<?php echo $dominio;?>/galaxyservers/assets/js/SmoothScroll.js"></script>
<script src="<?php echo $dominio;?>/galaxyservers/assets/js/pcoded.min.js"></script>
<script src="<?php echo $dominio;?>/galaxyservers/assets/js/demo-12.js"></script>
<script src="<?php echo $dominio;?>/galaxyservers/assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script type="text/javascript" src="<?php echo $dominio;?>/galaxyservers/assets/js/script.min.js"></script>
<script type="text/javascript">
	funcaoJavascript = function(){
		var a = document.getElementById('user');
		var b = document.getElementById('db');
		if(a.value == "")
			b.value = a.value;
		else 
			b.value = a.value+"_hotel";
	}
</script>
</body>
</html>
<?php }?>