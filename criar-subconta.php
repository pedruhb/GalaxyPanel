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
	if(isset($_SESSION['subconta']))
		return;
	?>
	<div class="pcoded-content">
		<div class="pcoded-inner-content">
			<div class="main-body user-profile">
				<div class="page-wrapper">
					<div class="page-body">
						<div class="card">
							<div class="card-block">
								<div class="m-b-20">
									<h4 class="sub-title">Crie uma sub conta para seu hotel.</h4>
									<form method="POST" enctype="multipart/form-data">	
										<?php

										if(isset($_POST['add'])){

											$usuario = $_SESSION['nomeusuario']."_".$_POST['usuario'];
											$senha = $_POST['senha'];

											$verificacontas = $PDO->prepare("SELECT id FROM sub_contas WHERE usuario = :usuario;");
											$verificacontas->bindParam(":usuario", $usuario);
											$verificacontas->execute();
											$verificaconta = $verificacontas->rowCount();
											if(empty($_POST['usuario']) || !isset($_POST['usuario']) || empty($senha)){
												echo '<div class="alert alert-danger background-danger">
												<strong>Erro!</strong> Há dados faltando.
												</div>';
											}
											else if($verificaconta > 0){
												echo '<div class="alert alert-danger background-danger">
												<strong>Erro!</strong> Já existe uma subconta com esse usuário.
												</div>';
											} else {

												$addconta = $PDO->prepare("INSERT INTO `sub_contas` (`usuario`, `senha`, `servidor`) VALUES (:usuario, :senha, :server);");
												$addconta->bindParam(":usuario", $usuario);
												$addconta->bindParam(":senha", $senha);
												$addconta->bindValue(":server", $server['id']);
												$addconta->execute();

												$id_sub = $PDO->lastInsertId();;

												$sql1 = "(id,";
												$sql2 = "(".$id_sub.",";

												$pegaoscaralho = $PDO->prepare("SELECT * FROM sub_permissoes_name;");
												$pegaoscaralho->execute();
												while($caralho = $pegaoscaralho->fetch())
												{
													$sql1 .= $caralho['perm'].",";
													$sql2 .= ":".$caralho['perm'].",";											
												}
												$sql1 = substr($sql1,0, strlen($sql1)-1);
												$sql2 = substr($sql2,0, strlen($sql2)-1);
												$sql1 .= ")";
												$sql2 .= ")";

												$sql_exec = "INSERT INTO sub_contas_perm ".$sql1." VALUES ".$sql2;

												$insereaporra = $PDO->prepare($sql_exec);
												$pegaoscaralho = $PDO->prepare("SELECT * FROM sub_permissoes_name;");
												$pegaoscaralho->execute();
												while($caralho = $pegaoscaralho->fetch())
												{
													$insereaporra->bindValue(':'.$caralho['perm'], $_POST[$caralho['perm']]);
												}
												$insereaporra->execute();

												addlog('Adicionou uma sub conta.');

												echo '<div class="alert alert-success background-success">
												<strong>Sucesso!</strong> Subconta '.$usuario.' criada com sucesso!
												</div>';
											}

										}

										?>
										<div class="row">
											<label class="col-sm-4 col-lg-2 col-form-label">Usuário</label>
											<div class="col-sm-8 col-lg-10">
												<div class="input-group">
													<input type="text" name="usuario" class="form-control" required>
												</div>
											</div>
										</div>
										<div class="row">
											<label class="col-sm-4 col-lg-2 col-form-label">Senha</label>
											<div class="col-sm-8 col-lg-10">
												<div class="input-group">
													<input type="text" name="senha" class="form-control" required>
												</div>
											</div>
										</div>
										<?php
										$getArtdicles = $PDO->prepare("SELECT * FROM sub_permissoes_name;");
										$getArtdicles->execute();
										while($dnews = $getArtdicles->fetch())
										{
											?>
											<div class="row">
												<label class="col-sm-4 col-lg-2 col-form-label"><?= utf8_encode($dnews['info']);?></label>
												<div class="col-sm-8 col-lg-10">
													<div class="input-group">
														<select name="<?= $dnews['perm'];?>" required class="form-control">
															<option value="false">Não</option>
															<option value="true">Sim</option>
														</select>
													</div>
												</div>
											</div>
										<?php }?>
									</div>
									<center><button type="submit" style="border-radius: 8px;" name="add" class="btn btn-primary m-b-0">Salvar</button></center>
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