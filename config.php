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
									<h4 class="sub-title">Altere as configurações avançadas do hotel.</h4>
									<form method="POST" enctype="multipart/form-data">	

										<?php

												if(!permissao("config")){
													echo '<div style="display: contents;">
													<div class="col-md-12">
													<center><div class="alert alert-danger background-danger" style="width: 30%;">
													<strong>Erro!</strong> Sua subconta não tem permissão para acessar essa página.
													</div></center>
													</div>
													</div>';
												} else {

										if(isset($_POST['salvar-config'])){

											$nomehotel = $_POST['nomehotel'];
											$nomehotel = str_replace(" hotel", "", $nomehotel);
											$nomehotel = str_replace("hotel", "", $nomehotel);
											$nomehotel = str_replace(" Hotel", "", $nomehotel);
											$nomehotel = str_replace("Hotel", "", $nomehotel);
											$nomemoedas = utf8_encode($_POST['creditos']);
											$nomeduckets = utf8_encode($_POST['duckets']);
											$nomediamantes = utf8_encode($_POST['diamantes']);
											$nomegotw = utf8_encode($_POST['gotw']);
											$emblemacabecastaff = $_POST['emblemacabecastaff'];
											$emblemacabecaemb = $_POST['emblemacabecaemb'];
											$quartovip = $_POST['quartovip'];
											$quartoprisao = $_POST['quartoprisao'];
											$premioporatividade = $_POST['premioporatividade'];
											$tempoon = $_POST['tempoon'];
											$nivelmax = $_POST['nivelmax'];
											$emblemapremiar = $_POST['emblemapremiar'];
											$rankemb = $_POST['rankemb'];
											$premiodiario = $_POST['premiodiario'];
											$reiniciargalaxy = $_POST['reiniciargalaxy'];
											$imagembv = $_POST['imagembv'];
											$RespeitosUsers = $_POST['RespeitosUsers'];
											$RespeitosStaffs = $_POST['RespeitosStaffs'];


$AtualizaNaDB = $PDO->prepare("UPDATE `config_servidores` SET `nomehotel`= :nomehotel, `nomemoedas`= :nomemoedas, `nomeduckets`= :nomeduckets, `nomediamantes`= :nomediamantes, `nomegotw`= :nomegotw, `emblemacabecastaff`= :embstaff, `emblemacabecaemb`= :embemb, `quartovip`= :qv, `quartoprisao`= :qp, `premioporatividade`=:premioativ, `tempoon`= :tempoon, `nivelmax`=:nvmax, emblemapremiar = :emblemapremiar, `rankbalaoemb`= :rankemb, `premiodiario`= :premiodiario, `reiniciargalaxy`= :reiniciagalaxy, `rankminimoferramentaemb`= :rankemb , `imagem_bv`= :imagembv, RespeitosUsers=:RespeitosUsers, RespeitosStaffs = :RespeitosStaffs   WHERE  `servidor`= :id;");
$AtualizaNaDB->bindParam(":nomehotel", $nomehotel);
$AtualizaNaDB->bindParam(":nomemoedas", $nomemoedas);
$AtualizaNaDB->bindParam(":nomeduckets", $nomeduckets);
$AtualizaNaDB->bindParam(":nomediamantes", $nomediamantes);
$AtualizaNaDB->bindParam(":nomegotw", $nomegotw);
$AtualizaNaDB->bindParam(":embstaff", $emblemacabecastaff);
$AtualizaNaDB->bindParam(":embemb", $emblemacabecaemb);
$AtualizaNaDB->bindParam(":qv", $quartovip);
$AtualizaNaDB->bindParam(":qp", $quartoprisao);
$AtualizaNaDB->bindParam(":premioativ", $premioporatividade);
$AtualizaNaDB->bindParam(":tempoon", $tempoon);
$AtualizaNaDB->bindParam(":nvmax", $nivelmax);
$AtualizaNaDB->bindParam(":rankemb", $rankemb);
$AtualizaNaDB->bindParam(":premiodiario", $premiodiario);
$AtualizaNaDB->bindParam(":reiniciagalaxy", $reiniciargalaxy);
$AtualizaNaDB->bindParam(":emblemapremiar", $emblemapremiar);
$AtualizaNaDB->bindParam(":imagembv", $imagembv);
$AtualizaNaDB->bindParam(":RespeitosUsers", $RespeitosUsers);
$AtualizaNaDB->bindParam(":RespeitosStaffs", $RespeitosStaffs);
$AtualizaNaDB->bindParam(":id", $server['id']);
$AtualizaNaDB->execute();

$AtualizaNaDB2 = $PDO->prepare("UPDATE `servidores` SET `nomehotel`= :nomehotel WHERE  `id`= :id;");
$AtualizaNaDB2->bindParam(":nomehotel", $nomehotel);
$AtualizaNaDB2->bindParam(":id", $server['id']);
$AtualizaNaDB2->execute();

$configemuPHB = "## Nome dos pontos (GOTW)
coin.points.name=".utf8_decode($nomegotw)."
### Nome moedas
coin.credits.name=".utf8_decode($nomemoedas)."
### Nome duckets
coin.duckets.name=".utf8_decode($nomeduckets)."
### Nome diamantes
coin.diamonds.name=".utf8_decode($nomediamantes)."

## Staffs
staff.effect.inroom=false
staff.mensg.inroom=false

## Camera (cuidado ao mexer nos links)
camera.enable=true
camera.api.http=".$server['http']."://".str_replace("http://", "", str_replace("https://", "", $server['linkhotel']))."/camera/
camera.output.pictures=".$server['http']."://".str_replace("http://", "", str_replace("https://", "", $server['linkhotel']))."/camera/pictures/
camera.picture.purchase.alert.id=false
camera.photo.publish.price.duckets=10
camera.photo.purchase.item_id=1100001495
camera.photo.purchase.price.coins=00
camera.photo.purchase.price.duckets=10
camera.preview.maxcache=1000

## Rank mínimo para ter acesso a ferramente de embaixador
ambassador.minrank=".$rankemb."

## Emblema staff sobre a cabeça
emblemacabeca.staff=".$emblemacabecastaff."
emblemacabeca.embaixador=".$emblemacabecaemb."

## Configuração dos Quartos
Quartovip=".$quartovip."
Prisao=".$quartoprisao."

## Premio por atividade
PremioPorAtividade=".$premioporatividade."
MensagemAoReceber=true
Intervalo=".$tempoon."

# Comando Premiar
NiveltotalGames=".$nivelmax."
CodEmblemaNivel=".$emblemapremiar."

### Nick de quem pode usar o comando reiniciar
ReiniciarPermissao=".$reiniciargalaxy."

## Rank que vai aparecer balão embaixador
RankEmbaixador=".$rankemb."

### Premiação diária
PremiacaoDiaria=".$premiodiario."

ImagemBemVindo=".$imagembv."

RespeitosUsers=".$RespeitosUsers."
RespeitosStaffs=".$RespeitosStaffs."
";
$arquivo = "galaxyservers/emuladores/".$server['uservestacp']."/Config/extras.ini";
$fp = fopen($arquivo, "w");
$escreve = fwrite($fp, $configemuPHB);
fclose($fp);


$PrincipalConfig = "### Arquivo de configuração do Galaxy Server!
### Emulador programado por PHB.

## Configuração MYSQL
db.hostname=".$iphospedagem."
db.port=3306
db.username=".$server['uservestacp']."_hotel
db.password=".$server['senhavestacp']."
db.name=".$server['uservestacp']."_hotel

## MySQL pooling setup (controla a quantidade de conexões)
db.pool.minsize=10
db.pool.maxsize=250

## Game TCP/IP Configuração
game.tcp.bindip=".$ipvps."
game.tcp.port=".$server['portatcp']."
game.tcp.conlimit=100000
game.tcp.conperip=3
game.tcp.enablenagles=true

## MUS TCP/IP Configuração
mus.tcp.bindip=".$ipvps."
mus.tcp.port=".$server['portamus']."
mus.tcp.allowedaddr=".$ipvps."

## Client Configuração
client.ping.enabled=1
client.ping.interval=3
client.maxrequests=300

## Configuração do Nome do seu hotel
hotel.name=".$nomehotel."
license=".$nomehotel." Hotel
game.legacy.figure_mutant=1

# Rank Mánimo de Staff
MineRankStaff=7

## Hall da Fama na client (0 = não / 1 = sim)
halldafama=0

## Tipo (1 = gotw/ 2 =diamantes/ 3 = duckets/ 4 =moedas)
tipohall=2";

$CaminhoConfig = "galaxyservers/emuladores/".$server['uservestacp']."/Config/config.ini";
$fp = fopen($CaminhoConfig, "w");
$escreve = fwrite($fp, $PrincipalConfig);
fclose($fp);

addlog('Editou as configurações.');

sendRCONCommand2('reload_extras', '', $ipvps, $server['portamus']);

loginsucess("Alterações salvas com sucesso!");

$infoserver = $PDO->prepare("SELECT * FROM servidores WHERE nomeusuario = '".$_SESSION['nomeusuario']."'");
$infoserver->execute();
$server = $infoserver->fetch();
								
										}

										$PegaEstadoAtual = $PDO->prepare("SELECT * FROM config_servidores WHERE servidor = '".$server['id']."' LIMIT 1;");
										$PegaEstadoAtual->execute();
										$EstadoAtual = $PegaEstadoAtual->fetch();

										?>
										<div class="row">
											<label class="col-sm-4 col-lg-2 col-form-label">Nome Hotel</label>
											<div class="col-sm-8 col-lg-10">
												<div class="input-group">		
													<input type="text" value="<?php echo $server['nomehotel'];?>" name="nomehotel" class="form-control" placeholder="Nome do hotel sem hotel, EX: Habbo" required>
												</div>
											</div>
										</div>
										<div class="row">
											<label class="col-sm-4 col-lg-2 col-form-label">Nome Moedas</label>
											<div class="col-sm-8 col-lg-10">
												<div class="input-group">		
													<input type="text" value="<?php echo utf8_decode($EstadoAtual['nomemoedas']);?>" name="creditos" class="form-control" placeholder="Moedas" required>
												</div>
											</div>
										</div>
										<div class="row">
											<label class="col-sm-4 col-lg-2 col-form-label">Nome Duckets</label>
											<div class="col-sm-8 col-lg-10">
												<div class="input-group">		
													<input type="text" value="<?php echo utf8_decode($EstadoAtual['nomeduckets']);?>" name="duckets" class="form-control" placeholder="Duckets" required>
												</div>
											</div>
										</div>
										<div class="row">
											<label class="col-sm-4 col-lg-2 col-form-label">Nome Diamantes</label>
											<div class="col-sm-8 col-lg-10">
												<div class="input-group">
													<input type="text" value="<?php echo utf8_decode($EstadoAtual['nomediamantes']);?>" name="diamantes" class="form-control" placeholder="Diamantes" required>
												</div>
											</div>
										</div>
										<div class="row">
											<label class="col-sm-4 col-lg-2 col-form-label">Nome GOTW</label>
											<div class="col-sm-8 col-lg-10">
												<div class="input-group">
													<input type="text" name="gotw" value="<?php echo utf8_decode($EstadoAtual['nomegotw']);?>" class="form-control" placeholder="GOTW Points" required>
												</div>
											</div>
										</div>
										<div class="row">
											<label class="col-sm-4 col-lg-2 col-form-label">Emblema sobre a cabeça de staff</label>
											<div class="col-sm-8 col-lg-10">
												<div class="input-group">
													<select name="emblemacabecastaff" required class="form-control">
														<option <?php if($EstadoAtual['emblemacabecastaff'] == 'false') echo 'selected';?> value="false">Não</option>
														<option <?php if($EstadoAtual['emblemacabecastaff'] == 'true') echo 'selected';?> value="true">Sim</option>
													</select>
												</div>
											</div>
										</div>
										<div class="row">
											<label class="col-sm-4 col-lg-2 col-form-label">Emblema sobre a cabeça de EMB</label>
											<div class="col-sm-8 col-lg-10">
												<div class="input-group">
													<select name="emblemacabecaemb" required class="form-control">
														<option <?php if($EstadoAtual['emblemacabecaemb'] == 'false') echo 'selected';?> value="false">Não</option>
														<option <?php if($EstadoAtual['emblemacabecaemb'] == 'true') echo 'selected';?> value="true">Sim</option>
													</select>
												</div>
											</div>
										</div>
										<div class="row">
											<label class="col-sm-4 col-lg-2 col-form-label">ID Quarto VIP</label>
											<div class="col-sm-8 col-lg-10">
												<div class="input-group">
													<input type="text" name="quartovip" placeholder="Um quarto que só usuários VIP's podem entrar" value="<?php echo utf8_decode($EstadoAtual['quartovip']);?>" class="form-control" required>
												</div>
											</div>
										</div>
										<div class="row">
											<label class="col-sm-4 col-lg-2 col-form-label">ID Quarto Prisão</label>
											<div class="col-sm-8 col-lg-10">
												<div class="input-group">
													<input type="text" name="quartoprisao" value="<?php echo utf8_decode($EstadoAtual['quartoprisao']);?>" class="form-control" placeholder="Quarto que será levado ao ser preso usando o comando :prender" required>
												</div>
											</div>
										</div>
										<div class="row">
											<label class="col-sm-4 col-lg-2 col-form-label">Premio tempo on</label>
											<div class="col-sm-8 col-lg-10">
												<div class="input-group">
													<select name="premioporatividade" required class="form-control">
														<option <?php if($EstadoAtual['premioporatividade'] == 'true') echo 'selected';?> value="true">Sim</option>
														<option <?php if($EstadoAtual['premioporatividade'] == 'false') echo 'selected';?> value="false">Não</option>
													</select>
												</div>
											</div>
										</div>
										<div class="row">
											<label class="col-sm-4 col-lg-2 col-form-label">Intervalo em minutos.</label>
											<div class="col-sm-8 col-lg-10">
												<div class="input-group">
													<input type="text" name="tempoon" value="<?php echo utf8_decode($EstadoAtual['tempoon']);?>" class="form-control" placeholder="Ex: 30" required>
												</div>
											</div>
										</div>
										<div class="row">
											<label class="col-sm-4 col-lg-2 col-form-label">Nível máximo.</label>
											<div class="col-sm-8 col-lg-10">
												<div class="input-group">
													<input type="text" name="nivelmax" value="<?php echo utf8_decode($EstadoAtual['nivelmax']);?>" class="form-control" placeholder="Nível máximo que um usuário pode chegar." required>
												</div>
											</div>
										</div>
										<div class="row">
											<label class="col-sm-4 col-lg-2 col-form-label">Emblema Premiar.</label>
											<div class="col-sm-8 col-lg-10">
												<div class="input-group">
													<input type="text" name="emblemapremiar" value="<?php echo utf8_decode($EstadoAtual['emblemapremiar']);?>" class="form-control" placeholder="Prefixo inicial da sequencia de emblemas do premiar." required>
												</div>
											</div>
										</div>
										<div class="row">
											<label class="col-sm-4 col-lg-2 col-form-label">Rank mínimo embaixador.</label>
											<div class="col-sm-8 col-lg-10">
												<div class="input-group">
													<select name="rankemb" class="form-control">
														<?php
														try{
															$PDO2 = new PDO('mysql:host='.$iphospedagem.';dbname='.$server['uservestacp']."_hotel", $server['uservestacp']."_hotel", $server['senhavestacp']);
														} catch(PDOException $e){
															echo('<script>alert("Erro ao conectar ao banco de dados do hotel, entre em contato com o suporte para a correção do problema! Informe a mensagem: "'.utf8_encode($e->getMessage()).'")</script>');

														}
														$getArtdicles = $PDO2->prepare("SELECT * FROM ranks ORDER BY id");
														$getArtdicles->execute();
														while($dnews = $getArtdicles->fetch())
														{
															?>
															<option <?php if($EstadoAtual['rankbalaoemb'] == $dnews['id']) echo 'selected';?>  value="<?php echo $dnews['id']?>"><?php echo utf8_encode($dnews['name'])?> (<?php echo $dnews['id']?>)</option>
														<?php } ?>
													</select>	
												</div>
											</div>
										</div>
										<div class="row">
											<label class="col-sm-4 col-lg-2 col-form-label">Prêmio diário</label>
											<div class="col-sm-8 col-lg-10">
												<div class="input-group">
													<select name="premiodiario" required class="form-control">										
														<option <?php if($EstadoAtual['premiodiario'] == 'false') echo 'selected';?> value="false">Não</option>
														<option <?php if($EstadoAtual['premiodiario'] == 'true') echo 'selected';?> value="true">Sim</option>
													</select>
												</div>
											</div>
										</div>
										<div class="row">
											<label class="col-sm-4 col-lg-2 col-form-label">Permissão Comando Reiniciar.</label>
											<div class="col-sm-8 col-lg-10">
												<div class="input-group">
													<input type="text" name="reiniciargalaxy" value="<?php echo utf8_decode($EstadoAtual['reiniciargalaxy']);?>" class="form-control" placeholder="Usuário que pode usar o comando :reiniciargalaxy." required>
												</div>
											</div>
										</div>
											<div class="row">
											<label class="col-sm-4 col-lg-2 col-form-label">Imagem bem vindo</label>
											<div class="col-sm-8 col-lg-10">
												<div class="input-group">
													<input type="text" name="imagembv" value="<?php echo utf8_decode($EstadoAtual['imagem_bv']);?>" class="form-control" placeholder="Imagem exibida ao entrar no hotel, hospedada no beeimg.">
												</div>
											</div>
										</div>
										<div class="row">
											<label class="col-sm-4 col-lg-2 col-form-label">Respeitos usuários</label>
											<div class="col-sm-8 col-lg-10">
												<div class="input-group">
													<input type="number" name="RespeitosUsers" value="<?= $EstadoAtual['RespeitosUsers'];?>" class="form-control" placeholder="Quantidade de respeitos diários que usuários poderão dar." required>
												</div>
											</div>
										</div>
										<div class="row">
											<label class="col-sm-4 col-lg-2 col-form-label">Respeitos staffs</label>
											<div class="col-sm-8 col-lg-10">
												<div class="input-group">
													<input type="number" name="RespeitosStaffs" value="<?= $EstadoAtual['RespeitosStaffs'];?>" class="form-control" placeholder="Quantidade de respeitos diários que staffs poderão dar." required>
												</div>
											</div>
										</div>
									</div>
									<center><button type="submit" style="border-radius: 8px;" name="salvar-config" class="btn btn-primary m-b-0">Salvar</button></center>
								</form>
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