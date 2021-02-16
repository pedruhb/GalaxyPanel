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
									error_reporting(0);
									if(!permissao("usuarios")){
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

										if(isset($_POST['salvar']))
										{
											$username = $_POST['username'];
											$motto = $_POST['motto'];
											$mail = $_POST['mail'];
											$prefix_name = $_POST['prefix_name'];
											$prefix_name_color = $_POST['prefix_name_color'];
											$Premiar = $_POST['Premiar'];
											$rank = $_POST['rank'];
											$pin = $_POST['pin'];
											$hide_online = $_POST['hide_online'];
											$ignore_invites = $_POST['ignore_invites'];
											$allow_gifts = $_POST['allow_gifts'];
											$allow_mimic = $_POST['allow_mimic'];
											$allow_sex = $_POST['allow_sex'];
											$allow_events = $_POST['allow_events'];
											$AchievementScore = $_POST['AchievementScore'];
											$Respect = $_POST['Respect'];
											$senha = $_POST['senha'];
											$activity_points = $_POST['activity_points'];
											$credits = $_POST['credits'];
											$gotw_points = $_POST['gotw_points'];
											$vip_points = $_POST['vip_points'];

											$permissao2 = $PDO2->prepare("SELECT online FROM users WHERE id = :id");
											$permissao2->bindParam(':id', $_GET['user']);
											$permissao2->execute();
											$permi2 = $permissao2->fetch()['online'];

											if($permi2 == '1'){
												echo '<div class="alert alert-danger background-danger">
												<strong>Erro!</strong> Não é possível editar um usuário online.
												</div>';
											} else {
												$attUser = $PDO2->prepare("UPDATE users SET username = :1, motto = :2, mail = :3, prefix_name = :4, prefix_name_color = :5, name_color = :15, Premiar = :6, rank = :7, pin = :8, hide_online = :9, ignore_invites = :10, allow_gifts = :11, allow_mimic = :12, allow_sex = :13, allow_events = :14,activity_points = :16, credits = :17, gotw_points = :18, vip_points = :19 WHERE id = :id");
												$attUser->bindParam(':1', $username);
												$attUser->bindParam(':2', $motto);
												$attUser->bindParam(':3', $mail);
												$attUser->bindParam(':4', $prefix_name);
												$attUser->bindParam(':5', $prefix_name_color);
												$attUser->bindParam(':6', $Premiar);
												$attUser->bindParam(':7', $rank);
												$attUser->bindParam(':8', $pin);
												$attUser->bindParam(':9', $hide_online);
												$attUser->bindParam(':10', $ignore_invites);
												$attUser->bindParam(':11', $allow_gifts);
												$attUser->bindParam(':12', $allow_mimic);
												$attUser->bindParam(':13', $allow_sex);
												$attUser->bindParam(':14', $allow_events);
												$attUser->bindParam(':15', $name_color);
												$attUser->bindParam(':16', $activity_points);
												$attUser->bindParam(':17', $credits);
												$attUser->bindParam(':18', $gotw_points);
												$attUser->bindParam(':19', $vip_points);
												$attUser->bindParam(':id', $_GET['user']);
												$attUser->execute();

												$attUser2 = $PDO2->prepare("UPDATE user_stats SET AchievementScore = :1, Respect = :2 WHERE id = :id");
												$attUser2->bindParam(':1', $AchievementScore);
												$attUser2->bindParam(':2', $Respect);
												$attUser2->bindParam(':id', $_GET['user']);
												$attUser2->execute();

												addlog('Editou o usuário '.$_GET['user']);

												echo '<div class="alert alert-success background-success">
												<strong>Sucesso!</strong> Usuário editado com sucesso.
												</div>';

												if(isset($_POST['senha']) && !empty($_POST['senha'])){

													if (strlen($senha) >= 6){
														$senha_hash = password_hash($senha, PASSWORD_BCRYPT);
														$attSUser = $PDO2->prepare("UPDATE users SET password = :1 WHERE id = :id");
														$attSUser->bindParam(':1', $senha_hash);
														$attSUser->bindParam(':id', $_GET['user']);
														$attSUser->execute();

														addlog('Editou a senha do usuário '.$_GET['user']);

														echo '<div class="alert alert-success background-success">
														<strong>Sucesso!</strong> Senha do usuário alterada.
														</div>';
													} else {
														echo '<div class="alert alert-danger background-danger">
														<strong>Erro!</strong> A senha deve ter no mínimo 6 caracteres.
														</div>';
													}
												}

											}
										}

										$permissao = $PDO2->prepare("SELECT * FROM users WHERE id = :id");
										$permissao->bindParam(':id', $_GET['user']);
										$permissao->execute();
										$permi = $permissao->fetch();
										if(!$permi){
											echo '<div class="alert alert-danger background-danger">
											<strong>Erro!</strong> Usuário não encontrado.
											</div>';
										} else {

											$permissao2 = $PDO2->prepare("SELECT * FROM user_stats WHERE id = :id");
											$permissao2->bindParam(':id', $_GET['user']);
											$permissao2->execute();
											$permi2 = $permissao2->fetch();

											?>
											<h4 class="sub-title">Editando o usuário <?= $permi['username'];?>.</h4>
											<form method="POST" enctype="multipart/form-data">	
												<?php
												if(isset($mensagem))
												{
													echo $mensagem;
												}
												?>
												<div class="table-responsive">
													<table class="table mb-0">
														<?php
														$json_file = file_get_contents("http://ip-api.com/json/".$permi['ip_last']);
														$json_str = json_decode($json_file, true);
														$user_accounts = $PDO2->prepare("SELECT id FROM users WHERE ip_last = :ip OR ip_reg = :ip");
														$user_accounts->bindValue(':ip', $permi['ip_last']);
														$user_accounts->execute();
														$user_accounts = $user_accounts->rowCount();
														?>
														<tbody>
															<tr>
																<td>Último IP: <?= $permi['ip_last'];?></td>
																<td style="width: 250px;">Cidade: <?= $json_str['city'];?> - <?= $json_str['region'];?></td>
																<td>Provedor: <?= $json_str['org'];?></td>
																<td>MachineID: <?= $permi['machine_id'];?></td>
															</tr>
															<tr>
																<td style="width: 400px;"><a style="color: #212529;" href="/contas-ip/<?= $permi['ip_last'];?>">Há <?=$user_accounts;?> conta<?php if($user_accounts>1)echo"s"; ?> criada<?php if($user_accounts>1)echo"s"; ?> nesse ip, clique aqui para ver.</a></td>
																<td></td>
																<td></td>
																<td></td>
															</tr>
														</tbody>
													</table>
												</div>
												<br>
												<br>
												<br>
												<div class="row">
													<label class="col-sm-4 col-lg-2 col-form-label">Nome de usuário</label>
													<div class="col-sm-8 col-lg-10">
														<div class="input-group">
															<input type="text" name="username" value="<?= $permi['username'];?>" class="form-control">
														</div>
													</div>
												</div>
												<div class="row">
													<label class="col-sm-4 col-lg-2 col-form-label">Missão</label>
													<div class="col-sm-8 col-lg-10">
														<div class="input-group">
															<input type="text" name="motto" value="<?= $permi['motto'];?>" class="form-control">
														</div>
													</div>
												</div>
													<div class="row">
													<label class="col-sm-4 col-lg-2 col-form-label">Créditos</label>
													<div class="col-sm-8 col-lg-10">
														<div class="input-group">
															<input type="number" name="credits" value="<?= $permi['credits'];?>" class="form-control">
														</div>
													</div>
												</div>
													<div class="row">
													<label class="col-sm-4 col-lg-2 col-form-label">Duckets</label>
													<div class="col-sm-8 col-lg-10">
														<div class="input-group">
															<input type="number" name="activity_points" value="<?= $permi['activity_points'];?>" class="form-control">
														</div>
													</div>
												</div>
													<div class="row">
													<label class="col-sm-4 col-lg-2 col-form-label">Diamantes</label>
													<div class="col-sm-8 col-lg-10">
														<div class="input-group">
															<input type="number" name="vip_points" value="<?= $permi['vip_points'];?>" class="form-control">
														</div>
													</div>
												</div>
													<div class="row">
													<label class="col-sm-4 col-lg-2 col-form-label">GOTW</label>
													<div class="col-sm-8 col-lg-10">
														<div class="input-group">
															<input type="number" name="gotw_points" value="<?= $permi['gotw_points'];?>" class="form-control">
														</div>
													</div>
												</div>
												<div class="row">
													<label class="col-sm-4 col-lg-2 col-form-label">Email</label>
													<div class="col-sm-8 col-lg-10">
														<div class="input-group">
															<input type="text" name="mail" value="<?= $permi['mail'];?>" class="form-control">
														</div>
													</div>
												</div>
												<div class="row">
													<label class="col-sm-4 col-lg-2 col-form-label">TAG</label>
													<div class="col-sm-8 col-lg-10">
														<div class="input-group">
															<input type="text" name="prefix_name" value="<?= $permi['prefix_name'];?>" class="form-control">
														</div>
													</div>
												</div>
												<div class="row">
													<label class="col-sm-4 col-lg-2 col-form-label">Cor TAG</label>
													<div class="col-sm-8 col-lg-10">
														<div class="input-group">
															<input type="text" name="prefix_name_color" value="<?= $permi['prefix_name_color'];?>" id="tcolor" class="form-control">
														</div>
													</div>
												</div>
												<div class="row">
													<label class="col-sm-4 col-lg-2 col-form-label">Cor Nick</label>
													<div class="col-sm-8 col-lg-10">
														<div class="input-group">
															<input type="text" name="name_color" value="<?= $permi['name_color'];?>" id="ncolor" class="form-control">
														</div>
													</div>
												</div>
												<div class="row">
													<label class="col-sm-4 col-lg-2 col-form-label">Nível Premiar</label>
													<div class="col-sm-8 col-lg-10">
														<div class="input-group">
															<input type="number" name="Premiar" value="<?= $permi['Premiar'];?>" class="form-control">
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
																	<option <?php if($permi['rank'] == $dnews['id'])echo'selected ';?> value="<?php echo $dnews['id']?>"><?php echo utf8_encode($dnews['name'].' ('.$dnews['id'].')');?></option>
																<?php } ?>
															</select>
														</div>
													</div>
												</div>
												<div class="row">
													<label class="col-sm-4 col-lg-2 col-form-label">Senha loginstaff</label>
													<div class="col-sm-8 col-lg-10">
														<div class="input-group">
															<input type="text" name="pin" value="<?= $permi['pin'];?>" class="form-control">
														</div>
													</div>
												</div>
												<div class="row">
													<label class="col-sm-4 col-lg-2 col-form-label">Ocultar Online</label>
													<div class="col-sm-8 col-lg-10">
														<div class="input-group">
															<select name="hide_online" class="form-control">
																<option <?php if($permi['hide_online'] == "1")echo'selected ';?> value="1">Sim</option>
																<option <?php if($permi['hide_online'] == "0")echo'selected ';?> value="0">Não</option>
															</select>
														</div>
													</div>
												</div>
												<div class="row">
													<label class="col-sm-4 col-lg-2 col-form-label">Ignorar convites</label>
													<div class="col-sm-8 col-lg-10">
														<div class="input-group">
															<select name="ignore_invites" class="form-control">
																<option <?php if($permi['ignore_invites'] == "1")echo'selected ';?> value="1">Sim</option>
																<option <?php if($permi['ignore_invites'] == "0")echo'selected ';?> value="0">Não</option>
															</select>
														</div>
													</div>
												</div>
												<div class="row">
													<label class="col-sm-4 col-lg-2 col-form-label">Permitir Presentes</label>
													<div class="col-sm-8 col-lg-10">
														<div class="input-group">
															<select name="allow_gifts" class="form-control">
																<option <?php if($permi['allow_gifts'] == "1")echo'selected ';?> value="1">Sim</option>
																<option <?php if($permi['allow_gifts'] == "0")echo'selected ';?> value="0">Não</option>
															</select>
														</div>
													</div>
												</div>
												<div class="row">
													<label class="col-sm-4 col-lg-2 col-form-label">Permitir que copiem o visual</label>
													<div class="col-sm-8 col-lg-10">
														<div class="input-group">
															<select name="allow_mimic" class="form-control">
																<option <?php if($permi['allow_mimic'] == "1")echo'selected ';?> value="1">Sim</option>
																<option <?php if($permi['allow_mimic'] == "0")echo'selected ';?> value="0">Não</option>
															</select>
														</div>
													</div>
												</div>
												<div class="row">
													<label class="col-sm-4 col-lg-2 col-form-label">Permitir comando :sexo</label>
													<div class="col-sm-8 col-lg-10">
														<div class="input-group">
															<select name="allow_sex" class="form-control">
																<option <?php if($permi['allow_sex'] == "1")echo'selected ';?> value="1">Sim</option>
																<option <?php if($permi['allow_sex'] == "0")echo'selected ';?> value="0">Não</option>
															</select>
														</div>
													</div>
												</div>
												<div class="row">
													<label class="col-sm-4 col-lg-2 col-form-label">Permitir alerta de eventos</label>
													<div class="col-sm-8 col-lg-10">
														<div class="input-group">
															<select name="allow_events" class="form-control">
																<option <?php if($permi['allow_events'] == "1")echo'selected ';?> value="1">Sim</option>
																<option <?php if($permi['allow_events'] == "0")echo'selected ';?> value="0">Não</option>
															</select>
														</div>
													</div>
												</div>
												<div class="row">
													<label class="col-sm-4 col-lg-2 col-form-label">Placar de conquistas</label>
													<div class="col-sm-8 col-lg-10">
														<div class="input-group">
															<input type="text" name="AchievementScore" value="<?= $permi2['AchievementScore'];?>" class="form-control">
														</div>
													</div>
												</div>
												<div class="row">
													<label class="col-sm-4 col-lg-2 col-form-label">Respeitos Recebidos</label>
													<div class="col-sm-8 col-lg-10">
														<div class="input-group">
															<input type="text" name="Respect" value="<?= $permi2['Respect'];?>" class="form-control">
														</div>
													</div>
												</div>
												<div class="row">
													<label class="col-sm-4 col-lg-2 col-form-label">Nova senha</label>
													<div class="col-sm-8 col-lg-10">
														<div class="input-group">
															<input type="text" name="senha" placeholder="Preencha apenas se deseja alterar a senha." class="form-control">
														</div>
													</div>
												</div>
											</div>
											<center><button type="submit" style="border-radius: 8px;" name="salvar" class="btn btn-primary m-b-0">Salvar</button></center>
										</form>
									<?php }}?>
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
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.0/spectrum.js"></script>
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/spectrum/1.8.0/spectrum.css' />
<script>
	$("#ncolor").spectrum({
		color: "<?= $permi['name_color'];?>",
		preferredFormat: "hex"
	});
	$("#tcolor").spectrum({
		color: "<?= $permi['prefix_name_color'];?>",
		preferredFormat: "hex"
	});
</script>
</body>
</html><?php } else header('Location: ../index'); ?>