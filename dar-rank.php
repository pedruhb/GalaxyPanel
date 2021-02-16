﻿<?php
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
									<h4 class="sub-title">Dar rank para um usuário.</h4>
									<form method="POST" enctype="multipart/form-data">	
										<?php

										if(!permissao("darrank")){
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
												die('<script>alert("Erro de conexão ao hotel: ' . utf8_encode($e->getMessage()).'");</script>');
											}

											if(isset($_POST['dar'])){

												$aaaaaa = $PDO2->prepare("SELECT id FROM users WHERE `username`= '".$_POST['usuario']."'");
												$aaaaaa->execute(); 
												$aa = $aaaaaa->fetch();

												if(empty($aa['id'])){
													echo '<div class="alert alert-danger background-danger">
													<strong>Erro!</strong> Usuário não encontrado
													</div>';
												} else {

													$rankbind = gs($_POST['rank']);
													$idbind = gs($_POST['usuario']);

													$upateUser2 = $PDO2->prepare("UPDATE `users` SET rank = :rank where `username`= :id");
													$upateUser2->bindParam(':rank', $rankbind); 
													$upateUser2->bindParam(':id', $idbind);
													$upateUser2->execute(); 

													echo '<div class="alert alert-success background-success">
													<strong>Successo!</strong> o Rank do usuário "'.gs($_POST['usuario']).'" foi alterado para o '.gs($_POST['rank']).'.
													</div>';

													addlog('Deu rank '.$_POST['rank'].' para o usuário '.$_POST['usuario'].".");

												}
											}
											?>
											<div class="row">
												<label class="col-sm-4 col-lg-2 col-form-label">Usuário</label>
												<div class="col-sm-8 col-lg-10">
													<div class="input-group">																	
														<input type="text" name="usuario" class="form-control" placeholder="Nome de usuário" required>
													</div>
												</div>
											</div>															
											<div class="row">
												<label class="col-sm-4 col-lg-2 col-form-label">Rank</label>
												<div class="col-sm-8 col-lg-10">
													<div class="input-group">
														<select name="rank" class="form-control">
															<?php
															$getArtdicles = $PDO2->prepare("SELECT * FROM ranks ORDER BY id");
															$getArtdicles->execute();
															while($dnews = $getArtdicles->fetch())
															{
																?>
																<option value="<?php echo $dnews['id']?>"><?php echo utf8_encode($dnews['name'])?> (<?php echo utf8_encode($dnews['id'])?>)</option>
															<?php } ?>
														</select>
													</div>
												</div>
											</div>
										</div>
										<center><button type="submit" style="border-radius: 8px;" name="dar" class="btn btn-primary m-b-0">Salvar</button><br></center>
									</form>
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