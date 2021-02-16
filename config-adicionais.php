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
									<h4 class="sub-title">Configurações adicionais</h4>
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


											if(isset($_POST['alterar'])){

												if(!empty($_POST['telefone'])){
													$aaaaaa = $PDO->prepare("SELECT id FROM servidores WHERE `telefone`= :telefone AND id <> '".$server['id']."';");
													$aaaaaa->bindValue(':telefone', $_POST['telefone']); 
													$aaaaaa->execute(); 
													$aa = $aaaaaa->rowCount();
												}

												if(!empty($_POST['telefone']) && $aa != 0){
													echo '<div class="alert alert-danger background-danger">
													<strong>Erro!</strong> Telefone já cadastrado
													</div>';
												} else {

													$upateUser2 = $PDO->prepare("UPDATE `servidores` SET telefone = :telefone, login_dados = :login_dados , indexar = :indexar  where `id`= :id");
													$upateUser2->bindValue(':login_dados', $_POST['login_dados']); 
													$upateUser2->bindValue(':telefone', $_POST['telefone']); 
													$upateUser2->bindValue(':indexar', $_POST['indexar']); 
													$upateUser2->bindValue(':id', $server['id']);
													$upateUser2->execute(); 

													echo '<div class="alert alert-success background-success">
													<strong>Successo!</strong> Alterações salvas.
													</div>';

													addlog('Alterou configurações de login.');

												}
											}


											function apiRequest($url, $post=FALSE, $headers=array()) {
												global $token_bot;
												$ch = curl_init($url);
												curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
												curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
												$response = curl_exec($ch);
												if($post)
													curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
												$headers[] = 'Accept: application/json';

												$headers[] = 'Authorization: Bot '.$token_bot;
												curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
												$response = curl_exec($ch);
												return json_decode($response);
											}

											$infoserver = $PDO->prepare("SELECT * FROM servidores WHERE nomeusuario = '".$_SESSION['nomeusuario']."'");
											$infoserver->execute();
											$server = $infoserver->fetch();
											?>
											<style>
												.input-group {
													margin-bottom: 0;
												}
											</style>
											<div class="row">
												<label class="col-sm-4 col-lg-2 col-form-label">Telefone SMS (Login)</label>
												<div class="col-sm-8 col-lg-10">
													<div class="input-group">																	
														<input type="text" name="telefone" class="form-control" value="<?= $server['telefone'];?>" placeholder="Seu telefone com DDD.">													
													</div><small>Telefone que pode entrar com SMS, Exemplo: +552199999999</small>
												</div>
											</div>
											<br>
											<div class="row">
												<label class="col-sm-4 col-lg-2 col-form-label">Email</label>
												<div class="col-sm-8 col-lg-10">
													<div class="input-group">																	
														<input type="text"class="form-control" value="<?= $server['emailcliente'];?>" disabled>													
													</div><small>Email que pode entrar com pin, ele não pode ser alterado.</small>
												</div>
											</div>
											<br>
											<div class="row">
												<label class="col-sm-4 col-lg-2 col-form-label">Login com dados</label>
												<div class="col-sm-8 col-lg-10">
													<div class="input-group">																	
														<select class="form-control" name="login_dados">
															<option <?php if($server['login_dados'] == "Y")echo"selected";?> value="Y">Sim</option>
															<option <?php if($server['login_dados'] == "N")echo"selected";?> value="N">Não</option>
														</select>
													</div><small>Caso você desative, só poderá logar com pin via sms ou email.</small>
												</div>
											</div>
											<br>
											<div class="row">
												<label class="col-sm-4 col-lg-2 col-form-label">Indexar no site da Galaxy</label>
												<div class="col-sm-8 col-lg-10">
													<div class="input-group">																	
														<select class="form-control" name="indexar">
															<option <?php if($server['indexar'] == "Y")echo"selected";?> value="Y">Sim</option>
															<option <?php if($server['indexar'] == "N")echo"selected";?> value="N">Não</option>
														</select>
													</div><small>Caso você desative, seu hotel não aparecerá no site da Galaxy e não será encontrado pelo Saturninho.</small>
												</div>
											</div>
											<br>
											<div class="row">
												<label class="col-sm-4 col-lg-2 col-form-label">Discord vinculado</label>
												<div class="col-sm-8 col-lg-10">
													<div class="input-group">	
														<?php
														if(!isset($server['discord_id']) || $server['discord_id'] == null || $server['discord_id'] == "")	
															$conta = "Não há discord vinculado.";
														else {
															$infos = apiRequest("https://discordapp.com/api/users/".$server['discord_id']);
															$conta = $infos->username."#".$infos->discriminator." (". $infos->id.")";
														}	
														?>														
														<input type="text" class="form-control" value="<?= $conta;?>" disabled>													
													</div><small>Conta do discord que pode ser usada para realizar o login.</small><br>
													<small>Clique <a href="vincular-discord">aqui</a> para vincular uma nova conta.</small>
												</div>
											</div>

										</div>
										<center><button type="submit" style="border-radius: 8px;" name="alterar" class="btn btn-primary m-b-0">Salvar</button><br></center>
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