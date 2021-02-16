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
	if($planoi['editarmobi'] == "false"){
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
						<div class="card">
							<div class="card-block">
								<div class="m-b-20">
									<h4 class="sub-title">Modificar nome e descrição do mobi</h4>
									<?php

									if(!permissao("editmobis")){
										echo '<div style="display: contents;">
										<div class="col-md-12">
										<center><div class="alert alert-danger background-danger" style="width: 30%;">
										<strong>Erro!</strong> Sua subconta não tem permissão para acessar essa página.
										</div></center>
										</div>
										</div>';
									} else {


										$PDO2 = new PDO('mysql:host='.$iphospedagem.';dbname='.$server['uservestacp']."_hotel", $server['uservestacp']."_hotel", $server['senhavestacp']);


										if(isset($_POST['adicionar'])){

											$nome=strip_tags($_POST['nome']);
											$desc=strip_tags($_POST['desc']);
											$furni_id=$_POST['furni_id'];	
											
											$dadosfurni = $PDO2->prepare("SELECT * FROM furniture WHERE id = :furniid");
											$dadosfurni->bindParam(':furniid', $furni_id);
											$dadosfurni->execute();
											$furni = $dadosfurni->fetch();

											$data = $PDO->prepare("SELECT * FROM furnidata WHERE usuario = :user AND id = :furniid");
											$data->bindParam(':furniid', $furni_id);
											$data->bindValue(':user', $server['uservestacp']);
											$data->execute();
											$dataCount = $data->rowCount();

											if(!$furni){
												echo '<div class="alert alert-danger background-danger">
												<strong>Erro!</strong> Nenhum mobi encontrado com o furni_id enviado.
												</div>'; 
											} else if($dataCount != 0){
												echo '<div class="alert alert-danger background-danger">
												<strong>Erro!</strong> Já existe uma modificação para este mobi.
												</div>'; 
											} else {

												if($furni['type'] == "s")
													$tipo = "chao";
												else if($furni['type'] == "i")
													$tipo = "parede";
												else 
													$tipo = "erro";

												if($tipo == "erro"){
													echo '<div class="alert alert-danger background-danger">
													<strong>Erro!</strong> O mobi informado não é compatível com a função.
													</div>'; 
												} else {

													$inseremod = $PDO->prepare("INSERT INTO `furnidata` (`usuario`, `tipo`, `mobi_id`, `mobi_classname`, `mobi_name`, `mobi_desc`) VALUES (:u, :t, :i, :c, :n, :d);");
													$inseremod->bindValue(':u', $server['uservestacp']);
													$inseremod->bindParam(':t', $tipo);
													$inseremod->bindParam(':i', $furni_id);
													$inseremod->bindValue(':c', $furni['item_name']);
													$inseremod->bindParam(':n', $nome);
													$inseremod->bindParam(':d', $desc);
													if($inseremod->execute()){
														echo '<br><div class="alert alert-success background-success">
														<strong>Successo!</strong> Modificação aplicada com sucesso, reentre no hotel.
														</div>';
														addlog('Modificou nome e descrição do mobi '.$furni_id);
													} else {
														echo '<div class="alert alert-danger background-danger">
														<strong>Erro!</strong> Erro ao aplicar modificação.
														</div>'; 
													}

												}

											}

										}

										?>
										<form method="POST" enctype="multipart/form-data">	
											<div class="row">
												<label class="col-sm-4 col-lg-2 col-form-label">Nome</label>
												<div class="col-sm-8 col-lg-10">
													<div class="input-group">																	
														<input type="text" name="nome" class="form-control" placeholder="Nome do mobi. Ex: Serpa Preta" required>
													</div>
												</div>
											</div>	

											<div class="row">
												<label class="col-sm-4 col-lg-2 col-form-label">Descrição</label>
												<div class="col-sm-8 col-lg-10">
													<div class="input-group">																	
														<input type="text" name="desc" class="form-control" placeholder="Descrição do mobi. Ex: Serpa Preta" required>
													</div>
												</div>
											</div>															

											<div class="row">
												<label class="col-sm-4 col-lg-2 col-form-label">Furniture ID</label>
												<div class="col-sm-8 col-lg-10">
													<div class="input-group">
														<input type="text" name="furni_id" class="form-control" placeholder="ID da tabela furniture do mobi correspondente." required>
													</div>
												</div>
											</div>										

										</div>
										<center><button type="submit" style="border-radius: 8px;" name="adicionar" class="btn btn-primary m-b-0">Adicionar</button><br></center><?php }?>
									</form>
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