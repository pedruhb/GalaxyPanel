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
							<div class="card-block">
								<div class="m-b-20">
									<h4 class="sub-title">Executar SQL</h4>
									<form method="POST" enctype="multipart/form-data">	
										<?php
										
										if(isset($_SESSION['subconta'])){
											echo '<div style="display: contents;">
											<div class="col-md-12">
											<center><div class="alert alert-danger background-danger" style="width: 30%;">
											<strong>Erro!</strong> Sua subconta não tem permissão para acessar essa página.
											</div></center>
											</div>
											</div>';
										} else {

											try {
												$PDO2 = new PDO('mysql:host='.$iphospedagem.';dbname='.$server['uservestacp']."_hotel", $server['uservestacp']."_hotel", $server['senhavestacp']);
												$PDO2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
											} catch(PDOException $e) {
												echo '<script>alert("Erro de conexão ao hotel: ' . utf8_encode($e->getMessage()).'");</script>';
											}	

											if(isset($_POST['executar']))
											{
												try{
													$sql = $_POST['sql'];
													$att = $PDO2->prepare($sql);
													if($att->execute()){
														loginsucess("SQL Executado.");
														addlog('Executou um SQL.');
													} else {
														loginerror("Erro ao executar SQL");
														addlog('Executou um SQL porém com erro.');
													}
												} catch (Exception $e){
													loginerror(str_replace('C:\xampp\htdocs\sql.php', "", $e));
													addlog('Executou um SQL porém com erro.');
												}
											}
											?>
											<div class="row">
												<div class="col-sm-12 col-lg-12">
													<div class="input-group">
														<textarea class="form-control" name="sql" id="sql" placeholder="Escreva o seu código SQL aqui." style="height: 211px;width: 100%"></textarea>
													</div>
												</div>
											</div>
											<center>
												<b>Atalhos Rápidos</b>
												<br>
												<select id="atalho"  onchange="Atalhos()">
													<option value="0">Nenhum atalho</option>
													<option value="1">Resetar créditos de usuários</option>
													<option value="2">Botar todos os mobis da loja em 1c</option>
													<option value="3">Zerar pontos de eventos</option>
													<option value="4">Zerar pontos de promoções</option>
												</select>
											</center>
										</div>
										<center><button type="submit" style="border-radius: 8px;" name="executar" class="btn btn-primary m-b-0">Executar</button>
											<br>
											Atenção, essa ação não pode ser desfeita!
										</center>
									</form>
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
<script type="text/javascript" src="../../galaxyservers/bower_components/jquery/js/jquery.min.js"></script>
<script type="text/javascript" src="../../galaxyservers/bower_components/jquery-ui/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="../../galaxyservers/bower_components/popper.js/js/popper.min.js"></script>
<script type="text/javascript" src="../../galaxyservers/bower_components/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../../galaxyservers/bower_components/jquery-slimscroll/js/jquery.slimscroll.js"></script>
<script type="text/javascript" src="../../galaxyservers/bower_components/modernizr/js/modernizr.js"></script>
<script type="text/javascript" src="../../galaxyservers/bower_components/modernizr/js/css-scrollbars.js"></script>
<script src="../../galaxyservers/assets/pages/jquery.filer/js/jquery.filer.min.js"></script>
<script src="../../galaxyservers/assets/pages/filer/custom-filer.js" type="text/javascript"></script>
<script src="../../galaxyservers/assets/pages/filer/jquery.fileuploads.init.js?a=a" type="text/javascript"></script>
<script type="text/javascript" src="../../galaxyservers/bower_components/i18next/js/i18next.min.js"></script>
<script type="text/javascript" src="../../galaxyservers/bower_components/i18next-xhr-backend/js/i18nextXHRBackend.min.js"></script>
<script type="text/javascript" src="../../galaxyservers/bower_components/i18next-browser-languagedetector/js/i18nextBrowserLanguageDetector.min.js"></script>
<script type="text/javascript" src="../../galaxyservers/bower_components/jquery-i18next/js/jquery-i18next.min.js"></script>
<script src="../../galaxyservers/assets/js/pcoded.min.js"></script>
<script src="../../galaxyservers/assets/js/demo-12.js"></script>
<script src="../../galaxyservers/assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
<script type="text/javascript" src="../../galaxyservers/assets/js/script.js"></script>
<script type="text/javascript">
	function Atalhos(){
		var e = document.getElementById("atalho");
		switch(e.value){
			case '0':
			$("textarea#sql").val("");
			break;

			case '1':
			$("textarea#sql").val("UPDATE `users` SET `vip_points`='0', `credits`='0', `activity_points`='0', `gotw_points`='0';");
			break;

			case '2':
			$("textarea#sql").val("UPDATE `catalog_items` SET `cost_credits`='1' WHERE page_id != '13';");
			break;

			case '3':
			$("textarea#sql").val("UPDATE `users` SET `Premiar`='0';");
			break;

			case '4':
			$("textarea#sql").val("UPDATE `users` SET `promo_points`='0';");
			break;
		}
	}
</script>
</body>
</html><?php } else header('Location: ../index'); ?>