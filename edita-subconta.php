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
									<h4 class="sub-title">Editando subconta</h4>
									<form method="POST" enctype="multipart/form-data">	
										<?php

										if(isset($_POST['add'])){

											$sql1 = "";

											$pegaoscaralho = $PDO->prepare("SELECT * FROM sub_permissoes_name;");
											$pegaoscaralho->execute();
											while($caralho = $pegaoscaralho->fetch())
											{
												$sql1 .= $caralho['perm']." = :".$caralho['perm'].",";
											}
											$sql1 = substr($sql1,0, strlen($sql1)-1);

											$sql_exec = "UPDATE sub_contas_perm SET ".$sql1." WHERE id = :id";

											$insereaporra = $PDO->prepare($sql_exec);
											$pegaoscaralho = $PDO->prepare("SELECT * FROM sub_permissoes_name;");
											$pegaoscaralho->execute();
											while($caralho = $pegaoscaralho->fetch())
											{
												$insereaporra->bindValue(':'.$caralho['perm'], $_POST[$caralho['perm']]);
											}
											$insereaporra->bindValue(':id', $_GET['id']);
											$insereaporra->execute();

											addlog('Editou uma sub conta.');

											echo '<div class="alert alert-success background-success">
											<strong>Sucesso!</strong> Subconta  editada com sucesso!
											</div>';

										}

										$verificacontas = $PDO->prepare("SELECT * FROM sub_contas WHERE id = :id;");
										$verificacontas->bindParam(":id", $_GET['id']);
										$verificacontas->execute();
										$verificacontas = $verificacontas->fetch();

										$verificacontas2 = $PDO->prepare("SELECT * FROM sub_contas_perm WHERE id = :id;");
										$verificacontas2->bindParam(":id", $_GET['id']);
										$verificacontas2->execute();
										$verificacontas2 = $verificacontas2->fetch();

										if($verificacontas['servidor'] != $server['id']){
											
											echo '<div class="alert alert-danger background-danger">
												<strong>Erro!</strong> Essa subconta não é sua.
											</div>';
										} else { ?>
											<div class="row">
												<label class="col-sm-4 col-lg-2 col-form-label">Usuário</label>
												<div class="col-sm-8 col-lg-10">
													<div class="input-group">
														<input type="text" class="form-control" value="<?= $verificacontas['usuario'];?>" disabled>
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
																<option <?php if(strpos($verificacontas2[$dnews['perm']], 'true') !== true) echo "selected" ?> value="false">Não</option>
																<option <?php if(strpos($verificacontas2[$dnews['perm']], 'true') !== false) echo "selected" ?> value="true">Sim</option>
															</select>
														</div>
													</div>
												</div>
											<?php }?>
										</div>
										<center><button type="submit" style="border-radius: 8px;" name="add" class="btn btn-primary m-b-0">Salvar</button></center>
									<?php } ?>
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