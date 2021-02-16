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
	if($planoi['galaxyhk'] == "false"){
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
									<?php
									if(!permissao("confighk")){
										echo '<div style="display: contents;">
										<div class="col-md-12">
										<center><div class="alert alert-danger background-danger" style="width: 30%;">
										<strong>Erro!</strong> Sua subconta não tem permissão para acessar essa página.
										</div></center>
										</div>
										</div>';
									} else {
										?>
										<h4 class="sub-title">Altere as configurações do HK.</h4>
										<form method="POST" enctype="multipart/form-data">	
											<?php
											error_reporting(0);
											if(isset($_POST['salvar-config'])){

												$configuracao = '{
													"discord_webhook": '.$_POST['log_webhook'].',
													"link_webhook": "'.$_POST['link_hook'].'",
													"imagem_discord": "https://i.imgur.com/QNuikh4.png",
													"permissoes": {
														"logs": '.$_POST['logs'].',
														"noticias": '.$_POST['noticias'].',
														"emblemas": '.$_POST['emblemas'].',
														"filtro": '.$_POST['filtro'].',
														"bans": '.$_POST['bans'].',
														"infracoes": '.$_POST['infracoes'].',
														"usuario": '.$_POST['usuario'].',
														"quartos": '.$_POST['quartos'].',
														"raros": '.$_POST['raros'].'
													}
												}';
												
												$nomearquivoc = "galaxyservers/galaxycms/configcms.php";
												$fpc = fopen($nomearquivoc, "w");
												$escreve = fwrite($fpc, $configuracao);

												$linkhotel = str_replace("http:", "", str_replace("https:", "", str_replace("/", "", $server['linkhotel'])));
												$con_id = ftp_connect($iphospedagem) or die( '<div class="alert alert-danger">Não conectou em: '.$servidor.'</div>');
												ftp_login( $con_id, $server['uservestacp'], $server['senhavestacp']);
												ftp_pasv($con_id, true) or die('<script>alert("Cannot switch to passive mode")</script>'); 
												if (ftp_put( $con_id, '/web/'.$linkhotel.'/public_html/adminpan/assets/config.json', 'galaxyservers/galaxycms/configcms.php', FTP_BINARY  ) ) {
													echo '<div class="alert alert-success background-success">
													<strong>Sucesso!</strong> HK configurado.
													</div>';
													addlog('Configurou o HK.');

												} else {
													echo '<div class="alert alert-danger background-danger">
													<strong>Erro!</strong> Erro ao configurar o HK.
													</div>';	
												}
											}
											$exibir = true;

											$linkhotel = str_replace("http:", "", str_replace("https:", "", str_replace("/", "", $server['linkhotel'])));
											$con_id = ftp_connect($iphospedagem) or die( '<div class="alert alert-danger">Não conectou em: '.$servidor.'</div>');
											ftp_login( $con_id, $server['uservestacp'], $server['senhavestacp']);
											ftp_pasv($con_id, true) or die('<script>alert("Cannot switch to passive mode")</script>'); 
											$h = fopen('php://temp', 'r+');
											@ftp_fget($con_id, $h, './web/'.$linkhotel.'/public_html/adminpan/assets/config.json', FTP_BINARY, 0);
											$fstats = fstat($h);
											fseek($h, 0);
											$json = fread($h, $fstats['size']); 
											$config = json_decode($json);
											if(!$config || !$json){

												echo $json;
												$exibir = false;
												loginerror("Erro ao obter configurações, reinstale seu HK.");
											}

											if($exibir){
												?>
												<div class="row">
													<label class="col-sm-4 col-lg-2 col-form-label">LOG via Webhook</label>
													<div class="col-sm-8 col-lg-10">
														<div class="input-group">
															<select name="log_webhook" required class="form-control">
																<option <?php if($config->{'discord_webhook'} == false) echo 'selected';?> value="false">Não</option>
																<option <?php if($config->{'discord_webhook'} == true) echo 'selected';?> value="true">Sim</option>
															</select>
														</div>
													</div>
												</div>

												<div class="row">
													<label class="col-sm-4 col-lg-2 col-form-label">Link webhook</label>
													<div class="col-sm-8 col-lg-10">
														<div class="input-group">
															<input type="text" name="link_hook" value="<?= $config->{'link_webhook'};?>" class="form-control" placeholder="Link do webhook" required>
														</div>
													</div>
												</div>


												<div class="row">
													<label class="col-sm-4 col-lg-2 col-form-label">Permissão usuários</label>
													<div class="col-sm-8 col-lg-10">
														<div class="input-group">
															<select name="usuario" class="form-control">
																<?php
																$getArtdicles = $PDO2->prepare("SELECT * FROM ranks ORDER BY id");
																$getArtdicles->execute();
																while($dnews = $getArtdicles->fetch())
																{
																	?>
																	<option <?php if($config->permissoes->usuario == $dnews['id'])echo'selected ';?> value="<?php echo $dnews['id']?>"><?php echo utf8_encode($dnews['name'].' ('.$dnews['id'].')');?></option>
																<?php } ?>
															</select>
														</div>
													</div>
												</div>

												<div class="row">
													<label class="col-sm-4 col-lg-2 col-form-label">Permissão notícias</label>
													<div class="col-sm-8 col-lg-10">
														<div class="input-group">
															<select name="noticias" class="form-control">
																<?php
																$getArtdicles = $PDO2->prepare("SELECT * FROM ranks ORDER BY id");
																$getArtdicles->execute();
																while($dnews = $getArtdicles->fetch())
																{
																	?>
																	<option <?php if($config->permissoes->noticias == $dnews['id'])echo'selected ';?> value="<?php echo $dnews['id']?>"><?php echo utf8_encode($dnews['name'].' ('.$dnews['id'].')');?></option>
																<?php } ?>
															</select>
														</div>
													</div>
												</div>


												<div class="row">
													<label class="col-sm-4 col-lg-2 col-form-label">Permissão logs</label>
													<div class="col-sm-8 col-lg-10">
														<div class="input-group">
															<select name="logs" class="form-control">
																<?php
																$getArtdicles = $PDO2->prepare("SELECT * FROM ranks ORDER BY id");
																$getArtdicles->execute();
																while($dnews = $getArtdicles->fetch())
																{
																	?>
																	<option <?php if($config->permissoes->logs == $dnews['id'])echo'selected ';?> value="<?php echo $dnews['id']?>"><?php echo utf8_encode($dnews['name'].' ('.$dnews['id'].')');?></option>
																<?php } ?>
															</select>
														</div>
													</div>
												</div>

												<div class="row">
													<label class="col-sm-4 col-lg-2 col-form-label">Permissão emblemas</label>
													<div class="col-sm-8 col-lg-10">
														<div class="input-group">
															<select name="emblemas" class="form-control">
																<?php
																$getArtdicles = $PDO2->prepare("SELECT * FROM ranks ORDER BY id");
																$getArtdicles->execute();
																while($dnews = $getArtdicles->fetch())
																{
																	?>
																	<option <?php if($config->permissoes->emblemas == $dnews['id'])echo'selected ';?> value="<?php echo $dnews['id']?>"><?php echo utf8_encode($dnews['name'].' ('.$dnews['id'].')');?></option>
																<?php } ?>
															</select>
														</div>
													</div>
												</div>


												<div class="row">
													<label class="col-sm-4 col-lg-2 col-form-label">Permissão filtro</label>
													<div class="col-sm-8 col-lg-10">
														<div class="input-group">
															<select name="filtro" class="form-control">
																<?php
																$getArtdicles = $PDO2->prepare("SELECT * FROM ranks ORDER BY id");
																$getArtdicles->execute();
																while($dnews = $getArtdicles->fetch())
																{
																	?>
																	<option <?php if($config->permissoes->filtro == $dnews['id'])echo'selected ';?> value="<?php echo $dnews['id']?>"><?php echo utf8_encode($dnews['name'].' ('.$dnews['id'].')');?></option>
																<?php } ?>
															</select>
														</div>
													</div>
												</div>

												<div class="row">
													<label class="col-sm-4 col-lg-2 col-form-label">Permissão bans</label>
													<div class="col-sm-8 col-lg-10">
														<div class="input-group">
															<select name="bans" class="form-control">
																<?php
																$getArtdicles = $PDO2->prepare("SELECT * FROM ranks ORDER BY id");
																$getArtdicles->execute();
																while($dnews = $getArtdicles->fetch())
																{
																	?>
																	<option <?php if($config->permissoes->bans == $dnews['id'])echo'selected ';?> value="<?php echo $dnews['id']?>"><?php echo utf8_encode($dnews['name'].' ('.$dnews['id'].')');?></option>
																<?php } ?>
															</select>
														</div>
													</div>
												</div>

														<div class="row">
													<label class="col-sm-4 col-lg-2 col-form-label">Permissão infrações</label>
													<div class="col-sm-8 col-lg-10">
														<div class="input-group">
															<select name="infracoes" class="form-control">
																<?php
																$getArtdicles = $PDO2->prepare("SELECT * FROM ranks ORDER BY id");
																$getArtdicles->execute();
																while($dnews = $getArtdicles->fetch())
																{
																	?>
																	<option <?php if($config->permissoes->infracoes == $dnews['id'])echo'selected ';?> value="<?php echo $dnews['id']?>"><?php echo utf8_encode($dnews['name'].' ('.$dnews['id'].')');?></option>
																<?php } ?>
															</select>
														</div>
													</div>
												</div>

												<div class="row">
													<label class="col-sm-4 col-lg-2 col-form-label">Permissão quartos</label>
													<div class="col-sm-8 col-lg-10">
														<div class="input-group">
															<select name="quartos" class="form-control">
																<?php
																$getArtdicles = $PDO2->prepare("SELECT * FROM ranks ORDER BY id");
																$getArtdicles->execute();
																while($dnews = $getArtdicles->fetch())
																{
																	?>
																	<option <?php if($config->permissoes->quartos == $dnews['id'])echo'selected ';?> value="<?php echo $dnews['id']?>"><?php echo utf8_encode($dnews['name'].' ('.$dnews['id'].')');?></option>
																<?php } ?>
															</select>
														</div>
													</div>
												</div>

												<div class="row">
													<label class="col-sm-4 col-lg-2 col-form-label">Permissão raros</label>
													<div class="col-sm-8 col-lg-10">
														<div class="input-group">
															<select name="raros" class="form-control">
																<?php
																$getArtdicles = $PDO2->prepare("SELECT * FROM ranks ORDER BY id");
																$getArtdicles->execute();
																while($dnews = $getArtdicles->fetch())
																{
																	?>
																	<option <?php if($config->permissoes->raros == $dnews['id'])echo'selected ';?> value="<?php echo $dnews['id']?>"><?php echo utf8_encode($dnews['name'].' ('.$dnews['id'].')');?></option>
																<?php } ?>
															</select>
														</div>
													</div>
												</div>

											</div>
											<center><button type="submit" style="border-radius: 8px;" name="salvar-config" class="btn btn-primary m-b-0">Salvar</button></center>
										</form>
									<?php } }?>
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