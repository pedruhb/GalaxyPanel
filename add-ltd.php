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
									<h4 class="sub-title">Adicionar Raro LTD</h4>
									<?php
									/* Informa o nível dos erros que serão exibidos */
									error_reporting(E_ALL);

									/* Habilita a exibição de erros */
									ini_set("display_errors", 1);

									if(!permissao("addltd")){
										echo '<div style="display: contents;">
										<div class="col-md-12">
										<center><div class="alert alert-danger background-danger" style="width: 30%;">
										<strong>Erro!</strong> Sua subconta não tem permissão para acessar essa página.
										</div></center>
										</div>
										</div>';
									} else {

										function soNumero($str) {
											return preg_replace("/[^0-9]/", "", $str);
										}

										$PDO2 = new PDO('mysql:host='.$iphospedagem.';dbname='.$server['uservestacp']."_hotel", $server['uservestacp']."_hotel", $server['senhavestacp']);

										$aparecer = true;

										if(isset($_POST['adicionar-ltd'])){

											$nome=$_POST['nome'];
											$moedas=0;
											$duckets=0;	
											$diamantes=0;	
											$gotw=0;	
											$furni_id=soNumero($_POST['furni_id']);	
											$page_id=soNumero($_POST['page_id']);	
											$estoque=10;
											$emblema=strtoupper($_POST['emblema']);	

											if(soNumero($_POST['moedas']) > 0)
												$moedas=soNumero($_POST['moedas']);
											if(soNumero($_POST['duckets']) > 0)
												$duckets=soNumero($_POST['duckets']);
											if(soNumero($_POST['diamantes']) > 0)
												$diamantes=soNumero($_POST['diamantes']);	
											if(soNumero($_POST['gotw']) > 0)
												$gotw=soNumero($_POST['gotw']);	
											if(soNumero($_POST['estoque']) > 0)
												$estoque=soNumero($_POST['estoque']);

											$dadosfurni = $PDO2->prepare("SELECT * FROM furniture WHERE id = :furniid");
											$dadosfurni->bindParam(':furniid', $furni_id);
											$dadosfurni->execute();
											$furni = $dadosfurni->fetch();

											$dadospage = $PDO2->prepare("SELECT caption FROM catalog_pages WHERE id = :pageid");
											$dadospage->bindParam(':pageid', $page_id);
											$dadospage->execute();
											$page = $dadospage->fetch();

											if(!$furni){
												echo '<div class="alert alert-danger background-danger">
												<strong>Erro!</strong> Nenhum mobi encontrado com o furni_id enviado.
												</div>'; 
											} else if (!$page){
												echo '<div class="alert alert-danger background-danger">
												<strong>Erro!</strong> Nenhuma página no catálogo encontrada com o id enviado.
												</div>'; 
											} else if($diamantes > 0 & $gotw > 0){
												echo '<div class="alert alert-danger background-danger">
												<strong>Erro!</strong> Não é possível custar diamantes e gotw ao mesmo tempo.
												</div>'; 
											} else {
												echo '<h3>Confirme os dados</h3>';
												echo '<strong>Nome:</strong> '.$nome.'<br>';
												echo '<strong>Valor em Moedas:</strong> '.$moedas.'<br><img draggable="false" src="https://puhekupla.com/images/furni/'.$furni['item_name'].'.png" style="float: right;padding-right: 300px;">';
												echo '<strong>Valor em Duckets:</strong> '.$duckets.'<br>';
												echo '<strong>Valor em Diamantes:</strong> '.$diamantes.'<br>';
												echo '<strong>Valor em GOTW:</strong> '.$gotw.'<br>';
												echo '<strong>Mobi:</strong> ID:'.$furni_id.' / item_name: '.$furni['item_name'].' / ícone: <img draggable="false" src="https://swf.galaxyservers.com.br/dcr/hof_furni/'.$furni['item_name'].'_icon.png"><br>';
												echo '<strong>Página do catálogo:</strong> '.$page_id.' / Nome: '.$page['caption'].'<br>';
												echo '<strong>Lotes disponíveis:</strong> '.$estoque.'<br>';
												if(!empty($emblema))
													echo '<strong>Emblema:</strong> '.$emblema;
												echo '<br><br><br>';
												echo '<form method="POST" name="confirma" enctype="multipart/form-data"><center>
												<input type="hidden" name="nome" value="'.$nome.'">
												<input type="hidden" name="moedas" value="'.$moedas.'">
												<input type="hidden" name="duckets" value="'.$duckets.'">
												<input type="hidden" name="diamantes" value="'.$diamantes.'">
												<input type="hidden" name="gotw" value="'.$gotw.'">
												<input type="hidden" name="furni_id" value="'.$furni_id.'">
												<input type="hidden" name="page_id" value="'.$page_id.'">
												<input type="hidden" name="estoque" value="'.$estoque.'">
												<input type="hidden" name="emblema" value="'.$emblema.'">
												<button type="submit" name="confirma" style="border-radius: 8px;" class="btn btn-primary m-b-0">Adicionar</button>
												<br></center></form>';
												$aparecer = false;
											}
										}

										if(isset($_POST['confirma'])){ 
											try {
												$adicionanadb = $PDO2->prepare("INSERT INTO `catalog_items` (`page_id`, `item_id`, `catalog_name`, `cost_credits`, `cost_diamonds`, `cost_gotw`, `limited_stack`, `badge`, `offer_id`) VALUES (:paid, :fuid, :nome, :moedas, :dimas, :gotw, :estoque, :emblema, '-1');");
												$adicionanadb->bindValue(':nome', $_POST["nome"]);
												$adicionanadb->bindValue(':moedas', $_POST['moedas']);
												$adicionanadb->bindValue(':fuid', $_POST['furni_id']);
												$adicionanadb->bindValue(':paid', $_POST['page_id']);
												$adicionanadb->bindValue(':dimas', $_POST['diamantes']);
												$adicionanadb->bindValue(':estoque', $_POST['estoque']);
												$adicionanadb->bindValue(':emblema', $_POST['emblema']);
												$adicionanadb->bindValue(':gotw', $_POST['gotw']);
												if($adicionanadb->execute()){
													echo '<div class="alert alert-success background-success">
													<strong>Sucesso!</strong> Raro adicionado! atualize o catálogo usando o :cataltd (envia alerta) ou :update cata (sem alerta)
													</div>'; 	
													addlog('Adicionou um raro ao catálogo.');
												}
												else {
													echo '<div class="alert alert-danger background-danger">
													<strong>Erro!</strong> Erro ao adicionar o raro. 
													</div>'; 
												    print_r($adicionanadb->errorInfo());

												}



											}
											catch (Exception $e){
												loginerror(str_replace('C:\xampp\htdocs\add-ltd.php', "", $e));
												addlog('Executou um SQL porém com erro.');
											}

										}

										$pegadados = $PDO->prepare("SELECT nomemoedas,nomeduckets,nomediamantes,nomegotw FROM config_servidores WHERE  `servidor`=".$server['id']);
										$pegadados->execute();
										$pegoudados = $pegadados->fetch();

										if($aparecer != false){
											?>
											<form method="POST" enctype="multipart/form-data">	
												<div class="row">
													<label class="col-sm-4 col-lg-2 col-form-label">Nome</label>
													<div class="col-sm-8 col-lg-10">
														<div class="input-group">																	
															<input type="text" name="nome" class="form-control" placeholder="Nome do mobi. Ex: Serpa Preta" required>
														</div>
													</div>
												</div>															
												<div class="row">
													<label class="col-sm-4 col-lg-2 col-form-label"><?php echo utf8_decode($pegoudados['nomemoedas']);?></label>
													<div class="col-sm-8 col-lg-10">
														<div class="input-group">																	
															<input type="text" name="moedas" class="form-control" placeholder="Valor em <?php echo utf8_decode($pegoudados['nomemoedas']);?>.">
														</div>
													</div>
												</div>
												<div class="row">
													<label class="col-sm-4 col-lg-2 col-form-label"><?php echo utf8_decode($pegoudados['nomeduckets']);?></label>
													<div class="col-sm-8 col-lg-10">
														<div class="input-group">																	
															<input type="text" name="duckets" class="form-control" placeholder="Valor em <?php echo utf8_decode($pegoudados['nomeduckets']);?>.">
														</div>
													</div>
												</div>
												<div class="row">
													<label class="col-sm-4 col-lg-2 col-form-label"><?php echo utf8_decode($pegoudados['nomediamantes']);?></label>
													<div class="col-sm-8 col-lg-10">
														<div class="input-group">
															<input type="text" name="diamantes" class="form-control" placeholder="Valor em <?php echo utf8_decode($pegoudados['nomediamantes']);?>.">
														</div>
													</div>
												</div>
												<div class="row">
													<label class="col-sm-4 col-lg-2 col-form-label"><?php echo utf8_decode($pegoudados['nomegotw']);?></label>
													<div class="col-sm-8 col-lg-10">
														<div class="input-group">
															<input type="text" name="gotw"  class="form-control" placeholder="Valor em <?php echo utf8_decode($pegoudados['nomegotw']);?>. (Você não pode usar <?php echo utf8_decode($pegoudados['nomegotw']);?> e <?php echo utf8_decode($pegoudados['nomediamantes']);?> ao mesmo tempo...).">
														</div>
													</div>
												</div>
												<div class="row">
													<label class="col-sm-4 col-lg-2 col-form-label">Furniture ID</label>
													<div class="col-sm-8 col-lg-10">
														<div class="input-group">
															<input type="text" name="furni_id" class="form-control" placeholder="ID da tabela furniture do mobi correspondente." required>
														</div>
													</div>
												</div>										
												<div class="row">
													<label class="col-sm-4 col-lg-2 col-form-label">Página</label>
													<div class="col-sm-8 col-lg-10">
														<div class="input-group">
															<select name="page_id" class="form-control">
																<?php
																$getArtdicles = $PDO2->prepare("SELECT id,caption FROM catalog_pages WHERE page_layout != \"info_duckets\" and page_layout != \"marketplace_own_items\" 
																	and page_layout != \"marketplace\" and page_layout != \"badge_display\" and page_layout != \"bots\"  and page_layout != \"soundmachine\" and page_layout != \"trophies\" and page_layout != \"roomads\" and page_layout != \"single_bundle\" and page_layout != \"recycler\"  and page_layout != \"pets3\" and page_layout != \"pets\" and enabled = \"1\" and visible = \"1\" and page_link != \"ultimas_compras\" ORDER BY id");
																$getArtdicles->execute();
																while($dnews = $getArtdicles->fetch())
																{
																	$nomecata = str_replace("HOTELNAME", $server['nomehotel'], utf8_encode($dnews['caption']));



																	?>
																	<option value="<?= $dnews['id']?>"><?= $nomecata;?> - <?= $dnews['id']?></option>
																<?php } ?>
															</select>
														</div>
													</div>
												</div>
												<div class="row">
													<label class="col-sm-4 col-lg-2 col-form-label">Estoque</label>
													<div class="col-sm-8 col-lg-10">
														<div class="input-group">
															<input type="text" name="estoque"  class="form-control" placeholder="Quantidade de raros que serão disponibilizados." required>
														</div>
													</div>
												</div>
												<div class="row">
													<label class="col-sm-4 col-lg-2 col-form-label">Emblema</label>
													<div class="col-sm-8 col-lg-10">
														<div class="input-group">
															<input type="text" name="emblema"  class="form-control" placeholder="Emblema que será dado ao comprar (caso não tenha deixe em branco).">
														</div>
													</div>
												</div>
											</div>
											<center><button type="submit" style="border-radius: 8px;" name="adicionar-ltd" class="btn btn-primary m-b-0">Adicionar</button><br></center><?php }?>
										</form>
									</div>
								<?php }?>
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