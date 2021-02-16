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
									<?php
									if(!permissao("gerenciarltd")){
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
										
										$id = $_GET['id'];

										if(isset($_POST['editar'])){

											$nome = utf8_encode($_POST['nome']);
											$moedas = $_POST['moedas'];
											$diamantes = $_POST['diamantes'];
											$gotw = $_POST['gotw'];
											$estoque = $_POST['estoque'];
											$vendidos = $_POST['vendidos'];
											$emblema = $_POST['emblema'];
											$pagina = $_POST['pagina'];

											$updateraro = $PDO2->prepare("UPDATE `catalog_items` SET `catalog_name`= :nome, `cost_credits`= :moedas, `cost_diamonds`= :diamantes, `cost_gotw`=:gotw, `limited_sells`= :vendas, `limited_stack`= :estoque, `badge`= :emblema, `page_id`= :pagina WHERE  `id`= :id");
											$updateraro->bindParam(':nome', $nome);
											$updateraro->bindParam(':moedas', $moedas);
											$updateraro->bindParam(':diamantes', $diamantes);
											$updateraro->bindParam(':gotw', $gotw);
											$updateraro->bindParam(':vendas', $vendidos);
											$updateraro->bindParam(':estoque', $estoque);
											$updateraro->bindParam(':emblema', $emblema);
											$updateraro->bindParam(':pagina', $pagina);
											$updateraro->bindParam(':id', $id);
											$updateraro->execute();

											echo '<div class="alert alert-success background-success">
											<strong>Sucesso!</strong> Alterações salvas com sucesso, utilize o comando :update cata para atualizar o catálogo.
											</div>';
										}

										$itemcatalog = $PDO2->prepare("SELECT * FROM catalog_items WHERE id = :id");
										$itemcatalog->bindParam(':id', $id);
										$itemcatalog->execute();
										$itemcatalog = $itemcatalog->fetch();

										$pages = $PDO2->prepare("SELECT id,caption FROM catalog_pages WHERE id = '".$itemcatalog['page_id']."'");
										$pages->execute();
										$pages = $pages->fetch();

										$permissao = $PDO2->prepare("SELECT * FROM catalog_items WHERE id = '".gs($_GET['id'])."' LIMIT 1");
										$permissao->execute();
										$pagina = $permissao->fetch();
										if(!$pagina){
											echo '<div class="alert alert-danger background-danger">
											<strong>Erro!</strong> Página não encontrada.
											</div>';
										} else {
											?>
											<h4 class="sub-title">Editando um raro.</h4>
											<form method="POST">	
												<div class="row">
													<label class="col-sm-4 col-lg-2 col-form-label">Nome</label>
													<div class="col-sm-8 col-lg-10">
														<div class="input-group">
															<input type="text" name="nome" value="<?= $itemcatalog['catalog_name'];?>" class="form-control">
														</div>
													</div>
												</div>
												<div class="row">
													<label class="col-sm-4 col-lg-2 col-form-label">Moedas</label>
													<div class="col-sm-8 col-lg-10">
														<div class="input-group">
															<input type="number" name="moedas" value="<?= $itemcatalog['cost_credits'];?>" class="form-control">
														</div>
													</div>
												</div>
												<div class="row">
													<label class="col-sm-4 col-lg-2 col-form-label">Diamantes</label>
													<div class="col-sm-8 col-lg-10">
														<div class="input-group">
															<input type="number" name="diamantes" value="<?= $itemcatalog['cost_diamonds'];?>" class="form-control">
														</div>
													</div>
												</div>
												<div class="row">
													<label class="col-sm-4 col-lg-2 col-form-label">GOTW</label>
													<div class="col-sm-8 col-lg-10">
														<div class="input-group">
															<input type="number" name="gotw" value="<?= $itemcatalog['cost_gotw'];?>" class="form-control">
														</div>
													</div>
												</div>
												<div class="row">
													<label class="col-sm-4 col-lg-2 col-form-label">Estoque</label>
													<div class="col-sm-8 col-lg-10">
														<div class="input-group">
															<input type="number" name="estoque" value="<?= $itemcatalog['limited_stack'];?>" class="form-control">
														</div>
													</div>
												</div>
												<div class="row">
													<label class="col-sm-4 col-lg-2 col-form-label">Vendidos</label>
													<div class="col-sm-8 col-lg-10">
														<div class="input-group">
															<input type="number" name="vendidos" value="<?= $itemcatalog['limited_sells'];?>" class="form-control">
														</div>
													</div>
												</div>
												<div class="row">
													<label class="col-sm-4 col-lg-2 col-form-label">Emblema</label>
													<div class="col-sm-8 col-lg-10">
														<div class="input-group">
															<input type="text" name="emblema" value="<?= $itemcatalog['badge'];?>" class="form-control">
														</div>
													</div>
												</div>
												<div class="row">
													<label class="col-sm-4 col-lg-2 col-form-label">Página</label>
													<div class="col-sm-8 col-lg-10">
														<div class="input-group">
															<select name="pagina" class="form-control">
																<?php
																$getArtdicles = $PDO2->prepare("SELECT id, caption FROM catalog_pages");
																$getArtdicles->execute();
																while($dnews = $getArtdicles->fetch())
																{

																	$nomecata = str_replace("HOTELNAME", $server['nomehotel'], $dnews['caption']);
																	if(mb_detect_encoding($dnews['caption']) == "UTF-8")
																		$nomecata = utf8_decode(str_replace("HOTELNAME", $server['nomehotel'], $nomecata));

																	?>
																	<option <?php if($itemcatalog['page_id']== $dnews['id'])echo'selected ';?> value="<?php echo $dnews['id']?>"><?= $nomecata;?> (<?= $dnews['id'];?>)</option>
																<?php } ?>
															</select>
														</div>
													</div>
												</div>
											</div>
											<center><button type="submit" style="border-radius: 8px;" name="editar" class="btn btn-primary m-b-0">Salvar</button></center>
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
</body>
</html><?php } else header('Location: ../index'); ?>