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
									<h4 class="sub-title">Editando o emblema <?php echo $_GET['cod'];?></h4>
									<form method="POST" enctype="multipart/form-data">	
										<?php
										if(!permissao("embhospedados")){
											echo '<div style="display: contents;">
											<div class="col-md-12">
											<center><div class="alert alert-danger background-danger" style="width: 30%;">
											<strong>Erro!</strong> Sua subconta não tem permissão para acessar essa página.
											</div></center>
											</div>
											</div>';
										} else {
											if( $_SERVER['REQUEST_METHOD']=='POST' )
											{
												$EditaEmblema = $PDO->prepare("UPDATE emblemas SET nome = '".gs($_POST['nome'])."', descricao = '".gs($_POST['desc'])."' WHERE codigo = '".gs($_GET['cod'])."' AND usuario = '".gs($server['uservestacp'])."';");
												if(!$EditaEmblema->execute()){
													echo '<div class="alert alert-danger background-danger">
													<strong>Erro!</strong> Houve um erro ao editar o emblema.
													</div>'; 
												} else {
													echo '<div class="alert alert-success background-success">
													<strong>Successo!</strong> Emblema editado com sucesso!
													</div>';

													addlog('Editou o emblema '.$_GET['cod']);

												}
											}
											$DadosEmblema = $PDO->prepare("SELECT * FROM emblemas WHERE codigo = '".gs($_GET['cod'])."' AND usuario = '".$server['uservestacp']."';");
											$DadosEmblema->execute();
											$DadoEmblemas = $DadosEmblema->fetch();

											if (!$DadoEmblemas){
												$editar = false;
												echo '<div class="alert alert-danger background-danger">
												<strong>Erro!</strong> Emblema não encontrado no banco de dados.
												</div>'; 
											} else {
												$editar = true;
											}
											if($editar){
												?>
												<div class="row">
													<label class="col-sm-4 col-lg-2 col-form-label">Nome</label>
													<div class="col-sm-8 col-lg-10">
														<div class="input-group">																	<input type="text" name="nome" value="<?php echo $DadoEmblemas['nome'];?>" class="form-control" placeholder="Nome do emblema" required>
														</div>
													</div>
												</div>
												<div class="row">
													<label class="col-sm-4 col-lg-2 col-form-label">Descrição</label>
													<div class="col-sm-8 col-lg-10">
														<div class="input-group">
															<input type="text" name="desc" value="<?php echo $DadoEmblemas['descricao'];?>" class="form-control" placeholder="Descrição do emblema" required>
														</div>
													</div>
												</div>

											</div>
											<center><button type="submit" name="hospedar-emblema" style="border-radius: 8px;" class="btn btn-primary m-b-0">Salvar</button></center>
										<?php } } ?>
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