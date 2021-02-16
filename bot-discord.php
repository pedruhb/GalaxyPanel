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
									if($server['botdiscord'] == "desativado"){
										if($server['plano'] == "6"){

										/// ativa o bot se for plano 6

											function copiaDir($dirFont, $dirDest){

												if(!file_exists($dirDest)){
													mkdir($dirDest);
												}
												if ($dd = opendir($dirFont)) {
													while (false !== ($arq = readdir($dd))) {
														if($arq != "." && $arq != ".."){
															$pathIn = "$dirFont/$arq";
															$pathOut = "$dirDest/$arq";
															if(is_dir($pathIn)){
																copiaDir($pathIn, $pathOut);
															}elseif(is_file($pathIn)){
																copy($pathIn, $pathOut);
															}
														}
													}
													closedir($dd);
												}
											}

                   $pasta = "galaxyservers/emuladores/sourcebot/"; //Pasta source
                   $pastad = "galaxyservers/emuladores/".$server['uservestacp']."/bot_discord/"; //pasta destino
                   $path_completo = "c:/xampp/htdocs/galaxyservers/emuladores/".$server['uservestacp']."/bot_discord/";
                   
                   copiaDir($pasta, $pastad);

                   $configuracao = '{ 
                   	"token"  : "SEU TOKEN AQUI",
                   	"prefix" : ";",
                   	"nomehotel" : "'.$server['nomehotel'].'",
                   	"linkhotel_news" : "'.$server['http'].'://'.$server['linkhotel'].'/news/",
                   	"linkhotel" : "'.$server['linkhotel'].'",

                   	"mensagensentradaesaida" : "desativado",
                   	"idcanalbemvindos" : "0",
                   	"idcanaladeus" : "0",

                   	"verificacao" : "desativado", 
                   	"idcanalverificacao" : "0",
                   	"nomecargoverificados" : "NOME DO CARGO DE VERIFICADOS AQUI",

                   	"hostmysql" : "'.$iphospedagem.'",
                   	"usermysql" : "'.$server['uservestacp'].'_hotel",
                   	"dbmysql" : "'.$server['uservestacp'].'_hotel",
                   	"passmysql" : "'.$server['senhavestacp'].'",

                   	"versao" : "1.0",
                   	"icone_embed" : "https://i.imgur.com/6Z848W8.png",
                   	"linkdiscord" : "LINK DE CONVITE DO SERVIDOR",
                   	"corembed" : "7419530",

                   	"status_canal" : "desligado",
                   	"canal_usersregistrados" : "0",
                   	"canal_userson" : "0",
                   	"canal_userNoServidor" : "0",

                   	"imagem_ship": "https://i.imgur.com/ZWTnaX6.jpg",
                   	"proibirlinks": "ativado"
                   }';
                   $fp = fopen($pastad."config.json", "w");
                   $escreve = fwrite($fp, $configuracao);
                   fclose($fp);

                   $desligar = 'cd '.$path_completo.' && forever stop index.js';
                   $fp = fopen($pastad."desligar.bat", "w");
                   $escreve = fwrite($fp, $desligar);
                   fclose($fp);

                   $ligar = "title ".$server['uservestacp']." BOT
                   cd ".$path_completo." && forever index.js";
                   $fp = fopen($pastad."ligar.bat", "w");
                   $escreve = fwrite($fp, $ligar);
                   fclose($fp);

                   $ligar = "title ".$server['uservestacp']." BOT
                   cd ".$path_completo." && start ligabot.exe";
                   $fp = fopen($pastad."iniciar.bat", "w");
                   $escreve = fwrite($fp, $ligar);
                   fclose($fp);

                   $attStatus = $PDO->prepare("UPDATE servidores SET botdiscord = 'desligado' WHERE id = '".$server['id']."';");
                   $attStatus->execute();

                   echo '	<h4 class="sub-title">Gerencie seu BOT</h4><div style="display: contents;">
                   <div class="col-md-12">
                   <center><div class="alert alert-success background-success" style="width: 30%;">
                   <strong>Sucesso!</strong> Seu BOT acaba de ser instalado pelo sistema, para aprender a configurar, clique <a style="color:white" target="_blank" href="https://cliente.galaxyservers.com.br/index.php?rp=/knowledgebase/2/Como-configurar-o-bot-para-discord.html">aqui</a>. Atualize a página para ter acesso as funções.
                   </div></center>
                   </div>
                   </div>';

               } else {
               	echo '	<h4 class="sub-title">Gerencie seu BOT</h4><div style="display: contents;">
               	<div class="col-md-12">
               	<center><div class="alert alert-danger background-danger" style="width: 30%;">
               	<strong>Erro!</strong> Você deve realizar a compra do bot clicando <a style="color:white" target="_blank" href="https://cliente.galaxyservers.com.br/cart.php?gid=addons">aqui</a> para utilizar.
               	<br>
               	Caso você já tenha realizado a compra, entre em contato com o suporte solicitando a ativação.
               	</div></center>
               	</div>
               	</div>';
               }
           } 
           else if(!permissao("botdiscord")){
           	echo '<div style="display: contents;">
           	<div class="col-md-12">
           	<center><div class="alert alert-danger background-danger" style="width: 30%;">
           	<strong>Erro!</strong> Sua subconta não tem permissão para acessar essa página.
           	</div></center>
           	</div>
           	</div>';
           } else {
           	?>
           	<h4 class="sub-title">Gerencie seu BOT</h4>
           	<?php
           	if(isset($_POST['ligar'])){

           		if($server['botdiscord'] == "ligado"){

           			echo '<div style="display: contents;">
           			<div class="col-md-12">
           			<center><div class="alert alert-danger background-danger" style="width: 50%;">
           			<strong>Erro!</strong> O bot já está ligado!
           			</div></center>
           			</div>
           			</div>';

           		} else {

           			popen("C:/xampp/htdocs/galaxyservers/emuladores/".$server['uservestacp']."/bot_discord/iniciar.bat", "r");

           			$attStatus = $PDO->prepare("UPDATE servidores SET botdiscord = 'ligado' WHERE id = '".$server['id']."';");
           			$attStatus->execute();

           			echo '<div style="display: contents;">
           			<div class="col-md-12">
           			<center><div class="alert alert-success background-success" style="width: 50%;">
           			<strong>Successo!</strong> Bot ligado com sucesso!
           			</div></center>
           			</div>
           			</div>';

           		}
           	} else if(isset($_POST['desligar'])){

           		if($server['botdiscord'] == "desligado"){
           			echo '<div style="display: contents;">
           			<div class="col-md-12">
           			<center><div class="alert alert-danger background-danger" style="width: 50%;">
           			<strong>Erro!</strong> O bot já está desligado!
           			</div></center>
           			</div>
           			</div>';
           		} else {
           			popen("C:/xampp/htdocs/galaxyservers/emuladores/".$server['uservestacp']."/bot_discord/desligar.bat", "r");

           			$attStatus = $PDO->prepare("UPDATE servidores SET botdiscord = 'desligado' WHERE id = '".$server['id']."';");
           			$attStatus->execute();

           			echo '<div style="display: contents;">
           			<div class="col-md-12">
           			<center><div class="alert alert-success background-success" style="width: 50%;">
           			<strong>Successo!</strong> Bot desligado com sucesso!
           			</div></center>
           			</div>
           			</div>';
           		}
           	}
           	?>
           	<form method="POST" style="display: contents;">
           		<div class="col-md-12">
           			<center>
           				<h4>O bot está <?= $server['botdiscord'];?></h4>
           				<br>
           				<button title="Ligar Bot" name="ligar" style="border-radius: 8px;" data-type="inverse" data-align="right" data-from="top" class="btn btn-success"><i class="icofont icofont-ui-play"></i>Ligar</button>
           				<button  title="Desligar Bot" type="submit" style="border-radius: 8px;" name="desligar" data-type="inverse" data-align="right" data-from="top" class="btn btn-danger" ><i class="icofont icofont-ui-power"></i>Desligar</button>
           			</div>
           		</form>
           	</div>
           </div>
       </div>
       <div class="card">
       	<div class="card-block">
       		<div class="m-b-20">
       			<h4 class="sub-title">Altere as configurações do bot do discord.</h4>
       			<form method="POST" enctype="multipart/form-data">	
       				<?php
       				error_reporting(0);
       				$caminho_config = "./galaxyservers/emuladores/".$server['uservestacp']."/bot_discord/config.json";
       				if(isset($_POST['salvar-config'])){
       					$token = $_POST['token'];
       					$prefixo = $_POST['prefixo'];
       					$imagem_ship = $_POST['imagem_ship'];
       					$iconembed = $_POST['iconembed'];
       					$linkconvite = $_POST['linkconvite'];
       					$verificacao_conta = $_POST['verificacao_conta'];
       					$id_verificacao = $_POST['id_verificacao'];
       					$cargo_verificados = $_POST['cargo_verificados'];
       					$mensagems_welcome = $_POST['mensagems_welcome'];
       					$id_canal_bemvindo = $_POST['id_canal_bemvindo'];
       					$id_canal_adeus = $_POST['id_canal_adeus'];
       					$server_status = $_POST['server_status'];
       					$id_canal_registrados = $_POST['id_canal_registrados'];
       					$id_canal_onlines = $_POST['id_canal_onlines'];
       					$id_canal_usersserver = $_POST['id_canal_usersserver'];
       					$proibir_links = $_POST['proibir_links'];
       					$configuracao = '{ 
       						"token"  : "'.$token.'",
       						"prefix" : "'.$prefixo.'",
       						"nomehotel" : "'.$server['nomehotel'].'",
       						"linkhotel_news" : "'.$server['http'].'://'.$server['linkhotel'].'/news",
       						"linkhotel" : "'.$server['linkhotel'].'",
       						"mensagensentradaesaida" : "'.$mensagems_welcome.'",
       						"idcanalbemvindos" : "'.$id_canal_bemvindo.'",
       						"idcanaladeus" : "'.$id_canal_adeus.'",
       						"verificacao" : "'.$verificacao_conta.'", 
       						"idcanalverificacao" : "'.$id_verificacao.'",
       						"nomecargoverificados" : "'.$cargo_verificados.'",
       						"hostmysql" : "'.$iphospedagem.'",
       						"usermysql" : "'.$server['uservestacp'].'_hotel",
       						"dbmysql" : "'.$server['uservestacp'].'_hotel",
       						"passmysql" : "'.$server['senhavestacp'].'",
       						"versao" : "1.0",
       						"icone_embed" : "'.$iconembed.'",
       						"linkdiscord" : "'.$linkconvite.'",
       						"corembed" : "7419530",
       						"status_canal" : "'.$server_status.'",
       						"canal_usersregistrados" : "'.$id_canal_registrados.'",
       						"canal_userson" : "'.$id_canal_onlines.'",
       						"canal_userNoServidor" : "'.$id_canal_usersserver.'",
       						"imagem_ship": "'.$imagem_ship.'",
       						"proibirlinks": "'.$proibir_links.'"
       					}';
       					$fp = fopen($caminho_config, "w");
       					$escreve = fwrite($fp, $configuracao);
       					fclose($fp);
       					loginsucess("Alterações realizadas, caso seu bot esteja ligado, desligue e ligue novamente ou use o comando ".$prefixo."reiniciar.");

                $infoserver = $PDO->prepare("SELECT * FROM servidores WHERE nomeusuario = '".$_SESSION['nomeusuario']."'");
                $infoserver->execute();
                $server = $infoserver->fetch();
                
       				}
       				$exibir = true;
       				$json = @file_get_contents($caminho_config);
       				$config = json_decode($json);
       				if(!$json){
       					$exibir = false;
       					loginerror("Seu bot não está ativo, por favor, solicite ativação com o suporte.");
       				}
       				if($exibir){
       					?>
       					<div class="row">
       						<label class="col-sm-4 col-lg-2 col-form-label">Discord TOKEN</label>
       						<div class="col-sm-8 col-lg-10">
       							<div class="input-group">		
       								<input type="text" value="<?= $config->{'token'};?>" name="token" class="form-control" placeholder="Token do seu bot" required>
       							</div>
       						</div>
       					</div>
       					<div class="row">
       						<label class="col-sm-4 col-lg-2 col-form-label">Prefixo</label>
       						<div class="col-sm-8 col-lg-10">
       							<div class="input-group">		
       								<input type="text" value="<?= $config->{'prefix'};?>" name="prefixo" class="form-control" placeholder="Prefixo para ativar o bot, exemplo: !,:,;" required>
       							</div>
       						</div>
       					</div>
       					<div class="row">
       						<label class="col-sm-4 col-lg-2 col-form-label">Imagem do ship</label>
       						<div class="col-sm-8 col-lg-10">
       							<div class="input-group">		
       								<input type="text" value="<?= $config->{'imagem_ship'};?>" name="imagem_ship" class="form-control" placeholder="Fundo da imagem do comando ship" required>
       							</div>
       						</div>
       					</div>
       					<div class="row">
       						<label class="col-sm-4 col-lg-2 col-form-label">Ícone dos embeds</label>
       						<div class="col-sm-8 col-lg-10">
       							<div class="input-group">
       								<input type="text" value="<?= $config->{'icone_embed'};?>" name="iconembed" class="form-control" placeholder="Ícone dos embeds" required>
       							</div>
       						</div>
       					</div>
       					<div class="row">
       						<label class="col-sm-4 col-lg-2 col-form-label">Link convite</label>
       						<div class="col-sm-8 col-lg-10">
       							<div class="input-group">
       								<input type="text" name="linkconvite" value="<?= $config->{'linkdiscord'};?>" class="form-control" placeholder="Link para convite de seu servidor" required>
       							</div>
       						</div>
       					</div>


       					<div class="row">
       						<label class="col-sm-4 col-lg-2 col-form-label">Verificação de conta</label>
       						<div class="col-sm-8 col-lg-10">
       							<div class="input-group">
       								<select name="verificacao_conta" required class="form-control">
       									<option <?php if($config->{'verificacao'} == 'desativado') echo 'selected';?> value="desativado">Não</option>
       									<option <?php if($config->{'verificacao'} == 'ativado') echo 'selected';?> value="ativado">Sim</option>
       								</select>
       							</div>
       						</div>
       					</div>


       					<div class="row">
       						<label class="col-sm-4 col-lg-2 col-form-label">Proibir links?</label>
       						<div class="col-sm-8 col-lg-10">
       							<div class="input-group">
       								<select name="proibir_links" required class="form-control">
       									<option <?php if($config->{'proibirlinks'} == 'desativado') echo 'selected';?> value="desativado">Não</option>
       									<option <?php if($config->{'proibirlinks'} == 'ativado') echo 'selected';?> value="ativado">Sim</option>
       								</select>
       							</div>
       						</div>
       					</div>

       					<div class="row">
       						<label class="col-sm-4 col-lg-2 col-form-label">ID Canal de Verificação</label>
       						<div class="col-sm-8 col-lg-10">
       							<div class="input-group">
       								<input type="number" name="id_verificacao" placeholder="ID do canal que será enviado as keys de ativação" value="<?= $config->{'idcanalverificacao'};?>" class="form-control" required>
       							</div>
       						</div>
       					</div>

       					<div class="row">
       						<label class="col-sm-4 col-lg-2 col-form-label">Nome do cargo de verificados</label>
       						<div class="col-sm-8 col-lg-10">
       							<div class="input-group">
       								<input type="text" name="cargo_verificados" placeholder="Nome do cargo que será dado ao usuário verificado" value="<?= $config->{'nomecargoverificados'};?>" class="form-control" required>
       							</div>
       						</div>
       					</div>

       					<div class="row">
       						<label class="col-sm-4 col-lg-2 col-form-label">Mensagem entrada/saida</label>
       						<div class="col-sm-8 col-lg-10">
       							<div class="input-group">
       								<select name="mensagems_welcome" required class="form-control">
       									<option <?php if($config->{'mensagensentradaesaida'} == 'desativado') echo 'selected';?> value="desativado">Não</option>
       									<option <?php if($config->{'mensagensentradaesaida'} == 'ativado') echo 'selected';?> value="ativado">Sim</option>
       								</select>
       							</div>
       						</div>
       					</div>
       					<div class="row">
       						<label class="col-sm-4 col-lg-2 col-form-label">ID Canal de Bem-Vindo</label>
       						<div class="col-sm-8 col-lg-10">
       							<div class="input-group">
       								<input type="number" name="id_canal_bemvindo" placeholder="ID do canal que será enviado bem vindo a quem chegar" value="<?= $config->{'idcanalbemvindos'};?>" class="form-control">
       							</div>
       						</div>
       					</div>
       					<div class="row">
       						<label class="col-sm-4 col-lg-2 col-form-label">ID Canal de Adeus</label>
       						<div class="col-sm-8 col-lg-10">
       							<div class="input-group">
       								<input type="number" name="id_canal_adeus" placeholder="ID do canal que será enviado adeus a quem sair" value="<?= $config->{'idcanaladeus'};?>" class="form-control">
       							</div>
       						</div>
       					</div>


       					<div class="row">
       						<label class="col-sm-4 col-lg-2 col-form-label">Server Status</label>
       						<div class="col-sm-8 col-lg-10">
       							<div class="input-group">
       								<select name="server_status" required class="form-control">
       									<option <?php if($config->{'status_canal'} == 'desativado') echo 'selected';?> value="desativado">Não</option>
       									<option <?php if($config->{'status_canal'} == 'ativado') echo 'selected';?> value="ativado">Sim</option>
       								</select>
       							</div>
       						</div>
       					</div>
       					<div class="row">
       						<label class="col-sm-4 col-lg-2 col-form-label">ID Canal Registrados</label>
       						<div class="col-sm-8 col-lg-10">
       							<div class="input-group">
       								<input type="number" name="id_canal_registrados" placeholder="ID do canal que será renomeado" value="<?= $config->{'canal_usersregistrados'};?>" class="form-control">
       							</div>
       						</div>
       					</div>
       					<div class="row">
       						<label class="col-sm-4 col-lg-2 col-form-label">ID Canal Onlines</label>
       						<div class="col-sm-8 col-lg-10">
       							<div class="input-group">
       								<input type="number" name="id_canal_onlines" placeholder="ID do canal que será renomeado" value="<?= $config->{'canal_userson'};?>" class="form-control">
       							</div>
       						</div>
       					</div>
       					<div class="row">
       						<label class="col-sm-4 col-lg-2 col-form-label">ID Canal Users no servidor</label>
       						<div class="col-sm-8 col-lg-10">
       							<div class="input-group">
       								<input type="number" name="id_canal_usersserver" placeholder="ID do canal que será renomeado" value="<?= $config->{'canal_userNoServidor'};?>" class="form-control">
       							</div>
       						</div>
       					</div>

       				</div>
       				<center><button type="submit" style="border-radius: 8px;" name="salvar-config" class="btn btn-primary m-b-0">Salvar</button></center>
       			</form>
       		<?php } }?>
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