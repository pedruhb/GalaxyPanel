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
								<div class="main-body">
									<div class="page-wrapper">
										<div class="page-body">
											<div class="col-sm-12" style="padding-top:20px">
												<div class="card">
													<div class="card-header">
														<h5>Emblemas de games hospedados no servidor.</h5>
														<span>Para instalar aperte o botão aplicar.</span>
														<div class="card-header-right"><i class="icofont icofont-spinner-alt-5"></i></div>
													</div>
													<div class="row card-block">
														<div class="col-md-12">
															<ul class="list-view">
																<li>																			

																	<?php

													if(!permissao("embgames")){
													echo '<div style="display: contents;">
													<div class="col-md-12">
													<center><div class="alert alert-danger background-danger" style="width: 30%;">
													<strong>Erro!</strong> Sua subconta não tem permissão para acessar essa página.
													</div></center>
													</div>
													</div>';
												} else {

if(isset($_POST['aplicar'])){
$limite = $_POST['limite'];
$cod = $_POST['cod'];
$AtualizaNaDB = $PDO->prepare("UPDATE `config_servidores` SET `emblemapremiar`= :cod,`nivelmax`='".$limite."' WHERE `servidor`= '".$server['id']."';");
$AtualizaNaDB->bindParam(":cod", $cod);
$AtualizaNaDB->execute();

$PegaEstadoAtual = $PDO->prepare("SELECT * FROM config_servidores WHERE servidor = '".$server['id']."'");
$PegaEstadoAtual->execute();
$EstadoAtual = $PegaEstadoAtual->fetch();

$configemuPHB = "## Nome dos pontos (GOTW)
coin.points.name=".utf8_decode($EstadoAtual['nomegotw'])."
### Nome moedas
coin.credits.name=".utf8_decode($EstadoAtual['nomemoedas'])."
### Nome duckets
coin.duckets.name=".utf8_decode($EstadoAtual['nomeduckets'])."
### Nome diamantes
coin.diamonds.name=".utf8_decode($EstadoAtual['nomediamantes'])."

## Staffs
staff.effect.inroom=false
staff.mensg.inroom=false

## Camera (cuidado ao mecher nos links)
camera.enable=true
camera.api.http=".$server['http']."://".$server['linkhotel']."/camera/
camera.output.pictures=".$server['http']."://".$server['linkhotel']."/camera/pictures/
camera.picture.purchase.alert.id=false
camera.photo.publish.price.duckets=10
camera.photo.purchase.item_id=1100001495
camera.photo.purchase.price.coins=00
camera.photo.purchase.price.duckets=10
camera.preview.maxcache=1000

## Rank mínimo para ter acesso a ferramente de embaixador
ambassador.minrank=".$EstadoAtual['rankminimoferramentaemb']."

## Emblema staff sobre a cabeça
emblemacabeca.staff=".$EstadoAtual['emblemacabecastaff']."
emblemacabeca.embaixador=".$EstadoAtual['emblemacabecaemb']."

## Configuração dos Quartos
Quartovip=".$EstadoAtual['quartovip']."
Prisao=".$EstadoAtual['quartoprisao']."

## Premio por atividade
PremioPorAtividade=".$EstadoAtual['premioporatividade']."
MensagemAoReceber=true
Intervalo=".$EstadoAtual['tempoon']."

# Comando Premiar
NiveltotalGames=".$limite."
CodEmblemaNivel=".$cod."

### Nick de quem pode usar o comando reiniciar
ReiniciarPermissao=".$EstadoAtual['reiniciargalaxy']."

## Rank que vai aparecer balão embaixador
RankEmbaixador=".$EstadoAtual['rankbalaoemb']."

### Premiação diária
PremiacaoDiaria=".$EstadoAtual['premiodiario']."
";

$arquivo = "galaxyservers/emuladores/".$server['uservestacp']."/Config/extras.ini";
$fp = fopen($arquivo, "w");
$escreve = fwrite($fp, $configemuPHB);
fclose($fp);

addlog('Alterou o emblema de games.');

	echo '<div class="alert alert-success background-success">Emblema alterado com sucesso.</div>';


sendRCONCommand2('reload_extras', '', $ipvps, $server['portamus']);

																	}

																$noticias = $PDO->prepare("SELECT *,(SELECT visual FROM admin WHERE login = user) AS visual FROM emblemas_game ORDER BY id DESC");
																$noticias->execute();
																while($noticia = $noticias->fetch()){
																	$codemblema = $noticia['codigo'];
																	$quantidade = $noticia['qnt'];
																	echo'<!--- ---->
																	<div class="card list-view-media">
																	<div class="card-block">
																	<div class="media">
																	<a class="media-left">
																	<img class="media-object card-list-img" draggable="false" src="https://www.habbo.com/habbo-imaging/avatarimage?hb=img&figure='.$noticia['visual'].'&action=sit,crr=667&gesture=sml&direction=2&head_direction=2&size=m&img_format=png" alt="Foto de usuário">
																	<br><center>Por '.$noticia['user'].'</center>
																	</a>
																	<div class="media-body">
																	<div class="col-xs-12">
																	<h6 class="d-inline-block">
																	'.$noticia['titulo'].' (Nível total: '.$quantidade.')</h6>
																	</div>
																	<div class="f-13 text-muted m-b-15">
																	Código: '.$codemblema.'
																	</div>
																	<img class="media-object card-list-img" draggable="false" src="'.$linkapiemblema.''.$codemblema.'1" alt="Emblema" style="padding-left: 10px;">
																	<img class="media-object card-list-img" draggable="false" src="'.$linkapiemblema.''.$codemblema.'10" alt="Emblema"  style="padding-left: 10px;">
																	<img class="media-object card-list-img" draggable="false" src="'.$linkapiemblema.''.$codemblema.'20" alt="Emblema"  style="padding-left: 10px;">
																	<img class="media-object card-list-img" draggable="false" src="'.$linkapiemblema.''.$codemblema.'30" alt="Emblema"  style="padding-left: 10px;">
																	<img class="media-object card-list-img" draggable="false" src="'.$linkapiemblema.''.$codemblema.'40" alt="Emblema"  style="padding-left: 10px;">
																	<img class="media-object card-list-img" draggable="false" src="'.$linkapiemblema.''.$codemblema.'50" alt="Emblema"  style="padding-left: 10px;">
																	<img class="media-object card-list-img" draggable="false" src="'.$linkapiemblema.''.$codemblema.'60" alt="Emblema"  style="padding-left: 10px;">
																	<img class="media-object card-list-img" draggable="false" src="'.$linkapiemblema.''.$codemblema.'70" alt="Emblema"  style="padding-left: 10px;">
																	<img class="media-object card-list-img" draggable="false" src="'.$linkapiemblema.''.$codemblema.'80" alt="Emblema"  style="padding-left: 10px;">
																	<img class="media-object card-list-img" draggable="false" src="'.$linkapiemblema.''.$codemblema.'90" alt="Emblema"  style="padding-left: 10px;">
																	<img class="media-object card-list-img" draggable="false" src="'.$linkapiemblema.''.$codemblema.'100" alt="Emblema"  style="padding-left: 10px;">
																	'; if($quantidade == 200) echo '<br><br><img class="media-object card-list-img" draggable="false" src="'.$linkapiemblema.''.$codemblema.'100" alt="Emblema" style="padding-left: 10px;">
																	<img class="media-object card-list-img" draggable="false" src="'.$linkapiemblema.''.$codemblema.'110" alt="Emblema"  style="padding-left: 10px;">
																	<img class="media-object card-list-img" draggable="false" src="'.$linkapiemblema.''.$codemblema.'120" alt="Emblema"  style="padding-left: 10px;">
																	<img class="media-object card-list-img" draggable="false" src="'.$linkapiemblema.''.$codemblema.'130" alt="Emblema"  style="padding-left: 10px;">
																	<img class="media-object card-list-img" draggable="false" src="'.$linkapiemblema.''.$codemblema.'140" alt="Emblema"  style="padding-left: 10px;">
																	<img class="media-object card-list-img" draggable="false" src="'.$linkapiemblema.''.$codemblema.'150" alt="Emblema"  style="padding-left: 10px;">
																	<img class="media-object card-list-img" draggable="false" src="'.$linkapiemblema.''.$codemblema.'160" alt="Emblema"  style="padding-left: 10px;">
																	<img class="media-object card-list-img" draggable="false" src="'.$linkapiemblema.''.$codemblema.'170" alt="Emblema"  style="padding-left: 10px;">
																	<img class="media-object card-list-img" draggable="false" src="'.$linkapiemblema.''.$codemblema.'180" alt="Emblema"  style="padding-left: 10px;">
																	<img class="media-object card-list-img" draggable="false" src="'.$linkapiemblema.''.$codemblema.'190" alt="Emblema"  style="padding-left: 10px;">
																	<img class="media-object card-list-img" draggable="false" src="'.$linkapiemblema.''.$codemblema.'200" alt="Emblema"  style="padding-left: 10px;">
																	'; echo '</div><form method="POST"><input type="hidden" name="cod" value="'.$codemblema.'"><input type="hidden" name="limite" value="'.$quantidade.'"><button name="aplicar" type="submit" class="btn btn-primary" style="border-radius: 8px;">Aplicar</button></form>
																	</div>
																	</div>
																	</div>
																	</li> <!--- ---->';
																}
																?> 
																
															</ul>
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
			</div>
		</div>
	</div>
	<script type="text/javascript" src="galaxyservers/bower_components/jquery/js/jquery.min.js"></script>
	<script type="text/javascript" src="galaxyservers/bower_components/jquery-ui/js/jquery-ui.min.js"></script>
	<script type="text/javascript" src="galaxyservers/bower_components/popper.js/js/popper.min.js"></script>
	<script type="text/javascript" src="galaxyservers/bower_components/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="galaxyservers/bower_components/jquery-slimscroll/js/jquery.slimscroll.js"></script>
	<script type="text/javascript" src="galaxyservers/bower_components/modernizr/js/modernizr.js"></script>
	<script src="galaxyservers/assets/pages/widget/amchart/amcharts.min.js"></script>
	<script src="galaxyservers/assets/pages/widget/amchart/serial.min.js"></script>
	<script type="text/javascript" src="galaxyservers/bower_components/chart.js/js/Chart.js"></script>
	<script type="text/javascript" src="galaxyservers/assets/pages/todo/todo.js"></script>
	<script type="text/javascript" src="galaxyservers/assets/js/script.js"></script>
	<script type="text/javascript" src="galaxyservers/assets/js/bootstrap-growl.min.js"></script>
	<script type="text/javascript" src="galaxyservers/bower_components/i18next/js/i18next.min.js"></script>
	<script type="text/javascript" src="galaxyservers/bower_components/i18next-xhr-backend/js/i18nextXHRBackend.min.js"></script>
	<script type="text/javascript" src="galaxyservers/bower_components/i18next-browser-languagedetector/js/i18nextBrowserLanguageDetector.min.js"></script>
	<script type="text/javascript" src="galaxyservers/bower_components/jquery-i18next/js/jquery-i18next.min.js"></script>
	<script type="text/javascript" src="galaxyservers/assets/pages/notification/notification.js"></script>
	<script type="text/javascript" src="galaxyservers/assets/pages/dashboard/custom-dashboard.min.js"></script>
	<script type="text/javascript" src="galaxyservers/assets/js/SmoothScroll.js"></script>
	<script src="galaxyservers/assets/js/pcoded.min.js"></script>
	<script src="galaxyservers/assets/js/demo-12.js"></script>
	<script src="galaxyservers/assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
	<script type="text/javascript" src="galaxyservers/assets/js/script.min.js"></script>
</body>
</html>
		</html><?php } else header('Location: ../index'); ?>