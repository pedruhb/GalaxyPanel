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
									<h4 class="sub-title">Gerar voucher</h4>
									<form method="POST" enctype="multipart/form-data">	
										<?php

										if(!permissao("voucher")){
											echo '<div style="display: contents;">
											<div class="col-md-12">
											<center><div class="alert alert-danger background-danger" style="width: 30%;">
											<strong>Erro!</strong> Sua subconta não tem permissão para acessar essa página.
											</div></center>
											</div>
											</div>';
										} else {

											if(isset($_POST['dar'])){

												try {
													$PDO2 = new PDO('mysql:host='.$iphospedagem.';dbname='.$server['uservestacp']."_hotel", $server['uservestacp']."_hotel", $server['senhavestacp']);
													$PDO2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
												} catch(PDOException $e) {
													echo '<script>alert("Erro de conexão ao hotel: ' . utf8_encode($e->getMessage()).'");</script>';
												}

												$codigo = $_POST['codigo'];
												$tipo = $_POST['tipo'];
												$valor = $_POST['valor'];
												$usosmax = $_POST['usosmax'];

												$continua = true;
												if($tipo == "mobi"){
													$type = "furni";
													$selectMobi = $PDO2->prepare("SELECT item_name FROM furniture WHERE id = :id");
													$selectMobi->bindParam(':id', $valor);
													$selectMobi->execute(); 

													if($selectMobi->rowCount() == 0){
														echo '<div class="alert alert-danger background-danger">
														<strong>Erro!</strong> O mobi cujo o id foi informado não existe.
														</div>';
														$continua = false;
													}
												} 
												if($tipo == "moedas")
													$type = "credit";
												else if($tipo == "duckets")
													$type = "ducket";
												else if($tipo == "diamantes")
													$type = "diamond";
												else if($tipo == "gotw")
													$type = "gotw";

												if($continua){
													$upateUser2 = $PDO2->prepare("INSERT INTO `catalog_vouchers` (`voucher`, `type`, `value`, `max_uses`) VALUES (:1, :2, :3, :4);");
													$upateUser2->bindParam(':1', $codigo); 
													$upateUser2->bindParam(':2', $type);
													$upateUser2->bindParam(':3', $valor); 
													$upateUser2->bindParam(':4', $usosmax);
													$upateUser2->execute(); 

													echo '<div class="alert alert-success background-success">
													<strong>Successo!</strong> Voucher gerado.
													</div>';

													addlog('Gerou o voucher '.$codigo);

													sendRCONCommand2('reload_vouchers', '', $ipvps, $server['portamus']);

												}
												
											}
											?>
											<div class="row">
												<label class="col-sm-4 col-lg-2 col-form-label">Código</label>
												<div class="col-sm-8 col-lg-10">
													<div class="input-group">																	
														<input type="text" name="codigo" class="form-control" placeholder="Código do voucher" value="<?= md5(time());?>" required>
													</div>
												</div>
											</div>			

											<div class="row">
												<label class="col-sm-4 col-lg-2 col-form-label">Tipo</label>
												<div class="col-sm-8 col-lg-10">
													<div class="input-group">																	
														<select name="tipo" class="form-control">
															<option value="moedas">Moedas</option>
															<option value="duckets">Duckets</option>
															<option value="diamantes">Diamantes</option>
															<option value="gotw">GOTW</option>
															<option value="mobi">Mobi</option>
														</select>
													</div>
												</div>
											</div>	

											<div class="row">
												<label class="col-sm-4 col-lg-2 col-form-label">Valor</label>
												<div class="col-sm-8 col-lg-10">
													<div class="input-group">																	
														<input type="text" name="valor" class="form-control" placeholder="Quantidade de moedas ou id do mobi que será dado" required>
													</div>
												</div>
											</div>

											<div class="row">
												<label class="col-sm-4 col-lg-2 col-form-label">Máximo de usos</label>
												<div class="col-sm-8 col-lg-10">
													<div class="input-group">																	
														<input type="number" name="usosmax" class="form-control" placeholder="Quantidade de vezes que o voucher pode ser usado." required>
													</div>
												</div>
											</div>

											<center><button type="submit" style="border-radius: 8px;" name="dar" class="btn btn-primary m-b-0">Salvar</button><br></center>
										</form>
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
</body>
</html><?php } else header('Location: ../index'); ?>