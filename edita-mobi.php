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
										$id= $_GET['id'];
										$creditos = $_POST['creditos'];   
										$duckets = $_POST['duckets'];   
										$diamantes = $_POST['diamantes'];   
										$gotw = $_POST['gotw'];   
										$pagina = $_POST['pagina'];   
										$emblema = $_POST['emblema'];   


										if($diamantes > 0 && $gotw > 0){
											$mensagem = '<div class="alert alert-danger background-danger">
											<strong>Erro!</strong> não é possível usar diamante e gotw ao mesmo tempo!
											</div>';
										} else {

											$att = $PDO2->prepare("UPDATE catalog_items SET `cost_credits`= :cost_credits, `cost_pixels`= :cost_pixels, `cost_diamonds`= :cost_diamonds, `cost_gotw`= :cost_gotw, `page_id`= :page_id, `badge`= :badge WHERE `id`=:id;");
											$att->bindParam(":cost_credits", $creditos);
											$att->bindParam(":cost_pixels", $duckets);
											$att->bindParam(":cost_diamonds", $diamantes);
											$att->bindParam(":cost_gotw", $gotw);
											$att->bindParam(":page_id", $pagina);
											$att->bindParam(":badge", $emblema);
											$att->bindParam(":id", $id);
											$att->execute();

											addlog('Editou o mobi '.$id);

											$mensagem = '<div class="alert alert-success background-success">
											<strong>Successo!</strong> alterações salvas.
											</div>';

											echo "<!--";
											sendRCONCommand2('reload_catalog', '', $ipvps, $server['portamus']);
											echo "-->";
											
										}
									}

									$permissao = $PDO2->prepare("SELECT *,(SELECT item_name FROM furniture WHERE id = item_id) as furniturename FROM catalog_items WHERE id = :id LIMIT 1");
									$permissao->bindParam(":id", $_GET['id']);
									$permissao->execute();
									$pagina = $permissao->fetch();
									if(!$pagina){
										echo '<div class="alert alert-danger background-danger">
										<strong>Erro!</strong> Mobis não encontrado!
										</div>';
									} else {
										?>
										<span>Editando mobi <?php echo '<img draggable="false" src="'.$linkswf_api.'/dcr/hof_furni/'.$pagina['furniturename'].'_icon.png"> '.$pagina['furniturename'];?></span>
										<form method="POST">	
											<br>
											<?php
											if(isset($mensagem))
												echo $mensagem;
											?>
											<div class="row">
												<label class="col-sm-4 col-lg-2 col-form-label">Créditos</label>
												<div class="col-sm-8 col-lg-10">
													<div class="input-group">
														<input type="text" name="creditos" value="<?php echo $pagina['cost_credits'];?>" class="form-control">
													</div>
												</div>
											</div>
											<div class="row">
												<label class="col-sm-4 col-lg-2 col-form-label">Duckets</label>
												<div class="col-sm-8 col-lg-10">
													<div class="input-group">
														<input type="text" name="duckets" value="<?php echo $pagina['cost_pixels'];?>" class="form-control">
													</div>
												</div>
											</div>
											<div class="row">
												<label class="col-sm-4 col-lg-2 col-form-label">Diamantes</label>
												<div class="col-sm-8 col-lg-10">
													<div class="input-group">
														<input type="text" name="diamantes" value="<?php echo $pagina['cost_diamonds'];?>" class="form-control">
													</div>
												</div>
											</div>
											<div class="row">
												<label class="col-sm-4 col-lg-2 col-form-label">GOTW</label>
												<div class="col-sm-8 col-lg-10">
													<div class="input-group">
														<input type="text" name="gotw" value="<?php echo $pagina['cost_gotw'];?>" class="form-control">
													</div>
												</div>
											</div>
											<div class="row">
												<label class="col-sm-4 col-lg-2 col-form-label">Página catálogo</label>
												<div class="col-sm-8 col-lg-10">
													<div class="input-group">
														<select name="pagina" class="form-control">
															<?php
															$getArtdicles = $PDO2->prepare("SELECT id,caption FROM catalog_pages ORDER BY id");
															$getArtdicles->execute();
															while($dnews = $getArtdicles->fetch())
															{
																?>
																<option <?php if($pagina['page_id'] == $dnews['id'])echo'selected ';?> value="<?php echo $dnews['id']?>"><?php echo str_replace("HOTELNAME", $server['nomehotel'], utf8_encode($dnews['caption'])).' ('.$dnews['id'].')';?></option>
															<?php } ?>
														</select>
													</div>
												</div>
											</div>
											<div class="row">
												<label class="col-sm-4 col-lg-2 col-form-label">Emblema</label>
												<div class="col-sm-8 col-lg-10">
													<div class="input-group">
														<input type="text" name="emblema" value="<?php echo $pagina['badge'];?>" class="form-control">
													</div>
												</div>
											</div>
										</div>
										<center><button type="submit" style="border-radius: 8px;" name="hospedar-emblema" class="btn btn-primary m-b-0">Salvar</button></center>
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