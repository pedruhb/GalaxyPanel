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
							<?php
							if(!permissao("catalogo")){
								echo '<div style="display: contents;">
								<div class="col-md-12">
								<center><div class="alert alert-danger background-danger" style="width: 30%;">
								<strong>Erro!</strong> Sua subconta não tem permissão para acessar essa página.
								</div></center>
								</div>
								</div>';
							} else {
								?>
							<div class="card-block">
								<div class="m-b-20">
									<?php
									try {
										$PDO2 = new PDO('mysql:host='.$iphospedagem.';dbname='.$server['uservestacp']."_hotel", $server['uservestacp']."_hotel", $server['senhavestacp']);
										$PDO2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
									} catch(PDOException $e) {
										echo '<script>alert("Erro de conexão ao hotel: ' . utf8_encode($e->getMessage()).'");</script>';
									}
									if( $_SERVER['REQUEST_METHOD']=='POST' )
									{
										$id=gs($_GET['id']);
										$nome = str_replace($server['nomehotel'], "HOTELNAME", $_POST['nome']);
										$nome = utf8_decode($nome);
										$parentid = gs($_POST['parentid']);   
										$icon = gs($_POST['icon']); 
										$ordem = gs($_POST['ordem']); 
										$rank = gs($_POST['rank']);  
										$strings1 = gs($_POST['strings1']);   
										$visivel = gs($_POST['visivel']);    

										$att = $PDO2->prepare("UPDATE `catalog_pages` SET `parent_id`='".$parentid."', `caption`='".$nome."', `icon_image`='".$icon."', `visible`='".$visivel."', `min_rank`='".$rank."', `order_num`='".$ordem."', `page_strings_1`='".$strings1."' WHERE `id`='".$id."';");
										$att->execute();

										addlog('Editou uma página no catálogo ('.$_GET['id'].')');

										$mensagemsucesso='<div class="alert alert-success background-success">
										<strong>Successo!</strong> alterações salvas.
										</div>';

										echo "<!--";
										sendRCONCommand2('reload_catalog', '', $ipvps, $server['portamus']);
										echo "-->";
									}

									$permissao = $PDO2->prepare("SELECT * FROM catalog_pages WHERE id = '".gs($_GET['id'])."' limit 1");
									$permissao->execute();
									$pagina = $permissao->fetch();
									if(!$pagina){
										echo '<div class="alert alert-danger background-danger">
										<strong>Erro!</strong> Página não encontrada.
										</div>';
									} else {
										?>
										<h4 class="sub-title">Editando a página <?php echo '<img draggable="false" src="'.$cimagesswf.'catalogue/icon_'.$pagina['icon_image'].'.png"> '.utf8_encode(str_replace("HOTELNAME", $server['nomehotel'], $pagina['caption']));?></h4>
										<form method="POST">	
											<?php
											if(isset($mensagemsucesso))
												echo $mensagemsucesso;
											?>
											<div class="row">
												<label class="col-sm-4 col-lg-2 col-form-label">Nome</label>
												<div class="col-sm-8 col-lg-10">
													<div class="input-group">
														<input type="text" name="nome" value="<?php echo utf8_encode(str_replace("HOTELNAME", $server['nomehotel'], $pagina['caption']));?>" class="form-control">
													</div>
												</div>
											</div>
											<div class="row">
												<label class="col-sm-4 col-lg-2 col-form-label">Parent ID</label>
												<div class="col-sm-8 col-lg-10">
													<div class="input-group">
														<input type="text" name="parentid" value="<?php echo $pagina['parent_id'];?>" class="form-control">
													</div>
												</div>
											</div>
											<div class="row">
												<label class="col-sm-4 col-lg-2 col-form-label">Ícone</label>
												<div class="col-sm-8 col-lg-10">
													<div class="input-group">
														<input type="text" name="icon" value="<?php echo $pagina['icon_image'];?>" class="form-control">
													</div>
												</div>
											</div>
											<div class="row">
												<label class="col-sm-4 col-lg-2 col-form-label">Ordem</label>
												<div class="col-sm-8 col-lg-10">
													<div class="input-group">
														<input type="text" name="ordem" value="<?php echo $pagina['order_num'];?>" class="form-control">
													</div>
												</div>
											</div>
											<div class="row">
												<label class="col-sm-4 col-lg-2 col-form-label">Visível</label>
												<div class="col-sm-8 col-lg-10">
													<div class="input-group">
														<select name="visivel"  class="form-control">
															<option <?php if($pagina['visible'] == '1')echo'selected ';?> value="1">Sim</option>
															<option <?php if($pagina['visible'] == '0')echo'selected ';?> value="0">Não</option>
														</select>				
													</div>
												</div>
											</div>
											<div class="row">
												<label class="col-sm-4 col-lg-2 col-form-label">Rank mínimo</label>
												<div class="col-sm-8 col-lg-10">
													<div class="input-group">
														<select name="rank" class="form-control">
															<?php
															$getArtdicles = $PDO2->prepare("SELECT id,name FROM ranks ORDER BY id");
															$getArtdicles->execute();
															while($dnews = $getArtdicles->fetch())
															{
																?>
																<option <?php if($pagina['min_rank'] == $dnews['id'])echo'selected ';?> value="<?php echo $dnews['id']?>"><?php echo utf8_encode($dnews['name'].' ('.$dnews['id']).')';?></option>
																<?php } ?>
															</select>
														</div>
													</div>
												</div>
												<div class="row">
													<label class="col-sm-4 col-lg-2 col-form-label">Strings 1</label>
													<div class="col-sm-8 col-lg-10">
														<div class="input-group">
															<input type="text" name="strings1" value="<?php echo $pagina['page_strings_1'];?>" class="form-control">
														</div>
													</div>
												</div>
											</div>
											<center><button type="submit" style="border-radius: 8px;" name="hospedar-emblema" class="btn btn-primary m-b-0">Salvar</button></center>
										</form>
										<?php }?>
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